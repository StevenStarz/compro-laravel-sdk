<?php

namespace ComproLaravelSDK;

use Veritrans_Config;
use Veritrans_Snap;

Class Midtrans
{
    public function vt_payment($transaction)
    {
        Veritrans_Config::$serverKey = config("config.payment.midtrans.server_key");
        Veritrans_Config::$isProduction = false;
        Veritrans_Config::$isSanitized = true;
        Veritrans_Config::$is3ds = true;

        $transaction_details = [
            'order_id'      => $transaction['order_id'],
            'gross_amount'  => $transaction['total'],
        ];

        $item_details = $transaction["transaction_details"];

        $billing_address = [
            'first_name'    => $transaction['name'],
            'phone'         => $transaction['phone'],
            'address'       => $transaction['address'],
            'city'          => $transaction['city'],
            'postal_code'   => $transaction['postal_code'],
        ];

        $customer_details = [
            'first_name'        => $transaction['name'],
            'email'             => $transaction['email'],
            'phone'             => $transaction["phone"],
            'billing_address'   => $billing_address,
            'shipping_address'  => $billing_address,
        ];

        $transaction_midtrans = [
            'transaction_details'   => $transaction_details,
            'item_details'          => $item_details,
            'customer_details'      => $customer_details
        ];

        $transaction_midtrans['credit_card'] = [
            "secure" => true
        ];

        $snapToken = Veritrans_Snap::getSnapToken($transaction_midtrans);

        return [
            "success" => true,
            "message" => "Successfully get Token",
            "response" => $snapToken,
        ];
    }
}