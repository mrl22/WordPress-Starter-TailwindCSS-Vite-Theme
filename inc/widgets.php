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