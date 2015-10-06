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
	  <?php echo get_theme_mod( 'footer_html', '<div class="group1">Copyright 2015</div><div class="group2"><div class="social"><div class="title">Social</div><span rel="facebook">FB</span><span rel="twitter">TW</span><span rel="google">G+</span><span rel="pinterest">PT</span></div></div>' ) ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
