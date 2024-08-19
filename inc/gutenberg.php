<?php

/* `Restore Classic Editor in the admin (replaces Gutenberg)
----------------------------------------------------------------------------------------------------*/

add_filter('use_block_editor_for_post', '__return_false', 10);

/* `Restore Classic Widgets in the admin (replaces Widget blocks)
----------------------------------------------------------------------------------------------------*/

add_action('after_setup_theme', function () {
    remove_theme_support('widgets-block-editor');
});