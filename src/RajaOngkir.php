<?php

namespace ComproLaravelSDK;

use ComproLaravelSDK\Contracts\DeliveryServiceInterface;

Class RajaOngkir implements DeliveryServiceInterface
{
    public function domesticDeliveryCost(array $data)
    {
        $integrationUrl = config("config.delivery_services.raja_ongkir.api_url");
        $apiKey = config("config.delivery_services.raja_ongkir.api_key");

        $weight = ceil($data["weight"]);

        if ($weight == 0) {
            $weight = 1;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"key\"\r\n\r\n$apiKey\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"origin\"\r\n\r\n".$data['origin']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"destination\"\r\n\r\n".$data['destination']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"weight\"\r\n\r\n$weight\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"courier\"\r\n\r\n".$data['courier']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"originType\"\r\n\r\ncity\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"destinationType\"\r\n\r\ncity\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: ef2ca6c8-7171-4fbf-b1e2-4d3a0bb6afa0",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
            ),
        ));

        $resp = curl_exec($curl);
        $response = json_decode($resp);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err || $response == null) {
            return [
                "success" => false,
                "message" => "Failed to check delivery cost"
            ];
        } elseif ($response->rajaongkir->status->code == 400) {
            return [
                "success" => false,
                "message" => "Something is wrong with data/parameter sent",
                "response" => $response->rajaongkir->status->description
            ];
        } else {
            return [
                "success" => true,
                "message" => "Success checking delivery cost",
                "response" => $response
            ];
        }
    }

    public function internationalDeliveryCost(array $data)
    {
        $integrationUrl = config("config.delivery_services.raja_ongkir.api_url");
        $apiKey = config("config.delivery_services.raja_ongkir.api_key");

        $weight = ceil($data["weight"]);

        if ($weight == 0) {
            $weight = 1;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."internationalCost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"key\"\r\n\r\n$apiKey\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"origin\"\r\n\r\n".$data['origin']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"destination\"\r\n\r\n".$data['destination']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"weight\"\r\n\r\n".$weight."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"courier\"\r\n\r\n".$data['courier']."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 7a72d0fd-86af-4236-9497-8f4c9d2c3e5f",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
            ),
        ));

        $resp = curl_exec($curl);
        $response = json_decode($resp);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err || $response == null) {
            return [
                "success" => false,
                "message" => "Failed to check delivery cost",
            ];
        } elseif ($response->rajaongkir->status->code == 400) {
            return [
                "success" => false,
                "message" => "Something is wrong with data/parameter sent",
                "response" => $response->rajaongkir->status->description
            ];
        } else {
            return [
                "success" => true,
                "message" => "Success checking delivery cost",
                "response" => $response
            ];
        }
    }
}