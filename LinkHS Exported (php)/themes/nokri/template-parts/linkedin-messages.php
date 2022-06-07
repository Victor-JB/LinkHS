<?php
/* Redirect Page */
global $nokri;
 $dashboard_page = '';
 if((isset($nokri['sb_dashboard_page'])) && $nokri['sb_dashboard_page']  != '' )
{
	$dashboard_page =  ($nokri['sb_dashboard_page']);
}
/* Job id */
if(isset($_GET['state']) && $_GET['state'] != '' )
{
	$state_arr	= explode( '-', $_GET['state'] );
	$job_id	=	$state_arr[1];
}
/* Email permission */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 1 )
{
    nokri_jspopup(__('Email permission is not enabled.','nokri'), 'error');
	unset( $GLOBALS['action_type']);
}
/* Register and login */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 2 )
{
	nokri_jspopup(__("You are registered and logged in successfully.",'nokri'), 'success');
	unset( $GLOBALS['action_type']);
	nokri_js_redirect(get_the_permalink( $dashboard_page ));
}
/* Login */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 3 )
{
	nokri_jspopup(__("You are logged in successfully.",'nokri'), 'success'); 
	unset( $GLOBALS['action_type']);
	nokri_js_redirect(get_the_permalink( $dashboard_page ));
}
/* logedin and apply */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 4 )
{
	//nokri_jspopup(__("You have applied successfully.",'nokri'), 'success');
	nokri_js_redirect(get_the_permalink( $job_id ). "?src=lkn");
	unset( $GLOBALS['action_type']);
}
/* logedin and already apply */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 5 )
{
	nokri_jspopup(__("Already applied for this job.",'nokri'), 'error');
	nokri_js_redirect(get_the_permalink( $job_id ));	
	unset( $GLOBALS['action_type']);
}
/* not logedin and apply */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 6 )
{
	//nokri_jspopup(__("You have applied successfully.",'nokri'), 'success');
	nokri_js_redirect(get_the_permalink( $job_id ) . "?src=lkn");
	unset( $GLOBALS['action_type']);
}
/* not logedin and already apply */
if( isset( $GLOBALS['action_type'] ) && $GLOBALS['action_type'] == 7 )
{
	nokri_jspopup(__("Already applied for this job.",'nokri'), 'error');
	nokri_js_redirect(get_the_permalink( $job_id ));	
	unset( $GLOBALS['action_type']);
}



