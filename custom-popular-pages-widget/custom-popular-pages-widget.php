<?php
/*
Plugin Name: Custom Popular Pages
Description: Custom Popular Pages widget for use in sidebar
*/
/* Start Adding Functions Below this Line */

/**
 * Enable viewcounts for topics
  */
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 Views";
    }
    return $count.' Views';
}

function test_for_metadata($id,$key,$value) {
	if ($key == '') return false;
	else if ($value == '') return get_post_meta($page->ID,$key,true) != '';
	else return get_post_meta($id,$key,true) == $value;
}

function check_parents_for_metadata($key,$value) {
	global $post;
	if($post->ID) {
		if (test_for_metadata($page->ID,$key,$value)) return true;
		
		$parent_id = $post->post_parent;

		while ($parent_id) {
			if (test_for_metadata($parent_id,$key,$value)) return true;
			$page = get_page($parent_id);
			$parent_id = $page->post_parent;
		}
	}
	return false;
}

/**
 * Add track posts function to wp_head
 */
// Doesn't work...
/**function track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    set_post_views($post_id);
}
add_action( 'wp_head', 'track_post_views');**/


/**
 * Widget for sidebar
 **/
class popular_pages_widget extends WP_Widget {

  function __construct() {
	parent::__construct(
	  // Base ID of your widget
	  'popular_pages_widget', 
	  
	  // Widget name will appear in UI
	  __('Popular Pages Widget', 'popular_pages_widget_domain'), 
	  
	  // Widget description
	  array( 'description' => __( 'A widget that will list the pages with the most views.', 'popular_pages_widget_domain' ), ) 
	);
  }
  
  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];
	
	// This is where you run the code and display the output
	$meta_args = array(
	  array(
		  'key' => 'post_views_count'
		  )
	  );
	$custom_query = array();
	// Below is for checking if each individual page has the metadata values.
	// Currently using L132 to check all parents for metadata values instead.
	/*
	if ( !empty($instance['meta_key'])) $custom_query['key'] = $instance['meta_key'];
	if ( !empty($instance['meta_value'])) $custom_query['value'] = $instance['meta_value'];
	if ( !empty($custom_query)) $meta_args[] = $custom_query;
	*/
	$query_args = array(
      'post_type' => 'page',
	  'posts_per_page' => $instance['number_to_show'],
	  'meta_query' => $meta_args,
      'orderby' => array(
	    array(
		  'meta_key' => 'post_views_count',
		  'field' => 'meta_value_num',
		  'order' => 'DESC'
	    )
	  )
	);
	$popularpost = new WP_Query( $query_args );
	while ( $popularpost->have_posts() ) { 
	  $popularpost->the_post();
	  
	  if (check_parents_for_metadata($instance['meta_key'],$instance['meta_value'])) {
		  ?>
		  <a class="popular-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		  <?php
	  }
	}
	echo $args['after_widget'];
  }
		  
  // Widget Backend 
  public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	  $title = $instance[ 'title' ];
	}
	else {
	  $title = __( 'New title', 'popular_pages_widget_domain' );
	}
	if (isset ($instance[ 'number_to_show' ])) {
	  $number_to_show = $instance[ 'number_to_show' ];
	} else {
	  $number_to_show = "10";
	}
	if (isset ($instance[ 'meta_key' ])) {
	  $meta_key = $instance[ 'meta_key' ];
	} else {
	  $meta_key = "";
	}
	if (isset ($instance[ 'meta_value' ])) {
	  $meta_value = $instance[ 'meta_value' ];
	} else {
	  $meta_value = "";
	}
	// Widget admin form
	?>
	<p>
	  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id( 'number_to_show' ); ?>"><?php _e( 'Number of posts to show:' ) ?></label>
	  <input id="<?php echo $this->get_field_id( 'number_to_show' ); ?>" name="<?php echo $this->get_field_name( 'number_to_show' ); ?>" type="text" value="<?php echo esc_attr( $number_to_show ); ?>" size="3">
	</p>
    <p>
	  <label style="display:block;font-weight:bold;"><?php _e('Metadata Filters:') ?></label>
	  <label for="<?php echo $this->get_field_id( 'meta_key' ); ?>"><?php _e( 'Metadata Key:' ) ?></label>
	  <input class="widefat" id="<?php echo $this->get_field_id( 'meta_key' ); ?>" name="<?php echo $this->get_field_name( 'meta_key' ); ?>" type="text" value="<?php echo esc_attr( $meta_key ); ?>" size="3">
	  <label for="<?php echo $this->get_field_id( 'meta_value' ); ?>"><?php _e( 'Metadata Value:' ) ?></label>
	  <input class="widefat" id="<?php echo $this->get_field_id( 'meta_value' ); ?>" name="<?php echo $this->get_field_name( 'meta_value' ); ?>" type="text" value="<?php echo esc_attr( $meta_value ); ?>" size="3">
	</p>
	<?php 
  }
	  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['number_to_show'] = ( ! empty( $new_instance['number_to_show'] ) ) ? strip_tags( $new_instance['number_to_show'] ) : '10';
	$instance['meta_key'] = ( ! empty( $new_instance['meta_key'] ) ) ? strip_tags( $new_instance['meta_key'] ) : '';
	$instance['meta_value'] = ( ! empty( $new_instance['meta_value'] ) ) ? strip_tags( $new_instance['meta_value'] ) : '';
	return $instance;
  }
} // Class wpb_widget ends here

// Register and load the widget
function load_widget() {
	register_widget( 'popular_pages_widget' );
}
add_action( 'widgets_init', 'load_widget' );
/* Stop Adding Functions Below this Line */
?>