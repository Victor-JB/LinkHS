/*
Template Name: Nokri Job Board Theme
Author: ScriptsBundle
Version: 1.3.1
Designed and Development by: ScriptsBundle  */
(function ($) {
	"use strict";      
	var nokri_ajax_url = $('#nokri_ajax_url').val();
	$('#make_id').on('change', function () {
           
		$('.cp-loader').show();
		$('#select_modal').hide();
		$('#select_modals').hide();
		$('#category_search').hide();
		$('#select_forth_div').hide();
		var cat_s_id = $('#make_id').val();
		$('input[name=cat-id]').val(cat_s_id);
		$.post(nokri_ajax_url, {
			action: 'sb_get_sub_cat_search',
			cat_id: cat_s_id,
		}).done(function (response) {
		$('.cp-loader').hide();
			$('#select_modal').show();
			$('#select_modal').html(response);
			$(".questions-category").select2({
				placeholder: get_strings.option_select,
				allowClear: true,
			});
			$('#category_search').show();
		});
	});
	$('#category_search').on("click", function () {
		$(this).closest("form").submit();
	});
	$('.location_search').on("click", function () {
		$(this).closest("form").submit();
	});
	$(document).on('change', '#cats_response', function () {
          
		$('.cp-loader').show();
		$('#select_modals').hide();
		$('#select_forth_div').hide();
		$('#category_search').hide();
		var cat_s_id = $('#cats_response').val();
                
               
		$('input[name=cat-id]').val(cat_s_id);
		$.post(nokri_ajax_url, {
			action: 'sb_get_sub_sub_cat_search',
			cat_id: cat_s_id,
		}).done(function (response) {
		$('.cp-loader').hide();
			$('#select_modals').show();
			$('#select_modals').html(response);
			$(".search-select").select2({
				placeholder: get_strings.option_select,
				allowClear: true,
			});
			$('#category_search').show();
		});
	});
	$(document).on('change', '#select_version', function () {
		$('.cp-loader').show();
		$('#select_forth_div').hide();
		$('#category_search').hide();
		var cat_s_id = $('#select_version').val();
		$('input[name=cat-id]').val(cat_s_id);
		$.post(nokri_ajax_url, {
			action: 'sb_get_sub_sub_sub_cat_search',
			cat_id: cat_s_id,
		}).done(function (response) {
		$('.cp-loader').hide();
			$('#select_forth_div').show();
			$('#select_forth_div').html(response);
			$(".search-select").select2({
				placeholder: get_strings.option_select,
				allowClear: true,
			});
			$('#category_search').show();
		});
	});
	$(document).on('change', '#select_forth', function () {
		var cat_s_id = $('#select_forth').val();
		$('input[name=cat-id]').val(cat_s_id);
	});
	/*iCheck*/
	$(document).ready(function () {
		$('.input-icheck-search').iCheck({
			checkboxClass: 'icheckbox_square',
			radioClass: 'iradio_square',
			increaseArea: '20%' // optional
		});
	});
        $(document).ready(function () {
		$('.input-icheck-search-custom').iCheck({
			checkboxClass: 'icheckbox_square',
			radioClass: 'iradio_square',
			increaseArea: '20%' // optional
		});
	});
        
             
                       
	$('.change_order').on("select2:select", function (e) {
           
		$(this).closest("form").submit();
	});
	/*On click search form submit*/  
        
        
        
                $('.input-icheck-search').on('ifChecked', function (event) {   
		$('.cp-loader').show();
		$(this).closest("form").submit();
	});
	$('.iradio_square').on('ifChecked', function (event) {
          
		$('.cp-loader').show();
		$(this).closest("form").submit();
	});
	$('.change_select').on("select2:select", function (e) {
		$(this).closest("form").submit();
	});
	$('.submit_on_select').on('click', function () {
		$('.cp-loader').show();
		$(this).closest("form").submit();
	});
    $('.show_next').on('click', function () {
		var cur_id = $(this).attr('data-tax-id');
		$('.hide_nexts-' + cur_id).show();
		$(this).hide();
	});
    /* Select Country */
	$(document).on('change', '#countries_id', function () {
		$('.cp-loader').show();
		$('#select_modals_state').hide();
		$('#select_forth_div_city').hide();
		$('#select_modal_countries').hide();
		$('#location_search_btn').hide();
		var countries_s_id = $('#countries_id').val();
		$('input[name=location_id]').val(countries_s_id);
		$.post(nokri_ajax_url, {
			action: 'get_countries_search',
			country_id: countries_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
				$("#location_id").val(countries_s_id);
				$('#select_modal_countries').show();
				$('#select_modal_countries').html(response);
				$(".questions-category").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
				$('#location_search_btn').show();
		});
	});
    /* Select State */
    $(document).on('change', '#state_response', function () {
		$('.cp-loader').show();
		$('#select_forth_div_city').hide();
		$('#location_search_btn').hide();
		var countries_s_id = $('#state_response').val();
		$('input[name=location_id]').val(countries_s_id);
		$.post(nokri_ajax_url, {
			action: 'get_cities_search',
			country_id: countries_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
				$("#location_id").val(countries_s_id);
				$('#select_forth_div_city').show();
				$('#select_forth_div_city').html(response);
				$(".questions-category").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
			$('#location_search_btn').show();
		});
	});
    /* Select City */
	$(document).on('change', '#countries_response', function () {
		$('.cp-loader').show();
		$('#select_forth_div_city').hide();
		$('#location_search_btn').hide();
		var countries_s_id = $('#countries_response').val();
		$('input[name=location_id]').val(countries_s_id);
		$.post(nokri_ajax_url, {
			action: 'get_states_search',
			country_id: countries_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
				$("#location_id").val(countries_s_id);
				$('#select_modals_state').show();
				$('#select_modals_state').html(response);
				$(".questions-category").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
				$('#location_search_btn').show();
		});
	});
	$(document).on('change', '#cities_response', function () {
		var countries_s_id = $('#cities_response').val();
		$('input[name=location_id]').val(countries_s_id);
		$("#location_id").val(countries_s_id);
		//$("#search_form").submit();
	});
	$('.show_records').on('click', function () {
		var show_now = $(this).attr('data-attr-id');
		var hide_now = $(this).attr('data-attr-hide');
		$('.hide_now_' + hide_now).hide();
		$('.' + show_now).show();
	});
	 $(document).on('change', '#alert_sub_cat', function() {
		$('.cp-loader').show();
		$('#get_child_lev1').hide();
		$('#get_child_lev2').hide();
		$('#get_child_lev5').hide();
                $('#job_alerts').attr('disabled','disabled');
                $('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev1',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
            $('#get_child_lev1').show();
			$('#get_child_lev1').html(response);
                         $('#job_alerts').removeAttr('disabled');
                         $('#submit_paid_alerts').removeAttr('disabled');
			$('#job_alerts').show();
			$(".questions-category").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
			$('#get_cat_val').val(cat_s_id);
		});
	});
     $(document).on('change', '#child_lev1', function () {
		$('.cp-loader').show();
		$('#get_child_lev2').hide();
		$('#get_child_lev3').hide();
                 $('#job_alerts').attr('disabled','disabled');
                  $('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev2',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
				$('#get_child_lev2').show();
				$('#get_child_lev2').html(response);
                                  $('#job_alerts').removeAttr('disabled');
                                  $('#submit_paid_alerts').removeAttr('disabled');
				$(".search-select").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
			$('#get_cat_val').val(cat_s_id);
		});
	});
     $(document).on('change', '#child_lev2', function () {
		$('.cp-loader').show();
		$('#get_child_lev5').hide();
                 $('#job_alerts').attr('disabled','disabled');
                 $('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev3',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
            $('#get_child_lev5').show();
            $('#get_child_lev5').html(response);
             $('#job_alerts').removeAttr('disabled');
             $('#submit_paid_alerts').removeAttr('disabled');
            $(".search-select").select2({
            placeholder: get_strings.option_select,
            allowClear: true,
            });
		   $('#get_cat_val').val(cat_s_id);
        });
	});
     $(document).on('change', '#get_child_lev3', function () {
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev4',
			cat_id: cat_s_id,
		}).done(function (response) {
		   $('#get_cat_val').val(response);
        });
	});
        
 /*sub location for alert location*/
  $(document).on('change', '#alert_sub_loc', function() {
		$('.cp-loader').show();
		$('#get_child_loc_lev1').hide();
		$('#get_child_loc_lev2').hide();
		$('#get_child_loc_lev5').hide();
                
                $('#job_alerts').attr('disabled','disabled');
                $('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev1',
			cat_id: cat_s_id,
                        tax   : 'ad_location',
		}).done(function (response) {
			$('.cp-loader').hide();
            $('#get_child_loc_lev1').show();
			$('#get_child_loc_lev1').html(response);
                         $('#job_alerts').removeAttr('disabled');
                          $('#submit_paid_alerts').removeAttr('disabled');
			$('#job_alerts').show();
			$(".questions-category").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
			$('#get_cat_loc').val(cat_s_id);
		});
	});
     $(document).on('change', '#child_lev1_loc', function () {
		$('.cp-loader').show();
		$('#get_child_loc_lev2').hide();
		$('#get_child_loc_lev5').hide();
                 $('#job_alerts').attr('disabled','disabled');
                 $('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev2',
			cat_id: cat_s_id,
                         tax   : 'ad_location',
		}).done(function (response) {
			$('.cp-loader').hide();
				$('#get_child_loc_lev2').show();
				$('#get_child_loc_lev2').html(response);
                                  $('#job_alerts').removeAttr('disabled');
                                  $('#submit_paid_alerts').removeAttr('disabled');
				$(".search-select").select2({
					placeholder: get_strings.option_select,
					allowClear: true,
				});
			$('#get_cat_loc').val(cat_s_id);
		});
	});
     $(document).on('change', '#child_lev2_loc', function () {
		$('.cp-loader').show();
		$('#get_child_loc_lev5').hide();
                 $('#job_alerts').attr('disabled','disabled');
                  $('#submit_paid_alerts').attr('disabled','disabled');

         var cat_s_id = $(this).val();
		$.post(nokri_ajax_url, {
			action: 'get_child_lev3',
			cat_id: cat_s_id,
                         tax   : 'ad_location',
		}).done(function (response) {
                    
                    console.log(response);
			$('.cp-loader').hide();
            $('#get_child_loc_lev5').show();
            $('#get_child_loc_lev5').html(response);
             $('#job_alerts').removeAttr('disabled');
               $('#submit_paid_alerts').removeAttr('disabled');
            $(".search-select").select2({
            placeholder: get_strings.option_select,
            allowClear: true,
            });
		   $('#get_cat_loc').val(cat_s_id);
        });
	});
     $(document).on('change', '#get_child_lev3_loc', function () {
		var cat_s_id = $(this).val();
                 $('#job_alerts').attr('disabled','disabled');
                  $('#submit_paid_alerts').attr('disabled','disabled');
                
		$.post(nokri_ajax_url, {
			action: 'get_child_lev4',
			cat_id: cat_s_id,
		}).done(function (response) {
		   $('#get_cat_loc').val(response);
                     $('#job_alerts').removeAttr('disabled');
                      $('#submit_paid_alerts').removeAttr('disabled');
        });
	});
                           
})(jQuery);