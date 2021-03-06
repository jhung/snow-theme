<?php
/**
 * For a category, display the category's landing page.
 *
 * To make a category landing page:
 * 1. Make a post.
 * 2. Give it a name you would recognize like "About Us Landing Page".
 *    This title is ignored and is useful only to identify it easily in the
 *    Wordpress admin.
 * 3. Add the following into the post's Custom Fields:
 *        name:  is_landing_page
 *        value: true
 * 4. Assign the post to the category it's supposed to be a landing page for.
 *
 * @package a11y
 */
$category_name = '';
$category_landing_id = '';
$category_landing_content = '';
$category_current = get_the_category();

if ( ! empty( $category_current ) ) {
    $category_name = $category_current[0]->name;
    $args = array(
        'post_type' => 'post',
        'category_name' => $category_current[0]->slug,
        'meta_query' => array (
            array (
                'key' => 'is_landing_page',
                'value' => 'true',
                'compare' => '=',
            ),
        ),
    );
    $the_query = new WP_Query($args);

    while ( $the_query->have_posts() ) {
        /* If there is a landing page for the category. */
        $the_query->the_post();
        $category_landing_content = get_the_content();
        $category_landing_id = get_the_ID();
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}

get_header();
get_sidebar('post');
?>
    <main id="content" class="a11y-site-main columns">
        <div class="flc-toc-tocContainer"></div>


        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
            <?php if(function_exists('bcn_display'))
            {
            bcn_display();
            }?>
        </div>

        <h1><?php echo $category_name ?></h1>
        <section>
            <article>
                <div class="a11y-entry-content">
                    <?php echo apply_filters('the_content', $category_landing_content); //do_shortcode ($category_landing_content); ?>
                </div>
            </article>
        <?php if (empty ($category_landing_id)) {
            /* No landing page to show, then list posts in the category. */
            /* Start the Loop */
            if (have_posts()) :
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', get_post_format() );
                endwhile;

                the_posts_navigation();

                /* Restore original Post Data */
                wp_reset_postdata();
            else :
                echo wpautop ('No posts');
            endif;
        }
        ?>
        </section>
    </main>
<?php
get_footer();
