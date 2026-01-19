<?php
/**
 * Blog7 Custom Theme Functions
 */

if (!defined('ABSPATH')) { exit; }

function blog7_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    // 타겟 사이트 썸네일 비율에 최적화
    set_post_thumbnail_size(800, 450, true); 
    
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    register_nav_menus(array('primary' => __('Primary Menu', 'blog7-custom')));
}
add_action('after_setup_theme', 'blog7_theme_setup');

function blog7_enqueue_scripts() {
    wp_enqueue_style('blog7-style', get_stylesheet_uri(), array(), '1.1.0');
    wp_enqueue_script('jquery');
    wp_enqueue_script('blog7-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('blog7-menu', get_template_directory_uri() . '/assets/js/menu.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'blog7_enqueue_scripts');

// 발췌문 길이 수정 (카드 디자인에 맞춤)
function blog7_custom_excerpt_length($length) {
    return 25; // 한글 기준 적당한 길이
}
add_filter('excerpt_length', 'blog7_custom_excerpt_length');

function blog7_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'blog7_excerpt_more');

// 날짜 표시 함수
function blog7_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string .= '<time class="updated" datetime="%3$s" style="display:none;">%4$s</time>';
    }
    
    $time_string = sprintf($time_string,
        esc_attr(get_the_date('c')),
        esc_html(get_the_date('Y.m.d')), // 2024.01.01 포맷
        esc_attr(get_the_modified_date('c')),
        esc_html(get_the_modified_date('Y.m.d'))
    );
    
    echo '<span class="posted-on">' . $time_string . '</span>';
}

// 브레드크럼 (상세페이지 상단용)
function blog7_breadcrumb() {
    if (!is_front_page() && !is_home()) {
        echo '<nav class="breadcrumb" style="font-size:13px; color:#666; margin-bottom:10px;">';
        echo '<a href="' . home_url() . '">홈</a>';
        if (is_single()) {
            echo ' &rsaquo; ';
            the_category(', ');
        }
        echo '</nav>';
    }
}

// SVG 아이콘 헬퍼
function blog7_get_svg($icon) {
    $icons = array(
        'menu' => '<svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>',
        'close' => '<svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>',
        'search' => '<svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>',
        'arrow-up' => '<svg viewBox="0 0 24 24"><path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/></svg>',
    );
    return isset($icons[$icon]) ? $icons[$icon] : '';
}

// 검색 모달 출력
function blog7_search_modal() {
    ?>
    <div class="gp-modal gp-search-modal" id="gp-search" style="display:none;">
        <div class="gp-modal__overlay"></div>
        <div class="gp-modal__container">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" class="search-field" placeholder="검색어를 입력하세요..." value="" name="s" />
            </form>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'blog7_search_modal');
?>
