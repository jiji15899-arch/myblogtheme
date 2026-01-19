<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="masthead">
    <div class="inside-navigation grid-container">
        
        <div class="site-branding">
            <h1 class="main-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
        </div>
        
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="gp-icon icon-menu">
                <?php echo blog7_get_svg('menu'); ?>
            </span>
        </button>
        
        <nav id="site-navigation" class="main-navigation">
            <div id="primary-menu" class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false // 메뉴 미설정시 숨김
                ));
                ?>
            </div>
        </nav>
        
        <div class="header-widget">
            <a href="#" class="search-toggle" data-gpmodal-trigger="gp-search">
                <span class="gp-icon icon-search">
                    <?php echo blog7_get_svg('search'); ?>
                </span>
            </a>
        </div>
        
    </div>
</header>

<div class="site grid-container container hfeed" id="page">
    <div class="site-content" id="content">
