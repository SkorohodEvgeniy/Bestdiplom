<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package reshaemonline
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			<div class="section-404 col-xs-12 text-center">
				<h2>Ошибка 404. По Вашему запросу ничего не найдено. <a href="/">Главная страница</a></h2>
			</div>
            <div class="col-xs-12 text-center">
                <ul class="section-404-pipular-posts">
	                <?php dynamic_sidebar( 'sidebar-2' ); ?>
                </ul>
            </div>
		</div>
	</div>
    <br><br>

<?php
get_footer();
