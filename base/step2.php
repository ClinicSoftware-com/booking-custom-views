<?php $this->load->view('main_head'); ?>

<link rel="stylesheet" href="/static/select2/css/select2.min.css">
<link rel="stylesheet" href="/static/select2/css/select2-bootstrap.min.css">
<script src="/static/select2/js/select2.full.min.js"></script>

</head>
<body role="document">

<a class="pos_app_btn" id="pos_app_close_btn" style="display:none;"><span class="glyphicon glyphicon-remove"></span></a>
<a class="pos_app_btn" id="pos_app_minimize_btn" style="display:none;"><span
            class="glyphicon glyphicon-minus"></span></a>
<script>
    if (nw_win && typeof global.setup_menu == 'undefined') {
        $('.pos_app_back_btn').show();
        $('.pos_app_btn').show();
        $('#pos_app_close_btn').click(function () {
            nw_win.close();
        });
        $('#pos_app_minimize_btn').click(function () {
            nw_win.minimize();
        });
    }
</script>

<?php $this->load->view('navigation'); ?>

<div class="container theme-showcase main_content online_booking" role="main">

    <?php if (empty($is_embed)) { ?>
        <div class="page-header">
            <h1><?= __("Online Booking") ?></h1>
        </div>
    <?php } ?>

    <?php $this->flash->printMessages(); ?>

    <?php $this->load->view('pages/booking/booking_progress_step2'); ?>

    <a class="btn btn-default" id="ob_step2_back_btn" href="<?php echo "{$domain_base}online-booking"; ?>"><span
                class="glyphicon glyphicon-backward"></span> <?php echo __('back') ?></a>
    <script>
        $(function () {
            if (location.hash) {
                let $btn = $('#ob_step2_back_btn');
                $btn.attr('href', $btn.attr('href') + location.hash);
            }
        });
    </script>

    <?php $this->load->view('pages/booking/booking_cart'); ?>

    <?php $this->load->view('pages/booking/step2_upsell', $this->view_data) ?>

    <?php if ($booking_interval): ?>
        <?php $this->load->view('pages/booking/step2_booking_interval'); ?>
    <?php else: ?>
        <div class="row">
            <div class="col-sm-3">
                <div class="list-group" id="ob_dates_list">

                    <?php if (!empty($ob_search_enabled)) { ?>
                        <a class="list-group-item" id="btn_ob_open_search_availability"
                           style="font-weight:bold; color:#ff0000;"
                           onclick="booking.showSearchOptions(); booking.searchBookingOptions();"><?php echo __('search_next_available_slot') ?></a>
                    <?php } ?>

                    <?php foreach ($dates_list as $date_item) {
                        echo "<a class=\"list-group-item ob_date_option" . (($date_item['is_disabled']) ? ' disabled' : '') . "\" data-date=\"{$date_item['value']}\"><strong>" . __(strtolower($date_item['label1'])) . "</strong><span class=\"pull-right\">{$date_item['label2']}</span></a></li>";
                    } ?>
                    <a class="list-group-item" id="ob_datepicker"><strong><?= __("Select date"); ?>..</strong></a>
                </div>
            </div>
            <div class="col-sm-9">

                <div id="ob_search_availabilty" style="display:none;">

                    <form id="ob_search_availabilty_form" method="post" onsubmit="return false;">
                        <div class="row" style="margin:0;">
                            <div class="col-lg-2 col-md-6 col-xs-6" style="padding:0 5px;">
                                <label style="width:100%;"><?php echo __('from_date') ?>
                                    <?php if ($this->settings['usa_date_format']): ?>
                                        <input type="text" id="sa_from_date" name="sa_from_date"
                                               class="form-control datepicker" style="width:100%;"
                                               value="<?php echo empty($select_date) ? date('m/d/Y') : date('m/d/Y', strtotime($select_date)); ?>"
                                        >
                                    <?php else: ?>
                                        <input type="text" id="sa_from_date" name="sa_from_date"
                                               class="form-control datepicker" style="width:100%;"
                                               value="<?php echo empty($select_date) ? date('d/m/Y') : date('d/m/Y', strtotime($select_date)); ?>"
                                        >
                                    <?php endif; ?>

                                </label>
                            </div>
                            <?php
                            if ($settings['booking_steps__time_filter__enabled']) { ?>
                                <div class="col-lg-2 col-md-6 col-xs-6" style="padding:0 5px;">
                                    <label style="width:100%;"><?php echo __('from_time') ?>
                                        <select id="sa_from_time" name="sa_from_time" class="form-control"
                                                style="width:100%;">
                                            <?php
                                            if (!empty($sa_time_list)) {
                                                foreach ($sa_time_list as $item) { ?>
                                                    <option value="<?= $item['regular'] ?>"><?= $item['time'] ?></option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </label>
                                </div>
                            <?php } ?>

                            <div class="col-lg-6 col-md-10 col-xs-12" style="padding:0 5px;">
                                <label style="width:100%;"><?php echo __('staff') ?>
                                    <select id="sa_staff" name="sa_staff[]" class="form-control" style="width:100%;"
                                            multiple="multiple">
                                        <?php if (!empty($sa_staff_list)) {
                                            foreach ($sa_staff_list as $sa_staff) { ?>
                                                <option value="<?php echo $sa_staff['id']; ?>"><?php echo htmlentities("{$sa_staff['nickname']} ({$sa_staff['staff_type_title']})"); ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </label>
                            </div>

                            <div class="col-lg-2 col-md-2 col-xs-12" style="padding:0 5px;">
                                <label style="float:right; width:100%;">&nbsp;
                                    <button onclick="booking.searchBookingOptions();"
                                            class="form-control btn btn-success"
                                            style="width:100%;"><?php echo __('search') ?></button>
                                </label>
                            </div>
                        </div>
                    </form>
                    <hr/>

                    <div id="ob_search_availabilty_results"></div>

                </div>

                <div id="ob_select_date_message" class="noselect">
                    <h2>Select an option to view available appointment slots</h2>
                    <span class="glyphicon glyphicon-calendar"></span>
                </div>

                <div id="ob_load_indicator" class="noselect" style="display:none;">
                    <h2>Searching for available appointment slots</h2>
                    <img src="/static/img/loading.gif">
                </div>

                <div id="ob_booking_options" style="display:none;">
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>

<script>

    $.fn.select2.defaults.set("theme", "bootstrap");

    <?php if($this->settings['usa_date_format']):  ?>
    var sa_from_date = $('#sa_from_date').datepicker({
        format: "mm/dd/yyyy",
        weekStart: 1,
        keyboardNavigation: false,
        todayHighlight: true,
        forceParse: false
    });
    <?php else: ?>
    var sa_from_date = $('#sa_from_date').datepicker({
        format: "dd/mm/yyyy",
        weekStart: 1,
        keyboardNavigation: false,
        todayHighlight: true,
        forceParse: false
    });
    <?php endif; ?>

    sa_from_date
        .on('show', function (ev) {
            if (typeof to_datepicker !== 'undefined') {
                to_datepicker.datepicker('hide');
            }
        })
        .on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });

    $('#ob_datepicker').datepicker({
        format: "yyyy-mm-dd",
        weekStart: 1,
        startDate: "<?php echo $calendar_date;?>",
        keyboardNavigation: false,
        forceParse: false,
        todayHighlight: true
    });

    $('#sa_staff').select2({
        placeholder: "<?php echo __('any_staff_member'); ?>"
    });

    <?php if (!empty($select_date)) { ?>
    booking.loadBookingOptions('<?php echo $select_date;?>');
    <?php } else { ?>
    $('#btn_ob_open_search_availability').click();
    <?php } ?>

</script>

<?php $this->load->view('footer'); ?>
<?php $this->load->view('main_footer'); ?>
</body>
</html>