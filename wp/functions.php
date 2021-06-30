<?php
/**
 * ai-land functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ai-land
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'ai_land_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ai_land_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ai-land, use a find and replace
		 * to change 'ai-land' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ai-land', get_template_directory() . '/languages' );

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
				'menu-1' => esc_html__( 'Primary', 'ai-land' ),
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
				'ai_land_custom_background_args',
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
endif;
add_action( 'after_setup_theme', 'ai_land_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ai_land_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ai_land_content_width', 640 );
}
add_action( 'after_setup_theme', 'ai_land_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ai_land_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ai-land' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ai-land' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ai_land_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ai_land_scripts() {
	wp_enqueue_style( 'ai-land-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ai-land-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ai-land-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ai_land_scripts' );

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
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

define('AI_LAND_PATH_CSS', get_template_directory_uri() . '/assets/css/');
define('AI_LAND_PATH_JS', get_template_directory_uri() . '/assets/js/');

add_action('wp_enqueue_scripts', function() {
	wp_enqueue_style('ai-land-application-css', AI_LAND_PATH_CSS . 'application.css');
	wp_enqueue_script('ai-land-application-js', AI_LAND_PATH_JS . 'application.js', [], '1.0', true);
});

add_action('after_setup_theme', function() {
	register_nav_menu('header', 'Header menu');
	register_nav_menu('footer', 'Footer menu');
});

add_filter('nav_menu_css_class', function($classes, $item, $args, $depth) {
	if ($args -> theme_location === 'header') {
		$classes = ['navigation__list-item'];
	}
	return $classes;
}, 10, 4);

add_filter('nav_menu_link_attributes', function($attrs, $item, $args, $depth) {
	if (!isset($attrs['class'])) {
		$attrs['class'] = '';
	}
	$attrs['class'] = 'navigation__list-link';
	return $attrs;
}, 10, 4);

class AI_land_Menu_Walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		$output .= "<li class='navigation__list-item'>";
		$output .= '<a class="navigation__list-link" href="' . $item->url . '">&#60;';
		$output .= $item->title;
		$output .= '&#62;</a></li>';
	}
}

add_image_size( 'custom-logo-1x-size', 96, 30 );

add_filter( 'wpcf7_autop_or_not', '__return_false' );