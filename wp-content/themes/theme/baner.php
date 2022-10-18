<section class="banner"
         style="background: url('<?php the_field("banner_bg", "option") ?>') no-repeat center / cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-lg-9">
                <div class="banner__outer">

                    <?php if (in_category('services')) { ?><?php
                        echo "<h1>" . get_the_title() . "</h1>";
                    }else{
                    ?>
                    <h1>
                        <?php the_field('banner_title', 'option') ?>
                    </h1>

                   <?php }
                    ?>


                    <p class="banner__subtitle"><?php the_field('banner_subtitle', 'option') ?></p>
                    <?php echo do_shortcode('[button_register_line]'); ?>
                    <p class="banner-form__subtitle">На размещение заявки уйдёт 60 секунд :)</p>
                </div>
            </div>
        </div>
    </div>
</section>
