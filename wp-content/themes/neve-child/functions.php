<?php

//adding child theme stylesheet after parent theme stylesheet
add_action( 'wp_enqueue_scripts', 'neve_child_enqueue_styles' );
function neve_child_enqueue_styles() {

    $parent_style = 'neve-style'; // loaded in front_end.php inside the neve theme folder

    //wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.min.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style),
        wp_get_theme()->get('Version')
    );
}

//obfuscating emails using email-address-encoder plugin https://encoder.till.im/guide#filtering-content
if ( function_exists( 'eae_encode_emails' ) )  {
    add_filter( 'wp_nav_menu_items', 'eae_encode_emails' );
}

//add wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'neve_child_enqueue_scripts');

function neve_child_enqueue_scripts() {
  wp_enqueue_script( 'open-children', get_stylesheet_directory_uri() . '/js/open-children.js', array ( 'jquery' ), 1.0, true);
  wp_enqueue_script( 'typo-js', get_stylesheet_directory_uri() . '/js/typo.js', array ( 'jquery' ), 1.0, true);
}
//add google analytics
add_action('wp_head', 'wpb_add_googleanalytics');
function wpb_add_googleanalytics() { ?>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-15294685-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-15294685-1');
  </script>

<?php } ?>
