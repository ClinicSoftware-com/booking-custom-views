<?php if (empty($is_embed)) { ?>

    <script>
        function scrollToInvalid() {

            // Height of nav bar plus a bottom margin
            var navHeight = 70;

            // Offset of the first input element minus your nav height
            var invalid_el = $('input:invalid').first().offset().top - navHeight;

            // If the invalid element is already within the window view, return true. If you return false, the validation will stop.
            if (invalid_el > (window.pageYOffset - navHeight) && invalid_el < (window.pageYOffset + window.innerHeight - navHeight)) {
                return true;
            } else {
                // If the first invalid input is not within the current view, scroll to it.
                $('html, body').scrollTop(invalid_el);
            }
        }
        $('input').on('invalid', scrollToInvalid);
    </script>

    <div style="clear:both; height:80px;"></div>

    <?php
    $mobile_footer_btn_width = empty($footer_call_us_phone_nr) ? 33 : 25;
    ?>

    <script>
        $('#btn_open_mobile_full_menu').click(function() {
            $('div.main_content').hide();
            //$('#footer').hide();
            $('#mobile_footer_container').hide();
            $('.mobile_full_menu').show();
            window.scrollTo(0, document.body.scrollHeight);
        });

        $('#btn_close_mobile_full_menu').click(function() {
            $('div.main_content').show();
            //$('#footer').show();
            $('#mobile_footer_container').show();
            $('.mobile_full_menu').hide();
            window.scrollTo(0, 0);
        });
    </script>


    <?php if (!empty($ios_app)) { ?>
        <div class="app_mobile_full_menu" style="display:none;">
            <table width="100%">
                <tr>
                    <td width="50%" align="left">
                        <a href="<?php echo $domain_base; ?>cityluxmassage_app_ios" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-home btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Home</span>
                        </a>
                    </td>
                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>online-booking" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-calendar btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Book online</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <a href="<?php echo $domain_base; ?>treatments" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-list-alt btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Treatments</span>
                        </a>
                    </td>
                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>therapists" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-user btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Therapists</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <a href="<?php echo $domain_base; ?>about-us" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-question-sign btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">About us</span>
                        </a>
                    </td>
                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>messages" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-comment btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Live Chat</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <a href="<?php echo $domain_base; ?>my-account/appointments" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-book btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">My Appointments</span>
                        </a>
                    </td>

                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>terms-conditions" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-link btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Terms and conditions</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <a href="<?php echo $domain_base; ?>my-account/purchase-history" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-gbp btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Purchase history</span>
                        </a>
                    </td>
                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>staff/login/asd" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-star btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Staff Login</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <a id="btn_app_close_mobile_full_menu" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-circle-arrow-left mobile_footer_btn_icon"></span>
                            <span class="btn_mobile_full_menu_label">BACK</span>
                        </a>
                    </td>
                    <td width="50%" align="right">
                        <a href="<?php echo $domain_base; ?>contact" class="btn btn btn-default btn_mobile_full_menu">
                            <span class="glyphicon glyphicon-earphone btn_mobile_full_icon"></span>
                            <span class="btn_mobile_full_menu_label">Contact us</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <script>
            var current_html_overflow = $('html').css('overflow');
            $('#btn_app_open_mobile_full_menu').click(function() {
                $('html').css('overflow', 'auto');
                $('div.main_content').hide();
                //$('#footer').hide();
                $('#mobile_footer_container').show();
                $('.app_mobile_full_menu').show();
                $('.bg').hide();
            });

            $('#btn_app_close_mobile_full_menu').click(function() {
                $('html').css('overflow', current_html_overflow);
                $('div.main_content').show();
                //$('#footer').show();
                $('#mobile_footer_container').show();
                $('.app_mobile_full_menu').hide();
                $('.bg').show();
            });
        </script>

    <?php } ?>

    <div id="footer">
        <div class="container-fluid page_container" style="margin-left:auto !important; margin-right:auto !important; padding:0 15px !important; background-color:initial;">
            <div class="row">
                <div class="col-xs-12">
                    <div class="pull-left">
                        <a target="_blank" title="Clinic Software®.com" href="http://clinicsoftware.com/">&copy; <?php echo date('Y'); ?> ClinicSoftware.com</a>
                    </div>
                    <div class="pull-right"><?php echo htmlentities($sitename); ?></div>
                </div>
            </div>
        </div>
    </div>

<?php } // end is_embed 
?>