<?php

namespace WooUkrainianShippingDelivery\App\Controllers\Ukrposhta;

if (!defined('ABSPATH')) {
    exit;
}


class WUSD_UKR_Validation {

    public function init(){
        add_action('woocommerce_checkout_process', array($this, 'wusd_checkout_field_process'));
        add_action('woocommerce_checkout_update_order_meta',  array($this,  'wusd_checkout_field_update_order_meta'));
    }

    /**
     * Checkout Process
     */
    public function wusd_checkout_field_process()
    {
        // Show an error message if the field is not set.
        if (!$_POST['wusd_area']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть область',WUSD_DOMAIN)) , 'error');
        if (!$_POST['wusd_city']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть місто',WUSD_DOMAIN)) , 'error');
        if (!$_POST['wusd_warehouse']) wc_add_notice(__(esc_attr__('Будь ласка, виберіть відділення',WUSD_DOMAIN)) , 'error');
    }

    /**
     * Update the value given in custom field
    */
    public function wusd_checkout_field_update_order_meta($order_id)
    {
        if (empty($_POST['wusd_area'])) {
            update_post_meta($order_id, 'area',sanitize_text_field($_POST['wusd_area']));
        }
        if (empty($_POST['wusd_city'])) {
            update_post_meta($order_id, 'city',sanitize_text_field($_POST['wusd_city']));
        }
        if (empty($_POST['wusd_warehouse'])) {
            update_post_meta($order_id, 'warehouse',sanitize_text_field($_POST['wusd_warehouse']));
        }
    }
}