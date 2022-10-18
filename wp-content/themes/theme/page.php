<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package reshaemonline
 */

get_header(); ?>

        <div class="container">

			<?php
				do_action('pretty_breadcrumb');
			?>

		</div>
   
    <?php require_once "page-template/blog.php";?>
<?php
get_footer();