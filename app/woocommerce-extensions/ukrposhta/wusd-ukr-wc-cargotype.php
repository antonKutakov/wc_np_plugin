<?php

namespace WooUkrainianShippingDelivery\App\WCEXT\Ukrposhta;

class WC_UKR_WUSD_Cargotype {

    public function init(){
        add_action('woocommerce_product_options_shipping', array($this, 'wusd_add_product_cargotype'));
        add_action('woocommerce_process_product_meta', array($this, 'wusd_save_custom_field'));
    }

    /**
     * Add selector into product for cargo type
     *
     * @return void
     */
    public function wusd_add_product_cargotype(){
        $args = array(
            'id' => 'wusd-shipping-cargotype',
            'label' => __('Cargo Type', WUSD_DOMAIN),
            'class' => 'wusd-shipping-cargotype',
            'desc_tip' => true,
            'description' => __('Select product cargo type', WUSD_DOMAIN),
            'type' => 'select',
            'options' => array(
                'Cargo' => 'Вантаж',
                'Documents' => 'Документи',
                'TiresWheels' => 'Шини-диски',
                'Pallet' => 'Палети',
                'Parcel' => 'Посилка'
            )
        );

        \woocommerce_wp_select($args);
    }

    public function wusd_save_custom_field($post_id){
        $product = wc_get_product($post_id);
        $cargotype = isset($_POST['wusd-shipping-cargotype']) ? sanitize_text_field($_POST['wusd-shipping-cargotype']) : '';
        $product->update_meta_data('wusd-shipping-cargotype', $cargotype);
        $product->save();
    }

}