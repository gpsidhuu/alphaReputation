<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>

<!-- Comment Item -->
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class('media comment-item'); ?> id="li-comment-<?php comment_ID() ?>">
	<div class="pull-left">
		<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '', get_comment_author_email( $comment->comment_ID ) ); ?>
	</div>
	<div class="media-body">
		<div class="comment-item-data">
			<div class="comment-author" itemprop="author">
				<?php comment_author(); 
				if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' ) {
					if ( wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $comment->comment_post_ID ) ) {
						echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';
					}
				}
				
				?>
			</div>
			<time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( __( get_option( 'date_format' ), 'woocommerce' ) ); ?></time><span class="separator">&mdash;</span>
			
			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>			
				<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" title="<?php echo esc_attr(sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating )); ?>">
					<?php $rating = round($rating);
						for ($i = 0; $i < $rating; $i++): ?>
							<i class="fa fa-star"></i>
						<?php endfor; 
						for ($i = 5; $i > $rating; $i--): ?>
							<i class="fa fa-star-o"></i>
						<?php endfor; ?>
				</span>
			<?php endif; ?>


		</div>
		
		<?php if ( $comment->comment_approved == '0' ) : ?>

			<div><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></div>

		<?php endif; ?>
		
		<div itemprop="description" class="description"><?php comment_text(); ?></div>
	</div>
<!-- End Comment Item -->
