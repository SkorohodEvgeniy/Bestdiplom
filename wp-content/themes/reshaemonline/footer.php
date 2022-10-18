<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package reshaemonline
 */

?>

<!--Banner Section-->
<section class="banner banner--second">
    <div class="container">
        <div class="row">
            <div class="col-md-11 col-lg-9">
                <div class="banner__outer">
                    <h2 class="banner__title"><?php the_field('_cta_title', 'option') ?></h2>
                    <?php echo do_shortcode('[button_register_line]'); ?>
                    <p class="banner-form__subtitle">На размещение заявки уйдёт 60 секунд :)</p>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <p class="footer__description"><?php the_field('_footer_subtitle', 'option') ?></p>
                <img class="footer__payments" src="<?php the_field('_footer_payment-icon', 'option') ?>" alt="Payments">
                <ul class="footer__ul-a">
                    <li><a href="/vacancies">Вакансии</a></li>
                    <li class="footer__line"></li>
                    <li><a href="/about-us">Про Компанию</a></li>
                    <li class="footer__line"></li>
                    <li><a href="/sitemap.html">Карта сайта</a></li>
                    <li class="footer__line"></li>
                    <li><a href="/contacts">Контакты</a></li>
                </ul>
            </div>
            <div class="col-md-6 two-center">
                <h5 class="two-header">Мы в регионах:</h5>
                <ul class="two-column">
                    <li class="two-li"><a class="two-a" href="/zakazat-kursovuyu-rabotu-v-breste/">Брест</a></li>
                    <li class="two-li"><a class="two-a" href="/zakazat-kursovuyu-rabotu-v-vitebske/">Витебск</a></li>
                    <li class="two-li"><a class="two-a" href="/zakazat-kursovuyu-rabotu-v-gomeli/">Гомель</a></li>
                    <li class="two-li"><a class="two-a" href="/zakazat-kursovuyu-rabotu-v-grodno/">Гродно</a></li>
                </ul>
            </div>
            <div class="col-sm-7">
                <div class="col-md-12">
                    <ul class="footer__contacts">
                        <li><a href="tel:<?php $phone = str_replace(' ', '', get_field('phone_number', 'options'));  ?>"><?php the_field('phone_number', 'options') ?></a></li>
                        <li><a href="mailto:<?php the_field('e_mail', 'options') ?>"><?php the_field('e_mail', 'options') ?></a></li>
                        <li><a href="#"><?php the_field('footer__address', 'options') ?></a></li>
                    </ul>
                </div>
                <div class="col-md-12 footer__conf">
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .two-header {
    text-transform: uppercase;
    color: #fff;
    margin-top: 30px;
}

.two-a {
    color: #fff;
}

.two-column {
    column-count: 2;
    column-fill: initial;
    list-style: none;
    margin: 0;
    padding: 0;
    text-transform: uppercase;
    width: 70%;
}

@media all and (max-width: 764px) {
    .footer__ul-a {
        text-align: center;
    }

    .two-center {
        text-align: center;
    }

    .two-column {
        width: initial;
}
}
</style>

<?php wp_footer(); ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-64695449-8"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-64695449-8');

    //кнопка обратного звонка
    (function(d, w, s) {
        var widgetHash = '9p6anbj9kbg4mftn1u3h', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
        gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
        var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
    })(document, window, 'script');
</script>

<?php

if(is_front_page() || is_single() || is_page()) :

$loop = new WP_Query( array(
		'post_type' => 'review',
		'posts_per_page' => -1
	)
);
?>

<?php $i = 0; while ( $loop->have_posts() ) : $loop->the_post();?>

        <script>
            jQuery(document).ready(function() {
                jQuery('#rate-<?php echo $i;?>').barrating({
                    theme: 'fontawesome-stars',
                    readonly: true,
                    initialRating: <?php the_field('review_rate') ?>
                });
            });
        </script>

<?php ++$i; endwhile; wp_reset_query(); endif; ?>

</body>
</html>
