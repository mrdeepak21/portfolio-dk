<?php
/**
* @version: 1.0.0
* @package: portfolio-by-deepak

Plugin name: Portfolio by Deepak
Author: Deepak Kumar
Author URI: https://www.linkedin.com/in/deepak01/
Description: Customized plugin to display portfolios. Use shortcode <code>[portfolio]</code> anywhere to display portfolios added from portfolio.
Version: 1.0.0
Plugin URI: #
*/ 


if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

// path and URL
define('PFPATH',plugin_dir_path(__FILE__));
define('PFURL',plugin_dir_url(__FILE__));

// main class
class PF_Portfolio{
    function __construct(){        
        add_action ('wp_enqueue_scripts', function () {
            wp_enqueue_style( 'dk-portfolio', PFURL.'front-end/css/master.css',false,'1.0');
            wp_enqueue_script( 'dk-portfolio', PFURL. 'front-end/js/master.js', array('jquery'), '1.0', true );
        });

// SHortcode
        add_shortcode('portfolio',function (){    


 // categoroes query
    $cat = get_categories('taxonomy=portfolio_categories&type=portfolio');
    ?>
    <div class='portfolio-content'>
    <ul class='portfolio-filters text-center'>
    <li class='port-cat'>
    <button class='filter button btn btn-sm btn-link active' id='all'>All</button></li>
    <?php
    foreach($cat as $category){ 
    $slug = strtolower($category -> slug);
    $cate  = $category -> name; 
        ?>
    <li class='port-cat'>
    <button class='filter button btn btn-sm btn-link' id='<?php echo $slug ?>'>
    <?php echo $cate ?> 
    </button>
    </li>
   <?php 
   }
    echo "</ul></div>";


    // post query               
    $portfolio = get_posts([
        'post_type'   => 'portfolio',
        'post_status' => 'publish',
        'posts_per_page' =>-1,
        'order'          => 'ASC'  
    ]);

    //  posts layout

    echo '<div id="project">';

    foreach ($portfolio as $port) {
        $port_id = $port-> ID;
        $cat = get_the_terms( $port_id,'portfolio_categories')[0];
        $url = get_metadata( 'post', $port_id, 'project_link',true );
    ?>
    <figure class="all project <?php echo $cat->slug; ?>">
    <a target="_blank" href="<?php echo $url; ?>">
    <div class="project-item-img">
    <?php 

    echo has_post_thumbnail($port_id )? get_the_post_thumbnail($port_id,'large'):""; 
    ?>

    </div>
    <h4 class="name"><?php echo $port->post_title; ?></h4>
    <div class="port-layer">
        <span class="category"><?php echo $cat->name;  ?></span>
        <span class="arrow">&#x1F855</span>
    </div>
    </a>
    </figure>
    <?php } ?>
</div>
<!-- /post layout --> 
    <?php
    });
    }
}
new PF_Portfolio();

