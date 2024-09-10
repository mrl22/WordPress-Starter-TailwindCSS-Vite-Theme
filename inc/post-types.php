<?php

//WordPress permalinks should be flushed when you register a post type or taxonomy.
//flush_rewrite_rules();

/* `Create custom post type
----------------------------------------------------------------------------------------------------*/

//add_action('init', function () {
//    // Example - Testimonials
//    // Don't forget to create single-<post_type>.php and archive-<post_type>.php
//    register_post_type('testimonial',
//        // CPT Options
//        array(
//            'labels' => array(
//                'name' => 'Testimonials',
//                'singular_name' => 'Testimonial'
//            ),
//            'public' => true,
//            'has_archive' => true,
//            'rewrite' => array('slug' => 'testimonials'),
//        )
//    );
//
//    register_taxonomy('sector', array('testimonial'), array(
//        'hierarchical' => true,
//        'labels' => array(
//            'name' => 'Sectors',
//            'singular_name' => 'Sector'
//        ),
//        'show_ui' => true,
//        'show_admin_column' => true,
//        'query_var' => true,
//        'rewrite' => array('slug' => 'sector'),
//    ));
//});
