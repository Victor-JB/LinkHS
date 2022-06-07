<?php global $nokri; ?>
<section class="n-top-bar2">   
  <div class="container-fluid">
  	<div class="row">
    <?php if((isset($nokri['contact_switch'])) && $nokri['contact_switch']  == 1 ) { ?>
  		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-7">
  			<div class="n-top-detail">
  				<ul>
  					<?php echo nokri_top_bar_sorter('ul'); ?>
  				</ul>
  			</div>
  		</div>
        <?php } if((isset($nokri['header_top_bar_links_switch'])) && $nokri['header_top_bar_links_switch']  == 1 ) {  ?>
  		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-5">
  			<div class="n-jobs-details">
  				<ul>
  					<?php echo nokri_topbar_hot_links(); ?>
  			    </ul>									
  			</div>
  		</div>
        <?php } ?>
  	</div>
  </div>
</section>