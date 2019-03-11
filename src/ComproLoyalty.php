<?php

namespace ComproLaravelSDK;

Class ComproLoyalty
{
    public function internalLogin(array $data)
    {
        $integrationUrl = config("config.loyalty.compro_loyalty.api_url");

        $authID = $data['auth_id'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."Login?auth_id=".$authID."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 99ba4655-4014-4242-b1f9-bc681e839cf3",
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
                "message" => "Success to Login",
                "response" => $response
            ];
        }
    }

    public function getMerchant(array $data)
    {
        $integrationUrl = config("config.loyalty.compro_loyalty.api_url");
        $integrationDomain = config("config.loyalty.compro_loyalty.domain");
        $merchantCode = config("config.loyalty.compro_loyalty.merchant_code");

        $sessionId = $data['session_id'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."ComproGetMerchant?session_id=".$sessionId."&merchant_code=".$merchantCode."&domain=".$integrationDomain."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "undefined=",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: 748e56e7-49ca-4af9-bb95-a5e49905e319",
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
                "message" => "Success to get Merchant",
                "response" => $response
            ];
        }
    }

    public function getIntegrationMember(array $data)
    {
        $integrationUrl = config("config.loyalty.compro_loyalty.api_url");
        $merchantCode = config("config.loyalty.compro_loyalty.merchant_code");

        $sessionId = $data['session_id'];
        $appIntegration = $data['app_integration'];
        $emailIntegration = $data['email_integration'];
        $email = $data['email'];
        $password = $data['password'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."ComproIntegrationMember?session_id=".$sessionId."&app_integration=".$appIntegration."&email_integration=".$emailIntegration."&email=".$email."&password=".$password."&merchant_code=".$merchantCode."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 5c574584-b97e-41f9-b72d-49917e156885",
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
                "message" => "Success to Integration Member",
                "response" => $response
            ];
        }
    }

    public function getMemberBalance(array $data)
    {
        $integrationUrl = config("config.loyalty.compro_loyalty.api_url");
        $integrationDomain = config("config.loyalty.compro_loyalty.domain");
        $merchantCode = config("config.loyalty.compro_loyalty.merchant_code");

        $sessionId = $data['session_id'];
        $memberCode = $data['member_code'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."ComproGetMemberBalance?session_id=".$sessionId."&member_code=".$memberCode."&merchant_code=".$merchantCode."&domain=$integrationDomain",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: bfca94e4-5a20-4abc-b385-f336519ab389",
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
                "message" => "Success to get Member Balance",
                "response" => $response
            ];
        }
    }

    public function getLoyaltyTransaction(array $data)
    {
        $integrationUrl = config("config.loyalty.compro_loyalty.api_url");
        $integrationDomain = config("config.loyalty.compro_loyalty.domain");
        $merchantCode = config("config.loyalty.compro_loyalty.merchant_code");

        $sessionId = $data['session_id'];
        $memberCode = $data['member_code'];
        $rewardUse = $data['reward_use'];
        $balanceUse = $data['balance_use'];
        $description = $data['description'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $integrationUrl."ComproTransaction?session_id=".$sessionId."&domain=".$integrationDomain."&merchant_code=".$merchantCode."&member_code=".$memberCode."&balance_use=".$balanceUse."&reward_use=".$rewardUse."&description=".$description."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: f93049df-d2f4-4d9f-81b2-c7dbd47e702d",
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
                "message" => "Success to get Loyalty Transaction",
                "response" => $response
            ];
        }
    }
}
