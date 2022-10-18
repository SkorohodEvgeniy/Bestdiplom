<section class="objects objects--single">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="text-section__title <?php if(!is_front_page()) : echo 'text-section__title__single'; endif; ?>">Решение задач по предметам</h2>
			</div>
			<div class="col-md-12">
				<ul class="objects-outer">

					<?php
					$loop = new WP_Query( array(
							'post_type' => 'post',
							'posts_per_page' => -1
						)
					);

					$ID = get_the_ID();
					?>


					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php if( get_field('_object_name') && $ID != get_the_ID() ) :?>

						<li><a href="<?php the_permalink(); ?>"><?php the_field('_object_name'); ?></a></li>

						<?php endif; ?>

					<?php endwhile; wp_reset_query(); ?>

				</ul>
			</div>
		</div>
	</div>
</section>