<?php 
global $nokri;
$user_id  =  get_current_user_id();
$c_order  =	 'all';
if( isset($_GET['c_order']) )
{
	if( isset($_GET['c_order']) && $_GET['c_order'] != "" )
	{
		 $c_order = array('wc-'.$_GET['c_order']);
	}
}
?>
<div class="main-body">
<div class="dashboard-job-stats dashboard-email-templates">
<div class="dashboard-job-filters">
    <div class="row">
    	<div class="col-md-6 col-xs-12 col-sm-6">
            <h4><?php echo esc_html__('Orders history', 'nokri' ); ?></h4>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <form method="GET" id="order_form">
                     <input type="hidden" name="candidate-page" value="my-orders" >
                        <select class="js-example-basic-single form-control order_form" name="c_order">
                            <option value="all" <?php if ( $c_order == 'all') { echo "selected"; } ; ?> ><?php echo esc_html__('All orders', 'nokri' ); ?></option>
                            <option value="completed" <?php if (isset($c_order[0]) && $c_order[0] == 'wc-completed') { echo "selected"; } ; ?>><?php echo  esc_html__( 'Completed', 'nokri' ); ?></option>
                            <option value="processing" <?php if ( isset($c_order[0]) && $c_order[0] == 'wc-processing') { echo "selected"; } ; ?>><?php echo  esc_html__( 'Pending', 'nokri' ); ?></option>
                        </select>
                     </form>
            </div>
        </div>
    </div>
</div>
<div class="dashboard-posted-jobs">
    <div class="posted-job-list header-title">
        <ul class="list-inline">
            <li class="email-template-id"><?php echo esc_html__( '#', 'nokri' ); ?></li>
            <li class="posted-job-title"><?php echo esc_html__( 'Package Name', 'nokri' ); ?></li>
            <li class="posted-job-expiration"><?php echo esc_html__( 'Purchased on', 'nokri' ); ?></li>
            <li class="posted-job-action"><?php echo esc_html__( 'Status', 'nokri' ); ?></li>
        </ul>
    </div>
<?php
if ( class_exists( 'WooCommerce' ) )
{
		/* Wo commerce Order Query */
		$order_html     = '';
		$args = array(
		'numberposts' 	=>  -1,
		'orderby'  		=>  'date',
		'order'    		=>  'DESC',
		'return'   		=>  'ids',
		'meta_key'    	=>  '_customer_user',
		'meta_value'  	=>   get_current_user_id(),
		'status'        =>   $c_order
	) ;
		//$args = array_push($args, $c_order);
	$query          = 	new WC_Order_Query( $args );
	$orders 		= 	$query->get_orders();
	
	
	
	
	if ($orders)
{
foreach( $orders as $ord)
	{
		$order_new = wc_get_order( $ord );
		$data = $order_new->get_data(); 
		$items = $order_new->get_items();
		foreach ( $items as $item ) 
		{
			$product_name = $item->get_name();
		 }
		 $order_status = $data['status'];
		 if($order_status == 'completed')
		 {
			 $class = 'success';
			 $title = esc_html__('Completed','nokri');
			 $type  = 'ti-check-box';
		 }
		 else
		 {
			  $class = 'warning';
			  $title = esc_html__('Pending','nokri');
			  $type  = 'ti-alert';
		 }
echo "".$order_html = '<div class="posted-job-list">
		<ul class="list-inline">
			<li class="email-template-id">'.$data['id'].'</li>  
			<li class="posted-job-title"> 
				<a href="#">'.esc_html($product_name).' </a>
			</li>
			<li class="posted-job-expiration">'.$data['date_created']->date('F j, Y').'</li>
			<li class="posted-job-action"> 
				<ul class="list-inline">
					<li class="tool-tip" title="'.esc_html($title).'"> <a href="javascript:void(0)" class="label label-'.esc_attr($class).'"> <i class="'.esc_attr($type).'"></i></a></li>
					<li class="tool-tip" title="'.esc_html__('View Invoice','nokri').'"><a href="?candidate-page=my-invoice&order_id='.esc_attr( $data['id']).'" class="label label-info"> <i class="ti-files"></i></a></li>
				</ul>
			</li>
		</ul>
	</div>';
	}
?>
   		</div>
	</div>
</div>
<?php } else { ?>
<div class="dashboard-posted-jobs">
    <div class="notification-box">
        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
        <h4><?php echo esc_html__( 'No packages purchased yet', 'nokri' ); ?></h4>
    </div>
</div>
<?php } }