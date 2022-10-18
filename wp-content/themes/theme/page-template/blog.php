
        <div class="container blog-page">
          <article>
            <section class="blog-page__content">
			<h2
                class="join-us__section-heading section-heading section-heading--decor-left"
              >
                <?php the_title(); ?>
              </h2>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <?php the_content(); ?>

                    <?php endwhile;
                        wp_reset_postdata(); ?>
            <?php endif; ?>
          </article>
          <aside class="aside">
            <section class="calculator">
              <div class="container">
                <div class="calculator__content">
                  <div class="calculator-form">
                    <div class="form" id="calculator-form">
                     <?php echo do_shortcode("[na5ku_form_inline]"); ?>
                    </div>
                    <div class="total">
                      <div class="time">
                        <img
                          src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/clock.svg"
                          alt="clock"
                          width="40"
                          height="40"
                        />
                        <p>Ответим менее, чем за <b>2 часа</b></p>
                      </div>
                      <div class="sale">
                        <img
                          src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/sale.svg"
                          alt="sale"
                          width="40"
                          height="40"
                        />
                        <p>Скидка на первый заказ - <b>5%</b></p>
                      </div>
                      <div class="total-box" id="total-box">
                        <div class="text">
                          <img
                            src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/money.svg"
                            alt="money"
                            width="40"
                            height="40"
                          />
                          <p>Предварительная стоимость:</p>
                        </div>
                        <div class="sum"><span>2555</span> $</div>
                      </div>
                    </div>
                  </div>

                  <p class="private-policy">
                    Я даю согласие на обработку своих персональных данных в
                    соответствии с политикой конфиденциальности и принимаю
                    условия договора <a href="<?php the_field("_public_ofer", "option"); ?>">публичной оферты</a>
                  </p>
                </div>
              </div>
            </section>
          
		  
				<section class="how-work__buttons">
					<h3 class="how-work__title">Как работает сервис</h3>
					  <div class="how-work__buttons-inner">
						<button class="how-work-button how-work__how-work-button">
						  <span class="how-work-button__text-box">Заполните заявку на сайте и узнайте точную стоимость работы <span class="text__blue"> за 2 часа</span></span>
						  <span class="how-work-button__number-box">
							<span class="how-work-button__number">1</span>
						  </span>
						</button>
						<button class="how-work-button how-work__how-work-button">
						  <span class="how-work-button__text-box">Внесите предоплату в размере <span class="text__blue">30%</span> и мы приступим к выполнению</span>
						  <span class="how-work-button__number-box">
							<span class="how-work-button__number">2</span>
						  </span>
						</button>
						<button class="how-work-button how-work__how-work-button">
						  <span class="how-work-button__text-box">После выполнения работы ознакомитесь с ее частью и внесите остаток оплаты</span>
						  <span class="how-work-button__number-box">
							<span class="how-work-button__number">3</span>
						  </span>
						</button>
						<button class="how-work-button how-work__how-work-button ">
						  <span class="how-work-button__text-box">Если нужны будут правки - отправьте работу на доработку</span>
						  <span class="how-work-button__number-box">
							<span class="how-work-button__number">4</span>
						  </span>
						</button>
						<button class="how-work-button how-work__how-work-button ">
						  <span class="how-work-button__text-box">Сдайте работу на отлично!</span>
						  <span class="how-work-button__number-box">
							<span class="how-work-button__number owl">
								<img src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/m-logo 1.svg">
							</span>
						  </span>
						</button>
					  </div>
                </section>
		  </aside>
        </div>
        <section class="last-in-blog">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/last-in-blog__bg.svg"
            alt="last in blog background"
            width="1920"
            height="676"
            class="last-in-blog__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/last-in-blog__bg-mobile.svg"
            alt="last in blog background"
            width="320"
            height="502"
            class="last-in-blog__bg-mobile"
          />
          <div class="container">
            <div class="last-in-blog__inner">
              <h2
                class="last-in-blog__section-heading section-heading section-heading--decor-right section-heading--decor-left"
              >
                Похожие записи
              </h2>
              <div class="last-in-blog__swiper swiper">
                <ul class="last-in-blog__swiper-wrapper swiper-wrapper">
                  <?php
						global $post;
						$postslist = get_posts( [
							'posts_per_page' => 10,
							'orderby' => 'date',
							'category_name' => 'blog'
						] );

						foreach( $postslist as $post ){
							setup_postdata($post);
							?>
							<li class="last-in-blog__swiper-slide swiper-slide">
							<div
							  class="last-in-blog-card last-in-blog__last-in-blog-card"
							>
							   <?php 
									//должно находится внутри цикла
									if( has_post_thumbnail() ) {
										$default_attr = array(
											'class' => "last-in-blog-card__img",
											'alt'   => trim(strip_tags( $wp_postmeta->_wp_attachment_image_alt )),
										);
										the_post_thumbnail( array(370, 283), $default_attr );
									}
									else {
										echo '<img src="'.get_bloginfo("template_url").'/media/images/last-in-blog/1.jpg" />';
									}
								?>
							  <?php  ?>
							  <div class="last-in-blog-card__text-box">
								<h3 class="last-in-blog-card__heading">
								 <?php the_title(); ?>
								</h3>
								<p class="last-in-blog-card__text">
								<?php the_excerpt(); ?>
								</p>
								<div class="last-in-blog-card__footer">
								  <time class="last-in-blog-card__date"
									><?php the_date(); ?></time
								  >
								  <a href="<?php echo the_permalink(); ?>" class="last-in-blog-card__read-more"
									>Читать далее</a
								  >
								</div>
							  </div>
							  <h3 class="last-in-blog-card__heading-inner">
								<?php the_title(); ?>
							  </h3>
							</div>
						  </li>
							<?php
						}

						wp_reset_postdata();
					?>
                </ul>
                <div class="last-in-blog__btns">
                  <button
                    type="button"
                    class="last-in-blog__swiper-btn swiper-btn swiper-btn--prev"
                  >
                    <svg
                      width="15"
                      height="14"
                      viewBox="0 0 15 14"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clip-path="url(#clip0_40_294)">
                        <path
                          class="arrow"
                          d="M0.226734 6.45631L5.28262 1.4003C5.42694 1.25598 5.61929 1.17676 5.8244 1.17676C6.02973 1.17676 6.22197 1.25609 6.36629 1.4003L6.82533 1.85945C6.96954 2.00355 7.04899 2.19602 7.04899 2.40124C7.04899 2.60634 6.96954 2.8053 6.82533 2.94939L3.8758 5.90541L13.2466 5.90541C13.6691 5.90541 14.0029 6.23618 14.0029 6.65879L14.0029 7.30791C14.0029 7.73052 13.6691 8.09463 13.2466 8.09463L3.84234 8.09463L6.82522 11.0672C6.96943 11.2115 7.04887 11.3987 7.04887 11.6039C7.04887 11.8089 6.96943 11.9989 6.82522 12.1431L6.36618 12.6008C6.22186 12.7451 6.02962 12.8237 5.82429 12.8237C5.61918 12.8237 5.42683 12.7441 5.2825 12.5997L0.22662 7.54386C0.0819555 7.39908 0.0023952 7.20581 0.00296453 7.00037C0.00250961 6.79424 0.0819554 6.60086 0.226734 6.45631Z"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_40_294">
                          <rect
                            width="14"
                            height="14"
                            fill="white"
                            transform="matrix(-1 8.74234e-08 8.74222e-08 1 14.0029 0)"
                          />
                        </clipPath>
                      </defs>
                    </svg>
                  </button>
                  <button
                    type="button"
                    class="last-in-blog__swiper-btn swiper-btn swiper-btn--next"
                  >
                    <svg
                      width="15"
                      height="14"
                      viewBox="0 0 15 14"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <g clip-path="url(#clip0_40_294)">
                        <path
                          class="arrow"
                          d="M0.226734 6.45631L5.28262 1.4003C5.42694 1.25598 5.61929 1.17676 5.8244 1.17676C6.02973 1.17676 6.22197 1.25609 6.36629 1.4003L6.82533 1.85945C6.96954 2.00355 7.04899 2.19602 7.04899 2.40124C7.04899 2.60634 6.96954 2.8053 6.82533 2.94939L3.8758 5.90541L13.2466 5.90541C13.6691 5.90541 14.0029 6.23618 14.0029 6.65879L14.0029 7.30791C14.0029 7.73052 13.6691 8.09463 13.2466 8.09463L3.84234 8.09463L6.82522 11.0672C6.96943 11.2115 7.04887 11.3987 7.04887 11.6039C7.04887 11.8089 6.96943 11.9989 6.82522 12.1431L6.36618 12.6008C6.22186 12.7451 6.02962 12.8237 5.82429 12.8237C5.61918 12.8237 5.42683 12.7441 5.2825 12.5997L0.22662 7.54386C0.0819555 7.39908 0.0023952 7.20581 0.00296453 7.00037C0.00250961 6.79424 0.0819554 6.60086 0.226734 6.45631Z"
                        />
                      </g>
                      <defs>
                        <clipPath id="clip0_40_294">
                          <rect
                            width="14"
                            height="14"
                            fill="white"
                            transform="matrix(-1 8.74234e-08 8.74222e-08 1 14.0029 0)"
                          />
                        </clipPath>
                      </defs>
                    </svg>
                  </button>
                </div>
                <div
                  class="last-in-blog__swiper-pagination swiper-pagination"
                ></div>
              </div>
            </div>
          </div>
        </section>