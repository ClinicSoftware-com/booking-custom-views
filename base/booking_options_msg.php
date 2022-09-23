<div class="row noselect" id="ob_msg">

    <?php if (!empty($calendar_control['prev_day']['value']) || !empty($calendar_control['next_day']['value'])) { ?>
	<div id="ob_calendar_control">
    
        <?php if (!empty($calendar_control['prev_day']['value'])) { ?>
		<a class="btn btn-default btn-sm" data-date="<?php echo $calendar_control['prev_day']['value'];?>" <?php if (!$calendar_control['prev_day']['value']) echo ' disabled="disabled"';?>><span class="glyphicon glyphicon-backward"></span> <?php echo $calendar_control['prev_day']['label'];?></a>
		<?php } ?>
        
        <?php if (!empty($calendar_control['next_day']['value'])) { ?>
        <a class="btn btn-default btn-sm" data-date="<?php echo $calendar_control['next_day']['value'];?>"><span class="glyphicon glyphicon-forward"></span> <?php echo $calendar_control['next_day']['label'];?></a>
		<?php } ?>
        
        <div style="height:20px;"></div>
		<hr>
	</div>
    <?php } ?>

	<h2><?php echo $msg;?></h2>
	
</div>