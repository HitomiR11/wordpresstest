<?php get_header();?>

<section class="page-wrap">
    <div class="container">

        <!--Show the title in front page-->
        <h1><?php the_title();?></h1>
        <!--Show the section-content.php in front page-->
        <?php get_template_part('includes/section', 'content');?>

        <!--Search form template for front page. when searchform.php have then underneath line doesn't need-->
        <?php get_search_form();?>

    </div>
</section>

<?php get_footer();?>