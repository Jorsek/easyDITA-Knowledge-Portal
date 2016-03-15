<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package easydita_knowledge_portal
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function easydita_knowledge_portal_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'easydita_knowledge_portal_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function easydita_knowledge_portal_jetpack_setup
add_action( 'after_setup_theme', 'easydita_knowledge_portal_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function easydita_knowledge_portal_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function easydita_knowledge_portal_infinite_scroll_render
