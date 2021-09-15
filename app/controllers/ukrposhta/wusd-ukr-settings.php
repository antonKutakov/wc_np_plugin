<?php

namespace WooUkrainianShippingDelivery\App\Controllers\Ukrposhta;

use WooUkrainianShippingDelivery\App\Controller;
use WooUkrainianShippingDelivery\App\Helpers\WUSD_Helper_Request_Json;
use WooUkrainianShippingDelivery\App\DB\WUSD_DB;
use WooUkrainianShippingDelivery\App\Render;


class WUSD_UKR_Settings extends Controller{

    private $wusd_settings_render;
    private $wusd_request_json;

    public function __construct(){
        $this->wusd_request_json = new WUSD_Helper_Request_Json();
    }

    /**
     * Init options
     *
     * @return void
     */
    public function init(){
        add_action( "admin_menu", array($this, 'wusd_show_menu') );
        add_action( "wp_ajax_wusd_save_settings", array($this, 'wusd_save_settings') );
        add_action( "wp_ajax_wusd_load_addresses", array($this, 'wusd_load_addresses') );
        add_action( "wp_ajax_wusd_preload_addresses", array($this, 'wusd_preload_addresses') );
        add_action( "wp_ajax_wusd_preload_cities", array($this, 'wusd_preload_cities') );
        add_action( "wp_ajax_wusd_preload_warehouses", array($this, 'wusd_preload_warehouses') );
    }

    /**
     * Create menu
     *
     * @return void
     */
    public function wusd_show_menu(){
        add_menu_page(
            "Nova Poshta", 
            "Nova Poshta", 
            "manage_options", 
            "nova_poshta", 
            array($this, "wusd_add_atributes_to_render"),
            WUSD_PATH . "assets/images/novaposhta-logo.png", 
            4 
        );
    }

    /**
     * Adding attributes to render
     *
     * @return void
     */
    public function wusd_add_atributes_to_render(){
        $npdb = WUSD_DB::getInstance();
        $data = get_option("woocommerce_nova_poshta_shipping_settings");
        if(empty($data)){
            $data = array(
                'enabled' => 'no',
                'title' => '0',
                'subtitle' => '0',
                'api' => '0',
                'myarea' => '0',
                'mycity' => '0',
                'mywarehouse' => '0',
                'attr' => '0',
                'warehouse_ref' => '0',
            );
        }
        else{
            $warehouse_desc = $data['mywarehouse'];
            $warehouse_info = $npdb->get_data("*", "novaposhta_warehouses", "WHERE `Description` = '$warehouse_desc'");
            @$warehouse_ref = $warehouse_info[0]['Ref'];
            $data += array("warehouse_ref" => $warehouse_ref);
        }
        
        Render::make("settings", $data);
    }

    public function wusd_save_settings(){
        global $wpdb;

        $idArea =  sanitize_text_field($_POST['myarea']);
        $idCity =  sanitize_text_field($_POST['mycity']);
        $idWarehouse =  sanitize_text_field($_POST['mywerehouse']);

        $npArea = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_areas WHERE Ref = '" .$idArea. "'", ARRAY_A);
        $npCity = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_cities WHERE Ref = '" . $idCity . "'", ARRAY_A);
        $npWarehouse = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_warehouses WHERE Ref = '" . $idWarehouse . "'", ARRAY_A);

        $areaOutput = $npArea[0]['Description'];
        $cityOutput = $npCity[0]['Description'];
        $warehouseOutput = $npWarehouse[0]['Description'];

        $data = array(
            'enabled' => ($_POST['enabled'] == 1) ? "yes" : "no",
            'title' => sanitize_text_field($_POST['title']),
            'subtitle' => sanitize_text_field($_POST['subtitle']),
            'api' => sanitize_text_field($_POST['api']),
            'myarea' => $areaOutput,
            'mycity' => $cityOutput,
            'mywarehouse' => $warehouseOutput,
            'attr' => $idArea
        );

        update_option( "woocommerce_nova_poshta_shipping_settings", $data );
        echo "success";

        wp_die();
    }

    /**
     * Ajax callback for taking statements
     *
     * @return void
     */
    public function wusd_ajax_take_areas(){
        $result = get_option("woocommerce_nova_poshta_shipping_method_settings");

        echo $this->wusd_settings->wusd_save_settings($result, $this->db);

        wp_die();
    }

    public function wusd_load_addresses(){
        $npdb = WUSD_DB::getInstance();
        $areas = $this->wusd_request_json->wusd_getAreas();
        $cities = $this->wusd_request_json->wusd_getCities();
        $warehouses = $this->wusd_request_json->wusd_getWarehouses();
        
        $npdb->clear_table("novaposhta_areas");

        foreach($areas['data'] as $area){
            $npdb->insert_data("novaposhta_areas", $area, array());
        }

        $npdb->clear_table("novaposhta_cities");

        foreach($cities['data'] as $city){
            $npdb->insert_data("novaposhta_cities", $city, array());
        }
        
        $npdb->clear_table("novaposhta_warehouses");
        foreach($warehouses['data'] as $warehouse){
            $npdb->insert_data("novaposhta_warehouses", $warehouse, array());
        }

        echo json_encode($warehouses);

        wp_die();
    }

    public function wusd_preload_addresses(){
        $data = WUSD_DB::getInstance()->get_data("*", "novaposhta_areas");

        echo json_encode($data);
        
        wp_die();
    }

    public function wusd_preload_cities(){
        $area_ref = sanitize_text_field($_GET['area']);

        $cities = WUSD_DB::getInstance()->get_data("*", "novaposhta_cities", "WHERE `Area` = '$area_ref'");

        echo json_encode($cities);

        wp_die();
    }

    public function wusd_preload_warehouses(){
        $city_ref = sanitize_text_field($_GET['city']);

        $warehouses = WUSD_DB::getInstance()->get_data("*", "novaposhta_warehouses", "WHERE `CityDescription` = '$city_ref'");
        
        echo json_encode($warehouses);

        wp_die();
    }

}