<?php
/**
 * 404 error page template
 */

get_header();
?>

<div class="content-area" id="primary">
    <main class="site-main error-404 not-found" id="main">
        
        <section class="error-404-content">
            <header class="page-header">
                <h1 class="page-title"><?php _e('페이지를 찾을 수 없습니다', 'blog7-custom'); ?></h1>
            </header>
            
            <div class="page-content">
                <p><?php _e('죄송합니다. 요청하신 페이지를 찾을 수 없습니다. 다음 방법을 시도해 보세요:', 'blog7-custom'); ?></p>
                
                <div class="error-404-search">
                    <h2><?php _e('검색하기', 'blog7-custom'); ?></h2>
                    <?php get_search_form(); ?>
                </div>
                
                <div class="error-404-recent">
                    <h2><?php _e('최근 게시물', 'blog7-custom'); ?></h2>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish',
                        ));
                        
                        foreach ($recent_posts as $post) :
                            ?>
                            <li>
                                <a href="<?php echo get_permalink($post['ID']); ?>">
                                    <?php echo $post['post_title']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="error-404-categories">
                    <h2><?php _e('카테고리', 'blog7-custom'); ?></h2>
                    <ul>
                        <?php
                        wp_list_categories(array(
                            'title_li' => '',
                            'number' => 10,
                        ));
                        ?>
                    </ul>
                </div>
                
                <div class="error-404-home">
                    <a href="<?php echo home_url('/'); ?>" class="button">
                        <?php _e('홈으로 돌아가기', 'blog7-custom'); ?>
                    </a>
                </div>
            </div>
        </section>
        
    </main>
</div>

<style>
.error-404-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
    text-align: center;
}

.error-404-content h1 {
    font-size: 48px;
    margin-bottom: 20px;
    color: #333;
}

.error-404-content > p {
    font-size: 18px;
    margin-bottom: 40px;
    color: #666;
}

.error-404-search,
.error-404-recent,
.error-404-categories {
    margin-bottom: 40px;
    text-align: left;
}

.error-404-search h2,
.error-404-recent h2,
.error-404-categories h2 {
    font-size: 24px;
    margin-bottom: 15px;
}

.error-404-recent ul,
.error-404-categories ul {
    list-style: none;
    padding: 0;
}

.error-404-recent li,
.error-404-categories li {
    margin-bottom: 10px;
}

.error-404-recent a,
.error-404-categories a {
    color: #0073aa;
    text-decoration: none;
}

.error-404-recent a:hover,
.error-404-categories a:hover {
    text-decoration: underline;
}

.error-404-home {
    margin-top: 40px;
}

.error-404-home .button {
    display: inline-block;
    padding: 12px 30px;
    background: #0073aa;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 16px;
    transition: background 0.3s;
}

.error-404-home .button:hover {
    background: #005a87;
}
</style>

<?php
get_footer();
