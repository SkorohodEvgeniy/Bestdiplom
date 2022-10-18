<?php

//Instagram shortcode

add_shortcode( 'instagram', 'instagram_shortcode' );

function instagram_shortcode($atts){
	ob_start();
	?>
	
		<section class="join-us">
		  <picture>
			<source
			  srcset="<?php echo get_bloginfo("template_url"); ?>/media/images/bg-inst-m.svg"
			  media="(max-width: 426px)"
			/>

			<img
			  src="<?php echo get_bloginfo("template_url"); ?>/media/images/join-us__bg.svg"
			  alt="join us backgorund"
			  loading="lazy"
			  width="1920"
			  height="586"
			  class="join-us__bg"
			/>
		  </picture>
		  <div class="container">
			<div class="join-us__inner">
			  <div class="join-us__text-box">
				<?php the_field('_insta_title', 'option'); ?>
				<p class="join-us__text">
				  <?php the_field('_insta_content', 'option'); ?>
				</p>
				<a href="<?php the_field('_insta_link', 'option'); ?>" class="btn join-us__btn">Подписаться</a>
			  </div>
			  <div class="join-us__img-box">
				<img
				  src="<?php the_field('_img_insta', 'option'); ?>"
				  alt="join us"
				  width="518"
				  height="447"
				  class="join-us__img"
				/>
			  </div>
			</div>
		  </div>
		</section>
<?php	
return ob_get_clean();
}



//Banner shortcode

add_shortcode( 'banners', 'banner_shortcode' );

function banner_shortcode($atts){
	ob_start();
	?>
	    <div class="banner">
			<a href="<?php the_field('_banner_link', 'option'); ?>">
			  <img src="<?php the_field('_banner_img', 'option'); ?>">
			</a>
		</div>
	<?php	
return ob_get_clean();
}