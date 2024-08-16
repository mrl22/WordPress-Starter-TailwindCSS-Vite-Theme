<?php

/* `Set your custom excerpt length
----------------------------------------------------------------------------------------------------*/

//add_filter('excerpt_length', function ($length) {
//    return 30;
//}, 999);

/* `The "Read more" link after the excerpt
----------------------------------------------------------------------------------------------------*/

//add_filter('excerpt_more', function ($more) {
//    return '<p><a class="read-more" href="' . get_permalink(get_the_ID()) . '">Read more »</a></p>';
//});



/* `Give 'Posts' a custom name in the admin
----------------------------------------------------------------------------------------------------*/

//add_action('admin_menu', function () {
//    global $menu;
//    global $submenu;
//    $menu[5][0] = 'News';
//});