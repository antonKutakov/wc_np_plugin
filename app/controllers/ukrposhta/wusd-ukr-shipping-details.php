<?php

namespace WooUkrainianShippingDelivery\App\Controllers\Ukrposhta;

use WooUkrainianShippingDelivery\App\Controller;
use WooUkrainianShippingDelivery\App\DB\WUSD_DB;
use WooUkrainianShippingDelivery\App\Render;

class WUSD_UKR_Shipping_Details extends \WC_Shipping_Method{

    private $cost;

    public function __construct(){
        // Code...
    }

    /**
     * Init options
     *
     * @return void
     */
    public function init(){
        add_action('woocommerce_admin_order_data_after_shipping_address', array($this, 'wusd_add_atributes_to_render'));
        add_action('woocommerce_order_details_after_customer_details', array($this,'wusd_add_atributes_to_render_frontend'), 10, 1);
        add_action('wp_ajax_wusd_change_shipping_cost', array($this, 'wusd_change_shipping_cost'));
        add_action('wp_ajax_nopriv_wusd_change_shipping_cost', array($this, 'wusd_change_shipping_cost'));
        add_action('wp_ajax_wusd_get_city_sender', array($this, 'wusd_get_city_sender'));
        add_action('wp_ajax_nopriv_wusd_get_city_sender', array($this, 'wusd_get_city_sender'));
        add_action('wp_ajax_wusd_get_total_goods_price', array($this, 'wusd_get_total_goods_price'));
        add_action('wp_ajax_nopriv_wusd_get_total_goods_price', array($this, 'wusd_get_total_goods_price'));
        add_action('woocommerce_thankyou', array($this, 'wusd_refresh_shipping_rates_cache_after_place_order'));
        add_action('woocommerce_checkout_update_order_review', array($this, 'wusd_action_woocommerce_checkout_update_order_review'), 10);
        add_filter('woocommerce_checkout_update_order_review', array($this,'wusd_clear_wc_shipping_rates_cache'));
    }

    public function wusd_get_total_goods_price(){
        global $woocommerce;

        echo WC()->cart->get_subtotal();

        wp_die();
    }
    
    public function wusd_get_city_sender(){
        $result = get_option('woocommerce_nova_poshta_shipping_settings');
        $city_sender = $result['mycity'];
        $npdb = WUSD_DB::getInstance();
        $city_sender_ref = $npdb->get_data("*", "novaposhta_cities", "WHERE Description = '$city_sender'");
        echo $city_sender_ref[0]['Ref'];
        wp_die();
    }
    
    public function wusd_refresh_shipping_rates_cache_after_place_order(){
        $packages = WC()->cart->get_shipping_packages();
    
        foreach ($packages as $key => $value) {
            $shipping_session = "shipping_for_package_$key";
    
            unset(WC()->session->$shipping_session);
        }
    }

    public function wusd_clear_wc_shipping_rates_cache(){
        $packages = WC()->cart->get_shipping_packages();
    
        foreach ($packages as $key => $value) {
            $shipping_session = "shipping_for_package_$key";
    
            unset(WC()->session->$shipping_session);
        }
    }

    /**
     * Changing order shipping costу
     *
     * @return void
     */
    public function wusd_change_shipping_cost($order){
        global $woocommerce;

        $npdb = WUSD_DB::getInstance();

        $shipping_cost = sanitize_text_field($_POST['cost']);
        $this->cost = $shipping_cost;
        $WC_Cart = new \WC_Cart();
        $packages = $WC_Cart->get_shipping_packages();
        $WC_Shipping = new \WC_Shipping();
        $WC_Checkout = new \WC_Checkout();

        WC()->session->set('new_shipping_cost', sanitize_text_field($_POST['cost']));
        WC()->cart->calculate_shipping();
        
        echo "0";
        wp_die();
    }


    public function wusd_action_woocommerce_checkout_update_order_review($array)
    {
        WC()->cart->calculate_shipping();
        WC()->cart->calculate_totals();
        return;
    }

    public function wusd_getOrderData($order){
        global $wpdb;

        $items = $order->get_items();

        foreach ( $items as $item ) {
            $product_name = $item['name'];
            $product_id = $item['product_id'];
            $product_variation_id = $item['variation_id'];
        }

        $npdb = WUSD_DB::getInstance();
        
        $idArea = get_post_meta( $order->get_id(), 'area', true );
        $idCity = get_post_meta( $order->get_id(), 'city', true );
        $idWarehouse = get_post_meta( $order->get_id(), 'warehouse', true );
        $shippingType = get_post_meta( $order->get_id(), 'shippingType', true );

        $npArea = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_areas WHERE Ref = '" . esc_attr($idArea) . "'", ARRAY_A);
        $npCity = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_cities WHERE Ref = '" . esc_attr($idCity) . "'", ARRAY_A);
        $npWarehouse = $wpdb->get_results("SELECT Description FROM  wp_novaposhta_warehouses WHERE Ref = '$idWarehouse'", ARRAY_A);

        $shippingMethod = $order->get_shipping_methods();
        $shippingMethod = reset($shippingMethod);

        $areaOutput = $npArea[0]['Description'];
        $cityOutput = $npCity[0]['Description'];
        $warehouseOutput = $npWarehouse[0]['Description'];

        return array(
            'areaOutput' => $areaOutput,
            'cityOutput' => $cityOutput,
            'warehouseOutput' => $warehouseOutput,
            'shippingType' => $shippingType
        );

    }


    /**
     * Adding attributes to render for admin
     *
     * @return void
     */
    public function wusd_add_atributes_to_render($order){
        $data  = $this->wusd_getOrderData($order);
        $shippingTypeRu = $this->translate_shipping_type($data['shippingType']); 

        $data += ["shippingTypeRu" => $shippingTypeRu];

        Render::make("order-details-admin", $data);
    }

    /**
     * Adding attributes to render on frontend
     *
     * @return void
     */
    public function wusd_add_atributes_to_render_frontend($order){
        $data  = $this->wusd_getOrderData($order);
        $shippingTypeRu = $this->translate_shipping_type($data['shippingType']);        

        $data += ["shippingTypeRu" => $shippingTypeRu];

        Render::make("order-details-frontend", $data);
    }

    private function translate_shipping_type($shipping_type){
        switch($shipping_type){
            case "DoorsDoors":
                return "Двері-Двері";
            break;
            case "DoorsWarehouse":
                return "Двері-Склад";
            break;
            case "WarehouseWarehouse":
                return "Склад-Склад";
            break;
            case "WarehouseDoors":
                return "Склад-Двері";
            break;
            default: 
                return "Склад-Склад";                        
            break;  
        }
    }
}