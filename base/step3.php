<?php
if ($_SERVER['SERVER_NAME'] == "online.localhost") {
    $no_payment_form_enabled = false;
}
$this->load->view('navigation');
?>

    <div class="container theme-showcase main_content online_booking" role="main">

        <?php if (empty($is_embed)) { ?>
            <div class="page-header">
                <h1><?= __("Online Booking"); ?></h1>
            </div>
        <?php } ?>

        <?php $this->flash->printMessages(); ?>

        <?php $this->load->view('pages/booking/booking_progress_step3'); ?>

        <div class="row">

            <div class="col-md-9">
                <?php
                if(!empty($shop_cart) && !empty($shop_cart_total) && $shop_cart_total > 0){
                    $cart_total += number_format($shop_cart_total, 2);
                }
                ?>

                <?php if (!$no_payment_form_enabled && $deposit_value > 0) { ?>
                    <div class="alert alert-warning" role="alert" style="font-weight:bold; color:#c09853;">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        A deposit of <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?>
                        is required to complete this booking
                    </div>
                <?php } ?>

                <?php
                $app_num = 1;
                foreach ($appointments as $appointment) {
                    ?>
                    <div class="ob_appointment">
                    <span class="ob_appointment_title">
                    <?php
                    if ($this->settings['usa_date_format']):
                        echo __("Appointment") . " {$app_num}: &nbsp;"
                            . date('F jS Y, h:i A', $appointment['ts_start']) . ' - '
                            . date('h:i A', $appointment['ts_start'] + $appointment['duration_m'] * 60)
                            . " (" . $this->utils->min_to_hours($appointment['duration_m']) . ") with {$appointment['staff_nickname']} at {$salon_name}";
                    else:
                        echo __("Appointment") . " {$app_num}: &nbsp;"
                            . date('d M Y, h:i A', $appointment['ts_start']) . ' - '
                            . date('h:i A', $appointment['ts_start'] + $appointment['duration_m'] * 60)
                            . " (" . $this->utils->min_to_hours($appointment['duration_m']) . ") with {$appointment['staff_nickname']} at {$salon_name}";

                    endif;
                    ?>
                    </span>
                        <ul>
                            <?php
                            foreach ($appointment['items'] as $item) {
                                echo '<li>' . $item['title'];
                                if (!empty($item['pt_area_interested'])) {
                                    echo '<br><span style="margin-left:30px; color:#999;">Area Interested: ' . htmlentities($item['pt_area_interested']) . '</span>';
                                }
                                if (!empty($item['groupon_code'])) {
                                    echo '<br><span style="margin-left:30px; color:#999;">Groupon Code: ' . htmlentities($item['groupon_code']) . '</span>';
                                }
                                echo '</li>';
                            }
                            ?>
                        </ul>

                        <?php if(!empty($shop_cart)) : ?>
                            <ul class="cart-shop-products">
                                <li>
                                    <span class="cart-shop-total"><?php echo __('Services Total'); ?>:</span>
                                    <span class="cart-shop-total-value"><?php echo CURRENCY_PREFIX . number_format($cart_total_before, 2) . CURRENCY_SUFFIX; ?></span>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <?php
                    $app_num++;
                }
                ?>

                <textarea id="set_booking_notes" rows="3" class="form-control" style="resize: vertical;" placeholder="Notes" autofocus></textarea>

                <?php if (!empty($shop_cart)): ?>
                    <div class="products-in-cart">
                        <p>Selected products:</p>
                        <ul class="cart-shop-products">
                            <?php foreach ($shop_cart as $key => $item): ?>
                                <li>
                                    <span class="product-title"><?php echo $item['name']; ?></span>
                                    <span class="product-quantity">Qty: <?php echo $item['quantity']; ?></span>
                                    <span class="product-price">Unit Price: <?php echo CURRENCY_PREFIX . number_format($item['price_incl_tax'], 2) . CURRENCY_SUFFIX; ?> (incl taxes)</span>
                                    <span class="product-cart-remove">
                                        <a class="btn btn-sm btn-danger" href="javascript:" onclick="removeShopCartItem(<?php echo $key; ?>);">Remove</a>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <span class="cart-shop-total">Products:</span>
                                <span class="cart-shop-total-value"><?php echo CURRENCY_PREFIX . number_format($shop_cart_total, 2) . CURRENCY_SUFFIX; ?></span>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($coupons_enabled) && ($cart_total > 0 || !empty($coupon_promotion_type_enabled))) { ?>
                    <hr>

                    <div class="panel panel-default">
                        <div class="panel-heading"><?= __("Coupons"); ?></div>
                        <table class="table">

                            <?php if (!empty($coupons_list)) {
                                foreach ($coupons_list as $coupon) { ?>
                                    <tr>
                                        <td align="left"><?php echo $coupon['code']; ?></td>
                                        <td align="right"><?php if ($coupon['type'] != 'promotion') echo CURRENCY_PREFIX . number_format($coupon['price'], 2) . CURRENCY_SUFFIX; ?></td>
                                        <td align="right" width="110">
                                            <form method="post" role="form">
                                                <input type="hidden" name="action" value="del_coupon">
                                                <input type="hidden" name="coupon_id"
                                                       value="<?php echo $coupon['id']; ?>">
                                                <input class="btn btn-sm btn-danger" type="submit" value="Remove"
                                                       style="width:95px;">
                                            </form>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>

                            <tr>
                                <td align="left" colspan="3">
                                    <form method="post" role="form" class="form-inline">
                                        <input type="hidden" name="action" value="add_coupon">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <input class="form-control" name="coupon_code"
                                                           placeholder="<?= __("Enter Coupon Code") ?>"
                                                           style="width:100%;"/>
                                                </td>
                                                <td align="right" width="110">
                                                    <input class="btn btn-sm btn-success" type="submit"
                                                           value="<?= __("Add Coupon"); ?>" style="width:95px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>

                <?php } ?>

                <div style="height:20px;"></div>

                <?php if (!empty($membership_data)) { ?>
                    <h4>Selected
                        membership: <?php echo htmlentities($membership_data['name']); ?> <?php if (!empty($membership_data['is_two_for_one_offer_enabled'])) echo ' (two for one offer)'; ?></h4>
                    <p><?php echo htmlentities($membership_data['description']); ?></p>

                    <ul>
                        <?php foreach ($selected_membership_services_map as $membership_service) { ?>

                            <li><?php echo htmlentities($membership_service['title']); ?>: &nbsp;

                                <?php if (!empty($membership_service['u_price_incl_tax']) && $membership_service['u_price_incl_tax'] > $membership_service['price_incl_tax']) { ?>
                                    <strike><?php echo CURRENCY_PREFIX . number_format($membership_service['u_price_incl_tax'], 2) . CURRENCY_SUFFIX; ?></strike>&nbsp;
                                <?php } ?>

                                <?php echo CURRENCY_PREFIX . number_format($membership_service['price_incl_tax'], 2) . CURRENCY_SUFFIX; ?>
                            </li>

                        <?php } ?>
                    </ul>

                    <div style="height:30px;"></div>
                <?php } ?>

                <?php if (!empty($membership_data)) { ?>
                    <ul class="ob_summary">

                        <li class="ob_summary_total" style="margin:5px 0;">
                            Monthly membership price (pay at the clinic):

                            <?php if (!empty($monthly_membership_price_undiscounted) && $monthly_membership_price_undiscounted > $monthly_membership_price) { ?>
                                <strike><?php echo CURRENCY_PREFIX . number_format($monthly_membership_price_undiscounted, 2) . CURRENCY_SUFFIX; ?></strike>&nbsp;
                            <?php } ?>

                            <?php echo CURRENCY_PREFIX . number_format($monthly_membership_price, 2) . CURRENCY_SUFFIX; ?>
                        </li>

                        <li class="ob_summary_total" style="margin:5px 0;">
                            Total membership price (pay at the clinic):

                            <?php if (!empty($total_membership_price_undiscounted) && $total_membership_price_undiscounted > $total_membership_price) { ?>
                                <strike><?php echo CURRENCY_PREFIX . number_format($total_membership_price_undiscounted, 2) . CURRENCY_SUFFIX; ?></strike>&nbsp;
                            <?php } ?>

                            <?php echo CURRENCY_PREFIX . number_format($total_membership_price, 2) . CURRENCY_SUFFIX; ?>
                        </li>


                        <li class="ob_summary_total" style="margin:5px 0;">
                            Payment plan:
                            <?php if ($payment_plan == 'full') {
                                echo ' Full payment';
                            } elseif ($payment_plan == -1) {
                                echo ' Monthly, last day of the month';
                            } else {
                                echo ' Monthly, every ' . number_ordinal($payment_plan) . ' day of the month';
                            }
                            ?>
                        </li>

                    </ul>


                <?php } else { ?>
                    <ul class="ob_summary">

                        <?php if ($this->settings['show_prices_excl_tax_till_checkout']): ?>
                            <li class="ob_summary_total">
                                Services Cost:
                                <?php echo CURRENCY_PREFIX . number_format($cart_total_excl_tax, 2) . CURRENCY_SUFFIX; ?>
                            </li>
                            <li class="ob_summary_total">
                                Tax:
                                <?php echo CURRENCY_PREFIX . number_format($cart_total - $cart_total_excl_tax, 2) . CURRENCY_SUFFIX; ?>
                            </li>
                        <?php endif; ?>

                        <li class="ob_summary_total">
                            <?php if ($this->settings['show_prices_excl_tax_till_checkout']): ?>
                                Total Price (including TAX):
                            <?php else: ?>
                                Total Price:
                            <?php endif; ?>
                            <?php if (isset($has_individual_deposit) && $has_individual_deposit && !empty($individual_deposit_cart_total)) : ?>
                                <?php echo CURRENCY_PREFIX . number_format($individual_deposit_cart_total, 2) . CURRENCY_SUFFIX; ?>
                            <?php else: ?>
                                <?php if (!empty($cart_total_before) && $cart_total_before > $cart_total) { ?>
                                    <strike><?php echo CURRENCY_PREFIX . number_format($cart_total_before, 2) . CURRENCY_SUFFIX; ?></strike>&nbsp;
                                <?php } ?>

                                <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?>
                            <?php endif; ?>

                            <?php if (!empty($currency_modifier)) { ?>
                                <span style="margin-right: 1rem; background-color: #e1e1e1; padding: 0.4rem 0.5rem; border-radius: 0.25rem; font-size: 1.4rem;">
                                    <?= $secondary_currency . " " . number_format($currency_modifier * $cart_total, 2) ?>
                                </span>
                            <?php } ?>
                        </li>


                        <?php if ($deposit_value > 0 || $has_individual_deposit) { ?>
                            <li class="ob_summary_deposit">
                                <?= __("Deposit Due"); ?>
                                : <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?>

                                <?php if (!empty($currency_modifier)) { ?>
                                    <span style="margin-right: 1rem; background-color: #e1e1e1; padding: 0.4rem 0.5rem; border-radius: 0.25rem; font-size: 1.4rem;">
                                        <?= $secondary_currency . " " . number_format($currency_modifier * $deposit_value, 2) ?>
                                    </span>
                                <?php } ?>
                            </li>
                        <?php } ?>

                    </ul>
                <?php } ?>

                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                    <hr>

                    <div style="margin-bottom:20px;" id="client_terms_agreement_cb_container">
                        <label>
                            <input type="checkbox" class="toggle-check-input" id="client_terms_agreement_cb"
                                <?php if (!empty($ob_step3_terms_checkbox_checked)) echo ' checked'; ?>
                            />
                            <span class="toggle-check-text"></span>

                            <?php if ($this->language_code == 'ro') { ?>
                                &nbsp;<?= __("I have read and agree with the") ?> <a target="_blank"
                                                                                     href="<?= $domain_base; ?>terms-conditions"><?= __("Terms And Conditions") ?></a>,
                                <a href="<?= $domain_base; ?>confidentiality_policy"><?= __("Privacy Policy") ?></a> <?= __("and") ?>
                                <a href="<?= $domain_base; ?>customer_agreement"><?= __("Customer Agreement") ?></a>
                            <?php } else { ?>
                                &nbsp;<?= __("I have read and agree with the") ?> <a target="_blank"
                                                                                     href="<?php echo $domain_base; ?>terms-conditions"><?= __("Terms And Conditions") ?></a>
                            <?php } ?>

                        </label>
                    </div>
                <?php } ?>

            </div>

            <div class="col-md-3 ob_payment" style="position: relative;">

                <style>

                    #main-payment-form-wrapper-loader {
                        position: absolute;
                        left: 0;
                        right: 0;
                        top: 0;
                        bottom: 0;
                        background-color: #00000078;
                        display: flex;
                        flex-flow: column;
                        justify-content: center;
                        align-items: center;
                    }

                    .loading {
                        width: 1.5em;
                        height: 1.5em;
                        border-radius: 50%;
                        box-shadow: 0 -3em rgba(255, 255, 255, 1),
                        2.25em -2.25em rgba(255, 255, 255, 0.875),
                        3em 0 rgba(255, 255, 255, 0.75),
                        2.25em 2.25em rgba(255, 255, 255, 0.625),
                        0 3em rgba(255, 255, 255, 0.5),
                        -2.25em 2.25em rgba(255, 255, 255, 0.375),
                        -3em 0 rgba(255, 255, 255, 0.25),
                        -2.25em -2.25em rgba(255, 255, 255, 0.125);
                        animation: spin 1.2s linear infinite;
                    }

                    @keyframes spin {
                        100% {
                            transform: rotate(-360deg)
                        }
                    }

                </style>

                <script>
                    function showPaymentLoading() {
                        document.getElementById(`main-payment-form-wrapper-loader`).classList.remove(`hidden`);
                    }

                    function hidePaymentLoading() {
                        document.getElementById(`main-payment-form-wrapper-loader`).classList.add(`hidden`);
                    }
                </script>

                <div id="main-payment-form-wrapper-loader" class="hidden">
                    <div class="loading"></div>
                </div>

                <div id="ob_payment_section">

                    <form id="ob_payment_form_main" action="<?php echo $domain_base; ?>online-booking/step4"
                          method="post" onkeypress="return event.keyCode != 13;" onsubmit="return false;"
                          autocomplete="new-password">

                        <input type="hidden" name="action" value="do_booking">
                        <input type="hidden" name="booking_option_id" value="<?php echo $booking_option_id; ?>">
                        <input type="hidden" name="booking_notes" value="">
                        <input type="hidden" name="bt_card" value="">
                        <input type="hidden" name="stripe_card" value="">
                        <input type="hidden" id="__stripe_payment_id" name="stripe_payment_id" value="">
                        <input type="hidden" name="payment_type" value="">
                        <input type="hidden" name="cc_processor" value="<?php echo $ob_payment_card_processor; ?>">
                        <input type="hidden" name="has_individual_deposit"
                               value="<?php echo(isset($has_individual_deposit) ? $has_individual_deposit : 0); ?>">
                        <input type="hidden" name="individual_deposit_value"
                               value="<?php echo(isset($individual_deposit_value) ? $individual_deposit_value : ''); ?>">

                        <input type="hidden" name="lh" id="step3_lh" value=""/>
                        <input type="hidden" name="shop_cart" id="shop_cart" value='<?php echo json_encode($shop_cart); ?>'/>
                        <script>
                            $(function () {
                                if (location.hash) {
                                    $('#step3_lh').val(location.hash);
                                }
                            });
                        </script>

                        <?php if (!empty($stripe_enabled) && empty($this->online_settings_model->item("stripe_shop_only_enabled"))) { ?>
                            <input type="hidden" name="stripe_token" value="">
                        <?php } ?>

                        <?php if (!empty($ob_paymentsense_ce_enabled)) { ?>
                            <input type="hidden" name="paymentsense_ec_tx_uuid" value="">
                            <input type="hidden" name="paymentsense_ec_access_token" value="">
                            <input type="hidden" name="paymentsense_ec_tx_data_status_code" value="">
                            <input type="hidden" name="paymentsense_ec_tx_data_auth_code" value="">
                            <input type="hidden" name="paymentsense_ec_tx_data_message" value="">
                        <?php } ?>

                        <?php if (!empty($paypal_express_checkout_enabled)) { ?>
                            <input type="hidden" name="pp_ec_payment_id" value="">
                            <input type="hidden" name="pp_ec_payer_id" value="">
                        <?php } ?>

                        <?php if ($credit_card_payment_enabled && $ob_payment_card_processor == 'paypal') { ?>
                            <input type="hidden" name="cc_number" value="">
                            <input type="hidden" name="cc_type" value="">
                            <input type="hidden" name="cc_expiry" value="">
                            <input type="hidden" name="cc_first_name" value="">
                            <input type="hidden" name="cc_last_name" value="">
                            <input type="hidden" name="cc_cvc" value="">
                        <?php } ?>

                        <?php if ($credit_card_payment_enabled && $ob_payment_card_processor == 'twocheckout') { ?>
                            <input type="hidden" name="2co_data" value="">
                            <input type="hidden" name="2co_name" value="">
                            <input type="hidden" name="2co_addr_line1" value="">
                            <input type="hidden" name="2co_city" value="">
                            <input type="hidden" name="2co_state" value="">
                            <input type="hidden" name="2co_zip_code" value="">
                            <input type="hidden" name="2co_country" value="">
                        <?php } ?>

                        <?php if ($credit_card_payment_enabled && $ob_payment_card_processor == 'netbanx') { ?>
                            <input type="hidden" name="card_number" value="">
                            <input type="hidden" name="card_exp_month" value="">
                            <input type="hidden" name="card_exp_year" value="">
                            <input type="hidden" name="card_cvv" value="">
                            <input type="hidden" name="card_first_name" value="">
                            <input type="hidden" name="card_last_name" value="">
                            <input type="hidden" name="card_email" value="">
                            <input type="hidden" name="card_billing_country" value="">
                            <input type="hidden" name="card_billing_state" value="">
                            <input type="hidden" name="card_billing_city" value="">
                            <input type="hidden" name="card_billing_street" value="">
                            <input type="hidden" name="card_billing_street2" value="">
                            <input type="hidden" name="card_billing_zip" value="">
                            <input type="hidden" name="card_billing_phone" value="">
                        <?php } ?>

                        <?php if ($phone_nr_required) { ?>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                       placeholder="" pattern="[0-9]*" data-numeric=""
                                       autofocus <?php if (empty($s_staff_data)) echo ' required'; ?>>
                                <p id="phone_number_required_message" style="margin-top:5px;">Please enter your phone
                                    number as we may need contact you if there are any changes to your booking.</p>
                            </div>
                            <script>
                                var validatePhoneNumber = function () {
                                    var $main_form = $('#ob_payment_form_main');
                                    var phone_number = $('#phone_number', $main_form).val();
                                    if (!phone_number || !phone_number.length || isNaN(phone_number)) {
                                        $('#phone_number_required_message', $main_form).css('color', '#ff0000');
                                        $('#phone_number', $main_form).focus();
                                        return false;
                                    }
                                    return true;
                                }
                            </script>
                        <?php } ?>

                    </form>

                    <?php if (!$no_payment_form_enabled) { ?>

                        <?php // Braintree
                        if (!empty($braintree_enabled) && !empty($this->settings_model->item("ob_account_payment_methods_card_enabled"))) {
                            $this->load->view('pages/booking/braintree_payment', $this->view_data);
                        }
                        ?>

                        <?php // Stripe Saved Payment methods
                        if (!empty($this->settings_model->item("ob_account_payment_methods_card_stripe_enabled")) && empty($this->online_settings_model->item("stripe_shop_only_enabled"))) {
                            $this->load->view('pages/booking/stripe_payment_methods', $this->view_data);
                        }
                        ?>

                        <!-- Card Form -->
                        <?php if ($credit_card_payment_enabled) { ?>

                        <?php if ($ob_payment_card_processor == 'twocheckout') { ?>
                        <!-- 2Checkout Card Form -->
                        <script>
                            var twoCheckoutRetryCount = 0;
                            var twoCheckoutPubKeyIsLoaded = false;
                            var twoCheckoutBillingAddress = {};

                            var showPaymentProgressInd = function () {
                                $('#ob_payment_section').hide();
                                $('#ob_load_indicator').show();
                            }

                            var hidePaymentProgressInd = function () {
                                $('#ob_load_indicator').hide();
                                $('#ob_payment_section').show();
                            }

                            var twoCheckoutSuccessCallback = function (data) {
                                data['billingAddr'] = twoCheckoutBillingAddress;

                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='2co_data']", $main_form).val(JSON.stringify(data, null));

                                $main_form[0].submit();
                                return false;
                            };

                            var twoCheckoutErrorCallback = function (data) {
                                if (data.errorCode === 200) { // ajax call failed, retrying request

                                    if (twoCheckoutRetryCount > 5) {
                                        twoCheckoutRetryCount = 0;
                                        alert("Could not verify the credit card data you have provided. \nPlease try again.");
                                        hidePaymentProgressInd();
                                        return false;
                                    }

                                    ++twoCheckoutRetryCount;

                                    if ($("#ob_payment_form_main input[name='payment_type']").val() == 'cc_deposit') {
                                        $('#ob_payment_btn_2co_cc_deposit').click();
                                        return false;
                                    }

                                    if ($("#ob_payment_form_main input[name='payment_type']").val() == 'cc_total') {
                                        $('#ob_payment_btn_2co_cc_total').click();
                                        return false;
                                    }

                                } else {
                                    alert(data.errorMsg);
                                    hidePaymentProgressInd();
                                }
                            };

                            var submitCCPayment2CO = function (event) {

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                showPaymentProgressInd();

                                var $twocheckout_form = $('#cc_payment_form_2co');

                                var args = {
                                    sellerId: "<?php echo $twocheckout_seller_id;?>",
                                    publishableKey: "<?php echo $twocheckout_publishable_key;?>",
                                    ccNo: $('#2co_cc', $twocheckout_form).val(),
                                    cvv: $('#2co_cvc', $twocheckout_form).val(),
                                    expMonth: $('#2co_exp_month', $twocheckout_form).val(),
                                    expYear: $('#2co_exp_year', $twocheckout_form).val()
                                };

                                twoCheckoutBillingAddress = {
                                    'name': $('#2co_name', $twocheckout_form).val(),
                                    'email': $('#2co_email', $twocheckout_form).val(),
                                    'country': $('#2co_country', $twocheckout_form).val(),
                                    'state': $('#2co_state', $twocheckout_form).val(),
                                    'city': $('#2co_city', $twocheckout_form).val(),
                                    'addrLine1': $('#2co_addr_line1', $twocheckout_form).val(),
                                    'addrLine2': $('#2co_addr_line2', $twocheckout_form).val(),
                                    'zipCode': $('#2co_zip_code', $twocheckout_form).val()
                                };

                                // request token
                                if (twoCheckoutPubKeyIsLoaded) {
                                    TCO.requestToken(twoCheckoutSuccessCallback, twoCheckoutErrorCallback, args);
                                } else { // load public encryption key
                                    TCO.loadPubKey('<?php echo empty($twocheckout_sandbox) ? 'production' : 'sandbox';?>', function () {
                                        twoCheckoutPubKeyIsLoaded = true;
                                        TCO.requestToken(twoCheckoutSuccessCallback, twoCheckoutErrorCallback, args);
                                    });
                                }

                                return false;
                            };

                            $(function () {
                                $('.ob_payment_btn_2co').click(function () {
                                    var $main_form = $('#ob_payment_form_main');
                                    $("input[name='cc_processor']", $main_form).val('twocheckout');
                                    $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                    $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());
                                });
                            });
                        </script>
                        <form id="cc_payment_form_2co" onkeypress="return event.keyCode != 13;"
                              onsubmit="return submitCCPayment2CO();">
                            <div class="form-group">
                                <label for="2co_cc">Card Number</label>
                                <input type="text" class="form-control" id="2co_cc" placeholder="•••••••••••••••••"
                                       pattern="[0-9]*" data-numeric="" autocomplete="new-password" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_exp_month">Card Expiration Date (MM / YYYY)</label>
                                <div class="clearfix"></div>
                                <input type="text" class="form-control" style="width:49%; float:left;"
                                       id="2co_exp_month" size="2" placeholder="MM" pattern="[0-9]*" data-numeric=""
                                       required/>
                                <input type="text" class="form-control" style="width:49%; float:right;"
                                       id="2co_exp_year" size="4" placeholder="YYYY" pattern="[0-9]*" data-numeric=""
                                       required/>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="2co_cvc">Card Verification Code</label>
                                <input type="text" class="form-control" id="2co_cvc" placeholder="CVC" pattern="[0-9]*"
                                       data-numeric="" autocomplete="new-password" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_name">Card Holder Name</label>
                                <input type="text" class="form-control" id="2co_name" placeholder="Name"
                                       value="<?php echo trim("{$this->customer_data['name']} {$this->customer_data['surname']}"); ?>"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_email">Email</label>
                                <input type="text" class="form-control" id="2co_email" placeholder="Email"
                                       value="<?php echo $this->customer_data['email']; ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_country">Country</label>
                                <input type="text" class="form-control" id="2co_country" placeholder="Country"
                                       value="<?php echo $twocheckout_default_country; ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_state">State</label>
                                <input type="text" class="form-control" id="2co_state" placeholder="State"
                                       value="<?php echo $twocheckout_default_state; ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_city">City</label>
                                <input type="text" class="form-control" id="2co_city" placeholder="City"
                                       value="<?php echo $twocheckout_default_city; ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_addr_line1">Address Line 1</label>
                                <input type="text" class="form-control" id="2co_addr_line1" placeholder="Address Line 1"
                                       value="<?php echo $this->customer_data['address']; ?>" required/>
                            </div>
                            <div class="form-group">
                                <label for="2co_addr_line2">Address Line 2 (optional)</label>
                                <input type="text" class="form-control" id="2co_addr_line2"
                                       placeholder="Address Line 2 (optional)"/>
                            </div>
                            <div class="form-group">
                                <label for="2co_zip_code">ZIP / PostCode</label>
                                <input type="text" class="form-control" id="2co_zip_code" placeholder="ZIP / PostCode"
                                       value="<?php echo $this->customer_data['postcode']; ?>" required/>
                            </div>

                            <?php if ($deposit_value > 0) { ?>
                                <button type="submit" id="ob_payment_btn_2co_cc_deposit"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_2co"
                                        data-payment-type="cc_deposit">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay") ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit") ?>
                                </button>
                            <?php } ?>

                            <?php if ($ob_payment_card_full_enabled && $cart_total > 0) { ?>
                                <button type="submit" id="ob_payment_btn_2co_cc_total"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_2co"
                                        data-payment-type="cc_total">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay") ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price") ?>
                                </button>
                            <?php } ?>

                        </form>
                        <script>

                        </script>
                        <!-- [end] 2Checkout Card Form -->
                    <?php } ?>

                    <?php if ($ob_payment_card_processor == 'paypal' && empty($paypal_express_checkout_enabled)) { ?>
                        <!-- PayPal Card Form -->
                        <script>
                            var submitCCPaymentPaypal = function (event) {

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                var $main_form = $('#ob_payment_form_main');
                                var $paypal_form = $('#cc_payment_form_paypal');

                                // copy values from paypal form to main form
                                var list = ['cc_number', 'cc_type', 'cc_expiry', 'cc_first_name', 'cc_last_name', 'cc_cvc'];
                                for (var i in list) {
                                    $("input[name='" + list[i] + "']", $main_form).val($('#' + list[i], $paypal_form).val());
                                }

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            };

                            $(function () {
                                $('.ob_payment_btn_paypal_card').click(function () {
                                    var $main_form = $('#ob_payment_form_main');
                                    $("input[name='cc_processor']", $main_form).val('paypal');
                                    $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                    $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());
                                });
                            });
                        </script>
                        <form id="cc_payment_form_paypal" onkeypress="return event.keyCode != 13;"
                              onsubmit="return submitCCPaymentPaypal();">
                            <div class="form-group">
                                <label for="cc_number">Card Number</label>
                                <input type="text" size="50" class="form-control" id="cc_number" name="cc_number"
                                       placeholder="•••••••••••••••••" pattern="[0-9]*" data-numeric=""
                                       autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="cc_type">Card Type</label>
                                <select class="form-control" id="cc_type" name="cc_type">
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">MasterCard</option>
                                    <option value="discover">Discover</option>
                                    <option value="amex">AmericanExpress</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cc_expiry">Expires</label>
                                <input type="text" size="50" class="form-control" id="cc_expiry" name="cc_expiry"
                                       placeholder="MM/YY" pattern="[0-9\/]*" autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="cc_first_name">Card First Name</label>
                                <input type="text" size="50" class="form-control" id="cc_first_name"
                                       name="cc_first_name" pattern="[A-Za-z -]*" required>
                            </div>
                            <div class="form-group">
                                <label for="cc_last_name">Card Last Name</label>
                                <input type="text" size="50" class="form-control" id="cc_last_name" name="cc_last_name"
                                       pattern="[A-Za-z -]*" required>
                            </div>
                            <div class="form-group">
                                <label for="cc_cvc">Card Code</label>
                                <input type="text" size="50" class="form-control" id="cc_cvc" name="cc_cvc"
                                       placeholder="CVV" pattern="\d*" data-numeric="" autocomplete="new-password"
                                       required>
                            </div>

                            <?php if ($deposit_value > 0) { ?>
                                <button type="submit"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_paypal_card"
                                        data-payment-type="cc_deposit">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                                </button>
                            <?php } ?>

                            <?php if ($ob_payment_card_full_enabled && $cart_total > 0) { ?>
                                <button type="submit"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_paypal_card"
                                        data-payment-type="cc_total">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                                </button>
                            <?php } ?>

                        </form>
                        <!-- [end] PayPal Card Form -->
                    <?php } ?>


                    <?php if ($ob_payment_card_processor == 'netbanx') { ?>
                        <!-- NETBANX Card Form -->
                        <script>
                            var submitCCPaymentNETBANX = function (event) {

                                var $main_form = $('#ob_payment_form_main');
                                var $netbanx_form = $('#cc_payment_form_netbanx');

                                var cc_fields = [
                                    'card_number', 'card_exp_month', 'card_exp_year', 'card_cvv', 'card_first_name', 'card_last_name',
                                    'card_email', 'card_billing_country', 'card_billing_state', 'card_billing_city', 'card_billing_street',
                                    'card_billing_street2', 'card_billing_zip', 'card_billing_phone'
                                ];

                                // copy values from netbanx form to main form
                                for (var i = 0; i < cc_fields.length; i++) {

                                    var cc_field_name = cc_fields[i];

                                    var $cc_field = $('#' + cc_field_name, $netbanx_form);
                                    if (!$cc_field.length) continue;

                                    var cc_field_value = $cc_field.val();
                                    if (!cc_field_value) continue;

                                    $("input[name='" + cc_field_name + "']", $main_form).val(cc_field_value);
                                }

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            };

                            $(function () {
                                $('.ob_payment_btn_netbanx_card').click(function () {
                                    var $main_form = $('#ob_payment_form_main');
                                    $("input[name='cc_processor']", $main_form).val('netbanx');
                                    $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                    $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());
                                });
                            });
                        </script>
                        <form id="cc_payment_form_netbanx" onkeypress="return event.keyCode != 13;"
                              onsubmit="return submitCCPaymentNETBANX();">
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input type="text" maxlength="20" class="form-control" id="card_number"
                                       placeholder="•••••••••••••••••" pattern="[0-9]*" data-numeric=""
                                       autocomplete="new-password" required>
                            </div>
                            <div class="form-group">
                                <label for="card_exp_month">Card Expiration Date</label>
                                <div class="clearfix"></div>
                                <select class="form-control" id="card_exp_month" style="width:49%; float:left;">
                                    <?php
                                    $currentMonth = Date('n');
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo '<option value="' . $i . '"' . (($i == $currentMonth) ? ' selected' : '') . '>' . DateTime::createFromFormat('!m', $i)->format('F') . '</option>';
                                    }
                                    ?>
                                </select>
                                <select class="form-control" id="card_exp_year" style="width:49%; float:right;">
                                    <?php
                                    $currentYear = Date('Y');
                                    for ($i = $currentYear; $i < $currentYear + 20; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label for="card_cvv">Card Verification Code</label>
                                <input type="text" maxlength="4" class="form-control" id="card_cvv" placeholder="CVV"
                                       pattern="\d*" data-numeric="" autocomplete="new-password" required>
                            </div>

                            <?php if (!empty($netbanx_api_profile_required)) { ?>
                                <div class="form-group">
                                    <label for="card_first_name">Customer First Name</label>
                                    <input type="text" maxlength="80" class="form-control" id="card_first_name"
                                           placeholder="Customer First Name"
                                           value="<?php echo $this->customer_data['name']; ?>"
                                           autocomplete="new-password" required>
                                </div>
                                <div class="form-group">
                                    <label for="card_last_name">Customer Last Name</label>
                                    <input type="text" maxlength="80" class="form-control" id="card_last_name"
                                           placeholder="Customer Last Name"
                                           value="<?php echo $this->customer_data['surname']; ?>"
                                           autocomplete="new-password" required>
                                </div>
                                <div class="form-group">
                                    <label for="card_email">Customer Email</label>
                                    <input type="email" maxlength="255" class="form-control" id="card_email"
                                           placeholder="Customer Email"
                                           value="<?php echo $this->customer_data['email']; ?>"
                                           autocomplete="new-password" required>
                                </div>
                            <?php } ?>

                            <?php if (!empty($netbanx_api_billing_required)) { ?>
                                <div class="form-group">
                                    <label for="card_billing_country">Billing Country</label>
                                    <select class="form-control" id="card_billing_country">
                                        <?php
                                        $countries = [
                                            ['AF', 'Afghanistan'],
                                            ['AX', 'Åland Islands'],
                                            ['AL', 'Albania'],
                                            ['DZ', 'Algeria'],
                                            ['AS', 'American Samoa'],
                                            ['AD', 'Andorra'],
                                            ['AO', 'Angola'],
                                            ['AI', 'Anguilla'],
                                            ['AQ', 'Antarctica'],
                                            ['AG', 'Antigua and Barbuda'],
                                            ['AR', 'Argentina'],
                                            ['AM', 'Armenia'],
                                            ['AW', 'Aruba'],
                                            ['AU', 'Australia'],
                                            ['AT', 'Austria'],
                                            ['AZ', 'Azerbaijan'],
                                            ['BS', 'Bahamas'],
                                            ['BH', 'Bahrain'],
                                            ['BD', 'Bangladesh'],
                                            ['BB', 'Barbados'],
                                            ['BY', 'Belarus'],
                                            ['BE', 'Belgium'],
                                            ['BZ', 'Belize'],
                                            ['BJ', 'Benin'],
                                            ['BM', 'Bermuda'],
                                            ['BT', 'Bhutan'],
                                            ['BO', 'Bolivia'],
                                            ['BQ', 'Bonaire, Sint Eustatius and Saba'],
                                            ['BA', 'Bosnia and Herzegovina'],
                                            ['BW', 'Botswana'],
                                            ['BV', 'Bouvet Island'],
                                            ['BR', 'Brazil'],
                                            ['IO', 'British Indian Ocean Territory'],
                                            ['BN', 'Brunei Darussalam'],
                                            ['BG', 'Bulgaria'],
                                            ['BF', 'Burkina Faso'],
                                            ['BI', 'Burundi'],
                                            ['KH', 'Cambodia'],
                                            ['CM', 'Cameroon'],
                                            ['CA', 'Canada'],
                                            ['CV', 'Cape Verde'],
                                            ['KY', 'Cayman Islands'],
                                            ['CF', 'Central African Republic'],
                                            ['TD', 'Chad'],
                                            ['CL', 'Chile'],
                                            ['CN', 'China'],
                                            ['CX', 'Christmas Island'],
                                            ['CC', 'Cocos (Keeling) Islands '],
                                            ['CO', 'Colombia'],
                                            ['KM', 'Comoros'],
                                            ['CG', 'Congo'],
                                            ['CD', 'Congo, Democratic Republic of'],
                                            ['CK', 'Cook Islands'],
                                            ['CR', 'Costa Rica'],
                                            ['CI', 'Côte D’Ivoire'],
                                            ['HR', 'Croatia '],
                                            ['CU', 'Cuba'],
                                            ['CW', 'Curaçao'],
                                            ['CY', 'Cyprus'],
                                            ['CZ', 'Czech Republic'],
                                            ['DK', 'Denmark'],
                                            ['DJ', 'Djibouti'],
                                            ['DM', 'Dominica'],
                                            ['DO', 'Dominican Republic'],
                                            ['EC', 'Ecuador'],
                                            ['EG', 'Egypt'],
                                            ['SV', 'El Salvador'],
                                            ['GQ', 'Equatorial Guinea'],
                                            ['ER', 'Eritrea'],
                                            ['EE', 'Estonia'],
                                            ['ET', 'Ethiopia'],
                                            ['FK', 'Falkland Islands '],
                                            ['FO', 'Faroe Islands'],
                                            ['FJ', 'Fiji'],
                                            ['FI', 'Finland'],
                                            ['FR', 'France'],
                                            ['GF', 'French Guiana'],
                                            ['PF', 'French Polynesia'],
                                            ['TF', 'French Southern Territories'],
                                            ['GA', 'Gabon'],
                                            ['GM', 'Gambia'],
                                            ['GE', 'Georgia'],
                                            ['DE', 'Germany'],
                                            ['GH', 'Ghana'],
                                            ['GI', 'Gibraltar'],
                                            ['GR', 'Greece'],
                                            ['GL', 'Greenland'],
                                            ['GD', 'Grenada'],
                                            ['GP', 'Guadeloupe'],
                                            ['GU', 'Guam'],
                                            ['GT', 'Guatemala'],
                                            ['GG', 'Guernsey'],
                                            ['GN', 'Guinea'],
                                            ['GW', 'Guinea-Bissau'],
                                            ['GY', 'Guyana'],
                                            ['HT', 'Haiti'],
                                            ['HM', 'Heard and McDonald Islands'],
                                            ['HN', 'Honduras'],
                                            ['HK', 'Hong Kong'],
                                            ['HU', 'Hungary'],
                                            ['IS', 'Iceland'],
                                            ['IN', 'India'],
                                            ['ID', 'Indonesia'],
                                            ['IR', 'Iran  (Islamic Republic of) '],
                                            ['IQ', 'Iraq'],
                                            ['IE', 'Ireland'],
                                            ['IM', 'Isle of Man'],
                                            ['IL', 'Israel'],
                                            ['IT', 'Italy'],
                                            ['JM', 'Jamaica'],
                                            ['JP', 'Japan'],
                                            ['JE', 'Jersey'],
                                            ['JO', 'Jordan'],
                                            ['KZ', 'Kazakhstan'],
                                            ['KE', 'Kenya'],
                                            ['KI', 'Kiribati'],
                                            ['KP', 'Korea, Democratic People’s Republic'],
                                            ['KR', 'Korea, Republic of'],
                                            ['KW', 'Kuwait'],
                                            ['KG', 'Kyrgyzstan'],
                                            ['LA', 'Lao People’s Democratic Republic'],
                                            ['LV', 'Latvia'],
                                            ['LB', 'Lebanon'],
                                            ['LS', 'Lesotho'],
                                            ['LR', 'Liberia'],
                                            ['LY', 'Libyan Arab Jamahiriya'],
                                            ['LI', 'Liechtenstein'],
                                            ['LT', 'Lithuania'],
                                            ['LU', 'Luxembourg'],
                                            ['MO', 'Macau'],
                                            ['MK', 'Macedonia'],
                                            ['MG', 'Madagascar'],
                                            ['MW', 'Malawi'],
                                            ['MY', 'Malaysia'],
                                            ['MV', 'Maldives'],
                                            ['ML', 'Mali'],
                                            ['MT', 'Malta'],
                                            ['MH', 'Marshall Islands'],
                                            ['MQ', 'Martinique'],
                                            ['MR', 'Mauritania'],
                                            ['MU', 'Mauritius'],
                                            ['YT', 'Mayotte'],
                                            ['MX', 'Mexico'],
                                            ['FM', 'Micronesia, Federated States of'],
                                            ['MD', 'Moldova, Republic of'],
                                            ['MC', 'Monaco'],
                                            ['MN', 'Mongolia'],
                                            ['ME', 'Montenegro'],
                                            ['MS', 'Montserrat'],
                                            ['MA', 'Morocco'],
                                            ['MZ', 'Mozambique'],
                                            ['MM', 'Myanmar'],
                                            ['NA', 'Namibia'],
                                            ['NR', 'Nauru'],
                                            ['NP', 'Nepal'],
                                            ['NC', 'New Caledonia'],
                                            ['NZ', 'New Zealand'],
                                            ['NI', 'Nicaragua'],
                                            ['NE', 'Niger'],
                                            ['NG', 'Nigeria'],
                                            ['NU', 'Niue'],
                                            ['NF', 'Norfolk Island'],
                                            ['MP', 'Northern Mariana Islands'],
                                            ['NO', 'Norway'],
                                            ['OM', 'Oman'],
                                            ['PK', 'Pakistan'],
                                            ['PW', 'Palau'],
                                            ['PS', 'Palestinian Territory, Occupied'],
                                            ['PA', 'Panama'],
                                            ['PG', 'Papua New Guinea'],
                                            ['PY', 'Paraguay'],
                                            ['PE', 'Peru'],
                                            ['PH', 'Philippines'],
                                            ['PN', 'Pitcairn'],
                                            ['PL', 'Poland'],
                                            ['PT', 'Portugal'],
                                            ['PR', 'Puerto Rico'],
                                            ['QA', 'Qatar'],
                                            ['RE', 'Reunion'],
                                            ['RO', 'Romania'],
                                            ['RU', 'Russian Federation'],
                                            ['RW', 'Rwanda'],
                                            ['BL', 'Saint Barthélemy'],
                                            ['SH', 'Saint Helena'],
                                            ['KN', 'Saint Kitts and Nevis'],
                                            ['LC', 'Saint Lucia'],
                                            ['MF', 'Saint Martin'],
                                            ['VC', 'Saint Vincent and the Grenadines'],
                                            ['WS', 'Samoa'],
                                            ['SM', 'San Marino'],
                                            ['ST', 'Sao Tome and Principe'],
                                            ['SA', 'Saudi Arabia'],
                                            ['SN', 'Senegal'],
                                            ['RS', 'Serbia'],
                                            ['SC', 'Seychelles'],
                                            ['SL', 'Sierra Leone'],
                                            ['SG', 'Singapore'],
                                            ['SX', 'Sint Maarten'],
                                            ['SK', 'Slovakia (Slovak Republic)'],
                                            ['SI', 'Slovenia'],
                                            ['SB', 'Solomon Islands'],
                                            ['SO', 'Somalia'],
                                            ['ZA', 'South Africa'],
                                            ['GS', 'South Georgia and the South Sandwich Islands'],
                                            ['SS', 'South Sudan'],
                                            ['ES', 'Spain'],
                                            ['LK', 'Sri Lanka'],
                                            ['PM', 'St. Pierre and Miquelon'],
                                            ['SD', 'Sudan'],
                                            ['SR', 'Suriname'],
                                            ['SJ', 'Svalbard and Jan Mayen Islands'],
                                            ['SZ', 'Swaziland'],
                                            ['SE', 'Sweden'],
                                            ['CH', 'Switzerland'],
                                            ['SY', 'Syrian Arab Republic'],
                                            ['TW', 'Taiwan'],
                                            ['TJ', 'Tajikistan'],
                                            ['TZ', 'Tanzania, United Republic of'],
                                            ['TH', 'Thailand'],
                                            ['NL', 'The Netherlands'],
                                            ['TL', 'Timor-Leste'],
                                            ['TG', 'Togo'],
                                            ['TK', 'Tokelau'],
                                            ['TO', 'Tonga'],
                                            ['TT', 'Trinidad and Tobago'],
                                            ['TN', 'Tunisia'],
                                            ['TR', 'Turkey'],
                                            ['TM', 'Turkmenistan'],
                                            ['TC', 'Turks and Caicos Islands'],
                                            ['TV', 'Tuvalu'],
                                            ['UG', 'Uganda'],
                                            ['UA', 'Ukraine'],
                                            ['AE', 'United Arab Emirates'],
                                            ['GB', 'United Kingdom'],
                                            ['US', 'United States'],
                                            ['UM', 'United States Minor Outlying Islands'],
                                            ['UY', 'Uruguay'],
                                            ['UZ', 'Uzbekistan'],
                                            ['VU', 'Vanuatu'],
                                            ['VA', 'Vatican City State (Holy See)'],
                                            ['VE', 'Venezuela'],
                                            ['VN', 'Vietnam'],
                                            ['VG', 'Virgin Islands (British)'],
                                            ['VI', 'Virgin Islands (U.S.)'],
                                            ['WF', 'Wallis and Futuna Islands'],
                                            ['EH', 'Western Sahara'],
                                            ['YE', 'Yemen'],
                                            ['ZM', 'Zambia'],
                                            ['ZW', 'Zimbabwe']
                                        ];
                                        foreach ($countries as $c) {
                                            echo "<option value=\"{$c[0]}\"" . (($c[0] == $netbanx_default_country) ? ' selected' : '') . ">{$c[1]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?php if (!empty($netbanx_api_billing_state_required)) { ?>
                                    <div class="form-group">
                                        <label for="card_billing_state">Billing State</label>
                                        <input type="text" maxlength="40" class="form-control" id="card_billing_state"
                                               placeholder="Billing State" autocomplete="new-password">
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label for="card_billing_city">Billing City</label>
                                    <input type="text" maxlength="40" class="form-control" id="card_billing_city"
                                           placeholder="Billing City" autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label for="card_billing_street">Billing Street</label>
                                    <input type="text" maxlength="50" class="form-control" id="card_billing_street"
                                           placeholder="Billing Street"
                                           value="<?php echo $this->customer_data['address']; ?>"
                                           autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label for="card_billing_street2">Billing Street 2</label>
                                    <input type="text" maxlength="50"" class="form-control" id="card_billing_street2"
                                    placeholder="Billing Street 2" autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label for="card_billing_zip">Billing ZIP / Postcode</label>
                                    <input type="text" maxlength="10" class="form-control" id="card_billing_zip"
                                           placeholder="Billing ZIP / Postcode"
                                           value="<?php echo $this->customer_data['postcode']; ?>"
                                           autocomplete="new-password">
                                </div>

                                <?php if (empty($phone_nr_required)) { ?>
                                    <div class="form-group">
                                        <label for="card_billing_phone">Billing Phone</label>
                                        <input type="text" maxlength="40" class="form-control" id="card_billing_phone"
                                               placeholder="Billing Phone"
                                               value="<?php echo $this->customer_data['phone']; ?>"
                                               autocomplete="new-password">
                                    </div>
                                <?php } ?>

                            <?php } ?>

                            <?php if ($deposit_value > 0) { ?>
                                <button type="submit"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_netbanx_card"
                                        data-payment-type="cc_deposit">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                                </button>
                            <?php } ?>

                            <?php if ($ob_payment_card_full_enabled && $cart_total > 0) { ?>
                                <button type="submit"
                                        class="btn btn-large btn-success ob_payment_btn ob_payment_btn_netbanx_card"
                                        data-payment-type="cc_total">
                                    <span class="glyphicon glyphicon-lock"></span> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                                </button>
                            <?php } ?>

                        </form>
                        <!-- [end] NETBANX Card Form -->
                    <?php } ?>

                    <?php } ?>
                        <!-- [end] Card Form -->


                    <?php if ($ob_enable_bitcoin_payments && (($deposit_value > 0) || ($cart_total > 0 && $ob_enable_bitcoin_full_payment))) { ?>
                        <!-- Pay with Bitcoin -->

                        <h3>Pay with Bitcoin</h3>
                    <?php if ($deposit_value > 0) { ?>
                        <button type="button" class="btn btn-large btn-default ob_payment_btn ob_payment_btn_bitcoin"
                                data-payment-type="btc_deposit">
                            <img src="/static/img/bc_logo1.png"
                                 height="13"/>&nbsp; <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                        </button>
                    <?php } ?>

                    <?php if ($ob_payment_paypal_full_enabled && $cart_total > 0) { ?>
                        <button type="button" class="btn btn-large btn-default ob_payment_btn ob_payment_btn_bitcoin"
                                data-payment-type="btc_total">
                            <img src="/static/img/bc_logo1.png"
                                 height="13"/>&nbsp; <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                    <?php } ?>

                        <script>
                            $('.ob_payment_btn_bitcoin').click(function () {

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>

                        <!-- [end] Pay with Bitcoin -->
                    <?php } ?>

                    <?php if (empty($this->settings_model->item("ob_account_payment_methods_card_stripe_enabled"))) { ?>
                        <?php if (!empty($stripe_enabled) && empty($this->online_settings_model->item("stripe_shop_only_enabled"))) { ?>
                        <!-- Pay with Stripe -->
                        <script src="https://checkout.stripe.com/checkout.js"></script>
                        <h3><?= __("Pay with Card"); ?></h3>

                    <?php if ($deposit_value > 0 && ($cart_total != $deposit_value || !$ob_payment_stripe_full_enabled)) { ?>
                        <button type="button" class="btn btn-large btn-default ob_payment_btn ob_payment_btn_stripe"
                                data-payment-type="st_deposit"
                                data-st-amount="<?php echo (int)(round($deposit_value, 2) * $stripe_currency_multiplier); ?>"
                        >
                            <?= __("Pay"); ?><?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                        </button>
                    <?php } ?>

                    <?php if (!empty($ob_payment_stripe_full_enabled) && $cart_total > 0) { ?>
                        <button type="button" class="btn btn-large btn-default ob_payment_btn ob_payment_btn_stripe"
                                data-payment-type="st_total"
                                data-st-amount="<?php echo (int)(round($cart_total, 2) * $stripe_currency_multiplier); ?>"
                        >
                            <?= __("Pay"); ?><?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                    <?php } ?>

                    <?php if (!empty($stripe_sca_enabled) && empty($this->online_settings_model->item("stripe_shop_only_enabled"))) {
                        $this->load->view('pages/booking/sca_stripe');
                    } else { ?>
                        <script>
                            var stripe_handler = StripeCheckout.configure({
                                key: '<?php echo $stripe_api_key;?>',

                                <?php if (!empty($stripe_logo_uri)) { ?>
                                image: '<?php echo $stripe_logo_uri;?>',
                                <?php } ?>

                                locale: 'en',
                                token: function (token) {
                                    (function ($) {

                                        var $f = $('#ob_payment_form_main');
                                        $('input[name="stripe_token"]', $f).val(token.id);

                                        $f[0].submit();
                                        return false;

                                    })(jQuery);
                                }
                            });

                            // Close Checkout on page navigation:
                            window.addEventListener('popstate', function () {
                                stripe_handler.close();
                            });


                            $('.ob_payment_btn_stripe').click(function () {

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                var st_amount = parseInt($(this).attr('data-st-amount')) || 0;

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) {
                                    return false;
                                }
                                <?php } ?>

                                stripe_handler.open({

                                    <?php if (!empty($sitename)) { ?>
                                    name: <?php echo json_encode((string)$sitename);?>,
                                    <?php } ?>

                                    <?php if (!empty($stripe_description)) { ?>
                                    description: <?php echo json_encode((string)$stripe_description);?>,
                                    <?php } ?>

                                    currency: '<?php echo $stripe_currency;?>',

                                    amount: st_amount,

                                    zipCode: true,
                                    email: '<?php echo $this->customer_data['email'];?>',
                                    allowRememberMe: false
                                });

                            });
                        </script>
                        <!-- [end] Pay with Stripe -->
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>

                    <?php
                    // PAYMENTSENSE CONNECT-E
                    if (!empty($ob_paymentsense_ce_enabled)) {
                        $this->load->view('pages/booking/step3_payment_methods/paymentsense_ce');
                    }
                    ?>

                        <!-- Pay with PayPal Account -->
                    <?php if ($paypal_accept_pp_payments && (($deposit_value > 0) || ($cart_total > 0 && $ob_payment_paypal_full_enabled))) { ?>

                        <?php if (!$credit_card_payment_enabled && empty($stripe_enabled)) { ?>

                        <h3>Pay with Card</h3>
                        <?php if ($deposit_value > 0) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_paypal_account"
                                data-payment-type="pp_deposit">
                            <?= __("Pay"); ?><?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                        </button>
                    <?php } ?>

                        <?php if ($ob_payment_paypal_full_enabled && $cart_total > 0) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_paypal_account"
                                data-payment-type="pp_total">
                            <?= __("Pay"); ?><?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                    <?php } ?>

                    <?php } ?>

                        <h3><?= __("Pay with PayPal"); ?></h3>
                    <?php if ($deposit_value > 0) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_paypal_account"
                                data-payment-type="pp_deposit">
                            <img src="/static/img/paypal_btn_icon.png"> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                        </button>
                    <?php } ?>

                    <?php if ($ob_payment_paypal_full_enabled && $cart_total > 0) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_paypal_account"
                                data-payment-type="pp_total">
                            <img src="/static/img/paypal_btn_icon.png"> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                    <?php } ?>

                        <script>
                            $('.ob_payment_btn_paypal_account').click(function () {
                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>
                    <?php } ?>
                        <!-- [end] Pay with PayPal Account -->


                        <!-- Pay with credit -->
                    <?php if ($ob_payment_credit_full_enabled && $cart_total > 0 && $customer_credit >= $cart_total) { ?>
                        <h3>Pay with credit</h3>
                        <span>You have <?php echo CURRENCY_PREFIX . number_format($customer_credit, 2) . CURRENCY_SUFFIX; ?> credited to your account.</span>

                        <button id="ob_payment_btn_credit_total" class="btn btn-large btn-success ob_payment_btn">
                            <?= __("Pay"); ?><?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                        <script>
                            $('#ob_payment_btn_credit_total').click(function () {
                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val('credit_total');
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>
                    <?php } ?>
                        <!-- Pay with credit -->

                    <?php } // endif !$no_payment_form_enabled ?>

                    <!-- Pay with Direct Debit -->
                    <?php if (empty($membership_data) && (($ob_payment_dd_deposit_enabled && $deposit_value > 0) || ($cart_total > 0 && $ob_payment_dd_full_enabled))) { ?>

                        <h3>Pay with Direct Debit</h3>
                    <?php if ($ob_payment_dd_deposit_enabled && $deposit_value > 0 && $deposit_value != $cart_total) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_direct_debit"
                                data-payment-type="dd_deposit">
                            <img src="/static/img/dd_btn_icon.png">
                            &nbsp;<?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX; ?> <?= __("Deposit"); ?>
                        </button>
                    <?php } ?>

                    <?php if ($ob_payment_dd_full_enabled && $cart_total > 0) { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_direct_debit"
                                data-payment-type="dd_total">
                            <img src="/static/img/dd_btn_icon.png">
                            &nbsp;<?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("Total Price"); ?>
                        </button>
                    <?php } ?>

                        <script>
                            $('.ob_payment_btn_direct_debit').click(function () {
                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>
                    <?php } ?>
                    <!-- [end] Pay with Direct Debit -->

                    <?php if ($no_payment_form_enabled || $ob_payment_at_salon_enabled) { ?>
                        <!-- Pay on arrival -->

                        <?php if ($cart_total > 0) { ?>
                        <button id="ob_payment_btn_at_salon" class="btn btn-large btn-info ob_payment_btn">
                            <span class="glyphicon glyphicon-print"></span> <?= __("Pay"); ?> <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX; ?> <?= __("on arrival"); ?>
                        </button>
                    <?php } else if (empty($membership_data)) { ?>
                        <button id="ob_payment_btn_at_salon" class="btn btn-large btn-info ob_payment_btn">COMPLETE
                            ORDER
                        </button>
                    <?php } ?>

                        <script>
                            $('#ob_payment_btn_at_salon').click(function () {
                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val('at_salon');
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required && empty($s_staff_data)) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>

                        <!-- [end] Pay on arrival -->
                    <?php } ?>

                    <!-- Pay with Direct Debit (Membership) -->
                    <?php if (!empty($membership_data) && !empty($ob_direct_debit_payments_enabled)) { ?>

                        <h3>Pay with Direct Debit</h3>

                    <?php if ($payment_plan == 'full') { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_direct_debit"
                                data-payment-type="dd_membership">
                            <img src="/static/img/dd_btn_icon.png">
                            &nbsp;Pay <?php echo CURRENCY_PREFIX . number_format($total_membership_price, 2) . CURRENCY_SUFFIX; ?>
                            Total Price
                        </button>
                    <?php } else { ?>
                        <button type="button"
                                class="btn btn-large btn-default ob_payment_btn ob_payment_btn_direct_debit"
                                data-payment-type="dd_membership">
                            <img src="/static/img/dd_btn_icon.png">
                            &nbsp;Pay <?php echo CURRENCY_PREFIX . number_format($monthly_membership_price, 2) . CURRENCY_SUFFIX; ?>
                            Deposit
                        </button>
                    <?php } ?>

                        <script>
                            $('.ob_payment_btn_direct_debit').click(function () {
                                var $main_form = $('#ob_payment_form_main');
                                $("input[name='payment_type']", $main_form).val($(this).attr('data-payment-type'));
                                $("input[name='booking_notes']", $main_form).val($('#set_booking_notes').val());

                                <?php if ($phone_nr_required) { ?>
                                if (!validatePhoneNumber()) return false;
                                <?php } ?>

                                <?php if (!empty($ob_step3_terms_checkbox_enabled)) { ?>
                                if (!$('#client_terms_agreement_cb').prop('checked')) {
                                    alert('Please indicate that you have read and agree to the Terms and Conditions.');

                                    var offset = $('#client_terms_agreement_cb_container').offset();
                                    offset.top -= 80;
                                    $('html, body').animate({scrollTop: offset.top,});

                                    return false;
                                }
                                <?php } ?>

                                $main_form[0].submit();
                                return false;
                            });
                        </script>
                    <?php } ?>
                    <!-- [end] Pay with Direct Debit (Membership) -->


                </div>

                <div id="ob_load_indicator" class="noselect" style="display:none; margin:0;">
                    <h2>Please wait...</h2>
                    <img src="/static/img/loading.gif">
                </div>

            </div>
        </div>

        <?php
        if (empty($is_embed)) {
            $this->load->view('pages/booking/cancellation_policy');
        }
        ?>

    </div>

    <script type="text/javascript">
        window.removeShopCartItem = function (index){
            return new Promise(function (r, e){
                $.ajax({
                    method: 'post',
                    url: window.DOMAIN_BASE + 'shop/cart/remove_item/' + index + '/0',
                    data: {},
                    success: (response) => {
                        window.location.reload();
                    },
                    error: (err) => {
                        console.log(error);
                    },
                });
            });
        };
        $(document).ready(function (){

        });
    </script>

<?php $this->load->view('footer'); ?>