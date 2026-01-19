<?php
/**
 * Page template
 */

get_header();
?>

<div class="content-area" id="primary">
    <main class="site-main" id="main">
        
        <?php
        while (have_posts()) :
            the_post();
        ?>
        
        <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
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
            
        </article>
        
        <?php
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
