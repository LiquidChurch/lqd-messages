<?php
/**
 * The template for displaying single messages
 *
 * @package WordPress
 * @subpackage Liquid_Church
 * @since LiquidChurch 1.0
 */
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the single post content template.
            get_template_part( 'template-parts/content', 'single-lqd-messages' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            if ( is_singular( 'attachment' ) ) {

                // Parent post navigation.
                the_post_navigation( array(
                    'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'liquidchurch' ),
                ) );
            } elseif ( is_singular( 'post' ) ) {
            }
            // End of the loop.
        endwhile;
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->
<?php get_footer(); ?>

