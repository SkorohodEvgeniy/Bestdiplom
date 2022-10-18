<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Canyon Themes
 * @subpackage Quality Construction
 */
$quality_construction_breadcrump_option = quality_construction_get_option('quality_construction_breadcrumb_setting_option');
$quality_construction_designlayout = get_post_meta(get_the_ID(), 'quality_construction_sidebar_layout', true  );
$quality_construction_hide_breadcrump_option = quality_construction_get_option('quality_construction_hide_breadcrumb_front_page_option');
get_header(); 

$sidebardesignlayout = esc_attr(quality_construction_get_option( 'quality_construction_sidebar_layout_option' ) );

/* check if sidebar layout is overridden in individual page settings */
if(isset($quality_construction_designlayout) && $quality_construction_designlayout != 'default-sidebar' ){
	$sidebardesignlayout = $quality_construction_designlayout;
	
} else{
	$quality_construction_designlayout = $sidebardesignlayout ;
}

$sidebar_primary_classes_alignment =  ' col-md-9 ' ;

if ( $quality_construction_designlayout == 'left-sidebar') { 
	$sidebar_primary_classes_alignment =  ' col-md-9 order-md-2' ;
}

if( ($quality_construction_hide_breadcrump_option== 1 && is_front_page()) || !is_front_page())
{
?>
    <section id="inner-title" class="inner-title" <?php echo $header_style; ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-8"><h2><?php the_title(); ?></h2></div>
                <?php
                if ($quality_construction_breadcrump_option == "enable") {
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
 <?php } ?>   
    <section id="section16" class="section16">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 <?php echo $sidebar_primary_classes_alignment; ?> left-block">
                    <?php
                    while (have_posts()) : the_post();

                        get_template_part('template-parts/content', 'page');

                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;

                    endwhile; // End of the loop.
                    ?>
                </div><!-- div -->
				<?php
				 $sidebar_classes_alignment =  '' ;
				 
				 if ( $sidebardesignlayout == 'left-sidebar') { 
				  $sidebar_classes_alignment =  'order-md-1' ;
				 
				 }                     
				 if ( $sidebardesignlayout != 'no-sidebar') { ?>
				 
				 
					<div class="col-sm-12 col-md-3 <?php echo $sidebar_classes_alignment; ?>">
				
						<?php get_sidebar(); ?>
				 
					</div>
				<?php } ?>
            </div><!-- div -->
        </div>
    </section>

<?php get_footer();
