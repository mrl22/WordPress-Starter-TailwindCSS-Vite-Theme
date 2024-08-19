<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

// Main switch to get frontend assets from a Vite dev server OR from production built folder
// If you specify a DEVELOPMENT_IP constant, the frontend assets will be loaded from the Vite dev server only for the IP specified
// it is recommended to move it into wp-config.php
const IS_VITE_DEVELOPMENT = false;
//const DEVELOPMENT_IP = '123.123.123.123';

require 'vendor/autoload.php';

require 'inc/vite.php';

require 'inc/acf.php';
require 'inc/blog.php';
require 'inc/cleanup.php';
require 'inc/comments.php';
require 'inc/general.php';
require 'inc/gutenberg.php';
require 'inc/login.php';
require 'inc/nav_walker.php';
require 'inc/post-types.php';
require 'inc/shortcodes.php';
require 'inc/svg.php';
require 'inc/updates.php';
require 'inc/useful.php';
require 'inc/widgets.php';


add_action('after_setup_theme', function () {

    add_theme_support('title-tag');

    add_theme_support(
        'html5',
        array(
            'search-form',
            'gallery',
            'caption',
        )
    );

    /* `Add Support to change the logo */
    add_theme_support('custom-logo');

    add_theme_support('wp-block-styles');

    /* `Add Support for Menus */
    add_theme_support('menus');
    register_nav_menu('main-menu', 'Navigation');
    register_nav_menu('mobile-menu', 'Navigation (Mobile)');

    /* `Add Support for Post thumbnail */
//    add_theme_support('post-thumbnails');
//    set_post_thumbnail_size( 800, 800 );

    /* `Custom image sizes */

//    add_image_size( 'category-thumb', 300 ); // 300 pixels wide (and unlimited height)
//    add_image_size( 'custom-size', 220, 180 ); // 220 pixels wide by 180 pixels tall, soft proportional crop mode
//    add_image_size( 'homepage-thumb', 220, 180, true ); // (cropped)

});