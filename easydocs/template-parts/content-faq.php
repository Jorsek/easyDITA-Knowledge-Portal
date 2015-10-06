<?php
/**
 * Template part for displaying FAQ content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="header-title"><?php echo get_the_title(); ?></div>
	
	<div class="faq-entries">
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
		
		if ( $the_query->have_posts() ) { 
		
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>
				
				<div class="faq closed">
					<span class="faq-icon" onclick="showHideContent(this.nextElementSibling)"> </span>
					<div class="faq-title" onclick="showHideContent(this)">
						<?php echo get_the_title(); ?>
					</div>
					
					<div class="faq-content" style="display:none;">
						<?php echo get_the_content() ?>
					</div> <!-- .child-pages -->
				</div> <!-- .subpage -->
			<?php
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		?>
	</div><!-- .faq-entries -->
	<script type="text/javascript">
		
		function showHideContent(target) {
			if (target == null || target.nextElementSibling == null || target.parentElement == null) return;
			if (target.parentElement.classList.contains("closed")) {
				target.nextElementSibling.style.display = "block";
				target.parentElement.classList.remove("closed");
				target.parentElement.classList.add("open");
			} else {
				target.nextElementSibling.style.display = "none";
				target.parentElement.classList.remove("open");
				target.parentElement.classList.add("closed");
			}
		}
		
	</script>
</article><!-- #post-## -->

