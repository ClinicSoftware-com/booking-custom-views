<div class="row bs-wizard">

        <div class="col-xs-3 bs-wizard-step complete">
            <div class="text-center bs-wizard-stepnum"><?= $settings['booking_steps__step_bullets__text_over_1'] ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a title="Choose Services" href="<?= "{$domain_base}online-booking" ?>" class="bs-wizard-dot <?= ($settings['booking_steps__step_bullets__type'] == 'img' ? 'img" style="background-image: url('.$settings['booking_steps__step_bullets__img'].'); background-position: center; background-size: cover; background-repeat: no-repeat;"' : '"') ?>></a>
            <div class="bs-wizard-info text-center hidden-xs">
                <a href="<?= "{$domain_base}online-booking" ?>">
                    <?= __($settings['booking_steps__step_bullets__text_under_1']) ?>
                </a>
            </div>
            <div class="bs-wizard-info text-center visible-xs">
                <a href="<?= "{$domain_base}online-booking" ?>">
                    <?= str_replace(' ', '<br>', __($settings['booking_steps__step_bullets__text_under_1'])) ?>
                </a>
            </div>
        </div>

        <div class="col-xs-3 bs-wizard-step complete">
            <div class="text-center bs-wizard-stepnum"><?= $settings['booking_steps__step_bullets__text_over_2'] ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="<?= "{$domain_base}online-booking/step2" ?>" class="bs-wizard-dot <?= ($settings['booking_steps__step_bullets__type'] == 'img' ? 'img" style="background-image: url('.$settings['booking_steps__step_bullets__img'].'); background-position: center; background-size: cover; background-repeat: no-repeat;"' : '"') ?>></a>
            <div class="bs-wizard-info text-center hidden-xs">
                <a href="<?= "{$domain_base}online-booking/step2" ?>">
                    <?= __($settings['booking_steps__step_bullets__text_under_2']) ?>
                </a>
            </div>
            <div class="bs-wizard-info text-center visible-xs">
                <a href="<?= "{$domain_base}online-booking/step2" ?>">
                    <?= str_replace(' ', '<br>', __($settings['booking_steps__step_bullets__text_under_2'])) ?>
                </a>
            </div>
        </div>

        <div class="col-xs-3 bs-wizard-step active">
            <div class="text-center bs-wizard-stepnum"><?= $settings['booking_steps__step_bullets__text_over_3'] ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="<?= "{$domain_base}online-booking/step3" ?>" class="bs-wizard-dot <?= ($settings['booking_steps__step_bullets__type'] == 'img' ? 'img" style="background-image: url('.$settings['booking_steps__step_bullets__img'].'); background-position: center; background-size: cover; background-repeat: no-repeat;"' : '"') ?>></a>
            <div class="bs-wizard-info text-center hidden-xs">
                <a href="<?= "{$domain_base}online-booking/step3/{$booking_option_id}" ?>">
                    <?= $settings['booking_steps__step_bullets__text_under_3'] ?></a>
            </div>
            <div class="bs-wizard-info text-center visible-xs">
                <a href="<?= "{$domain_base}online-booking/step3/{$booking_option_id}" ?>">
                    <?= str_replace(' ', '<br>', $settings['booking_steps__step_bullets__text_under_3']) ?>
                </a>
            </div>
        </div>

        <div class="col-xs-3 bs-wizard-step disabled">
            <div class="text-center bs-wizard-stepnum"><?= $settings['booking_steps__step_bullets__text_over_4'] ?></div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="bs-wizard-dot <?= ($settings['booking_steps__step_bullets__type'] == 'img' ? 'img" style="background-image: url('.$settings['booking_steps__step_bullets__img'].'); background-position: center; background-size: cover; background-repeat: no-repeat;"' : '"') ?>></a>
            <div class="bs-wizard-info text-center"><?= __($settings['booking_steps__step_bullets__text_under_4']) ?></div>
        </div>
        

        <?php
        if (!empty($s_staff_data) && ($no_payment_form_enabled || $ob_payment_at_salon_enabled)) { ?>
            <div class="col-xs-12 visible-xs" style="padding:0 5px;">
                <button onclick="$('#ob_payment_btn_at_salon').click();" class="btn btn-large btn-info ob_payment_btn" style="margin:20px 0 -20px 0;">COMPLETE ORDER</button>
            </div>
        <?php } ?>
    </div>

<style>
    .progress-bar {
        background-color: <?= $this->online_settings_model->item("booking_steps__step_bullets__color") ?> !important;
    }
</style>