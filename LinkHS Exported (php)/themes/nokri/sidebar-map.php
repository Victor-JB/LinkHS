<?php
global $nokri;


$multi_searach = ( isset($nokri['multi_job_search_form']) && $nokri['multi_job_search_form'] != "" ) ? $nokri['multi_job_search_form'] : false;
 $is_mobile   = wp_is_mobile()  ?   "collapse"  : "collapse in";
if (is_active_sidebar('search_sidebar')) {
    ?>
    <aside class="new-sidebar side-filters">
        <div class="heading">
            <h4> <?php echo esc_html__("Search Filters", "nokri"); ?></h4>
            <a href="<?php echo get_the_permalink($nokri['sb_search_page']); ?>"><?php echo esc_html__("Clear All", "nokri"); ?></a>
                <a role="button" class="" data-toggle="collapse" href="#accordion" aria-expanded="true" id="panel_acordian"></a>
        </div>
        <?php if ($multi_searach) { ?>
            <form method="get" id="all_search_form">
                <div class = "panel-group <?php echo esc_attr($is_mobile) ?>" id = "accordion" role = "tablist" aria-multiselectable = "true">
                    <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
            ?></button>    
                    <?php dynamic_sidebar('search_sidebar'); ?>   
                    <button type = "submit" class = "submit-all-form btn n-btn-flat btn-block" ><?php echo esc_html__('Search', 'nokri')
                    ?></button>    
                </div>
            </form>

        <?php } else { ?>

            <div class = "panel-group <?php echo esc_attr($is_mobile) ?>" id = "accordion" role = "tablist" aria-multiselectable = "true">                                                                  
                <?php  dynamic_sidebar('search_sidebar'); ?>                                 
            </div>
        <?php } ?>  
    </aside>
<?php } ?>