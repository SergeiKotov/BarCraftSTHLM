<?php
/**
 * sthlmesport functions and definitions
 *
 * @package sthlmesport
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'sthlmesport_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sthlmesport_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sthlmesport, use a find and replace
	 * to change 'sthlmesport' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sthlmesport', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size("top-image", 760, 380, true );
	add_image_size("article-thumb", 280, 140, true );

	// remove hard coded dimension from thumbnails
	add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );
	function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	    return $html;
	}

	// Decrease excerpt length
	function my_excerpt_length($length) {
		return 30; // Number of words
	}
	add_filter('excerpt_length', 'my_excerpt_length');

	// Remove excerpt "[...]"
	function new_excerpt_more( $more ) {
	return '…';
	}
	add_filter('excerpt_more', 'new_excerpt_more');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sthlmesport' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sthlmesport_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
}
endif; // sthlmesport_setup
add_action( 'after_setup_theme', 'sthlmesport_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function sthlmesport_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'sthlmesport' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Notice Widgets 1', 'noticewidgets1' ),
		'id'            => 'noticewidgets1',
		'before_widget' => '<div id="%1$s" class="splash %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Notice Widgets 2', 'noticewidgets2' ),
		'id'            => 'noticewidgets2',
		'before_widget' => '<div id="%1$s" class="splash %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Article Widgets', 'articlewidgets' ),
		'id'            => 'articlewidgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'footerwidgets' ),
		'id'            => 'footerwidgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Schedule Widgets', 'schedulewidgets' ),
		'id'            => 'schedulewidgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'sthlmesport_widgets_init' );


/**
 * Shortcodes
 */

function esport_ingress( $atts, $content = null ) {
	return '<p class="ingress ' . implode(" ", $atts) . '">' . do_shortcode($content) . '</p>';
}
add_shortcode('ingress', 'esport_ingress');


/**
 * Enqueue scripts and styles.
 */
function sthlmesport_scripts() {

    wp_enqueue_script('jquery');

	wp_enqueue_style( 'sthlmesport-style', get_stylesheet_uri() );

    wp_enqueue_script( 'sthlmesport-navigation', get_template_directory_uri() . '/js/filter_functions.js');

	wp_enqueue_script( 'sthlmesport-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'sthlmesport-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sthlmesport_scripts' );

/*
 *  Adds Event post type
 */
function create_post_types() { // add 'supports' => array(),
    register_post_type( 'event',
                        array(
                            'labels' => array(
                                            'name' => __( 'Event' ),
                                            'singular_name' => __( 'Event' )
                                            ),
                            'taxonomies' => array('category', 'post_tag'),
                            'public' => true,
                            'supports'=> array('title', 'editor', 'thumbnail'),
                            'has_archive' => true,
                            'rewrite' => array( 'slug' => 'event'),
                        )
                    );

}
add_action( 'init', 'create_post_types' );

//function older_posts_query(&$query) {
//    if ( ! $query->is_posts_page ) {
//        return;
//    }
//
//    $offset = 6;
//
//    $ppp = get_option( 'posts_per_page' );
//
//    if ( $query->is_paged ) {
//        $page_offset = $offset + ( ($query->query_vars['paged']-1) * $ppp );
//        $query->set( 'offset', $page_offset );
//    } else {
//        $query->set( 'offset', $offset );
//    }
//}
//add_action('pre_get_posts', 'older_posts_query', 1);
//
//function older_posts_adjust_offset($found_posts, $query) {
//    $offset = 6;
//
//    if ( $query->is_posts_page ) {
//        return $found_posts - $offset;
//    }
//    return $found_posts;
//}
//add_filter( 'found_posts', 'older_posts_adjust_offset', 1, 2 );

//function event_delete_transient( $post_id, $post ) {
//    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
//        return;
//    }
//    if ( $post->post_type == 'event' ) {
//        delete_transient( 'event_query' );
//    }
//}
//add_action( 'save_post', 'event_delete_transient', 10, 2 );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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



function be_exclude_post_formats_from_blog( $query ) {

	global $show_asides;

	if($show_asides == false) {
		$tax_query = array( array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-aside',
			'operator' => 'NOT IN',
		) );
		$query->set( 'tax_query', $tax_query );
	}

}
add_action( 'pre_get_posts', 'be_exclude_post_formats_from_blog' );

function limit_posts_per_archive_page() {
	set_query_var('posts_per_archive_page', 7); // or use variable key: posts_per_page
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');