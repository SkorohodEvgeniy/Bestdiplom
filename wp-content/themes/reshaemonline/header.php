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
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="site-wrapper">

    <!--Header-->
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
				        <?php the_custom_logo(); ?>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
				        <?php
				        wp_nav_menu( array(
						        'theme_location'    => 'menu-1',
						        'depth'             => 2,
						        'menu_class'        => 'nav navbar-nav',
						        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
						        'walker'            => new WP_Bootstrap_Navwalker())
				        );
				        ?>
                        <ul class="nav navbar-nav navbar-right">
					        <?php if( get_field('phone_number', 'options') ) :?>
                                <li>
                                    <a class="header-phone" href="tel:<?php $phone = str_replace(' ', '', get_field('phone_number', 'options'));  ?>"><?php the_field('phone_number', 'option') ?></a>
                                </li>
					        <?php endif; ?>

                            <li>
                                <a class="login-btn" href="#" data-toggle="modal" data-target="#login">Входfffffff</a>
                            </li>
                            <li>
                                <a class="reg-btn" href="#" data-toggle="modal" data-target="#register">Регистрация</a>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        </div>
    </header>