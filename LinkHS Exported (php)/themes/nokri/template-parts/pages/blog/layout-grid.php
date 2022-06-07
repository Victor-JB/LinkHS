<?php global $nokri; 
$pid = get_the_id();
$author_id=$post->post_author;
$comments_html = get_comments_number($pid);
$comments_txt = __("comment", "nokri");
if($comments_html > 1 || $comments_html == '0' )
{
	$comments_txt = __("comments", "nokri");
}
?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="n-blog-box">
     <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
     <?php if ( has_post_thumbnail() ) { ?>
        <div class="n-blog-top">
           <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo get_the_post_thumbnail($pid,'nokri_post_standard',array('class'=>'img-responsive') ); ?> </a>
        </div>
        <?php } ?>
        <div class="n-blog-bottom">
        <?php if( isset( $nokri['theme_date'] ) && $nokri['theme_date'] == '1'   ) { ?>
            <ul>
                <li><?php echo  get_the_time(get_option( 'date_format' )); ?></li>
            </ul>
            <?php } ?>
            <h4>
            <?php
            $title = the_title('','',false);
            if (empty($title)) { 
            echo '
            <a class="readmore" href="'. esc_url(get_the_permalink()).'">
            <strong>'.esc_html__('Read More','nokri').'</strong>
            </a>';
            } else { ?>
            <a href="<?php echo esc_url(get_the_permalink());?>">
               <?php echo the_title(); ?>
             </a>
            <?php  } ?>
            </h4>
             <?php if( isset( $nokri['theme_cmnt'] ) && $nokri['theme_cmnt'] == '1'   ) { ?>
            <p><?php echo nokri_words_count(get_the_excerpt(), 90); ?></p>
            <?php } ?>
            <a href="<?php echo esc_url(get_the_permalink($pid)); ?>" class="read-more"><?php echo __("Read More", "nokri"); ?></a>
        </div>
        </div>
    </div>
</div>