<?php get_header();?>
<!-- This is for showing the each sections reference after click read more button -->
<section class="page-wrap">
    <div class="container">

    <h1><?php the_title();?></h1>

        <!--showing the thumbnail-->
        <?php if(has_post_thumbnail()):?>
            <div class="gallery">
                <a href="<?php the_post_thumbnail_url( 'blog-large');?>">
                    <img src="<?php the_post_thumbnail_url('blog-large');?>" alt="<?php the_title();?>" class="img-fluid mb-3 img-thumbnail">
                </a>
            </div>
        <?php endif;?>


    <div class="row">
            <div class="col-lg-6">

                <?php get_template_part('includes/section', 'cars');?>

                <!--showing the pages number in a post-->
                <?php wp_link_pages();?>
            </div>
            <div class="col-lg-6">
                <!-- You can add any additional content here, like a sidebar or other widgets. exsample coustum fields etc -->
                <!--This will show in the page-->
                 <!-- <ul>
                    <li>
                        Colour: <?php echo get_post_meta($post->ID, 'Colour', true); ?>
                    </li>

                     *if there is no output, then it will be hidden the output -->
                    <!-- <?php if (get_post_meta($post->ID, 'Registration', true)):?>
                    <li>
                        Registration: <?php echo get_post_meta($post->ID, 'Registration', true); ?>
                    </li>
                    <?php endif;?>
                 </ul> --> 


                <!--The otherhand, this can make by wordpress plugin too. Name is Advanced custom fields. although Garrely plugin will show in the own memo-->

                <!--Still otherhand, set up for showing the fields in the UI-->
                <div class="col-lg-6">

                        <?php get_template_part( 'includes/form', 'enquiry');?>

                    
                    <li>
                        Colour: <?php the_field('colour');?>
                    </li>                    
                    <li>
                        Registration: <?php the_field('registration');?>
                    </li>
                </div> 


                
            </div>

    </div>    

        

        
    </div>
</section>

<?php get_footer();?>