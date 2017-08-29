<?php
/** Hide admin bar on site **/
//add_filter('show_admin_bar', '__return_false');

add_action( 'admin_enqueue_scripts', 'chrome_fix' );
function chrome_fix() {

    if ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'Chrome' ) !== false ) {
        wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0) }' );
    }
}

// Start Sessions
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

// This theme uses post thumbnails
add_theme_support('post-thumbnails');

// Custom Image Sizes
//add_image_size( 'artist-thumb', 315, 210, true );
//add_image_size( 'gellery-thumb', 211, 141, true );


/** Front end styles and scripts **/
function load_style_script(){
	wp_enqueue_style('critical', get_template_directory_uri() . '/public/css/critical.min.css');

    wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js','','',true );
    wp_enqueue_script('app', get_template_directory_uri() . '/public/js/app.min.js','','',true );


    
}
add_action('wp_enqueue_scripts', 'load_style_script');

function prefix_add_footer_styles() {
    wp_enqueue_style('app', get_template_directory_uri() . '/public/css/app.min.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/public/css/style.css');
    wp_enqueue_style('Roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,500,700,900&subset=cyrillic');
    wp_enqueue_style('style_dev', get_template_directory_uri() . '/style.css');
};
add_action( 'get_footer', 'prefix_add_footer_styles' );

/** Turn on menus  **/
function register_my_menu() {
  register_nav_menu('top-menu',__( 'Top Menu' ));
}
add_action( 'init', 'register_my_menu' );


/** Get menu items **/
function sera2007_get_menu_items($menu_name){
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        return wp_get_nav_menu_items($menu->term_id);
		wp_reset_query();
    }
}
/** ACF Option Page **/
if( function_exists('acf_add_options_page') ) {

    $parent = acf_add_options_page(array(
        'page_title'    => 'Theme settings',
        'menu_title'    => 'Theme settings',
        'menu_slug' => 'general-settings',
        'redirect'      => false
    ));
//    acf_add_options_sub_page(array(
//        'page_title'    => 'Header',
//        'menu_title'    => 'Header',
//        'parent_slug'   => $parent['menu_slug'],
//    ));
//    acf_add_options_sub_page(array(
//        'page_title'    => 'Footer',
//        'menu_title'    => 'Footer',
//        'parent_slug'   => $parent['menu_slug'],
//    ));
}

/** Google key for ACF **/
function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyCdZ9hx0az23JkCmgn_WVk1Bv5BK42I0Xk');
}
add_action('acf/init', 'my_acf_init');


/** Custom Sidebars **/
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'Footer Col 1',
        'id' => 'footer-1',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Col 2',
        'id' => 'footer-2',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Col 3',
        'id' => 'footer-3',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Footer Col 4',
        'id' => 'footer-4',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}


// Custom pagination function
function custom_pagination($numpages = '', $pagerange = '', $paged='') {

    if (empty($pagerange)) {
        $pagerange = 2;
    }

    /**
     * This first part of our function is a fallback
     * for custom pagination inside a regular loop that
     * uses the global $paged and global $wp_query variables.
     *
     * It's good because we can now override default pagination
     * in our theme, and use this function in default quries
     * and custom queries.
     */
    global $paged;
    if (empty($paged)) {
        $paged = 1;
    }
    if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if(!$numpages) {
            $numpages = 1;
        }
    }

    /**
     * We construct the pagination arguments to enter into our paginate_links
     * function.
     */
    $pagination_args = array(
        'base'            => get_pagenum_link(1) . '%_%',
        'format'          => 'page/%#%',
        'total'           => $numpages,
        'current'         => $paged,
        'show_all'        => False,
        'end_size'        => 1,
        'mid_size'        => $pagerange,
        'prev_next'       => True,
        'prev_text'       => __('<i class="fa fa-long-arrow-left"></i>'),
        'next_text'       => __('<i class="fa fa-long-arrow-right"></i>'),
        'type'            => 'plain',
        'add_args'        => false,
        'add_fragment'    => ''
    );

    $paginate_links = paginate_links($pagination_args);

    if ($paginate_links) {
        echo "<nav class='custom-pagination'>";
        echo "<span class='page-numbers page-num'>Page " . $paged . " of " . $numpages . "</span> ";
        echo $paginate_links;
        echo "</nav>";
    }

}

// ***** Multi level cusom menu *****

// is child of, recursive
function is_child_of( $post, $possible_parent_ID ) {
    if ($post->ID == $possible_parent_ID) {
        return true;
    } elseif ($post->post_parent == 0) {
        return false;
    } else {
        return is_child_of( get_post($post->post_parent), $possible_parent_ID );
    }
}
// convert relative to absolute URLs
function relative_to_absolute_URL($rel, $base) {
    /* return if already absolute URL */
    if (parse_url($rel, PHP_URL_SCHEME) != '') return $rel;
    /* queries and anchors */
    if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;
    /* parse base URL and convert to local variables:
       $scheme, $host, $path */
    extract(parse_url($base));
    /* remove non-directory element from path */
    $path = preg_replace('#/[^/]*$#', '', $path);
    /* destroy path if relative url points to root */
    if ($rel[0] == '/') $path = '';
    /* dirty absolute URL */
    $abs = "$host$path/$rel";
    /* replace '//' or '/./' or '/foo/../' with '/' */
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}
    /* absolute URL is ready! */
    return $scheme.'://'.$abs;
}
// custom menu url (e.g. '/custom-archive') ??is it current?
function custom_post_type_menu_current($menuitem) {
    // menu item URL
    $url = $menuitem->url;
    $url = relative_to_absolute_URL($url, site_url());
    // custom post type archive link
    $post_type = get_post_type( get_the_ID() );
    $post_type_archive_link = get_post_type_archive_link($post_type);
    $custom_post_type_archive_link = rtrim($post_type_archive_link,"/");
    if (!$custom_post_type_archive_link) {
        return false;
    }
    if (strpos($url,$custom_post_type_archive_link) !== false) {
        return  true;
    }
    return false;
}
function category_menu_current($post, $menuitem) {

    if ($menuitem->object !== 'category') {
        return false;
    }
    $categories = get_the_category( $post->ID );
    if (is_category($menuitem->object_id)) {
        return true;
    }
    if ((is_page() || is_single())  && ((int)$menuitem->object_id === $category->term_taxonomy_id)) {
        return true;
    }
    return false;
}
// hierarchical menus
function menu_has_children($item) {
    if (!empty($item->children)) {
        return true;
    } else {
        return false;
    }
}
// find id in multidimensional menuitems, recursive
function find_parent_in_multi_menuitems($id, $menuitems) {
    foreach ($menuitems as $menuitem) {
        if ((int) $id === (int) $menuitem->ID) {
            // $menuitem->level = $level;
            return $menuitem;
        } else {
            // get children
            if ($children = $menuitem->children) {
                // find parent
                $parent = find_parent_in_multi_menuitems($id, $children);
            }
        }
    }
    return false;
}
// for each menuitems, recursive
function get_heirachical_menu($menu_name, $locations) {
    global $post;
    // get current post object

    $the_post_id = false;
    if (!empty($post->ID)) {
        $the_post_id = $post->ID;
    }

    if (empty($locations[$menu_name])) {
        return false;
    }
    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
    // get wordpress menu items from menu
    $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
    $menu_items_multidimensional = array();
    foreach ($menuitems as $menuitem) {
        // add current classes
        $menuitem->current = false;
        // current page is current
        if ($the_post_id === (int)$menuitem->object_id && $menuitem->object === 'page') {
            $menuitem->current = true;
        }
        // current post is current
        if ($the_post_id === (int)$menuitem->object_id && $menuitem->object === 'post') {
            $menuitem->current = true;
        }
        // if is child of post
        if ( is_child_of($post, (int)$menuitem->object_id) && ($menuitem->object === 'page') ) {
            $menuitem->current = true;
        }
        // get parent ID
        $parentID = $menuitem->menu_item_parent;
        // setup childrens array if doesn't exist
        if (!$menuitem->children) {
            $menuitem->children = array();
        }
        // if menu item is top level
        if ((int) $parentID === 0) {
            // add to multidimensional array;
            $menuitem->level = 0;
            $menu_items_multidimensional[] = $menuitem;
        } else {
            // find parent
            $parent = find_parent_in_multi_menuitems($parentID, $menuitems);
            // add this item to parent->children array();
            if ($menuitem->current) {
                $parent->current = true;
            }
            $menuitem->level = $parent->level + 1;
            $parent->children[] = $menuitem;
        }
        // sort custom post type current classes
        if (custom_post_type_menu_current($menuitem)) {
            $menuitem->current = true;
        }
        if (category_menu_current($post, $menuitem)) {
            $menuitem->current = true;
        }
    }
    return $menu_items_multidimensional;
}
?>