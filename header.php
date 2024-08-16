<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri() ?>/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-white text-gray-900 antialiased' ); ?>>
<?php wp_body_open(); ?>
<div id="page" class="min-h-screen flex flex-col">
    <div id="mobile-menu-container">
        <?php echo get_template_part('template-parts/mobile-menu'); ?>
    </div>
    <header>
        <div class="container mx-auto px-4">
            <div class="lg:flex lg:justify-between lg:items-center border-b">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <?php if ( has_custom_logo() ) { ?>
                            <?php the_custom_logo(); ?>
                        <?php } else { ?>
                            <a href="<?php echo get_bloginfo( 'url' ); ?>" class="font-extrabold text-lg uppercase">
                                <?php echo get_bloginfo( 'name' ); ?>
                            </a>

                            <p class="text-sm font-light text-gray-600">
                                <?php echo get_bloginfo( 'description' ); ?>
                            </p>

                        <?php } ?>
                    </div>

                    <div class="lg:hidden">
                        <a href="#" aria-label="Toggle navigation" class="mobile-menu-toggle">
                            <svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1"
                                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                                    <g id="icon-shape">
                                        <path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
                                              id="Combined-Shape"></path>
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <?php
                wp_nav_menu(
                    array(
                        'container_id'    => 'main-menu',
                        'container_class' => 'hidden bg-gray-100 lg:bg-transparent lg:block',
                        'menu_class'      => 'lg:flex lg:-mx-4',
                        'theme_location'  => 'main-menu',
                        'li_class'        => 'px-4 py-2',
                        'fallback_cb'     => false,
                    )
                );
                ?>
            </div>
        </div>
    </header>

    <div id="content" class="site-content flex-grow">

        <main>