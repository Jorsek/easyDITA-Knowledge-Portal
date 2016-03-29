<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydita_knowledge_portal
 */

?>

<section class="no-results not-found">
	<h2 class="header"><?php esc_html_e( 'Nothing Found', 'easydita_knowledge_portal' ); ?></h1>

	<div class="text">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) :
			printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'easydita_knowledge_portal' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) );

		elseif ( is_search() ) :
			esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'easydita_knowledge_portal' );

		else :
			esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'easydita_knowledge_portal' );

		endif; ?>
	</div><!-- .page-content -->
	
</section><!-- .no-results -->
