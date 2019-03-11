<?php

namespace ComproLaravelSDK;

use ComproLaravelSDK\Contracts\DeliveryServiceInterface;

Class Shipper implements DeliveryServiceInterface
{
    public function shipperDomesticDeliveryCost(array $data)
    {
        $integrationUrl = config("config.delivery_services.shipper.api_url") . "public/v1/domesticRates";
        $apiKey = config("config.delivery_services.shipper.api_key");

        $body = [
            "apiKey" => $apiKey,
            "o" => $data['origin'],
            "d" => $data['destination'],
            "wt" => $data['weight'],
            "l" => $data['length'],
            "w" => $data['width'],
            "h" => $data['height'],
            "v" => $data['value']
        ];

        $index = 0;
        foreach ($body as $key => $value) {
            if ($index == 0) {
                $integrationUrl .= "?{$key}={$value}";
            } else {
                $integrationUrl .= "&{$key}={$value}";
            }
            $index++;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 3619a343-6ae9-4bee-af33-8f83486a4e8c",
                "User-Agent: Mozilla/",
                "cache-control: no-cache"
            ),
        ));

        $resp = curl_exec($curl);
        $response = json_decode($resp);
        $err = curl_error($curl);

        curl_close($curl);

        if (! isset($response->status) || $err) {
            return [
                "success" => false,
                "error" => "Failed to check delivery cost."
            ];
        } elseif ($response->status == "fail") {
            return [
                "success" => false,
                "message" => "Something is wrong with the Parameter",
                "error" => "{$response->data->title} - {$response->data->content}."
            ];
        } elseif ($response->status == "success") {
            return [
                "success" => true,
                "message" => "Successfully check the delivery cost",
                "response" => $response
            ];
        }
    }
}
