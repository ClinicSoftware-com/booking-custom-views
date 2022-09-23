<?php
$nof_items = count($result);
?>

<div class="row" >

    <div class="list-group" id="rs_days" style="<?php if ($nof_items < 2) echo 'display:none;';?>">
        <?php 
        if (!empty($result)) {
            foreach($result as $rsk => $rs) { 
                $last_option  = end($rs);
                $first_option = reset($rs);
                $nof_slots = count($rs);
        ?>
        <a href="javascript:;" onclick="$('#rs_days').hide(); $('#result_set<?php echo $rsk;?>').show();" class="list-group-item ob_result_option" data-date="<?php echo $rsk;?>">
            <strong><?php echo date('d/m/Y', strtotime($rsk));?></strong>
            <span class="pull-right">
                <?php 
                echo $nof_slots . (($nof_slots > 1)? ' slots' : ' slot') . ' ';
                if ($first_option['ts_start'] != $last_option['ts_start']) { 
                    echo date('h:i A', $first_option['ts_start']) . ' - ' . date('h:i A', $last_option['ts_start']);
                } else {
                    echo date('h:i A', $first_option['ts_start']);
                }
                ?>
            </span>
        </a>
        <?php }} ?>
    </div>
    
    <?php if (!empty($result)) { foreach ($result as $rsk => $rs) { ?>
        <div id="result_set<?php echo $rsk;?>" style="<?php if ($nof_items > 1) echo 'display:none;';?>">
        
            <button onclick="$('#result_set<?php echo $rsk;?>').hide(); $('#rs_days').show();" 
                class="btn btn-lg btn-primary" 
                style="width:100%; margin:0 0 20px 0;"><?=__("Choose another date")?></button>
            
            <?php if (!empty($rs)) { ?>
            
            <?php foreach($rs as $option) { ?>
            
            <form class="ob_option_form" method="post" action="<?php echo $domain_base;?>online-booking/step3" onclick="this.submit();">
                <input type="hidden" name="booking_option" value="<?php echo base64_encode(gzcompress(json_encode($booking_options_session[$option['option_id']]), 2));?>" />
                <input type="hidden" name="lh" value="" />
                
                <div class="ob_option_item">
                    <table>
                        <?php for($i=0, $n=count($option['assigned_staff']); $i < $n; $i++) { ?>
                        <tr onclick="location.replace('<?php echo "{$domain_base}online-booking/step3/{$option['option_id']}";?>');">
                        
                            <?php if (!$i) { ?>
                            <td rowspan="<?php echo $n;?>" class="ob_option_title" ><?php echo $option['time_start'];?><br /><span style="font-weight:normal; font-size:14px;"><?php echo date('d/m/Y', strtotime($rsk));?></span>
                            </td>
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
            
            <button onclick="$('#result_set<?php echo $rsk;?>').hide(); $('#rs_days').show();" 
                class="btn btn-lg btn-primary" 
                style="width:100%; margin:20px 0 20px 0;"><?=__("Choose another date")?></button>
            
            <?php } ?>
            
        </div>
        
    <?php }} ?>

</div>