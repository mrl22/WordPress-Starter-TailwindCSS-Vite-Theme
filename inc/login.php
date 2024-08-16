<?php

/* `Customize the login logo url. By default, it goes to wordpress.org
----------------------------------------------------------------------------------------------------*/

add_filter('login_headerurl', function ($url) {
    return get_site_url();
});

/* `Customize the login logo
----------------------------------------------------------------------------------------------------*/

//add_action('login_head', function () {
//    echo '<style type="text/css">
//       #login h1 a {
//		   background-image:url(' . get_bloginfo('stylesheet_directory') . '/images/login_logo.png) !important;
//		   background-size: 320px 99px !important; height: 99px !important; width: 320px !important;
//       }
//    </style>';
//});

/* `Powered by message on login page
----------------------------------------------------------------------------------------------------*/

add_filter('login_message', function () {
    $message = '<div id="poweredby" style="position:absolute;bottom:10px;left:0;width:100vw;text-align:center">Powered by <a href="https://www.webfwd.co.uk/" target="_blank">Webforward</a></div>';
    return $message;
});