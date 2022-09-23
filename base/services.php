<?php $this->load->view('navigation'); ?>

<div class="container theme-showcase main_content online_booking" role="main">

	<?php if (empty($is_embed)) { ?>
	<div class="page-header">
		<h1>online_booking</h1>
	</div>
	<?php } ?>
	
	<?php $this->flash->printMessages(); ?>
    
    <?php $this->load->view('pages/booking/booking_progress_step1'); ?>
	
	<ol class="breadcrumb">
		<li><a href="<?php echo "{$domain_base}online-booking";?>">online_booking'</a></li>
		<li class="active"><?php echo "{$service_category['title']} ({$service_section['title']})";?></li>
	</ol>
	
	<?php $this->load->view('pages/booking/booking_cart'); ?>
    
    <div class="row">
		<div class="col-xs-12" style="text-align:center;">
            <a class="btn btn-default" href="<?php echo "{$domain_base}online-booking";?>"><span class="glyphicon glyphicon-backward"></span>continue_adding_more_services</a>
		</div>
	</div>
    
	
	<div class="row ob_service_category_title">
		<div class="col-xs-12">
			<h4><?php echo "{$service_category['title']} ({$service_section['title']})";?></h4>
		</div>
	</div>
	
	<div class="ob_services_list">
		<?php if (!empty($services)) { foreach ($services as $service) { ?>
		<div class="row ob_service_item hidden-xs">
			<div class="col-xs-12">
            
                 <div class="pull-left <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>">
                    <span><?php echo "{$service['title']} ({$service['duration_h']})";?></span>
                 </div>
				
				<div class="pull-right" style="height:35px;">
                
                    <div class="pull-left ob_service_price <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>">
                        <?php if ( !empty($currency_modifier) ) { ?>
                            <span style="margin-right: 1rem;background-color: #dbdbdb;padding: 0.4rem 0.5rem;border-radius: 0.25rem;font-size: 1.4rem;">
                                <?= $secondary_currency . " " . number_format($currency_modifier * $service['price_excl_tax'], 2) ?>
                            </span>
                        <?php } ?>
                        <span>
                            <?php
                            if($this->settings['show_prices_excl_tax_till_checkout']):
                                echo CURRENCY_PREFIX . number_format($service['price_excl_tax'], 2) . CURRENCY_SUFFIX;
                            else:
                                echo CURRENCY_PREFIX . number_format($service['price'], 2) . CURRENCY_SUFFIX;
                            endif;
                            ?>
                        </span>
                    </div>
                    
                    <div class="pull-left">
					<form method="post" role="form">
						<input type="hidden" name="action" value="add_service">
						<input type="hidden" name="service_id" value="<?php echo $service['id'];?>">
						<select name="staff_id" class="form-control ob_item_staff" <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo ' disabled="disabled"';?> style="width: 160px !important;display: inline-block">
							<option value="0"><?=__("Any staff member");?></option>
							<?php 
                            $search_staff_id = empty($book_now_staff_id)? (empty($s_staff_data['id'])? 0 : $s_staff_data['id']) : $book_now_staff_id;
                            if (!empty($service['staff_list'])) { 
                                $selected_staff_id = null;
                                if (isset($service['cart_staff_id'])) {
                                    $selected_staff_id = $service['cart_staff_id'];
                                }
                                foreach ($service['staff_list'] as $staff) { 
                                    if (!isset($selected_staff_id) && $search_staff_id && $staff['id'] == $search_staff_id) {
                                        $selected_staff_id = $search_staff_id;
                                    }
                                    echo "<option value=\"{$staff['id']}\"" . (($staff['id'] == $selected_staff_id)? ' selected="selected"' : '') . ">{$staff['label']}</option>";
                                }
                            }
                            ?>	
						</select>
						<input class="btn btn-success btn-sm ob_service_add" type="submit" value="<?php echo __('add') ?>" <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo ' disabled="disabled"';?> style="display: inline-block;">
					</form>
                    </div>
                    
				</div>

                <div class="pull-left <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>" style="clear:both;">
					<?php if (!empty($service['ob_desc'])) { ?>
						<p><?php echo $service['ob_desc'];?></p>
					<?php } ?>
				</div>

			</div>
        </div>
            
        <div class="row ob_service_item visible-xs">
            <div class="col-xs-12">
            
                <div class="pull-left <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>">
                    <span><?php echo "{$service['title']} ({$service['duration_h']})";?></span>
                </div>
                 
                <div class="pull-right ob_service_price <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>">
                    <?php if ( !empty($currency_modifier) ) { ?>
                        <span style="margin-right: 1rem;background-color: #dbdbdb;padding: 0.4rem 0.5rem;border-radius: 0.25rem;font-size: 1.4rem;">
                            <?= $secondary_currency . " " . number_format($currency_modifier * $service['price_excl_tax'], 2) ?>
                        </span>
                    <?php } ?>
                    <span>
                        <?php
                        if($this->settings['show_prices_excl_tax_till_checkout']):
                            echo CURRENCY_PREFIX . number_format($service['price_excl_tax'], 2) . CURRENCY_SUFFIX;
                        else:
                            echo CURRENCY_PREFIX . number_format($service['price'], 2) . CURRENCY_SUFFIX;
                        endif;
                        ?>
                    </span>
                </div>
                
                <div style="clear:both; height:5px;"></div>
                
                <div class="pull-left">
                    <form method="post" role="form">
                        <input type="hidden" name="action" value="add_service">
                        <input type="hidden" name="service_id" value="<?php echo $service['id'];?>">
                        <select name="staff_id" class="form-control ob_item_staff" style="margin-top:10px;" <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo ' disabled="disabled"';?>>
                            <option value="0">Any staff member</option>
                            <?php 
                            $search_staff_id = empty($book_now_staff_id)? (empty($s_staff_data['id'])? 0 : $s_staff_data['id']) : $book_now_staff_id;
                            if (!empty($service['staff_list'])) { 
                                $selected_staff_id = null;
                                if (isset($service['cart_staff_id'])) {
                                    $selected_staff_id = $service['cart_staff_id'];
                                }
                                foreach ($service['staff_list'] as $staff) { 
                                    if (!isset($selected_staff_id) && $search_staff_id && $staff['id'] == $search_staff_id) {
                                        $selected_staff_id = $search_staff_id;
                                    }
                                    echo "<option value=\"{$staff['id']}\"" . (($staff['id'] == $selected_staff_id)? ' selected="selected"' : '') . ">{$staff['label']}</option>";
                                }
                            }
                            ?>	
                        </select>
                        <input class="btn btn-success btn-sm ob_service_add" style="" type="submit" value="Add to cart" <?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo ' disabled="disabled"';?>>
                    </form>
                </div>

                <?php if (!empty($service['ob_desc'])) { ?>
                <div class="<?php if ($service['in_cart'] && empty($multiple_same_service_in_cart)) echo 'text-danger';?>" style="clear:both; padding-top:10px;">
                    <p><?php echo $service['ob_desc'];?></p>
                </div>
                <?php } ?>

            </div>
        </div>
		<?php }} ?>
	</div>

</div>

<?php $this->load->view('footer'); ?>