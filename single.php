<?php
/**
 * Single Post Template
 */
get_header();
?>

<div class="content-area">
    <main class="site-main">
        <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <?php blog7_breadcrumb(); ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <div class="entry-meta">
                    <?php blog7_posted_on(); ?>
                    <span class="byline">by <?php the_author(); ?></span>
                </div>
            </header>
            
            <?php if (has_post_thumbnail()) : ?>
            <div class="featured-image">
                <?php the_post_thumbnail('full'); ?>
            </div>
            <?php endif; ?>
            
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            
            <footer class="entry-footer">
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    echo '<div class="tags-links">';
                    foreach ($tags as $tag) {
                        echo '<a href="' . get_tag_link($tag->term_id) . '">#' . $tag->name . '</a>';
                    }
                    echo '</div>';
                }
                ?>
            </footer>
            
        </article>
        
        <?php
        // 이전/다음 글 네비게이션
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">이전 글</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">다음 글</span> <span class="nav-title">%title</span>',
        ));
        
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        endwhile;
        ?>
    </main>
</div>

<?php get_footer(); ?>
