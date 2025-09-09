<?php

$attributes = get_query_var( 'attributes' );

// test print of attributes
    //print_r($attributes['colour']);


//array for the shortcode connecting to home page, where wrote the shortcode. parameters. 
// example -> in the wordpress page could write like ->  [latest_cars price_above="20000" colour="black"]
$args = [
    'post_type' => 'cars',
    // 'meta_key' => 'colour',
    // 'meta_value' => $attributes['colour'],
    'posts_per_page' => 0, // latest 1 post. if 0 set to the number, then unlimited
    'tax_query' => [
                // [
                //     'taxonomy' => 'brands',
                //     'field' => 'slug',
                //     'terms' =>  array($attributes['brand']), // or [$attributes['brand']]
                    
                // ]
            ],
    'meta_query' => [
            // Below code set to the inside of isset price_below and it can set to inside of isset colour
                // array(
                //     'key' => 'price',
                //     'value' => $attributes['price_below'],
                //     'type' => 'numeric',
                //     'compare' => '<='
                // )
            ],
        ];

     if(isset($attributes['price_above']))
    {
        $args['meta_query'][] = array(
                    'key' => 'price',
                    'value' => $attributes['price_above'],
                    'type' => 'numeric',
                    'compare' => '>='
        );
    }


    if(isset($attributes['price_below']))
    {
        $args['meta_query'][] = array(
                    'key' => 'price',
                    'value' => $attributes['price_below'],
                    'type' => 'numeric',
                    'compare' => '<='
        );
    }


    if(isset($attributes['colour']))
    {
        $args['meta_query'][] = array(
                    'key' => 'colour',
                    'value' => $attributes['colour'],
                    'compare' => '='
        );

        // $args['meta_key'] = 'colour';
        // $args['meta_value'] = $attributes['colour'];
    }

    if(isset($attributes['brand']))
    {
        $args['tax_query'][] = [
            'taxonomy' => 'brands',
            'field' => 'slug',
            'terms' => array( $attributes['brand']),
        ];
    }

$query = new WP_Query($args);

?>

<!-- echo is coming automatically from get_template_part -->
<?php if($query->have_posts()):?>
    <?php while($query->have_posts() ) : $query->the_post();?>
        <div class="card mb-3">
            <div class="card-body">
                <a href="<?php the_post_thumbnail_url( 'blog-large');?>">
                    <img src="<?php the_post_thumbnail_url('blog-large');?>" alt="<?php the_title();?>" class="img-fluid mb-3 img-thumbnail">
                </a>
                <h3><?php the_title();?></h3>

                <?php the_field('registration');?>
            </div>    
        </div>  
    <?php endwhile;?>
<?php endif;?>