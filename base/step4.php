<?php $this->load->view('navigation'); ?>

<div class="container theme-showcase main_content online_booking" role="main">

	<?php if (empty($is_embed)) { ?>
	<div class="page-header">
		<h1><?=__("Online Booking")?></h1>
	</div>
	<?php } ?>
	
	<?php $this->flash->printMessages(); ?>
    
    <?php $this->load->view('pages/booking/booking_progress_step4'); ?>
	
	<div class="row">
	
		<div class="col-xs-12">
            <?php
            if(!empty($ob_shop_cart) && !empty($ob_shop_cart_total) && $ob_shop_cart_total > 0){
                $cart_total += number_format($ob_shop_cart_total, 2);
            }
            ?>
		
			<h1>Appointment Confirmation</h1>
			<hr>
		
			<?php 
			$app_num = 1;
			foreach($appointments as $appointment) { 
			?>
				<div class="ob_appointment">
					<span class="ob_appointment_title">
					<?php
                    if ($this->settings['usa_date_format']):
                        echo "Appointment {$app_num}: &nbsp;"
                            . date('F jS Y, h:i A', $appointment['ts_start']) . ' - '
                            . date('h:i A', $appointment['ts_start'] + $appointment['duration_m'] * 60)
                            . " (" . $this->utils->min_to_hours($appointment['duration_m']) . ") with {$appointment['staff_nickname']} at {$salon_name}";
                    else:
                        echo "Appointment {$app_num}: &nbsp;"
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
                            if (!empty($item['pt_area_interested'])) { echo '<br><span style="margin-left:30px; color:#999;">Area Interested: ' . htmlentities($item['pt_area_interested']) . '</span>'; }
                            if (!empty($item['groupon_code'])) { echo '<br><span style="margin-left:30px; color:#999;">Groupon Code: ' . htmlentities($item['groupon_code']) . '</span>'; }
                            echo '</li>';
                        } 
                        ?>
					</ul>

                    <?php if(!empty($ob_shop_cart)) : ?>
                        <ul class="cart-shop-products">
                            <li>
                                <span class="cart-shop-total"><?php echo __('Services Total'); ?>:</span>
                                <span class="cart-shop-total-value"><?php echo CURRENCY_PREFIX . number_format($cart_total - $ob_shop_cart_total, 2) . CURRENCY_SUFFIX; ?></span>
                            </li>
                        </ul>
                    <?php endif; ?>
				</div>
			<?php 
				$app_num++;
			} 
			?>

            <?php if (!empty($ob_shop_cart)): ?>
                <div class="products-in-cart">
                    <p>Selected products:</p>
                    <ul class="cart-shop-products">
                        <?php foreach ($ob_shop_cart as $key => $item): ?>
                            <li>
                                <span class="product-title"><?php echo $item['name']; ?></span>
                                <span class="product-quantity">Qty: <?php echo $item['quantity']; ?></span>
                                <span class="product-price">Unit Price: <?php echo CURRENCY_PREFIX . number_format($item['price_incl_tax'], 2) . CURRENCY_SUFFIX; ?> (incl taxes)</span>
                            </li>
                        <?php endforeach; ?>
                        <li>
                            <span class="cart-shop-total">Products:</span>
                            <span class="cart-shop-total-value"><?php echo CURRENCY_PREFIX . number_format($ob_shop_cart_total, 2) . CURRENCY_SUFFIX; ?></span>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
			
			<?php if ($booking_notes) { ?>
			<p><b>Notes:</b><br><pre><?php echo $booking_notes; ?></pre></p>
			<?php } ?>
			
			<hr>
            
            <script>
            function copyBTCAddressToClipboard() {
                $('#bitcoin_address').select();
                
                document.execCommand("Copy");
                alert('Copied bitcoin address to clipboard');
            }
            </script>
			
			<div class="pull-left">
				<ul class="ob_summary">
					<?php 
					switch ($payment_type) {
						case 'cc_deposit': // break intentionally omitted
						case 'pp_deposit': // break intentionally omitted
						case 'credit_deposit': {
					?>
						<li class="ob_summary_deposit">Deposit Paid: <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX;?></li>
						<li class="ob_summary_total">Left to pay at the time of visit: <?php echo CURRENCY_PREFIX . number_format(max(0, $cart_total - $deposit_value), 2) . CURRENCY_SUFFIX;?></li>
					<?php
						} break;
						case 'cc_total': // break intentionally omitted
						case 'pp_total': // break intentionally omitted
						case 'credit_total': {
					?>
						<li class="ob_summary_deposit">Paid Total: <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX;?></li>
					<?php
						} break;
						case 'at_salon': {
					?>
						<li class="ob_summary_total">Left to pay at the time of visit: <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX;?></li>
					<?php
						} break;
                        case 'btc_deposit': {
                    ?>
                    <li class=""><span style="color:#ff0000; font-weight:bold;">Please pay deposit with bitcoin:</span> <div class="visible-xs"></div><?php echo $bitcoin_payment_data['amount_btc']?> BTC / <?php echo CURRENCY_PREFIX . number_format($deposit_value, 2) . CURRENCY_SUFFIX;?></li>
                    <li class="visible-xs">&nbsp;</li>
                    <li class=""><span style="color:#ff0000; font-weight:bold;">Bitcoin address:</span> <div class="visible-xs"></div><?php echo $bitcoin_payment_data['address']?></li>
                    <li>&nbsp;</li>
                    <li class="ob_summary_total">Left to pay at the time of visit: <?php echo CURRENCY_PREFIX . number_format(max(0, $cart_total - $deposit_value), 2) . CURRENCY_SUFFIX;?></li>
                    <?php
                        } break;
                        case 'btc_total': {
                    ?>
                    <li class=""><span style="color:#ff0000; font-weight:bold;">Please pay with bitcoin:</span> <div class="visible-xs"></div><?php echo $bitcoin_payment_data['amount_btc']?> BTC / <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX;?></li>
                    <li class="visible-xs">&nbsp;</li>
                    <li class=""><span style="color:#ff0000; font-weight:bold;">Bitcoin address:</span> <div class="visible-xs"></div><?php echo $bitcoin_payment_data['address']?></li>
                    <?php
                        } break;
					}
					?>
				</ul>
			</div>
			
			<div class="pull-right hidden-xs">
				<a title="Share on Facebook" target="_blank" href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=" . urldecode($facebook_sharebtn_u);?>">
					<img src="/static/img/btn_share_on_facebook.png">
				</a>
			</div>
			
		</div>
		
	</div>
    
    <?php if (!empty($bitcoin_payment_data)) { ?>
    <div class="row">
        <div class="col-xs-12">
            <div style="height:20px;"></div>
            <div>
                <a href="<?php echo $bitcoin_payment_url;?>">
                    <img src="<?php echo $bitcoin_qr_data_uri;?>" />
                </a>
                <div style="clear:both; height:20px;"></div>
                <table class="table" width="100%">
                    <tr>
                        <td width="150">Amount: </td>
                        <td><?php echo $bitcoin_payment_data['amount_btc']?> BTC / <?php echo CURRENCY_PREFIX . number_format($cart_total, 2) . CURRENCY_SUFFIX;?></td>
                    </tr>
                    <tr>
                        <td>Bitcoin address:</td>
                        <td>
                            <div class="input-group">
                               <input type="text" class="form-control" id="bitcoin_address" value="<?php echo $bitcoin_payment_data['address']?>" onclick="this.select();" readonly style="cursor:text; width:100%;" />
                               <span class="input-group-btn">
                                   <button class="btn btn-default" type="button" onclick="copyBTCAddressToClipboard();">Copy</button>
                               </span>
                            </div>
                        </td>
                    </tr>
                </table>
                

            </div>
            <div style="height:20px;"></div>
        </div>
    </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-xs-12" style="text-align:center; margin-top:10px;">
            
            <?php if (!empty($ob_step4_book_new_appointment_btn_url)) { ?>
            <a class="btn btn-default" style="margin:5px;" href="<?php echo $ob_step4_book_new_appointment_btn_url;?>">Book New Appointment</a>
            <?php } ?>
            
            <?php if (!empty($ob_step4_my_appointments_btn_url)) { ?>
            <a class="btn btn-default" style="margin:5px;"  href="<?php echo $ob_step4_my_appointments_btn_url;?>">My Appointments</a>
            <?php } ?>
            
            <?php if (!empty($ob_step4_buy_product_btn_url)) { ?>
            <a class="btn btn-success" style="margin:5px;" href="<?php echo $ob_step4_buy_product_btn_url;?>">Buy a Product</a>
            <?php } ?>
            
            <div class="pull-right visible-xs" style="clear:both; margin:5px 0;">
				<a title="Share on Facebook" target="_blank" href="<?php echo "https://www.facebook.com/sharer/sharer.php?u=" . urldecode($facebook_sharebtn_u);?>">
					<img src="/static/img/btn_share_on_facebook.png">
				</a>
			</div>
            
            <div style="height:20px;"></div>
            
        </div>
    </div>
    
    <?php $this->load->view('pages/booking/cancellation_policy'); ?>

</div>

<?php $this->load->view('footer'); ?>

<?php if ( strpos( strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone' ) !== FALSE ) {  ?>
    <script>

        function sendMobileNotification(message = null, button = `Ok`, secondsAway = 0) {

            // Check if any of the mandatory fields are missing, if they are just return
            if ( !message || !button ) return;

            // Validate the secondsAway
            if ( !secondsAway ) secondsAway = 0;

            // Console.log for dev purposes
            console.log(`[${secondsAway}]: ${message}`);

            // Launch the notification
            window.location.href = "sendlocalpushmsg://push.send?s="+ secondsAway +"=msg!"+ message +"&!#"+ button +"";
        }

        setTimeout(() => {
            // Since php is in seconds, but javascript is in miliseconds we do the following:
            let app_start = new Date(<?=$appointment['ts_start'] * 1000; ?>);
            // Get the current date.
            let now = new Date();

            // The actual reminderSecondsAway
            let reminderSecondsAway = 0;

            // Calculate how many seconds away the appointment is
            let secondsAway = ((app_start.getTime() - now.getTime()) / 1000) - (60 * 60);

            // This is set to 24 hours, H * M * S
            let padding = 24 * 60 * 60; // The amount of seconds to pad

            // Check if this appointment is not that far away, if it's in the same day, set the reminder to be 1 hour before the appointment.
            if ( secondsAway <= padding ) padding = 1 * 60 * 60; 

            // If the padding is still bigger than seconds away...
            reminderSecondsAway = secondsAway - padding;
            if ( reminderSecondsAway < 1 ) reminderSecondsAway = 1;

            // Build the message to send out in the notification
            let msg = "Don't miss your appointment with <?=$appointment['staff_nickname']?> on <?=date('d/m/Y', $appointment['ts_start'])?> at <?=date('h:i A', $appointment['ts_start'])?>";

            // Send out the reminder notification
            if ( secondsAway > 60 * 60 ) sendMobileNotification(msg, "Ok", reminderSecondsAway);
        }, 1000);
    </script>
<?php } ?>