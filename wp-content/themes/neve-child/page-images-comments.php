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

					//display attached images
					$children_args = array(
						'order'          => 'ASC',
		        'post_mime_type' => 'image',
		        'post_parent'    => $post->ID
					);

					$this_page_children = get_children($children_args);

					/*
					echo('<pre>');
					print_r($this_page_children);
					echo('</pre>');
					*/
					foreach($this_page_children as $this_child){
								//display all imamge attachment children
								echo(wp_get_attachment_link($this_child->ID, 'large', true) );

								//display a random commment from the attachment image
								$comments_args = array(
									'post_id' => $this_child->ID
								);
								$this_comments_list = (get_comments($comments_args));
								if (sizeof($this_comments_list)> 0 ){
									$chosen_comment = $this_comments_list[array_rand($this_comments_list)];
									//display comment content
									?>
									<div class="comment">
										<div class="comment-content">
											"<?php echo($chosen_comment->comment_content);?>"
										</div>
										<div class="comment-author">
											by <?php echo($chosen_comment->comment_author);?>
										</div>
									</div>
									<?php
								}

							/*
							echo('<pre>');
							echo('array </br>');
							print_r($this_child);
							echo('</pre>');

							echo('<pre>');
							echo('this_child[ID]');
							echo($this_child->ID);
							echo('</pre>');
							*/
					}
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