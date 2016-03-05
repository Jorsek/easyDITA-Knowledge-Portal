<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package easydocs
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

class Comment_Walker extends Walker {
	var $db_fields = array(
		'parent' => 'comment_parent',
		'id' => 'comment_ID'
	);
	
	// start_lvl - wrapper for child comments list
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 2; ?>
		
		<section class="child-comments comments-list">

	<?php }

	// end_lvl - closing wrapper for child comments list
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 2; ?>

		</section>

	<?php }

	// start_el - HTML for comment template
	function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment'] = $comment;
		$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 

		if ( 'article' == $args['style'] ) {
			$tag = 'article';
			$add_below = 'comment';
		} else {
			$tag = 'article';
			$add_below = 'comment';
		} ?>

		<article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
			<div class="comment-header">
				<figure class="gravatar"><?php echo get_avatar($comment, 32); ?></figure>
				<div class="comment-meta post-meta" role="complementary">
					<div class="comment-author"><?php comment_author(); ?></div>
					<time class="comment-time" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php comment_date('jS F Y') ?>, <a href="#comment-<?php comment_ID() ?>" itemprop="url"><?php comment_time() ?></a></time>
					<div class="edit-link">
						<?php edit_comment_link(__('Edit this comment', 'easydocs'),'',''); ?>
					</div>
					<?php if ($comment->comment_approved == '0') :
						echo __('Your comment is awaiting moderation.', 'easydocs');
					endif; ?>
				</div>
			</div>
			<div class="comment-content post-content" itemprop="text">
				<?php comment_text() ?>
				<div class="comment-reply-area">
					<i class="fa fa-reply fa-flip-horizontal"><!-- filler --></i>
					<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>

	<?php }

	// end_el - closing HTML for comment template
	function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

		</article>

	<?php }
	
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'easydocs' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'easydocs' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'easydocs' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'easydocs' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<div class="comment-list">
			<?php
				wp_list_comments( array(
					'walker' => new Comment_Walker(),
				) );
			?>
		</div><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'easydocs' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'easydocs' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'easydocs' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'easydocs' ); ?></p>
	<?php endif; ?>

	<?php
	$fields = array(
			'author' =>
				'<div class="comment-form-extra comment-form-author"><label for="author">' . __( 'Name', 'easydocs' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
				'" size="30"' . $aria_req . ' /></div>',
			
			'email' =>
				'<div class="comment-form-extra comment-form-email"><label for="email">' . __( 'Email', 'easydocs' ) . '</label> ' .
				( $req ? '<span class="required">*</span>' : '' ) .
				'<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) .
				'" size="30"' . $aria_req . ' /></div>',
			
			'breaker' =>
				'<div class="breaker"><!-- filler --></div>'
		);
	
	comment_form(array(
			'fields' => apply_filters('comment_form_default_fields', $fields),
			'comment_field' => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="3" aria-required="true" placeholder="Comment . . ."></textarea></div>',
			'logged_in_as' => '<div class="logged-in-as"><div class="user">' . sprintf( __('Logged in as <a href="%1$s">%2$s</a>.', 'easydocs'), admin_url( 'profile.php' ), $user_identity) . '</div><div class="log-out">' . sprintf( __('<a href="%3$s" title="Log out of this account">Log out?</a>', 'easydocs'), wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</div></div>',
			'title_reply' => __('Leave a Comment', 'easydocs'),
			'title_reply_to' => __('Reply to %s', 'easydocs')
		));
	?>

</div><!-- #comments -->
