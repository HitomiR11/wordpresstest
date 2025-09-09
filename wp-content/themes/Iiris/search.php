<!--connect to search form from front page This is coming from archive page-->

    <?php get_header();?>

<section class="page-wrap">
    <div class="container">

            
                <h1>Search Results for '<?php echo get_search_query();?>'</h1>

                <?php get_template_part('includes/section', 'searchresults');?>
                
                <!-- this is showing the one of the blog and showing previous of button and next of button. This works by wordpress setting -->
                <?php previous_posts_link();?>
                <?php next_posts_link();?>
            
        

        <!--This code will showing privious button and next button also number of pages. The code came from wordpress developer handbook-->
        <!-- <?php 
        global $wp_query;
        $big = 999999999; //need an unlikely integer
        echo paginate_links( array(
            'base' => str_replace($big, '%#%', esc_url( get_pagenum_link( $big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var( 'paged')),
            'total' => $wp_query->max_num_pages
        ) );
        ?> -->

    </div>
</section>

<?php get_footer();?>