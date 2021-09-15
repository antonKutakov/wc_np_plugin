<?php

namespace WooUkrainianShippingDelivery\App;

class Render{

    /**
     * Render template
     *
     * @param string $template
     * @param array $vars
     * @param boolean $render
     * @return void
     */
    public static function make($template = "", $vars = array(), $subfolder = "", $render = true){
        // echo self::construct_file_path($template, $subfolder);
        if($render){
            if(file_exists(self::construct_file_path($template, $subfolder))){
                \extract($vars);
                ob_start();
                require_once self::construct_file_path($template, $subfolder);
                $content = ob_get_contents();
            }
        }
    }

    /**
     * Constructing file path
     *
     * @param string $template
     * @return void
     */
    private static function construct_file_path($template = "", $subfolder = ""){
        return dirname(__FILE__) . "/renders/$subfolder/" . WUSD_FILE_PREFIX . "-" . $template . "-" . "render" . ".php";
    }

}