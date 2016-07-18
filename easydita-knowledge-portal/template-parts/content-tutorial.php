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
	
	<div class="header-title"><?php echo get_the_title($root_map_id); ?></div>
  <?php get_template_part('template-parts/scroll-top-button'); ?>
  	
	<div class="main-entry-wrapper">
		<?php get_template_part('template-parts/toc'); ?>
		<div class="entry-content">
			<div class="root-title"><?php echo $root_title ?></div>
			<?php if ($root_title != get_the_title()) : ?>
			<div class="content-title"><?php echo get_the_title(); ?></div>
			<?php endif ?>
			<?php 
				the_content();
			?>
		</div><!-- .entry-content -->
	</div> <!-- .main-entry-wrapper -->
	<script type="text/javascript">
		
		jQuery(function(){ // document ready
			
			var tocOrigTop = jQuery('#side-toc').offset().top;
			var subsections = jQuery('h1[id]');
			var locations = [];
			var ids = [];
			for (var i=0; i < subsections.length; i++) {
				locations.push(subsections[i].offsetTop);
				ids.push(subsections[i].id);
			}
			
			handleScroll();
			jQuery(window).scroll(handleScroll);
			
			function handleScroll() {
				// Set the hash appropriately when scrolling
				var cScrollTop = jQuery(window).scrollTop();
				for (var i=0; i < locations.length; i++) {
					if (i == 0 && cScrollTop < locations[i]) {
						history.replaceState({},'',location.pathname);
						break;
					} else if (cScrollTop < locations[i] && cScrollTop > locations[i-1]) {
						history.replaceState({},'',location.pathname+"#"+ids[i-1]);
						// highlight the current step in the TOC
						jQuery('#side-toc li.parent-item:has(a[href *= "#"])').each(function(index) {
							jQuery(this).removeClass('parent-item');
						});
						var currentSection = jQuery('#side-toc li:has(a[href = "'+location.toString()+'"])');
						if (currentSection.length == 0) {
							currentSection = jQuery('#side-toc li:has(a[href $= "'+location.hash+'"])');
						}
						currentSection.addClass('parent-item');
						break;
					}
				}
			
				// Make sure the TOC stays on screen
				var theSideToc = jQuery('#side-toc');
				var theWidth = jQuery(window).width();
				if (jQuery("#side-toc")[0].clientWidth > 0) {
					if (tocOrigTop < cScrollTop+45) {
						theSideToc.css({ position: 'fixed', top: '45px' });
						var tocWidth = (theWidth < 783) ? '200px' : '300px';
						jQuery('.main-entry-wrapper .entry-content').css({width: 'calc(100% - '+tocWidth+')',display: 'block',left: tocWidth,position: 'relative'});
					} else {
						theSideToc.css('position','static');
						jQuery('.main-entry-wrapper .entry-content').css({width: 'initial',display: 'table-cell',left: '0'});
					}
				} else {
					jQuery('.main-entry-wrapper .entry-content').css({width: 'initial',display: 'table-cell',left: '0'});
				}
        
			}      
		});
	</script>
</article><!-- #post-## -->
