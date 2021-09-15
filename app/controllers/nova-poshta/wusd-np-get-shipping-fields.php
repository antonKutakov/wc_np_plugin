<?php

namespace WooUkrainianShippingDelivery\App\Controllers\Novaposhta;

use WooUkrainianShippingDelivery\App\Controller;


class WUSD_NP_Get_Shipping_Fields extends Controller
{
    private $wusd_request_areas;

    public function __construct(){
        $this->wusd_request_areas = new WUSD_NP_Settings();
    }


    /**
     * Init options
     *
     * @return void
     */
    public function init(){
        add_action( "wp_ajax_wusd_get_areas", array($this, 'wusd_get_areas') );
        add_action( "wp_ajax_wusd_get_cities", array($this, 'wusd_get_cities') );
        add_action( "wp_ajax_wusd_get_warehouses", array($this, 'wusd_get_warehouses') );
        add_action( "wp_ajax_nopriv_wusd_get_areas", array($this, 'wusd_get_areas') );
        add_action( "wp_ajax_nopriv_wusd_get_cities", array($this, 'wusd_get_cities') );
        add_action( "wp_ajax_nopriv_wusd_get_warehouses", array($this, 'wusd_get_warehouses') );
        add_action( "wp_ajax_wusd_get_city_recepient", array($this, 'wusd_get_city_recepient') );
        add_action( "wp_ajax_nopriv_wusd_get_city_recepient", array($this, 'wusd_get_city_recepient') );
    }

    public function wusd_get_city_recepient(){
        global $wpdb;
        $city = sanitize_text_field($_GET['city']);
        $result = $wpdb->get_row("SELECT * FROM wp_novaposhta_cities WHERE Description = '$city'", OBJECT);
        echo json_encode($result->Ref);
        wp_die();
    }

    public function wusd_get_areas(){
        $areas = $this->wusd_request_areas->wusd_preload_addresses();

        echo json_encode($areas);

        wp_die();
    }

    public function wusd_get_cities(){
        $cities = $this->wusd_request_areas->wusd_preload_cities();

        echo json_encode($cities);

        wp_die();
    }

    public function wusd_get_warehouses(){
        $warehouses = $this->wusd_request_areas->wusd_preload_warehouses();

        echo json_encode($warehouses);

        wp_die();
    }

}
