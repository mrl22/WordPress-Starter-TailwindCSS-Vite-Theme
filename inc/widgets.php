<?php

/* `Register widgets
----------------------------------------------------------------------------------------------------*/

add_action('widgets_init', function () {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));
});

/* `Remove unwanted widgets.
----------------------------------------------------------------------------------------------------*/

add_action('widgets_init', function () {
//    unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_Archives' );
    unregister_widget('WP_Widget_Block');
    unregister_widget('WP_Widget_Calendar' );
    unregister_widget('WP_Widget_Categories');
//    unregister_widget('WP_Widget_Custom_HTML');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Media_Audio');
    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Media_Gallery');
    unregister_widget('WP_Widget_Media_Image');
    unregister_widget('WP_Widget_Media_Video');
    unregister_widget('WP_Widget_Meta' );
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_RSS' );
    unregister_widget('WP_Widget_Recent_Comments' );
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Search' );
    unregister_widget('WP_Widget_Tag_Cloud' );
//    unregister_widget('WP_Widget_Text');
}, 11);