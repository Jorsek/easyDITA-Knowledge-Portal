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

<div class="header-title"><?php echo get_theme_mod( 'browse_title', 'Browse Help Content' ); ?></div>

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
