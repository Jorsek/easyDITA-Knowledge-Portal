<?php

function add_custom_fonts() {
	echo "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600,700,700italic|Roboto+Slab:300,700' rel='stylesheet' type='text/css'>";
}
add_action('wp_head','add_custom_fonts');

function skin1_customizer( $wp_customize) {
	
	// Remove unused controls:
	$wp_customize -> remove_control("search_header_text_color");
	$wp_customize -> remove_section("home_page");
	$wp_customize -> remove_control("search_header");
	$wp_customize -> remove_control("search_header_text");
	$wp_customize -> remove_section("toc_info");
	
	// Secondary accent color
	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default' => "#1A578E",
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'secondary_color', 
		array(
			'label'      => __( 'Secondary Accent Color' , 'easydocs'),
			'section'    => 'custom_colors',
			'settings'   => 'secondary_color',
			'priority'   => 20
		) ) 
	);
	
	// Background image (for header and footer)
	$wp_customize->add_section(
		'header_bg',
		array(
		  'title' => __('Background Image', 'easydocs'),
		  'description' => __('Set the background image or color for the search bar header and home page footer.', 'easydocs'),
		  'priority' => 59,
		)
	);
	$wp_customize->add_setting(
		'bg_image',
		array(
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Upload_Control( $wp_customize, 'bg_image', 
			array(
				'label'      => __('Background Image', 'easydocs'),
				'section'    => 'header_bg',
				'settings'   => 'bg_image',
			)
		)
	);
	
}
add_action( 'customize_register', 'skin1_customizer' );

function add_custom_css()
{
    ?>
         <style type="text/css">
             .faq.open .faq-head,
             .topic-topic th,
             .topic-topic td:before,
             .task-step .topic-itemgroup .legend,
             .toc > .open > .toc-list > .toc-item.parent-item > .toc-head,
             #main .thumbnail-links > .subpage:hover,
             #searchform .submit:hover {
             	background-color:<?php echo get_theme_mod('main_color', '#20a332'); ?> !important;
             }
             
             .widget-container .widget-title,
             .entry-content .root-title {
             	color:<?php echo get_theme_mod('main_color', '#20a332'); ?> !important;
             }
             
             
             .topic-topic th,
             footer.site-footer .user-text .title,
             .toc > .open > .toc-list > .toc-item > .toc-head:hover,
             .toc .toc-list .toc-list .toc-item > .toc-head > a:hover,
             .toc .toc-list .toc-list .toc-item.parent-item > .toc-head > a,
             .child-page-entry .entry-summary a:hover,
             .topic-topic a {
             	color:<?php echo get_theme_mod('secondary_color', '#1A578E'); ?> !important;
             }
             
             .entry-content .content-child-pages .child-page-entry .entry-header a,
             .entry-content .concatenated-content .content-title,
             .faq.closed .faq-head:hover,
             #secondary div.widget-container .widget a:hover,
             #main .search-result .entry-header a,
             #main .search-result .entry-url a,
             .topic-topic h1.topic-title {
             	color:<?php echo get_theme_mod('secondary_color', '#1A578E'); ?>;
             }
             
             #page .home-search,
             #page .small-search,
             footer.site-footer.home .social {
             	<?php
             		$url = get_theme_mod('bg_image');
             		if ($url == '') {
             			$url = get_template_directory_uri() . "/skins/skin1/BGPattern2.png";
             		}
             	?>
             	background: url('<?php echo $url; ?>');
             }
             
         </style>
    <?php
}
add_action( 'wp_head', 'add_custom_css');

function get_404_content() {
	?>
	<h2 class="header"><?php echo get_theme_mod( '404_header', __('Oops! That page can&rsquo;t be found.', 'easydocs') ); ?></h2>
    <div class="text"><?php echo get_theme_mod( '404_text', __('It looks like nothing was found at this location. Maybe try a search or one of the popular pages below? Or you can always escape back to the home page by clicking the logo in the top left.', 'easydocs')); ?></div>
	<?php
}

?>