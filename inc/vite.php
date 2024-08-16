<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

/*
 * VITE & Tailwind JIT development
 * Inspired by https://github.com/andrefelipe/vite-php-setup
 *
 */

// dist subfolder - defined in vite.config.json
const DIST_DEF = 'dist';

// defining some base urls and paths
define('DIST_URI', get_template_directory_uri() . '/' . DIST_DEF);
define('DIST_PATH', get_template_directory() . '/' . DIST_DEF);

// js enqueue settings
const JS_DEPENDENCY = array(); // array('jquery') as example
const JS_LOAD_IN_FOOTER = true; // load scripts in footer?

// deafult server address, port and entry point can be customized in vite.config.json
const VITE_SERVER = 'http://localhost:3000';

define('IS_LOGIN_PAGE', in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php')));

if (IS_LOGIN_PAGE) {
    define("VITE_ENTRY_POINT", 'src/wp-login/login.js');
    define("HOOK_PREFIX", 'login');
} else {
    define("VITE_ENTRY_POINT", 'src/theme.js');
    define("HOOK_PREFIX", 'wp');
}

// enqueue hook
add_action(HOOK_PREFIX.'_enqueue_scripts', function() {

    if (defined('IS_VITE_DEVELOPMENT') && IS_VITE_DEVELOPMENT === true && ((defined('DEVELOPMENT_IP') && $_SERVER['REMOTE_ADDR'] === DEVELOPMENT_IP) || !defined('DEVELOPMENT_IP'))) {

        // insert hmr into head for live reload
        function vite_head_module_hook() {
            echo '<script type="module" crossorigin src="' . VITE_SERVER . '/' . VITE_ENTRY_POINT . '"></script>';
        }
        add_action(HOOK_PREFIX.'_head', 'vite_head_module_hook');


    } else {

        // production version, 'npm run build' must be executed in order to generate assets
        // ----------

        // read manifest.json to figure out what to enqueue
        $manifest = json_decode( file_get_contents( DIST_PATH . '/manifest.json'), true );

        // is ok
        if (is_array($manifest)) {

            if (isset($manifest[VITE_ENTRY_POINT]) && !empty($manifest[VITE_ENTRY_POINT]['css'])) {

                // enqueue CSS files
                foreach ($manifest[VITE_ENTRY_POINT]['css'] as $css_file) {
                    wp_enqueue_style('theme', DIST_URI . '/' . $css_file);
                }

                // enqueue theme JS file
                $js_file = $manifest[VITE_ENTRY_POINT]['file'];
                if (!empty($js_file)) {
                    wp_enqueue_script('theme', DIST_URI . '/' . $js_file, JS_DEPENDENCY, '', JS_LOAD_IN_FOOTER);
                }


            }

        }

    }

});