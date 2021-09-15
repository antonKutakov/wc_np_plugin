<h4 id=""><?php
    $result =  get_option('woocommerce_novaposhta_settings');
    if(!empty($result['title'])){
        echo esc_html_e($result['title'], WUSD_DOMAIN);
    }
    ?></h4>
    <h5>
        <?php
        if(!empty($result['subtitle'])){
            echo esc_html_e($result['subtitle'], WUSD_DOMAIN);
        }
        ?>
    </h5>
<p class="form-row form-row-wide">
    <span class="woocommerce-input-wrapper">
        <label for="wusd_area" class=""><?php esc_html_e('Область', WUSD_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
        <select name="wusd_area" id="wusd_area" class="wusd_fields wusd_area select " autocomplete="off" placeholder="Select your area">
        </select>
    </span>
</p>
<p class="form-row form-row-wide">
    <span class="woocommerce-input-wrapper">
        <label for="wusd_city" class=""><?php esc_html_e('Місто', WUSD_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
        <select name="wusd_city" id="wusd_city" class="wusd_fields wusd_city  select" autocomplete="off" >
        </select>
    </span>
</p>
<p class="form-row form-row-wide">
    <span class="woocommerce-input-wrapper">
        <label for="wusd_warehouse" class=""><?php esc_html_e('Відділення', WUSD_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
        <select name="wusd_warehouse" id="wusd_warehouse" class="wusd_fields wusd_warehouse  select" autocomplete="off" >
        </select>
    </span>
</p>
<p class="form-row form-row-wide">
    <span class="woocommerce-input-wrapper">
        <label for="wusd_shippingtype" class=""><?php esc_html_e('Тип доставки', WUSD_DOMAIN) ?><abbr class="required" title="required">*</abbr></label>
        <select name="wusd_shippingtype" id="wusd_shippingtype" class="wusd_fields wusd_shippingtype  select" autocomplete="off" >
            <option value="0" selected="selected">Выберите тип доставки</option>
            <option value="DoorsDoors">Двері-Двері</option>
            <option value="DoorsWarehouse">Двері-Склад</option>
            <option value="WarehouseWarehouse">Склад-Склад</option>
            <option value="WarehouseDoors">Склад-Двері</option>
        </select>
    </span>
</p>
<input type="hidden" name="cargotype" id="cargotype" value="<?php echo get_post_meta($pdt_id, "wusd-shipping-cargotype", true)?>">
<div id="checkout_weight" class="cart-extra-info">
    <p class="total-weight"> 
    <span>Загальна Вага: </span>
    <span id="total_int">
        <strong> 
            <span id="weight"> <?php echo $weight ?> </span>
            <span id="unit"> <?php echo $unit ?> </span>
        </strong>
    </span>
    </p>
</div>


