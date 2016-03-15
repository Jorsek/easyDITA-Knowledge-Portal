<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
 */

?>

<article id="post-<?php the_ID(); ?>" class="search-result">
	<header class="entry-header">
		<a class="title" href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
		<?php $root_map_id = easydita_knowledge_portal_get_root_map_id(); ?>
		<div class="category <?php echo get_post_meta($root_map_id,'page_type',true) ?>"><?php echo get_the_title($root_map_id) ?></div>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php
		$excerpt = get_the_excerpt();
		if ($excerpt == "") {
			echo easydita_knowledge_portal_get_the_shortdesc();
		} else {
			$title = get_the_title();
			if (substr($excerpt,0,strlen($title)) === $title) {
				echo substr($excerpt,strlen($title));
			} else {
				echo $excerpt;
			}
		}
		?>
	</div><!-- .entry-summary -->
	
	<div class="entry-url">
		<a href="<?php echo the_permalink(); ?>"><?php echo the_permalink(); ?></a>
	</div><!-- .entry-url -->
</article><!-- #post-## -->

