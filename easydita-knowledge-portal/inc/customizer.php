<?php
/**
 * easydita_knowledge_portal Theme Customizer.
 *
 * @package easydita_knowledge_portal
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function easydita_knowledge_portal_customize_register( $wp_customize ) {

	class Example_Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        <label>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
	        <textarea rows="4" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
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

	/** Skin Selection **/
	$skins = easydita_knowledge_portal_get_all_skins();
	$wp_customize->add_section(
		'skin_select',
		array(
			'title' => __('Skin Selection', 'easydita_knowledge_portal'),
			'description' => __('Select a different skin to style your site. After changing the skin, please click the Save & Publish button then reload the page to make sure you get the correct options within the customizer.', 'easydita_knowledge_portal'),
			'priority' => 0
		)
	);
	$wp_customize->add_setting(
		'skin',
		array(
			'default' => "default",
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'skin',
		array(
			'label' => __('Available Skins', 'easydita_knowledge_portal'),
			'section' => 'skin_select',
			'type' => 'radio',
			'choices' => $skins,
			'priority' => 10
		)
	);


	/** Page Hierarchy Section **/
	$wp_customize->add_section(
		'page_hierarchy',
		array(
			'title' => __('Page Hierarchy', 'easydita_knowledge_portal'),
			'description' => __('Here you can select whether you wish to support versions in the page hierarchy. When "No" is selected, all the root pages will appear on the homepage. When "Yes" is selected, the root pages will determine the version of the content and a dropdown selector will appear in the top right hand corner for version selection. The subpages for that version will appear on the homepage.', 'easydita_knowledge_portal'),
			'priority' => 10
		)
	);
	$wp_customize->add_setting(
		'versioning_enabled',
		array(
			'default' => "no",
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'versioning_enabled',
		array(
			'label' => __('Versioning Enabled', 'easydita_knowledge_portal'),
			'section' => 'page_hierarchy',
			'type' => 'radio',
			'choices' => array(
						"yes" => "Yes",
						"no" => "No"),
			'priority' => 10
		)
	);


	/** Home Page Section **/
	$wp_customize->add_section(
		'home_page',
		array(
		  'title' => __('Home Page', 'easydita_knowledge_portal'),
		  'description' => __('Customize the home page. Note that not all settings may be available for all skins.', 'easydita_knowledge_portal'),
		  'priority' => 30,
		)
	);
	$wp_customize->add_setting(
		'browse_title',
		array(
			'default' => __("Browse Help Content", 'easydita_knowledge_portal'),
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'browse_title',
		array(
			'label' => __('Browse Content Title', 'easydita_knowledge_portal'),
			'description' => __('Set the title for your content.', 'easydita_knowledge_portal'),
			'section' => 'home_page',
			'type' => 'text',
			'priority' => 10
		)
	);

  /** Page Content **/
  $wp_customize->add_section(
    'page_content',
    array(
      'title' => __('Page Content', 'easydita_knowledge_portal'),
      'description' => __('Customize layout of content on page.', 'easydita_knowledge_portal'),
      'priority' => 40
    )
  );
  $wp_customize->add_setting(
    'move_short_desc',
    array(
      'default' => '',
      'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
    )
  );
  $wp_customize->add_control(
    'move_short_desc',
    array(
      'label' => __('Always keep Short Description with Title', 'easydita_knowledge_portal'),
      'section' => 'page_content',
      'type' => 'checkbox',
      'priority' => 10
    )
  );
  $wp_customize->add_setting(
    'topic_hierarchy_display',
    array(
      'default' => 1,
      'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
    )
  );
  $wp_customize->add_control(
    'topic_hierarchy_display',
    array(
      'label' => __('Display Child Topic Content with Parent Topic', 'easydita_knowledge_portal'),
      'section' => 'page_content',
      'type' => 'checkbox',
      'priority' => 10
    )
  );

	/** Main Color Section **/
	$wp_customize->add_section(
		'custom_colors',
		array(
		  'title' => __('Colors', 'easydita_knowledge_portal'),
		  'description' => __('Set the colors of the theme. Note that not all settings may be available for all skins.', 'easydita_knowledge_portal'),
		  'priority' => 25,
		)
	);
	$wp_customize->add_setting(
		'main_color',
		array(
			'default' => "#20a332",
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'main_color',
		array(
			'label'      => __('Main Accent Color', 'easydita_knowledge_portal'),
			'section'    => 'custom_colors',
			'settings'   => 'main_color',
			'priority'=>10
		) )
	);
	$wp_customize->add_setting(
		'search_header_text_color',
		array(
			'default' => "#ffffff",
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'search_header_text_color',
		array(
			'label'      => __('Search Header Text Color', 'easydita_knowledge_portal'),
			'section'    => 'custom_colors',
			'settings'   => 'search_header_text_color',
			'priority'   => 20
		) )
	);
	$wp_customize->add_setting(
		'footer_background_color',
		array(
			'default' => "#000000",
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'footer_background_color',
		array(
			'label'      => __('Footer Background Color', 'easydita_knowledge_portal'),
			'section'    => 'custom_colors',
			'settings'   => 'footer_background_color',
			'priority'   => 30
		) )
	);
	$wp_customize->add_setting(
		'footer_text_color',
		array(
			'default' => "#808080",
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'footer_text_color',
		array(
			'label'      => __('Footer Text Color', 'easydita_knowledge_portal'),
			'section'    => 'custom_colors',
			'settings'   => 'footer_text_color',
			'priority'   => 40
		) )
	);

	/** Search Info Section **/
	$wp_customize->add_section(
		'header_info',
		array(
		  'title' => __('Header Info', 'easydita_knowledge_portal'),
		  'description' => __('Customization for the Header and Search Text. Note that not all settings may be available for all skins.', 'easydita_knowledge_portal'),
		  'priority' => 40,
		)
	);
	$wp_customize->add_setting(
		'version_label',
		array(
		  'default' => __('Version: ', 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'version_label',
		array(
			'label'=>__('Version Label', 'easydita_knowledge_portal'),
			'description'=>__('Set the label to be placed in front of the version picker in the top right hand corner.', 'easydita_knowledge_portal'),
			'section'=>'header_info',
			'type'=>'text',
			'priority'=>5
		)
	);
	$wp_customize->add_setting(
		'search_placeholder',
		array(
		  'default' => __('Have a question? Ask or enter a search term.', 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'search_placeholder',
		array(
			'label'=>__('Search Placeholder', 'easydita_knowledge_portal'),
			'description'=>__('Set the placeholder for the search bar.', 'easydita_knowledge_portal'),
			'section'=>'header_info',
			'type'=>'text',
			'priority'=>10
		)
	);
	$wp_customize->add_setting(
		'search_header',
		array(
		  'default' => __('How can we help?', 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'search_header',
		array(
			'label'=>__('Search Header', 'easydita_knowledge_portal'),
			'description'=>__('Set the Title for the Search Header on the main page.', 'easydita_knowledge_portal'),
			'section'=>'header_info',
			'type'=>'text',
			'priority'=>20
		)
	);
	$wp_customize->add_setting(
		'search_header_text',
		array(
		  'default' => '',
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Example_Customize_Textarea_Control( $wp_customize, 'search_header_text', array(
		    'label'   => __('Search Header Text', 'easydita_knowledge_portal'),
		    'description' => __('Set the description text for the search header on the main page.', 'easydita_knowledge_portal'),
		    'section' => 'header_info',
		    'settings'   => 'search_header_text',
			'priority'=>30
			)
		)
	);

	/** TOC Title **/
	$wp_customize->add_section(
		'toc_info',
		array(
		  'title' => __('TOC Info', 'easydita_knowledge_portal'),
		  'description' => __('Customization for the Table of Contents. Note that not all settings may be available for all skins.', 'easydita_knowledge_portal'),
		  'priority' => 50,
		)
	);
	$wp_customize->add_setting(
		'toc_title',
		array(
		  'default' => __('TOC', 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'toc_title',
		array(
			'label'=>__('Title', 'easydita_knowledge_portal'),
			'description'=>__('Set the Title for the TOC', 'easydita_knowledge_portal'),
			'section'=>'toc_info',
			'type'=>'text',
			'priority'=>10
		)
	);
	/*$wp_customize->add_setting(
		'child_pages_title',
		array(
		  'default' => 'Child Pages',
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'child_pages_title',
		array(
			'label'=>__( 'Child Pages Title' , 'easydita_knowledge_portal'),
			'description'=>__( 'Set the Title for the child pages listed within the content' , 'easydita_knowledge_portal'),
			'section'=>'toc_info',
			'type'=>'text'
		)
	);*/


	/** Footer Content **/
	$wp_customize->add_section(
		'footer_info',
		array(
		  'title' => __('Footer Info', 'easydita_knowledge_portal'),
		  'description' => __('Set the content for your footer. Note that not all settings may be available for all skins.', 'easydita_knowledge_portal'),
		  'priority' => 60,
		)
	);
	$wp_customize->add_setting(
		'footer_html',
		array(
		  'default' => __('Copyright 2016', 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'wp_kses_data'
		)
	);
	$wp_customize->add_control(
		new Example_Customize_Textarea_Control( $wp_customize, 'textarea_setting', array(
		    'label'   => __('Contact Info', 'easydita_knowledge_portal'),
		    'section' => 'footer_info',
		    'settings'   => 'footer_html',
			'priority'=>10
			)
		)
	);
	// Facebook
	$wp_customize->add_setting(
		'facebook_link',
		array(
		  'default' => '#',
		  'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control(
		'facebook_link',
		array(
			'label'=>__('Facebook', 'easydita_knowledge_portal'),
			'description'=>__('Set the URL to navigate to when the user clicks on the Facebook icon (if shown)', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'text',
			'priority'=>20
		)
	);
	$wp_customize->add_setting(
		'facebook_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
		)
	);
	$wp_customize->add_control(
		'facebook_enabled',
		array(
			'label'=>__('Display link to Facebook?', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'checkbox',
			'priority'=>25
		)
	);
	// Twitter
	$wp_customize->add_setting(
		'twitter_link',
		array(
		  'default' => '#',
		  'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control(
		'twitter_link',
		array(
			'label'=>__('Twitter', 'easydita_knowledge_portal'),
			'description'=>__('Set the URL to navigate to when the user clicks on the Twitter icon (if shown)', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'text',
			'priority'=>30
		)
	);
	$wp_customize->add_setting(
		'twitter_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
		)

	);
	$wp_customize->add_control(
		'twitter_enabled',
		array(
			'label'=>__('Display link to Twitter?', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'checkbox',
			'priority'=>35
		)
	);
	// Google Plus
	$wp_customize->add_setting(
		'google_link',
		array(
		  'default' => '#',
		  'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control(
		'google_link',
		array(
			'label'=>__('Google+', 'easydita_knowledge_portal'),
			'description'=>__('Set the URL to navigate to when the user clicks on the Google+ icon (if shown)', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'text',
			'priority'=>40
		)
	);
	$wp_customize->add_setting(
		'google_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
		)
	);
	$wp_customize->add_control(
		'google_enabled',
		array(
			'label'=>__('Display link to Google+?', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'checkbox',
			'priority'=>45
		)
	);
	// LinkedIn
	$wp_customize->add_setting(
		'linkedin_link',
		array(
		  'default' => '#',
		  'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control(
		'linkedin_link',
		array(
			'label'=>__('LinkedIn', 'easydita_knowledge_portal'),
			'description'=>__('Set the URL to navigate to when the user clicks on the LinkedIn icon (if shown)', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'text',
			'priority'=>50
		)
	);
	$wp_customize->add_setting(
		'linkedin_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
		)
	);
	$wp_customize->add_control(
		'linkedin_enabled',
		array(
			'label'=>__('Display link to LinkedIn?', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'checkbox',
			'priority'=>55
		)
	);

	// YouTube
	$wp_customize->add_setting(
		'youtube_link',
		array(
		  'default' => '#',
		  'sanitize_callback' => 'esc_url'
		)
	);
	$wp_customize->add_control(
		'youtube_link',
		array(
			'label'=>__('YouTube', 'easydita_knowledge_portal'),
			'description'=>__('Set the URL to navigate to when the user clicks on the YouTube icon (if shown)', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'text',
			'priority'=>60
		)
	);
	$wp_customize->add_setting(
		'youtube_enabled',
		array(
			'default' => 1,
			'sanitize_callback' => 'easydita_knowledge_portal_is_boolean'
		)
	);
	$wp_customize->add_control(
		'youtube_enabled',
		array(
			'label'=>__('Display link to YouTube?', 'easydita_knowledge_portal'),
			'section'=>'footer_info',
			'type'=>'checkbox',
			'priority'=>65
		)
	);

	/** 404 Page Info **/
	$wp_customize->add_section(
		'404_page',
		array(
		  'title' => __('404 Page Text', 'easydita_knowledge_portal'),
		  'description' => __('Customization for the text shown on the 404 error page not found page.', 'easydita_knowledge_portal'),
		  'priority' => 70,
		)
	);
	$wp_customize->add_setting(
		'404_header',
		array(
		  'default' => __("Oops! That page can't be found.", 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		'404_header',
		array(
			'label'=>__('Header Text', 'easydita_knowledge_portal'),
			'description'=>__('Set the text for the header of the 404 page.', 'easydita_knowledge_portal'),
			'section'=>'404_page',
			'type'=>'text',
			'priority'=>10
		)
	);
	$wp_customize->add_setting(
		'404_text',
		array(
		  'default' => __("It looks like nothing was found at this location. Maybe try a search or one of the popular pages below? Or you can always escape back to the home page by clicking the logo in the top left.", 'easydita_knowledge_portal'),
		  'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control(
		new Example_Customize_Textarea_Control( $wp_customize, '404_text', array(
		    'label'   => __('Body Text', 'easydita_knowledge_portal'),
		    'description' => __('Set the text for the body of the 404 page.', 'easydita_knowledge_portal'),
		    'section' => '404_page',
		    'settings'   => '404_text',
			'priority' => 20
			)
		)
	);
}
add_action( 'customize_register', 'easydita_knowledge_portal_customize_register' );

/*
 * Sanitization functions
 */
function easydita_knowledge_portal_is_boolean($value) {
	if ($value == 0) {
		return 0;
	} else {
		return 1;
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function easydita_knowledge_portal_customize_preview_js() {
	wp_enqueue_script( 'easydita_knowledge_portal_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'easydita_knowledge_portal_customize_preview_js' );

/**
 * Generates live CSS
 **/
function build_customize_css()
{
    ?>
         <style type="text/css">
             .child-page-entry .entry-header a,
             #masthead > div[class*="menu-"] ul.menu li a:hover,
             .site-footer .social i,
             .widget_popular_pages_widget .popular-link,
             .search-result .entry-header a,
             .search-result .entry-url a,
             .faq-title,
             .faq.open .faq-icon:before,
             .topic-section > .topic-title,
             .content-title,
             .toc .parent-item .parent-item > a,
             h1.topic-title,
             .posts-navigation a:hover {
             	color:<?php echo get_theme_mod('main_color', '#20a332'); ?>;
             }

             footer.site-footer .social a {
             	border-color:<?php echo get_theme_mod('main_color','#20a332'); ?>;
             }

             .home-search,
             .small-search {
             	background-color:<?php echo get_theme_mod('main_color', '#20a332'); ?>;
             }

             .home-search {
             	color:<?php echo get_theme_mod('search_header_text_color', '#ffffff'); ?>;
             }

             .site-footer, .site-footer .user-text {
             	background-color:<?php echo get_theme_mod('footer_background_color', '#000000'); ?>;
             	color:<?php echo get_theme_mod('footer_text_color', '#808080'); ?>;
             }

         </style>
    <?php
}
add_action( 'wp_head', 'build_customize_css');
