<?php
/**
 * reshaemonline functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package reshaemonline
 */

// Register Custom Navigation Walker
require_once get_template_directory() . '/wp-bootstrap-navwalker.php';

if ( ! function_exists( 'reshaemonline_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function reshaemonline_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on reshaemonline, use a find and replace
		 * to change 'reshaemonline' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'reshaemonline', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'reshaemonline' ),
			'footer_menu-l' => esc_html__( 'footer_menu-left', 'reshaemonline'),
			'footer_menu-r' => esc_html__( 'footer_menu-right', 'reshaemonline'),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'reshaemonline_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'reshaemonline_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function reshaemonline_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'reshaemonline_content_width', 640 );
}
add_action( 'after_setup_theme', 'reshaemonline_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function reshaemonline_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'reshaemonline' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'reshaemonline' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( '404 page', 'reshaemonline' ),
		'id'            => 'sidebar-2',
	) );
}
add_action( 'widgets_init', 'reshaemonline_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function reshaemonline_scripts() {
	//wp_enqueue_style( 'reshaemonline-fontwesome-style', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );
	wp_enqueue_style( 'reshaemonline-fontwesome-style', get_template_directory_uri() . '/css/font-awesome.min.css' );


	wp_enqueue_style( 'reshaemonline-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );

	//wp_enqueue_style( 'reshaemonline-jquery-bar-rating-style', '//cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.min.css' );

	//wp_enqueue_style( 'reshaemonline-lightslide-style', '//cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css' );
	wp_enqueue_style( 'reshaemonline-jquery-bar-rating-style', get_template_directory_uri() . '/css/fontawesome-stars.min.css' );

	wp_enqueue_style( 'reshaemonline-lightslide-style', get_template_directory_uri() . '/css/lightslider.min.css' );

	//wp_enqueue_style( 'reshaemonline-main-css', get_template_directory_uri() . '/css/main.css' );

	wp_enqueue_style( 'reshaemonline-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'swiper-bundle-css', get_template_directory_uri() . '/css/swiper-bundle.min.css' );
	wp_enqueue_style( 'select2-css', get_template_directory_uri() . '/css/select2.min.css' );
	


	//Scripts
	wp_deregister_script('jquery');
	//wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, false);

	//wp_enqueue_script( 'reshaemonline-bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(), null, true );

	//wp_enqueue_script( 'reshaemonline-barration-js', '//cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js', array(), null, true );

	//wp_enqueue_script( 'reshaemonline-lightslider-js', '//cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js', array(), null, true );
wp_enqueue_script('jquery', get_template_directory_uri() . '/js/new/jquery-3.6.2.js', array(), null, false);

	wp_enqueue_script( 'reshaemonline-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), null, true );

	wp_enqueue_script( 'reshaemonline-barration-js', get_template_directory_uri() . '/js/jquery.barrating.min.js', array(), null, true );

	wp_enqueue_script( 'reshaemonline-lightslider-js', get_template_directory_uri() . '/js/lightslider.min.js', array(), null, true );
	wp_enqueue_script( 'reshaemonline-jquery-matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight-min.js', array(), '20151215', true );

	wp_enqueue_script( 'reshaemonline-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'reshaemonline-countUp-js', get_template_directory_uri() . '/js/countUp.min.js', array(), '20151215', true );

	wp_enqueue_script( 'reshaemonline-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
		

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	};

	wp_enqueue_script( 'reshaemonline-main-js', get_template_directory_uri() . '/js/script.js', array(), null, true );
	
	
	wp_enqueue_script( 'select2-min', get_template_directory_uri() . '/js/new/select2.min.js', array(), '20151218', true );
	wp_enqueue_script( 'swiper-bundle-min', get_template_directory_uri() . '/js/new/swiper-bundle.min.js', array(), '20151216', true );
	//wp_enqueue_script( 'index-new', get_template_directory_uri() . '/js/new/index.js', array(), '20151217', true );
}
add_action( 'wp_enqueue_scripts', 'reshaemonline_scripts' );

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
 * Shortcodes.
 */ 
require get_template_directory() . '/assets/shortcode/shortcodes.php';

 /**
 * Breadcrumb Yoast.
 */
require get_template_directory() . '/assets/yoast-breadcrums.php';

/**
 * Load Jetpack compatibility file.
 */
//if ( defined( 'JETPACK__VERSION' ) ) {
//	require get_template_directory() . '/inc/jetpack.php';
//}

//----------------------------
//Customize custom logo output
//----------------------------
function siteBrand($html)
{
	// grab the site name as set in customizer options
	$site = get_bloginfo('name');
	// Wrap the site name in an H1 if on home, in a paragraph tag if not.
	is_front_page() ? $title = '<h1>' . $site . '</h1>' : $title = '<p>' . $site . '</p>';
	// Grab the home URL
	$home = esc_url(home_url('/'));
	// Class for the link
	$class = 'navbar-brand header__logo';
	// Set anchor content to $title
	$content = $title;
	// Check if there is a custom logo set in customizer options...
	if (has_custom_logo()) {
		// get the URL to the logo
		$logo    = wp_get_attachment_image(get_theme_mod('custom_logo'), 'full', false, array(
			'class'    => 'brand-logo img-responsive',
		));
		// we have a logo, so let's update the $content variable
		$content = $logo;
		// include the site name markup, hidden with screen reader friendly styles
		//$content .= '<div class="sr-only">' . $title . '</div>';
	}
	// construct the final html
	$html = sprintf('<a href="%1$s" class="%2$s" rel="home">%3$s</a>', $home, $class, $content);

	// return the result to the front end
	return $html;
}
add_filter('get_custom_logo', __NAMESPACE__ . '\\siteBrand');

//---------------------
// Move Yoast to bottom
//---------------------
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


function getSize($file){
	$bytes = filesize($file);
	$s = array('b', 'Kb', 'Mb', 'Gb');
	$e = floor(log($bytes)/log(1024));
	return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}

show_admin_bar( false );

//add_action( 'template_redirect', 'Sheensay_HTTP_Headers_Last_Modified' );

function Sheensay_HTTP_Headers_Last_Modified() {

	if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( is_admin() ) ) {
		return;
	}

	$last_modified = '';


	// ?????? ?????????????? ?? ??????????????
	if ( is_singular() ) {
		global $post;

		// ???????? ???????? ?????????????????? - ???????????????????? ??????
		if ( post_password_required( $post ) )
			return;

		if ( !isset( $post -> post_modified_gmt ) ) {
			return;
		}

		$post_time = strtotime( $post -> post_modified_gmt );
		$modified_time = $post_time;

		// ???????? ???????? ??????????????????????, ?????????????????? ????????
		if ( ( int ) $post -> comment_count > 0 ) {
			$comments = get_comments( array(
				'post_id' => $post -> ID,
				'number' => '1',
				'status' => 'approve',
				'orderby' => 'comment_date_gmt',
			) );
			if ( !empty( $comments ) && isset( $comments[0] ) ) {
				$comment_time = strtotime( $comments[0] -> comment_date_gmt );
				if ( $comment_time > $post_time ) {
					$modified_time = $comment_time;
				}
			}
		}

		$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
	}


	// C?????????????? ??????????????: ??????????????, ??????????, ???????? ?? ???????? ????????????????
	if ( is_archive() || is_home() ) {
		global $posts;

		if ( empty( $posts ) ) {
			return;
		}

		$post = $posts[0];

		if ( !isset( $post -> post_modified_gmt ) ) {
			return;
		}

		$post_time = strtotime( $post -> post_modified_gmt );
		$modified_time = $post_time;

		$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
	}


	// ???????? ?????????????????? ?????? ???????????????????? - ???????????? ???? ????????????
	if ( headers_sent() ) {
		return;
	}

	if ( !empty( $last_modified ) ) {
		header( 'Last-Modified: ' . $last_modified );

		if ( !is_user_logged_in() ) {
			if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) >= $modified_time ) {
				$protocol = (isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
				header( $protocol . ' 304 Not Modified' );
			}
		}
	}
}


function wp_zhilin_krohi() {
    $id = get_the_ID() ;
    if ( !is_home() ) {
        echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
<a itemprop="url" href="'.get_option('home').'" ><span itemprop="title">??????????????</span></a></span>';
    }
//    echo "<pre>";
//    var_dump(is_category(the_ID()), is_single(the_ID()));
//    echo "<pre>";
    if (is_category()) {
        $cats = get_the_category();
        foreach ($cats as $cat) {
//            echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'.get_category_link($cat->term_id).'" ><span itemprop="title">' .$cat->name.'</span></a></span> ?? ';
            echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' .$cat->name.'</span></span>';
        }
    }else if(is_single($id))
    {
//        echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'.get_permalink().'" ><span itemprop="title">' .get_the_title(). '</span></a></span>';
        echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' .get_the_title(). '</span></span>';
    }else{
//        echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="'.get_permalink().'" ><span itemprop="title">' .get_the_title(). '</span></a></span>';
        echo '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">' .get_the_title(). '</span></span>';
    }
}



//===== ?????????????????? ?????????????????????? ???? ???????????????????? ???????????????? ?? ??????????????????=====//
add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
wp_clear_scheduled_hook('wp_version_check');
remove_action( 'load-update-core.php', 'wp_update_plugins' );
add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
add_filter( 'auto_update_core', '__return_false' );
//???????????????? ???? ???????????? ?????????????????? ???????? start
function wph_new_toolbar() {
global $wp_admin_bar;
$wp_admin_bar->remove_menu('updates'); //???????? "????????????????????"
}
add_action('wp_before_admin_bar_render', 'wph_new_toolbar');
//???????????????? ???? ???????????? ?????????????????? ???????? end

//???????????????? [...] ?? the_excerpt
add_filter( 'excerpt_more', fn() => '' );
add_filter( 'excerpt_length', function(){
	return 20;
} );



