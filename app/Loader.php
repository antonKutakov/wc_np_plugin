<?php

namespace WooUkrainianShippingDelivery\App;

use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Get_Shipping_Fields;
use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Settings;
use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Shipping_Details;
use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Order_Processing;
use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Validation;
use WooUkrainianShippingDelivery\App\WCEXT\Novaposhta\WC_NP_WUSD_Woo_Shipping_Details;
use WooUkrainianShippingDelivery\App\WCEXT\Novaposhta\WC_NP_WUSD_Cargotype;

use WooUkrainianShippingDelivery\App\Controllers\Ukrposhta\WUSD_UKR_Get_Shipping_Fields;
use WooUkrainianShippingDelivery\App\Controllers\Ukrposhta\WUSD_UKR_Settings;
use WooUkrainianShippingDelivery\App\Controllers\Ukrposhta\WUSD_UKR_Shipping_Details;
use WooUkrainianShippingDelivery\App\Controllers\Ukrposhta\WUSD_UKR_Order_Processing;
use WooUkrainianShippingDelivery\App\Controllers\Ukrposhta\WUSD_UKR_Validation;
use WooUkrainianShippingDelivery\App\WCEXT\Ukrposhta\WC_UKR_WUSD_Woo_Shipping_Details;
use WooUkrainianShippingDelivery\App\WCEXT\Ukrposhta\WC_UKR_WUSD_Cargotype;

/**
 * Class for loading scripts, styles and dependencies
 */
class Loader{

    public function __construct(){
        add_action('admin_enqueue_scripts', array($this, 'wusd_load_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'wusd_frontend_load_scripts'));
    }

    public function wusd_frontend_load_scripts(){
        wp_enqueue_style( 'select2css', WUSD_PATH.'assets/js/select2/select2.min.css', false, '1.0', 'all' );
        wp_enqueue_script( 'select2', WUSD_PATH.'assets/js/select2/select2.min.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_script( 'wusd_frontend_script', WUSD_PATH . 'assets/js/frontend.min.js', array(), null, true );
        wp_enqueue_script( 'wusd_gmap_script', WUSD_PATH . 'assets/js/gmap.min.js', array(), null, true );
        wp_enqueue_style( 'wusd_styles', WUSD_PATH . 'assets/css/style-frontend.min.css' );
        wp_localize_script('wusd_frontend_script', 'ajaxurl', array(
            'url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('ajax_pp_form_nonce'),
        ));
    }

    /**
     * Loading scripts
     *
     * @return void
     */
    public function wusd_load_scripts(){
        wp_enqueue_style( 'select2css', WUSD_PATH.'assets/js/select2/select2.min.css', false, '1.0', 'all' );
        wp_enqueue_script( 'select2', WUSD_PATH.'assets/js/select2/select2.min.js', array( 'jquery' ), '1.0', true );
        wp_enqueue_style( 'wusd_styles', WUSD_PATH . 'assets/css/style.min.css' );
        wp_enqueue_script( 'wusd_script', WUSD_PATH . 'assets/js/main.min.js', array(), null, true );
        wp_localize_script('wusd-ajax', 'ajaxurl', array(
            'url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('ajax_pp_form_nonce'),
        ));
    }

    /**
     * Loading controllers
     *
     * @return void
     */
    public function wusd_load_dependencies(){
        (new WUSD_NP_Settings())->init();
        (new WUSD_NP_Get_Shipping_Fields())->init();
        (new WUSD_NP_Order_Processing())->init();
        (new WUSD_NP_Shipping_Details())->init();
        (new WUSD_NP_Validation())->init();
        (new WC_NP_WUSD_Woo_Shipping_Details())->init();
        (new WC_NP_WUSD_Cargotype())->init();

        /* (new WUSD_UKR_Settings())->init();
        (new WUSD_UKR_Get_Shipping_Fields())->init();
        (new WUSD_UKR_Order_Processing())->init();
        (new WUSD_UKR_Shipping_Details())->init();
        (new WUSD_UKR_Validation())->init();
        (new WC_UKR_WUSD_Woo_Shipping_Details())->init();
        (new WC_UKR_WUSD_Cargotype())->init(); */
    }

}