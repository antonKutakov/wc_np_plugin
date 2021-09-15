<?php

namespace WooUkrainianShippingDelivery\App\Controllers\Ukrposhta;

if (!defined('ABSPATH')) {
    exit;
}

class WUSD_UKR_Order_Processing {

    public function init(){
        add_action('woocommerce_checkout_update_order_meta', array($this, 'wusd_custom_checkout_field_update_order_meta'));
    }

    public function wusd_custom_checkout_field_update_order_meta($order_id){
        if (!empty($_POST['wusd_area'])) {
            update_post_meta($order_id, 'area' , sanitize_text_field($_POST['wusd_area'] ));
        }
        if (!empty($_POST['wusd_city'])) {
            update_post_meta($order_id, 'city' , sanitize_text_field($_POST['wusd_city'] ));
        }
        if (!empty($_POST['wusd_warehouse'])) {
            update_post_meta($order_id, 'warehouse' , sanitize_text_field($_POST['wusd_warehouse'] ));
        }
        if (!empty($_POST['wusd_shippingtype'])){
            update_post_meta($order_id, 'shippingType', sanitize_text_field($_POST['wusd_shippingtype']));
        }
    }

}