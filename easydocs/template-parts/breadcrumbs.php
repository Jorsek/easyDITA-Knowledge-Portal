<?php

function get_breadcrumb() {

	global $post;
  
	$trail = '';
	$page_title = get_the_title($post->ID);

	if($post->post_parent) {
		$parent_id = $post->post_parent;

		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a> &gt; ';
			$parent_id = $page->post_parent;
		}
		
		$breadcrumbs = array_reverse($breadcrumbs);
		foreach($breadcrumbs as $crumb) $trail .= $crumb;
	}

	/** Add home **/
	$trail = '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . __('Home', 'easydocs') . '</a> &gt; ' . $trail;

	$trail .= $page_title;
	$trail .= '';

	return $trail;	

}

?>

<?php if (is_search()) : ?>

	<div class="breadcrumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php _e('Home', 'easydocs'); ?></a> &gt; <?php _e('Search Results', 'easydocs'); ?></div>

<?php elseif (!is_front_page()) : ?>

	<div class="breadcrumbs"><?php echo get_breadcrumb() ?></div>

<?php endif; ?>