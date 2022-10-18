<?php
/**
 * The template for displaying all pages.
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
                <div class="col-md-8"><h2><?php esc_html_e('Store', 'quality-construction') ?></h2>
                </div>
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
    <section id="section16" class="section16">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 <?php echo $sidebar_primary_classes_alignment; ?> left-block">
                    <?php if (have_posts()) :
                        woocommerce_content();
                    endif;
                    ?>
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