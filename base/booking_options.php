<div class="row" >
	<div id="ob_calendar_control">
		<a class="btn btn-default btn-sm" data-date="<?php echo $calendar_control['prev_day']['value'];?>" <?php if (!$calendar_control['prev_day']['value']) echo ' disabled="disabled"';?>><span class="glyphicon glyphicon-backward"></span> <?php echo $calendar_control['prev_day']['label'];?></a>
		<a class="btn btn-default btn-sm" data-date="<?php echo $calendar_control['next_day']['value'];?>"><span class="glyphicon glyphicon-forward"></span> <?php echo $calendar_control['next_day']['label'];?></a>
		
		<div class="center-block">
			<h4>Showing availability for <?php echo $calendar_date;?></h4>
		</div>
		
		<hr>
	</div>

	
	<?php 
    foreach($booking_options as $option) { 
    ?>
    <form class="ob_option_form" method="post" action="<?php echo $domain_base;?>online-booking/step3" onclick="this.submit();">
        <input type="hidden" name="booking_option" value="<?php echo base64_encode(gzcompress(json_encode($option), 2));?>" />
        <input type="hidden" name="lh" value="" />
        
        <div class="ob_option_item">
            <table>
                <?php for($i=0, $n=count($option['assigned_staff']); $i < $n; $i++) { ?>
                <tr>
                
                    <?php if (!$i) { ?>
                    <td rowspan="<?php echo $n;?>" class="ob_option_title"><?php echo $option['time_start'];?></td>
                    <?php } ?>
                    
                    <td><?php echo $option['assigned_staff'][$i]['item_title_short'];?></td>
                    
                    <td>
                    <?php echo htmlentities($option['assigned_staff'][$i]['staff_nickname']); 
                    if (!empty($ob_show_staff_function)) echo ' (' . htmlentities($option['assigned_staff'][$i]['staff_type']) . ')';?>
                    </td>
                    
                    <?php if (!$i) { ?>
                    <td rowspan="<?php echo $n;?>" class="ob_option_action">
                        <button class="btn btn-default btn-success">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>
                    </td>
                    <?php } ?>
                    
                </tr>
                <?php } ?>
            </table>
        </div>
    </form>
	<?php } ?>

	<?php if (!empty($diagnostics)) { echo "<br><pre>{$diagnostics}</pre>"; } ?>

</div>