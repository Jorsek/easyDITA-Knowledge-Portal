<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
			
				<!--<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'easydocs' ); ?></h1>
				</header>--><!-- .page-header -->

				<div class="home-search">
					<div class="header"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'easydocs' ); ?></div>
				    <div class="text"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search or one of the popular pages below? Or you can always escape back to the home page by clicking the logo in the top left.', '_s' ); ?></div>
				    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			          <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', 'Have a question? Ask or enter a search term.' ); ?>" />
			  		  <button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
		  	        </form>
				</div>

			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
