<?php get_header();?>

<section class="page-wrap">
    <div class="container">

        <h1><?php echo single_cat_title();?></h1>


        <!-- THIS IS CATEGORY BLOG TEMPLATE -->

        <?php get_template_part('includes/section', 'archive');?>
        <!-- this is showing the one of the blog and showing previous of button and next of button. This works by wordpress setting -->
        <?php previous_posts_link();?>
        <?php next_posts_link();?>
    </div>
</section>

<?php get_footer();?>