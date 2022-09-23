<?php
require("./settings.php");
?>

<head>
    <meta name="robots" content="noindex,nofollow,noarchive,nosnippet">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="keywords" content="">
    <meta name="description" content="description">


    <title>Demo - Online Booking</title>

    <link rel="icon" sizes="192x192" href="https://appointments.clinicsoftware.com/static/img/touch_icon/touch-icon-192x192.png">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-180x180-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-152x152-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-120x120-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-76x76-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="https://appointments.clinicsoftware.com/static/img/touch_icon/apple-touch-icon-precomposed.png">

    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/datepicker.css">
    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/featherlight.min.css">
    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/notie.min.css">
    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/style.css?v=2.72.3">

    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/navbar_templates/navbar_1.css">




    <style>
        /* My Account Button */
        .navbar #my_account_frm .btn-group .btn,
        .navbar #my_account_frm .dropdown-menu>.active>a {
            background-color: #34495e;
            color: white;
        }

        .navbar #my_account_frm .btn-group .btn:hover {
            background-color: #34495e95 !important;
        }

        /* Navbar Underline Link */
        .navbar-default .navbar-nav>li>a {
            border-bottom: 3px solid #34495e40;
        }

        .navbar-default .navbar-nav>.active>a {
            border-bottom: 3px solid #34495e;
        }

        /* Booking Steps */
        .bs-wizard>.bs-wizard-step.active>.bs-wizard-dot,
        .bs-wizard>.bs-wizard-step.complete>.bs-wizard-dot {
            background-color: #34495e60;
        }

        .bs-wizard>.bs-wizard-step.active>.bs-wizard-dot:after,
        .bs-wizard>.bs-wizard-step.complete>.bs-wizard-dot:after {
            background-color: #34495e;
        }

        .bs-wizard>.bs-wizard-step>.progress>.progress-bar {
            background-color: #34495e60;
        }

        .bs-wizard>.bs-wizard-step>.bs-wizard-info>a {
            color: #34495e;
        }
    </style>












    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <style>
        *:not(.fa):not(.fas):not(.glyphicon) {
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <style>
        .btn-success {
            background-color: #34495e !important;
            border-color: #34495e !important;
        }
    </style>

    <link rel="stylesheet" href="https://bookings.clinicsoftware.comhttps://appointments.clinicsoftware.com/static/css/style.css?v=2.72">


    <style>
        :root {
            --button-color: #34495e;
            --link-dash-color: #34495e;
            --step-bullets-color: #34495e;
        }
    </style>

    <link rel="stylesheet" href="https://appointments.clinicsoftware.com/static/css/app_responsive.css?v=1663928205">

    <!--[if lt IE 9]>
        <script src="https://appointments.clinicsoftware.com/static/js/html5shiv.min.js"></script>
        <script src="https://appointments.clinicsoftware.com/static/js/respond.min.js"></script>
    <![endif]-->

    <script src="https://appointments.clinicsoftware.com/static/js/jquery-1.11.0.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/jquery.cookie.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/bootstrap.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/bootstrap-paginator.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/bootstrap-datepicker.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/docs.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/layout.engine.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/featherlight.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/notie.min.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/app_notif.js"></script>
    <script src="https://appointments.clinicsoftware.com/static/js/bootbox.min.js"></script>


    <script src="https://appointments.clinicsoftware.com/static/js/main.js?v=2.72.3"></script>



    <style id="holderjs-style" type="text/css"></style>
</head>

<div class="container theme-showcase main_content online_booking" role="main">
    <?php if (empty($is_embed)) { ?>
        <div class="page-header">
            <h1>online_booking</h1>
        </div>
    <?php } ?>

    <?php
    require('./booking_progress_step1.php');
    require('./booking_cart.php');
    $ob_selected_salon = $_SESSION['ob_selected_salon'] ?? null;
    ?>

    <div class="row">

        <div class="col-xs-12">
            <div class="ob_salon_selection">
                <?php if (!empty($salons_list) && count($salons_list) > 1) { ?>
                    <form id="salon_change_form" method="post" role="form" onsubmit="return false;">
                        <input type="hidden" id="current_ob_salon" value="<?php echo $selected_salon; ?>">
                        <input type="hidden" name="action" value="change_salon">

                        <select id="ob_salon" name="ob_salon" class="form-control" style="float:left; width:267px; margin:3px;">

                            <?php foreach ($salons_list as $salon) { ?>
                                <option value="<?= $salon['id'] ?>" <?= ($salon['id'] == $ob_selected_salon) ? "selected=\"selected\"" : "" ?>>
                                    <?= $salon['title'] ?>
                                </option>
                            <?php } ?>

                        </select>

                    </form>
                <?php } ?>
                <form method="post" role="form">
                    <input type="hidden" name="action" value="clear_cart">
                    <input class="btn btn-default" style="float:left; margin:3px;" type="submit" value="Clear treatment list">
                </form>
                <div style="clear:both;"></div>
            </div>
        </div>

    </div>

    <script>
        var current_ob_salon_val = $('#ob_salon').val();
        $('#ob_salon').change(function(e) {
            if (booking.confirmSalonChange()) {
                $('#salon_change_form')[0].submit();
            } else {
                $(this).val(current_ob_salon_val);
            }
            return false;
        });
    </script>

    <?php if (!empty($ob_message)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <p style="font-weight:bold;"><?php echo $ob_message; ?></p>
            </div>
        </div>
    <?php } ?>

    <div class="row" id="services_categories">
        <div class="col-xs-12">
            <h4>Appointment History</h4>
            <div class="list-group nav">
                <a class="list-group-item" href="<?php echo "{$domain_base}my-account/appointments"; ?>">My Booking History</a>
            </div>
        </div>
    </div>

    <?php if (!empty($services)) {
        foreach ($services as $service_section) { ?>
            <div class="row">
                <div class="col-xs-12">
                    <h4>
                        <?php
                        if (!empty($multilanguage_enabled)) {
                            if (!empty($service_section['title_ml'][$this->language_code])) {
                                echo $service_section['title_ml'][$this->language_code];
                            } else {
                                echo $service_section['title_ml']['en'];
                            }
                        } else {
                            echo $service_section['title'];
                        }
                        ?>
                    </h4>
                    <div class="list-group">
                        <?php if (!empty($service_section['categories'])) {
                            foreach ($service_section['categories'] as $service_category) { ?>
                                <a class="list-group-item" href="<?php echo "{$domain_base}online-booking/services/{$service_category['id']}"; ?>">
                                    <?php
                                    if (!empty($multilanguage_enabled)) {
                                        if (!empty($service_category['title_ml'][$this->language_code])) {
                                            echo $service_category['title_ml'][$this->language_code];
                                        } else {
                                            echo $service_category['title_ml']['en'];
                                        }
                                    } else {
                                        echo $service_category['title'];
                                    }
                                    ?>
                                </a>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
    <?php }
    } ?>


    <?php if (!empty($ob_book_my_courses_enabled) || !empty($ob_book_new_pt_enabled) || !empty($ob_book_new_courses_enabled)) { ?>
        <div class="row">
            <div class="col-xs-12">
                <h4>Course</h4>
                <div class="list-group">

                    <?php if (!empty($ob_book_my_courses_enabled)) { ?>
                        <a class="list-group-item" href="<?php echo $domain_base; ?>online-booking/my-courses">My Courses</a>
                    <?php } ?>

                    <?php if (!empty($ob_book_new_pt_enabled)) { ?>
                        <a class="list-group-item" href="<?php echo $domain_base; ?>online-booking/my_patch_tests">My Patch Tests</a>
                    <?php } ?>

                    <?php if (!empty($ob_book_new_courses_enabled)) { ?>

                        <?php if (!empty($ob_book_courses_prompt_enabled)) { ?>
                            <a class="list-group-item" href="<?php echo $domain_base; ?>online-booking/courses_prompt">Book New Course</a>
                        <?php } else { ?>

                            <a class="list-group-item" href="<?php echo $domain_base; ?>online-booking/courses">Book New Course</a>

                        <?php } ?>

                    <?php } ?>

                </div>
            </div>
        </div>
    <?php } ?>

</div>
<?php require('./footer.php'); ?>