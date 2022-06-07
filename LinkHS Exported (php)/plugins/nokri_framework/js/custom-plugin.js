(function($) {
	"use strict";
var is_job_post = $('#is_job_post').val();


//Package for
if($( "#is_pkg_base" ).val() == '1')
{
	var pkg_for = $( "#op_pkg_for" ).val();
	if(pkg_for == 1)
	{
		$('#job_class_package').show();
		$('#candidate_package').hide();
	}
	else if(pkg_for == 0)
	{
		$('#candidate_package').show();
		$('#job_class_package').hide();
	}
        else if(pkg_for == 3)
	{
		$('#candidate_package').hide();
		$('#job_class_package').hide();
	}
        else{
            $('#candidate_package').show();
            $('#job_class_package').hide();
        }

	$('#op_pkg_for').change(function() {
	var op_pkg_for = $(this).val();
	if(op_pkg_for == '1')
	{
		$('#candidate_package').hide();
		$('#job_class_package').show();
	}
	else if (op_pkg_for == '0')
	{
		$('#job_class_package').hide();
		$('#candidate_package').show();
	}
        else if((op_pkg_for == '3')){
            
            $('#job_class_package').hide();
            $('#candidate_package').hide();
            
        }
	});
}
//Job apply with external link
$('#ad_external').change(function() {
var link_val = $(this).val();
if(link_val == 'exter')
{
	$('#job_external_link_feild').show();
	$('#job_external_mail_feild').hide();
          $('#job_external_whatsapp_feild').hide();
	$('#job_external_url').prop('required',true);
}
else if (link_val == 'mail')
{
  $('#job_external_url').removeAttr('required');
  $('#job_external_link_feild').hide();
   $('#job_external_whatsapp_feild').hide();
  $('#job_external_mail_feild').show();
}
else if (link_val == 'whatsapp')
{
  $('#job_external_url').removeAttr('required');
  $('#job_external_link_feild').hide();
  $('#job_external_mail_feild').hide();
  $('#job_external_whatsapp_feild').show();
}
else
{
	$('#job_external_mail_feild').hide();
	$('#job_external_link_feild').hide();
          $('#job_external_whatsapp_feild').hide();
}
});


if($(".datepickerhere").length > 0)

{
	$('.datepickerhere').datepicker({
		format: 'mm/dd/yyyy',
		language: 'en',
                minDate: new Date(),
	});       
      
}
var lat = $('#ad_map_lat').val();
var lon = $('#ad_map_long').val();
var map_type =$('#check_map').val();
/* Leaflet Map */
if (map_type == 'leafletjs_map' && $("#dvMap").length > 0)
{
var mymap = L.map('dvMap').setView([lat, lon], 13);
	L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png', {
		maxZoom: 18,
	}).addTo(mymap);
	var markerz = L.marker([lat, lon],{draggable: true}).addTo(mymap);
	var searchControl 	=	new L.Control.Search({
		url: '//nominatim.openstreetmap.org/search?format=json&q={s}',
		jsonpParam: 'json_callback',
		propertyName: 'display_name',
		propertyLoc: ['lat','lon'],
		marker: markerz,
		autoCollapse: true,
		autoType: true,
		minLength: 2,
	});
	searchControl.on('search:locationfound', function(obj) {
		var lt	=	obj.latlng + '';
		var res = lt.split( "LatLng(" );
		res = res[1].split( ")" );
		res = res[0].split( "," );
		document.getElementById('ad_map_lat').value = res[0];
		document.getElementById('ad_map_long').value = res[1];
	});
	mymap.addControl( searchControl );
	markerz.on('dragend', function (e) {
	  document.getElementById('ad_map_lat').value = markerz.getLatLng().lat;
	  document.getElementById('ad_map_long').value = markerz.getLatLng().lng;
	});
	
	
}

	
/* Google Map */	
if (map_type == 'google_map')
{	
	var map = "";
	var latlng = new google.maps.LatLng(lat, lon);
	var myOptions = {
		zoom: 13,
		center: latlng,
		scrollwheel: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		size: new google.maps.Size(480, 240)
	}
        
      if ($('#dvMap').length > 0){
	map = new google.maps.Map(document.getElementById("dvMap"), myOptions);
	var marker = new google.maps.Marker({
		map: map,
		position: latlng
	});
}}

if (map_type == 'google_map')
{
	var latoz = $('#ad_map_lat').val();
		var longoz = $('#ad_map_long').val();
		var markers = [{
			"title": "",
			"lat": latoz,
			"lng": longoz,
		}, ];
		window.onload = function () {
                       if ($('#dvMap').length > 0){
			my_g_map(markers);}
		};
}
function my_g_map(markers1) {
	
	var my_map;
			var marker;
			var markers = [
				{
					"title": "",
					"lat": "37.090240",
					"lng": "-95.712891",
				},
			];
	
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
			//document.getElementById("sb_loading").style.display	= "block";
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
				}

			});
		});
	})(marker, data);
	latlngbounds.extend(marker.position);
	jQuery(document).ready(function($) {
			$("#your_current_location").click(function() {
                          
				$.ajax({
				url: "https://geoip-db.com/jsonp",
				jsonpCallback: "callback",
				dataType: "jsonp",
				success: function( location ) {
					var pos = new google.maps.LatLng(location.latitude, location.longitude);
					my_map.setCenter(pos);
					my_map.setZoom(12);
					
					$("#sb_user_address").val(location.city + ", " + location.state + ", " + location.country_name );
					document.getElementById("ad_map_long").value = location.longitude;
					document.getElementById("ad_map_lat").value = location.latitude;
					
				var markers2 = [
				{
					title: "",
					lat: location.latitude,
					lng: location.longitude,
				},
			];
			my_g_map(markers2);
				}
			});		
			});
			
				});
}
$('#sb_change_author').on("change",function(){
 var userId  =  $(this).val();
 var authorId  =  $("#post_author_override").val(); 
 if(userId == -1){
  $.post(ajaxurl, {
       action: 'get_job_authors',
       author_id: authorId,
   
      }).done(function(response) {
     
    $('#sb_change_author').html(response);
         
});}
 
});

if($('#sb_change_author').length > 0){

$('#sb_change_author').select2();
}


//date picker for jobs export fields



if($('.jobs_dp').length > 0){
    
   
   $('.jobs_dp').datepicker({
		format: 'mm/dd/yyyy',
		language: 'en',
	});             
}




//bulk editor for job expiry
jQuery(function($){
	$( 'body' ).on( 'click', 'input[name="bulk_edit"]', function() {		
		
            $( this ).after('<span class="spinner is-active"></span>');
 	
		var bulk_edit_row = $( 'tr#bulk-edit' );
		   var  post_ids = new Array();
		   var job_exp = bulk_edit_row.find( 'input[name="job_date"]' ).val();
		  
		
		bulk_edit_row.find( '#bulk-titles' ).children().each( function() {
			post_ids.push( $( this ).attr( 'id' ).replace( /^(ttle)/i, '' ) );
		});
 
		if(job_exp != ""){
		$.ajax({
			url: ajaxurl, 
			type: 'POST',
			data: {
				action: 'bulk_edit_job_expiry', 
				post_ids: post_ids,
                                job_exp : job_exp,
			}
		});
            }
	});
});



//admin download resume
    /* Admin download Resumes against job */
    $(".download_admin_resumes").on("click", function (e) {
        e.preventDefault();
        $('.cp-loader').show();
        var download_job_id = $(this).attr('data-job-id');
        var attachment_id = $(this).attr('data-attachid');

        $.post(ajaxurl, {
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
               
               window.location.href = response;
            }
        });
    });

})( jQuery );