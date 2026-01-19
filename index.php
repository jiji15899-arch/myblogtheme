<?php
/**
 * Main template file
 */

get_header();
?>

<div class="content-area" id="primary">
    <main class="site-main" id="main">
        
        <?php if (have_posts()) : ?>
            
            <div class="generate-columns-container">
                
                <?php
                while (have_posts()) :
                    the_post();
                    
                    // 포스트 클래스 설정
                    $post_classes = array(
                        'post-' . get_the_ID(),
                        'post',
                        'type-post',
                        'status-publish',
                        'format-standard',
                    );
                    
                    if (has_post_thumbnail()) {
                        $post_classes[] = 'has-post-thumbnail';
                    }
                    
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            $post_classes[] = 'category-' . $category->term_id;
                        }
                    }
                    
                    $post_classes[] = 'generate-columns';
                    $post_classes[] = 'tablet-grid-50';
                    $post_classes[] = 'mobile-grid-100';
                    $post_classes[] = 'grid-parent';
                    $post_classes[] = 'grid-33';
                ?>
                
                <article id="post-<?php the_ID(); ?>" class="<?php echo implode(' ', $post_classes); ?>" itemtype="https://schema.org/CreativeWork" itemscope>
                    <div class="inside-article">
                        
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="post-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                the_post_thumbnail('full', array(
                                    'itemprop' => 'image',
                                    'alt' => get_the_title(),
                                ));
                                ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <header class="entry-header">
                            <h2 class="entry-title" itemprop="headline">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            
                            <div class="entry-meta">
                                <?php blog7_posted_on(); ?>
                            </div>
                        </header>
                        
                        <div class="entry-summary" itemprop="text">
                            <p><?php echo blog7_custom_excerpt(100); ?></p>
                            
                            <p class="read-more-container">
                                <a title="<?php the_title_attribute(); ?>" class="read-more button" href="<?php the_permalink(); ?>" aria-label="<?php the_title(); ?>에 대해 더 자세히 알아보세요">
                                    Read more
                                </a>
                            </p>
                        </div>
                        
                    </div>
                </article>
                
                <?php
                endwhile;
                ?>
                
            </div><!-- .generate-columns-container -->
            
            <?php
            // 페이지네이션
            blog7_pagination();
            ?>
            
        <?php else : ?>
            
            <div class="no-posts">
                <h2><?php _e('포스트가 없습니다', 'blog7-custom'); ?></h2>
                <p><?php _e('죄송합니다. 표시할 포스트가 없습니다.', 'blog7-custom'); ?></p>
            </div>
            
        <?php endif; ?>
        
    </main>
</div>

<?php
get_footer();
