<?php

/* `Remove unwanted Gutenberg block styles from loading inline on the frontend
----------------------------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library-theme'); // Remove WooCommerce Block Styles
    wp_dequeue_style('classic-theme-styles'); // Remove Class Theme Styles
}, 100);

/* `Let's clean up WordPress meta head
----------------------------------------------------------------------------------------------------*/

add_filter('xmlrpc_enabled', '__return_false');                      // Disable XML RPC

remove_action('wp_head', 'wp_generator');                            // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rsd_link');                                // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link');                        // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link');                          // Display the index link
remove_action('wp_head', 'feed_links', 2);                           // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'feed_links_extra', 3);                     // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);  // Display the prev,start links
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);             // Display the short url of the ucrrent page
add_filter('the_generator', 'no_generator');                         // Do not generate and display WordPress version
// Remove Emoji support in new Wordpress 4.2
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
// Remove .recentcomments from the WP Head
add_action('widgets_init', function () {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
});

// Remove wp-json
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11);
// Remove dns-prefetch Link from WordPress Head (Frontend)
remove_action('wp_head', 'wp_resource_hints', 2);