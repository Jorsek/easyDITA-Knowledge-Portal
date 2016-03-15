<?php
/**
 * Template part for displaying FAQ content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
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
				
				<div class="faq closed" faq-id="faq_<?php echo get_the_ID(); ?>">
					<div class="faq-head" onclick="showHideContent(this)">
						<span class="faq-icon"> </span>
						<div class="faq-title">
							<?php echo get_the_title(); ?>
						</div>
					</div>
					
					<div class="faq-content" style="display:none;">
						<?php echo get_the_content(); ?>
					</div> <!-- .faq-content -->
				</div> <!-- .faq -->
			<?php
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		?>
	</div><!-- .faq-entries -->
	<script type="text/javascript">
		
		jQuery(document).ready(function() {
			var theHash = location.hash;
			if (theHash == null) return;
			
			var theIDs = theHash.substring(1).split(",");
			
			for (var i=0; i < theIDs.length; i++) {
				if (theIDs[i] == "") continue;
				showHideContent(jQuery("[faq-id='"+theIDs[i]+"'] > .faq-head")[0]);
			}
		});
		
		function showHideContent(target) {
			if (target == null || target.nextElementSibling == null || target.parentElement == null) return;
			if (target.parentElement.classList.contains("closed")) {
				// Open the FAQ
				target.nextElementSibling.style.display = "block";
				target.parentElement.classList.remove("closed");
				target.parentElement.classList.add("open");
				
				// Add the id to the location hash
				var theID = target.parentElement.getAttribute("faq-id");
				var oldHash = location.hash;
				if (oldHash.indexOf(theID) == -1) {
					location.hash = (oldHash == "") ? theID : location.hash+","+theID;
				}
				
				// Increment views using custom-popular-pages-widget action
				var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
				var elID = target.parentElement.getAttribute('faq-id');
				var pageID = elID.substring("faq_".length);
				
				jQuery.post(
					ajaxurl,
					{
						'action': 'increment_views',
						'id': pageID
					},
					function(response) {
						console.log("View count incremented for page: " + pageID);
					}
				);
				
			} else {
				// Close the FAQ
				target.nextElementSibling.style.display = "none";
				target.parentElement.classList.remove("open");
				target.parentElement.classList.add("closed");
				
				// Remove the id from the location hash
				var theID = target.parentElement.getAttribute("faq-id");
				var oldHash = location.hash;
				var newHash = oldHash.replace(theID,"").replace(",+",",");
				
				// Replace hash
	            if ((''+newHash).charAt(0) !== '#') newHash = '#' + newHash;
	            history.replaceState('', '', newHash);
			}
		}
		
	</script>
</article><!-- #post-## -->

