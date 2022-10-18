<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package reshaemonline
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="yandex-verification" content="ab191c5634f685bf"/>
    <meta name="verification" content="ccf8a75c2bd0cf1f6323e31e0496b4"/>

    <link rel="shortcut icon" href="#" />
    <meta name="description" content="" />
    <meta name="robots" content="index, follow" />
 

    <style type="text/css">
        /* Magnific Popup CSS */
        .mfp-bg {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1042;
            overflow: hidden;
            position: fixed;
            background: #0b0b0b;
            opacity: 0.8;
        }

        .mfp-wrap {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1043;
            position: fixed;
            outline: none !important;
            -webkit-backface-visibility: hidden;
        }

        .mfp-container {
            text-align: center;
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            padding: 0 8px;
            box-sizing: border-box;
        }

        .mfp-container:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
        }

        .mfp-align-top .mfp-container:before {
            display: none;
        }

        .mfp-content {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            margin: 0 auto;
            text-align: left;
            z-index: 1045;
        }

        .mfp-inline-holder .mfp-content,
        .mfp-ajax-holder .mfp-content {
            width: 100%;
            cursor: auto;
        }

        .mfp-ajax-cur {
            cursor: progress;
        }

        .mfp-zoom-out-cur, .mfp-zoom-out-cur .mfp-image-holder .mfp-close {
            cursor: -moz-zoom-out;
            cursor: -webkit-zoom-out;
            cursor: zoom-out;
        }

        .mfp-zoom {
            cursor: pointer;
            cursor: -webkit-zoom-in;
            cursor: -moz-zoom-in;
            cursor: zoom-in;
        }

        .mfp-auto-cursor .mfp-content {
            cursor: auto;
        }

        .mfp-close,
        .mfp-arrow,
        .mfp-preloader,
        .mfp-counter {
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .mfp-loading.mfp-figure {
            display: none;
        }

        .mfp-hide {
            display: none !important;
        }

        .mfp-preloader {
            color: #CCC;
            position: absolute;
            top: 50%;
            width: auto;
            text-align: center;
            margin-top: -0.8em;
            left: 8px;
            right: 8px;
            z-index: 1044;
        }

        .mfp-preloader a {
            color: #CCC;
        }

        .mfp-preloader a:hover {
            color: #FFF;
        }

        .mfp-s-ready .mfp-preloader {
            display: none;
        }

        .mfp-s-error .mfp-content {
            display: none;
        }

        button.mfp-close,
        button.mfp-arrow {
            overflow: visible;
            cursor: pointer;
            background: transparent;
            border: 0;
            -webkit-appearance: none;
            display: block;
            outline: none;
            padding: 0;
            z-index: 1046;
            box-shadow: none;
            touch-action: manipulation;
        }

        button::-moz-focus-inner {
            padding: 0;
            border: 0;
        }

        .mfp-close {
            width: 44px;
            height: 44px;
            line-height: 44px;
            position: absolute;
            right: 0;
            top: 0;
            text-decoration: none;
            text-align: center;
            opacity: 0.65;
            padding: 0 0 18px 10px;
            color: #FFF;
            font-style: normal;
            font-size: 28px;
            font-family: Arial, Baskerville, monospace;
        }

        .mfp-close:hover,
        .mfp-close:focus {
            opacity: 1;
        }

        .mfp-close:active {
            top: 1px;
        }

        .mfp-close-btn-in .mfp-close {
            color: #333;
        }

        .mfp-image-holder .mfp-close,
        .mfp-iframe-holder .mfp-close {
            color: #FFF;
            right: -6px;
            text-align: right;
            padding-right: 6px;
            width: 100%;
        }

        .mfp-counter {
            position: absolute;
            top: 0;
            right: 0;
            color: #CCC;
            font-size: 12px;
            line-height: 18px;
            white-space: nowrap;
        }

        .mfp-arrow {
            position: absolute;
            opacity: 0.65;
            margin: 0;
            top: 50%;
            margin-top: -55px;
            padding: 0;
            width: 90px;
            height: 110px;
            -webkit-tap-highlight-color: transparent;
        }

        .mfp-arrow:active {
            margin-top: -54px;
        }

        .mfp-arrow:hover,
        .mfp-arrow:focus {
            opacity: 1;
        }

        .mfp-arrow:before,
        .mfp-arrow:after {
            content: '';
            display: block;
            width: 0;
            height: 0;
            position: absolute;
            left: 0;
            top: 0;
            margin-top: 35px;
            margin-left: 35px;
            border: medium inset transparent;
        }

        .mfp-arrow:after {
            border-top-width: 13px;
            border-bottom-width: 13px;
            top: 8px;
        }

        .mfp-arrow:before {
            border-top-width: 21px;
            border-bottom-width: 21px;
            opacity: 0.7;
        }

        .mfp-arrow-left {
            left: 0;
        }

        .mfp-arrow-left:after {
            border-right: 17px solid #FFF;
            margin-left: 31px;
        }

        .mfp-arrow-left:before {
            margin-left: 25px;
            border-right: 27px solid #3F3F3F;
        }

        .mfp-arrow-right {
            right: 0;
        }

        .mfp-arrow-right:after {
            border-left: 17px solid #FFF;
            margin-left: 39px;
        }

        .mfp-arrow-right:before {
            border-left: 27px solid #3F3F3F;
        }

        .mfp-iframe-holder {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .mfp-iframe-holder .mfp-content {
            line-height: 0;
            width: 100%;
            max-width: 900px;
        }

        .mfp-iframe-holder .mfp-close {
            top: -40px;
        }

        .mfp-iframe-scaler {
            width: 100%;
            height: 0;
            overflow: hidden;
            padding-top: 56.25%;
        }

        .mfp-iframe-scaler iframe {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
            background: #000;
        }

        /* Main image in popup */
        img.mfp-img {
            width: auto;
            max-width: 100%;
            height: auto;
            display: block;
            line-height: 0;
            box-sizing: border-box;
            padding: 40px 0 40px;
            margin: 0 auto;
        }

        /* The shadow behind the image */
        .mfp-figure {
            line-height: 0;
        }

        .mfp-figure:after {
            content: '';
            position: absolute;
            left: 0;
            top: 40px;
            bottom: 40px;
            display: block;
            right: 0;
            width: auto;
            height: auto;
            z-index: -1;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
            background: #444;
        }

        .mfp-figure small {
            color: #BDBDBD;
            display: block;
            font-size: 12px;
            line-height: 14px;
        }

        .mfp-figure figure {
            margin: 0;
        }

        .mfp-bottom-bar {
            margin-top: -36px;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            cursor: auto;
        }

        .mfp-title {
            text-align: left;
            line-height: 18px;
            color: #F3F3F3;
            word-wrap: break-word;
            padding-right: 36px;
        }

        .mfp-image-holder .mfp-content {
            max-width: 100%;
        }

        .mfp-gallery .mfp-image-holder .mfp-figure {
            cursor: pointer;
        }

        @media screen and (max-width: 800px) and (orientation: landscape), screen and (max-height: 300px) {
            /**
                 * Remove all paddings around the image on small screen
                 */
            .mfp-img-mobile .mfp-image-holder {
                padding-left: 0;
                padding-right: 0;
            }

            .mfp-img-mobile img.mfp-img {
                padding: 0;
            }

            .mfp-img-mobile .mfp-figure:after {
                top: 0;
                bottom: 0;
            }

            .mfp-img-mobile .mfp-figure small {
                display: inline;
                margin-left: 5px;
            }

            .mfp-img-mobile .mfp-bottom-bar {
                background: rgba(0, 0, 0, 0.6);
                bottom: 0;
                margin: 0;
                top: auto;
                padding: 3px 5px;
                position: fixed;
                box-sizing: border-box;
            }

            .mfp-img-mobile .mfp-bottom-bar:empty {
                padding: 0;
            }

            .mfp-img-mobile .mfp-counter {
                right: 5px;
                top: 3px;
            }

            .mfp-img-mobile .mfp-close {
                top: 0;
                right: 0;
                width: 35px;
                height: 35px;
                line-height: 35px;
                background: rgba(0, 0, 0, 0.6);
                position: fixed;
                text-align: center;
                padding: 0;
            }
        }

        @media all and (max-width: 900px) {
            .mfp-arrow {
                -webkit-transform: scale(0.75);
                transform: scale(0.75);
            }

            .mfp-arrow-left {
                -webkit-transform-origin: 0;
                transform-origin: 0;
            }

            .mfp-arrow-right {
                -webkit-transform-origin: 100%;
                transform-origin: 100%;
            }

            .mfp-container {
                padding-left: 6px;
                padding-right: 6px;
            }
        }

    </style>

    <?php wp_head(); ?>
	 <link rel="stylesheet" href="<?php echo get_bloginfo("template_url"); ?>/style-new.css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106116731-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-106116731-1');
    </script>

    <script type="text/javascript">
        (function(w,d){
            w.HelpCrunch=function(){w.HelpCrunch.q.push(arguments)};w.HelpCrunch.q=[];
            function r(){var s=document.createElement('script');s.async=1;s.type='text/javascript';s.src='https://widget.helpcrunch.com/';(d.body||d.head).appendChild(s);}
            if(w.attachEvent){w.attachEvent('onload',r)}else{w.addEventListener('load',r,false)}
        })(window, document)
    </script>

    <script type="text/javascript">
        HelpCrunch('init', 'kabinetavtora', {
            applicationId: 5,
            applicationSecret: 'CqgNTXFMKfQpaIH0ULfKnEGPxDHo76wUBvpFgVecu1V/pFrsLh2SQEvEA0Iw67OZEw9/jvO+4Vq3X9J1P2UoCQ=='
        })

        HelpCrunch('showChatWidget');
    </script>


    <script src="//static-login.sendpulse.com/apps/fc3/build/loader.js"
            sp-form-id="9f5b0c15046b923658da79ac3d59c5f80b4cf255cbb15beb1013118351223df5"></script>


    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1763988517169424');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1763988517169424&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body <?php body_class(); ?>>

    <div id="root">
      <header class="header">
        <nav class="navbar">
          <div class="container">
            <div class="navbar__wrap">
              <div class="hamb">
                <div class="hamb__field" id="hamb">
                  <span class="bar"></span>
                  <span class="bar"></span>
                  <span class="bar"></span>
                </div>
              </div>
              <a href="/" class="logo" id="logo">
                <picture>
                  <source
                    srcset="  <?php the_field('_big-logo', 'option') ?>"
                    media="(min-width: 769px)"
                  />
                  <img src="  <?php the_field('_logo-mobile', 'option') ?>" alt="logo" />
                </picture>
              </a>
           <?php
                        wp_nav_menu(array(
                                'theme_location' => 'menu-1',
                                'depth' => 3,
								'container_class' => 'header-menu__class',
                                'menu_class' => 'menu',
                                'menu_id' => 'menu',
                                'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                'walker' => new WP_Bootstrap_Navwalker()
								)
                        );
                        ?>
			
              <div class="header-contact">
                <div class="phone">
          
				  <?php the_field('_time-work', 'option') ?>
				  <a href="tel:<?php $phone = str_replace(' ', '', get_field('phone_number', 'option')); ?>"><?php the_field('phone_number', 'option') ?></a>
                </div>
                <a href="#calculator-form" class="btn btn--size-sm mob_btn-val">Узнать стоимость</a>
				<?php  echo do_shortcode('[button_register_login]'); ?>
				
              </div>
			      <?php


                            function varnish_safe_http_headers()
                            {
                                header('X-UA-Compatible: IE=edge,chrome=1');
                                session_cache_limiter('');
                                header("Cache-Control: public, s-maxage=120");
                                if (!session_id()) {
                                    session_start();
                                }
                            }

                            //                            add_action( 'send_headers', 'varnish_safe_http_headers' );
                            add_filter('wp_headers', 'wpse167128_nocache');
                            function wpse167128_nocache($headers)
                            {
//                                unset($headers['Cache-Control']);
                                $headers['Cache-Control'] = 'no-cache, no-store, must-revalidate,max-age=0';
                                $headers['Pragma'] = 'no-cache';
                                $headers['Expires'] = '0';
                                return $headers;
                            }
 ?>
            </div>
          </div>
        </nav>
        <div class="popup" id="popup"></div>
      </header>
      <main class="main">
<!-- Start SiteHeart code
<script>
    (function () {
        var widget_id = 851515;
        _shcp = [{widget_id: widget_id}];
        var lang = (navigator.language || navigator.systemLanguage
            || navigator.userLanguage || "en")
            .substr(0, 2).toLowerCase();
        var url = "widget.siteheart.com/widget/sh/" + widget_id + "/" + lang + "/widget.js";
        var hcc = document.createElement("script");
        hcc.type = "text/javascript";
        hcc.async = true;
        hcc.src = ("https:" == document.location.protocol ? "https" : "http")
            + "://" + url;
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hcc, s.nextSibling);
    })();
</script>
End SiteHeart code -->

