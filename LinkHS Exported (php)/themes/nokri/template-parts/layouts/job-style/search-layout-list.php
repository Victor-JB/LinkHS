<?php 
global $nokri; 
//$layout = $nokri['search_layout'];
$layout = 'list_1';
$out	=	'';
while ( $results->have_posts() )
{
	$results->the_post();
	$pid	=	get_the_ID();
	$jobs	=	 new jobs();
	$option	=	$layout;
	$function	=	"nokri_search_layout_$option";
	$out	.= $jobs->$function( $pid );
}