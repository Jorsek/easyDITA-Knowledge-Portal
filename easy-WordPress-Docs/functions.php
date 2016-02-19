<?php
/**
 * _s functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

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
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'header-menu' => esc_html__( 'Header Menu', 'easy-WordPress-Docs' ),
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
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div class="widget-container"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );

/***
 * Hierarchy Functions
 ***/
// Walk the hierarchy and return an array of IDs
function get_hierarchy() {
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
function get_root_map_id() {
	/** get the title for the root map this is a member of **/
	$hierarchy = get_hierarchy();
    return $hierarchy[0];
}

/***
 * Get all subsections (for Tutorials)
 ***/
function get_subsections() {
	global $post;
	$content = $post->post_content;
	preg_match_all('#<h1[^>]*class="[^"]*topic-title [^"]*"[^>]*>((<h1.*?>.*?</h1>)|(.))*?</h1>#', $content, $matches);
	return $matches[0];
}


/**
 * get the short description
 **/
function get_the_shortdesc() {
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
			?>
			<a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a>
			<?php
			if ($i != $count) {
				echo ", ";
			}
			$i++;
		}
		wp_reset_query();
		wp_reset_postdata();
	}
}

function get_404_content() {
	?>
	<div class="home-search">
		<div class="header"><?php echo get_theme_mod( '404_header', 'Oops! That page can&rsquo;t be found.' ); ?></div>
	    <div class="text"><?php echo get_theme_mod( '404_text', 'It looks like nothing was found at this location. Maybe try a search or one of the popular pages below? Or you can always escape back to the home page by clicking the logo in the top left.'); ?></div>
	    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
          <input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php echo get_theme_mod( 'search_placeholder', 'Have a question? Ask or enter a search term.' ); ?>" />
  		  <button type="submit" class="submit" name="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
          </form>
	</div>
	<?php
}

/**
 * Add Google Analytics stuff to wp_head
**/
function insert_ga_info() {
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
add_action('wp_head','insert_ga_info');

/**
 * Get the list of available skins
**/
function get_all_skins() {
	$root_url = dirname(__FILE__)."/skins/";
	$skins = array(
		"default" => "Default"
	);
	if (!file_exists($root_url)) {
		return $skins;
	}
	$skin_files = scandir($root_url);
	foreach ($skin_files as $i => $file) {
		$contents = file_get_contents($root_url.$file);
		$title = preg_match("/\/\*\n\s*Skin Name:\s*(.*?)(\n|Author:)/",$contents,$matches);
		$version = preg_match("/\/\*(\n|.)*?Version:\s*(.*?)(\n)/",$contents,$version_matches);
		if ($title != "") {
			$skins[$file."?ver=".$version_matches[2]] = $matches[1];
		};
	}
	return $skins;
}

/**
 * Add the skin to the header if necessary
 **/
function add_skin_stylesheet() {
	$skin = get_theme_mod('skin','default');
	if ($skin != 'default') {
		$href = get_template_directory_uri()."/skins/".$skin;
		echo '<link rel="stylesheet" type="text/css" href="'.$href.'"/>';
	}
}
add_action('wp_head','add_skin_stylesheet');

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
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

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
