<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package reshaemonline
 */

get_header(); ?>

    <section class="banner__single"></section>

    <section class="container text-section pb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb">
					<?php
					if ( function_exists( "bcn_display" ) ) {
						bcn_display();
					}
					?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-section__title-wrapper mb-0-h1">
                <h1><?php the_title() ?></h1>
            </div>
        </div>
    </section>

    <section class="text-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8 clearfix">
	                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		                    <?php the_content(); ?>

	                    <?php endwhile; wp_reset_postdata(); ?>
	                    <?php endif; ?>
                    </div>
                    <div class="col-md-4 single__pricelist-outer clearfix">
                        <div class="col-md-12 info-grid__outer info-grid__single">
							<?php

							// check if the repeater field has rows of data
							if( have_rows('bullets', 73) ): $i = 1;

								// loop through the rows of data
								while ( have_rows('bullets', 73) ) : the_row(); if($i <= 3) : ?>

                                    <div class="col-sm-4">
                                        <figure class="info-grid__item">
                                            <img src="<?php the_sub_field('bullet_icon'); ?>" alt="Иконка">
                                            <h3 class="info-grid__title"><?php the_sub_field('bullet_title'); ?></h3>
                                        </figure>
                                    </div>

								<?php endif; ++$i;  endwhile; endif; ?>
                        </div>
                        <div class="col-md-10 col-md-offset-1 info-grid__outer info-grid__single">
							<?php

							// check if the repeater field has rows of data
							if( have_rows('bullets', 73) ): $i = 1;

								// loop through the rows of data
								while ( have_rows('bullets', 73) ) : the_row(); if($i > 3) : ?>

                                    <div class="col-sm-6">
                                        <figure class="info-grid__item">
                                            <img src="<?php the_sub_field('bullet_icon'); ?>" alt="Иконка">
                                            <h3 class="info-grid__title"><?php the_sub_field('bullet_title'); ?></h3>
                                        </figure>
                                    </div>

								<?php endif;  ++$i; endwhile; endif; ?>
                        </div>
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

<?php
get_footer();