<?php
/**
 * Single post template
 */

get_header();
?>

<div class="content-area" id="primary">
    <main class="site-main" id="main">
        
        <?php
        while (have_posts()) :
            the_post();
        ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                
                <div class="entry-meta">
                    <?php blog7_posted_on(); ?>
                    
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo '<span class="cat-links"> | 카테고리: ';
                        echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                        echo '</span>';
                    }
                    ?>
                </div>
            </header>
            
            <?php if (has_post_thumbnail()) : ?>
            <div class="featured-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <?php endif; ?>
            
            <div class="entry-content">
                <?php
                the_content();
                
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . __('Pages:', 'blog7-custom'),
                    'after'  => '</div>',
                ));
                ?>
            </div>
            
            <footer class="entry-footer">
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    echo '<div class="tags-links">';
                    echo '<span>태그: </span>';
                    $tag_links = array();
                    foreach ($tags as $tag) {
                        $tag_links[] = '<a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>';
                    }
                    echo implode(', ', $tag_links);
                    echo '</div>';
                }
                ?>
            </footer>
            
        </article>
        
        <?php
        // 이전/다음 포스트 네비게이션
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">이전 글</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">다음 글</span> <span class="nav-title">%title</span>',
        ));
        
        // 댓글
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        endwhile;
        ?>
        
    </main>
</div>

<?php
get_sidebar();
get_footer();
