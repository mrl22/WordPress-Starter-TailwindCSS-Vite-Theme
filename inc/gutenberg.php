<?php

// Create your first Gutenberg block
// https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
//
// cd blocks
// npx @wordpress/create-block hello-world

$blocks_dir = get_template_directory() . '/blocks';

if (is_dir($blocks_dir)) {
    $dirs = scandir($blocks_dir);

    foreach ($dirs as $dir) {
        if ($dir === '.' || $dir === '..') {
            continue;
        }
        $dir_path = $blocks_dir . '/' . $dir;
        $file_path = $dir_path . '/' . $dir . '.php';

        if (is_dir($dir_path) && file_exists($file_path)) {
            require $file_path;
        }
    }
}