/*
 Template Name: Nokri Job Board Theme
 Author: ScriptsBundle
 Version: 1.4.7
 Designed and Development by: ScriptsBundle
 
 ====================================
 [ CSS TABLE CONTENT ]
 ------------------------------------
 1.0 - Pre Loader
 2.0 - Counter Up
 3.0 - OUR CLIENTS CAROUSEL
 4.0 - TESTIMONIAL 1
 5.0 - TESTIMONIAL 2
 6.0 - ACCORDIAN
 7.0 - FOOTER REVEAL
 8.0 - SEACRH FIXED
 9.0 - MENU
 10.0 - SCROLL TO TOP
 11.0 - FILE UPLOADER
 -------------------------------------
 [ END CSS TABLE CONTENT ]
 =====================================
 */
(function ($) {
    "use strict";

    $('.cand_type_form').on("click", function () {
        $('form#cand_type_form').submit();
    });

    $('.cand_level_form').on("click", function () {
        $('form#cand_level_form').submit();
    });

    $('.cand_skills_form').on("click", function () {
        $('form#cand_skills_form').submit();
    });

    $('.cand_experience_form').on("click", function () {
        $('form#cand_experience_form').submit();
    });


    $(".candidates_orders").change(function () {
        $('form#candiate_order').submit();
    });


    $('.new-sidebar .panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
    });

    $('.new-sidebar .panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
    });

    /*JQUERY SELECT*/

    $(".orderby").select2({});



    $(".js-example-basic-single").select2({
        // placeholder: get_strings.template_select,
        allowClear: true,
        maximumSelectionLength: 8,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            },
            maximumSelected: function (e) {
                var t = get_strings.max_select + e.maximum;
                return t;
            },
        }
    });
    $('p:empty').remove();
    // Log In Model
    $('.search_company').on("click", function () {
        $('form#company_form').submit();
    });

    $(".search_company").change(function () {
        $('form#company_form').submit();
    });

    /* add more skills */
    $('.skills-gen').multifield({
        section: '.group',
        btnAdd: '#btnAdd-2',
        btnRemove: '.btnRemove',
        locale: {
            "multiField": {
                "messages": {
                    "removeConfirmation": get_strings.content,
                }
            }
        }
    });
    /* add more questions */
    $('.questions').multifield({
        section: '.group',
        btnAdd: '#question_btn',
        btnRemove: '.btnRemove',
        locale: {
            "multiField": {
                "messages": {
                    "removeConfirmation": get_strings.content,
                }
            }
        }
    });
    // Candidate saving job alerts model
    $(".job_alert").click(function () {


        $("#job-alert-subscribtion").modal({});

        var map_type = get_strings.nokri_map_type;
        if ($('#job-alert-subscribtion').length > 0 && map_type == 'google_map') {
            $('#job-alert-subscribtion').on('shown.bs.modal', function (e) {
                var input = document.getElementById("sb_user_address2");
                var autocomplete = new google.maps.places.Autocomplete(input);
            })
        }
        $('#get_child_loc_lev1').hide();
        $('#get_child_loc_lev2').hide();
        $('#get_child_loc_lev5').hide();
        $(".select-generat").select2({
            placeholder: get_strings.option_select,
            allowClear: true,
            maximumSelectionLength: 15,
            language: {
                noResults: function (params) {
                    return get_strings.no_res;
                }
            }
        });
    });
    //restrict job update  
    if ($("#job_update_restrict").length > 0) {
        var restrict_val = $("#job_update_restrict").val();

        if (restrict_val == "1") {
            $("#ad_title").remove();
            $("#ad_title").on('keydown', function (event) {
                event.preventDefault();
            });
        }
    }

    /* Candidate Subscribing job alerts */
    $(document).on('click', '#job_alerts', function () {
        $('#alert_job_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'job_alert_subscription',
                        submit_alert_data: $("form#alert_job_form").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) == '1') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.action_success,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '2') {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '3') {
                            toastr.warning($('#not_log_in').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '4') {
                            toastr.warning($('#not_cand').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });
    $(document).on('click', '#submit_paid_alerts', function () {
        $('#alert_job_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'job_alert_paid_subscription',
                        submit_alert_data: $("form#alert_job_form").serialize(),
                        nonce: get_strings.nonce,
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        var get_r = response.split('|');
                        if ($.trim(response) == '1') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.action_success,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '2') {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '3') {
                            toastr.warning($('#not_log_in').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '4') {
                            toastr.warning($('#not_cand').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(get_r[0]) == '1') {
                            toastr.success(get_r[1], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            window.location = get_r[2];
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });
    /* Candidate Upload resume at apply time */
    $('body').on('change', '.upload_resume_now', function (e) {


        var fd = new FormData();
        var files_data = $('.form-group .upload_resume_now');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('upload_resume_now[' + j + ']', file);
            });
        });
        fd.append('action', 'upload_resume_now');

        $('.cp-loader').show();
        $('#progress_loader').show();
        $("#submit_cv_form_btn").prop('disabled', true);
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        var per = Math.round(percentComplete) + "%";
                        var kbs = evt.loaded / 1000 + "  Kb" + "/ " + evt.total / 1000 + " kb";
                        $('#progress_counter').html(kbs + "     " + per);
                    }

                }, false);
                return xhr;
            },

            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.cp-loader').hide();
                $('#progress_loader').hide();
                $("#submit_cv_form_btn").prop('disabled', false);

                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    toastr.success($('#emp_resume_save').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    $("#current_resume").val(res_arr[1]);
                } else if ($.trim(res_arr[0]) == "2") {
                    toastr.warning($('#demo_mode').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            }
        });


    });

    /* Candidate Upload resume from resume tabs */
    $('body').on('change', '.upload_resume_tab', function (e) {
        var fd = new FormData();
        var files_data = $('.upload_resume_tab');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('upload_resume_tab[' + j + ']', file);
            });
        });

        $('#progress_loader').show();
        fd.append('action', 'upload_resume_from_tab');
        $('.cp-loader').show();
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        var per = Math.round(percentComplete) + "%";
                        var kbs = evt.loaded / 1000 + "  Kb" + "/ " + evt.total / 1000 + " kb";
                        $('#progress_counter').html(kbs + "     " + per);
                    }

                }, false);
                return xhr;
            },
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {


                console.log(res);
                $('#progress_loader').hide();
                $('.cp-loader').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "0")
                {
                    toastr.warning(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else if ($.trim(res_arr[0]) == "1")
                {
                    toastr.warning(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else if ($.trim(res_arr[0]) == "2")
                {
                    toastr.warning(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else if ($.trim(res_arr[0]) == "3")
                {
                    toastr.warning(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else if ($.trim(res_arr[0]) == "4")
                {
                    toastr.success(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    location.reload();
                } else if ($.trim(res_arr[0])) {
                    toastr.warning(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            }
        });


    });

    $("#input-b1").fileinput({

        browseLabel: get_strings.browse_btn,
        removeLabel: get_strings.remove_btn,
        msgPlaceholder: get_strings.select_btn,
    });
    $(".input-b2").fileinput({

        browseLabel: get_strings.browse_btn,
        removeLabel: get_strings.remove_btn,
        msgPlaceholder: get_strings.select_btn,
    });

    $("#imgdp").fileinput({
        browseLabel: get_strings.browse_btn,
        removeLabel: get_strings.remove_btn,
        msgPlaceholder: get_strings.select_btn,
    });

    /* Candidate Deleting Saved alerts */
    $(".del_save_alert").on("click", function () {
        var alert_id = $(this).attr("data-value");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'del_job_alerts',
                            alert_id: alert_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#alert-box-" + alert_id).remove();
                            } else if ($.trim(response) == '2') {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });
    /*iCheck for others*/
    $(window).load(function () {
        $('.input-icheck-others').iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square',
            increaseArea: '10%'
        });
    });
    /*Skills bar*/
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'manual'
        }).tooltip('show');
    });

    $(window).scroll(function () {

        if ($(window).scrollTop() > 10) { // scroll down abit and get the action   
            $(".progress-bar").each(function () {
                var each_bar_width = $(this).attr('aria-valuenow');
                $(this).width(each_bar_width + '%');
            });

        }
    });


    /*SCROLL TO SPASIFIC BLOCK*/
    $(function () {

        $('a[href*="#"].scroller:not([href="#"])').click(function () {

            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.substr(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        });
    });


    /*iCheck*/
    /*$(document).ready(function(){
     $('.input-icheck').iCheck({
     checkboxClass: 'icheckbox_square',
     radioClass: 'iradio_square',
     increaseArea: '10%' 
     });
     });*/
    // Alphabet Click
    $('.alphabets a').on("click", function () {
        $('.cp-loader').show();
        var value = $(this).data("value");
        $("#alphabet").val(value);
        $('form#alphabets_form').submit();
    });
    // Candidalte List order
    $(".cand_list_order").change(function () {
        $('.cp-loader').show();
        $('form#cand_list_order').submit();
    });
    $(".job_search").change(function () {
        $('form#job_search').submit();
    });

    $('.search_job').on("click", function () {
        $('form#sav_job_search').submit();
    });

    $('.search_aplied_job').on("click", function () {
        $('form#job_search').submit();
    });

    /*--- Employer Active Job Form ---*/
    $('.submit_emp_active_job_form').on("click", function () {
        $('form#emp_active_job').submit();
    });


    $('.submit_applier_form').on("click", function () {
        $('form#applier_filter_form').submit();
    });

    $(".emp_active_job").change(function () {
        $('form#emp_active_job').submit();
    });
    /** candidate filter  **/
    $(".applier_filter_select").change(function () {
        $('form#applier_filter_form').submit();
    });
    /*--- Employer matched resumes ---*/
    $('.emp_matched_resumes').on("click", function () {
        $('form#emp_matched_resumes').submit();
    });

    $(".emp_matched_resumes").change(function () {
        $('form#emp_matched_resumes').submit();
    });





    /*--- End Employer Active Job Form  ---*/

    /*--- Employer Followers  Form ---*/
    $(".emp_followers_form").change(function () {
        $('form#follower_form').submit();
    });
    /*--- Employer Followers  Form ---*/


    /*--- Employer saved resume  form ---*/
    $(".emp_saved_resumes_form").change(function () {
        $('form#emp_saved_resumes_form').submit();
    });
    /*--- Employer Followers  Form ---*/

    /*--- Employer matched resume  form ---*/
    $(".emp_matched_resumes_form").change(function () {
        $('form#emp_matched_resumes_form').submit();
    });
    $('.emp_matched_resumes_form').on("click", function () {
        $('form#emp_matched_resumes_form').submit();
    });
    /*--- Employer Followers  Form ---*/



    /*--- Employer Resumes  Form ---*/

    $('.search_resume').on("click", function () {
        $('form#emp_resumes_form').submit();
    });

    $(".resumes_filter").change(function () {
        $('form#emp_resumes_form').submit();
    });
    /*--- Employer Followers  Form ---*/

    /*--- Employer Pakckages  Form ---*/
    $(".order_form").change(function () {
        $('form#order_form').submit();
    });


    /*--- Toggle Value ---*/
    $('input[name="is_opened_all"]').on('switchChange.bootstrapSwitch', function (event, state) {
        $("#business-hours-fields").slideToggle("slow");
        $("#timezone").slideToggle("slow");
    });
    /*--- Toggle Value ---*/
    $("#sortable").sortable();
    $("#sortable").disableSelection();
    /*--- PRE LOADER JS ---*/

    var nokri_ajax_url = $('#nokri_ajax_url').val();
    /*--- Counter Up---*/

    $('.counter-stats').counterUp({
        delay: 10,
        time: 2000
    });

    /* ======= Candidate slider ======= */
    $('.n-candidatel-2').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });



    /* ======= Masonry Grid System ======= */
    $('.posts-masonry').masonry();
    /*--- OUR CLIENTS CAROUSEL---*/
    $(".clients-list").owlCarousel({
        nav: false,
        loop: true,
        margin: 10,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed: 3000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 4,
            },
            1000: {
                items: 6,
            }
        }
    });

    /*--- Owl  Carousel clients --*/
    $('.n-client-box').owlCarousel({
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
    });


    /*--- Hiring carousel---*/
    $('.hiring-slider').owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });




    /*--- Owl  Carousel --*/
    $(".featured-job-slider").owlCarousel({
        nav: true,
        navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
        loop: false,
        dots: false,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 1500,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            }
        }
    });

    /*--- Clients carousel---*/
    $('.n-owl-testimonial-23').owlCarousel({
        dots: false,
        loop: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });





    $('.n-owl-testimonial-2').owlCarousel({
        nav: true,
        navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
        dots: true,
        loop: true,
        margin: 20,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    //Job apply with external link
    $('#ad_external').on('select2:select', function (e) {
        var link_val = $("#ad_external").select2('val');


        if (link_val == 'exter') {
            $('#job_external_link_feild').show();
            $('#job_external_mail_feild').hide();
            $('#job_external_whatsapp_feild').hide();
            $('#job_external_url').prop('required', true);
        } else if (link_val == 'mail') {
            $('#job_external_link_feild').hide();
            $('#job_external_mail_feild').show();
            $('#job_external_whatsapp_feild').hide();
            $('#job_external_email').prop('required', true);
        } else if (link_val == 'whatsapp') {
            $('#job_external_link_feild').hide();
            $('#job_external_mail_feild').hide();
            $('#job_external_whatsapp_feild').show();
            $('#job_external_whatsapp').prop('required', true);
        } else {
            $('#job_external_url').removeAttr('required');
            $('#job_external_email').removeAttr('required');
            $('#job_external_link_feild').hide();
            $('#job_external_mail_feild').hide();

        }
    });

    /*--- MAIN SECTION CATS---*/
    $(".featured-cat").owlCarousel({
        nav: false,
        loop: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplaySpeed: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 5,
            },
            1000: {
                items: 6,
            }
        }
    });


    /*--- TESTIMONIAL 2---*/

    $(".owl-testimonial-2").owlCarousel({
        nav: false,
        navText: false,
        loop: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 1500,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            }
        }
    });

    /*--- job cand cat slider---*/
    $('.job-cat-cand-slider').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    $('.success1-slider').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
        }
    });

    /*--- TESTIMONIAL 1---*/
    $("#owl-testimonial").owlCarousel({
        nav: false,
        //navText:["<i class='ti-angle-left'></i>","<i class='ti-angle-right'></i>"],
        loop: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 7000,
        autoplaySpeed: 1500,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 2,
            }
        }
    });

    $(".full-width-job-slider").owlCarousel({
        nav: true,
        navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
        loop: true,
        dots: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 1500,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
    $(".category-style-3-slider").owlCarousel({
        nav: false,
        //navText:["<i class='ti-angle-left'></i>","<i class='ti-angle-right'></i>"],
        loop: false,
        dots: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 10000,
        autoplaySpeed: 1500,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 4,
            }
        }
    });
    /*TOP HIRING COMPIES SLIDER*/
    $(".top-hiring-company-slider").owlCarousel({
        nav: false,
        //navText:["<i class='ti-angle-left'></i>","<i class='ti-angle-right'></i>"],
        loop: true,
        dots: false,
        autoplay: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 5,
            },
            1000: {
                items: 5,
            }
        }
    });

    /*--- ACCORDIAN---*/

    $('.panel-heading').on("click", function () {
        $('.panel-heading').removeClass('tab-collapsed');
        var collapsCrnt = $(this).find('.collapse-controle').attr('aria-expanded');
        if (collapsCrnt != 'true') {
            $(this).addClass('tab-collapsed');
        }
    });

    /******** Start New JS **********/

    $(".select-generat ").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 10,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });


    /* ======= Progress bars ======= */
    $('.progress-bar > span').each(function () {
        var $this = $(this);
        var width = $(this).data('percent');
        $this.css({
            'transition': 'width 3s'
        });
        setTimeout(function () {
            $this.appear(function () {
                $this.css('width', width + '%');
            });
        }, 500);
    });


    /*MOBILD DASHBOARD MENU*/
    $(".menu-dashboard").on('click', function () {
        $(".profile-menu").toggleClass("position");
    });


    /*MOBILD DASHBOARD MENU*/
    $('#dashboard-bar-right').theiaStickySidebar({
        additionalMarginTop: 80
    });

    $('#side-fix').theiaStickySidebar({
        additionalMarginTop: 80
    });

    /*Premium Jobs vertical slider*/
    $(document).ready(function () {
        $(".slider-1").each(function () {
            $(this).bxSlider({
                mode: 'vertical',
                moveSlides: 1,
                infiniteLoop: true,
                minSlides: 3,
                maxSlides: 3,
                speed: 2000,
                controls: true,
                nextText: '<i class="fa fa-angle-right"></i>',
                prevText: '<i class="fa fa-angle-left"></i>',
                pager: false,
                auto: true,
                autoHover: true,
                pause: $(this).attr('data-slider-speed'),
                //ticker:true,
                touchEnabled: false,
            });

        });
    });
    $(document).ready(function () {
        $('#hero-cat-parralex').show();
        /*--- Owl  Carousel categories --*/
        $('.main-hero-cat').owlCarousel({
            nav: true,
            navText: ["<i class='ti-angle-left'></i>", "<i class='ti-angle-right'></i>"],
            loop: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        });
    });

    /* Call to action 4 counter */
    function Counter(data) {
        var _default = {
            fps: 20,
            from: 0,
            time: 2000,
        }

        for (var attr in _default) {
            if (typeof data[attr] === 'undefined') {
                data[attr] = _default[attr];
            }
        }

        if (typeof data.to === 'undefined')
            return;

        data.fps = typeof data.fps === 'undefined' ? 20 : parseInt(data.fps);
        data.from = typeof data.from === 'undefined' ? 0 : parseFloat(data.from);

        var frames = data.time / data.fps,
                inc = (data.to - data.from) / frames,
                val = data.from;

        if (typeof data.start === 'function') {
            data.start(data.from, data)
        }
        var interval = setInterval(function () {
            frames--;
            val += inc;

            if (val >= data.to) {
                if (typeof data.complete === 'function') {
                    console.log('complete');
                    data.complete(data.to, data)
                }
                console.log(interval);
                clearInterval(interval);
            } else if (typeof data.progress === 'function') {
                data.progress(val, data)
            }
        }, data.fps);

    }

// Auto-counter from HTML API
    var counters = document.getElementsByClassName('counter'),
            print = function (val, data) {
                data.element.innerHTML = val;
            }

    for (var i = 0, l = counters.length; i < l; i++) {
        // Loads from HTML dataset
        var data = {};
        for (var attr in counters[i].dataset) {
            data[attr] = counters[i].dataset[attr];
        }

        // Save element and callbacks
        data.element = counters[i];
        data.start = print;
        data.progress = print;
        data.complete = print;

        // Creates the counter
        new Counter(data);
    }




    /******** End New JS **********/
    $('#tags_tag').tagEditor({
        placeholder: get_strings.select_tags,
        removeDuplicates: false,
        onChange: function (field, editor, tags) {
            if ((!$.isNumeric(tags)) || (tags > 100)) {
                var str = tags;
                str.toString();
                $.each(str, function (i, l) {
                    if (!$.isNumeric(l) || l > 100) {
                        $('#tags_tag').tagEditor('removeTag', l);
                    }
                });
            }
        },
    });


    $('#tags_tag_job').tagEditor({
        placeholder: get_strings.select_jobs_tags,
        removeDuplicates: false,
    });

    /* --- SEACRH FIXED---*/

    $(window).scroll(function () {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 300) {
            $(".search").addClass("navbar-fixed-top");
        } else if (scrollTop < 300) {
            $(".search").removeClass("navbar-fixed-top");
        }
    });

    $(".questions-category").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 15,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });

    $(".custom-search-select").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 15,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });

    $(".select-category ").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 13,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });
    $(".select-location").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 13,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });

    $(".select-resume").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });

    $(".select-generat").select2({
        placeholder: get_strings.option_select,
        allowClear: true,
        maximumSelectionLength: 15,
        language: {
            noResults: function (params) {
                return get_strings.no_res;
            }
        }
    });

    /* Employer deleting candidate resume */
    $(".del-this-resume").on("click", function () {
        var cand_key = $(this).attr("data-resume-id");
        var resume_array = cand_key.split("|");
        var cand_id = resume_array[0];
        var job_id = resume_array[1];
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'del_this_candidate',
                            cand_id: cand_id,
                            job_id: job_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == 1) {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });

    /*--- Drop Zone For company gallery---*/
    function sbDropzone_comp_image() {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
        var fileList = new Array;
        var i = 0;
        $("#company-dropzone").dropzone({
            addRemoveLinks: true,
            paramName: "my_file_upload",
            maxFiles: $('#sb_upload_limit').val(), //change limit as per your requirements
            acceptedFiles: '.jpeg,.jpg,.png',
            dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
            /*acceptedFiles: acceptedFileTypes,*/
            url: nokri_ajax_url + "?action=nokri_upload_comp_image&is_update=" + $('#is_update').val(),
            parallelUploads: 1,
            dictDefaultMessage: $('#dictDefaultMessage').val(),
            dictFallbackMessage: $('#dictFallbackMessage').val(),
            dictFallbackText: $('#dictFallbackText').val(),
            dictFileTooBig: $('#dictFileTooBig').val(),
            dictInvalidFileType: $('#dictInvalidFileType').val(),
            dictResponseError: $('#dictResponseError').val(),
            dictCancelUpload: $('#dictCancelUpload').val(),
            dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
            dictRemoveFile: get_strings.remove_btn,
            dictRemoveFileConfirmation: null,

            init: function () {
                var thisDropzone = this;
                $.post(nokri_ajax_url, {
                    action: 'get_uploaded_company_images',
                }).done(function (data) {


                    if (data != 0) {
                        $.each(data, function (key, value) {
                            var mockFile = {
                                name: value.name,
                                size: value.size
                            };
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                            i++;
                        });
                    }
                    if (i > 0)
                        $('.dz-message').hide();
                    else
                        $('.dz-message').show();
                });
                this.on("addedfile", function (file) {
                    $('.dz-message').hide();
                });
                this.on("success", function (file, responseText) {
                    var res_arr = responseText.split("|");
                    if ($.trim(res_arr[0]) != "0") {
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                        i++;
                        $('.dz-message').hide();
                    } else {
                        if (i == 0)
                            $('.dz-message').show();
                        this.removeFile(file);
                        toastr.error(res_arr[1], '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }
                });
                this.on("removedfile", function (file) {
                    var img_id = file._removeLink.attributes[2].value;
                    if (img_id != "") {
                        i--;
                        if (i == 0)
                            $('.dz-message').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_comp_image',
                            img: img_id,
                            is_update: $('#is_update').val(),
                        }).done(function (response) {
                            if ($.trim(response) == "1") {
                                toastr.success($('#del_msg').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                });

            },

        });
    }
    sbDropzone_comp_image();
    /*--- End Drop Zone company gallery---*/

    /*--- Drop Zone For Portfolio---*/
    function sbDropzone_image() {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
        var fileList = new Array;
        var i = 0;
        $("#dropzone").dropzone({
            addRemoveLinks: true,
            paramName: "my_file_upload",
            maxFiles: $('#sb_upload_limit').val(), //change limit as per your requirements
            acceptedFiles: '.jpeg,.jpg,.png',
            dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
            /*acceptedFiles: acceptedFileTypes,*/
            url: nokri_ajax_url + "?action=nokri_upload_portfolio&is_update=" + $('#is_update').val(),
            parallelUploads: 1,
            dictDefaultMessage: $('#dictDefaultMessage').val(),
            dictFallbackMessage: $('#dictFallbackMessage').val(),
            dictFallbackText: $('#dictFallbackText').val(),
            dictFileTooBig: $('#dictFileTooBig').val(),
            dictInvalidFileType: $('#dictInvalidFileType').val(),
            dictResponseError: $('#dictResponseError').val(),
            dictCancelUpload: $('#dictCancelUpload').val(),
            dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
            dictRemoveFile: $('#dictRemoveFile').val(),
            dictRemoveFileConfirmation: null,
            init: function () {
                var thisDropzone = this;
                $.post(nokri_ajax_url, {
                    action: 'get_uploaded_portfolio_images',
                }).done(function (data) {
                    if (data != 0) {
                        $.each(data, function (key, value) {
                            var mockFile = {
                                name: value.name,
                                size: value.size
                            };
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                            i++;
                        });
                    }
                    if (i > 0)
                        $('.dz-message').hide();
                    else
                        $('.dz-message').show();
                });
                this.on("addedfile", function (file) {
                    $('.dz-message').hide();
                });
                this.on("success", function (file, responseText) {
                    var res_arr = responseText.split("|");
                    if ($.trim(res_arr[0]) != "0") {
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                        i++;
                        $('.dz-message').hide();
                    } else {
                        if (i == 0)
                            $('.dz-message').show();
                        this.removeFile(file);
                        toastr.error(res_arr[1], '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }
                });
                this.on("removedfile", function (file) {
                    var img_id = file._removeLink.attributes[2].value;
                    if (img_id != "") {
                        i--;
                        if (i == 0)
                            $('.dz-message').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_ad_image',
                            img: img_id,
                            is_update: $('#is_update').val(),
                        }).done(function (response) {

                            if ($.trim(response) == "1") {
                                toastr.success($('#del_msg').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                });

            },

        });
    }
    sbDropzone_image();
    /*--- End Drop Zone For Portfolio---*/

    /*--- Drop Zone For Resumes---*/

    function sbDropzone_resume() {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
        var fileList = new Array;
        var i = 0;
        $("#dropzone_resume").dropzone({
            addRemoveLinks: true,
            paramName: "my_cv_upload",
            maxFiles: $('#sb_upload_limit').val(), //change limit as per your requirements
            acceptedFiles: '.txt,.doc,.docx,.pdf',
            dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
            /*acceptedFiles: acceptedFileTypes,*/
            url: nokri_ajax_url + "?action=cand_resume&is_update=" + $('#is_update').val(),
            parallelUploads: 1,
            dictDefaultMessage: $('#dictDefaultMessage').val(),
            dictFallbackMessage: $('#dictFallbackMessage').val(),
            dictFallbackText: $('#dictFallbackText').val(),
            dictFileTooBig: $('#dictFileTooBig').val(),
            dictInvalidFileType: $('#dictInvalidFileType').val(),
            dictResponseError: $('#dictResponseError').val(),
            dictCancelUpload: $('#dictCancelUpload').val(),
            dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
            dictRemoveFile: $('#dictRemoveFile').val(),
            dictRemoveFileConfirmation: null,
            init: function () {
                var thisDropzone = this;
                $.post(nokri_ajax_url, {
                    action: 'get_uploaded_cand_resume',
                }).done(function (data) {

                    $.each(data, function (key, value) {
                        var mockFile = {
                            name: value.display_name,
                            size: value.size
                        };
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                        i++;
                    });
                    if (i > 0)
                        $('.dz-message').hide();
                    else
                        $('.dz-message').show();
                });
                this.on("addedfile", function (file) {
                    $('.dz-message').hide();
                });
                this.on("success", function (file, responseText) {
                    var res_arr = responseText.split("|");
                    if ($.trim(res_arr[0]) != "0") {
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                        i++;
                        $('.dz-message').hide();
                    } else {
                        if (i == 0)
                            $('.dz-message').show();
                        this.removeFile(file);
                        toastr.error(res_arr[1], '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }
                });
                this.on("removedfile", function (file) {
                    var resume_id = file._removeLink.attributes[2].value;
                    if (resume_id != "") {
                        i--;
                        if (i == 0)
                            $('.dz-message').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_cand_resume',
                            resume: resume_id,
                            is_update: $('#is_update').val(),
                        }).done(function (response) {
                            if ($.trim(response) == "1") {
                                toastr.success($('#del_msg').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                });

            },

        });
    }
    sbDropzone_resume();
    /*--- End Drop Zone For Resumes---*/

    /*--- Drop Zone For Resumes Video---*/
    csDropzone_video();

    function csDropzone_video() {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "video/mp4,video/ogg,video/webm";

        var fileList = new Array;
        var k = 0;
        if ($('#ad_vidoe_dropzone').length) {
            $("#ad_vidoe_dropzone").dropzone({
                timeout: 5000000000,
                maxFilesize: $('#max_upload_video_size').val(),
                addRemoveLinks: true,
                paramName: "resume_video",
                maxFiles: get_strings.resume_video_limit, //change limit as per your requirements
                MaxFilesExceeded: $('#sb_upload_video_limit').val(),
                acceptedFiles: acceptedFileTypes,
                url: nokri_ajax_url + "?action=upload_resume_single_video",
                parallelUploads: 1,
                uploadMultiple: false,
                dictMaxFilesExceeded: $('#dictMaxFilesExceeded').val(),
                dictDefaultMessage: $('#dictDefaultMessage').val(),
                dictFallbackMessage: $('#dictFallbackMessage').val(),
                dictFallbackText: $('#dictFallbackText').val(),
                dictFileTooBig: $('#dictFileTooBig').val(),
                dictInvalidFileType: $('#dictInvalidFileType').val(),
                dictResponseError: $('#dictResponseError').val(),
                dictCancelUpload: $('#dictCancelUpload').val(),
                dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
                dictRemoveFile: $('#dictRemoveFile').val(),
                dictRemoveFileConfirmation: null,
                init: function () {
                    var thisDropzone = this;
                    let videoLogoUrl = $('#video_logo_url').val();
                    /*get uploaded videos*/
                    $.post(nokri_ajax_url, {
                        action: 'get_uploaded_video'
                    }).done(function (data) {

                        if (data !== "") {
                            $.each(data, function (key, value) {
                                var mockFile = {
                                    name: value.video_name,
                                    size: value.video_size
                                };
                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, videoLogoUrl);
                                $('#ad_vidoe_dropzone a.dz-remove:eq(' + k + ')').attr("data-dz-remove", value.video_id);
                                k++;
                            });
                        }
                        if (k > 0)
                            $('.dz-message').hide();
                        else
                            $('.dz-message').show();
                    });
                    /*rejected because the number of files exceeds the maxFiles limit.*/
                    thisDropzone.on("maxfilesexceeded", function (file) {
                        this.removeFile(file);
                    });
                    /*file has been uploaded successfully*/
                    thisDropzone.on("success", function (file, responseText) {
                        var res_arr = responseText.split("|");
                        // If the image is already a thumbnail:
                        this.emit('thumbnail', file, videoLogoUrl);
                        if ($.trim(res_arr[0]) != "0") {

                            $('#ad_vidoe_dropzone a.dz-remove:eq(' + k + ')').attr("data-dz-remove", responseText);
                            k++;
                            $('.dz-message').hide();
                        } else {
                            if (k == 0)
                                $('.dz-message').show();
                            this.removeFile(file);
                            toastr.error(res_arr[1], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    /*remove/delete the file*/
                    thisDropzone.on("removedfile", function (file) {
                        var video_id = file._removeLink.attributes[2].value;
                        if (video_id != "") {
                            k--;
                            if (k == 0) {
                                $('.dz-message').show();
                            }
                            $.post(nokri_ajax_url, {
                                action: 'delete_upload_video',
                                video: video_id,
                            }).done(function (response) {

                                if ($.trim(response) == "1") {
                                    toastr.success($('#del_msg').val(), '', {
                                        timeOut: 2500,
                                        "closeButton": true,
                                        "positionClass": "toast-top-right"
                                    });

                                }
                            });
                        }
                    });
                },
            });
        }
    }


    /*--- Drop Zone For Resumes Video---*/

    /*--- Drop Zone For Custom feilds---*/
    function sbDropzone_custom() {
        Dropzone.autoDiscover = false;
        var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
        var fileList = new Array;
        var i = 0;
        $("#dropzone_custom").dropzone({
            addRemoveLinks: true,
            paramName: "custom_upload",
            maxFiles: $('#sb_upload_limit').val(), //change limit as per your requirements
            acceptedFiles: '.txt,.doc,.docx,.pdf,.png,.jpg,.gif,.jpeg',
            dictMaxFilesExceeded: $('#adforest_max_upload_reach').val(),
            /*acceptedFiles: acceptedFileTypes,*/
            url: nokri_ajax_url + "?action=job_attachments&is_update=" + $('#is_update').val(),
            parallelUploads: 1,
            dictDefaultMessage: $('#dictDefaultMessage').val(),
            dictFallbackMessage: $('#dictFallbackMessage').val(),
            dictFallbackText: $('#dictFallbackText').val(),
            dictFileTooBig: $('#dictFileTooBig').val(),
            dictInvalidFileType: $('#dictInvalidFileType').val(),
            dictResponseError: $('#dictResponseError').val(),
            dictCancelUpload: $('#dictCancelUpload').val(),
            dictCancelUploadConfirmation: $('#dictCancelUploadConfirmation').val(),
            dictRemoveFile: get_strings.action_remove,
            dictRemoveFileConfirmation: get_strings.btn_cnfrm,
            init: function () {
                var thisDropzone = this;
                $.post(nokri_ajax_url, {
                    action: 'get_uploaded_job_attachments',
                    is_update: $('#is_update').val()
                }).done(function (data) {
                    var is_update = $('#is_update').val();
                    var is_attachment = $('#is_attachment').val();
                    if (is_update && is_attachment == '1')
                    {
                        $.each(data, function (key, value) {
                            var mockFile = {
                                name: value.display_name,
                                size: value.size
                            };
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.name);
                            $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", value.id);
                            i++;
                        });
                    }
                    if (i > 0)
                        $('.dz-message').hide();
                    else
                        $('.dz-message').show();
                });
                this.on("addedfile", function (file) {
                    $('.dz-message').hide();
                });
                this.on("success", function (file, responseText) {
                    var res_arr = responseText.split("|");
                    if ($.trim(res_arr[0]) != "0") {
                        $('a.dz-remove:eq(' + i + ')').attr("data-dz-remove", responseText);
                        i++;
                        $('.dz-message').hide();
                    } else {
                        if (i == 0)
                            $('.dz-message').show();
                        this.removeFile(file);
                        toastr.error(res_arr[1], '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }
                });
                this.on("removedfile", function (file) {
                    var img_id = file._removeLink.attributes[2].value;
                    if (img_id != "") {
                        i--;
                        if (i == 0)
                            $('.dz-message').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_uploaded_job_attachments',
                            img: img_id,
                            is_update: $('#is_update').val(),
                        }).done(function (response) {
                            if ($.trim(response) == "1") {
                                toastr.success($('#del_msg').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                });

            },

        });
    }
    sbDropzone_custom();
    /*--- End Drop Zone For Resumes---*/




    /* Candidate Deleting  Resumes */

    $(".del_my_resume").on("click", function () {
        var del_val = $(this).attr("value");
        var row = $(this).closest('ul');
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_cand_resume',
                            resume: del_val,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) !== "") {
                                row.remove();
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });

    /* Candidate  Deleting Saved Jobs */
    $(".del_saved_job").on("click", function () {
        var del_job_id = $(this).attr("data-value");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'del_saved_job',
                            cand_job_id: del_job_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#save-job-html-" + del_job_id).remove();
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });


    /* ======= employer rating ======= */
    if ($('#user_ratting_form').length > 0)
    {
        $('#user_ratting_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_loading').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_post_user_ratting', sb_data: $("form#user_ratting_form").serialize(), security: $('#rating_nonce').val()}).done(function (response)
                    {
                        $('#sb_loading').hide();

                        var res_arr = response.split("|");


                        if ($.trim(res_arr[0]) != "0")
                        {
                            toastr.success(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});
                            window.location.reload(true);
                        } else
                        {
                            toastr.error(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});

                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });

                    return false;
                });
    }

    //reply to rator

    if ($('.sb-reply-rating-form').length > 0)
    {
        $(".sb-reply-rating-form").on("click", function () {
            var comment_id = $(this).attr('data-commentid');
            var comment_reply_text = $('.review-reply-' + comment_id).val();
            $(this).parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
            })
                    .on('form:submit', function () {
                        /*Ajax for Rating Reply*/
                        $('#sb_loading').show();
                        $.post(nokri_ajax_url, {action: 'sb_reply_user_rating', cid: comment_id, reply_text: comment_reply_text, security: $('#rating_reply_nonce').val()}).done(function (response)
                        {
                            $('#sb_loading').hide();

                            var res_arr = response.split("|");
                            if ($.trim(res_arr[0]) != "0")
                            {
                                toastr.success(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});
                                window.setTimeout(function ()
                                {
                                    window.location.reload(true);
                                }, 1000);
                            } else
                            {
                                toastr.error(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});

                            }
                        }).fail(function () {
                            $('#sb_loading').hide();
                            toastr.error($('#nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        });


                        return false;
                    });
        });
    }
    /* ======= employer rating ======= */
    if ($('#cand_ratting_form').length > 0)
    {
        $('#cand_ratting_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_loading').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_post_cand_ratting', sb_data: $("form#cand_ratting_form").serialize(), security: $('#rating_nonce').val()}).done(function (response)
                    {
                        $('#sb_loading').hide();

                        var res_arr = response.split("|");


                        if ($.trim(res_arr[0]) != "0")
                        {
                            toastr.success(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});
                            window.location.reload(true);
                        } else
                        {
                            toastr.error(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});

                        }
                    }).fail(function () {
                        $('#sb_loading').hide();
                        toastr.error($('#nonce_error').val(), '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                    });

                    return false;
                });
    }
    /* ======= Revolution slider  Home Page Cleaning ======= */
    if ($('.slider-grid-3').length > 0) {
        $(".slider-grid-3").revolution({
            delay: 9000,
            startwidth: 1170,
            startheight: 620,
            onHoverStop: "off",
            hideThumbs: 1,
            hideTimerBar: "on",
            navigationType: "none",
            navigationStyle: "preview3",
            fullWidth: "on",
            dottedOverlay: "custom",
            fullScreen: "off",
            fullScreenOffsetContainer: ""
        });
    }

    /*--- MENU---*/


    $('.mega-menu').megaMenu({
        // DESKTOP MODE SETTINGS
        logo_align: 'left',
        /* align the logo left or right. options (left) or (right)*/
        links_align: 'left',
        /* align the links left or right. options (left) or (right)*/
        socialBar_align: 'left',
        /*align the socialBar left or right. options (left) or (right)*/
        searchBar_align: 'right',
        /*align the search bar left or right. options (left) or (right)*/
        trigger: 'hover',
        /*show drop down using click or hover. options (hover) or (click)*/
        effect: 'fade',
        /*drop down effects. options (fade), (scale), (expand-top), (expand-bottom), (expand-left), (expand-right)*/
        effect_speed: 400,
        /*drop down show speed in milliseconds*/
        sibling: true,
        /*hide the others showing drop downs if this option true. this option works on if the trigger option is "click". options (true) or (false)*/
        outside_click_close: true,
        /*hide the showing drop downs when user click outside the menu. this option works if the trigger option is "click". options (true) or (false)*/
        top_fixed: false,
        /*fixed the menu top of the screen. options (true) or (false)*/
        sticky_header: false,
        /*menu fixed on top when scroll down down. options (true) or (false)*/
        sticky_header_height: 200,
        /* sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.*/
        menu_position: 'horizontal',
        /* change the menu position. options (horizontal), (vertical-left) or (vertical-right)*/
        full_width: false,
        /*make menu full width. options (true) or (false)*/
        /* MOBILE MODE SETTINGS*/
        mobile_settings: {
            collapse: true,
            /*collapse the menu on click. options (true) or (false)*/
            sibling: true,
            /*hide the others showing drop downs when click on current drop down. options (true) or (false)*/
            scrollBar: true,
            /*enable the scroll bar. options (true) or (false)*/
            scrollBar_height: 400,
            /*scroll bar height in px value. this option works if the scrollBar option true.*/
            top_fixed: false,
            /*fixed menu top of the screen. options (true) or (false)*/
            sticky_header: false,
            /*menu fixed on top when scroll down down. options (true) or (false)*/
            sticky_header_height: 200 /*sticky header height top of the screen. activate sticky header when meet the height. option change the height in px value.*/
        }
    });


    /*--- SCROLL TO TOP---*/

    $(document).ready(function () {

        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });


        $('.scrollup').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

    });
    /* Dahsboard scroll */
    var is_accordion = $("#is_accordion").attr('value')
    if (is_accordion == '1')
    {
        var ps = new PerfectScrollbar('#accordion');
    }
    // Upload canidate  resume
    $('body').on('change', '.sb_files-data-doc', function (e) {

        var fd = new FormData();
        var files_data = $('.sb_files-data-doc');

        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_file_upload[' + j + ']', file);
            });
        });
        $('#progress_loader').show();
        $("#submit_cv_form_btn").prop('disabled', true);

        fd.append('action', 'sb_upload_user_docs');
        $('#sb_loading').show();
        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        var per = Math.round(percentComplete) + "%";
                        var kbs = evt.loaded / 1000 + "  Kb" + "/ " + evt.total / 1000 + " kb";
                        $('#progress_counter').html(kbs + "     " + per);
                    }

                }, false);
                return xhr;
            },
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('#progress_loader').hide();
                $("#submit_cv_form_btn").prop('disabled', false);
                $('#sb_loading').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    $('#_sb_company_doc').val(res_arr[1]);
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 4000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            }
        });
    });


    /* Sticky Menu Option */
    var is_stick = $('#is_sticky_menu').val();
    var is_dashboard_page = $('#is_dashboard_page').val();
    if (is_stick == 1 && is_dashboard_page != 1) {
        $(window).scroll(function () {
            var limit = 200;
            if (jQuery(this).scrollTop() >= limit) {
                jQuery('.mega-menu').addClass('desktopTopFixed');
            } else {
                jQuery('.mega-menu').removeClass('desktopTopFixed');
            }
        });
    }


    // Validating Registration process
    if ($('#sb-signup-form').length > 0) {

        window.Parsley.addValidator('lowercase', {
            requirementType: 'number',
            validateString: function (value, requirement) {
                var lowecases = value.match(/[a-z]/g) || [];
                return lowecases.length >= requirement;
            },
            messages: {
                en: get_strings.lowercase_validation,
            }
        });


        window.Parsley.addValidator('number', {
            requirementType: 'number',
            validateString: function (value, requirement) {
                var numbers = value.match(/[0-9]/g) || [];
                return numbers.length >= requirement;
            },
            messages: {
                en: get_strings.number_validation,
            }
        });

        window.Parsley.addValidator('uppercase', {
            requirementType: 'number',
            validateString: function (value, requirement) {

                var specials = value.match(/[A-Z]/g) || [];
                return specials.length >= requirement;
            },
            messages: {
                en: get_strings.uppercase_validation
            }
        });

        window.Parsley.addValidator('customlimit', {
            validateString: function validateString(value, requirement) {

                console.log(value);
                if (!value)
                    return true;
                return value.length >= requirement;
            },
            messages: {
                en: get_strings.limit_validation,
            }
        });

        $('#my-alert').hide();
        $('#contct').hide();
        $('#sb_register_msg').hide();
        $('#sb_register_redirect').hide();
        $('#sb-signup-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax for Registration 
                    $('#sb_register_submit').hide();
                    $('#sb_register_msg').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_register_user',
                        sb_signup_data: $("form#sb-signup-form").serialize(),
                        nonce: get_strings.nonce,
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('#sb_register_msg').hide();
                        var res_arr = response.split("|");
                        var res_key = res_arr[0];

                        if ($.trim(res_key) == '1') {
                            $('#sb_register_redirect').show();
                            $('#my-alert').show();
                            window.location = $('#profile_page').val();
                        } else if ($.trim(res_key) == '2') {

                            $.alert({
                                title: get_strings.rgstr_info,
                                icon: 'fa fa-envelope-o',
                                type: 'green',
                                content: $('#verify_account_msg').val(),
                                buttons: {
                                    okay: {
                                        text: get_strings.rgstr_resend,
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            var usr_email = $('#sb_reg_email').val();
                                            $.post(nokri_ajax_url, {
                                                action: 'sb_resend_email',
                                                usr_email: usr_email,
                                            }).done(function (response) {
                                                toastr.success($('#verify_account_msg').val(), '', {
                                                    timeOut: 3500,
                                                    "closeButton": true,
                                                    "positionClass": "toast-top-right"
                                                });


                                                if ($('#is_email_on').val() == 1) {
                                                    $('#contct').show();
                                                }
                                                window.location = res_arr[1];
                                            });
                                        }

                                    },
                                    cancelAction: {
                                        text: get_strings.rgstr_close,
                                        btnClass: 'btn-red',
                                        action: function () {
                                            $('#my-alert').show();
                                            window.location = res_arr[1];
                                        }

                                    }

                                }

                            });

                        } else if ($.trim(res_key) == '3') {
                            $('#sb_register_submit').show();
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(res_key) == '4') {
                            $('#sb_register_submit').show();
                            toastr.warning(get_strings.password_confirm, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(res_key) == '5') {
                            $('#sb_verification_processing').hide();
                            var num = $('#sb_reg_contact').val();
                            $('#verification_label').html(get_strings.verification_message + "  " + num);
                            $('#user_phone_number').val(num);
                            $('#user_id').val(res_arr[1]);
                            $('#verification_modal').modal();
                        } else if ($.trim(res_key) == '6') {
                            $('#sb_register_submit').show();
                            toastr.error(res_arr[1], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            $('#sb_register_submit').show();
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    }
    /*Phone verification logic on registration*/
    $(document).on('click', '#sb_verification_ph_code', function ()
    {

        var code = $('#sb_ph_number_code').val();
        var sign_in_page = $('#sign_in_page').val();
        $('#sb_verification_processing').show();
        $('#sb_verification_ph_code').hide();
        $.post(nokri_ajax_url, {action: 'nokri_verification_system', code_entered: code}).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) == "2")
            {
                $('#sb_verification_processing').hide();
                $('#sb_verification_ph_code').show();
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                window.location.href = sign_in_page;

            } else
            {
                $('#sb_verification_processing').hide();
                $('#sb_verification_ph_code').show();
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });


    /*Phone verification on login page*/
    if ($('#sb_login_verification_form').length > 0) {

        $('#sb_login_verification_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    var sign_in_page = $('#sign_in_page').val();
                    $('#sb_verification_processing').show();
                    $('#verify_acc').hide();
                    $.post(nokri_ajax_url, {
                        action: 'nokri_login_verification_system',
                        form_data: $("form#sb_login_verification_form").serialize(),
                    }).done(function (response) {
                        var res_arr = response.split("|");
                        if ($.trim(res_arr[0]) == "1")
                        {
                            $('#sb_verification_processing').show();
                            $('#verify_acc').hide();
                            toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                            window.location.href = sign_in_page;
                        } else
                        {
                            $('#sb_verification_processing').show();
                            $('#verify_acc').hide();
                            $('#sb_verification_processing').show();
                            $('#verify_acc').hide();
                            toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
                        }
                    });
                    return false;
                });
    }
    /*Resend varification code */
    $(document).on('click', '#resend_now', function ()
    {
        var phone_number = $('#user_phone_number').val();
        var user_id = $('#user_id').val();
        var user_email = $('#user_email').val();
        var resend_btn = $(this);
        resend_btn.addClass('anchor_disable');
        $.post(nokri_ajax_url, {action: 'nokri_resend_verification_code', phone_number: phone_number, user_id: user_id, user_email: user_email}).done(function (response)
        {
            var res_arr = response.split("|");
            if ($.trim(res_arr[0]) == "1")
            {
                resend_btn.removeClass('anchor_disable');
                toastr.success(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            } else
            {
                resend_btn.removeClass('anchor_disable');
                toastr.error(res_arr[1], '', {timeOut: 4000, "closeButton": true, "positionClass": "toast-top-right"});
            }
        });
    });



    /*Resend otp*/
    $('#resend_email').on('click', function () {
        var usr_email = $('#sb_reg_email').val();
        $.post(nokri_ajax_url, {
            action: 'sb_resend_email',
            usr_email: usr_email,
        }).done(function (response) {
            toastr.success($('#verify_account_msg').val(), '', {
                timeOut: 3500,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });
            $('#my-alert').hide();
            $('#contct').show();
        });
    });
    // Validating SignIn process    

    if ($('#sb-login-form-data').length > 0) {
        // Login Process
        $('#sb_login_msg').hide();
        $('#sb_login_redirect').hide();
        $('#sb-login-form-data').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('#sb_loading').show();
                    $('.cp-loader').show();
                    // Ajax for Registration
                    $('#sb_login_submit').hide();
                    $('#sb_login_msg').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_login_user',
                        sb_login_data: $("form#sb-login-form-data").serialize(),
                        nonce: get_strings.nonce,
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('#sb_loading').hide();
                        $('#sb_login_msg').hide();

                        if ($.trim(response) == '1') {
                            $('#sb_login_redirect').show();
                            window.location = $('#profile_page').val();
                        } else if ($.trim(response) == '2') {
                            $('#sb_login_submit').show();
                            if ($('#sign_verification_modal').length > 0) {
                                $('#sb_verification_processing').hide();
                                $('#user_email').val($('#sb_reg_email').val());
                                $('#sign_verification_modal').modal();
                            } else {
                                toastr.error($('#acc_not_verified').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-bottom-right"
                                });
                            }
                        } else {
                            $('#sb_login_submit').show();
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }
                    });
                    return false;
                });
    }
    /*// Forgot Password*/
    if ($('#sb-forgot-form').length > 0) {
        $('#sb_forgot_msg').hide();

        $('#sb-forgot-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    // Ajax for Registration
                    $('#sb_forgot_submit').hide();
                    $('#sb_forgot_msg').show();
                    $('.cp-loader').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_forgot_password',
                        sb_data: $("form#sb-forgot-form").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('#sb_forgot_msg').hide();

                        if ($.trim(response) == '1') {
                            $('#sb_forgot_submit').show();
                            $('#sb_forgot_email').val('');
                            toastr.success($('#nokri_forgot_msg').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $('#myModal').modal('hide');
                        } else {
                            $('#sb_forgot_submit').show();
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                    return false;
                });
    }


    $(window).on('load', function () {
        $('#sb_reset_password_modal').modal('show');
    });

    if ($('#sb-reset-password-form').length > 0) {
        $('#sb_reset_password_msg').hide();
        $('#sb-reset-password-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    if ($('#sb_new_password').val() != $('#sb_confirm_new_password').val()) {
                        toastr.error($('#nokri_password_mismatch_msg').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        return false;
                    }
                    //Ajax for Registration
                    $('#sb_reset_password_submit').hide();
                    $('#sb_reset_password_msg').show();
                    $('#sb_loading').show();
                    $.post(nokri_ajax_url, {
                        action: 'sb_reset_password',
                        sb_data: $("form#sb-reset-password-form").serialize(),
                    }).done(function (response) {
                        $('#sb_loading').hide();
                        $('#sb_reset_password_msg').hide();

                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1') {
                            toastr.success(get_r[1], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $('#sb_reset_password_modal').modal('hide');
                            $('#sb_reset_password_submit').show();
                            $('#login-modal').modal('show');
                        } else {
                            $('#sb_reset_password_submit').show();
                            toastr.error(get_r[1], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    }

    /* Employer Profile  */

    // Validating Employer Profile process
    if ($('#sb-emp-profile').length > 0) {
        $('#sb_register_redirect').hide();
        $('#emp_proc').hide();
        $('#emp_redir').hide();
        $('#sb-emp-profile').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    $('#emp_proc').show();
                    $('#emp_save').hide();
                    // Ajax for Registration
                    $.post(nokri_ajax_url, {
                        action: 'emp_profiles',
                        sb_data: $("form#sb-emp-profile").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('#emp_proc').hide();
                        $('#emp_redir').show();
                        if ($.trim(response) == '1') {
                            toastr.success($('#nokri_emp_profile_save').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            location.reload();
                        } else {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                    return false;
                });
    }


    // Validating contact me process
    if ($('#contact_form_email').length > 0) {
        $('#sb_register_redirect').hide();
        $('#emp_proc').hide();
        $('#emp_redir').hide();
        $('#contact_form_email').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    $('#emp_proc').show();
                    $('#emp_save').hide();
                    // Ajax for Registration
                    $.post(nokri_ajax_url, {
                        action: 'contact_me',
                        contact_me_data: $("form#contact_form_email").serialize(),
                    }).done(function (response) {



                        var res_arr = response.split("|");
                        $('.cp-loader').hide();
                        $('#emp_proc').hide();
                        $('#emp_redir').show();
                        if ($.trim(response) == '1') {
                            toastr.success($('#contact_sent').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            document.getElementById("contact_form_email").reset();
                            //location.reload();
                        } else if (res_arr[0] == '0') {

                            toastr.error(res_arr[1], '', {timeOut: 2500, "closeButton": true, "positionClass": "toast-top-right"});
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                    return false;
                });
    }


    // Upload Employers profile picture 
    $('body').on('change', '.sb_files-data', function (e) {

        var fd = new FormData();
        var files_data = $('.form-group .sb_files-data');

        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_file_upload[' + j + ']', file);
            });
        });

        fd.append('action', 'upload_user_pic');
        $('.cp-loader').show();
        $.ajax({
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.cp-loader').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    toastr.success($('#nokri_dp_save').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    $('#emp_dp').attr('src', res_arr[1]);
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }

            }
        });

    });


    $('body').on('change', '.sb_cover-data', function (e) {

        var fd = new FormData();
        var files_data = $('.form-group .sb_cover-data');

        console.log(files_data);

        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_cover_upload[' + j + ']', file);
            });
        });

        fd.append('action', 'upload_user_cover');
        $('.cp-loader').show();
        $.ajax({
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {

                $('.cp-loader').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    toastr.success($('#nokri_cover_save').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            }
        });

    });

    /* Youtube popup */
    if ($("#is_intro_vid").val() == 1) {
        $("a.bla-1").YouTubePopUp();
    }
    $(document).ready(function () {
        if ($("a.hero-video").length)
        {
            $("a.hero-video").YouTubePopUp();
        }
    });

    // Upload Employers Cover picture 
    $('body').on('change', '.sb_files-data-cover', function (e) {
        var fd = new FormData();
        var files_data = $('.form-group .sb_files-data-cover');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('my_file_upload_cover[' + j + ']', file);
            });
        });

        fd.append('action', 'upload_user_cover');
        $('.cp-loader').show();
        $.ajax({
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.cp-loader').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    toastr.success($('#nokri_emp_profile_save').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    $('#emp_cover').attr('src', res_arr[1]);
                } else if ($.trim(res_arr[1]) == "2") {
                    toastr.warning($('#demo_mode').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }

            }
        });


    });

    /* Employers Deleting  Jobs */

    $(".del_my_job").on("click", function () {
        var my_job_id = $(this).attr("data-value");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'del_emp_job',
                            emp_job_id: my_job_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#all-jobs-list-box2-" + my_job_id).remove();
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });


    });

    /* Candidate Profile  */
    // Validating Candidate Profile process
    if ($('#candidate-settings').length > 0) {
        $('.cand_settings_pro').hide();
        $('#candidate-settings').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    $('.cand_settings_save').hide();
                    $('.cand_settings_pro').show();
                    // Ajax for Registration
                    $.post(nokri_ajax_url, {
                        action: 'candidate_settings_action',
                        candidate_data: $("form#candidate-settings").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('.cand_settings_save').show();
                        $('.cand_settings_pro').hide();
                        if ($.trim(response) == '1') {
                            toastr.success($('#nokri_emp_profile_save').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });

                        }
                    });
                    return false;
                });
    }

    /* Candidate Profile  */
    // Validating Candidate Profile process
    if ($('#candidate-profile').length > 0) {
        $('.cand_person_pro').hide();
        $('#candidate-profile').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    $('.cand_person_save').hide();
                    $('.cand_person_pro').show();
                    // Ajax for Registration
                    $.post(nokri_ajax_url, {
                        action: 'candidate_profile_action',
                        candidate_data: $("form#candidate-profile").serialize(),
                    }).done(function (response) {

                        $('.cp-loader').hide();
                        $('.cand_person_save').show();
                        $('.cand_person_pro').hide();
                        if ($.trim(response) == '1') {
                            toastr.success($('#nokri_emp_profile_save').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '6') {
                            toastr.warning($('#add_skills_value').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '5') {
                            toastr.warning($('#validate_vid').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"

                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);

                        } else {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });

                        }
                    });
                    return false;
                });

    }

//image cropper code
    if ($('#edit-user-pic').length > 0) {

        /*Show Crop Modal */
        $('#edit-user-pic').on('click', function () {
            $("#edit-profile-modal").modal();
        });

        /*Show Cropper on Image */
        var crop_img = $(".cropper-img > img"),
                options = {
                    aspectRatio: 1 / 1,
                    data: {
                        x: 480,
                        y: 60,
                        width: 640,
                        height: 360
                    },
                    enableResize: true
                };
        crop_img.cropper(options);

        var browsed_img = $("#browse-cand-dp");
        //browse image file  
        browsed_img.change(function () {
            var cur_url;
            var files = this.files,
                    file;
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    if (cur_url) {
                        URL.revokeObjectURL(cur_url);
                    }
                    cur_url = URL.createObjectURL(file);
                    crop_img.cropper("reset", true).cropper("replace", cur_url);
                    browsed_img.val("");
                }
            }
        });

        $("#image_rotator").on('click', function (e) {
            var crop_img = $(".cropper-img > img");

            crop_img.cropper('rotate', -90);
        });
        $('#crop_image_submit').on('click', function (ev) {
            ev.preventDefault();
            var crop_img = $(".cropper-img > img");

            var img_data = crop_img.cropper("getDataURL", "image/jpeg");

            var btn = $(this);
            btn.prop('disabled', true);
            $.ajax({
                url: nokri_ajax_url,
                type: "POST",
                data: {
                    action: "upload_cropped_image",
                    cropped_img: img_data,
                },
                success: function (res) {
                    btn.prop('disabled', false);
                    $('.cp-loader').hide();
                    var res_arr = res.split("|");
                    if ($.trim(res_arr[0]) == "1") {
                        toastr.success($('#nokri_dp_save').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                        $('#candidate_dp').attr('src', res_arr[1]);
                    } else if ($.trim(res_arr[0]) == "4") {
                        toastr.warning($('#demo_mode').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    } else {
                        toastr.error(res_arr[1], '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }

                }
            });
        });

    }

    // Upload Candidate profile picture 
    $('body').on('change', '.candidate_files-data', function (e) {


        var fd = new FormData();
        var files_data = $('.form-group .candidate_files-data');
        $.each($(files_data), function (i, obj) {
            $.each(obj.files, function (j, file) {
                fd.append('candidate_dp[' + j + ']', file);
            });
        });
        fd.append('action', 'candidate_dp');
        $('.cp-loader').show();
        $.ajax({
            type: 'POST',
            url: nokri_ajax_url,
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                $('.cp-loader').hide();
                var res_arr = res.split("|");
                if ($.trim(res_arr[0]) == "1") {
                    toastr.success($('#nokri_dp_save').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });

                    $('#candidate_dp').attr('src', res_arr[1]);

                } else if ($.trim(res_arr[0]) == "2") {
                    toastr.warning($('#demo_mode').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                } else {
                    toastr.error(res_arr[1], '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }

            }
        });
    });

    /* Validating external email */
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }
    /* External Apply package update */
    $(".external_apply").on("click", function () {
        var apply_job_id = $(this).attr('data-job-id');
        var external = $(this).attr('data-job-exter');
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.external_apply,
            type: 'blue',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'external_apply_package_base',
                            'apply_job_id': apply_job_id,
                            async: false
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            var get_r = response.split('|');
                            if ($.trim(get_r[0]) == "4") {
                                if (validateEmail(external))
                                {
                                    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
                                    if (iOS) {
                                        location.replace("mailto:" + external);
                                    } else {
                                        window.open("mailto:" + external);
                                    }
                                } else
                                {
                                    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
                                    if (iOS) {
                                        location.replace(external);
                                    } else {
                                        window.open(external, '_blank');
                                    }
                                }
                            } else if ($.trim(get_r[0]) == '2') {
                                toastr.warning(get_r[1], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                                window.location = get_r[2];
                            } else if ($.trim(get_r[0]) == '3') {
                                toastr.warning(get_r[1], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                                window.location = get_r[2];
                            } else if ($.trim(get_r[0]) == '1') {
                                toastr.warning(get_r[1], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                                window.location = get_r[2];
                            }
                        });
                    }
                },
                somethingElse: {
                    text: get_strings.btn_cancel,
                    btnClass: 'btn-blue',
                    action: function () {
                    }
                },
            }
        });
    });

    // Candidate Aplly Job Athentication
    $(".apply_job").on("click", function () {
        $('.cp-loader').show();
        //$("#applying_job").attr('data-job-id');
        var apply_job_id = $(this).attr('data-job-id');
        var apply_author_id = $(this).attr('data-author-id');
        $.post(nokri_ajax_url, {
            action: 'aplly_job',
            'apply_job_id': apply_job_id,
            'apply_author_id': apply_author_id
        }).done(function (response) {
            $('.cp-loader').hide();
            var get_r = response.split('|');
            if ($.trim(response) == '2') {
                toastr.error($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '3') {
                toastr.info($('#not_cand').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(get_r[0]) == '6') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(response) == '5') {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '4') {
                $.dialog({
                    title: get_strings.apply_msg,
                    content: get_strings.apply_details,
                    icon: 'fa fa-frown-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else if ($.trim(get_r[0]) == '7') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else {
                $("#popup-data").html(response);
                $('.job_textarea').jqte({
                    link: false,
                    unlink: false,
                    formats: [
                        ["p", get_strings.p_text],
                        ["h2", "H2"],
                        ["h3", "H3"],
                        ["h4", "H4"],
                    ],
                    funit: false,
                    fsize: false,
                    fsizes: false,
                    color: false,
                    strike: false,
                    source: false,
                    sub: false,
                    sup: false,
                    indent: false,
                    outdent: false,
                    right: false,
                    left: false,
                    center: false,
                    remove: false,
                    rule: false,
                    title: false,
                    p: true,
                });
                // Initialize Select After Response
                $(".select-generat").select2({
                    placeholder: get_strings.resume_select,
                    allowClear: true,
                    maximumSelectionLength: 5,
                    language: {
                        noResults: function (params) {
                            return get_strings.no_res;
                        }
                    }
                });
                $("#myModal-job").modal("show");
                $("#input-b2").fileinput({
                    browseLabel: get_strings.browse_btn,
                    removeLabel: get_strings.remove_btn,
                });
                $('.cp-loader').hide();
            }
        });
    });

    // Candidate Aplly Job email Athentication
    $(".email_apply").on("click", function () {
        $('.cp-loader').show();
        //$("#applying_job").attr('data-job-id');
        var apply_job_id = $(this).attr('data-job-id');
        var apply_external_email = $(this).attr('data-job-exter');


        $.post(nokri_ajax_url, {
            action: 'aplly_job_with_email',
            'apply_job_id': apply_job_id,
            'apply_email': apply_external_email,
        }).done(function (response) {


            $('.cp-loader').hide();
            var get_r = response.split('|');
            if ($.trim(response) == '2') {
                toastr.error($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '3') {
                toastr.info($('#not_cand').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(get_r[0]) == '6') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(response) == '5') {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '4') {
                $.dialog({
                    title: get_strings.apply_msg,
                    content: get_strings.apply_details,
                    icon: 'fa fa-frown-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else {
                $("#popup-data").html(response);
                $('.job_textarea').jqte({
                    link: false,
                    unlink: false,
                    formats: [
                        ["p", get_strings.p_text],
                        ["h2", "H2"],
                        ["h3", "H3"],
                        ["h4", "H4"],
                    ],
                    funit: false,
                    fsize: false,
                    fsizes: false,
                    color: false,
                    strike: false,
                    source: false,
                    sub: false,
                    sup: false,
                    indent: false,
                    outdent: false,
                    right: false,
                    left: false,
                    center: false,
                    remove: false,
                    rule: false,
                    title: false,
                    p: true,
                });
                // Initialize Select After Response
                $(".select-generat").select2({
                    placeholder: get_strings.resume_select,
                    allowClear: true,
                    maximumSelectionLength: 5,
                    language: {
                        noResults: function (params) {
                            return get_strings.no_res;
                        }
                    }
                });
                $("#myModal-email-job").modal("show");
                $("#input-b2").fileinput({
                    browseLabel: get_strings.browse_btn,
                    removeLabel: get_strings.remove_btn,
                });
                $('.cp-loader').hide();
            }
        });
    });
    /* Toggle for questionares */
    if ($('#job_qstns_enable').val() == 1)
    {
        $('.job_qstns').hide();
        var exist = $('#job_qstns_exist').val();
        if (exist)
        {
            $('.job_qstns').show();
        }
        $(function () {
            $(document).on('change', '#job_qstns_toggle', function () {
                var is_ad_qstns = $(this).prop('checked');
                if (!is_ad_qstns)
                {
                    $('.job_qstns').hide();
                    $('.jobs_questions').val('');
                } else
                {
                    $('.job_qstns').show();
                }
            });
        });
    }
// Candidate short details popups
    $(".candidate_short_det").on("click", function () {
        $('.cp-loader').show();
        $("#short-desc-data").html('');
        var candidate_id = $(this).attr('data-applierId');
        var job_id = $(this).attr('data-jobid');
        var attachment_id = $(this).attr('data-attachid');
        $.post(nokri_ajax_url, {
            action: 'candidate_short_details',
            'candidate_id': candidate_id,
            'job_id': job_id,
            'attachment_id': attachment_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == '2') {
                toastr.error($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                $("#short-desc-data").html(response);
                $("#short-detail-modal").modal("show");
                $('.cp-loader').hide();
            }
        });
    });
    // Update resume access package
    $(".update_pkg").on("click", function () {
        var candidate_id = $(this).attr('data-candId');
        var attach_id = $(this).attr('data-attachId');
        $.post(nokri_ajax_url, {
            action: 'update_resume_access',
            'candidate_id': candidate_id,
            'attach_id': attach_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '1') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(get_r[0]) == '2') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(get_r[0]) == '3') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(get_r[0]) == '4') {
                window.location = get_r[1];
            }
        });
    });


    // Candidate View Job Application
    $(".view_app").on("click", function () {
        $('.cp-loader').show();
        var app_job_id = $(this).attr("data-value");
        $("#app-data").html('');
        $.post(nokri_ajax_url, {
            action: 'view_application',
            'app_job_id': app_job_id
        }).done(function (response) {
            $("#app-data").html(response);
            $("#appmodel").modal("show");
            $('.cp-loader').hide();
        });

    });
    // Add to Cart for employer
    $('body').on('click', '.sb_add_cart', function () {
        $('.cp-loader').show();
        $.post(nokri_ajax_url, {
            action: 'sb_add_cart',
            product_id: $(this).attr('data-product-id'),
            qty: $(this).attr('data-product-qty'),
            is_free: $(this).attr('data-product-is-free'),
        }).done(function (response) {
            $('.cp-loader').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '3') {
                toastr.success(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(get_r[0]) == '5') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '7') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '4') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '6') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '1') {
                toastr.success(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            }
        });
    });
    // Add to Cart for candidate
    $('body').on('click', '.sb_add_cart_cand', function () {
        $('.cp-loader').show();
        $.post(nokri_ajax_url, {
            action: 'sb_add_cart_cand',
            product_id: $(this).attr('data-product-id'),
            qty: $(this).attr('data-product-qty'),
            is_free: $(this).attr('data-product-is-free'),
        }).done(function (response) {
            $('.cp-loader').hide();
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == '3') {
                toastr.success(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else if ($.trim(get_r[0]) == '5') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '7') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '4') {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '6') {
                toastr.warning(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(get_r[0]) == '1') {
                toastr.success(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
                window.location = get_r[2];
            } else {
                toastr.error(get_r[1], '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        });
    });

    if ($('#facebook_key').val() != "" && $('#google_key').val() != "") {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
            google: $('#google_key').val(),
        }, {
            redirect_uri: $('#redirect_uri').val()
        });
    } else if ($('#facebook_key').val() != "" && $('#google_key').val() == "") {
        // Hello JS
        hello.init({
            facebook: $('#facebook_key').val(),
        }, {
            redirect_uri: $('#redirect_uri').val()
        });
    } else if ($('#google_key').val() != "" && $('#facebook_key').val() == "") {
        // Hello JS
        hello.init({
            google: $('#google_key').val(),
        }, {
            redirect_uri: $('#redirect_uri').val()
        });
    }

    // Hello JS Hander
    $('a.btn-social').on('click', function () {
        hello.on('auth.login', function (auth) {
            console.log(auth);
            $('.cp-loader').show();
            // Call user information, for the given network
            hello(auth.network).api('me').then(function (r) {
                if ($('.get_action').val() == 'login' || $('.get_action').val() == 'register') {

                    var access_token = hello(auth.network).getAuthResponse().access_token;
                    var sb_network = hello(auth.network).getAuthResponse().network;

                    $.post(nokri_ajax_url, {
                        action: 'sb_social_login',
                        email: r.email,
                        key_code: $('#nonce').val(),
                        access_token: access_token,
                        sb_network: sb_network,

                    }).done(function (response) {

                        console.log(response);

                        var get_r = response.split('|');
                        if ($.trim(get_r[0]) == '1') {
                            $('#nonce').val(get_r[1]);
                            if ($.trim(get_r[2]) == '1') {
                                toastr.success(get_r[3], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                                window.location = $('#profile_page').val();
                            } else if ($.trim(get_r[2]) == '3') {
                                toastr.warning(get_r[3], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error(get_r[3], '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }

                        } else {
                            toastr.error(get_r[3], '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                } else {
                    $('#sb_reg_name').val(r.name);
                    $('#sb_reg_email').val(r.email);
                }
                $('.cp-loader').hide();
            });
        });
    });
    // Validating Acount Type process


    if ($('#social_login_form').length > 0) {
        $('#social_login_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {

                    $.post(nokri_ajax_url, {
                        action: 'after_social_login',
                        social_login_data: $("form#social_login_form").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) !== "") {
                            toastr.success($('#job_cv_action').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            window.location = $('#profile_page').val();
                        } else {
                            toastr.error($('#job_cv_action_fail').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });

    }

    /*Make Post on blur of title field*/
    $('#ad_title').on('blur', function () {
        if ($('#is_update').val() == "") {
            $.post(nokri_ajax_url, {
                action: 'post_ad',
                title: $('#ad_title').val(),
                is_update: $('#is_update').val(),
            }).done(function (response) {

            });
        }

    });

    /* ======= Ad Location ======= */
    if ($('#lat').length > 0) {

        var map_type = get_strings.nokri_map_type;
        var lat = $('#lat').val();
        var lon = $('#lon').val();
        if (map_type == 'leafletjs_map') {
            /*For leafletjs map*/
            var map = L.map('itemMap').setView([lat, lon], 5);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ''
            }).addTo(map);
            L.marker([lat, lon]).addTo(map);
        } else if (map_type == 'google_map') {


            var map = "";
            var latlng = new google.maps.LatLng(lat, lon);
            var myOptions = {
                zoom: 13,
                center: latlng,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                size: new google.maps.Size(480, 240)
            }
            map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
            var marker = new google.maps.Marker({
                map: map,
                position: latlng
            });
        }
    }

    /* ======= Phone number ======= */
    var phonenumbers = [];
    $(".phonenumber").each(function (i) {
        phonenumbers.push($(this).text());
        var text_string = get_strings.showNumber;
        var hashes = '***** ';
        var newcontent = $(this).text().substr(0, $(this).text().length - 7) + hashes + text_string
        $(this).text(newcontent);
        $(this).bind("click", function () {
            if ($(this).text() == phonenumbers[i]) {
                //$(this).text(phonenumbers[i].substr(0, phonenumbers[i].length - 7));
            } else {
                $(".phonenumber").each(function (x) {
                    if ($(this).text() == phonenumbers[x]) {
                        $(this).text(phonenumbers[x].substr(0, phonenumbers[x].length - 4));
                    }
                });
                $(this).text(phonenumbers[i]);
            }
        });
    });


    /* ======= Contact Map ======= */

    if ($('#contact-lat').length > 0) {
        var contact_lat = $('#contact-lat').val();
        var contact_lon = $('#contact-long').val();
        var map = "";
        var latlng = new google.maps.LatLng(contact_lat, contact_lon);
        var myOptions = {
            zoom: 15,
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            size: new google.maps.Size(480, 240)
        }
        map = new google.maps.Map(document.getElementById("contact-map"), myOptions);
        var marker = new google.maps.Marker({
            map: map,
            position: latlng
        });
    }
    /* ======= Category template ======= */
    var is_category_based = $("#is_category_based").val();
    function getCustomTemplate(ajax_url, catId, updateId, is_top) {
        /*For Category Templates*/
        $.post(ajax_url, {
            action: 'sb_get_sub_template',
            'cat_id': catId,
            'is_update': updateId,
        }).done(function (response) {
            if ($.trim(response) != "") {
                $("#dynamic-fields").html(response);
                $('.skin-minimal .list li input').iCheck({
                    checkboxClass: 'icheckbox_square',
                    radioClass: 'iradio_square',
                    increaseArea: '10%'
                });
                nokri_get_date_picker('days', 'datepicker-here-dynamic', '');
                $('#dynamic-fields select').select2();

//                if ($('#job_tags').length > 0) {
//                $('#job_tags').tagEditor({
//                    placeholder: get_strings.select_jobs_tags,
//                    removeDuplicates: false,
//                    language: {
//                        noResults: function (params) {
//                            return get_strings.no_res;
//                        }
//                    }
//                });}
                if ($('#is_category_based').val() == 1) {
                    sbDropzone_custom();
                }
                //carspot_inputTags();
            } else {
                $("#dynamic-fields").html('');
            }
            $('#sb_loading').hide();
        });
        /*For Category Templates*/
    }
    /* Re-inititalization after custom feilds*/
    $(document).ready(function () {
        $('#job_tags').tagEditor({
            placeholder: get_strings.select_jobs_tags,
            removeDuplicates: false,
        });
        $('.skin-minimal .list li input').iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square',
            increaseArea: '10%'
        });
        nokri_get_date_picker('days', 'datepicker-here-dynamic', 'mm/dd/yyyy');
        $('#dynamic-fields select').select2();
    });
    // Candidate submmiting linkedin url
    $(".submit_linkedin_url").on("click", function () {
        $('#submit_linkedin_url').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    var apply_job_id = $('#linkedin_job_id').val();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'submiit_linkedin_url',
                        'apply_job_id': apply_job_id,
                        submit_linkedin_url: $("form#submit_linkedin_url").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) != '2') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.action_success,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            window.location = response;
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                    return false;
                });
    });
    /***********/
    /* Job Post*/
    /***********/
    if ($('#emp-job-post').length > 0) {
        // Countries Hide 
        $('#ad_country_sub_div').hide();
        $('#ad_country_sub_sub_div').hide();
        $('#ad_country_sub_sub_sub_div').hide();
        // Categories Hide 
        $('#second_level').hide();
        $('#third_level').hide();
        $('#forth_level').hide();


        if ($('#is_update').val() != "") {
            var level = $('#is_level').val();
            if (level >= 2) {
                $('#ad_cat_sub_div').show();
            }
            if (level >= 3) {
                $('#ad_cat_sub_sub_div').show();
            }
            if (level >= 4) {
                $('#ad_cat_sub_sub_sub_div').show();
            }

            // Countries Level

            var country_level = $('#country_level').val();
            if (country_level >= 2) {
                $('#ad_country_sub_div').show();
            }
            if (country_level >= 3) {
                $('#ad_country_sub_sub_div').show();
            }
            if (country_level >= 4) {
                $('#ad_country_sub_sub_sub_div').show();
            }

        }
        $('#job_proc').hide();
        $('#job_redir').hide();
        $('#emp-job-post').parsley().on('field:validated', function () {})
                .on('form:submit', function () {
                    // Ad Post
                    $('.cp-loader').show();
                    $('#job_proc').show();
                    $('#job_redir').hide();
                    $('#job_post').hide();
                    $.post(nokri_ajax_url, {
                        action: 'sb_ad_posting',
                        sb_data: $("form#emp-job-post").serialize(),
                        is_update: $('#is_update').val(),
                    }).done(function (response) {
                        // console.log(response);
                        $('.cp-loader').hide();
                        if ($.trim(response) == "2")
                        {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $('#job_post').show();
                            $('#job_proc').hide();
                        } else if ($.trim(response) == "0") {
                            toastr.error($('#job_post_error').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == "3") {
                            toastr.error($('#only_admin').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $('#job_post').show();
                            $('#job_proc').hide();
                        } else {
                            toastr.success($('#nokri_emp_job_post').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                            $('#job_proc').hide();
                            $('#job_redir').hide();
                            $('#job_redir').show();
                            window.location = response;
                        }
                    });

                    return false;
                });


        if ($('#is_update').val() != "") {
            var level = $('#is_level').val();
            if (level >= 2) {
                $('#second_level').show();
            }
            if (level >= 3) {
                $('#third_level').show();
            }
            if (level >= 4) {
                $('#forth_level').show();
            }
        }

        /* Level 1 */
        $('#job_cat').on('change', function () {
            $('.cp-loader').show();
            $.post(nokri_ajax_url, {
                action: 'get_cats',
                cat_id: $("#job_cat").val(),
            }).done(function (response) {
                $('.cp-loader').hide();
                $("#second_level").val('');
                if ($.trim(response) != "") {
                    second_level
                    $('#job_cat_id').val($("#job_cat").val());
                    $('#second_level').show();
                    $('#job_cat_second').html(response);
                } else {
                    $('#second_level').hide();
                    $('#third_level').hide();
                    $('#forth_level').hide();
                }
                if (get_strings.is_cat_temp == '1')
                {
                    /*For Category Templates*/
                    getCustomTemplate(nokri_ajax_url, $("#job_cat").val(), $("#is_update").val(), true);
                    /*For Category Templates*/
                }
            });
        });

        /* Level 2 */
        $('#job_cat_second').on('change', function () {
            $('.cp-loader').show();
            $.post(nokri_ajax_url, {
                action: 'get_cats',
                cat_id: $("#job_cat_second").val(),
            }).done(function (response) {
                $('.cp-loader').hide();
                if ($.trim(response) != "") {
                    $('#ad_cat_id').val($("#ad_cat_sub").val());
                    $('#third_level').show();
                    $('#job_cat_third').html(response);
                } else {
                    $('#third_level').hide();
                    $('#forth_level').hide();
                }
                if (get_strings.is_cat_temp == '1')
                {
                    /*For Category Templates*/
                    getCustomTemplate(nokri_ajax_url, $("#job_cat").val(), $("#is_update").val(), true);
                    /*For Category Templates*/
                }
            });
        });

        /* Level 3 */
        $('#job_cat_third').on('change', function () {
            $('.cp-loader').show();
            $.post(nokri_ajax_url, {
                action: 'get_cats',
                cat_id: $("#job_cat_third").val(),
            }).done(function (response) {
                $('.cp-loader').hide();
                $("#ad_cat_sub_sub_sub").val('');
                if ($.trim(response) != "") {
                    $('#ad_cat_id').val($("#ad_cat_sub_sub").val());
                    $('#forth_level').show();
                    $('#job_cat_forth').html(response);
                } else {
                    $('#forth_level').hide();
                }
                if (get_strings.is_cat_temp == '1')
                {
                    /*For Category Templates*/
                    getCustomTemplate(nokri_ajax_url, $("#job_cat").val(), $("#is_update").val(), true);
                    /*For Category Templates*/
                }
            });
        });

        /* Level 4 */
        $('#ad_cat_sub_sub_sub').on('change', function () {
            $('#ad_cat_id').val($("#ad_cat_sub_sub_sub").val());
        });

    }


    // Candidate resume status action
    $(".candidate_resume_action").on("click", function () {
        $('.cp-loader').show();
        var candidate_id = $(this).attr('data-applierId');
        var job_id = $(this).attr('data-jobid');
        $.post(nokri_ajax_url, {
            action: 'candidate_resume_status_action',
            'candidate_id': candidate_id,
            'job_id': job_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == '2') {
                toastr.error($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                $("#status_action_data").html(response);

                $(function () {
                    $('#email_send_toggle').bootstrapToggle();
                });
                // Initialize Select After Response
                $(".js-example-basic-single").select2({
                    placeholder: get_strings.template_select,
                    allowClear: true,
                    maximumSelectionLength: 5,
                    language: {
                        noResults: function (params) {
                            return get_strings.no_res;
                        }
                    }
                });
                $("#myModalaction").modal("show");
                $('.email-status').hide();
                $('.cp-loader').hide();
            }
        });
    });
    /* Candidate Submitting Resume On Job */
    $(document).on('click', '#submit_cv_form_btn', function () {
        $('#submit_cv_form1').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'submit_cv_action',
                        submit_cv_data: $("form#submit_cv_form1").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) == '4') {
                        }
                        if ($.trim(response) == '1') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.apply_without,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '2') {
                            toastr.warning($('#upload_doc').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '3') {
                            toastr.error($('#email_exist').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });

//submitting resume for email job

    $(document).on('click', '#submit_cv_form_email_btn', function () {
        $('#submit_cv_form_email1').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'submit_cv_action_email',
                        submit_cv_data: $("form#submit_cv_form_email1").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) == '4') {
                        }
                        if ($.trim(response) == '1') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.apply_without,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if ($.trim(response) == '2') {
                            toastr.warning($('#upload_doc').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else if ($.trim(response) == '3') {
                            toastr.error($('#email_exist').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.error(response, '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });


    /* Employer Getting Id Of Candidate Send Email */
    $(".email-template-btn").on("click", function () {
        var appID = $(this).attr("data-applierId");
        $("#data-applierId-email").val(appID);
    });

    /* Employer Want To Send Email */
    $('.email-status').hide();
    $(function () {
        $(document).on('change', '#email_send_toggle', function () {
            var is_email = $(this).prop('checked');
            $("#is_send_email").val(is_email);
            if (!is_email) {
                $('.no-email-status').show();
                $('.email-status').hide();
                $('.no-email-subject').hide();
                $('.no-email-body').hide();
            } else {
                $('.no-email-status').hide();
                $('.email-status').show();
            }
        });
    });


    /* Employer Sending Email */
    $(document).on('click', '.send_email', function () {
        $('.cp-loader').show();
        // Ajax for Registration
        $.post(nokri_ajax_url, {
            action: 'sending_email',
            email_data: $("form#email_template_action").serialize(),
        }).done(function (response) {


            $('.cp-loader').hide();
            if ($.trim(response) == '1') {
                $.dialog({
                    title: get_strings.success,
                    content: get_strings.action_success,
                    icon: 'fa fa-smile-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            } else if ($.trim(response) == '2') {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                toastr.error(response, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        });

        return false;

    });

    /* Candidate Saving  Job */
    $(".save_job").click(function () {
        $('.cp-loader').show();
        var job_id = $(this).attr("data-value");
        $.post(nokri_ajax_url, {
            action: 'save_my_job',
            job_id: job_id,
        }).done(function (response) {

            $('.cp-loader').hide();
            if ($.trim(response) == "1") {
                toastr.success($('#saved_job_success').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "2") {
                toastr.warning($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "3") {
                toastr.info($('#not_cand').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "4") {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "5") {
                toastr.error($('#saved_job').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                toastr.error($('#job_cv_action_fail').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }

        });
    });

    /* Candidate Already Saved Message */

    $(".saved").click(function () {

        toastr.error($('#saved_job').val(), '', {
            timeOut: 2500,
            "closeButton": true,
            "positionClass": "toast-top-right"
        });
    });
    /* Candidate Following Company */
    $(".follow_company").click(function () {
        $('.cp-loader').show();
        var comp_id = $(this).attr("data-value");
        $.post(nokri_ajax_url, {
            action: 'following_company',
            company_id: comp_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == "2") {
                toastr.warning($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "3") {
                toastr.info($('#not_cand').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "4") {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "1") {
                toastr.success($('#comp_folow_success').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right",
                    onHidden: function () {
                        window.location.reload();
                    }
                });

            }
        });
    });




    /* Candidate Deleting Following Company */
    $(".unfollow_comp").on("click", function () {
        var comp_id = $(this).attr("data-value");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'un_following_company',
                            company_id: comp_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#company-box-" + comp_id).remove();
                            } else if ($.trim(response) == '2') {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });

    /* Company Deleting Followings */
    $(".unfollow_cands").on("click", function () {
        var follower_id = $(this).attr("data-id");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'un_following_followers',
                            follower_id: follower_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#company-box-" + follower_id).remove();
                            } else if ($.trim(response) == '2') {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                somethingElse: {text: get_strings.btn_cancel, action: function () {}}
            }
        });
    });


    /* Company Deleting saved resumes */
    $(".del_saved_resume").on("click", function () {
        var resume_id = $(this).attr("data-id");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'deleting_saved_resumes',
                            resume_id: resume_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#company-box-" + resume_id).remove();
                            } else if ($.trim(response) == '2') {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error($('#job_cv_action_fail').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                somethingElse: {text: get_strings.btn_cancel, action: function () {}}
            }
        });
    });


    /* Employer saving resume */
    $(".saving_resume").click(function () {
        $('.cp-loader').show();
        var cand_id = $(this).attr("data-cand-id");
        $.post(nokri_ajax_url, {
            action: 'emp_saving_resume',
            cand_id: cand_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == "2") {
                toastr.warning($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "3") {
                toastr.info($('#not_emp').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "1") {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });

            } else if ($.trim(response) == "4") {
                toastr.info($('#already_resume_saved').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "5") {
                toastr.success($('#emp_resume_save').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        });
    });

    /**/
    $(".generate_resume").click(function () {
        $('.cp-loader').show();
        var cand_id = $(this).attr("data-cand-id");
        var template_id = $(this).attr("data-id");
        $.post(nokri_ajax_url, {
            action: 'emp_generate_resume',
            cand_id: cand_id,
            template_id: template_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == "2") {
                toastr.warning($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "3") {
                toastr.info($('#not_emp').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == "1") {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                window.location.href = response;
            }
        });
    });

    //upload direct resume from shortcode hero section 1 and 2

    if ($("#upload_cand_resume").length > 0) {

        $('#upload_cand_resume').on('click', function () {
            var user_id = $('#check_user_login').val();
            var url = $('#check_user_login').data('redirect_url');
            if (user_id == "0") {
                window.location.href = url;
            } else {

                document.getElementById('my_cv_upload_custom').click();
            }
        })

    }

    /* Email job to anyone popup */
    $(".email_this_job").on("click", function () {
        $('.cp-loader').show();
        var email_job_id = $(this).attr('data-job-id');
        $.post(nokri_ajax_url, {
            action: 'email_this_job_popup',
            'email_job_id': email_job_id,
        }).done(function (response) {
            $('.cp-loader').hide();
            if ($.trim(response) == '2') {
                toastr.error($('#not_log_in').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '3') {
                toastr.info($('#not_cand').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else if ($.trim(response) == '5') {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                $("#popup-data").html(response);
                $("#myModal-job").modal("show");
                $('.cp-loader').hide();
            }
        });
    });
    /* Admin download Resumes against job */
    $(".download_admin_resumes").on("click", function () {
        $('.cp-loader').show();
        var download_job_id = $(this).attr('data-job-id');
        var attachment_id = $(this).attr('data-attachid');

        $.post(nokri_ajax_url, {
            action: 'download_admin_resumes_call',
            'download_job_id': download_job_id,
        }).done(function (response) {
            if ($.trim(response) == '2') {
                toastr.warning($('#demo_mode').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
            if ($.trim(response) == '3') {
                toastr.warning(get_strings.no_resume, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                console.log(response);


                window.location.href = response;
            }
        });
    });

    /* Email job to anyone */
    $(document).on('click', '#email_this_job_btn', function () {
        $('#email_this_job').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    // Ajax Submitting Resume
                    $.post(nokri_ajax_url, {
                        action: 'email_this_job',
                        submit_cv_data: $("form#email_this_job").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        if ($.trim(response) == '1') {
                            $.dialog({
                                title: get_strings.success,
                                content: get_strings.action_success,
                                icon: 'fa fa-smile-o',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'zoom',
                                closeAnimation: 'scale',
                                type: 'blue',
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error($('#some_wrong').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });
                    return false;
                });
    });



    /* Employer Action On Resume Request*/
    $('.action_change').on('change', function () {
        $('.cp-loader').show();
        var val = $(this).val();
        var val2 = $("#action_job_id").val();
        var val3 = $(this).attr('data-applier-id');
        $.post(nokri_ajax_url, {
            action: 'job_action',
            cv_action: val,
            job_id: val2,
            cand_id: val3,
        }).done(function (response) {
            $('.cp-loader').hide();

            if ($.trim(response) !== "") {
                $("#status-" + val3).html("<h5>" + response + "</h5>");
                toastr.success($('#job_cv_action').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            } else {
                toastr.error($('#job_cv_action_fail').val(), '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        });
    });

    /* Employer Create  Email Template*/

    if ($('#create_email_template').length > 0) {
        $('#temp_proc').hide();
        $('#create_email_template').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
        })
                .on('form:submit', function () {
                    $('.cp-loader').show();
                    $('#temp_save').hide();
                    $('#temp_proc').show();
                    // Ajax for Registration
                    $.post(nokri_ajax_url, {
                        action: 'create_email_action',
                        temp_data: $("form#create_email_template").serialize(),
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        $('#temp_proc').hide();
                        $('#temp_save').show();
                        if ($.trim(response) == '1') {
                            toastr.success($('#nokri_emp_profile_save').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        } else {
                            toastr.warning($('#demo_mode').val(), '', {
                                timeOut: 2500,
                                "closeButton": true,
                                "positionClass": "toast-top-right"
                            });
                        }
                    });

                    return false;
                });
    }

    /* Employer Select Email Template*/
    //$('.template_select').on('change', function() {
    $(document).on('change', '.template_select', function () {
        $('.cp-loader').show();
        var temp_val = $("#temp_select").val();
        $.post(nokri_ajax_url, {
            action: 'template_select_action',
            temp_val: temp_val,
        }).done(function (response) {
            $('.cp-loader').hide();
            $('#email_temp_html').html(response);
            $('.rich_textarea').jqte({
                link: false,
                unlink: false,
                formats: false,
                format: false,
                funit: false,
                fsize: false,
                fsizes: false,
                color: false,
                strike: false,
                source: false,
                sub: false,
                sup: false,
                indent: false,
                outdent: false,
                right: false,
                left: false,
                center: false,
                remove: false,
                rule: false,
                title: false,
            });
        });
    });

    /* Employer  Deleting Email Template */

    $(".del_email_template").on("click", function () {
        var email_temp_id = $(this).attr("data-tempId");
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'del_email_temp',
                            temp_id: email_temp_id,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#email_temp_del-" + email_temp_id).remove();
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });


    /*-- Getting Date Picker Value --*/
    var is_candidate = $("#is_candidate").val();
    if (is_candidate) {
        $(".datepicker-here, .datepicker-here-canidate").each(function (index) {
            if ($(this).val() == "") {
                //$(this).datepicker({minDate: $(this).val()});
            }
        });
    }


    /*-- DATE AND TIME PICKER Dynamically --*/

    $(document).on('click', 'body *', function () {

        $(".datepicker-here-canidate").each(function (index) {

            if ($(this).val() == "") {

                //$(this).datepicker({minDate: $(this).val()});
            }
        });

    });


    /* Employer Activating/InActivating Job */
    $(".inactive_job").on("click", function () {
        var job_id = $(this).attr("data-value");
        var job_status = $(this).attr('id');
        if (job_status == "active") {
            var title = get_strings.confirmation;
            var content = get_strings.content;
            var poptype_type = 'green';
            var btn_class = 'btn-green';
        } else {
            var title = get_strings.confirmation;
            var content = get_strings.content;
            var poptype_type = 'red';
            var btn_class = 'btn-red';
        }
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: title,
            content: content,
            type: poptype_type,
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: btn_class,
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'inactive_job',
                            job_id: job_id,
                            job_status: job_status,
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                                $("#all-jobs-list-box2-" + job_id).remove();
                            } else {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });


    /*Employer bumping up jobs*/
    $(".bump_this_job").on("click", function () {
        var job_id = $(this).attr("data-value");

        var title = get_strings.confirmation;
        var content = get_strings.content;
        var poptype_type = 'green';
        var btn_class = 'btn-green';

        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: title,
            content: content,
            type: poptype_type,
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: btn_class,
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'bump_this_job_call',
                            job_id: job_id
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "1") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                    close: function (event, ui) {
                                        location.reload();
                                    }
                                });
                            } else if ($.trim(response) == "2") {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else if ($.trim(response) == "0") {
                                toastr.warning(get_strings.no_bump_up, '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });







    //Countries
    /* Level 1 */
    $('#ad_country').on('change', function () {
        $('.ajax_loader').show();

        $("#ad_country_states").select2("val", "");
        $("#ad_country_cities").select2("val", "");
        $("#cand_country_towns").select2("val", "");

        $.post(nokri_ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country").val(),
        }).done(function (response) {
            $('.cp-loader').hide();

            if ($.trim(response) != "") {
                $('#ad_country_id').val($("#ad_cat").val());
                $('#ad_country_sub_div').show();
                $('#ad_country_states').html(response);
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            } else {

                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_div').hide();
                $('#ad_cat_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();

            }

        });
    });

    /* Level 2 */
    $('#ad_country_states').on('change', function () {

        //$("#ad_country_states").select2("val", "");
        $("#ad_country_cities").select2("val", "");
        $("#cand_country_towns").select2("val", "");

        $('.cp-loader').show();
        $.post(nokri_ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country_states").val(),
        }).done(function (response) {
            $('.cp-loader').hide();
            $("#ad_country_cities").val('');
            $("#ad_country_towns").val('');
            if ($.trim(response) != "") {
                $('#ad_country_id').val($("#ad_country_states").val());
                $('#ad_country_sub_sub_div').show();
                $('#ad_country_cities').html(response);
                $('#ad_country_sub_sub_sub_div').hide();
            } else {
                $('#ad_country_sub_sub_div').hide();
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });

    /* Level 3 */
    $('#ad_country_cities').on('change', function () {


        $('.cp-loader').show();
        $("#cand_country_towns").select2("val", "");
        $.post(nokri_ajax_url, {
            action: 'sb_get_sub_states',
            cat_id: $("#ad_country_cities").val(),
        }).done(function (response) {
            $('.cp-loader').hide();
            $("#ad_country_towns").val('');
            if ($.trim(response) != "") {
                $('#ad_country_id').val($("#ad_country_cities").val());
                $('#ad_country_sub_sub_sub_div').show();
                $('#ad_country_towns').html(response);
            } else {
                $('#ad_country_sub_sub_sub_div').hide();
            }
        });
    });


    /*-- Map Location --*/
    if ($('#is_gmap').val() == 1) {
        if (($('#is_profile_edit').length > 0 || $('#is_post_job').length > 0) && get_strings.nokri_map_type == 'google_map') {
            var latoz = $('#ad_map_lat').val();
            var longoz = $('#ad_map_long').val();
            var markers = [{
                    "title": "",
                    "lat": latoz,
                    "lng": longoz,
                }, ];
            window.onload = function () {
                my_g_map(markers);
            }
        }
    }

    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'manual'
    }).tooltip('show');
    $(document).ready(function () {
        // if($( window ).scrollTop() > 10){   scroll down abit and get the action   
        $(".progress-bar").each(function () {
            var each_bar_width = "";
            each_bar_width = $(this).attr('aria-valuenow');
            $(this).width(each_bar_width + '%');
        });

        //  }  
    });

    $('.agree-term input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        increaseArea: '60%' // optional
    });


    /* Candidate Employment Check  */

    /*ICHECKBOXES*/
    $(document).ready(function ($) {
        $('.dashboard-edit-profile input').iCheck({
            checkboxClass: 'icheckbox_minimal',
            increaseArea: '60%' // optional
        });

        $(document).on('ifChanged', 'input.icheckbox_minimal', function () {
            if ($(this).is(':checked')) {
                $(this).parent().parent().find('.end-hide').attr('readonly', 'readonly');
                $(this).parent().parent().find('input.checked-input-hide').val('1');
                $(this).parent().parent().find('input .end-hide').removeClass("datepicker-here-canidate");
            } else {
                $(this).parent().parent().find('.end-hide').removeAttr('readonly');
                $(this).parent().parent().find('input .end-hide').addClass("datepicker-here-canidate");
                $(this).parent().parent().find('input.checked-input-hide').val('0');
            }

        });
    });

    /* user change password */
    $('.cand_pass_pro').hide();
    $('.change_password').click(
            function () {
                $('.cp-loader').show();
                $('.change_password').hide();
                $('.cand_pass_pro').show();
                // Ajax for Registration
                $.post(nokri_ajax_url, {
                    action: 'change_password',
                    password_data: $("form#change_password").serialize(),
                }).done(function (response) {
                    $('.cp-loader').hide();
                    $('.cand_pass_pro').hide();
                    $('.change_password').show();
                    if ($.trim(response) == '0') {
                        toastr.error($('#old_password_miss').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    } else if ($.trim(response) == '1') {
                        toastr.error($('#new_password').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    } else if ($.trim(response) == '2') {
                        toastr.success($('#set_password').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    } else if ($.trim(response) == '3') {
                        toastr.error($('#old_password').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    } else if ($.trim(response) == '4') {
                        toastr.warning($('#demo_mode').val(), '', {
                            timeOut: 2500,
                            "closeButton": true,
                            "positionClass": "toast-top-right"
                        });
                    }
                });
                return false;
            });


    /* user del acount */
    $(".del_acount").on("click", function () {
        $.confirm({
            animationBounce: 1.5,
            closeAnimation: 'rotateXR',
            title: get_strings.confirmation,
            content: get_strings.content,
            type: 'red',
            buttons: {
                tryAgain: {
                    text: get_strings.btn_cnfrm,
                    btnClass: 'btn-red',
                    action: function () {
                        $('.cp-loader').show();
                        $.post(nokri_ajax_url, {
                            action: 'delete_myaccount',
                        }).done(function (response) {
                            $('.cp-loader').hide();
                            if ($.trim(response) == "0") {
                                $.dialog({
                                    title: get_strings.success,
                                    content: get_strings.action_success,
                                    icon: 'fa fa-smile-o',
                                    theme: 'modern',
                                    closeIcon: true,
                                    animation: 'scale',
                                    type: 'blue',
                                });
                            } else if ($.trim(response) == '4') {
                                toastr.warning($('#demo_mode').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            } else {
                                toastr.error($('#superadmin').val(), '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: get_strings.btn_cancel, // text for button
                    action: function (cancelButton) {
                        $('.cp-loader').hide();
                    }
                },
            }
        });
    });


    /* Newsletter function  */
    function nokri_validateEmail(sEmail) {
        var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }

    $('#processing_req').hide();
    $('#save_email').on('click', function () {
        var sb_email = $('#sb_email').val();
        var sb_action = $('#sb_action').val();
        if (nokri_validateEmail(sb_email)) {
            $('#save_email').hide();
            $('#processing_req').show();
            $.post(nokri_ajax_url, {
                action: 'sb_mailchimp_subcribe',
                'sb_email': sb_email,
                sb_action: sb_action
            }).done(function (response) {
                $('#processing_req').hide();
                $('#save_email').show();
                if (response == 1) {
                    toastr.success($('#chimp_success').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    $('#sb_email').val('');
                } else {
                    toastr.error($('#job_cv_action_fail').val(), '', {
                        timeOut: 2500,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                }
            });
        } else {
            toastr.error($('#chimp_mail_valid').val(), '', {
                timeOut: 2500,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });
        }

    });
    $('.cand-view-prof').on('click', function () {

        var canStatus = $(this).data('cand_status');
        var canID = $(this).data('cand_id');
        var jobID = $(this).data('job_id');
        if (canStatus == '0') {
            $.ajax({
                type: 'POST',
                url: nokri_ajax_url,
                data: {
                    action: "can_set_auto_viewed",
                    cand_status: canStatus,
                    cand_id: canID,
                    job_id: jobID,
                },
                success: function (res) {
                    if (res == '1') {
                        toastr.success(
                                get_strings.cand_status_change, '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                        location.reload();
                    }

                }
            });
        }

    });

//add globaly event trigering
    $('input[type="checkbox"]').on('ifChanged', function (e) {

        $(this).trigger("change", e);
    });
    //show password for sign in and sing up form
    if (("#show_password").length > 0) {
        $('#show_password').on("change", function () {
            var x = document.getElementById("sb_reg_password");
            var y = document.getElementById("sb_reg_conf_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            if (y) {
                if (y.type === "password") {
                    y.type = "text";
                } else {
                    y.type = "password";
                }
            }
        });
    }
//Search page loader 
    $("#more_jobs span").hide();
    $("#more_jobs").hover(function () {
        //$("#more_jobs span").show();
       
    });
    $("#more_jobs").click(function () {
        $("#more_jobs span").show();
         $("#more_jobs span").addClass("rotator");
        var page_num = parseInt($('#page_number').val()) + 1;
        var page_url = $('#page_url').val();
        if ($('#loading_flag').val() != '0') {
            $(".loader_container").css("display", "block");
        }
        $.ajax({
            type: 'POST',
            url: nokri_ajax_url,
            data: {
                action: "load_more_jobs",
                pageno: page_num,
                page_url: page_url,
            },
            success: function (data) {
                if (data != '') {
                    if (data.trim() == '0') {
                        $(".loader_container").css("display", "none");
                        $('#loading_flag').val('0');
                       $("#more_jobs span").hide();
                        $("#more_jobs").css("display", "none");
                    } else {
                        $('#jobs_container').append(data);
                        $('#page_number').val(page_num);
                        $(".loader_container").css("display", "none");
                        $("#more_jobs span").hide();
                    }
                } else {
                    $(".loader_container").css("display", "none");
                }
            }
        });


    });

    $(".mobile-filters-btn a, a.filter-close-btn").on("click", function () {
        $('.mobile-filters').toggleClass("active");
    });

    /*Scroll to top when arrow up clicked BEGIN*/
    $(document).ready(function () {
        $(".mobile-filters-btn a").click(function (event) {
            event.preventDefault();
            $("html, body").animate({scrollTop: 0}, "slow");
            return false;
        });

    });
    /* Business Hours Selection */
    $('.tab-pane .custom-checkbox').on('ifChecked', function (event) {
        var checkbox = $(this).attr("value");
        if ($(this).is(':checked')) {
            $("#to-" + checkbox).prop('readonly', true);
            $("#from-" + checkbox).prop('readonly', true);
        } else
        {
            $("#to-" + checkbox).prop('readonly', false);
            $("#from-" + checkbox).prop('readonly', false);
        }
    });
    /*For Business Hours*/
    $(document).on('ifChecked', '.frontend_hours input[type="radio"]', function () {
        var valzz = $(this).val();
        $('input[name=hours_type]').val(valzz);
        if (valzz == 2)
        {
            $("#timezone").removeClass("none");
            $("#business-hours-fields").removeClass("none");
            $("input#timezones").prop('required', true);
        } else
        {
            $("#timezone").addClass("none");
            $("#business-hours-fields").addClass("none");
            $("input#timezones").prop('required', false);
        }
    });
    if ($('.frontend_hours input[type="radio"]').is(':checked'))
    {
        var selected_valz = $('#hours_type').val();
        if (selected_valz == 2)
        {
            $("#timezone").removeClass("none");
            $("#business-hours-fields").removeClass("none");
            $("input#timezones").prop('required', true);
        } else
        {
            $("#timezone").addClass("none");
            $("#business-hours-fields").addClass("none");
            $("input#timezones").prop('required', false);
        }
    }


    if ($('.for_specific_page').is('.timepicker'))
    {
        $('.timepicker').timeselect({'step': 15, autocompleteSettings: {autoFocus: true}});
    }

    if ($('#timezone').is('.my-zones'))
    {
        var tzones = document.getElementById('theme_path').value + "/js/zones.json";
        $.get(tzones, function (data)
        {
            typeof $.typeahead === 'function' && $.typeahead({
                input: ".myzones-t",
                minLength: 0,
                emptyTemplate: get_strings.no_r_for + "{{query}}",
                searchOnFocus: true,
                blurOnTab: true,
                order: "asc",
                hint: true,
                source: data,
                debug: false,
            });
        }, 'json');
    }




})(jQuery);
jQuery(document).ready(function ($) {
    if ($('#spinner').length > 0) {
        document.getElementById('spinner').style.display = 'none';
    }
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;
        // Variables privadas
        var links = this.el.find('.profile-menu-link');
        // Evento
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        }, this.dropdown);
    };
    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this),
                $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        }
    };
    var accordion = new Accordion($('#accordion'), false);
});
jQuery(document).ready(function ($) {
    $("#your_current_location_alert").click(function () {
        $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                $("#sb_user_address").val(location.city + ", " + location.state + ", " + location.country_name);
            }
        });
    });
});
jQuery(document).ready(function ($) {
    $("#your_current_location_alert2").click(function () {
        $.ajax({
            url: "https://geoip-db.com/jsonp",
            jsonpCallback: "callback",
            dataType: "jsonp",
            success: function (location) {
                $("#sb_user_address2").val(location.city + ", " + location.state + ", " + location.country_name);
            }
        });
    });
});
//autoplace 
function my_g_map(markers1) {
    var my_map;
    var marker;
    var markers = [{
            "title": "",
            "lat": "37.090240",
            "lng": "-95.712891",
        }, ];
    var mapOptions = {
        center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var infoWindow = new google.maps.InfoWindow();
    var latlngbounds = new google.maps.LatLngBounds();
    var geocoder = geocoder = new google.maps.Geocoder();
    my_map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
    var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
    var data = markers1[0]
    var myLatlng = new google.maps.LatLng(data.lat, data.lng);
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: data.title,
        draggable: true,
        animation: google.maps.Animation.DROP
    });
    (function (marker, data) {
        google.maps.event.addListener(marker, "click", function (e) {
            infoWindow.setContent(data.description);
            infoWindow.open(map, marker);
        });
        google.maps.event.addListener(marker, "dragend", function (e) {
            jQuery('.cp-loader').show();
            //document.getElementById("sb_loading").style.display   = "block";
            var lat, lng, address;
            geocoder.geocode({
                "latLng": marker.getPosition()
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = marker.getPosition().lat();
                    lng = marker.getPosition().lng();
                    address = results[0].formatted_address;
                    document.getElementById("ad_map_lat").value = lat;
                    document.getElementById("ad_map_long").value = lng;
                    document.getElementById("sb_user_address").value = address;
                    jQuery('.cp-loader').hide();
                }
            });
        });
    })(marker, data);
    latlngbounds.extend(marker.position);
    jQuery(document).ready(function ($) {
        $("#your_current_location").click(function () {
            $.ajax({
                url: "https://geoip-db.com/jsonp",
                jsonpCallback: "callback",
                dataType: "jsonp",
                success: function (location) {
                    var pos = new google.maps.LatLng(location.latitude, location.longitude);
                    my_map.setCenter(pos);
                    my_map.setZoom(12);
                    $("#sb_user_address").val(location.city + ", " + location.state + ", " + location.country_name);
                    document.getElementById("ad_map_long").value = location.longitude;
                    document.getElementById("ad_map_lat").value = location.latitude;
                    var markers2 = [{
                            title: "",
                            lat: location.latitude,
                            lng: location.longitude,
                        }, ];
                    my_g_map(markers2);
                }
            });
        });
    });
}
/*-- Add More Educational Degrees --*/
var room = 1;
function nokri_textarea_initial(call) {
    call = typeof call !== 'undefined' ? call : '';
    $('button[data-remove-type=' + call + '] ').parent().parent().closest('div').find(".rich_textarea").jqte({
        link: false,
        unlink: false,
        formats: false,
        format: false,
        funit: false,
        fsize: false,
        fsizes: false,
        color: false,
        strike: false,
        source: false,
        sub: false,
        sup: false,
        indent: false,
        outdent: false,
        right: false,
        left: false,
        center: false,
        remove: false,
        rule: false,
        title: false,
    });
}
var eduClick = 0;
function education_fields() {
    "use strict";
    eduClick += 1;
    var my_Divs = Math.floor((Math.random() * 1000000000) + 1);
    var room = my_Divs + 1;
    var end_date_class = my_Divs + 2;
    var objTo = document.getElementById('education_fields');
    var divtest = document.createElement("div");
    var date_class = 'date-here-' + room;
    divtest.setAttribute("class", "form-group removeclass_edu" + room);
    var rdiv = 'removeclass_edu' + (room);
    /* Institute name */
    var inst = get_strings.quali_inst;
    if (inst)
    {
        var inst_html = '<div class="col-md-6 col-sm-6"><div class="form-group"><label>' + get_strings.inst_title + '</label><input type="text"  placeholder="' + get_strings.inst_plc + '" name="cand_education[\'degree_institute\'][]" class="form-control" ' + get_strings.inst_req + '></div></div>';
    } else {
        var inst_html = '';
    }
    /* Start date */
    var s_date = get_strings.s_date;
    if (s_date)
    {
        var s_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"><div class="form-group"><label class="">' + get_strings.sdate_title + '</label><input type="text" ' + get_strings.sdate_req + ' name="cand_education[\'degree_start\'][]" class="' + date_class + ' form-control"/></div></div>';
    } else {
        var s_date_html = '';
    }
    /* End date */
    var e_date = get_strings.e_date;
    if (e_date)
    {
        var e_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"> <div class="form-group"><label class="">' + get_strings.edate_title + '</label><input type="text" ' + get_strings.edate_req + '  name="cand_education[\'degree_end\'][]" class="' + end_date_class + ' form-control"/></div></div>';
    } else {
        var e_date_html = '';
    }
    /* Percentage */
    var percentage = get_strings.percent;
    if (percentage)
    {
        var percentage_html = '<div class="col-md-6 col-sm-6"> <div class="form-group"> <label>' + get_strings.perc_title + '</label> <input type="text"  placeholder="' + get_strings.perc_plc + '" name="cand_education[\'degree_percent\'][]" class="form-control" ' + get_strings.perc_req + '> </div></div>';
    } else {
        var percentage_html = '';
    }
    /* Grades */
    var grades = get_strings.grade;
    if (grades)
    {
        var grades_html = '<div class="col-md-6 col-sm-6"> <div class="form-group"> <label>' + get_strings.grad_title + '</label> <input type="text" placeholder="' + get_strings.grad_plc + '"  name="cand_education[\'degree_grade\'][]" class="form-control" ' + get_strings.grad_req + '></div></div>';
    } else {
        var grades_html = '';
    }
    /* Description */
    var desc = get_strings.desc;
    if (desc)
    {
        var desc_html = '<div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group"><label>' + get_strings.desc_title + '</label><textarea rows="6" ' + get_strings.desc_req + ' class="form-control rich_textarea" name="cand_education[\'degree_detail\'][]" id="ad_description"></textarea></div></div>';
    } else {
        var desc_html = '';
    }
    divtest.innerHTML = '<div class= "removeclass_edu"><div class= "ad-more-box-single"><div class="col-md-12 col-sm-12"><h4 class="dashboard-heading">' + get_strings.deghead + " " + eduClick + '</h4></div><div class="col-md-6 col-sm-6"><div class="form-group"><label>' + get_strings.degtitle + '<span class="required">*</span></label><input type="text"  placeholder="' + get_strings.deg_plc + '" name="cand_education[\'degree_name\'][]" class="form-control" ' + get_strings.deg_req + '></div></div>' + inst_html + '' + s_date_html + '' + e_date_html + '' + percentage_html + '' + grades_html + '' + desc_html + '<div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');" data-remove-type="' + room + '"> <span class="ti-minus" aria-hidden="true"></span>' + get_strings.degremov + '</button></div></div><div class="clearfix"></div></div>';
    objTo.appendChild(divtest);
    nokri_get_date_picker_start('months', date_class, 'MM yyyy', end_date_class);
    nokri_textarea_initial(room);
}
function remove_education_fields(rid) {
    "use strict";
    $.confirm({
        title: get_strings.confirmation,
        content: get_strings.content,
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: get_strings.btn_cnfrm,
                btnClass: 'btn-red',
                action: function () {
                    jQuery('.removeclass_edu' + rid).remove();
                }
            },
            cancel: {
                text: get_strings.btn_cancel, // text for button
                action: function (cancelButton) {
                    $('.cp-loader').hide();
                }
            },
        }
    });
}
/*-- Add More Professional Projects --*/
var room = 1;
function nokri_textarea_initial(call) {
    call = typeof call !== 'undefined' ? call : '';
    $('button[data-remove-type=' + call + '] ').parent().parent().closest('div').find(".rich_textarea").jqte({
        link: false,
        unlink: false,
        formats: false,
        format: false,
        funit: false,
        fsize: false,
        fsizes: false,
        color: false,
        strike: false,
        source: false,
        sub: false,
        sup: false,
        indent: false,
        outdent: false,
        right: false,
        left: false,
        center: false,
        remove: false,
        rule: false,
        title: false,
    });
}
var profclick = 0;
function professional_fields() {
    "use strict";
    profclick += 1;
    var my_Divs = Math.floor((Math.random() * 1000000000) + 1);
    var room = my_Divs + 1;
    var end_date_class = my_Divs + 2;
    var objTo = document.getElementById('professional_fields');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass_pro" + room);
    var rdiv = 'removeclass_pro' + room;
    var date_class_pro = 'date-here-pro' + room;
    /* Your Role */
    var role = get_strings.prof_role;
    if (role)
    {
        var role_html = '<div class="col-md-6 col-sm-12"><div class="form-group"><label>' + get_strings.role_title + '</label><input type="text"   placeholder="' + get_strings.role_plc + '" name="cand_profession[\'project_role\'][]" class="form-control" ' + get_strings.role_req + '></div></div>';
    } else {
        var role_html = '';
    }
    /* Start date */
    var s_date = get_strings.strt_show;
    if (s_date)
    {
        var s_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"><div class="form-group"><label class="">' + get_strings.strt_title + '</label><input type="text" ' + get_strings.strt_req + '  name="cand_profession[\'project_start\'][]" class="' + date_class_pro + '  form-control" /></div></div>';
    } else {
        var s_date_html = '';
    }
    /* End date */
    var e_date = get_strings.edate_show;
    if (e_date)
    {
        var e_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"><div class="form-group"><label class="">' + get_strings.edate_title + '</label><input type="text"  name="cand_profession[\'project_end\'][]" class="' + end_date_class + '  form-control end-hide"  /><input type="hidden"  value="0" name="cand_profession[\'project_name\'][]"  class="checked-input-hide" /><input type="checkbox" name="checked"  class="icheckbox_minimal control-class-' + room + '">' + get_strings.edate_curr + '</div></div>';
    } else {
        var e_date_html = '';
    }
    /* Description */
    var desc = get_strings.desc_show;
    if (desc)
    {
        var desc_html = '<div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group"><label>' + get_strings.desc_title + '</label><textarea rows="6"  class="form-control rich_textarea" name="cand_profession[\'project_desc\'][]" id="ad_description"></textarea></div></div>';
    } else {
        var desc_html = '';
    }
    divtest.innerHTML = '<div class= "ad-more-box-single"><div class="col-md-12 col-sm-12"><h4 class="dashboard-heading">' + get_strings.prof_head + " " + profclick + '</h4></div><div class="col-md-6 col-sm-12"><div class="form-group"><label>' + get_strings.org_title + '<span class="required">*</span></label><input type="text"  placeholder="' + get_strings.org_plc + '" name="cand_profession[\'project_organization\'][]" class="form-control" ' + get_strings.org_req + '></div></div>' + role_html + '' + s_date_html + '' + e_date_html + '' + desc_html + '</div></div><div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_professional_fields(' + room + ');" data-remove-type="' + room + '"> <span class="ti-minus" aria-hidden="true"></span>' + get_strings.prof_remov + '</button></div></div></div><div class="clearfix"></div></div></div>';
    objTo.appendChild(divtest);
    var class_name = 'control-class-' + room;
    nokri_get_date_picker_start('months', date_class_pro, 'MM yyyy', end_date_class)
    $('input').iCheck({
        checkboxClass: 'icheckbox_minimal',
        /*increaseArea: '20%' // optional*/
    });
    nokri_textarea_initial(room);
}
function remove_professional_fields(rid) {
    "use strict";
    $.confirm({
        title: get_strings.confirmation,
        content: get_strings.content,
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: get_strings.btn_cnfrm,
                btnClass: 'btn-red',
                action: function () {
                    jQuery('.removeclass_pro' + rid).remove();
                }
            },
            cancel: {
                text: get_strings.btn_cancel, // text for button
                action: function (cancelButton) {
                    $('.cp-loader').hide();
                }
            },
        }
    });
}
/*-- Add More Certifications --*/
var room = 1;
function nokri_textarea_initial(call) {
    call = typeof call !== 'undefined' ? call : '';
    $('button[data-remove-type=' + call + '] ').parent().parent().closest('div').find(".rich_textarea").jqte({
        link: false,
        unlink: false,
        formats: false,
        format: false,
        funit: false,
        fsize: false,
        fsizes: false,
        color: false,
        strike: false,
        source: false,
        sub: false,
        sup: false,
        indent: false,
        outdent: false,
        right: false,
        left: false,
        center: false,
        remove: false,
        rule: false,
        title: false,
    });
}
var cerClick = 0;
function certification_fields() {
    "use strict";
    cerClick += 1;
    var my_Divs = Math.floor((Math.random() * 1000000000) + 1);
    var room = my_Divs + 1;
    var end_date_class = my_Divs + 2;
    var objTo = document.getElementById('certification_fields');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass_cert" + room);
    var rdiv = 'removeclass_cert' + room;
    var date_class_certi = 'date-here-certi' + room;
    /* Start date */
    var s_date = get_strings.certi_sdate_show;
    if (s_date)
    {
        var s_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"> <div class="form-group"><label class="">' + get_strings.certstrt + '</label><input type="text"  name="cand_certifications[\'certification_start\'][]" class="' + date_class_certi + ' form-control" /></div></div>';
    } else {
        var s_date_html = '';
    }
    /* End date */
    var e_date = get_strings.edate_show;
    if (e_date)
    {
        var e_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"> <div class="form-group"><label class="">' + get_strings.certend + '</label><input type="text"  name="cand_certifications[\'certification_end\'][]" class="' + end_date_class + ' form-control" /></div></div>';
    } else {
        var e_date_html = '';
    }
    /* End date */
    var e_date = get_strings.edate_show;
    if (e_date)
    {
        var e_date_html = '<div class="col-md-6 col-xs-12 col-sm-6"> <div class="form-group"><label class="">' + get_strings.certend + '</label><input type="text"  name="cand_certifications[\'certification_end\'][]" class="' + end_date_class + ' form-control" /></div></div>';
    } else {
        var e_date_html = '';
    }
    /* Duration */
    var dur = get_strings.certi_dur_show;
    if (dur)
    {
        var dur_html = '<div class="col-md-6 col-sm-12"><div class="form-group"> <label>' + get_strings.certi_dur_title + '</label> <input type="text"  placeholder="' + get_strings.certi_dur_plc + '" name="cand_certifications[\'certification_duration\'][]" class="form-control" ' + get_strings.certi_dur_req + '></div></div>';
    } else {
        var dur_html = '';
    }
    /* Institute Name */
    var inst = get_strings.certi_inst_show;
    if (inst)
    {
        var inst_html = '<div class="col-md-6 col-sm-12"><div class="form-group"><label>' + get_strings.certi_inst_title + '</label><input type="text"   placeholder="' + get_strings.certi_inst_plc + '" name="cand_certifications[\'certification_institute\'][]" class="form-control" ' + get_strings.certi_inst_req + '></div></div>';
    } else {
        var inst_html = '';
    }
    /* DESC */
    var desc = get_strings.desc_show;
    if (desc)
    {
        var desc_html = '<div class="col-md-12 col-sm-12 col-xs-12"><div class="form-group"><label>' + get_strings.desc_title + '</label><textarea rows="6" class="form-control rich_textarea" name="cand_certifications[\'certification_desc\'][]" id="certification_description"></textarea></div></div>';
    } else {
        var _html = '';
    }
    divtest.innerHTML = '<div class="ad-more-box-single"><div class="col-md-12 col-sm-12"><h4 class="dashboard-heading">' + get_strings.cert_head + " " + cerClick + '</h4></div><div class="col-md-12 col-sm-12"><div class="form-group"><label>' + get_strings.certi_title + '<span class="required">*</span></label><input type="text" placeholder="' + get_strings.certi_plc + '"  name="cand_certifications[\'certification_name\'][]" class="form-control"></div></div>' + s_date_html + '' + e_date_html + '' + dur_html + '' + inst_html + '' + desc_html + '<div class="input-group-btn remove-btn"><button class="btn btn-danger" type="button" onclick="remove_certification_fields(' + room + ');" data-remove-type="' + room + '"> <span class="ti-minus" aria-hidden="true"></span>' + get_strings.degremov + '</button></div></div></div><div class="clearfix"></div></div></div>';
    objTo.appendChild(divtest);
    //nokri_get_date_picker('months', date_class_certi, 'MM yyyy');
    nokri_get_date_picker_start('months', date_class_certi, 'MM yyyy', end_date_class);
    nokri_textarea_initial(room);
}
function remove_certification_fields(rid) {
    "use strict";
    $.confirm({
        theme: 'dark',
        title: get_strings.confirmation,
        content: get_strings.content,
        type: 'red',
        typeAnimated: true,
        buttons: {
            tryAgain: {
                text: get_strings.btn_cnfrm,
                btnClass: 'btn-red',
                action: function () {
                    jQuery('.removeclass_cert' + rid).remove();
                }
            },
            cancel: {
                text: get_strings.btn_cancel, // text for button
                action: function (cancelButton) {
                    $('.cp-loader').hide();
                }
            },
        }
    });
}
var $ = jQuery.noConflict();
jQuery(document).ready(function () {
    "use strict";
    $('.tool-tip').tipsy({
        arrowWidth: 10,
        attr: 'data-tipsy',
        cls: null,
        duration: 150,
        offset: 7,
        position: 'top-center',
        trigger: 'hover',
    });
    nokri_get_date_picker_dob('days', 'datepicker-cand-dob', 'mm/dd/yyyy');
    nokri_get_date_picker_custom('days', 'datepicker-custom-feilds', 'dd/mm/yyyy');
    nokri_get_date_picker_job_post('days', 'datepicker-job-post', 'mm/dd/yyyy');
});
$(document).one('ready', function () {
    $('.datepicker-here-canidate').datepicker({
        view: 'months',
        minView: 'months',
        dateFormat: 'MM yyyy',
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0,

        },
    });
});
$(document).on("click", ".datepicker-here-canidate", function () {
    var apl_class = $(this).attr("class").split(' ')[0];

    last_date = '';
    var first_date = $(this).attr('data-date-input');
    var last_class = '';
    var v_length = $(this).parent().parent().next().find('input.date-end').length;
    if (v_length > 0) {
        var last_date = $(this).parent().parent().next().find('input.date-end').data('date-input');
        var v1 = $(this).parent().parent().next().find('input.date-end').attr("class").split(' ')[2];
        last_class = v1;
    }
    $('input[data-date-input="' + first_date + '"]').datepicker({
        view: 'months',
        minView: 'months',
        dateFormat: 'MM yyyy',
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0,
        },
    });

    $('input[data-date-input="' + first_date + '"]').datepicker({
        onSelect: function (dateText, inst) {
            var a = $('input[data-date-input="' + first_date + '"]').val();
            var b = $('input[data-date-input="' + last_date + '"]').val();
            $('input[data-date-input="' + last_date + '"]').datepicker({
                view: 'months',
                minView: 'months',
                dateFormat: 'MM yyyy',
                minDate: inst,
                language: {
                    days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
                    daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
                    daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
                    months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
                    monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
                    today: get_strings.Today,
                    clear: get_strings.Clear,
                    timeFormat: 'hh:ii aa',
                    firstDay: 0
                },
            });
            if (a > b) {
                var b = $('input[data-date-input="' + last_date + '"]').val('');
            }
        },
    });
});
function nokri_get_date_picker(c_view, apl_class, date_format) {
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        timepicker: false,
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
}
function nokri_get_date_picker_start(c_view, apl_class, date_format, end_date_class) {
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
    $(function () {
        $('.' + apl_class).datepicker({
            onSelect: function (dateText, inst) {
                nokri_get_date_picker_end(c_view, end_date_class, date_format, inst);
            }
        });
    });
}
function nokri_get_date_picker_end(c_view, apl_class, date_format, end_date) {
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        minDate: end_date,
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
}
function nokri_get_date_picker_dob(c_view, apl_class, date_format, end_class) {
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        maxDate: new Date(),
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
}
function nokri_get_date_picker_custom(c_view, apl_class, date_format, end_class) {
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        //maxDate: new Date(),
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
}
function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}
function nokri_get_date_picker_job_post(c_view, apl_class, date_format) {
    max_days = "";
    if ($("#job_expiry_limit").length > 0) {
        var exp_val = $("#job_expiry_limit").val();
        var max_days = addDays(new Date, parseInt(exp_val));
        $('.' + apl_class).on('keydown', function (event) {
            event.preventDefault();
        });
    }
    $('.' + apl_class).datepicker({
        view: c_view,
        minView: c_view,
        dateFormat: date_format,
        minDate: new Date(),
        maxDate: max_days,
        language: {
            days: [get_strings.Sunday, get_strings.Monday, get_strings.Tuesday, get_strings.Wednesday, get_strings.Thursday, get_strings.Friday, get_strings.Saturday],
            daysShort: [get_strings.Sun, get_strings.Mon, get_strings.Tue, get_strings.Wed, get_strings.Thu, get_strings.Fri, get_strings.Sat],
            daysMin: [get_strings.Su, get_strings.Mo, get_strings.Tu, get_strings.We, get_strings.Th, get_strings.Fr, get_strings.Sa],
            months: [get_strings.January, get_strings.February, get_strings.March, get_strings.April, get_strings.May, get_strings.June, get_strings.July, get_strings.August, get_strings.September, get_strings.October, get_strings.November, get_strings.December],
            monthsShort: [get_strings.Jan, get_strings.Feb, get_strings.Mar, get_strings.Apr, get_strings.May, get_strings.Jun, get_strings.Jul, get_strings.Aug, get_strings.Sep, get_strings.Oct, get_strings.Nov, get_strings.Dec],
            today: get_strings.Today,
            clear: get_strings.Clear,
            timeFormat: 'hh:ii aa',
            firstDay: 0
        },
    });
}
var $ = jQuery.noConflict();
jQuery(document).ready(function () {
    "use strict";
    $('.tool-tip').tipsy({
        arrowWidth: 10,
        attr: 'data-tipsy',
        cls: null,
        duration: 150,
        offset: 7,
        position: 'top-center',
        trigger: 'hover',
    });
});
jQuery(document).ready(function () {
    "use strict";
    jQuery(".rich_textarea").on("paste", function (e) {
        e.preventDefault();
        var text = e.originalEvent.clipboardData.getData('text');
        // insert copied data @ the cursor location
        document.execCommand("insertText", false, text);
    });
});
$(window).on('load', function () {
//*MASONRY */
    $('.mansi').masonry();
    if ($('.rich_textarea').length > 0) {
        $('.rich_textarea').jqte({
            link: false,
            unlink: false,
            formats: [
                ["p", get_strings.p_text],
                ["h2", "H2"],
                ["h3", "H3"],
                ["h4", "H4"],
            ],
            funit: false,
            fsize: false,
            fsizes: false,
            color: false,
            strike: false,
            source: true,
            sub: false,
            sup: false,
            indent: false,
            outdent: false,
            right: false,
            left: false,
            center: false,
            remove: false,
            rule: false,
            title: false,
            p: true,
        });
    }
});
$(document).ready(function () {
    $(".adv_opt").click(function () {
        $(".res-toggle").toggle();
    });
    $(".select_submit").on('change', function () {
        $(this).closest('form').submit();
    });
    $('#jobs_searh_form').submit(function () {
        $(this).find('select:not(:has(option:selected[value!=""]))').attr('name', '');
    });
});
$(document).ready(function () {
    $(".icons-click").click(function () {
        $(this).find(".n-grid-icon-list0").toggle(600);
    });
});
// ADD TEAM MEMBERS
$(".get_team_members").on("click", function () {
    $('.cp-loader').show();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'form_team_members',
    }).done(function (response) {
        $('.cp-loader').hide();
        $('#member_model_container_members').html(response);
        $('#team_memberModal').show();
    });
    $("body").delegate("#custom_close", "click", function () {
        $('#team_memberModal').hide();
    });
});
/*Submitting Team Members */
$(document).on('submit', '#u_team_members', function (e) {
    e.preventDefault();
    var form_v = $(this).parsley();
    form_v.validate();
    $('#u_team_members').parsley().on('form:validated', function (formInstance) {
        var success = formInstance.isValid();
        if (success) {
            var nokri_ajax_url = $('#nokri_ajax_url').val();
            e.preventDefault();
            var fd = new FormData();
            var form_data = $('#u_team_members').serialize();
            var files_data = $('#u_img');
            $.each($(files_data), function (i, obj) {
                $.each(obj.files, function (j, file) {
                    fd.append('member_image[' + j + ']', file);
                });
            });
            fd.append('action', 'nokri_add_team_members_fun');
            fd.append('form_data', form_data);
            $.ajax({
                url: nokri_ajax_url,
                type: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                dataType: 'json',
                processData: false,
                //nonce: get_strings.nonce,
                beforeSend: function () {
                    $("#add_member_btn").prop('disabled', true); // disable button
                },
                success: function (response) {
                    if (response.success == true) {
                        $("#add_member_btn").prop('disabled', false);
                        //$(".team-member-grids").append(response.data);
                        toastr.success('Member Added Successfully');
                        window.location.reload(true);
                    } else {
                        toastr.success('Member Added Successfully');
                        window.location.reload(true);
                    }
                }
            });
        } else {
            e.preventDefault();
            return false;
        }
    });
});
// Edit TEAM MEMBERS
$(".edit_team_member").on("click", function () {
    $('.cp-loader').show();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    var memeber_id = $(this).data('memeber_id');
    $.post(nokri_ajax_url, {
        action: 'nokri_edit_team_form',
        memeber_id: memeber_id,
    }).done(function (response) {
        $('.cp-loader').hide();
        $('#edit_model_container_members').html(response);
        $('#edit_team_memberModal').show();
    });
    $("body").delegate("#custom_close", "click", function () {
        $('#edit_team_memberModal').hide();
    });
});
/*Update Members details*/
$(document).on('click', '#update_member_btn', function (e) {
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    var member_id = $(this).data('member_id');
    e.preventDefault();
    var fd = new FormData();
    var form_data = $('#edit_team_members').serialize();
    var files_data = $('#u_img');
    $.each($(files_data), function (i, obj) {
        $.each(obj.files, function (j, file) {
            fd.append('member_image[' + j + ']', file);
        });
    });
    fd.append('action', 'nokri_update_team_members_func');
    fd.append('form_data', form_data);
    fd.append('member_id', member_id);
    $.ajax({
        url: nokri_ajax_url,
        type: 'POST',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        title: get_strings.success,
        content: get_strings.action_success,
        beforeSend: function () {
            $("#update_member_btn").prop('disabled', true); // disable button
        },
        success: function (response) {
            if (response.success == true) {
                $("#update_member_btn").prop('disabled', false);
                //$(".team-member-grids").append(response.data);
                toastr.success('Member updated Successfully');
                window.location.reload(true);
            } else {
                toastr.success('Member updated Successfully');
                window.location.reload(true);
            }
        }
    });
});
/*Delete Member Details*/
$(document).on('click', '.delete_member_btn', function (e) {
    var confirmation = confirm("Do you really want to remove the Team Member from List ?");
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    var member_id = $(this).data('memeber-delete-id');
    e.preventDefault();
    if (confirmation == true) {
        $.post(nokri_ajax_url, {
            'action': 'nokri_delete_team_members_func',
            'member_id': member_id,
        }).done(function (response) {
            $(".delete_member_btn").prop('disabled', true);
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == 1) {
                toastr.success($.trim(get_r[1]));
                $("." + member_id).remove();
                window.location.reload(true);
            } else {
                toastr.warning($.trim(get_r[1]));
            }
        });
    }
});
/*ZOOM Meetings authorization*/
$(document).on('submit', '.nokri_zoom_auth', function (e) {
    e.preventDefault();
    var _this = jQuery(this);
    var this_form = _this;
    $('.cp-loader').show();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'nokri_zoom_auth_user',
        form_data: $("form.nokri_zoom_auth").serialize(),
        nonce: get_strings.nonce,
    }).done(function (response) {
        this_form.append(response.html);
    });
});
/*Create Meeting form*/
$(".nokri_zoom_meeting").on("click", function (e) {
    e.preventDefault();
    $('.cp-loader').show();
    var candID = $(this).attr("data-applierid");
    var candJobID = $(this).attr("data-jobid");
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'nokri_load_zoom_meeting_form',
        candID: candID,
        candJobID: candJobID,
    }).done(function (response) {
        $('.cp-loader').hide();
        if ($.trim(response) == '2') {
            toastr.error($('#not_log_in').val(), '', {
                timeOut: 2500,
                "closeButton": true,
                "positionClass": "toast-top-right"
            });
        } else {
            $("#zoom_meeting_container").html(response);
            $('.zoom-meeting-popup').show();
            $('.cp-loader').hide();
        }
        $("body").delegate("#custom_close", "click", function () {
            $('.zoom-meeting-popup').hide();
        });
    });
});
/*Creating a Meeting Function*/
$(document).on('submit', '.zoom-metting-form', function (e) {
    e.preventDefault();
    $('.cp-loader').show();
    var meetID = $(this).find("input[name=current_meeting_id]").val();
    var candID = $(this).find("input[name=current_author]").val();
    var candJobID = $(this).find("input[name=current_job]").val();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'nokri_setup_zoon_meeting',
        candID: candID,
        meetID: meetID,
        candJobID: candJobID,
        form_data: $(this).serialize(),
        nonce: get_strings.nonce,
        beforeSend: function () {
            $(this).find(".zoom-metting-form-btn").prop('disabled', true); // disable button
        }
    }).done(function (response) {
        $('.cp-loader').hide();
        $("#zoom_meeting_container").html(response);
        $(this).show();
        var data = typeof response.data !== 'undefined' ? response.data : '';
        if (response.success == true) {
            if (data != '') {
                toastr.success(data.msg, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        } else {
            if (data != '') {
                toastr.error(data.msg, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
        }
        $('.cp-loader').hide();
        $('.zoom-meeting-popup').modal('hide');
        $("body").delegate("#custom_close", "click", function () {
            $('.zoom-meeting-popup').hide();
        });
    });
});
//Edit Zoom Meetinig
$(".nokri_zoom_edit_meeting").on("click", function () {
    $('.cp-loader').show();
    alert('Befroe updating a meeting Get Authorized 1st');
    var candID = $(this).attr('data-applierId');
    var candJobID = $(this).attr('data-jobid');
    var meetID = $(this).attr('data-meetid');
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'nokri_load_zoom_meeting_form',
        candID: candID,
        candJobID: candJobID,
        meetID: meetID,
        beforeSend: function () {
            $(this).find("#btn_update_meeting").prop('disabled', true); // disable button
        },
    }).done(function (response) {
        $('.cp-loader').hide();
        $("#zoom_edit_meeting_container").html(response);
        $('.zoom-meeting-popup').modal('show');
        var data = typeof response.data !== 'undefined' ? response.data : '';
        if (response.success == true) {
            if (data != '') {
                toastr.success(data.msg, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
            $('.cp-loader').hide();
        } else {
            if (data != '') {
                toastr.error(data.msg, '', {
                    timeOut: 2500,
                    "closeButton": true,
                    "positionClass": "toast-top-right"
                });
            }
            $('.cp-loader').hide();

        }
        $("#btn_update_meeting").prop('disabled', false);
        $('.cp-loader').hide();

        $("body").delegate("#custom_close", "click", function () {
            $('.zoom-meeting-popup').hide();
        });
    });
});
/* Delete Meeting*/
$(".del_single_meeting").on("click", function (e) {
    var candID = $(this).attr('data-applierId');
    var candJobID = $(this).attr('data-jobid');
    var meetID = $(this).attr('data-meetid');
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    e.preventDefault();
    $.confirm({
        animationBounce: 1.5,
        closeAnimation: 'rotateXR',
        title: get_strings.confirmation,
        content: get_strings.content,
        type: 'red',
        buttons: {
            tryAgain: {
                text: get_strings.btn_cnfrm,
                btnClass: 'btn-red',
                action: function () {
                    $('.cp-loader').show();
                    $.post(nokri_ajax_url, {
                        action: 'nokri_zoom_delete_meet',
                        candID: candID,
                        candJobID: candJobID,
                        meetID: meetID,
                    }).done(function (response) {
                        $('.cp-loader').hide();
                        var data = typeof response.data !== 'undefined' ? response.data : '';
                        if (response.success == true) {
                            if (data != '') {
                                toastr.success(data.msg, '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        } else {
                            if (data != '') {
                                toastr.error(data.msg, '', {
                                    timeOut: 2500,
                                    "closeButton": true,
                                    "positionClass": "toast-top-right"
                                });
                            }
                        }
                        window.location.reload(true);
                    });
                }
            },
            cancel: {
                text: get_strings.btn_cancel, // text for button
                action: function (cancelButton) {
                    $('.cp-loader').hide();
                }
            },
        }
    });
});
/*Hide Location while remotley job selected*/
$(".remote_work").change(function () {
    if ($('.remote_work').is(":checked")) {

        $('.n_jobs_location').hide();
    } else {
        $(".n_jobs_location").show();
    }
});
/*Add Account Members Form*/
$(".add_account_members").on("click", function () {
    $('.cp-loader').show();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    $.post(nokri_ajax_url, {
        action: 'nokri_account_members_from',
        beforeSend: function () {
            $(".add_account_members").prop('disabled', true); // disable button
        }
    }).done(function (response) {
        $('.cp-loader').hide();
        $('#member_model_container_members').html(response);
        $('#account_member_modal_form').show();
        $(".add_account_members").prop('disabled', false); // Enable button
    });
    $("body").delegate("#close_account_member_btn", "click", function () {
        $('#account_member_modal_form').hide();
        $(".add_account_members").prop('disabled', false); // Enable button
    });
});
/*Submitting Members Data*/
$(document).on('submit', '#ad_account_members_form', function (e) {

    e.preventDefault();
    $('.cp-loader').show();
    var form_v = $(this).parsley();
    if (!form_v.validate()) {
        return '';
    } else {
        var empID = $('#ad_account_members_form').find("input[name=employer_id]").val();
        var nokri_ajax_url = $('#nokri_ajax_url').val();
        var success = true;
        if (success) {
            $.post(nokri_ajax_url, {
                action: 'nokri_account_member_permissions',
                type: 'POST',
                empID: empID,
                form_data: $("#ad_account_members_form").serialize(),
                nonce: get_strings.nonce,
                beforeSend: function () {
                    $("#add_account_member_btn").prop('disabled', true); // disable button
                }
            }).done(function (response) {

                $('.cp-loader').hide();
                $(".add_account_member_btn").prop('disabled', false);
                $('#member_model_container_members').html(response);
                $('#ad_account_members_form').show();
                var get_r = response.split('|');
                if ($.trim(get_r[0]) == 1) {
                    toastr.success($.trim(get_r[1]));
                    window.location.reload(true);
                } else {
                    toastr.error($.trim(get_r[1]));
                }
                $("body").delegate("#close_account_member_btn", "click", function () {
                    $('#ad_account_members_form').hide();
                });
            });
        } else {
            e.preventDefault();
            return false;
        }
    }
    e.preventDefault();
});
/*Edit Account MEMBERS*/
$(".edit_acc_member").on("click", function () {
    $('.cp-loader').show();
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    var member_id = $(this).data('member_id');
    $.post(nokri_ajax_url, {
        action: 'nokri_edit_acc_members',
        member_id: member_id,
    }).done(function (response) {

        $('.cp-loader').hide();
        $('#member_model_container_members').html(response);
        $('#acc_memberModal').show();
        $("body").delegate("#close_account_member_form", "click", function () {
            $('#acc_memberModal').hide();
        });

    });
});
/*Delete Account Member Details*/
$(document).on('click', '.delete_acc_member', function (e) {
    var confirmation = confirm("Do you really want to remove Account Member from List ?");
    var nokri_ajax_url = $('#nokri_ajax_url').val();
    var member_id = $(this).data('memeber-delete-id');
    e.preventDefault();
    if (confirmation == true) {
        $.post(nokri_ajax_url, {
            'action': 'nokri_delete_account_member',
            'member_id': member_id,
        }).done(function (response) {
            $(".delete_acc_member").prop('disabled', true);
            var get_r = response.split('|');
            if ($.trim(get_r[0]) == 1) {
                toastr.success($.trim(get_r[1]));
                $("." + member_id).remove();
                window.location.reload(true);
            } else {
                toastr.error($.trim(get_r[1]));
            }
        });
    }
});
/*Update account Members details*/
$(document).on('submit', '#acc_memberModal_form', function (e) {
    e.preventDefault();
    $('.cp-loader').show();
    var form_v = $(this).parsley();

    if (!form_v.validate()) {
        return '';
    } else {
        var success = true;
        //var member_id = $(this).data('memeber-update-id');
        var member_id = $('#acc_memberModal_form').find("input[name=member_id]").val();
        var nokri_ajax_url = $('#nokri_ajax_url').val();
        if (success) {
            $.post(nokri_ajax_url, {
                action: 'nokri_update_account_member',
                type: 'POST',
                member_id: member_id,
                form_data: $("#acc_memberModal_form").serialize(),
                nonce: get_strings.nonce,
                beforeSend: function () {
                    $("#update_account_member_btn").prop('disabled', true); // disable button
                }
            }).done(function (response) {

                $('.cp-loader').hide();
                $('#member_model_container_members').html(response);
                $('#ad_account_members_form').show();

                var get_r = response.split('|');
                if ($.trim(get_r[0]) == 1) {
                    toastr.success($.trim(get_r[1]));
                    window.location.reload(true);
                } else {
                    toastr.error($.trim(get_r[1]));
                }
                $("body").delegate("#close_account_member_form", "click", function () {
                    $('#ad_account_members_form').hide();
                });
            });
        } else {
            e.preventDefault();
            return false;
        }
    }
});
/*Firebase Phone Number Authentication*/
(function ($) {
    $(".codee_field").hide();
    if ($('#sb-verify-phone-firebase').length > 0) {

        projectID = $('#sb-fb-projectid').val();
        appID = $('#sb-fb-appid').val();
        senderID = $('#sb-fb-senderid').val();
        apiKey = $('#sb-fb-apikey').val();

        var firebaseConfig = {
            apiKey: apiKey,
            projectId: projectID,
            messagingSenderId: senderID,
            appId: appID
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();

        var loginphone = $('#sb-verify-phone-firebase');
        if (loginphone.length > 0) {

            loginphone.on('click', function () {

                var otpNum = $("#user-otp-num").val();

                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-recaptcha', {
                    'size': 'normal',
                    'callback': function (response) {
                        // reCAPTCHA solved, allow signInWithPhoneNumber.
                    },
                    'expired-callback': function () {
                        // Response expired. Ask user to solve reCAPTCHA again
                    }
                });
                var cverify = window.recaptchaVerifier;
                //phone number authentication function of firebase
                //it takes two parameter first one is number,,,second one is recaptcha
                firebase.auth().signInWithPhoneNumber(otpNum, cverify).then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    var notice = $('#verification-notice').val() + " " + otpNum;

                    $(".numberr_field").hide();
                    $(".codee_field").show();
                    toastr.success(notice, '', {
                        timeOut: 3000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });

                }).catch(function (error) {
                    toastr.error(error['code'], error['message'], {timeOut: 2000, "closeButton": true, "positionClass": "toast-top-right"});
                });
            });
            /*  verifying otp  */
            $('#sb_verify_otp').on('click', function () {
                var otp = $('#sb_ph_number_code').val();
                var confirmation = $('#verification-confirmation').val() + " " + otp;
                confirmationResult.confirm(otp).then(function (result) {
                    toastr.success(confirmation, '', {
                        timeOut: 3000,
                        "closeButton": true,
                        "positionClass": "toast-top-right"
                    });
                    var userobj = result.user;
                    var phoneNum = userobj.phoneNumber;
                    var nokri_ajax_url = $('#nokri_ajax_url').val();
                    if (result) {
                        $.post(nokri_ajax_url, {
                            action: 'nokri_firebase_num_verify',
                            type: 'POST',
                            phoneNum: phoneNum,
                            nonce: get_strings.nonce,
                            beforeSend: function () {
                                $("#sb_verify_otp").prop('disabled', true); // disable button
                            }
                        }).done(function (response) {

                            window.location.reload();
                        });
                    }
                }).catch(function (error) {
                    toastr.error(error['code'], error['message'], {timeOut: 3000, "closeButton": true, "positionClass": "toast-top-right"});
                    window.location.reload();
                });

            });
        }
    }
    //counter for Employer Dashboard Statistics 
    (function ($) {
        $.fn.countTo = function (options) {
            options = options || {};

            return $(this).each(function () {
                // set options for current element
                var settings = $.extend({}, $.fn.countTo.defaults, {
                    from: $(this).data('from'),
                    to: $(this).data('to'),
                    speed: $(this).data('speed'),
                    refreshInterval: $(this).data('refresh-interval'),
                    decimals: $(this).data('decimals')
                }, options);

                // how many times to update the value, and how much to increment the value on each update
                var loops = Math.ceil(settings.speed / settings.refreshInterval),
                        increment = (settings.to - settings.from) / loops;

                // references & variables that will change with each update
                var self = this,
                        $self = $(this),
                        loopCount = 0,
                        value = settings.from,
                        data = $self.data('countTo') || {};

                $self.data('countTo', data);

                // if an existing interval can be found, clear it first
                if (data.interval) {
                    clearInterval(data.interval);
                }
                data.interval = setInterval(updateTimer, settings.refreshInterval);

                // initialize the element with the starting value
                render(value);

                function updateTimer() {
                    value += increment;
                    loopCount++;

                    render(value);

                    if (typeof (settings.onUpdate) == 'function') {
                        settings.onUpdate.call(self, value);
                    }

                    if (loopCount >= loops) {
                        // remove the interval
                        $self.removeData('countTo');
                        clearInterval(data.interval);
                        value = settings.to;

                        if (typeof (settings.onComplete) == 'function') {
                            settings.onComplete.call(self, value);
                        }
                    }
                }

                function render(value) {
                    var formattedValue = settings.formatter.call(self, value, settings);
                    $self.html(formattedValue);
                }
            });
        };
        $.fn.countTo.defaults = {
            from: 0, // the number the element should start at
            to: 0, // the number the element should end at
            speed: 1000, // how long it should take to count between the target numbers
            refreshInterval: 100, // how often the element should be updated
            decimals: 0, // the number of decimal places to show
            formatter: formatter, // handler for formatting the value before rendering
            onUpdate: null, // callback method for every time the element is updated
            onComplete: null       // callback method for when the element finishes updating
        };

        function formatter(value, settings) {
            return value.toFixed(settings.decimals);
        }
    }(jQuery));

    jQuery(function ($) {
        // custom formatting example
        $('.count-number').data('countToOptions', {
            formatter: function (value, options) {
                return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            }
        });

        // start all the timers
        $('.timer').each(count);

        function count(options) {
            var $this = $(this);
            options = $.extend({}, options || {}, $this.data('countToOptions') || {});
            $this.countTo(options);
        }
    });


}(jQuery));