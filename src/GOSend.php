<?php

namespace ComproLaravelSDK;

Class GOSend
{
    protected function priceEstimate($origin, $destination)
    {
        $integrationUrl = config("config.delivery_services.go_send.api_url");
        $clientId = config("config.delivery_services.go_send.client_id");
        $passKey = config("config.delivery_services.go_send.pass_key");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "443",
            CURLOPT_URL => $integrationUrl."calculate/price?origin=$origin&destination=$destination&paymentType=3",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Client-ID: $clientId",
                "Pass-Key: $passKey",
                "Postman-Token: f9267073-0105-4e44-9b80-b98f5d7dade9",
                "cache-control: no-cache"
            ),
        ));

        $resp = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ([
                "success" => false,
                "message" => "Error Occur "
            ]);
        } else {
            return ([
                "success" => true,
                "message" => "Successfully estimate the price",
                "response" => $resp,
            ]);
        }
    }

    protected function bookingCreation($shipmentMethod, $originName, $originNote, $originContactName, $originContactNo, $origin, $originAddress, $destinationName, $destinationNote, $destinationContactName, $destinationContactNo, $destination, $destinationAddress, $item, $storeOrderId)
    {
        $integrationUrl = config("config.delivery_services.go_send.api_url");
        $clientId = config("config.delivery_services.go_send.client_id");
        $passKey = config("config.delivery_services.go_send.pass_key");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "443",
            CURLOPT_URL => $integrationUrl."booking",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"paymentType\": 3,\n\t\"deviceToken\": \"\",\n\t\"collection_location\":\"pickup\",\n\t\"shipment_method\":\"$shipmentMethod\",\n\t\"routes\":\n\t[{\n\t\t\"originName\": \"$originName\",\n\t\t\"originNote\": \"$originNote\",\n\t\t\"originContactName\":\"$originContactName\",\n\t\t\"originContactPhone\": \"$originContactNo\",\n\t\t\"originLatLong\": \"$origin\",\n\t\t\"originAddress\": \"$originAddress\",\n\t\t\"destinationName\": \"$destinationName\",\n\t\t\"destinationNote\": \"$destinationNote\",\n\t\t\"destinationContactName\": \"$destinationContactName\",\n\t\t\"destinationContactPhone\": \"$destinationContactNo\",\n\t\t\"destinationLatLong\": \"$destination\",\n\t\t\"destinationAddress\": \"$destinationAddress\",\n\t\t\"item\": \"$item\",\n\t\t\"storeOrderId\": \"$storeOrderId\",\n\t\t\"insuranceDetails\":\n\t\t{\n\t\t\t\"applied\": \"\",\n\t\t\t\"fee\": \"\",\n\t\t\t\"product_description\": \"\",\n\t\t\t\"product_price\": \"\"\n\t\t}\n\t}]}",
            CURLOPT_HTTPHEADER => array(
                "Client-ID: $clientId",
                "Content-Type: application/json",
                "Pass-Key: $passKey",
                "Postman-Token: 8eabab2b-3df1-4df7-8b43-88e79003dc44",
                "cache-control: no-cache"
            ),
        ));

        $headers = [];
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        $resp = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ([
                "success" => false,
                "message" => "Error Occur"
            ]);
        } else {
            return ([
                "success" => true,
                "message" => "Successfully create Booking",
                "response" => $resp,
                "headers" => $headers,
            ]);
        }
    }

    protected function checkCurrentOrderStatus($orderNo)
    {
        $integrationUrl = config("config.delivery_services.go_send.api_url");
        $clientId = config("config.delivery_services.go_send.client_id");
        $passKey = config("config.delivery_services.go_send.pass_key");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "443",
            CURLOPT_URL => $integrationUrl."booking/orderno/$orderNo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Client-ID: $clientId",
                "Pass-Key: $passKey",
                "Postman-Token: 870ed279-5e3a-4fa7-a3b0-933e174c2567",
                "cache-control: no-cache"
            ),
        ));

        $resp = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ([
                "success" => false,
                "message" => "Error Occur"
            ]);
        } elseif ($resp == '') {
            return ([
                "success" => false,
                "message" => 'Order Number Not Found',
                "response" => $resp,
            ]);
        } else {
            return ([
                "success" => true,
                "message" => "Success retrieve Current Status",
                "response" => $resp,
            ]);
        }
    }

    protected function bookingCancellation($orderNo)
    {
        $integrationUrl = config("config.delivery_services.go_send.api_url");
        $clientId = config("config.delivery_services.go_send.client_id");
        $passKey = config("config.delivery_services.go_send.pass_key");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "443",
            CURLOPT_URL => $integrationUrl."booking/cancel?orderNo=$orderNo",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Client-ID: $clientId",
                "Pass-Key: $passKey",
                "Postman-Token: bfae494c-ef0a-415d-b36b-da4adf9b3998",
                "cache-control: no-cache"
            ),
        ));

        $headers = [];
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$headers)
            {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        $resp = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ([
                "success" => false,
                "message" => "Error Occur"
            ]);
        } elseif ($resp == '') {
            return ([
                "success" => false,
                "message" => 'Order Number Not Found',
                "response" => $resp,
                "headers" => $headers,
            ]);
        } else {
            return ([
                "success" => true,
                "message" => "Booking Cancelled",
                "response" => $resp,
                "headers" => $headers
            ]);
        }
    }

}