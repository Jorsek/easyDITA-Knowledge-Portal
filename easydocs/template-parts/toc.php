<?php
/**
 * Template part for displaying table of contents.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydocs
 *
 */

function show_subsections_in_toc($subsections,$ul_is_parent = true) {
	?>
	<div style="overflow:hidden;" class="<?php echo $ul_is_parent ? 'open' : 'closed' ?>">
	  	<ul class="toc-list">
	  	<?php 
			for ($i = 0; $i < count($subsections); $i++) {
				$text = preg_replace('#<[^>]*>#','',$subsections[$i]);
				preg_match('#(?<= id=")[^"]*#',$subsections[$i],$id);
				$href = $ul_is_parent ? '#'.$id[0] : get_the_permalink().'#'.$id[0];
				?>
				<li class="toc-item<?php echo $is_parent ? ' parent-item' : '' ?>">
					<a href="<?php echo $href; ?>"><?php echo $text; ?></a>
				</li>
				<?php
			}
		?>
		</ul>
	</div>
	<?php
}

function get_toc($post_id,$hierarchy,$is_tutorial,$ul_is_parent = true) {
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
			$subsections = easydocs_get_subsections();
			echo "<div class='toc-head' onclick='openCloseSubtoc(this)'>";
			if (count($children) != 0) {
				if ($is_parent) {
					echo '<i class="plusminus-icon minus"> </i>';
				} else {
					echo '<i class="plusminus-icon plus"> </i>';
				}
				?>
				<a href="<?php echo the_permalink(); ?>" onclick="event.stopPropagation();"><?php echo get_the_title(); ?></a>
				</div>
				<?php
				if ($is_parent) {
					echo get_toc(get_the_ID(),$hierarchy,$is_tutorial,true);
				} else {
					echo get_toc(get_the_ID(),$hierarchy,$is_tutorial,false);
				}
			} else if ($is_tutorial && count($subsections) != 0) {
				if ($is_parent) {
					echo '<i class="plusminus-icon minus"> </i>';
				} else {
					echo '<i class="plusminus-icon plus"> </i>';
				}
				?>
				<a href="<?php echo the_permalink(); ?>" onclick="event.stopPropagation();"><?php echo get_the_title(); ?></a>
				</div>
				<?php
				if ($is_parent) {
					echo show_subsections_in_toc($subsections,true);
				} else {
					echo show_subsections_in_toc($subsections,false);
				}
			} else {
				?>
				<a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a>
				</div>
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

<div class="toc" id="side-toc">
	
	<?php /** TOC Title set via Customizer **/ ?>
	<div class="title"><?php echo get_theme_mod( 'toc_title', _e('TOC', 'easydocs') ); ?></div>
	
	<?php
	$hierarchy = easydocs_get_hierarchy();
	$page_type = get_post_meta($hierarchy[0],'page_type',true);
	
	// Check the cache
	$key = $hierarchy[0] . md5(serialize($hierarchy)) . $page_type;
	if (false === ($toc_html = get_transient($key))) {
		// Not cached, so need to get it
		$toc_html = get_toc($hierarchy[0],$hierarchy,$page_type == 'tutorial');
		// Store for a day
		set_transient($key,$toc_html,DAY_IN_SECONDS);
		wp_reset_postdata();
	}
	echo $toc_html;
	?>
	
	<script type="text/javascript">
		
		jQuery(document).ready(function() {
			jQuery(".closed ul").each(function(index) {
				this.style.marginTop = "-"+this.clientHeight+"px";
				this.style.display = "none";
			});
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