<?php

/* `Disable comments completely
----------------------------------------------------------------------------------------------------*/

// Disable support for comments and trackbacks in post types
add_action('admin_init', function () {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', function () {
    return false;
}, 20, 2);
add_filter('pings_open', function () {
    return false;
}, 20, 2);

// Hide existing comments
add_filter('comments_array', function ($comments) {
    $comments = array();
    return $comments;
}, 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Redirect any user trying to access comments page
add_action('admin_init', function () {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
});

// Remove comments metabox from dashboard
add_action('admin_init', function () {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});