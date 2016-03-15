<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php
	$root_map_id = easydita_knowledge_portal_get_root_map_id();
	$the_hierarchy = easydita_knowledge_portal_get_hierarchy();
	$root_title = get_the_title($the_hierarchy[1]);
	?>
	
	<div class="header-title"><?php echo get_the_title($root_map_id); ?></div>
	
	<div class="main-entry-wrapper">
		<?php get_template_part('template-parts/toc'); ?>
		<div class="entry-content">
			<div class="root-title"><?php echo $root_title ?></div>
			<?php if ($root_title != get_the_title()) : ?>
			<div class="content-title"><?php echo get_the_title(); ?></div>
			<?php endif ?>
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
					echo '<div class="content-child-pages">';
					/* echo '<div class="child-pages-title">' . get_theme_mod( 'child_pages_title', 'Child Pages' ) . '</div>'; */
					while($the_query->have_posts()) {
						$the_query->the_post();
						?>
						<div class="child-page-entry">
							<header class="entry-header">
								<a class="title" href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
								<!--<?php $root_map_id = easydita_knowledge_portal_get_root_map_id(); ?>
								<div class="category <?php echo get_post_meta($root_map_id,'page_type',true) ?>"><?php echo get_the_title($root_map_id) ?></div>-->
							</header><!-- .entry-header -->
						
							<div class="entry-summary">
								<?php easydita_knowledge_portal_get_the_shortdesc(); ?>
							</div><!-- .entry-summary -->
							
							<!--<div class="entry-url">
								<a href="<?php echo the_permalink(); ?>"><?php echo the_permalink(); ?></a>
							</div>--><!-- .entry-url -->
						</div><!-- #post-## -->
						<?php
					}
					echo '</div>';
				}
				wp_reset_query();
				wp_reset_postdata();
			?>
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
					echo '<div class="concatenated-content">';
					while($the_query->have_posts()) {
						$the_query->the_post();
						?>
						<?php if (get_the_content() != "") : ?>
						<div class="child-page-content">
							<div class="content-title"><?php echo get_the_title(); ?></div>
							<?php the_content(); ?>
						</div><!-- #post-## -->
						<?php endif ?>
						<?php
					}
					echo '</div>';
				}
				wp_reset_query();
				wp_reset_postdata();
			?>
		</div><!-- .entry-content -->
	</div> <!-- .main-entry-wrapper -->
</article><!-- #post-## -->

