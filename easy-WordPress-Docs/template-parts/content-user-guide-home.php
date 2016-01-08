<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="header-title"><?php echo get_the_title(); ?></div>
	
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			$current_ID = $wp_query->post->ID;
			$args = array(
				"post_type" => "page",
				"post_parent" => $current_ID,
				"orderby" => "menu_order",
				"order" => "ASC"
			);
			// The Query
			$the_query = new WP_Query( $args );
		?>
		
		<div class="thumbnail-links">
			
			<?php // The Loop
			if ( $the_query->have_posts() ) { 
			
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?>
					
					<div class="subpage">
						<?php
						/*$children = get_pages("child_of=".$post->ID."&sort_column=menu_order");
						$first_child = $children[0];
						$first_child_permalink = get_permalink($first_child->ID);*/
						?>
						<a class="main-page-link" href="<?php the_permalink() ?>">
					
							<?php
							echo the_post_thumbnail();
							echo '<div class="title-text">';
							echo get_the_title();
							echo '</div>';
							?>
						</a>
						
						<div class="child-pages">
							<?php
							$sub_args = array(
								"posts_per_page" => 5,
								"post_type" => "page",
								"post_parent" => get_the_ID(),
								"orderby" => "menu_order",
								"order" => "ASC"
							);
							$sub_query = new WP_Query($sub_args);
							if ($sub_query->have_posts()) {
								while ($sub_query->have_posts()) {
									$sub_query->the_post();
									?>
									<a href="<?php echo the_permalink(); ?>" class="child-page"><?php echo get_the_title(); ?></a>
									<?php
								}
							}
							?>
						</div> <!-- .child-pages -->
					</div> <!-- .subpage -->
				<?php
				}
				/* Restore original Post Data */
				wp_reset_postdata();
			}
			?>
		</div><!-- .thumbnail-links -->
	</div><!-- .entry-content -->
</article><!-- #post-## -->

