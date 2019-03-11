<?php

namespace ComproLaravelSDK;

Class ComproBilling
{
    public function getPaymentWidgetLink(array $data)
    {
        $integrationUrl = config("config.payment.compro_billing.api_url");
        $accessToken = config("config.payment.compro_billing.access_token");
        $merchantUid = config("config.payment.compro_billing.merchant_uid");

        $fullName = $data['full_name'];
        $email = $data['email'];
        $contactNumber = $data['contact_number'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."validate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "merchant_uid=".$merchantUid."&full_name=".$fullName."&email=".$email."&contact_number=".$contactNumber."&undefined=",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$accessToken."",
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: 3e94d038-1547-462a-a1e1-93fa74f7b98d",
                "cache-control: no-cache"
            ),
        ));

        $resp = curl_exec($curl);
        $response = json_decode($resp);
        $err = curl_error($curl);

        curl_close($curl);


        if ($err) {
            return [
                "success" => false,
                "message" => $err
            ];
        } else {
            return [
                "success" => true,
                "message" => "Success to get Payment Widget Link",
                "response" => $response
            ];
        }
    }

    public function getTransactionHistoryList(array $data)
    {
        $integrationUrl = config("config.payment.compro_billing.api_url");
        $accessToken = config("config.payment.compro_billing.access_token");
        $merchantUid = config("config.payment.compro_billing.merchant_uid");

        $email = $data['email'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."transaction/get-transaction-list-shareable-link",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n".$email."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"merchant_uid\"\r\n\r\n".$merchantUid."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".$accessToken."",
                "Postman-Token: 93e58478-98f4-4477-bba2-6b8a2844ad8e",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
            ),
        ));

        $resp = curl_exec($curl);
        $response = json_decode($resp);
        $err = curl_error($curl);

        if ($err) {
            return [
                "success" => false,
                "message" => $err
            ];
        } else {
            return [
                "success" => true,
                "message" => "Success to get Transaction History List",
                "response" => $response
            ];
        }
    }
}