<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="user-text">
	  		<?php echo preg_replace("/^(.*?)<br\/>/",'<span class="title">$1</span><br/>',preg_replace("/\s*\n\s*/","<br/>",get_theme_mod( 'footer_html', 'Copyright 2015' ))) ?>
  		</div>
  		<div class="social">
  			<div class="title">Social</div>
  			<?php if (get_theme_mod('facebook_enabled') == 1) : ?>
  				<a href="<?php echo get_theme_mod('facebook_link','#') ?>" target="_blank"><i class="facebook-icon"></i></a>
  			<?php endif ?>
  			<?php if (get_theme_mod('twitter_enabled') == 1) : ?>
  				<a href="<?php echo get_theme_mod('twitter_link','#') ?>" target="_blank"><i class="twitter-icon"></i></a>
  			<?php endif ?>
  			<?php if (get_theme_mod('google_enabled') == 1) : ?>
  				<a href="<?php echo get_theme_mod('google_link','#') ?>" target="_blank"><i class="google-icon"></i></a>
  			<?php endif ?>
  			<?php if (get_theme_mod('linkedin_enabled') == 1) : ?>
  				<a href="<?php echo get_theme_mod('linkedin_link','#') ?>" target="_blank"><i class="linkedin-icon"></i></a>
  			<?php endif ?>
  		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
