<?php

namespace WooUkrainianShippingDelivery\App\WCEXT\Novaposhta;

use WooUkrainianShippingDelivery\App\Render;

class WC_NP_WUSD_Woo_Shipping_Details{
    
    private $checkout_render;
    private $map_render;
    private $wusd_package_area;

    public function __construct(){
    }

    public function init(){
        add_action('woocommerce_after_checkout_billing_form', array($this,'wusd_checkout_forms'));
        add_action('woocommerce_checkout_after_customer_details', array($this,'wusd_checkout_map'));
    }

    /**
     * Add np select boxes to checkout
     *
     * @return void
     */
    public function wusd_checkout_forms($checkout){
        global $woocommerce;

        $pdt_id = [];

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $pdt_id = $cart_item['product_id'];
        }

        $weight = $woocommerce->cart->cart_contents_weight;
        $unit = get_option('woocommerce_weight_unit');

        $data = array(
            "pdt_id" => $pdt_id,
            "weight" => $weight,
            "unit" => $unit
        );
        
        Render::make('checkout-select', $data);
    }

    /**
     * Add np googlemap
     *
     * @return void
     */
    public function wusd_checkout_map(){
        Render::make('checkout-gmap');
    }

}