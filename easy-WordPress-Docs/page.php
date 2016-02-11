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

$page_type = get_post_meta(get_root_map_id(),'page_type',true);

// This if block is to skip over the user guide overview page.
// It automatically redirects to the first child.
if (!get_post_meta(get_root_map_id(),'page_type') || $page_type == 'content' || $page_type == 'tutorial') {
	if (wp_get_post_parent_id( get_the_ID() ) == 0) {
		$pagekids = get_pages("child_of=".$post->ID."&sort_column=menu_order");
		if ($pagekids) {
			$firstchild = $pagekids[0];
			wp_redirect(get_permalink($firstchild->ID));
		}
	}
}

get_header();
get_template_part("template-parts/breadcrumbs");
?>

	<div id="primary" class="content-area <?php echo $page_type; ?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) {
				the_post();

		  		if (function_exists(set_post_views)) { set_post_views(get_the_ID()); }
				
				if ($page_type == 'content') {
					if (wp_get_post_parent_id( get_the_ID() ) == 0) {
						get_template_part( 'template-parts/content', 'user-guide-home' );
					} else {
						get_template_part( 'template-parts/content', 'user-guide-content' );
					}
				} else if ($page_type == 'faq') {
					get_template_part( 'template-parts/content', 'faq');
				} else if ($page_type == 'tutorial') {
					get_template_part( 'template-parts/content', 'tutorial' );
				} else if (!get_post_meta(get_root_map_id(),'page_type')) {
					if (wp_get_post_parent_id( get_the_ID() ) == 0) {
						get_template_part( 'template-parts/content', 'user-guide-home' );
					} else {
						get_template_part( 'template-parts/content', 'user-guide-content' );
					}
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
