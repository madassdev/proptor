<?php

namespace App\Exceptions;

use Exception;

class PaystackPaymentNotVerifiedException extends Exception
{
    protected $message;
    public function __construct($message, $code, $data=null){
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function render()
    {
        return response()->json(['error'=>['message'=>$this->message, 'data'=>$this->data]], $this->code);
    }
}
