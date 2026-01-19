<?php
/**
 * Main template file (Home)
 */
get_header();
?>

<div class="content-area">
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <div class="generate-columns-container">
                <?php while (have_posts()) : the_post(); ?>
                
                <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                    <div class="inside-article">
                        <?php if (has_post_thumbnail()) : ?>
                        <div class="post-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="entry-header">
                            <div class="entry-meta">
                                <?php 
                                    $categories = get_the_category();
                                    if($categories) {
                                        echo '<span class="cat-link">' . esc_html($categories[0]->name) . '</span>';
                                        echo ' · ';
                                    }
                                    blog7_posted_on(); 
                                ?>
                            </div>
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </div>
                        
                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                            <div class="read-more-container">
                                <a class="read-more" href="<?php the_permalink(); ?>">더 보기</a>
                            </div>
                        </div>
                    </div>
                </article>
                
                <?php endwhile; ?>
            </div>
            
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '<',
                'next_text' => '>',
            ));
            ?>
            
        <?php else : ?>
            <p>게시글이 없습니다.</p>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>
