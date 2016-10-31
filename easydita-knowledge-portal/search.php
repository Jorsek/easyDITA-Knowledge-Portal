<?php
/**
 * The template for displaying search results pages.
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package easydita_knowledge_portal
 */

get_header();
get_template_part("template-parts/breadcrumbs");

// get the current version
$versionId = easydita_knowledge_portal_get_version_id();
$current_version_pages = easydita_knowledge_portal_get_ids_in_version($versionId);

// get the search parameter
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

if( strlen($query_string) > 0 ) {
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach
} //if

// Searching for an empty string is valid
if ( !$search_query["s"] ) {
	$search_query["s"] = "";
}

// Only include posts that are in the current version hierarchy
$search_query["post__in"] = $current_version_pages;

$search = new WP_Query($search_query);

?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<div class="header-title"><?php _e( "Search Results" , 'easydita_knowledge_portal'); ?></div>
    <?php get_template_part('template-parts/scroll-top-button'); ?>

		<?php if ( $search->have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( $search->have_posts() ) : $search->the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );
				?>

			<?php endwhile; ?>

			<?php easydita_knowledge_portal_the_posts_pagination($search); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php /*get_sidebar();*/ ?>
<?php get_footer(); ?>
