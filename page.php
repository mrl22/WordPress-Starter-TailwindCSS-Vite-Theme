<?php get_header(); ?>

    <div class="container mx-auto my-8 px-4">

        <?php if ( have_posts() ) : ?>

            <?php
            while ( have_posts() ) :
                the_post();
                ?>

                <div class="grid grid-cols-4">
                    <div class="col-span-3">
                        <?php get_template_part( 'template-parts/content', 'single' ); ?>
                    </div>
                    <div class="col-span-1">
                        <?php get_sidebar(); ?>
                    </div>
                </div>

            <?php endwhile; ?>

        <?php endif; ?>

    </div>

<?php
get_footer();