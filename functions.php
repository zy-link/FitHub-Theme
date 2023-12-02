<?php
/**
 * Fithub Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fithub_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

// login and wp dashboard customization
// login logo change
// login logo change
function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {

			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/icons/fithub.svg);
			height:140px;
			width:140px;
			background-size: 140px 140px;
			background-repeat: no-repeat;
			padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// change login url of logo
function my_login_logo_url() {
	// return home_url();
    return 'https://codex.wordpress.org/Customizing_the_Login_Form';
	// works with any links
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Custom Title';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

// calling style-login.css
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

// customize dashboard widgets
//add a custom dashboard widget for admins
add_action('wp_dashboard_setup', 'my_custom_dashboard_widget');
  
function my_custom_dashboard_widget() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_fun_widget', 'Backend tutorial', 'custom_dashboard_fun');
}
 
function custom_dashboard_fun() {
	echo '<iframe  src="https://www.youtube.com/embed/V4tucbc-FuA?si=WxzGh5WcgzRTFYCk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
}

// remove default dashboards outside of using screen options
function remove_dashboard_meta() {
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
	remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
}
add_action('admin_init', 'remove_dashboard_meta');

// END OF CODE DEMO

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fithub_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Fithub Theme, use a find and replace
		* to change 'fithub-theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'fithub-theme', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'header' => esc_html__('Header Menu Location', 'fithub'),
			'footer' => esc_html__('Footer Menu Location', 'fithub'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fithub_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'fithub_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fithub_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fithub_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'fithub_theme_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function fithub_theme_scripts() {
	wp_enqueue_style( 'fithub-theme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'fithub-theme-style', 'rtl', 'replace' );

	wp_enqueue_script( 'fithub-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fithub_theme_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Register CPTs and Taxonomies
 */
require get_template_directory() . '/inc/cpt-taxonomy.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Keep Length of Excerpt to 25
function fithub_theme_excerpt_length($length)
{
	if ( !is_front_page() && is_home() ) {
		return 55;
	} else {
		return 20;
	}
}
add_filter('excerpt_length', 'fithub_theme_excerpt_length', 999);

// Modify the end of the excerpt
function fithub_theme_excerpt_more($more)
{
	if ( !is_front_page() && is_home() ) {
		$more = '... <a href="' . esc_url(get_permalink()) . '">Read More</a>';
	}
	return $more;
}
add_filter('excerpt_more', 'fithub_theme_excerpt_more');

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );