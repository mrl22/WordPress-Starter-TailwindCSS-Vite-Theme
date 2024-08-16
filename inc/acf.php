<?php

/* `Theme Settings Support - Buy ACF Pro - It's Amazing!
----------------------------------------------------------------------------------------------------*/

if (function_exists('acf_add_options_page')) {
//    acf_add_options_page(array(
//        'page_title' => 'General Settings',
//        'menu_title' => 'Theme Settings',
//        'menu_slug' => 'theme-settings',
//        'capability' => 'edit_posts',
//        'redirect' => false
//    ));

//	acf_add_options_sub_page(array(
//		'page_title' 	=> 'Footer Box Settings',
//		'menu_title'	=> 'Footer Boxes',
//		'parent_slug'	=> 'theme-settings',
//	));
}

/* `Hide ACF Menu for non-developer users
----------------------------------------------------------------------------------------------------*/

add_action('admin_menu', function () {

    // provide a list of usernames who can edit ACF
    $admins = [
        'webfwd'
    ];

    $current_user = wp_get_current_user();

    if (!in_array($current_user->user_login, $admins))
        remove_menu_page('edit.php?post_type=acf');


});

/* `Close all ACF Sub Groups by default
----------------------------------------------------------------------------------------------------*/

add_action('acf/input/admin_head', function () {
    echo <<<HTML
    <script type="text/javascript">
        jQuery(function($){
            $('.acf-postbox .acf-postbox').addClass('closed');
        });
    </script>
    HTML;
});