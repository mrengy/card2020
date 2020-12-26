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

//customizing comment form to eliminate browser autocomplete
$neve_child_comment_field_name = "comment";
function neve_child_filter_comment_form(){
  return '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></textarea>';
}
add_filter( "comment_form_field_{$neve_child_comment_field_name}", 'neve_child_filter_comment_form' );

//add wp_enqueue_scripts
add_action( 'wp_enqueue_scripts', 'neve_child_enqueue_scripts');

function neve_child_enqueue_scripts() {
  wp_enqueue_script( 'open-children', get_stylesheet_directory_uri() . '/js/open-children.js', array( 'jquery' ), 1.0, true);
  wp_enqueue_script( 'spellcheck', get_stylesheet_directory_uri() . '/js/spellcheck.js', array( 'jquery'), 1.0, true);

  $neve_child_stylesheet_directory = array( 'stylesheet_directory_uri' => get_stylesheet_directory_uri() );
  wp_localize_script( 'spellcheck', 'neve_child_stylesheet_directory', $neve_child_stylesheet_directory );
}

//widget to show vocab list

  // Creating the widget
  class show_vocab extends WP_Widget {

    // The construct part
    function __construct() {
      parent::__construct(

      // Base ID of your widget
      'show_vocab_widget',

      // Widget name will appear in UI
      __("Myron's Vocabulary", 'show_vocab_widget_domain'),

      // Widget description
      array( 'description' => __( 'Showing vocab list from json file', 'mike-eng.com' ), )
      );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
      $title = apply_filters( 'widget_title', $instance['title'] );

      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

      // This is where you run the code and display the output
      $vocab_file = file_get_contents( get_stylesheet_directory_uri().'/js/vocab.json' );
      $vocab_arr = json_decode($vocab_file, true);

      echo('<dl>');
      foreach($vocab_arr['word'] as $item){
        echo(
          '<dt>'.
          $item['name'].
          '</dt>'
        );
        if(strlen($item['description']) > 0){
          echo(
            '<dd>'.
            $item['description'].
            '</dd>'
          );
        }
      }
      echo('</dl>');

      console_log($vocab_arr);

      //display other theme things
      echo $args['after_widget'];
    }

    // Creating widget Backend
    public function form( $instance ) {
      if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
      }
      else {
      $title = __( 'New title', 'show_vocab_widget_domain' );
      }
      // Widget admin form
      ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php
    }


    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      return $instance;
    }

    // Class show_vocab ends here
  }

  function show_vocab_load_widget() {
    register_widget( 'show_vocab' );
  }

  add_action( 'widgets_init', 'show_vocab_load_widget' );

//php debugging function
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
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
