<?php 

/* Hooks the metabox. */
add_action('admin_init', 'dmb_rpts_add_pro', 1);
function dmb_rpts_add_pro() {
	add_meta_box( 
		'rpt_pricing_table_pro', 
		'Upgrade to PRO',
		'dmb_rpts_pro_display', // Below
		'rpt_pricing_table', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_rpts_pro_display() { ?>

	<div class="dmb_side_block">
  <div class="dmb_side_block_title">
			<span class="dashicons dashicons-yes" style="color:#81c240;"></span> <strong>Price toggle <span style="font-size: 9px; font-weight: 600; color: #0073AA; position: relative; top: -4px;">[NEW]</span></strong> : Display variable prices (monthly/yearly).
		</div>
		<div class="dmb_side_block_title">
			<span class="dashicons dashicons-yes" style="color:#81c240;"></span> <strong>Skins/designs</strong>: Choose from different visual layouts.
		</div>
		<div class="dmb_side_block_title">
			<span class="dashicons dashicons-yes" style="color:#81c240;"></span> <strong>Equalizer</strong>: Make the length of your pricing plans the same. 
		</div>
		<div class="dmb_side_block_title">
			<span class="dashicons dashicons-yes" style="color:#81c240;"></span> Add <strong>tooltips</strong> to your pricing plans' features (info bubbles).
		</div>
	</div>

	<a class="dmb_button dmb_button_huge dmb_button_green dmb_see_pro" target="_blank" href="https://wpdarko.com/items/responsive-pricing-table-pro">
		See all the new features
	</a>

	<div class="dmb_discount_box_pushr"></div>
	<div class="dmb_side_block dmb_discount_box">
		<div class="dmb_side_block_title">
			Discount code
		</div>
		<span style="font-size:14px; color:#75b03a;"><strong>7832949</strong> (10% OFF)</span>
	</div>

<?php } ?>