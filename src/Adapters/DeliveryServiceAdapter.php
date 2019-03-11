<?php

namespace ComproLaravelSDK\Adapters;

use ComproLaravelSDK\Contracts\DeliveryServiceAdapterInterface;
use ComproLaravelSDK\Contracts\DeliveryServiceInterface;
use ComproLaravelSDK\RajaOngkir;
use ComproLaravelSDK\Shipper;

final class DeliveryServiceAdapter implements DeliveryServiceAdapterInterface
{
    private $deliveryService;

    public function __construct(DeliveryServiceInterface $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function getDomesticRates(array $data)
    {
        if ($this->deliveryService instanceof RajaOngkir) {
            return $this->deliveryService->domesticDeliveryCost($data);
        } else if ($this->deliveryService instanceof Shipper) {
            return $this->deliveryService->shipperDomesticDeliveryCost($data);
        } else {
            throw new \Exception("Failed to get domestic rates.");
        }
    }

    public function getInternationalRates(array $data)
    {
        if ($this->deliveryService instanceof RajaOngkir) {
            return $this->deliveryService->internationalDeliveryCost($data);
        } else {
            throw new \Exception("Failed to get international rates.");
        }
    }

    public function getCountries()
    {

    }

    public function getProvinces()
    {

    }

    public function getCities()
    {

    }

    public function getSuburbs()
    {

    }

    public function getAreas()
    {

    }
}