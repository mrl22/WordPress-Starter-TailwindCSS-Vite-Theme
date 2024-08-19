<?php if (have_rows('builder')): ?>
    <div id="builder">
        <?php
        $builder = 0;
        while (have_rows('builder')): the_row();
            $builder++;
            $layout = esc_attr(get_row_layout());
            $layout_path = get_template_directory() . '/builder/_' . $layout . '.php';
            ?>
            <section class="<?php echo $layout; ?> builder<?php echo $builder; ?>">
                <?php
                if (file_exists($layout_path)) require($layout_path);
                else echo '<strong>[builder error: Block "_' . $layout . '.php" could not be found]</strong>';
                ?>
            </section>
        <?php endwhile; ?>
    </div>
<?php endif; ?>