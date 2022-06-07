<?php 
global $nokri;
$rtl_class = '';
if(is_rtl())
 {
 	$rtl_class = "flip";
 }
$user_id = get_current_user_id();
if( isset( $_GET['order_id'] ) )
 {
     $order_id = $_GET['order_id'];
 }
$order_new  =   wc_get_order( $order_id );
$data       =   $order_new->get_data();
if(wc_tax_enabled()){ 
 
    $subtotal = $order_new->get_subtotal();
}
else{
  
    $subtotal =  $data['total']; 
}



$items      =   $order_new->get_items(); 
foreach ( $items as $item ) 
{
	$product_name = $item->get_name();
 }
$adress		=	$data['billing']['address_1'];
$cart_tax    =  $data['cart_tax'];
$comp_name	=	$data['billing']['first_name'];
$order_date =   $data['date_created']->date('F j, Y'); 
$order_total =   $data['total']; 
$order_status =   $data['status'];
if($order_status == 'processing')
{
	$order_status_pend = esc_html__( 'Pending', 'nokri' );
}
else
{
	$order_status_pend = $order_status;
}
/* Logo */
$logo  =  get_template_directory_uri() . '/images/logo.png'; 
$logo = '';
if( isset( $nokri['header_logo']['url'] )  && $nokri['header_logo']['url'] != "")
{
	$logo = ( $nokri['header_logo']['url'] );
}
/*site owner address */
$address_invoice = isset($nokri['user_address_invoice']) ? $nokri['user_address_invoice'] : '';
?>
<div class="main-body">
<div id="printableArea">
<div class="order-invoice">
    <div class="order-invoice-header">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
          <div class="order-invoice-to">
            <h3 class="order-invoice-to-name"><?php echo esc_html__( 'Invoice', 'nokri' ); ?></h3>
            <address class="order-invoice-to-info">
              <?php echo esc_html($adress); ?></li>
            </address>
            
            <p><b><?php echo esc_html__( 'Invoice #', 'nokri' ).esc_html($order_id); ?></b> </p>
            <p class="order-invoice-status"> <b><?php echo esc_html__( 'Status:', 'nokri' ); ?></b> <span class="paid pending"><?php echo " ".esc_html($order_status_pend); ?></span></p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
          <div class="order-invoice-company">
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr__( 'company logo', 'nokri' ); ?>" class="img-responsive">
            <address class="order-invoice-to-info">
             <?php echo " ".esc_html($address_invoice); ?></li>
            </address>
            <p> <b><?php echo esc_html__( 'Date:', 'nokri' ); ?></b><?php echo " ".esc_html($order_date); ?></p>
          </div>
        </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="table-responsive">
            <table class="table order-invoice-items">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?php echo esc_html__( 'Package Name', 'nokri' ); ?></th>
                  <th><?php echo esc_html__( 'Amount', 'nokri' ); ?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td><?php echo esc_html($product_name); ?></td>
                  <td><?php echo wc_price($subtotal); ?></td>
                </tr>
                <?php if(wc_tax_enabled()){ ?> 
                <tr>
                  <td></td>
                  <td><?php echo esc_html__('VAT','nokri'); ?></td>                 
                  <td><?php echo wc_price($cart_tax); ?>                
                </tr>
                <?php } ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>

    <div class="order-invoice-footer">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-push-6  col-sm-push-6">
                <div class="order-invoice-footer-total">
                    <div class="table-responsive">
                        <table class="table table-responsive">
                          <tr>
                            <td><?php echo esc_html__( 'Total:', 'nokri' ); ?></td>
                            <td><span class="order-invoice-footer-total-amount"><?php echo  wc_price($order_total); ?></span></td>
                          </tr>
                        </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>
  </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <a href="#" class="btn n-btn-flat pull-right <?php echo esc_attr($rtl_class); ?>" onclick="printDiv('printableArea')"><?php echo esc_html__( 'Print', 'nokri' ); ?></a>
  </div>
</div>
<script>
	function printDiv(printableArea) {
     var printContents = document.getElementById(printableArea).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>