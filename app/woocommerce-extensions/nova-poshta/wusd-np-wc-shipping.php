<?php

use WooUkrainianShippingDelivery\App\Controllers\Novaposhta\WUSD_NP_Order_Processing;
use WooUkrainianShippingDelivery\App\DB\WUSD_DB;

add_action( "woocommerce_shipping_init", "wusd_wc_shipping_init" );
add_filter( "woocommerce_shipping_methods", "wusd_wc_shipping_method" );

function wusd_wc_shipping_init(){
    if(!class_exists('WC_WUSD_Woo_Shipping')){
        class WC_NP_WUSD_Woo_Shipping extends WC_Shipping_Method{

            public function __construct()
            {
                $this->id = 'nova_poshta_shipping';
                $this->method_title = __('Nova Poshta', WUSD_DOMAIN);
                $this->method_description = __('Nova Poshta shipping', WUSD_DOMAIN);

                $this->availability = 'including';
                $this->countries = array(
                    'UA'
                );
                $this->init();

                $this->title = $this->settings['title'];
                $this->subtitle = $this->settings['subtitle'];
                $this->enabled = $this->settings['enabled'];
                $this->myarea = $this->settings['myarea'];
                $this->mycity = $this->settings['mycity'];
                $this->mywarehouse = $this->settings['mywarehouse'];
            }

            public function init(){
                $this->init_form_fields();
                $this->init_settings();
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            public function init_form_fields(){

                $npdb = WUSD_DB::getInstance();

                $areas = $npdb->get_data("*", "novaposhta_areas");
                $areas_keys = [];
                $areas_values = [];

                $cities = $npdb->get_data("*", "novaposhta_cities");
                $cities_keys = [];
                $cities_values = [];

                $warehouses = $npdb->get_data("*", "novaposhta_warehouses");
                $warehouses_keys = [];
                $warehouses_values = [];

                foreach($cities as $city){
                    array_push($cities_keys, $city['Ref']);
                    array_push($cities_values, $city['Description']);
                }

                foreach($areas as $area){
                    array_push($areas_keys, $area['Ref']);
                    array_push($areas_values, $area['Description']);
                }

                foreach($warehouses as $warehouse){
                    array_push($warehouses_keys, $warehouse['Ref']);
                    array_push($warehouses_values, $warehouse['Description']);
                }

                $filled_areas = array_combine($areas_keys, $areas_values);
                $filled_cities = array_combine($cities_keys, $cities_values);
                $filled_warehouses = array_combine($warehouses_keys, $warehouses_values);

                $this->form_fields = array(
                    'enabled' => array(
                        'title' => __('Підключити', WUSD_DOMAIN),
                        'label' => __('Підключити Нову Пошту', WUSD_DOMAIN),
                        'type' => 'checkbox',
                        'description' => '',
                        'default' => 'no'
                    ),
                    'title' => array(
                        'title' => __('Нова Пошта', WUSD_DOMAIN),
                        'type' => 'text',
                        'description' => __('Назва способу доставки на сторінці чекауту', WUSD_DOMAIN),
                        'default' => __('Nova Poshta', WUSD_DOMAIN)
                    ),
                    'subtitle' => array(
                        'title' => __('Nova Poshta', WUSD_DOMAIN),
                        'type' => 'text',
                        'description' => __('Опис способу доставки на сторінці чекауту', WUSD_DOMAIN),
                        'default' => __('Nova Poshta ', WUSD_DOMAIN)
                    ),
                    'myarea' => array(
                        'title' => __('Область', WUSD_DOMAIN),
                        'description' => __('Замініть на сторінці налаштувань плагіну', WUSD_DOMAIN),
                        'default' => '0',
                        'type' => 'text'

                    ),
                    'mycity' => array(
                        'title' => __('Місто', WUSD_DOMAIN),
                        'type' => 'text',
                        'description' => __('Замініть на сторінці налаштувань плагіну', WUSD_DOMAIN),
                        'default' => '1',
                    ),
                    'mywarehouse' => array(
                        'title' => __('Відділення', WUSD_DOMAIN),
                        'type' => 'text',
                        'description' => __('Замініть на сторінці налаштувань плагіну', WUSD_DOMAIN),
                        'default' => '0'
                    ),
                    'api' => array(
                        'title' => __( 'API ключ', WUSD_DOMAIN ),
                        'type' => 'text',
                        'description' => __( 'API ключ з особистого кабінету НП', WUSD_DOMAIN ),
                        'default' => '18yfhia8rdh12o13418fdsd'
                    ),
                );
            }

            public function calculate_shipping($package = array()){
                global $woocommerce;

                $order_processing = new WUSD_NP_Order_Processing();
                $weight = $woocommerce->cart->cart_contents_weight;                
                $cost = $order_processing;
               
                $rate = array(
                    'id' => $this->id,
                    'label' => $this->title,
                    'cost' => WC()->session->get('new_shipping_cost'),
                    'calc_tax' => 'per_item'
                );

                $this->add_rate( $rate ); 
            }

        }
    }
}

function wusd_wc_shipping_method($methods){
    $methods['nova_poshta_shipping'] = 'WC_WUSD_Woo_Shipping';
    return $methods;
}