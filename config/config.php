<?php

return [
    "delivery_services" => [
        "raja_ongkir" => [
            "api_url" => env("RAJA_ONGKIR_API_URL"),
            "api_key" => env("RAJA_ONGKIR_API_KEY")
        ],
        "shipper" => [
            "api_url" => env("SHIPPER_API_URL"),
            "api_key" => env("SHIPPER_API_KEY")
        ],
        "pos_malaysia" => [
            "api_url" => env("POS_MALAYSIA_API_URL"),
            "api_key" => env("POS_MALAYSIA_API_KEY")
        ],
        "go_send" => [
            "api_url" => env("GOSEND_API_URL"),
            "client_id" => env("GOSEND_API_CLIENT_ID"),
            "pass_key" => env("GOSEND_API_PASS_KEY")
        ]
    ],
    "payment" => [
        "midtrans" => [
            "client_key" => env("MIDTRANS_CLIENT_KEY"),
            "server_key" => env("MIDTRANS_SERVER_KEY")
        ],
        "senangpay" => [
            "api_url" => env("SENANG_PAY_API_URL"),
            "api_key" => env("SENANG_PAY_API_KEY")
        ],
        "compro_billing" => [
            "api_url" => env("COMPRO_BILLING_API_URL"),
            "access_token" => env("COMPRO_BILLING_ACCESS_TOKEN"),
            "merchant_uid" => env("COMPRO_BILLING_MERCHANT_UID")
        ]
    ],
    "pos" => [
        "omega" => [
            "uid" => env("OMEGA_UID")
        ]
    ],
    "loyalty" => [
        "compro_loyalty" => [
            "api_url" => env("COMPRO_LOYALTY_API_URL"),
            "domain" => env("COMPRO_LOYALTY_DOMAIN"),
            "merchant_code" => env("COMPRO_LOYALTY_MERCHANT_CODE")
        ]
    ]
];