<?php
/**
 * Template part for displaying table of contents.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easyDocs
 *
 */

function get_toc($post_id,$hierarchy,$ul_is_parent = true) {
/** 
 * This loop will show all the root maps, then when it
 * detects the root map that we're currently in (via the 
 * hierarchy), it will display all the submaps for that page
 * etc.
 **/  
  
	$args_two = array(
	  "post_type" => "page",
	  "post_parent" => $post_id,
	  "orderby" => "menu_order",
	  "order" => "ASC"
	);
    $query_two = new WP_Query($args_two);
  	if ( $query_two->have_posts() ) {
  	?>
  	<div style="overflow:hidden;" class="<?php echo $ul_is_parent ? 'open' : 'closed' ?>">
  	<ul class="toc-list">
  		<?php
		while ( $query_two->have_posts() ) {
		  $query_two->the_post();
		  $is_parent = array_search(get_the_ID(),$hierarchy,false);
		  ?>
		  <li class="toc-item<?php echo $is_parent ? ' parent-item' : '' ?>">
		  	<?php
			$children = get_pages('child_of='.get_the_ID());
			if (count($children) != 0) {
				?>
				<a onclick="openCloseSubtoc(this)"><?php echo get_the_title(); ?></a>
				<?php
				if ($is_parent) {
					echo get_toc(get_the_ID(),$hierarchy,true);
				} else {
					echo get_toc(get_the_ID(),$hierarchy,false);
				}
			} else {
				?>
				<a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a>
				<?php
			}
			?>
		  </li>
		  <?php
		}
	?></ul>
	</div><?php
	}
}

?>

<div class="toc">
	
	<?php /** TOC Title set via Customizer **/ ?>
	<div class="title"><?php echo get_theme_mod( 'toc_title', 'TOC' ); ?></div>
	
	<?php
	$hierarchy = get_hierarchy();
	get_toc($hierarchy[0],$hierarchy);
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
	
	<script type="text/javascript">
		
		jQuery(document).ready(function() {
			jQuery(".closed ul").each(function(index) {
				this.style.marginTop = "-"+this.clientHeight+"px";
			});
		});
		
		function openCloseSubtoc(target) {
			if (target == null || target.nextElementSibling == null || target.nextElementSibling.firstElementChild == null) return;
			var theDiv = target.nextElementSibling;
			var theList = theDiv.firstElementChild;
			theDiv.classList.toggle('open');
			theDiv.classList.toggle('closed');
			
			if (theDiv.classList.contains('open')) {
				jQuery(theList).animate({marginTop:"0px"})
			} else if (theDiv.classList.contains('closed')) {
				jQuery(theList).animate({marginTop:"-"+theList.clientHeight+"px"})
			}
			
		}
		
	</script>
	
</div>