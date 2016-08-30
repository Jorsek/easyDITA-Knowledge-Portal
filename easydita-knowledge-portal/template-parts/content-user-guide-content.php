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
	
  <?php get_template_part('template-parts/scroll-top-button'); ?>
	
	<div class="main-entry-wrapper">
		<?php get_template_part('template-parts/toc'); ?>
		<div class="entry-content">
			<?php if ($root_title != get_the_title()) : ?>
			<h1 class="content-title"><?php echo get_the_title(); ?></h1>
      
      <!-- Option in customizer to move shortdesc -->
      <?php if (get_theme_mod('move_short_desc',0) == 1) : ?>
        <p id="moved-shortdesc">
          <?php easydita_knowledge_portal_get_the_shortdesc(); ?>
        </p>
        <style>
          .topic-shortdesc {
            display: none;
          }
          
          .entry-content #moved-shortdesc {
            max-width: 800px;
            margin: 15px 0 25px;
            font-style: italic;
          }
        </style>
      <?php endif ?>
      
      <!-- Option in customizer to display note icons-->
      <?php if (get_theme_mod('display_icons',0) == 1) : ?>
        <style>
          .note-icon {
            display: initial;
          }
          .topic-note {
            padding: 0 0 0 15px;
          }
        </style>
      <?php endif ?>
      
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
						
              <?php if (get_theme_mod('link_summary_shortdesc',0) == 1) : ?>
  							<div class="entry-summary">
  								<?php easydita_knowledge_portal_get_the_shortdesc(); ?>
  							</div><!-- .entry-summary -->
							<?php endif ?>
              
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
				if ($the_query->have_posts() && get_theme_mod('topic_hierarchy_display',1) == 1) {
					echo '<div class="concatenated-content">';
					while($the_query->have_posts()) {
						$the_query->the_post();
						?>
						<?php if (get_the_content() != "") : ?>
						<div class="child-page-content">
							<h2 class="content-title"><?php echo get_the_title(); ?></h2>
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
