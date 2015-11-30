<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

// This if block is to skip over the user guide overview page.
// It automatically redirects to the first child.
if (get_post_meta(get_root_map_id(),'page_type',true) == 'content') {
	if (wp_get_post_parent_id( get_the_ID() ) == 0) {
		$pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
		if ($pagekids) {
			$firstchild = $pagekids[0];
			wp_redirect(get_permalink($firstchild->ID));
		}
	}
}

get_header();
get_template_part("template-parts/searchbar");
get_template_part("template-parts/breadcrumbs");
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) {
				the_post();

		  		if (function_exists(set_post_views)) { set_post_views(get_the_ID()); }
				
				if (get_post_meta(get_root_map_id(),'page_type',true) == 'content') {
					if (wp_get_post_parent_id( get_the_ID() ) == 0) {
						get_template_part( 'template-parts/content', 'user-guide-home' );
					} else {
						get_template_part( 'template-parts/content', 'user-guide-content' );
					}
				} else if (get_post_meta(get_root_map_id(),'page_type',true) == 'faq') {
					get_template_part( 'template-parts/content', 'faq');
				} else if (get_post_meta(get_root_map_id(),'page_type',true) == 'tutorial') {
					echo "<div>This is a Tutorial Page.</div>";
				} else if (!get_post_meta(get_root_map_id(),'page_type')) {
					echo "<div>This page doesn't have a type.</div>";
				}

				
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				
			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
