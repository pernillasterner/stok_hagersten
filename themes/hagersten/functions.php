<?php

//---------------------------------------------------------------------------------
//	Aktivera den inbyggda menyfunktionalliteten
//---------------------------------------------------------------------------------

add_theme_support( 'menus' );


//---------------------------------------------------------------------------------
//	Aktivera widgets
//---------------------------------------------------------------------------------

if ( function_exists('register_sidebar') )
	register_sidebar(array(
	'before_widget' => '<section>',
	'after_widget' => '</section>',
	'before_title' => '<h4>',
	'after_title' => '</h4>',
));



//---------------------------------------------------------------------------------
//	Ta bort blandat skräp från head
//---------------------------------------------------------------------------------

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

//---------------------------------------------------------------------------------
//	Tar bort meny-alternativ i admin.
//---------------------------------------------------------------------------------

if(current_user_can('editor')) {
    add_action( 'admin_menu', 'my_remove_menu_pages' );

    function my_remove_menu_pages() {
        remove_submenu_page('themes.php','themes.php');
        remove_submenu_page('themes.php','widgets.php');
        //remove_submenu_page('themes.php','nav-menus.php');
        remove_menu_page('tools.php');
        remove_menu_page('edit-comments.php');
	remove_menu_page('plugins.php');
	remove_menu_page('link-manager.php');
	remove_submenu_page('themes.php','theme-editor.php');
    }
}


//---------------------------------------------------------------------------------
//	Lägg till menystöd.
//---------------------------------------------------------------------------------

add_action( 'after_setup_theme', 'this_theme_setup' );
if ( ! function_exists( 'this_theme_setup' ) ) {
	function this_theme_setup() {

		// This theme uses wp_nav_menu() in one location
		register_nav_menu( 'primary', 'Huvudmeny för temat' );
	}
}

//---------------------------------------------------------------------------------
//	Ta bort onödiga widgets från Dashboarden.
//---------------------------------------------------------------------------------

function remove_dashboard_widgets() {
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'yoast_db_widget', 'dashboard', 'side' );
}

add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

//---------------------------------------------------------------------------------
//	Lägg till custom-widget
//---------------------------------------------------------------------------------


function example_add_dashboard_widgets() {

    wp_add_dashboard_widget(
        'aveny-widget',         // Widget slug.
        'Manuell Aveny-uppdatering',         // Title.
        'aveny_widet__add' // Display function.
    );
}

add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

function aveny_widet__add() {

    ?>
    <p>Tryck på knappen nedan för att dra igång en manuell import av Aveny kalendarie-flöde.</p>

    <a href="http://www.hagersten.org/wp-content/plugins/aveny_updater/aveny_updater.php?key=203admin" title="Manuell aveny-uppdatering" target="_blank" class="button">Manuell Aveny-uppdatering</a>

    <?php
}


//---------------------------------------------------------------------------------
//	Ta bort "Uppdatera nu" -skylten. (Remove admin-bar)
//---------------------------------------------------------------------------------

if (!function_exists('no_update_nag')) {

    function no_update_nag(){
        remove_action('admin_notices', 'update_nag', 3 );
    }
}

add_action('admin_init', 'no_update_nag');


//---------------------------------------------------------------------------------
//	Lägg till Google Analytics i footern, ändra UA-XXXXX-X till din egen tracking-kod
//---------------------------------------------------------------------------------

/*function add_google_analytics() {
	echo '<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>';
	echo '<script type="text/javascript">';
	echo 'var pageTracker = _gat._getTracker("UA-XXXXX-X");';
	echo 'pageTracker._trackPageview();';
	echo '</script>';
}
add_action('wp_footer', 'add_google_analytics');

 */


//---------------------------------------------------------------------------------
//	Hierarchical submenu
//---------------------------------------------------------------------------------

function hierarchical_submenu($post) {
    $top_post = $post;
    // If the post has ancestors, get its ultimate parent and make that the top post
    if ($post->post_parent && $post->ancestors) {
        $top_post = get_post(end($post->ancestors));
    }
    // Always start traversing from the top of the tree
    return hierarchical_submenu_get_children($top_post, $post);
}

function hierarchical_submenu_get_children($post, $current_page) {
    $menu = '';
    // Get all immediate children of this page
    $children = get_pages('child_of=' . $post->ID . '&parent=' . $post->ID . '&sort_column=menu_order&sort_order=ASC');
    if ($children) {
        $menu = "\n<ul>\n";
        foreach ($children as $child) {
            // If the child is the viewed page or one of its ancestors, highlight it
            if (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID)) {
                $menu .= '<li class="sel"><a href="' . get_permalink($child) . '" class="sel">' . $child->post_title . '</a>';
            } else {
                $menu .= '<li><a href="' . get_permalink($child) . '">' . $child->post_title . '</a>';
            }
            // If the page has children and is the viewed page or one of its ancestors, get its children
            if (get_children($child->ID) && (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID))) {
                $menu .= hierarchical_submenu_get_children($child, $current_page);
            }
            $menu .= "</li>\n";
        }
        $menu .= "</ul>\n";
    }
    return $menu;
}


//---------------------------------------------------------------------------------
//	Lägg till stöd för featured image
//---------------------------------------------------------------------------------
add_theme_support( 'post-thumbnails' );

//---------------------------------------------------------------------------------
//  Add image sizes
//---------------------------------------------------------------------------------

add_action('init', 'theme_setup');

function theme_setup(){

    /* Register image sizes */
    add_image_size( 'press', 200, 999, false );
    add_image_size( 'big', 700);
	add_image_size( '209x209', 209, 209, true );
}

//---------------------------------------------------------------------------------
//	Shorten The Excerpt
//---------------------------------------------------------------------------------
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function search_type_filter($query) {
	if ($query->is_search) {
		$query->set('post_type', array('post','page'));
	}
	return $query;
}
add_filter('pre_get_posts','search_type_filter');




//---------------------------------------------------------------------------------
//	Add class to The Excerpt
//---------------------------------------------------------------------------------
function add_excerpt_class( $excerpt )
{
    $excerpt = str_replace( "<p", "<p class=\"ingress\"", $excerpt );
    return $excerpt;
}

add_filter( "the_excerpt", "add_excerpt_class" );


//---------------------------------------------------------------------------------
//	Fixa fallback för tomma sökningar
//---------------------------------------------------------------------------------
add_filter( 'request', 'my_request_filter' );
function my_request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}

//---------------------------------------------------------------------------------
//	Ladda Aveny API:et
//---------------------------------------------------------------------------------
require_once 'AvenyAPI.class.php';
global $aveny;
$aveny = new AvenyAPI();

//---------------------------------------------------------------------------------
//	Exerpt för pages
//---------------------------------------------------------------------------------
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

function add_query_vars($aVars) {
	$aVars[] = "no"; // bokningsnummer
	$aVars[] = "kal"; // calendar data, can be a date, a week or anything :)
	$aVars[] = "d"; // explicit date stuff param
//	$aVars[] = "kat"; //calendar category for sidebar
	return $aVars;
}
// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

setlocale(LC_ALL, "sv_SE.UTF-8");

/*
function add_rewrite_rules($aRules) {
	$aNewRules = array('/om-forsamlingen/eventvy/([^/]+)/?$' => 'om-forsamlingen/eventvy/?bokningsnummer=$matches[1]');
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'add_rewrite_rules');
*/

// Include files
$includes = [
	'lib/classes/CustomPostType.php',
	'lib/post-types/Instagram.php',
	'lib/uploads.php'
];

foreach( $includes as $file ) {
	$filepath = locate_template( $file );
	
	if( !$filepath ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'hagersten' ), $file ), E_USER_ERROR );
	}

	require_once $filepath;
}