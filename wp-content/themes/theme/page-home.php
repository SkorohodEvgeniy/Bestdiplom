<?php
/**
 *
 * Template Name: Homepage
 *	
 */
get_header(); ?>



<!--New Page-->
 <section class="help-write">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/bg-help-write.svg"
            alt="we go background"
            width="1920"
            height="789"
            class="help__bg"
          />
          <img
            src="<?php the_field("_photo_face"); ?>"
            alt="face"
            width="671"
            height="529"
            class="face-img"
          />
          <div class="container">
            <div class="help-write__content">
              <h1 class="title">
               
				<?php the_field('_strapline_text') ?>
              </h1>
              
			  <?php the_field('_strapline_subtext') ?>
              <ul class="items-lists">
				<?php

                    // check if the repeater field has rows of data
                    if (have_rows('bullets')):

                        // loop through the rows of data
                        while (have_rows('bullets')) : the_row(); ?>

							<li>
							  <img
								src="<?php the_sub_field('bullet_icon'); ?>"
								alt="need"
								width="50"
								height="50"
							  />
							  <div class="list-content">
								<h5><?php the_sub_field('bullet_title'); ?></h5>
								<p>
								  <?php the_sub_field('bullet_short_description'); ?>
								</p>
							  </div>
							</li>
                <?php endwhile; endif; ?>
              
              </ul>
              <a href="#calculator-form" class="btn">Узнать стоимость</a>
            </div>
          </div>
        </section>

<section class="calculator" id="calculator-form">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/bg-calculator.svg"
            alt="bg-calculator"
            width="1920"
            height="789"
            class="calculator__bg"
          />

          <div class="container">
            <div class="calculator__content">
              <h2 class="section-heading section-heading--decor-left">
            
				 <?php the_field('title_calc', 'option') ?>
              </h2>
              
			   <?php the_field('subtitle_calc', 'option') ?>
              <div class="calculator-form">
                <div class="form">
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
                  <div class="total-box">
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

              <p class="private-policy pl-40">
                Я даю согласие на обработку своих персональных данных в
                соответствии с политикой конфиденциальности и принимаю условия
                договора <a href="<?php the_field("_public_ofer", "option"); ?>">публичной оферты</a>
              </p>
            </div>
          </div>
        </section>

<section class="we-do">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/we-do__bg.png"
            alt="we go background"
            width="1920"
            height="1096"
            class="we-do__bg"
          />
          <div class="container">
            <div class="we-do__inner">
              <h2
                class="section-heading section-heading--decor-left we-do__section-heading"
              >
			   <?php the_field('_we_do_title', 'option') ?>
                </h2>
              <div class="we-do__cards">
			  
				<?php

                    // check if the repeater field has rows of data
                    if (have_rows('we_do_card', 'option')):

                        // loop through the rows of data
                        while (have_rows('we_do_card', 'option')) : the_row(); ?>

							
							<div class="we-do-card we-do__we-do-card">
							  <div>
								<header
								  class="we-do-card__header we-do-card__header--clr-<?php the_sub_field('_color_head'); ?>"
								>
								  <h3 class="we-do-card__heading"><?php the_sub_field('we_do_title'); ?>Дипломные работы</h3>
								  <img
									src="<?php the_sub_field('we_do_icon'); ?>"
									alt="alt"
									width="31"
									height="44"
									class="we-do-card__icon"
								  />
								</header>
								<div class="we-do-card__body">
								  <ul class="key-value-list we-do-card__key-value-list">
									<?php

										// check if the repeater field has rows of data
										if (have_rows('we_do_lists')):

											// loop through the rows of data
											while (have_rows('we_do_lists')) : the_row(); ?>
												<li class="key-value-list__item">
												  <p class="key-value-list__key"><?php the_sub_field('_list_title'); ?></p>
												  <p class="key-value-list__value"><?php the_sub_field('_list_description'); ?></p>
												</li>

									<?php endwhile; endif; ?>
									
								  </ul>
								</div>
							  </div>
							  <footer class="we-do-card__footer">
								<div class="we-do-card__price-box">
								  <p class="we-do-card__footer-text">Цена:</p>
								  <p class="we-do-card__price"><?php the_sub_field('we_do_price'); ?></p>
								</div>
								<div class="we-do-card__btn-box">
								  <a href="#calculator-form" class="btn we-do-card__btn">Заказать</a>
								</div>
							  </footer>
							</div>
                <?php endwhile; endif; ?>
                
              </div>
              <div class="additional-services">
                <h2
                  class="section-heading section-heading--size-md section-heading--decor-left additional-services__section-heading"
                >
                  Дополнительные услуги
                </h2>
                <div class="additional-services__cards">
					<?php

                    // check if the repeater field has rows of data
                    if (have_rows('_dop_lists', 'option')):

                        // loop through the rows of data
                        while (have_rows('_dop_lists', 'option')) : the_row(); ?>

						<div class="additional-service-card additional-services__additional-service-card">
							<h3 class="additional-service-card__heading">
							  <?php the_sub_field('_name_list'); ?>
							</h3>
							<div class="additional-service-card__footer">
							  <p class="additional-service-card__text">Цена:</p>
							  <p class="additional-service-card__price"><?php the_sub_field('_price_list'); ?></p>
							</div>
						</div>
					<?php endwhile; endif; ?>
				  
                </div>
              </div>
            </div>
          </div>
        </section>

<section class="how-work">
          <img
            loading="lazy"
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/bg-how-work.svg"
            width="1920"
            height="767"
            alt="how-work"
            class="how-work-bg"
          />

          <div class="container">
            <div class="how-work__inner">
              <h2
                class="section-heading section-heading--decor-left how-work__section-heading"
              >
                Как работает сервис
              </h2>
              <div class="how-work__content">
                <div class="how-work__images">
				
                  <img
                    src="  <?php the_field('_how_work_image_1', 'option') ?>"
                    alt="alt"
                    width="641"
                    height="482"
                    class="how-work__img how-work__img--active"
                  />
                  <img
                    src="  <?php the_field('_how_work_image_2', 'option') ?>"
                    alt="alt"
                    width="641"
                    height="482"
                    class="how-work__img"
                  />
                  <img
                    src="  <?php the_field('_how_work_image_3', 'option') ?>"
                    alt="alt"
                    width="641"
                    height="482"
                    class="how-work__img"
                  />
                  <img
                    src="  <?php the_field('_how_work_image_4', 'option') ?>"
                    alt="alt"
                    width="641"
                    height="482"
                    class="how-work__img"
                  />
                </div>
                <div class="how-work__buttons">
                  <div class="how-work__buttons-inner">
                    <button
                      class="how-work-button how-work-button--active how-work__how-work-button"
                    >
                      <span class="how-work-button__text-box"><?php the_field('_how_work_btn_1', 'option') ?></span>
                      <span class="how-work-button__number-box">
                        <span class="how-work-button__number">1</span>
                      </span>
                    </button>
                    <button class="how-work-button how-work__how-work-button">
                      <span class="how-work-button__text-box"><?php the_field('_how_work_btn_2', 'option') ?></span>
                      <span class="how-work-button__number-box">
                        <span class="how-work-button__number">2</span>
                      </span>
                    </button>
                    <button class="how-work-button how-work__how-work-button">
                      <span class="how-work-button__text-box"><?php the_field('_how_work_btn_3', 'option') ?></span>
                      <span class="how-work-button__number-box">
                        <span class="how-work-button__number">3</span>
                      </span>
                    </button>
                    <button class="how-work-button how-work__how-work-button">
                      <span class="how-work-button__text-box"><?php the_field('_how_work_btn_4', 'option') ?></span>
                      <span class="how-work-button__number-box">
                        <span class="how-work-button__number">4</span>
                      </span>
                    </button>
                  </div>
                  <a href="#calculator-form" class="btn btn--size-md how-work__btn">
                    Заполните форму
                  </a>
                </div>
              </div>
              <div class="how-work__text-info">
                <p class="how-work__text">
                  Внесите предоплату и мы приступим к работе
                </p>
                <a href="#calculator-form" class="btn btn--size-md how-work__text-into-btn">
                  Заполните форму
                </a>
              </div>
            </div>
          </div>
        </section>
		<section class="request">
          <picture>
            <source
              srcset="<?php echo get_bloginfo("template_url"); ?>/media/images/workers/bg-request.svg"
              media="(min-width: 426px)"
              class="request__bg"
            />

            <img src="<?php echo get_bloginfo("template_url"); ?>/media/images/workers/bg-request--mobile.svg"
            loading="lazy" alt="bg" width="320" height="526"
            class="how-work-bg" />
          </picture>

          <div class="container">
            <div class="request__inner">
              <h2 class="section-heading section-heading--decor-left">
                Заполните заявку <br />на просчет и получите:
              </h2>
              <div class="request__content">
                <div class="request__content-items">
				<?php

                    // check if the repeater field has rows of data
                    if (have_rows('request')):
						$count = 0;
                        // loop through the rows of data
                        while (have_rows('request')) : the_row(); 
							$count++;
							if( $count%2 === 0 ):
						?>
							<div class="item">
								<div class="lists">
									<?php the_sub_field('_content_block'); ?>
								</div>
								<div class="icon">
								  <picture>
									<source
									  srcset="<?php the_sub_field('_icon_mobile'); ?>"
									  media="(max-width: 426px)"
									/>

									<img
									  src="<?php the_sub_field('_icon_desctop'); ?>"
									  loading="lazy"
									  alt="cooperate"
									  width="200"
									  height="200"
									/>
								  </picture>
								</div>
							  </div>
						<?php else: ?>
							<div class="item">
								<div class="icon">
								  <picture>
									<source
									  srcset="<?php the_sub_field('_icon_mobile'); ?>"
									  media="(max-width: 426px)"
									/>
									<img
									  src="<?php the_sub_field('_icon_desctop'); ?>"
									  loading="lazy"
									  alt="motivation"
									  width="200"
									  height="200"
									/>
								  </picture>
								</div>
								<div class="lists">
									<?php the_sub_field('_content_block'); ?>
								</div>
							</div>
                <?php endif; endwhile; endif; ?>
				
                </div>
                <a href="#calculator-form" class="btn partner-program__btn">
                  Узнать стоимость
                </a>
              </div>
            </div>
          </div>
        </section>
		<section class="faq">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/faq__bg.png"
            alt="alt"
            width="1920"
            height="818"
            class="faq__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/faq__bg-mobile.png"
            alt="alt"
            width="320"
            height="674"
            class="faq__bg-mobile"
          />
          <div class="container">
            <div class="faq__inner">
              <h2
                class="faq__section-heading section-heading section-heading--decor-right section-heading--decor-left"
              >
               <?php the_field('faq_title', 'option'); ?>
              </h2>
              <div class="faq__items">
			  
				<?php

                    // check if the repeater field has rows of data
                    if (have_rows('_faq_repeter', 'option')):
						$count = 0;
                        // loop through the rows of data
                        while (have_rows('_faq_repeter', 'option')) : the_row(); 
							$count++;
						?>
						
							<div class="faq-item faq__faq-item">
							  <button class="faq-item__header">
								<span class="faq-item__number-box">
								  <span class="faq-item__number">0<?php echo $count; ?></span>
								</span>
								<h3 class="faq-item__heading"><?php the_sub_field('faq_question'); ?></h3>
								<span class="faq-item__plus-icon"></span>
							  </button>
							  <div class="faq-item__body">
								<div class="faq-item__body-inner">
								  <p class="faq-item__text">
									<?php the_sub_field('faq_answer'); ?>
									
								  </p>
								</div>
							  </div>
							</div>
							
                <?php endwhile; endif; ?>
				
             
              </div>
              <a href="<?php the_field("_link_faq", "option"); ?>" class="faq__btn btn btn--style-transparent">
                Все вопросы
              </a>
            </div>
          </div>
        </section>
		<section class="last-work">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/workers/bg-last-work.svg"
            alt="bg"
            width="1920"
            height="763"
            class="last-work__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/workers/bg-last-work-mobile.svg"
            alt="bg"
            width="320"
            height="526"
            class="last-work__bg-mobile"
          />
          <div class="container">
            <div class="last-work__inner">
              <h2
                class="section-heading section-heading--decor-right section-heading--decor-left"
              >
                Сделали <span><?php the_field("count_number", "option")?></span> работ
              </h2>
              <p class="last-work__subtitle">Последние выполненные работы</p>
              <div class="last-work__table">
                <table bordercolor="#FAFBFD">
                  <thead class="thead">
                    <tr class="trHead">
                      <th>ТИП</th>
                      <th>ТЕМА</th>
                      <th>СРОК</th>
                      <th>Уникальность</th>
                      <th>Цена,руб</th>
                    </tr> 
                  </thead>
                  <tbody>
					<?php

                    // check if the repeater field has rows of data
                    if (have_rows('last_work', 'option')):

                        // loop through the rows of data
                        while (have_rows('last_work', 'option')) : the_row();

						$date_string = get_sub_field('_data_work');
						$date = DateTime::createFromFormat('Ymd', $date_string);
					?>
								
							<tr>
							  <td><?php the_sub_field('_title_work'); ?></td>
							  <td><?php the_sub_field('_description_work'); ?>
							  </td>
							  <td><?php echo $date->format('Y/m/d'); ?></td>
							  <td><?php the_sub_field('_unic_text'); ?></td>
							  <td><b><?php the_sub_field('_price_text'); ?></b></td>
							</tr>
                <?php endwhile; endif; ?>
             
                  </tbody>
                </table>
                <a href="#calculator-form" class="btn partner-program__btn">
                  Узнать стоимость своей работы
                </a>
              </div>
            </div>
          </div>
        </section>
		<section class="reviews">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/reviews__bg.svg"
            alt="bg"
            width="1920"
            height="707"
            class="reviews__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/reviews__bg-mobile.svg"
            alt="bg"
            width="320"
            height="526"
            class="reviews__bg-mobile"
          />
          <div class="container">
            <div class="reviews__inner">
              <h2
                class="reviews__section-heading section-heading section-heading--decor-right section-heading--decor-left"
              >
				 <?php the_field('reviews_title', 'option'); ?>
              </h2>
              <div class="reviews__swiper swiper">
                <ul class="reviews__slides reviews__swiper-wrapper swiper-wrapper">
					<?php

                    // check if the repeater field has rows of data
                    if (have_rows('reviews_box', 'option')):

                        // loop through the rows of data
                        while (have_rows('reviews_box', 'option')) : the_row(); ?>
							<li class="reviews__slide reviews__swiper-slide swiper-slide">
								<div class="review-card reviews__review-card">
								  <div class="review-card__header">
									<div class="review-card__header-text">
									  <h3 class="review-card__heading"> <?php the_sub_field('reviews_name'); ?></h3>
									  <p class="review-card__age"> <?php the_sub_field('reviews_age'); ?></p>
									</div>
									<img
									  src=" <?php the_sub_field('icon_user'); ?>"
									  alt="image"
									  width="68"
									  height="68"
									  class="review-card__avatar"
									/>
								  </div>
								  <div class="review-card__body read-more-box">
									<p class="review-card__text read-more-text">
										 <?php the_sub_field('reviews_text'); ?>
									</p>
									<button
									  class="review-card__read-more-btn read-more-btn"
									  data-orig-text="Читать далее"
									  data-active-text="Скрыть"
									>
									  Читать далее
									</button>
								  </div>
								</div>
							</li>
					<?php endwhile; endif; ?>
                
                </ul>
                <div class="reviews__btns">
                  <button
                    type="button"
                    class="reviews__swiper-btn swiper-btn swiper-btn--prev"
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
                  <div
                    class="reviews__swiper-pagination swiper-pagination"
                  ></div>
                  <button
                    type="button"
                    class="reviews__swiper-btn swiper-btn swiper-btn--next"
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
              </div>
            </div>
          </div>
        </section>
		<section class="partner-program">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/partner-program__bg.png"
            alt="partner program img"
            width="1920"
            height="817"
            class="partner-program__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/partner-program__bg--mobile.png"
            alt="partner program img"
            width="320"
            height="884"
            class="partner-program__bg-mobile"
          />
          <div class="container">
            <div class="partner-program__inner">
              <h2
                class="partner-program__section-heading section-heading section-heading--decor-right section-heading--decor-left"
              >
                <?php the_field('partner_title', 'option'); ?>
              </h2>
              <div class="partner-program__tabs-box">
                <div class="partner-program__buttons">
                  <button
                    class="partner-program__tab-btn partner-program__tab-btn--active"
                  >
                    <?php the_field('_tab_one', 'option'); ?>
                  </button>
                  <button class="partner-program__tab-btn">
                    <?php the_field('_tab_two', 'option'); ?>
                  </button>
                </div>
                <ul class="partner-program__content">
                  <li class="partner-program__content-card partner-program__content-card--active">
                    <div class="partner-program__text-box">
						<?php the_field('content_tab_1', 'option'); ?>
                      
                      <a href="<?php the_field('_link_tab_1', 'option'); ?>" class="btn partner-program__btn">
                        Присоединится
                      </a>
                    </div>
                    <div class="partner-program__img-box">
                      <img
                        src="<?php the_field('_img_tab_1', 'option'); ?>"
                        alt="partner program"
                        width="450"
                        height="402"
                        class="partner-program__img"
                      />
                    </div>
                  </li>
                  <li class="partner-program__content-card">
                    <div class="partner-program__text-box">
						<?php the_field('content_tab_2', 'option'); ?>
                      
                      <a href="<?php the_field('_link_tab_2', 'option'); ?>" class="btn partner-program__btn">
                        Присоединится
                      </a>
                    </div>
                    <div class="partner-program__img-box">
                      <img
                        src="<?php the_field('_img_tab_2', 'option'); ?>"
                        alt="partner program"
                        width="450"
                        height="402"
                        class="partner-program__img"
                      />
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
		<section class="about">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/about__bg.svg"
            alt="about bg"
            width="1920"
            height="606"
            class="about__bg"
          />
          <div class="container">
            <div class="about__inner">
		
              <div class="about__img-box">
                <img
                  src="<?php the_field("_about_img", 'option'); ?>"
                  alt="about"
                  width="601"
                  height="400"
                  class="about__img"
                />
              </div>
              <div class="about__text-box">
			
                <h2
                  class="about__section-heading section-heading section-heading--decor-left"
                >
				
				<?php the_field("_about_title", 'option'); ?>
                 
                </h2><br>
				<?php the_field("_about_content", 'option'); ?>
               
              </div>
            </div>
          </div>
        </section>
		<section class="workers">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/workers__bg.svg"
            alt="bg"
            width="1920"
            height="664"
            class="workers__bg"
          />
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/workers__bg-mobile.svg"
            alt="bg"
            width="320"
            height="539"
            class="workers__bg-mobile"
          />
          <div class="container">
            <div class="workers__inner">
              <div class="workers__swiper swiper">
                <h2
                  class="workers__section-heading section-heading section-heading--decor-left section-heading--decor-right"
                >
               <?php the_field("_workers_title", 'option'); ?>
                </h2>
                <div class="workers__btns">
                  <button type="button" class="workers__swiper-btn swiper-btn swiper-btn--prev">
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
                  <button type="button" class="workers__swiper-btn swiper-btn swiper-btn--next">
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
                <ul class="workers__swiper-wrapper swiper-wrapper">
					<?php

                    // check if the repeater field has rows of data
                    if (have_rows('_workers_cards', 'option')):

                        // loop through the rows of data
                        while (have_rows('_workers_cards', 'option')) : the_row(); ?>
						  <li class="workers__swiper-slide swiper-slide">
							<div class="worker-card workers__worker-card">
							  <img
								src="<?php the_sub_field('_workers_img'); ?>"
								alt="worker 1"
								width="220"
								height="220"
								class="worker-card__img"
							  />
							  <h3 class="worker-card__name"><?php the_sub_field('_workers_name'); ?></h3>
							  <p class="worker-card__text"><?php the_sub_field('_workers_craft'); ?></p>
							</div>
						  </li>
					<?php endwhile; endif; ?>
                 </ul>
                <div class="workers__swiper-pagination swiper-pagination"></div>
              </div>
              <a href="#calculator-form" class="workers__btn btn">Оформить заявку</a>
            </div>
          </div>
        </section>	
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
                Последнее в блоге
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
                  <button type="button" class="last-in-blog__swiper-btn swiper-btn swiper-btn--prev">
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
                  <button type="button" class="last-in-blog__swiper-btn swiper-btn swiper-btn--next">
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
		<section class="seo-text">
          <img
            src="<?php echo get_bloginfo("template_url"); ?>/media/images/seo-text__bg.svg"
            alt="seo text background"
            width="1920"
            height="917"
            class="seo-text__bg"
          />
          <div class="container">
            <div class="seo-text__inner">
			<h2 class="section-heading section-heading--decor-left seo-text__section-heading">SEO-текст</h2>
			<?php the_content(); ?>
              
            </div>
          </div>
        </section>	
<!--END New page-->




<?php get_footer();