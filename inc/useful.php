<?php

/* `Output the template name in the footer
----------------------------------------------------------------------------------------------------*/

add_action('get_footer', function () {
    global $template;
    if (IS_VITE_DEVELOPMENT) {
        echo '<div class="fixed bottom-0 left-0 z-[9999] bg-red-500 text-white px-1 py-0.5">';
        echo basename($template);
        echo '</div>';
    }
});

/* `Output the Tailwind responsive size in the header
----------------------------------------------------------------------------------------------------*/

add_action('wp_head', function () {
    if (IS_VITE_DEVELOPMENT) {
        echo '<div class="fixed bottom-0 right-0 z-[9999] bg-red-500 text-white px-1 py-0.5">
        <div class="block sm:hidden">XS</div>
        <div class="hidden sm:block md:hidden">SM</div>
        <div class="hidden md:block lg:hidden">MD</div>
        <div class="hidden lg:block xl:hidden">LG</div>
        <div class="hidden xl:block 2xl:hidden">XL</div>
        <div class="hidden 2xl:block">2XL</div>
        </div>';
    }
});