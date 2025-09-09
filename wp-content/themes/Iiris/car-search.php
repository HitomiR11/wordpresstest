<!-- template for car search -->

<?php

/*
Template Name: Car Search
*/

$is_search = count($_GET);

//showing the details of the brands
 $brands = get_terms([
     'taxonomy' => 'brands',
     'hide_empty' => false,
 ]);

// shortcode               

  if($is_search)
    {

      $query = search_query();
    }
              

?>

<!--get from page.php-->
<?php get_header();?>

<!-- <pre>
    <?php print_r($brands);?>
</pre> -->

<section class="page-wrap">
    <div class="container">
        <div class="card">
            <div class="card-body mb-3">
                <form action="<?php echo home_url( '/car-search');?>">
                    <div class="form-group mb-3">
                        <label>Type a keyword</label>
                        <input 
                        type="text" 
                        name="keyword" 
                        placeholder="Type a keyword" 
                        class="form-control"
                        value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '';?>"
                        >
                        <!-- above of the value is used to keep the value in the search box after searching -->
                    </div>

                    <label>Choose a brand</label>
                    <!-- this is dropdown for brands of name -->
                    <div class="form-group mb-3">
                        <select name="brand" class="form-select">
                            <!-- showing the message in side of the dropdown -->
                            <option value="">Choose a brand</option>

                            <?php foreach($brands as $brand):?>
                                    <option 
                                    <?php if(isset($_GET['brand']) && ($_GET['brand'] == $brand->slug)):?>
                                        selected
                                    <?php endif;?>
                                    
                                    value="<?php echo $brand->slug;?>">   
                                        <?php echo $brand->name;?>
                                    </option>

                                    <!-- inside of the option if cede will keep the value in the search box after searching -->
                            <?php endforeach;?>
                        </select>

                    </div>

                    <!-- This is for the prices -->
                    <div class="form-group row mb-3">
                        <div class="col-lg-6">
                            <label>From Price</label>
                                <!-- select name show in url after submit button -->
                                <select name="price_above" class="form-select">
                                    <?php for($i=0; $i < 210000; $i+=10000):?>
                                        <option 
                                            <?php if(isset($_GET['price_above']) && ($_GET['price_above'] == $i)):?>
                                                selected
                                            <?php endif;?>
                                            value="<?php echo $i;?>">
                                            <?php echo '$' . number_format($i) ;?>
                                        </option>
                                    <?php endfor;?>
                                </select>
                        </div>
                        <div class="col-lg-6">
                            <label>To Price</label>
                                <!-- select name show in url after submit button -->
                                <select name="price_below" class="form-select">
                                    <?php for($i=0; $i < 210000; $i+=10000):?>
                                        <option 
                                            <?php if(isset($_GET['price_below']) && ($_GET['price_below'] == $i)):?>
                                                selected

                                            <?php elseif( $i == 200000):?>
                                                selected

                                            <?php endif;?>

                                            value="<?php echo $i;?>">
                                            <?php echo '$' . number_format($i) ;?>
                                        </option>
                                        <!-- elseif set to the price of below higher price -->
                                    <?php endfor;?>
                                </select>
                        </div>

                    </div>


                    <button type="submit" class="btn btn-success btn-lg d-grid gap-2 col-8 mx-auto mb-3">Search</button>

                    <!-- Reset for the search -->
                    <a href="<?php echo home_url( '/car-search');?>">Reset search</a>

                </form>


                                
                <!-- <pre><?php print_r($query);?></pre>  -->


                <!-- This first if makes for no repeat the picture -->
                <?php if($is_search):?>

                    <?php if($query->have_posts()):?>
                        <?php while($query->have_posts()) : $query->the_post();?>

                        <a href="<?php the_post_thumbnail_url( 'blog-large');?>">
                            <img src="<?php the_post_thumbnail_url('blog-large');?>" alt="<?php the_title();?>" class="img-fluid mb-3 img-thumbnail">
                        </a>
                            <h3><?php the_title();?></h3>
                        <?php endwhile;?>

                        <!-- paged of number. Cut from github mrdigital-->
                         <div class="pagination">
                            <?php 
                                echo paginate_links( array(
                                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                    'total'        => $query->max_num_pages,
                                    'current'      => max( 1, get_query_var( 'paged' ) ),
                                    'format'       => '?paged=%#%',
                                    'show_all'     => false,
                                    'type'         => 'plain',
                                    'end_size'     => 2,
                                    'mid_size'     => 1,
                                    'prev_next'    => true,
                                    'prev_text'    => sprintf( '<i></i> %1$s', __( 'Prev', 'text-domain' ) ),
                                    'next_text'    => sprintf( '%1$s <i></i>', __( 'Next', 'text-domain' ) ),
                                    'add_args'     => false,
                                    'add_fragment' => '',
                                ) );
                            ?>
                        </div>

                        <!-- This will reset end of the_title function -->
                        <?php wp_reset_postdata(  );?>

                    <?php else:?>
                        <!-- make a space -->
                        <div class="clearfix mb-3"></div>

                        <div class="alert alert-danger">There are no result</div>

                    <?php endif;?>
                <?php endif;?>

                
                <!-- <?php the_title();?> -->

            </div>
        </div>

</div>
</section>

<?php get_footer();?>