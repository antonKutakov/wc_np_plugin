<div class="wusd-base-block">
    <div class="wusd-preloader">
        <img src="<?php echo WUSD_PATH . 'assets/images/ajax-loader.gif' ?>" alt="">
    </div>
    <div class="wusd-wrapper">
        <div class="wusd-header">
            <div class="wusd-wrapper">
                <div class="wusd-image">
                    <img src="<?php echo WUSD_PATH . 'assets/images/novaposhta-logo.png' ?>" alt="">
                </div>
                <div class="wusd-title">
                    <h1><?php echo esc_html_e('Нова пошта', WUSD_DOMAIN) ?></h1>
                </div>
            </div>
        </div>
        <div class="wusd-body">
            <div class="wusd-wrapper">
                <div class="wusd-form">
                    <form method="post" class="wusd-settings-form" id="wusd-settings-form">
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Підключити:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div class="input-box">
                                <input type="checkbox" autocomplete="off" value="1" name="enabled" id="enabled" <?php if($enabled == 'yes'): ?>  checked="checked" <?php endif; ?> >
                            </div>
                        </div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Назва:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div class="input-box">
                                <input type="text" autocomplete="off" name="title" id="title" value="<?php echo esc_html_e($title, WUSD_DOMAIN) ?>" placeholder="Nova Poshta">
                            </div>

                        </div>
                        <div class="info-text"><?php echo esc_html_e('Назва способу доставки на сторінці чекауту', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Опис:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div class="input-box">
                                <input type="text" autocomplete="off" name="subtitle" id="subtitle" value="<?php echo esc_html_e($subtitle, WUSD_DOMAIN) ?>" placeholder="Payment method">
                            </div>
                        </div>
                        <div class="info-text"><?php echo esc_html_e('Опис способу доставки на сторінці чекауту', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('API ключ:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div class="input-box">
                                <input type="text" autocomplete="off" name="api" id="api" value="<?php echo esc_html_e($api, WUSD_DOMAIN) ?>" placeholder="API key">
                            </div>
                        </div>
                        <div class="info-text"><?php echo esc_html_e('API ключ з особистого кабінету НП', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Область:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div class="input-box">
                                <select type="text" class="area ls " autocomplete="off" name="myarea" id="myarea" value="" placeholder="Select your area">
                                    <?php if(isset($myarea)):?>
                                        <option value="<?php echo $attr ?>" selected class="selected" ><?php esc_html_e($myarea, WUSD_DOMAIN) ?></option>
                                    <?php endif;?>
                                </select>
                                <div class="valid-notice-area"><?php esc_html_e('Будь ласка, виберіть область',WUSD_DOMAIN) ?></div>
                            </div>
                        </div>
                        <div class="info-text"><?php echo esc_html_e('Вкажіть область відправника для розрахунку вартості доставки', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Місто:', WUSD_DOMAIN) ?>
                                </p>
                            </div>
                            <div id="city-block" class="input-box">
                                <select type="text" class="city ls" autocomplete="off" name="mycity" id="mycity" value="" placeholder="Select your city">
                                </select>
                                <?php if(isset($mycity)): ?>
                                    <input type="hidden"  value="<?php echo esc_html_e($mycity, WUSD_DOMAIN) ?>" selected id="select" class="checked">
                                <?php else: ?>
                                    <input type="hidden" value="<?php echo esc_html__('Оберіть Місто', WUSD_DOMAIN) ?>" selected id="select">
                                <?php endif; ?>
                                <div class="valid-notice-city"><?php esc_html_e('Будь ласка, виберіть місто',WUSD_DOMAIN) ?></div>
                            </div>
                        </div>
                        <div class="info-text"><?php echo esc_html_e('Вкажіть місто відправника для розрахунку вартості доставки', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-label">
                                <p><?php echo esc_html_e('Відділення:', WUSD_DOMAIN) ?></p>
                            </div>
                            <div id="werehouse-block"  class="input-box">
                                <select type="text" class="werehouse" autocomplete="off" name="mywerehouse" id="mywerehouse" value="" placeholder="Select your werehouse">
                                    <?php if(isset($mywarehouse)): ?>
                                        <option value="<?php echo $warehouse_ref?>" selected >
                                            <?php esc_html_e($mywarehouse, WUSD_DOMAIN) ?>
                                        </option>
                                    <?php endif; ?>
                                </select>
                                <?php if(isset($mywarehouse)): ?>
                                    <input type="hidden"  value="<?php echo esc_html_e($mywarehouse, WUSD_DOMAIN) ?>" selected id="select_werehouse" class="checked">
                                <?php else: ?>
                                    <input type="hidden" value="<?php echo esc_html__('Оберіть Відділення', WUSD_DOMAIN) ?>" selected id="select_werehouse">
                                <?php endif; ?>
                                <div class="valid-notice-warehouse"><?php esc_html_e('Будь ласка, виберіть відділення',WUSD_DOMAIN) ?></div>
                            </div>
                        </div>
                        <div class="info-text"><?php echo esc_html_e('Вкажіть відділення відправника для розрахунку вартості доставки', WUSD_DOMAIN) ?></div>
                        <div class="wusd-form-row">
                            <div class="input-box">
                                <button type="submit" id="wusd-submit"><?php esc_html_e('Зберегти', WUSD_DOMAIN) ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="wusd-wrapper">
                <div class="wusd-load-box">
                    <form method="POST" class="load_addresses" id="load_addresses">
                        <div class="wusd-form-row">
                            <div class="input-box">
                                <button type="submit"  id="submit" ><?php esc_html_e('Синхронізувати Довідник Адрес НП', WUSD_DOMAIN) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

