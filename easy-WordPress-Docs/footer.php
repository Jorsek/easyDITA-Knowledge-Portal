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
	  <?php echo get_theme_mod( 'footer_html', '<div class="group1">Copyright 2015</div><div class="group2"><div class="social"><div class="title">Social</div><a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="#" target="_blank"><i class="fa fa-twitter-square"></i></a><a href="#" target="_blank"><i class="fa fa-google-plus-square"></i></a><a href="#" target="_blank"><i class="fa fa-linkedin-square"></i></a></div></div>' ) ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
