<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package reshaemonline
 */

get_header(); ?>
    <section class="banner__single"></section>
    <section class="container">
       <div class="container">

		<?php
			do_action('pretty_breadcrumb');
		?>

		</div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if(is_category()) :
                    echo category_description();
                endif; ?>
            </div>
            <?php
            $loop = new WP_Query( array(
                    'category_name' => 'blog',
                    'posts_per_page' => -1
                )
            );
            ?>

            <?php while ( $loop->have_posts() ) : $loop->the_post();?>

                <div class="col-md-12">
                    <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                    <?php the_excerpt() ?>
                </div>

            <?php endwhile; wp_reset_query(); ?>
        </div>
    </section>

<?php
get_footer();
