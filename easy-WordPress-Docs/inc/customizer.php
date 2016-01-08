<?php
/**
 * _s Theme Customizer.
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function _s_customize_register( $wp_customize ) {

	class Example_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
	        <textarea rows="15" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	        </label>
	        <?php
	    }
	}

	/*
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_backgroundcolor' )->transport = 'postMessage';
	*/
	
	// Remove defaults
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('background_image');
	$wp_customize->remove_section('static_front_page');
	//not working:
	$wp_customize->remove_section('nav');
	
	/** Home Page Section **/
	$wp_customize->add_section(
		'home_page',
		array(
		  'title' => 'Home Page',
		  'description' => 'Customize the home page.',
		  'priority' => 30,
		)
	);
	$wp_customize->add_setting(
		'browse_title',
		array(
			'default' => "Browse Help Content"
		)
	);
	$wp_customize->add_control(
		'browse_title',
		array(
			'label'=>__( 'Browse Content Title' ),
			'description'=>__( 'Set the title for your content.' ),
			'section'=>'home_page',
			'type'=>'text'
		)
	);
	
	/** Main Color Section **/
	$wp_customize->add_section(
		'custom_colors',
		array(
		  'title' => 'Colors',
		  'description' => 'Set the colors of the theme',
		  'priority' => 35,
		)
	);
	$wp_customize->add_setting(
		'main_color',
		array(
			'default' => "#20a332"
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'main_color', 
		array(
			'label'      => __( 'Main Accent Color', 'easyDocs' ),
			'section'    => 'custom_colors',
			'settings'   => 'main_color',
		) ) 
	);
	$wp_customize->add_setting(
		'search_header_text_color',
		array(
			'default' => "#ffffff"
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'search_header_text_color', 
		array(
			'label'      => __( 'Search Header Text Color', 'easyDocs' ),
			'section'    => 'custom_colors',
			'settings'   => 'search_header_text_color',
		) ) 
	);
	$wp_customize->add_setting(
		'footer_background_color',
		array(
			'default' => "#000000"
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'footer_background_color', 
		array(
			'label'      => __( 'Footer Background Color', 'easyDocs' ),
			'section'    => 'custom_colors',
			'settings'   => 'footer_background_color',
		) ) 
	);
	$wp_customize->add_setting(
		'footer_text_color',
		array(
			'default' => "#808080"
		)
	);
	$wp_customize->add_control( 
		new WP_Customize_Color_Control( 
		$wp_customize, 
		'footer_text_color', 
		array(
			'label'      => __( 'Footer Text Color', 'easyDocs' ),
			'section'    => 'custom_colors',
			'settings'   => 'footer_text_color',
		) ) 
	);
	
	/** Search Info Section **/
	$wp_customize->add_section(
		'search_info',
		array(
		  'title' => 'Search Info',
		  'description' => 'Customization for the Search Header and Text',
		  'priority' => 35,
		)
	);
	$wp_customize->add_setting(
		'search_header',
		array(
		  'default' => 'How can we help?',
		)
	);
	$wp_customize->add_control(
		'search_header',
		array(
			'label'=>__( 'Search Header' ),
			'description'=>__( 'Set the Title for the Search Header on the main page.' ),
			'section'=>'search_info',
			'type'=>'text'
		)
	);
	$wp_customize->add_setting(
		'search_header_text',
		array(
		  'default' => '',
		)
	);
	$wp_customize->add_control(
		new Example_Customize_Textarea_Control( $wp_customize, 'search_header_text', array(
		    'label'   => 'Search Header Text',
		    'description' => 'Set the description text for the search header on the main page.',
		    'section' => 'search_info',
		    'settings'   => 'search_header_text',
			)
		)
	);
	$wp_customize->add_setting(
		'search_placeholder',
		array(
		  'default' => 'Have a question? Ask or enter a search term.',
		)
	);
	$wp_customize->add_control(
		'search_placeholder',
		array(
			'label'=>__( 'Search Placeholder' ),
			'description'=>__( 'Set the placeholder for the search bar.' ),
			'section'=>'search_info',
			'type'=>'text'
		)
	);
	
	/** TOC Title **/
	$wp_customize->add_section(
		'toc_info',
		array(
		  'title' => 'TOC Info',
		  'description' => 'Customization for the Table of Contents',
		  'priority' => 35,
		)
	);
	$wp_customize->add_setting(
		'toc_title',
		array(
		  'default' => 'TOC',
		)
	);
	$wp_customize->add_control(
		'toc_title',
		array(
			'label'=>__( 'Title' ),
			'description'=>__( 'Set the Title for the TOC' ),
			'section'=>'toc_info',
			'type'=>'text'
		)
	);
	$wp_customize->add_setting(
		'child_pages_title',
		array(
		  'default' => 'Child Pages',
		)
	);
	$wp_customize->add_control(
		'child_pages_title',
		array(
			'label'=>__( 'Child Pages Title' ),
			'description'=>__( 'Set the Title for the child pages listed within the content' ),
			'section'=>'toc_info',
			'type'=>'text'
		)
	);
	
	
	/** Footer Content **/
	$wp_customize->add_section(
		'footer_info',
		array(
		  'title' => 'Footer Info',
		  'description' => 'Set the content for your footer.',
		  'priority' => 35,
		)
	);
	$wp_customize->add_setting(
		'footer_html',
		array(
		  'default' => '<div class="group1">Copyright 2015</div><div class="group2"><div class="social"><div class="title">Social</div><span rel="facebook">FB</span><span rel="twitter">TW</span><span rel="google">G+</span><span rel="pinterest">PT</span></div></div>',
		)
	);
	$wp_customize->add_control(
		new Example_Customize_Textarea_Control( $wp_customize, 'textarea_setting', array(
		    'label'   => 'Footer HTML',
		    'section' => 'footer_info',
		    'settings'   => 'footer_html',
			)
		)
	);
}
add_action( 'customize_register', '_s_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _s_customize_preview_js() {
	wp_enqueue_script( '_s_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', '_s_customize_preview_js' );

/**
 * Generates live CSS
 **/
function build_customize_css()
{
    ?>
         <style type="text/css">
             .content-title,
             .topic-section > .topic-title,
             .faq.open .faq-icon:before,
             .faq-title,
             .search-result .entry-header a,
             .search-result .entry-url a,
             .toc .parent-item .parent-item > a,
             .widget_popular_pages_widget .popular-link {
             	color:<?php echo get_theme_mod('main_color', '#20a332'); ?> !important;
             }
             
             .home-search,
             .small-search {
             	background-color:<?php echo get_theme_mod('main_color', '#20a332'); ?> !important;
             }
             
             .home-search {
             	color:<?php echo get_theme_mod('search_header_text_color', '#ffffff'); ?>;
             }
             
             .site-footer {
             	background-color:<?php echo get_theme_mod('footer_background_color', '#000000'); ?> !important;
             	color:<?php echo get_theme_mod('footer_text_color', '#808080'); ?> !important;
             }
             
         </style>
    <?php
}
add_action( 'wp_head', 'build_customize_css');
