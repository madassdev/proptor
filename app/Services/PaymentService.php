<?php

namespace App\Services;

use App\Exceptions\ClientErrorException;
use App\Exceptions\PaymentFailedException;
use App\Exceptions\PaystackPaymentNotVerifiedException;
use App\FlutterwaveConfig;
use App\Payment;
use App\PaypalConfig;
use App\PaystackConfig;
use App\StripeConfig;
use GuzzleHttp\Client;
use Stripe\StripeClient;

use Throwable;

class PaymentService
{

    public static function processPayment($payment_method, $payment_reference)
    {
        switch ($payment_method) {
            case 'paystack':
                return self::verifyPaystack($payment_reference);
                break;
            
            
            case 'flutterwave':
                return self::verifyFlutterwave($payment_reference);
                break;
            
            
            case 'stripe':
                return self::stripeRetrieveIntent($payment_reference);
                break;
            
            
            case 'paypal':
                return self::verifyPaypal($payment_reference);
                break;
            
            
            default:
                # code...
                break;
        }
    }

    public static function getPaystackSecretKey()
    {
        return config('payment.paystack_sk');
        // $paystack_secret_key = "sk_test_a335450a82025ce1b4143aebfad5351966dd658b";
        // if(config()->get('env') == "live")
        // {
        //     // Get key from config variable.
        //     $paystack_secret_key = config()->get('payment.paystack_secret_key');
        // }
        // elseif(config()->get('env') == 'test')
        // {
        //     $paystack_secret_key = config()->get('payment.paystack_secret_key_test');
        // }
        // elseif(config()->get('client') == "store")
        // {
        //     // Get key from database.
        //     $paystack_config = PaystackConfig::latest()->first();
        //     if($paystack_config)
        //     {
        //         $paystack_secret_key = $paystack_config->secret_key;
        //     }
        //     else{
        //         throw new ClientErrorException("Paystack secret key not found, or it has not been set by Admin.", 400);
        //     }

        // }

        // return $paystack_secret_key;
    }

    public static function authChargePaystack($auth_details)
    {
        $paystack_secret_key = self::getPaystckSecretKey();
        $url = "https://api.paystack.co/transaction/charge_authorization";
        $fields = [
            'authorization_code' => "AUTH_l7ogr49xtu",
            'email' => "ucylvester@gmail.com",
            'amount' => "10000"
        ];
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $paystack_secret_key",
            "Cache-Control: no-cache",
        ));
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        
        //execute post
        $response = curl_exec($ch);
        // echo $result;
        if (!$response) {
            throw new PaystackPaymentNotVerifiedException("Unable to verify the transaction from paystack", 400);
        }

        $transaction = json_decode($response);
        
        if (!$transaction->status) {
            throw new PaystackPaymentNotVerifiedException("Payment could not be verifed. $response", 400);
        }

        if ($transaction->data->status != "success") {
            throw new PaystackPaymentNotVerifiedException("Paystack authorization payment failed. ", 400, 
            ['status'=>$transaction->data->status, 'gateway_response'=>$transaction->data->gateway_response]);
        }

        return $transaction;

    }

    public static function verifyPaystack($reference)
    {
        $paystack_secret_key = self::getPaystackSecretKey();
        
        // reference AmasT234Android_1582026397815
        //secret sk_test_a335450a82025ce1b4143aebfad5351966dd658b

        $url = 'https://api.paystack.co/transaction/verify/' . $reference;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                "Authorization: Bearer $paystack_secret_key"
            ]
        );

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new PaymentFailedException("Unable to verify the transaction from Paystack", 400);
        }

        $transaction = json_decode($response);

        if (!$transaction->status) {
            throw new PaymentFailedException("Payment could not be verifed. $response", 400);
        }


        $amount = $transaction->data->amount / 100;

        // "authorization": {
        //     "authorization_code": "AUTH_5oxi8pggl1",
        //     "bin": "408408",
        //     "last4": "4081",
        //     "exp_month": "11",
        //     "exp_year": "2022",
        //     "channel": "card",
        //     "card_type": "visa ",
        //     "bank": "TEST BANK",
        //     "country_code": "NG",
        //     "brand": "visa",
        //     "reusable": true,
        //     "signature": "SIG_2UU0kYwkOh9IDD5LJ8O7",
        //     "account_name": null
        // },
        return ['amount_paid'=>$amount, 'currency'=>$transaction->data->currency];
        return $transaction;
    }

    public static function validatePaystackKey($key)
    {
        $url = 'https://api.paystack.co/plan';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                "Authorization: Bearer $key"
            ]
        );

        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            throw new PaystackPaymentNotVerifiedException("Unable to get response from paystack", 400);
        }

        $response = json_decode($response);

        return $response;
    }

    // FLUTTERWAVE
    public static function getFlutterwaveSecretKey()
    {
        return config('payment.flutterwave_sk');
    }

    public static function verifyFlutterwave($reference)
    {
        // Secret FLWSECK_TEST-e7bf74cf358956ef1e286db58bd3f5cf-X
        //enc 4f5744364561aef72362a608
        //ref 1423869
        //public FLWPUBK_TEST-475613beb5156a9a5c288a7caced8dc7-X

        $flutterwave_keys = self::getFlutterwaveSecretKey();
        $user = auth()->guard('api')->user();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$reference/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                // "Authorization: Bearer $flutterwave_config->secret_key"
                "Authorization: Bearer $flutterwave_keys"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if (!$response) {
            throw new PaymentFailedException("Unable to verify the transaction from Flutterwave", 400);
        }

        $transaction = json_decode($response);

        if ($transaction->status != 'success') {
            throw new PaymentFailedException("Payment could not be verifed. $response", 400);
        }

        // if ($transaction->data->customer->email != $user->email) {
        //     throw new PaymentFailedException("Payment could not be verifed for user. $response", 400);
        // }

        // return $transaction;
        return ['amount_paid'=>$transaction->data->amount, 'currency'=>$transaction->data->currency];
    }

    public function store($p, $order, $amount_paid)
    {
        $user = auth()->guard('api')->user();
        
        $payment = new Payment;
        $payment->user_id =  $user->id;
        $payment->order_id =  $order->id;
        $payment->price_point =  $amount_paid;
        $payment->method = $p->method;
        $payment->reference = $p->reference;
        $payment->status = "success";
        $payment->save();
    }

    // STRIPE
    public static function stripeCreateIntent($data)
    {
        $secret_key = self::getStripeKey();
        $stripe = new StripeClient(
            $secret_key
          );
        try{
            $intent = $stripe->paymentIntents->create([
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'payment_method_types' => array_key_exists('payment_method_types', $data) ? $data['payment_method_types'] : ['card'],
                ]);
                
                return $intent;
        }
        catch(Throwable $e)
        {
            throw new ClientErrorException($e->getMessage(), 400, $e->getTrace());
        }
        
    }

    public static function stripeRetrieveIntent($intent_id)
    {
        $secret_key = self::getStripeKey();
        $stripe = new StripeClient(
            $secret_key
          );
        try{

            $intent = $stripe->paymentIntents->retrieve(
                $intent_id,
            );
            
            return ($intent);
        }

        catch(Throwable $e)
        {
            throw new ClientErrorException($e->getMessage(), 400, $e->getTrace());
        }
        
    }


    public static function getStripeKey()
    {
        $secret_key = "old_sk_test_Cq1kKC1ctoLfhcjjCDsM3ycO00MMOuLOZN";
        if(config()->get('env') == "live")
        {
            // Get key from config variable.
            $secret_key = config()->get('payment.stripe_secret_key');
        }
        elseif(config()->get('env') == 'test')
        {
            $secret_key = config()->get('payment.stripe_secret_key_test');
        }
        elseif(config()->get('client') == "store")
        {
            // Get key from database.
            $stripe_config = StripeConfig::latest()->first();
            if($stripe_config)
            {
                $secret_key = $stripe_config->secret_key;
            }
            else{
                throw new ClientErrorException("Stripe secret key not found, or it has not been set by Admin.", 400);
            }

        }

        return $secret_key;
    }

    // PAYPAL
    public static function verifyPaypal($transaction_id)
    {
        abort(501, 'Paypal implementation still in progress');
        $secret_key = "EFk4VAyPOO7HVS4Ow6CHapQ8G42OxW7Ix6UOGe4FpgJpdL-PH3fTSyCc3KTl323tO6yfND5pWaL8XhVd";
        $payment_id = "89K708651D9888622";
        $paypal_config = PaypalConfig::latest()->first();
        if($paypal_config)
        {
            $secret_key = $paypal_config->secret_key;
        }
        else{
            throw new ClientErrorException("Paystack secret key not found, or it has not been set by Admin.", 400);
        }

        return $transaction_id;


    }

    // public static function ()
    // {

    // }
}
