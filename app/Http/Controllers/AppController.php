<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentKeysRequest;
use App\Models\AppConfig;
use App\Models\FlutterwaveConfig;
use App\Models\PaypalConfig;
use App\Models\PaystackConfig;
use App\Models\StripeConfig;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppController extends Controller
{
    public function getDetails()
    {
        $details = AppConfig::all()->pluck(('config_value'), 'config_key')->toArray();
        return response()->json(['data'=>$details]);
    }

    public function saveDetails(Request $request)
    {
        foreach ($request->input() as $key => $value) {
            $config = AppConfig::whereConfigKey($key)->first();
            if ($config) {
                $config->config_value =  $value;
                $config->save();
            }
            // If the config does not exist at all, save a new one
            else{
                $save_new_config = AppConfig::updateOrCreate(["config_key"=>$key, "config_value" => $value]);
            }
        }

        $details = $this->getDetails();

        return response()->json(['data'=>$details]);
    }

    public function savePaymentKeys(PaymentKeysRequest $request)
    {
        $payment_methods = [];
        if ($request->has('paystack')) {
            $paystack_config = $request->paystack;

            $paystack_validation_rules = [
                "public_key" => "required|string",
                "secret_key" => "required|string",
            ];

            $paystack_validation_messages = [
                "required" => "The Paystack :attribute field is required"
            ];

            $validator = Validator::make($paystack_config, $paystack_validation_rules, $paystack_validation_messages);

            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }
            // $secretKeyValidation = PaymentService::validatePaystackKey($request->paystack['secret_key']);

            // if (!$secretKeyValidation->status) {
            //     // return response()->json('The Paystack secret key is invalid.', 422);
            // }

            $paystack_config = PaystackConfig::find(1);

            if ($paystack_config) {
                $paystack_config->update($request->paystack);
            } else {
                $paystack_config = PaystackConfig::create($request->paystack);
            }

            $payment_methods['paystack'] = $paystack_config;
        }

        if ($request->has('flutterwave')) {
            $flutterwave_config = $request->flutterwave;

            $flutterwave_validation_rules = [
                "public_key" => "required|string",
                "secret_key" => "required|string",
                "encryption_key" => "required|string",
            ];

            $flutterwave_validation_messages = [
                "required" => "The flutterwave :attribute field is required"
            ];

            $validator = Validator::make($flutterwave_config, $flutterwave_validation_rules, $flutterwave_validation_messages);

            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }

            $flutterwave_config = FlutterwaveConfig::find(1);
            if ($flutterwave_config) {
                $flutterwave_config->update($request->flutterwave);
            } else {
                $flutterwave_config = FlutterwaveConfig::create($request->flutterwave);
            }

            $payment_methods['flutterwave'] = $flutterwave_config;
        }

        if ($request->has('stripe')) {
            $stripe_config = $request->stripe;

            $stripe_validation_rules = [
                "publishable_key" => "required|string",
                "secret_key" => "required|string",
            ];

            $stripe_validation_messages = [
                "required" => "The Stripe :attribute field is required"
            ];

            $validator = Validator::make($stripe_config, $stripe_validation_rules, $stripe_validation_messages);

            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }

            $stripe_config = StripeConfig::find(1);

            if ($stripe_config) {
                $stripe_config->update($request->stripe);
            } else {
                $stripe_config = StripeConfig::create($request->stripe);
            }

            $payment_methods['stripe'] = $stripe_config;
        }

        if ($request->has('paypal')) {
            $paypal_config = $request->paypal;

            $paypal_validation_rules = [
                "client_id" => "required|string",
                "secret_key" => "required|string",
            ];

            $paypal_validation_messages = [
                "required" => "The Paypal :attribute field is required"
            ];

            $validator = Validator::make($paypal_config, $paypal_validation_rules, $paypal_validation_messages);

            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }

            $paypal_config = PaypalConfig::find(1);

            if ($paypal_config) {
                $paypal_config->update($request->paypal);
            } else {
                $paypal_config = PaypalConfig::create($request->paypal);
            }

            $payment_methods['paypal'] = $paypal_config;
        }


        return response()->json(["message"=>"Payment keys successfully saved", "data"=>$payment_methods]);
    }


    public function getPaymentKeys()
    {
        $payment_methods = [];
        $paystack_config = PaystackConfig::latest()->first();
        $flutterwave_config = FlutterwaveConfig::latest()->first();
        $stripe_config = StripeConfig::latest()->first();
        $paypal_config = PaypalConfig::latest()->first();
        $is_admin = auth()->guard('api')->check() && auth()->guard('api')->user()->hasRole("admin");

        if($paystack_config)
        {
            $paystack_config =  $is_admin ? $paystack_config : $paystack_config->makeHidden(['secret_key', 'created_at', 'updated_at', 'deleted_at', 'id']);
        }
        if($flutterwave_config)
        {
            $flutterwave_config = $is_admin ? $flutterwave_config : $flutterwave_config->makeHidden(['secret_key', 'encryption_key', 'created_at', 'updated_at', 'deleted_at', 'id']);
        }
        if($stripe_config)
        {
            $stripe_config = $is_admin ? $stripe_config : $stripe_config->makeHidden(['secret_key', 'created_at', 'updated_at', 'deleted_at', 'id']);
        }
        if($paypal_config)
        {
            $paypal_config = $is_admin ? $paypal_config : $paypal_config->makeHidden(['secret_key', 'encryption_key', 'created_at', 'updated_at', 'deleted_at', 'id']);
        }
            

        $payment_methods["paystack"] = $paystack_config;
        $payment_methods["flutterwave"] = $flutterwave_config;
        $payment_methods["stripe"] = $stripe_config;
        $payment_methods["paypal"] = $paypal_config;
        return response()->json($payment_methods);
    }
}
