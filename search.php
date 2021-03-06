<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package a11y
 */

get_header();
?>

    <main id="content" class="a11y-site-main columns">
        <div class="flc-toc-tocContainer"></div>

        <?php
        if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class=""><?php printf( esc_html__( 'Search Results for: %s', 'a11y' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header><!-- .page-header -->

            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part( 'template-parts/content', 'search' );

            endwhile;

            the_posts_navigation();

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif; ?>

        </main><!-- #main -->
    <?php
get_footer();
