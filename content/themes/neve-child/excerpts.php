<?php
/**
 * Template Name: Excerpts
 *
 * @package neve-child
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-page' );

get_header();

?>
<div class="<?php echo esc_attr( $container_class ); ?> single-page-container">
	<div class="row">
		<?php do_action( 'neve_do_sidebar', 'single-page', 'left' ); ?>
		<div class="nv-single-page-wrap col">
			<?php
			do_action( 'neve_before_page_header' );
			do_action( 'neve_page_header', 'single-page' );
			do_action( 'neve_before_content', 'single-page' );
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );

					//display child pages, per https://wordpress.stackexchange.com/questions/93844/child-pages-loop
					$child_pages = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = ".$post->ID."    AND post_type = 'page' ORDER BY menu_order", 'OBJECT');    ?>
					<?php if ( $child_pages ) : foreach ( $child_pages as $pageChild ) : setup_postdata( $pageChild ); ?>
						<?php
						// Must be inside a loop.
						if ( has_post_thumbnail($pageChild->ID) ) {
						get_the_post_thumbnail('page-thumb-mine');
						}
						//  else {
						//  echo '<img src="' . get_bloginfo( 'stylesheet_directory' ) . '/images/icon-cropped.png" />';
						//  }
						?>

						<div <?php post_class(); ?>>
						<?php echo get_the_post_thumbnail($pageChild->ID, 'page-thumb-mine'); ?>
						<h3><a href="<?php echo get_permalink($pageChild->ID); ?>" rel="bookmark" title="<?php     echo $pageChild->post_title; ?>"><?php echo $pageChild->post_title; ?></a></h3>
						<?php echo get_the_excerpt($pageChild->ID); ?>
						</div>
						</div>
					<?php endforeach; endif;

				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			do_action( 'neve_after_content', 'single-page' );
			?>
		</div>
		<?php do_action( 'neve_do_sidebar', 'single-page', 'right' ); ?>
	</div>
</div>
<?php get_footer(); ?>
