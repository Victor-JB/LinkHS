<?php 
global $nokri; 
$layout = 'list_2';
$out	=	'';
while ( $results_premium->have_posts() )
{
	$results_premium->the_post();
	 $pid		=		get_the_ID();
	$jobs		=	 	new jobs();
	$option		=		$layout;
	$function	=		"nokri_search_layout_$option";
	$out	   .= 		$jobs->$function( $pid );
}