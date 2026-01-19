<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="screen-reader-text skip-link" href="#content" title="컨텐츠로 건너뛰기">컨텐츠로 건너뛰기</a>

<nav class="has-branding main-navigation nav-align-right has-menu-bar-items sub-menu-right" id="site-navigation" aria-label="기본" itemtype="https://schema.org/SiteNavigationElement" itemscope>
    <div class="inside-navigation grid-container">
        <div class="navigation-branding">
            <h1 class="main-title" itemprop="headline">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
        </div>
        
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
            <span class="gp-icon icon-menu-bars">
                <?php echo blog7_get_svg('menu'); ?>
                <?php echo blog7_get_svg('close'); ?>
            </span>
            <span class="mobile-menu">Menu</span>
        </button>
        
        <div id="primary-menu" class="main-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'menu-main',
                'menu_class'     => 'menu sf-menu',
                'container'      => false,
                'fallback_cb'    => function() {
                    echo '<ul id="menu-main" class="menu sf-menu">';
                    echo '<li class="menu-item current-menu-item"><a href="' . home_url('/') . '">홈</a></li>';
                    echo '<li class="menu-item"><a href="#">메뉴 1</a></li>';
                    echo '</ul>';
                }
            ));
            ?>
        </div>
        
        <div class="menu-bar-items">
            <span class="menu-bar-item">
                <a href="#" role="button" aria-label="검색 열기" aria-haspopup="dialog" aria-controls="gp-search" data-gpmodal-trigger="gp-search">
                    <span class="gp-icon icon-search">
                        <?php echo blog7_get_svg('search'); ?>
                        <?php echo blog7_get_svg('close'); ?>
                    </span>
                </a>
            </span>
        </div>
    </div>
</nav>

<div class="site grid-container container hfeed" id="page">
    <div class="site-content" id="content">
