<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
		<?php echo esc_html__( 'Reviews', 'nokri' );?></h2>

		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html__( 'There are no reviews yet.', 'nokri' ); ?></p>

		<?php endif; ?>
	</div>
	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$commenter = wp_get_current_commenter();
					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'nokri' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'nokri' ), get_the_title() ),
						'title_reply_to'       => __( 'Leave a Reply to %s', 'nokri' ),
						'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
						'title_reply_after'    => '</span>',
						'comment_notes_after'  => '',
						'fields'               => array(
						
							'author' => '<div class="col-md-6 col-sm-12"><div class="form-group"><label>' . esc_html__( 'Name', 'nokri' ) . ': <span class="required">*</span></label><input  name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  class="form-control" type="text"></div></div>',
							'email'  => '<div class="col-md-6 col-sm-12"><div class="form-group"><label>' . esc_html__( 'Email', 'nokri' ) . ': <span class="required">*</span></label><input  id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" class="form-control" type="text" aria-required="true" required></div></div>',
						),
						'label_submit'  => __( 'Submit', 'nokri' ),
						'logged_in_as'  => '',
						'comment_field' => '',
					);
					if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'nokri' ), esc_url( $account_page_url ) ) . '</p>';
					}
					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<div class="col-md-12 col-sm-12"><label for="rating">' . esc_html__( 'Your rating', 'nokri' ) . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'nokri' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'nokri' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'nokri' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'nokri' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'nokri' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'nokri' ) . '</option>
						</select> </div>';
					}
					$comment_form['comment_field'] .=  '<div class="col-md-12 col-sm-12"> <div class="form-group"> <label>' . esc_html__( 'Your review', 'nokri' ) . '<span class="required">*</span> </label><textarea cols="6" id="comment" name="comment" rows="6" aria-required="true" required  class="form-control"></textarea></div>
                      </div>';
					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html__( 'Only logged in customers who have purchased this product may leave a review.', 'nokri' ); ?></p>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
