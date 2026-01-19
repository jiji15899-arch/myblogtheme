<?php
/**
 * Blog7 Custom Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 테마 설정
 */
function blog7_theme_setup() {
    // 제목 태그 지원
    add_theme_support('title-tag');
    
    // 포스트 썸네일 지원
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(600, 600, true);
    
    // HTML5 지원
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // RSS 피드 링크
    add_theme_support('automatic-feed-links');
    
    // 메뉴 등록
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'blog7-custom'),
    ));
}
add_action('after_setup_theme', 'blog7_theme_setup');

/**
 * 스타일시트와 스크립트 로드
 */
function blog7_enqueue_scripts() {
    // 스타일시트
    wp_enqueue_style('blog7-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // jQuery (워드프레스 기본 제공)
    wp_enqueue_script('jquery');
    
    // 커스텀 스크립트
    wp_enqueue_script('blog7-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    
    // 메뉴 스크립트
    wp_enqueue_script('blog7-menu', get_template_directory_uri() . '/assets/js/menu.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'blog7_enqueue_scripts');

/**
 * 발췌문 길이 조정
 */
function blog7_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'blog7_excerpt_length');

/**
 * 발췌문 more 텍스트
 */
function blog7_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'blog7_excerpt_more');

/**
 * 커스텀 발췌문 함수
 */
function blog7_custom_excerpt($length = 40) {
    $excerpt = get_the_excerpt();
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $length);
    $excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
    $excerpt = $excerpt . ' …';
    return $excerpt;
}

/**
 * 페이지네이션
 */
function blog7_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => __('이전', 'blog7-custom'),
        'next_text' => __('다음', 'blog7-custom'),
        'type' => 'array',
        'mid_size' => 2,
        'end_size' => 1,
    ));
    
    if ($pagination) {
        echo '<nav class="paging-navigation" aria-label="아카이브 페이지">';
        echo '<div class="nav-links">';
        foreach ($pagination as $page) {
            echo $page;
        }
        echo '</div>';
        echo '</nav>';
    }
}

/**
 * 헤드 정리 (불필요한 메타 태그 제거)
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * 위젯 영역 등록
 */
function blog7_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'blog7-custom'),
        'id' => 'sidebar-1',
        'description' => __('사이드바 위젯 영역', 'blog7-custom'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'blog7_widgets_init');

/**
 * 날짜 포맷 (한국어)
 */
function blog7_posted_on() {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="updated" datetime="%1$s">%2$s</time><time class="entry-date published" datetime="%3$s">%4$s</time>';
    }
    
    $time_string = sprintf($time_string,
        esc_attr(get_the_modified_date('c')),
        esc_html(get_the_modified_date('Y년 m월 d일')),
        esc_attr(get_the_date('c')),
        esc_html(get_the_date('Y년 m월 d일'))
    );
    
    echo '<span class="posted-on">' . $time_string . '</span>';
}

/**
 * 브레드크럼
 */
function blog7_breadcrumb() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumb">';
        echo '<a href="' . home_url() . '">홈</a>';
        
        if (is_category() || is_single()) {
            echo ' &raquo; ';
            the_category(' &bull; ');
            if (is_single()) {
                echo ' &raquo; ';
                the_title();
            }
        } elseif (is_page()) {
            echo ' &raquo; ';
            echo the_title();
        } elseif (is_search()) {
            echo ' &raquo; Search Results for "' . get_search_query() . '"';
        }
        
        echo '</nav>';
    }
}

/**
 * SVG 아이콘 지원
 */
function blog7_get_svg($icon) {
    $icons = array(
        'menu' => '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M0 96c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24zm0 160c0-13.255 10.745-24 24-24h464c13.255 0 24 10.745 24 24s-10.745 24-24 24H24c-13.255 0-24-10.745-24-24z"/></svg>',
        'close' => '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M71.029 71.029c9.373-9.372 24.569-9.372 33.942 0L256 222.059l151.029-151.03c9.373-9.372 24.569-9.372 33.942 0 9.372 9.373 9.372 24.569 0 33.942L289.941 256l151.03 151.029c9.372 9.373 9.372 24.569 0 33.942-9.373 9.372-24.569 9.372-33.942 0L256 289.941l-151.029 151.03c-9.373 9.372-24.569 9.372-33.942 0-9.372-9.373-9.372-24.569 0-33.942L222.059 256 71.029 104.971c-9.372-9.373-9.372-24.569 0-33.942z"/></svg>',
        'search' => '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path fill-rule="evenodd" clip-rule="evenodd" d="M208 48c-88.366 0-160 71.634-160 160s71.634 160 160 160 160-71.634 160-160S296.366 48 208 48zM0 208C0 93.125 93.125 0 208 0s208 93.125 208 208c0 48.741-16.765 93.566-44.843 129.024l133.826 134.018c9.366 9.379 9.355 24.575-.025 33.941-9.379 9.366-24.575 9.355-33.941-.025L337.238 370.987C301.747 399.167 256.839 416 208 416 93.125 416 0 322.875 0 208z"/></svg>',
        'arrow-up' => '<svg viewBox="0 0 330 512" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><path d="M305.863 314.916c0 2.266-1.133 4.815-2.832 6.514l-14.157 14.163c-1.699 1.7-3.964 2.832-6.513 2.832-2.265 0-4.813-1.133-6.512-2.832L164.572 224.276 53.295 335.593c-1.699 1.7-4.247 2.832-6.512 2.832-2.265 0-4.814-1.133-6.513-2.832L26.113 321.43c-1.699-1.7-2.831-4.248-2.831-6.514s1.132-4.816 2.831-6.515L158.06 176.408c1.699-1.7 4.247-2.833 6.512-2.833 2.265 0 4.814 1.133 6.513 2.833L303.03 308.4c1.7 1.7 2.832 4.249 2.832 6.515z"/></svg>',
    );
    
    return isset($icons[$icon]) ? $icons[$icon] : '';
}

/**
 * 보안 강화
 */
function blog7_remove_version() {
    return '';
}
add_filter('the_generator', 'blog7_remove_version');

/**
 * 이미지 최적화 속성 추가
 */
function blog7_add_image_attributes($attr, $attachment, $size) {
    $attr['loading'] = 'lazy';
    $attr['decoding'] = 'async';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'blog7_add_image_attributes', 10, 3);

/**
 * 검색 모달 HTML
 */
function blog7_search_modal() {
    ?>
    <div class="gp-modal gp-search-modal" id="gp-search" role="dialog" aria-modal="true" aria-label="검색">
        <div class="gp-modal__overlay" tabindex="-1" data-gpmodal-close>
            <div class="gp-modal__container">
                <form role="search" method="get" class="search-modal-form" action="<?php echo home_url('/'); ?>">
                    <label for="search-modal-input" class="screen-reader-text">검색:</label>
                    <div class="search-modal-fields">
                        <input id="search-modal-input" type="search" class="search-field" placeholder="검색 &hellip;" value="" name="s" />
                        <button aria-label="검색">
                            <span class="gp-icon icon-search"><?php echo blog7_get_svg('search'); ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'blog7_search_modal');
