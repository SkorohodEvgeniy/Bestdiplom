<?php
/**
*
* Template Name: Homepage
*
*/
get_header(); ?>


	<!--Banner Section-->
	<section class="banner" style="background: url('<?php the_field("banner_bg", "option") ?>') no-repeat center / cover;">
		<div class="container">
			<div class="row">
				<div class="col-md-11 col-lg-9">
					<div class="banner__outer">
						<h1>
                            <?php the_field('banner_title', 'option') ?>
                        </h1>
						<p class="banner__subtitle"><?php the_field('banner_subtitle', 'option') ?></p>
                        <?php echo do_shortcode('[button_register_line]'); ?>
                        <p class="banner-form__subtitle">На размещение заявки уйдёт 60 секунд :)</p>
					</div>
				</div>
			</div>
		</div>
	</section>

    <!--How it works-->
    <section class="hiw">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="text-section__title"><?php the_field('_hiw_title', 'option'); ?></h2>
                </div>
            </div>
            <div class="row hiw__outer text-center">
				<?php

				// check if the repeater field has rows of data
				if( have_rows('hiw_elements', 'option') ):

					// loop through the rows of data
					while ( have_rows('hiw_elements', 'option') ) : the_row(); ?>

                        <div class="col-sm-2">
                            <figure class="hiw__item">
                                <img class="hiw__icon" src="<?php the_sub_field('icon')?>" alt="Иконка">
                                <figcaption class="hiw__caption">
                                    <p><?php the_sub_field('short_description')?></p>
                                </figcaption>
                            </figure>
                        </div>

					<?php endwhile; endif; ?>
            </div>
        </div>
    </section>

    <section class="strapline-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                    <h2 class="ss__title"><?php the_field('_strapline-text') ?></h2>
                    <p class="ss__subtitle"><?php the_field('_strapline-subtext') ?></p>
                </div>
            </div>
        </div>
    </section>

	<!--Info grid Section-->
	<section class="info-grid">
		<div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="text-section__title"><?php the_field('_hiw_title', 'option'); ?></h2>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12 info-grid__outer">
					<?php

					// check if the repeater field has rows of data
					if( have_rows('bullets') ):

						// loop through the rows of data
						while ( have_rows('bullets') ) : the_row(); ?>

                            <div class="col-md-5ths col-sm-6">
                                <figure class="info-grid__item">
                                    <img src="<?php the_sub_field('bullet_icon'); ?>" alt="Иконка">
                                    <h3 class="info-grid__title"><?php the_sub_field('bullet_title'); ?></h3>
                                    <figcaption class="info-grid__caption">
                                        <p><?php the_sub_field('bullet_short_description'); ?></p>
                                    </figcaption>
                                </figure>
                            </div>

                        <?php endwhile; endif; ?>
				</div>
			</div>
		</div>
	</section>

    <!--Reviews Section-->
    <section class="reviews-section">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="review__outer">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="reviews">
                                <ul class="reviews-container">
	                                <?php
	                                $loop = new WP_Query( array(
			                                'post_type' => 'review',
			                                'posts_per_page' => -1
		                                )
	                                );
	                                ?>

	                                <?php $i = 0; while ( $loop->have_posts() ) : $loop->the_post();?>

                                        <li class="reviews__item">
                                            <h3 class="review__title"><?php the_title(); ?></h3>
                                            <p class="review__content"><?php the_field('review_text') ?></p>
                                            <select id="rate-<?php echo $i;?>">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </li>




	                                <?php ++$i; endwhile; wp_reset_query(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Stats Section-->
    <section class="stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-10 col-md-offset-1">
                    <div class="row">
                        <script>
                            var options = {
                                useEasing: true,
                                separator: ' '
                            };
                        </script>
	                    <?php

	                    // check if the repeater field has rows of data
	                    if ( have_rows( '_stats_elem', 'option' ) ): $i = 1;

		                    // loop through the rows of data
		                    while ( have_rows( '_stats_elem', 'option' ) ) : the_row(); ?>

                                <div class="col-sm-4">
                                    <img src="<?php the_sub_field( 'icon' ); ?>" alt="">
                                    <p id="statsNumber_<?php echo $i ?>"
                                       class="stats__number"><?php the_sub_field( 'number' ); ?></p>
                                    <h3 class="stats__title"><?php the_sub_field( 'title' ); ?></h3>
                                </div>

                                <script>
                                    jQuery(document).ready(function () {
                                        var demo<?php echo $i; ?> = new CountUp('statsNumber_<?php echo $i; ?>', 0, <?php the_sub_field( 'number' ); ?>, 0, 2.5, options);
                                        if (!demo<?php echo $i; ?>.error) {
                                            demo<?php echo $i; ?>.start();
                                        } else {
                                            console.error(demo<?php echo $i; ?>.error);
                                        }
                                    });
                                </script>

			                    <?php ++$i; endwhile; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Text Section-->
    <section class="text-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="text-section__title"><?php the_field('_ta_2_title') ?></h2>
                </div>
                <div class="col-sm-3 col-md-2 text-center">
                    <img class="text-section__icon" src="<?php the_field('_ta_2_icon') ?>" alt="Иконка">
                </div>
                <div class="col-sm-9 col-md-9 text-section__content">
	                <?php the_field('_ta_2_content') ?>
                </div>
            </div>
        </div>
    </section>

    <!--Text Section-->
    <section class="text-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="text-section__title"><?php the_field('_ta_3_title') ?></h2>
                </div>
                <div class="col-sm-3 col-md-2 text-center">
                    <img class="text-section__icon" src="<?php the_field('_ta_3_icon') ?>" alt="Иконка">
                </div>
                <div class="col-sm-9 col-md-9 text-section__content">
	                <?php the_field('_ta_3_content') ?>
                </div>
            </div>
        </div>
    </section>

<?php get_footer();
