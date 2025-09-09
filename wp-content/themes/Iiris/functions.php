<?php

// Load stylesheet
function load_css()
{
        wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all' );
        wp_enqueue_style('bootstrap');

        wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), false, 'all' );
        wp_enqueue_style('main');


}
add_action('wp_enqueue_scripts', 'load_css');

// Load Javascript
function load_js()
{
        wp_enqueue_script('jquery');

        wp_register_script( 'bootstrap',  get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery', false, true);
        wp_enqueue_script('bootstrap');
}
add_action('wp_enqueue_scripts', 'load_js');

//Theme Options
add_theme_support( 'menus');
//Post Thumbnails
add_theme_support( 'post-thumbnails' );
//widget for side bar
add_theme_support( 'widgets');

//Menus for wordpress setting of appearance
register_nav_menus(

        array(
                'top-menu' => 'Top Menu Location',
                'mobile-menu' => 'Mobile Menu Location',
                'footer-menu' => 'Footer Menu Location',
        )
);

//custom image sizes
add_image_size( 'blog-large', 800, 400, true); 
add_image_size( 'blog-small', 300, 200, true);

// Register sidebars
function my_sidebars()
{
        register_sidebar( 
                array(
                        'name' => 'Page Sidebar',
                        'id' => 'page-sidebar',
                        'before_title' => '<h4 class="widget-title">',
                        'after_title' => '</h4>'
                )
                );
        register_sidebar( 
                array(
                        'name' => 'Blog Sidebar',
                        'id' => 'blog-sidebar',
                        'before_title' => '<h4 class="widget-title">',
                        'after_title' => '</h4>'
                )
                );
}
add_action( 'widgets_init', 'my_sidebars' );

//custom post type for exsample of car's dealer
// This function is used to create a custom post type in WordPress.
function my_first_post_type()
{
        $args = array(

                //label for showing in wordpress admin page
                'labels' => array(
                        'name' => 'Cars',
                        'singular_name' => 'Car',

                        // underneath for set Add new in label
                        'add_new' => 'Add New',
                        'add_new_item' => 'Add New',
                ),

                //  for hierarchical post type, like pages
                //  if you want to use it like posts, set it to false
                'hierrachical' => true,

                //  for frontend and backend
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-car', // Icon for the post type in the admin menu.
                //https://developer.wordpress.org/resource/dashicons/#images-alt2

                'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
                
                //if want to set to slug of the name                 
                //'rewrite' => array('slug' => 'cars'),
        );

        register_post_type( 'cars', $args);
}
add_action( 'init', 'my_first_post_type' );


// category's cars in labels
// This function is used to create a custom taxonomy in WordPress.
function my_first_taxonomy()
{
        $args = array(

                //label for showing in wordpress admin page. 
                 'labels' => array(
                         'name' => 'Brands',
                         'singular_name' => 'Brand',
                 ),

                'public' => true,

                // Set to true for hierarchical taxonomy like categories. showing Tags when set up false and didn't set labels.
                'hierarchical' => true, 
                );
        register_taxonomy( 'brands', array('cars'), $args );
        // 'cars' is the post type we want to associate this taxonomy with

}
add_action('init', 'my_first_taxonomy');

// Enquiry form handler
add_action( 'wp_ajax_enquiry', 'enquiry_form');
add_action( 'wp_ajax_nopriv_enquiry', 'enquiry_form');//if not login user can use this too
function enquiry_form()
{

        if( !wp_verify_nonce($_POST['nonce'], 'ajax-nonce'))
        {
                wp_send_json_error('Nonce is incorrect', 401);
                die();
        }

        $formdata = [];

        wp_parse_str($_POST ['enquiry'], $formdata);

        // admin email address
        $admin_email = get_option('admin_email');

        //Email headers
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: My Website <' . $admin_email . '>';
        $headers[] = 'Reply-to:' . $formdata['email'];

        //Who are we sending the email to?
        $send_to = $admin_email;

        //Subject of the email
        $subject = "Enquiry from" . $formdata['fname'] . ' ' . $formdata['lname'];

        // Message
        $message = '';

        foreach($formdata as $index => $field)
        {
                $message .= '<strong>' . $index . '</strong>: ' . $field . '<br/>';
        }

        // Send the email
        try{
                if(wp_mail($send_to, $subjuct, $message, $headers))
                {
                        wp_send_json_success( 'Email send');
                }
                else
                {
                        wp_send_json_error('Email not sent');
                }
        }
        catch(Exception $e)
        {
                wp_send_json_error($e->getMessage());
        }

        wp_send_json_success($formdata['fname']);
}

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );




// this is for mail


add_action( 'phpmailer_init', 'custom_mailer' );
function custom_mailer(PHPMailer $phpmailer)
{
        $phpmailer->SetFrom('iiris.service@outlook.com', 'Iiris Service');
        //Amazon case
        $phpmailer->Host = 'email-smtp.us-west-2.amazonaws.com';
        $phpmailer->Port = 587;
        // this will be login info needed
        $phpmailer->SMTPAuth = true;
        // TSL or SSL
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Username = SMTP_LOGIN;
        $phpmailer->Password = SMTP_PASSWORD;
        $phpmailer->IsSMTP();
}       

// piece of code for latest_cars in home page. shortcode
function my_shortcode($atts, $content = null, $tag = '')
{
        //check the variable - $atts
                //print_r($atts);

        // check the tag
                //echo $tag;


        print_r($content);


        // this is for shortcode php function(output buffering)
        ob_start();

        //set to the variable. attributes of manipurate in latest-car.php
        set_query_var( 'attributes', $atts );

        get_template_part( 'includes/latest', 'cars' );
        //ob_get_clean gets all output and clean buffer
        return ob_get_clean();

        //return get_template_part( 'includes/latest', 'cars' );
}
add_shortcode( 'latest_cars', 'my_shortcode');

//shourtcode extra
function my_phone()
{
        return '<a href="tel:123-456-7890">123-456-7890</a>';
}
add_shortcode('phone', 'my_phone');



// Search query
function search_query()
{
        // set the page of number
        $paged = (get_query_var( 'paged' )) ? get_query_var( 'paged') : 1;

        $args = [
                'paged' => $paged,     
                'post_type' => 'cars',
                'posts_per_page' => 1,
                // 's' => 'keyword',
                'tax_query' => [],
                'meta_query' => [
                'relation' => 'AND',
                        ],
                ];

                    // this works for submit button by keyword. Sinitize is repair strange text automatically in url
                    if(isset($_GET['keyword']))
                    {
                        if(!empty($_GET['keyword']))
                        {
                        $args['s'] = sanitize_text_field(  $_GET['keyword'] );
                        }
                    }

                    //this works for the search button for brand. Inside of args array understand by url etc.
                    if(isset($_GET['brand']))
                    {
                        if(!empty($_GET['brand']))
                        {
                            $args['tax_query'][] = [
                                    'taxonomy' => 'brands',
                                    'field' => 'slug',
                                    'terms' => array( sanitize_text_field ($_GET['brand']) )
                            ];
                        }
                    }

                    //Search for the prices of above
                     if(isset($_GET['price_above']))
                    {
                        if(!empty($_GET['price_above']))
                        {
                            $args['meta_query'][] = array(
                                'key' => 'price',
                                'value' => sanitize_text_field( $_GET['price_above'] ),
                                'type' => 'numeric',
                                'compare' => '>='
                            );
                        }
                    }

                    //Search for the prices of below
                     if(isset($_GET['price_below']))
                    {
                        if(!empty($_GET['price_below']))
                        {
                            $args['meta_query'][] = array(
                                'key' => 'price',
                                'value' => sanitize_text_field( $_GET['price_below'] ),
                                'type' => 'numeric',
                                'compare' => '<='
                            );
                        }
                        
                    }   

        return new WP_Query($args);
}