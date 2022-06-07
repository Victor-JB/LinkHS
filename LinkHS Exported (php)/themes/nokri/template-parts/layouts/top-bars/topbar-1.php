<?php global $nokri; ?>
<div class="top-bar">
 <div class="container">
    <div class="row">
        <?php if((isset($nokri['social_switch'])) && $nokri['social_switch']  == 1 ) { ?>
       <div class="col-lg-7 col-md-5 col-sm-5 col-xs-12">
              <?php echo nokri_top_bar_social_sorter(); ?>
       </div>
       <?php } if((isset($nokri['contact_switch'])) && $nokri['contact_switch']  == 1 ) { ?>
       <div class="col-lg-5 col-md-7 col-sm-7 col-xs-12">
          <div class="header-info">
            <?php echo nokri_top_bar_sorter(); ?>
          </div>
       </div>
       <?php } ?>
    </div>
 </div>
</div> 