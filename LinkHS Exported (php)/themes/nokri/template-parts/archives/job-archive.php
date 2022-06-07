<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nokri
 */
global $nokri;
?>
<section class="n-search-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <aside class="new-sidebar">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php get_sidebar('widget'); ?>
                            </div>
                        </aside>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <div class="n-search-main">
                            <div class="n-search-listing n-featured-jobs">
                                <div class="n-featured-job-boxes">
                                    <?php
                                    if (have_posts()) {
                                        while (have_posts()) {
                                            the_post();

                                            $pid = get_the_ID();
                                            $ad = new jobs();
                                            echo nokri_returnEcho($ad->nokri_search_layout_list_3($pid));
                                        }
                                    } else {
                                        echo '<h3>' . esc_html__('No Result Found', 'nokri') . '</h3>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
