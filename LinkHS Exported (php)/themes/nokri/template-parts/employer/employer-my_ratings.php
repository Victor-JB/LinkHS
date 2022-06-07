<?php
	$current_user_id = get_current_user_id();
	
	$current_user = wp_get_current_user();
	$user_meta = '';
	$user_meta = get_user_meta($current_user_id);
?>

<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="row">
    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        	<div class="panel  panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('My Review and Ratings ', 'nokri' ); echo "<span>("; echo nokri_employer_review_count($current_user_id);	?>) </span></h3>
            <p class="panel-subtitle"><?php echo esc_html__('Last logged in ', 'nokri');echo  nokri_get_last_login( $current_user_id ); echo esc_html__(' Ago','nokri'); ?></p>
                </div>
                <div class="panel-body">
                	<div class="row">
                        
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        	<div class="edit-profile-form dealers-review-section on-backend">
                                <div class="row">
                                    	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        
                                        <?php get_template_part( 'template-parts/profiles/all-ratings' ); ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>