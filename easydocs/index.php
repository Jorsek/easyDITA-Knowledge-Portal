<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header();
get_template_part("template-parts/searchbar");
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		  <!-- default template commented out -->
<?php /****
		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php /* Start the Loop *-/ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 *-/
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>
<?php ****/ ?>
		  
<?php

/*
 * List all the root pages (maps)
 */

$args = array(
  "posts_per_page" => 4,
  "post_type" => "page",
  "post_parent" => 0,
  "orderby" => "menu_order",
  "order" => "ASC"
  );
// The Query
$the_query = new WP_Query( $args );
?>

<div class="header-title">Browse Help Content</div>

<div class="thumbnail-links">
  <?php // The Loop
  if ( $the_query->have_posts() ) { ?>
  
	<?php
		while ( $the_query->have_posts() ) {
		  $the_query->the_post();
		  ?>
		  <div class="subpage">
	          <a class="main-page-link" href="<?php the_permalink() ?>">
			  
				  <?php
				  // Insert image here....somehow
				  echo the_post_thumbnail();
				  echo '<div class="title-text">';
				  echo get_the_title();
				  echo '</div>';
				  ?>
			  </a>
		  </div><!-- .subpage -->
		  <?php
		}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
  </div>
  
  <?php
  } else { ?>
	<div class="no-pages">No Pages Here...</div>
  
  <?php
  } ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
