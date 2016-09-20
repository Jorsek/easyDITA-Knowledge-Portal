<?php
/**
 * Template part for displaying table of contents.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
 *
 */

function show_subsections_in_toc($page_id, $subsections) {
	?>
	<div style="overflow:hidden;" page-id="<?php echo esc_attr($page_id); ?>" class="closed">
	  	<ul class="toc-list">
	  	<?php 
			for ($i = 0; $i < count($subsections); $i++) {
				$text = preg_replace('#<[^>]*>#','',$subsections[$i]);
				preg_match('#(?<= id=")[^"]*#',$subsections[$i],$id);
				$href = $ul_is_parent ? '#'.$id[0] : get_the_permalink().'#'.$id[0];
				?>
				<li class="toc-item">
					<a href="<?php echo esc_url($href); ?>"><?php echo esc_html($text); ?></a>
				</li>
				<?php
			}
		?>
		</ul>
	</div>
	<?php
}

function get_toc($post_id,$is_tutorial) {
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
	  "order" => "ASC",
	  "posts_per_page" => -1
	);
    $query_two = new WP_Query($args_two);
  	if ( $query_two->have_posts() ) {
  	ob_start();
  	?>
  	<div style="overflow:hidden;" page-id="<?php echo esc_attr($post_id); ?>" class="closed">
  	<ul class="toc-list">
  		<?php
		while ( $query_two->have_posts() ) {
		  $query_two->the_post();
		  ?>
		  <li page-id="<?php echo esc_attr(get_the_ID()); ?>" class="toc-item">
		  	<?php
			$children = get_pages('child_of='.get_the_ID());
			$subsections = easydita_knowledge_portal_get_subsections();
			echo "<div class='toc-head' onclick='openCloseSubtoc(this)'>";
			if (count($children) != 0) {
				echo '<i class="plusminus-icon plus"> </i>';
				?>
				<a href="<?php echo esc_url(the_permalink()); ?>" onclick="event.stopPropagation();"><?php echo esc_attr(get_the_title()); ?></a>
				</div>
				<?php
				echo get_toc(get_the_ID(),$is_tutorial);
			} else if ($is_tutorial && count($subsections) != 0) {
				echo '<i class="plusminus-icon plus"> </i>';
				?>
				<a href="<?php echo esc_url(the_permalink()); ?>" onclick="event.stopPropagation();"><?php echo esc_attr(get_the_title()); ?></a>
				</div>
				<?php
				echo show_subsections_in_toc(get_the_ID(), $subsections);
			} else {
				?>
				<a href="<?php echo esc_url(the_permalink()); ?>"><?php echo esc_attr(get_the_title()); ?></a>
				</div>
				<?php
			}
			?>
		  </li>
		  <?php
		}
	?></ul>
	</div><?php
	return ob_get_clean();
	}
}

?>

<div class="toc" id="side-toc">
	
	<?php /** TOC Title set via Customizer **/ ?>
	<div class="title"><?php echo esc_html(get_theme_mod( 'toc_title', _e('TOC', 'easydita_knowledge_portal') )); ?></div>
	
	<?php
	$hierarchy = easydita_knowledge_portal_get_hierarchy();
	$root_page = (easydita_knowledge_portal_is_versioning_enabled() ? $hierarchy[1] : $hierarchy[0]);
	$page_type = get_post_meta($root_page,'page_type',true);
	
	// Check the cache
	$key = $root_page . $page_type;
	if (false === ($toc_html = get_transient($key))) {
		// Not cached, so need to get it
		$toc_html = get_toc($root_page,$page_type == 'tutorial');
		// Store for 3 days
		set_transient($key, $toc_html, 3 * DAY_IN_SECONDS);
		wp_reset_postdata();
	}
	echo $toc_html;
	?>
	
	<script type="text/javascript">
		
		var hierarchy = [<?php echo implode(",",$hierarchy); ?>]
		
		jQuery(document).ready(function() {
			jQuery(jQuery("li > .closed ul").get().reverse()).each(function(index) {
				this.style.marginTop = "-"+this.clientHeight+"px";
				this.style.display = "none";
			});
			
			for (var i=hierarchy.length-1; i>=0; i--) {
				jQuery("li[page-id = '"+hierarchy[i]+"']").addClass("parent-item");
				var theDiv = jQuery("div[page-id = '"+hierarchy[i]+"']");
				if (theDiv[0] != null) {
					var theHead = theDiv[0].previousElementSibling;
					if (theHead.classList.contains("toc-head")) {
						openCloseSubtoc(theHead);
					} else {
						theDiv[0].classList.toggle("closed");
						theDiv[0].classList.toggle("open");
					}
				}
			}
		});
		
		function openCloseSubtoc(tocHead) {
			if (tocHead == null || tocHead.firstElementChild == null || tocHead.nextElementSibling == null) return;
			var theIcon = tocHead.firstElementChild;
			var theDiv = tocHead.nextElementSibling;
			var theList = theDiv.firstElementChild;
			theDiv.classList.toggle('open');
			theDiv.classList.toggle('closed');
			theIcon.classList.toggle("plus");
			theIcon.classList.toggle("minus");
			
			if (theDiv.classList.contains('open')) {
				theList.style.display = "block";
				jQuery(theList).animate({marginTop:"0px"});
			} else if (theDiv.classList.contains('closed')) {
				jQuery(theList).animate({marginTop:"-"+theList.clientHeight+"px"},{"complete":function(){this.style.display = "none";}})
			}
			
		}
		
	</script>
	
</div>
