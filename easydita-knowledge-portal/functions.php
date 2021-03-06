<?php
/**
 * easy WordPress Docs functions and definitions.
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package easydita_knowledge_portal
 */

if ( ! function_exists( 'easydita_knowledge_portal_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function easydita_knowledge_portal_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'easydita_knowledge_portal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'header-menu' => esc_html__( 'Header Menu', 'easydita_knowledge_portal' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'easydita_knowledge_portal_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // easydita_knowledge_portal_setup
add_action( 'after_setup_theme', 'easydita_knowledge_portal_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function easydita_knowledge_portal_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'easydita_knowledge_portal_content_width', 640 );
}
add_action( 'after_setup_theme', 'easydita_knowledge_portal_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function easydita_knowledge_portal_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'easydita_knowledge_portal' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div class="widget-container"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'easydita_knowledge_portal_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function easydita_knowledge_portal_scripts() {
	wp_enqueue_style( 'easydita-knowledge-portal-style', get_stylesheet_uri() );

	wp_enqueue_script( 'easydita-knowledge-portal-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'easydita-knowledge-portal-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'easydita_knowledge_portal_scripts' );

/**
 * Allow changing of default version number on style.css to circumvent caching
 * This should always be commented out in production
 */
function easydita_knowledge_portal_change_style_version_num($styles) {
	$styles -> default_version = "123";
}
//add_action("wp_default_styles", "easydita_knowledge_portal_change_style_version_num");

/**
 * Is Versioning Enabled?
 **/
if (!function_exists('easydita_knowledge_portal_is_versioning_enabled')) {
	function easydita_knowledge_portal_is_versioning_enabled() {
		return get_theme_mod('versioning_enabled','no') == 'yes';
	}
}
/***
 * Hierarchy Functions
 ***/
// Walk the hierarchy and return an array of IDs
if (!function_exists('easydita_knowledge_portal_get_hierarchy')) {
	function easydita_knowledge_portal_get_hierarchy() {
		global $post;
		$hierarchy = array();
		if($post->ID) {
			$hierarchy[] = $post->ID;
			
			$parent_id = $post->post_parent;
	
			while ($parent_id) {
				$hierarchy[] = $parent_id;
				$page = get_page($parent_id);
				$parent_id = $page->post_parent;
			}
			return array_reverse($hierarchy);
		}
		return array(0);
	}
}
if (!function_exists('easydita_knowledge_portal_get_hierarchy_of')) {
	function easydita_knowledge_portal_get_hierarchy_of($post) {
		$hierarchy = array();
		if($post->ID) {
			$hierarchy[] = $post->ID;
			
			$parent_id = $post->post_parent;
	
			while ($parent_id) {
				$hierarchy[] = $parent_id;
				$page = get_page($parent_id);
				$parent_id = $page->post_parent;
			}
			return array_reverse($hierarchy);
		}
		return array(0);
	}
}
if (!function_exists('easydita_knowledge_portal_get_root_map_id')) {
	function easydita_knowledge_portal_get_root_map_id() {
		/** get the title for the root map this is a member of **/
		$hierarchy = easydita_knowledge_portal_get_hierarchy();
		if (easydita_knowledge_portal_is_versioning_enabled()) {
	    	return $hierarchy[1];
    	} else {
    		return $hierarchy[0];
    	}
	}
}

/**
 * Get version id
 **/
if (!function_exists('easydita_knowledge_portal_get_version_id')) {
	function easydita_knowledge_portal_get_version_id() {
		if (!easydita_knowledge_portal_is_versioning_enabled()) {
			return 0;
		} else if (isset($_GET['version'])) {
			$versionId = $_GET['version'];
		} else if (is_front_page()) {
			$versionId = get_pages("parent=0&post_type=page&sort_column=menu_order")[0]->ID;
		} else {
			$hierarchy = easydita_knowledge_portal_get_hierarchy();
			$versionId = $hierarchy[0];
		}
		return $versionId;
	}
}
if (!function_exists('easydita_knowledge_portal_get_version_id_of')) {
	function easydita_knowledge_portal_get_version_id_of($post) {
		if (!easydita_knowledge_portal_is_versioning_enabled()) {
			return 0;
		} else {
			$hierarchy = easydita_knowledge_portal_get_hierarchy_of($post);
			$versionId = $hierarchy[0];
			return $versionId;
		}
	}
}
// Get the list of page IDs in a given version hierarchy (all children and descendants of a version)
if (!function_exists('easydita_knowledge_portal_get_ids_in_version')) {
	function easydita_knowledge_portal_get_ids_in_version($version) {
		$pages_list = get_pages( array( 'child_of' => $version ) );
		$ids_list = [];
		foreach ($pages_list as $page) {
			array_push($ids_list, $page->ID);
		}
		return $ids_list;
	}
}

/***
 * Get all subsections (for Tutorials)
 ***/
if (!function_exists('easydita_knowledge_portal_get_subsections')) {
	function easydita_knowledge_portal_get_subsections() {
		global $post;
		$content = $post->post_content;
		preg_match_all('#<h1[^>]*class="[^"]*topic-title [^"]*"[^>]*>((<h1.*?>.*?</h1>)|(.))*?</h1>#', $content, $matches);
		return $matches[0];
	}
}


/**
 * get the short description
 **/
if (!function_exists('easydita_knowledge_portal_get_the_shortdesc')) {
	function easydita_knowledge_portal_get_the_shortdesc() {
		global $post;
		if ($post->post_content != '') {
			preg_match('#<div[^>]*class="[^"]*topic-shortdesc [^"]*"[^>]*>((<div.*?>.*?</div>)|(.))*?</div>#', $post->post_content, $matches);
			$output = preg_replace('#<[^>]*>#','',$matches[0]);
			echo $output;
		} else {
			$out_string = "";
			$args = array(
				"post_type" => "page",
				"post_parent" => $post->ID,
				"orderby" => "menu_order",
				"order" => "ASC"
			);
			$the_query = new WP_Query( $args );
			$count = $the_query->post_count;
			$i = 1;
			while($the_query->have_posts()) {
				$the_query->the_post();
				
				?><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a><?php
				
				if ($i != $count) {
					echo ", ";
				}
				$i++;
			}
			wp_reset_query();
			wp_reset_postdata();
		}
	}
}


if (!function_exists('easydita_knowledge_portal_get_collection_type')) {
	function easydita_knowledge_portal_get_collection_type() {
    global $post;
    $content = $post->post_content;
    $DOM = new DOMDocument();
    $DOM->loadHTML($content);
    $coll = $DOM->getElementById('collection');
    $val = $coll->getAttribute('value');
    return $val;
  }
}


if (!function_exists('easydita_knowledge_portal_get_404_content')) {
	function easydita_knowledge_portal_get_404_content() {
		?>
		<div class="home-search">
			<div class="header"><?php echo get_theme_mod( '404_header', __('Oops! That page can&rsquo;t be found.', 'easydita_knowledge_portal') ); ?></div>
		    <div class="text"><?php echo get_theme_mod( '404_text', __('It looks like nothing was found at this location. Maybe try a search or one of the popular pages below? Or you can always escape back to the home page by clicking the logo in the top left.', 'easydita_knowledge_portal')); ?></div>
		    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	          <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', __('Have a question? Ask or enter a search term.', 'easydita_knowledge_portal') ); ?>" />
	  		  <button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
	          </form>
	          <style type="text/css">.small-search {display: none;}</style>
		</div>
		<?php
	}
}

/**
 * Add Google Analytics stuff to wp_head
**/
function easydita_knowledge_portal_insert_ga_info() {
	echo "<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-68186023-1', 'auto');
		  ga('require', 'linkid');
		  ga('send', 'pageview');
		
		</script>";
}
add_action('wp_head','easydita_knowledge_portal_insert_ga_info');

/**
 * Get the list of available skins
**/
if (!function_exists('easydita_knowledge_portal_get_all_skins')) {
	function easydita_knowledge_portal_get_all_skins() {
		$root_url = get_template_directory_uri()."/skins/";
		$root_folder = dirname(__FILE__)."/skins/";
		$skins = array(
			"default" => "Default"
		);
		if (!file_exists($root_folder)) {
			return $skins;
		}
		$skin_files = scandir($root_folder);
		foreach ($skin_files as $i => $file) {
			if (strlen($file) < 4 || substr($file,strlen($file)-4) != '.css') {
				continue;
			}
			$contents = wp_remote_get($root_url.$file)['body'];
			$title = preg_match("/\/\*\n\s*Skin Name:\s*(.*?)(\n|Author:)/",$contents,$matches);
			$version = preg_match("/\/\*(\n|.)*?Version:\s*(.*?)(\n)/",$contents,$version_matches);
			if ($title != "") {
				$skins[$file."?ver=".$version_matches[2]] = $matches[1];
			};
		}
		return $skins;
	}
}

/**
 * Custom pagination functions
 * Copied from the default WP get_the_posts_pagination functions, however, added parameter 
 * for the query instead of using the global $wp_query.
 * This was needed for the search since we're using a custom query.
 **/
if (!function_exists('easydita_knowledge_portal_the_posts_pagination')) {
	function easydita_knowledge_portal_the_posts_pagination( $the_query, $args = array() ) {
	    echo easydita_knowledge_portal_get_the_posts_pagination( $the_query, $args );
	}
}
if (!function_exists('easydita_knowledge_portal_get_the_posts_pagination')) {
	function easydita_knowledge_portal_get_the_posts_pagination( $the_query, $args = array() ) {
	    $navigation = '';
	 
	    // Don't print empty markup if there's only one page.
	    if ( $the_query->max_num_pages > 1 ) {
	        $args = wp_parse_args( $args, array(
	            'mid_size'           => 1,
	            'prev_text'          => _x( 'Previous', 'previous post' ),
	            'next_text'          => _x( 'Next', 'next post' ),
	            'screen_reader_text' => __( 'Posts navigation' ),
	        ) );
	 
	        // Make sure we get a string back. Plain is the next best thing.
	        if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
	            $args['type'] = 'plain';
	        }
	 
	        // Set up paginated links.
	        $links = paginate_links( $args );
	 
	        if ( $links ) {
	            $navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'] );
	        }
	    }
	 
	    return $navigation;
	}
}

/**
 * Add the skin to the header if necessary
 **/
function easydita_knowledge_portal_add_skin_stylesheet() {
	$skin = get_theme_mod('skin','default');
	if ($skin != 'default') {
		$href = get_template_directory_uri()."/skins/".$skin;
		echo '<link rel="stylesheet" type="text/css" href="'.$href.'"/>';
	}
}
add_action('wp_head','easydita_knowledge_portal_add_skin_stylesheet');

/**
 * Add the 'reset_toc' query variable so Wordpress won't mangle it.
 **/
function easydita_knowledge_portal_add_query_vars($vars){
    $vars[] = "reset_toc";
    $vars[] = "guide_id";
    return $vars;
}
add_filter( 'query_vars', 'easydita_knowledge_portal_add_query_vars');

/**
 * Add JQuery
 **/
wp_enqueue_script("jquery");

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add custom PHP from skin
 **/
if (get_theme_mod('skin','default') != 'default') {
	$skinname = explode(".css",get_theme_mod('skin','default'),2)[0];
	$php_path = get_template_directory() . "/skins/" . $skinname . "/" . $skinname . ".php";
	if (file_exists($php_path)) {
		require $php_path;
	}
}
