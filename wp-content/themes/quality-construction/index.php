<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Canyon Themes
 * @subpackage Quality Construction
 */
get_header();

$blog_page_title = quality_construction_get_option('quality_construction_blog_title_option');
$quality_construction_breadcrump_option = quality_construction_get_option('quality_construction_breadcrumb_setting_option');
$quality_construction_designlayout = quality_construction_get_option('quality_construction_sidebar_layout_option');

$sidebar_primary_classes_alignment =  ' col-md-9 ' ;

if ( $quality_construction_designlayout == 'left-sidebar') { 
	$sidebar_primary_classes_alignment =  ' col-md-9 order-md-2' ;
}

?>
    <section id="inner-title" class="inner-title" <?php echo $header_style; ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2><?php echo esc_html($blog_page_title); ?></h2>
                </div>
                <?php
                if ($quality_construction_breadcrump_option == "enable") {
                    ?>
                    <div class="col-md-5">
                        <div class="breadcrumbs">
                            <?php breadcrumb_trail(); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section id="section14" class="section-margine">
        <div id="content" class="container">
            <div class="row">
                <div class="col-sm-12 <?php echo $sidebar_primary_classes_alignment; ?> left-block">
                    <?php
                    if (have_posts()) :
                        /* Start the Loop */
                        while (have_posts()) : the_post();
                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part('template-parts/content', get_post_format());

                        endwhile;

                        the_posts_navigation();

                    else :

                        get_template_part('template-parts/content', 'none');

                    endif; ?>

                </div><!--div -->
				<?php
				 $sidebar_classes_alignment =  '' ;
				 
				 if ( $quality_construction_designlayout == 'left-sidebar') { 
				  $sidebar_classes_alignment =  'order-md-1' ;
				 
				 }                     
				 if ( $quality_construction_designlayout != 'no-sidebar') { ?>
				 
				 
					<div class="col-sm-12 col-md-3 <?php echo $sidebar_classes_alignment; ?>">
				
						<?php get_sidebar(); ?>
				 
					</div>
				<?php } ?>

            </div>
        </div><!-- div -->
    </section>

<?php get_footer();
