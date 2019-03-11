<?php

namespace ComproLaravelSDK\Tests;

use ComproLaravelSDK\Adapters\DeliveryServiceAdapter;
use ComproLaravelSDK\RajaOngkir;
use ComproLaravelSDK\Shipper;
use Orchestra\Testbench\TestCase;

class DeliveryServiceAdapterTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testShipperGetDomesticRates()
    {
        $deliveryServiceAdapter = new DeliveryServiceAdapter(new Shipper());

        $data = [
            "origin" => "4850",
            "destination" => "20097",
            "weight" => 1.5,
            "length" => 1,
            "width" => 1,
            "height" => 1,
            "value" => 300000
        ];

        $results = $deliveryServiceAdapter->getDomesticRates($data);

        $this->assertEquals($results["success"], true);
    }

    /**
     * @throws \Exception
     */
    public function testRajaOngkirGetDomesticRates()
    {
        $deliveryServiceAdapter = new DeliveryServiceAdapter(new RajaOngkir());

        $data = [
            "origin" => 384,
            "destination" => 151,
            "weight" => 1000,
            "courier" => 'jnt',
        ];

        $results = $deliveryServiceAdapter->getDomesticRates($data);

        $this->assertEquals($results["success"], true);
    }

    /**
     * @throws \Exception
     */
    public function testRajaOngkirGetInternationalRates()
    {
        $deliveryServiceAdapter = new DeliveryServiceAdapter(new RajaOngkir());

        $data = [
            "origin" => 153,
            "destination" => 179,
            "weight" => 1000,
            "courier" => 'pos',
        ];

        $results = $deliveryServiceAdapter->getInternationalRates($data);

        $this->assertEquals($results["success"], true);
    }
}