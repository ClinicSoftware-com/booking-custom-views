<?php 
if (!empty($cart_contents)) {
    $step2_url = $domain_base . 'online-booking/step2/';
    if (!empty($ob_step2_date)) $step2_url .= $ob_step2_date;
?>

	<div class="row ob_cart hidden-xs">
		<div class="col-xs-12">
		  <table class="table table-striped">
			<thead>
				<tr>
					<th><?php echo __('treatment') ?></th>
					<th width="300"><?php echo __('staff') ?></th>
					<th width="150"><?php echo __('duration') ?></th>
                    <?php if ( !empty($currency_modifier) ) { ?>
                        <th width="90"><?= __('price') . ' '. $secondary_currency ?></th>
                    <?php } ?>
                    <th width="90"><?php echo __('price') ?></th>
					
					<?php if($ob_cart_editable): ?>
					<th width="75"></th>
					<?php endif;?>
					
				</tr>
			</thead>
			<tbody>
				<?php foreach($cart_contents as $k => $cart_item) { ?>
				<tr>
					<td>
                    <?php echo $cart_item['title'];?>
                    <?php if (!empty($cart_item['pt_area_interested'])) echo '<br>Area Interested: ' . htmlentities($cart_item['pt_area_interested']); ?>
                    <?php if (!empty($cart_item['groupon_code'])) echo '<br>Groupon Code: ' . htmlentities($cart_item['groupon_code']); ?>
                    </td>
					<td <?php if (!$cart_item['staff_id']) echo ' class="text-danger"';?>><?php echo $cart_item['staff_name'];?></td>
					<td><?php echo $cart_item['duration_h'];?></td>

                    <?php if ( !empty($currency_modifier) ) { ?>
                        <td>
                            <?= number_format($currency_modifier * $cart_item['price_excl_tax'], 2) ?>
                        </td>
                    <?php } ?>
					<td>
                        <?php
                        if($this->settings['show_prices_excl_tax_till_checkout']):
                            echo CURRENCY_PREFIX . number_format($cart_item['price_excl_tax'], 2) . CURRENCY_SUFFIX;
                        else:
                            echo CURRENCY_PREFIX . number_format($cart_item['price'], 2) . CURRENCY_SUFFIX;
                        endif;
                        ?>
                    </td>
					
					<?php if($ob_cart_editable): ?>
					<td align="right">
						<form method="post" role="form">
							<input type="hidden" name="action" value="del_item">
							<input type="hidden" name="cart_index" value="<?php echo $k;?>">
							<input class="btn btn-sm btn-danger ob_cart_btn" type="submit" value="<?php echo __('remove') ?>">
						</form>
					</td>
					<?php endif;?>
					
				</tr>
				<?php } ?>
				<tr>
					<td><span class="ob_cart_total"><?php echo __('total') ?></span></td>
					<td></td>

					<td><span class="ob_cart_total"><?= $cart_summary['duration_h'];?></span></td>
                    <?php if ( !empty($currency_modifier) ) { ?>
                    <td>
					    <span class="ob_cart_total_2">
                            <b>
                                <?= number_format($currency_modifier * $cart_summary['total_excl_tax'], 2);?>
                            </b>
                        </span>
                    </td>
                    <?php } ?>
					<td><span class="ob_cart_total"><?php echo CURRENCY_PREFIX . number_format($cart_summary['total_excl_tax'], 2) . CURRENCY_SUFFIX;?></span></td>
					
					<?php if($ob_cart_editable): ?>
					<td align="right">
						<a href="<?php echo $step2_url;?>" class="btn btn-sm btn-success ob_cart_btn" title="Proceed to Step 2: Pick Preferred Time"><?php echo __('book_now') ?></a>
					</td>
					<?php endif;?>
					
				</tr>
			</tbody>
		  </table>
		  
		</div>
	</div>
	
	<div class="row ob_cart visible-xs">
		<div class="col-xs-12">
		  <table class="table table-striped">
            <tr>
				<td>
					<span class="ob_cart_total" style="float:left;">Total: <?php echo CURRENCY_PREFIX . number_format($cart_summary['total'], 2) . CURRENCY_SUFFIX;?> <br><?php echo $cart_summary['duration_h'];?></span>
					<?php if($ob_cart_editable) { ?>
						<a style="float:right;" href="<?php echo $step2_url;?>" class="btn btn-sm btn-success ob_cart_btn" title="Proceed to Step 2: Pick Preferred Time"><?php echo __('book_now') ?></a>
					<?php } ?>
				</td>
			</tr>
			<?php foreach($cart_contents as $k => $cart_item) { ?>
			<tr>
				<td>
					<p style="float:left;">
						<?php echo $cart_item['title'];?>
                        <?php if (!empty($cart_item['pt_area_interested'])) echo '<br>Area Interested: ' . htmlentities($cart_item['pt_area_interested']); ?>
                        <?php if (!empty($cart_item['groupon_code'])) echo '<br>Groupon Code: ' . htmlentities($cart_item['groupon_code']); ?>
						<br><?php echo __('duration') ?>: <?php echo $cart_item['duration_h'];?>
						<br><?php echo __('staff') ?>: <span <?php if (!$cart_item['staff_id']) echo ' class="text-danger"';?>><?php echo $cart_item['staff_name'];?></span>
						<br><?php echo __('price') ?>: <?php echo CURRENCY_PREFIX . number_format($cart_item['price'], 2) . CURRENCY_SUFFIX;?>
					</p>
					<?php if($ob_cart_editable) { ?>
						<form method="post" role="form" style="float:right;">
							<input type="hidden" name="action" value="del_item">
							<input type="hidden" name="cart_index" value="<?php echo $k;?>">
							<input class="btn btn-sm btn-danger ob_cart_btn" type="submit" value="<?php echo __('remove') ?>">
						</form>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		  </table>
		  
		</div>
	</div>
	
<?php } ?>