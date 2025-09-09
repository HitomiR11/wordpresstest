<?php if( have_posts(  )): while( have_posts(  )): the_post(  );?>    

<!--Show the date and time-->
<p><?php echo get_the_date('d/m/Y h:i:s');?></p>

    <?php the_content();?>

    <!-- Showing the name of name by wordpress profile -->
    <?php
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
    // echo $fname . ' ' . $lname;
    ?>
    <!--other option-->
    <p>Posted by <?php echo $fname;?> <?php echo $lname;?></p>

<!--Showing the Tag-->
<?php
$tags = get_the_tags();
if ($tags):
    foreach($tags as $tag):?>
        <a href="<?php echo get_tag_link($tag->term_id);?>" class="btn btn-primary btn-sm">
            <?php echo $tag->name;?>
        </a>
    <?php endforeach;
endif;?>


    <!-- Showing the category -->
    <?php
    $categories = get_the_category();
    foreach($categories as $cat):?>
    <!--category if link-->
        <a href="<?php echo get_category_link( $cat->term_id);?>">
            <?php echo $cat->name;?>
        </a>       
    <?php endforeach;?>

    <!--coments-->
    <?php //comments_template();?> 

<?php endwhile; else: endif;?>