<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Canyon Themes
 * @subpackage Quality Construction
 */
$quality_construction_breadcrump_option = quality_construction_get_option('quality_construction_breadcrumb_setting_option');
$quality_construction_designlayout = quality_construction_get_option('quality_construction_sidebar_layout_option');
get_header(); 


$sidebar_primary_classes_alignment =  ' col-md-9 ' ;

if ( $quality_construction_designlayout == 'left-sidebar') { 
	$sidebar_primary_classes_alignment =  ' col-md-9 order-md-2' ;
}

?>
    <section id="inner-title" class="inner-title"  <?php echo $header_style; ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><?php printf(esc_html__('Search Results for: %s', 'quality-construction'), '<span>' . get_search_query() . '</span>'); ?></h2>
                </div>
                <?php if ($quality_construction_breadcrump_option == "enable") {
                    ?>
                    <div class="col-md-4">
                        <div class="breadcrumbs">
                            <?php breadcrumb_trail(); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section id="section16" class="section16">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 <?php echo $sidebar_primary_classes_alignment; ?> left-block">
                    <?php
                    if (have_posts()) : ?>

                        <?php
                        /* Start the Loop */
                        while (have_posts()) : the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part('template-parts/content', 'search');

                        endwhile;

                        the_posts_navigation();

                    else :

                        get_template_part('template-parts/content', 'none');

                    endif; ?>

                </div><!-- div -->
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
            </div><!-- div -->
        </div>
    </section>

<?php get_footer();
