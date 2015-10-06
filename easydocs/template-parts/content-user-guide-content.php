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
	
	<?php $root_map_id = get_root_map_id(); ?>
	
	<div class="header-title"><?php echo get_the_title($root_map_id); ?></div>
	
	<div class="main-entry-wrapper">
		<?php get_template_part('template-parts/toc'); ?>
		<div class="entry-content">
			<div class="root-title"><?php echo get_the_title(get_hierarchy()[1]) ?></div>
			<?php if (get_the_content() != '') : ?>
			<div class="content-title"><?php echo get_the_title(); ?></div>
			<?php endif ?>
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
				if ($the_query->have_posts()) {
					echo '<div class="child-pages-title">' . get_theme_mod( 'child_pages_title', 'Child Pages' ) . '</div>';
					echo '<ul class="child-pages">';
					while($the_query->have_posts()) {
						$the_query->the_post();
						echo '<li class="child-page">';
						echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
						echo '</li>';
					}
					echo '</ul>';
				}
			?>
		</div><!-- .entry-content -->
	</div> <!-- .main-entry-wrapper -->
</article><!-- #post-## -->

