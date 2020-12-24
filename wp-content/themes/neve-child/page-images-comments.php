<?php
/**
 * Template Name: show all page images with comments
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

					$children_args = array(
						'order'          => 'ASC',
		        'post_mime_type' => 'image',
		        'post_parent'    => $post_id
					);

					$this_page_children = get_children($children_args);
					echo('<pre>');
					print_r($this_page_children);
					echo('</pre>');

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
