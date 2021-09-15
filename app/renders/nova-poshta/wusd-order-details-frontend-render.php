<h2 class="woocommerce-column__title"><?php esc_html_e('Доставка Нова Пошта', WUSD_DOMAIN)?></h2>
    <section class="wusd_checkout_details">
        <div class="woocommerce-column woocommerce-column--1 ">
            <div class="detail_item">
                <span class="wusd_checkout_areа"><strong><?php esc_html_e('Область:', WUSD_DOMAIN)?></strong></span><span> <?php echo  '&nbsp ' . $areaOutput?></span>
            </div>
            <div class="detail_item">
                <span class="wusd_checkout_areа"><strong><?php esc_html_e('Місто:', WUSD_DOMAIN)?></strong></span><span> <?php echo '&nbsp ' . $cityOutput;?></span>
            </div>
            <div class="detail_item">
                <span class="wusd_checkout_areа"><strong><?php esc_html_e('Відділення:', WUSD_DOMAIN)?></strong></span><span> <?php echo '&nbsp' . $warehouseOutput;?></span>
            </div>
            <div class="detail_item">
                <span class="wusd_checkout_areа"><strong><?php esc_html_e('Тип доставки:', WUSD_DOMAIN)?></strong></span><span> <?php echo '&nbsp' . $shippingTypeRu;?></span>
            </div>
        </div>
    </section>


