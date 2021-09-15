<?php

namespace WooUkrainianShippingDelivery\App\Helpers;

use WooUkrainianShippingDelivery\App\Api\Novaposhta\WUSD_NP_API_Connector;

if (!defined('ABSPATH')) {
    exit;
}

class WUSD_Helper_Request_Json
{
    public function __construct()
    {
        $key = get_option('woocommerce_novaposhta_settings');
        $this->apiKey = $key['api'];

    }

    public function wusd_getAreas()
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getAreas';
        $data['apiKey'] = $this->apiKey;

        return $this->wusd_sendRequest($data);
    }

    public function wusd_getCities()
    {
        $data['modelName'] = 'Address';
        $data['calledMethod'] = 'getCities';
        $data['apiKey'] = $this->apiKey;

        return $this->wusd_sendRequest($data);
    }

    public function wusd_getWarehouses()
    {
        $data['modelName'] = 'AddressGeneral';
        $data['calledMethod'] = 'getWarehouses';
        $data['apiKey'] = $this->apiKey;

        return $this->wusd_sendRequest($data);
    }

    public function wusd_sendRequest($data)
    {
        return json_decode((new WUSD_NP_API_Connector())->wusd_send($data), true);
    }
}