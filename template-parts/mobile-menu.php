<div class="px-10 py-6">

    <a href="#" aria-label="Toggle navigation" class="mobile-menu-toggle absolute top-6 right-10">
        <svg class="w-8 h-8 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
        </svg>
    </a>

    <div class="p-10 text-center pt-[10vh]">

        <?php
        wp_nav_menu(
            array(
                'container_id'    => 'mobile-menu',
                'menu_class'      => 'flex min-h-[70vh] flex-col text-3xl font-bold text-gray-800',
                'theme_location'  => 'mobile-menu',
                'li_class'        => 'px-4 py-2',
                'fallback_cb'     => false,
            )
        );
        ?>
    </div>

</div>