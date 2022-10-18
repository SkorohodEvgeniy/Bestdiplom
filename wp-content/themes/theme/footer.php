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

</main>

<!--New Footer-->
   <footer class="footer">
        <div class="footer__content">
          <div class="container">
            <div class="footer__grid">
              <div class="footer__grid-item">
                <div class="logo footer__logo">
                  <a href="#" class="logo__link"
                    ><img
                      src=" <?php the_field('_big-logo', 'option') ?>"
                      alt="logo"
                      width="183"
                      height="47"
                      class="logo__img"
                  /></a>
                </div>
                <div class="bank-cards footer__bank-cards">
                  <div class="bank-cards__item">
                    <img
                      src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/mastercard.svg"
                      alt="mestercard"
                      width="70"
                      height="44"
                      class="bank-cards__icon"
                    />
                  </div>
                  <div class="bank-cards__item">
                    <img
                      src="<?php echo get_bloginfo("template_url"); ?>/media/images/icons/visa.svg"
                      alt="visa"
                      width="70"
                      height="44"
                      class="bank-cards__icon"
                    />
                  </div>
                </div>
				</div>
				<div class="footer__grid-item footer-menu-left">
					<?php
					   wp_nav_menu(array(
						   'theme_location' => 'footer_menu-l')
						);
					?>
               	</div>
				<div class="footer__grid-item footer-menu-right">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'footer_menu-r')
						);
					?>
              	</div>
				<div class="footer__grid-item">
					<?php the_field('_footer_subtitle', 'option') ?>
				</div>
            </div>
          </div>
        </div>
        <div class="footer__copy">
          <div class="container">
            <div class="footer__copy-inner">
              <p class="footer__copy-text">
                Пользуясь услугами данного сайта вы принимаете нашу политику
                конфиденциальности
              </p>
            </div>
          </div>
        </div>
      </footer>
	  
	 </div>  
<!--END New Footer-->






<style>
    .two-header {
    text-transform: uppercase;
    color: #60ebd4;
    margin-top: 30px;
}

.two-a {
    color: #60ebd4;
}

.two-column {
    column-count: 1;
    column-fill: initial;
    list-style: none;
    margin-top: 27px;
    margin-left: 15%;
    padding: 0;
    text-transform: none;
    font-size: 16px;
    width: 90%;
    justify-content: center;
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



<?php

if(is_front_page() || is_single() || is_page() || in_category('blog')) :

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

<?php wp_footer(); ?>

<div id="reg-message" style="display: none;">
    <div class="mfp-bg mfp-fade mfp-ready" style="height: 100%; "></div>
    <div class="mfp-wrap mfp-auto-cursor mfp-fade mfp-ready" tabindex="-1" style="top: 0px; position: absolute; height: 455px;">
        <div class="mfp-container mfp-s-ready mfp-inline-holder"><div class="mfp-content">
                <div id="register-popup_message" class="popup"><b style="color:red">Введите почту правильно</b></div>
            </div>
            <div class="mfp-preloader reg-message1">Loading...</div>
        </div>
    </div>
</div>
<style>
    .popup {
        position: relative;
        background: #fff;
        max-width: 370px;
        margin: 0 auto;
        padding: 20px 25px;
    }
    .mfp-container {
        position: fixed;
    }
    .dropdown-menu{display: none}
    .dropdown-menu.menu_lvl_1 {position: absolute;left: 100%;top: 0;padding: 0;}

</style>

<script src="https://my.hellobar.com/4f4b0d7b30bdddcb7d523ff3a4459cfa5aa0cbe6.js" type="text/javascript" charset="utf-8" async="async"></script>



<script>
    $(document).ready(function () {


            $( ".menu-item-42" ).hover(function() {
                $( '.menu_lvl_1' ).css("display","block !important");
            });




    });

    //кнопка обратного звонка
    var ZCallbackWidgetLinkId  = 'd5487fe2863f85844312671dbbc67e41';
    var ZCallbackWidgetDomain  = 'my.zadarma.com';
    (function(){
        var lt = document.createElement('script');
        lt.type ='text/javascript';
        lt.charset = 'utf-8';
        lt.async = true;
        lt.src = 'https://' + ZCallbackWidgetDomain + '/callbackWidget/js/main.min.js';
        var sc = document.getElementsByTagName('script')[0];
        if (sc) sc.parentNode.insertBefore(lt, sc);
        else document.documentElement.firstChild.appendChild(lt);
    })();

</script>
<!-- Subscription Form -->
<style >.sp-force-hide { display: none;}.sp-form[sp-id="117603"] { display: block; background: rgba(255, 255, 255, 1); padding: 15px; width: 530px; max-width: 100%; border-radius: 22px; -moz-border-radius: 22px; -webkit-border-radius: 22px; border-color: #dddddd; border-style: solid; border-width: 1px; font-family: Tahoma, Geneva, sans-serif; background-repeat: no-repeat; background-position: center; background-size: auto;}.sp-form[sp-id="117603"] input[type="checkbox"] { display: inline-block; opacity: 1; visibility: visible;}.sp-form[sp-id="117603"] .sp-form-fields-wrapper { margin: 0 auto; width: 500px;}.sp-form[sp-id="117603"] .sp-form-control { background: rgba(255, 255, 255, 1); border-color: #00b5ba; border-style: solid; font-size: 15px; padding-left: 8.75px; padding-right: 8.75px; border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; height: 35px; width: 100%;}.sp-form[sp-id="117603"] .sp-field label { color: #444444; font-size: 13px; font-style: normal; font-weight: bold;}.sp-form[sp-id="117603"] .sp-button { border-radius: 0px; -moz-border-radius: 0px; -webkit-border-radius: 0px; background-color: #ffa94c; color: #ffffff; width: auto; font-weight: 700; font-style: normal; font-family: Tahoma, Geneva, sans-serif; box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow: none;}.sp-form[sp-id="117603"] .sp-button-container { text-align: center; width: auto;}.sp-popup-outer { background: rgba(255, 255, 255, 0);}.sp-form[sp-id="117603"] .sp-240296ed-0fe6-492c-975c-3f045b2cbd58-container { text-align: left;}</style><div class="sp-form-outer sp-popup-outer sp-force-hide" style="background: rgba(255, 255, 255, 0);"><div id="sp-form-117603" sp-id="117603" sp-hash="9f5b0c15046b923658da79ac3d59c5f80b4cf255cbb15beb1013118351223df5" sp-lang="ru" class="sp-form sp-form-regular sp-form-popup sp-animation-slide-right" sp-show-options="%7B%22satellite%22%3Afalse%2C%22maDomain%22%3A%22login.sendpulse.com%22%2C%22formsDomain%22%3A%22forms.sendpulse.com%22%2C%22condition%22%3A%22onEnter%22%2C%22scrollTo%22%3A50%2C%22delay%22%3A90%2C%22repeat%22%3A1%2C%22background%22%3A%22rgba(255%2C%20255%2C%20255%2C%200)%22%2C%22position%22%3A%22bottom-right%22%2C%22animation%22%3A%22sp-animation-slide-right%22%2C%22hideOnMobile%22%3Atrue%2C%22urlFilter%22%3Afalse%2C%22urlFilterConditions%22%3A%5B%7B%22force%22%3A%22hide%22%2C%22clause%22%3A%22contains%22%2C%22token%22%3A%22%22%7D%5D%2C%22analytics%22%3A%7B%22ga%22%3A%7B%22eventLabel%22%3Anull%2C%22send%22%3Afalse%7D%2C%22ym%22%3A%7B%22counterId%22%3Anull%2C%22eventLabel%22%3Anull%2C%22targetId%22%3Anull%2C%22send%22%3Afalse%7D%7D%7D"><div class="sp-form-fields-wrapper"><button class="sp-btn-close "> </button><div class="sp-message"><div></div></div><form novalidate="" class="sp-element-container ui-sortable ui-droppable "><div class="sp-field full-width sp-240296ed-0fe6-492c-975c-3f045b2cbd58-container" sp-id="sp-240296ed-0fe6-492c-975c-3f045b2cbd58"><img class="sp-image " src="//login.sendpulse.com/files/emailservice/userfiles/f7a3501f1501ddacc88d9a3e0fad65dc6980273/reallygreatsite.com_1.png"></div><div class="sp-field sp-field-full-width" sp-id="sp-da95af91-661f-42ac-9bda-d55274b5d5bb"><div style="font-family: inherit; line-height: 1.2;"><p><strong>Узнать стоимость Вашего заказа или нет? </strong></p><p>Пока думаете, получите<strong> 10% скидки</strong> на любой Ваш заказ!</p><p> </p><p>Обещаем не отправлять ничего лишнего!</p><p> </p><p>Промокод придет Вам <strong>в течении 5 минут!</strong></p></div></div><div class="sp-field " sp-id="sp-454d08e5-818a-4bc8-a51f-c7182e2f1817"><label class="sp-control-label"><span >Имя</span><strong >*</strong></label><input type="text" sp-type="input" name="sform[NjAzMDg4NA==]" class="sp-form-control " placeholder="" sp-tips="%7B%22required%22%3A%22%D0%9E%D0%B1%D1%8F%D0%B7%D0%B0%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D0%BE%D0%B5%20%D0%BF%D0%BE%D0%BB%D0%B5%22%7D" required="required"></div><div class="sp-field " sp-id="sp-5f7c08d6-adea-49b3-9fa9-a00d31e16827"><label class="sp-control-label"><span >Email</span><strong >*</strong></label><input type="email" sp-type="email" name="sform[email]" class="sp-form-control " placeholder="" sp-tips="%7B%22required%22%3A%22%D0%9E%D0%B1%D1%8F%D0%B7%D0%B0%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D0%BE%D0%B5%20%D0%BF%D0%BE%D0%BB%D0%B5%22%2C%22wrong%22%3A%22%D0%9D%D0%B5%D0%B2%D0%B5%D1%80%D0%BD%D1%8B%D0%B9%20email-%D0%B0%D0%B4%D1%80%D0%B5%D1%81%22%7D" required="required"></div><div class="sp-field sp-button-container " sp-id="sp-95fd0d38-6a9f-431a-88ba-8df0f402065a"><button id="sp-95fd0d38-6a9f-431a-88ba-8df0f402065a" class="sp-button">Получить промокод </button></div></form><div class="sp-link-wrapper sp-brandname__center"></div></div></div></div><script type="text/javascript" src="//web.webformscr.com/apps/fc3/build/default-handler.js?1584976970988"></script>
<!-- /Subscription Form -->
<!-- BEGIN PLERDY CODE -->
<script type="text/javascript" defer>
    var _protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    var _site_hash_code = "622db71d88b0c9833af1d117307292a5";
    var _suid = 8315;
</script>
<script type="text/javascript" defer src="https://a.plerdy.com/public/js/click/main.js"></script>
<!-- END PLERDY CODE -->
<script src="<?php echo get_bloginfo("template_url"); ?>/js/new/index.js"></script>

</body>
</html>
