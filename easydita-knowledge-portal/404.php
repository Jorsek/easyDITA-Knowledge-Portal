<?php
/**
 * The template for displaying 404 pages (not found).
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package easydita_knowledge_portal
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
			
				<!--<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'easydita_knowledge_portal' ); ?></h1>
				</header>--><!-- .page-header -->

				<?php
				if (function_exists('get_404_content')) {
					get_404_content();
				} else {
					easydita_knowledge_portal_get_404_content();
				}
				?>

			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
