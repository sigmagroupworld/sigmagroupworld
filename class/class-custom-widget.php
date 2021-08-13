<?php
// Creating the widget 
class sigma_mt_widget extends WP_Widget {
  
	function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'sigma_mt_widget', 
		  
		// Widget name will appear in UI
		__('Latest News Widget', 'sigmaigaming'), 
		  
		// Widget description
		array( 'description' => __( 'Latest News Posts', 'sigmaigaming' ), ) 
		);
	}
  
	// Creating widget front-end
	public function widget( $args, $instance ) {
		$cache = wp_cache_get('sigma_mt_widget', 'widget');
		$title = apply_filters( 'widget_title', $instance['title'] );
		  
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		echo $args['before_title'] . $title . $args['after_title'];

		ob_start();
        extract($args);

        $wp_query = new WP_Query(array('showposts' => 5, 'nopaging' => 0, 'post_status' => 'publish', 'post_type' => 'news-items')); ?>
        <div class="blog-rightbar">
			<div class="magazine-widget bottom-border">
		        <?php if ($wp_query->have_posts()) : ?>
		        	<?php echo $before_widget; ?>
		        	<div class="blog-sub-title"><h3><?php if ( $title ) echo $before_title . $title . $after_title; ?></h3></div>
		    		<ul>
		    			<?php  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
		    				<li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
		    			<?php endwhile; ?>
		    		</ul>
		        	<?php echo $after_widget; ?>
					<?php wp_reset_postdata();
		        endif; ?>
		    </div>
		</div>
        <?php $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('sigma_mt_widget', $cache, 'widget');
		  
		// This is where you run the code and display the output
		$post_tag_args = array(
          'posts_per_page' => 5,
          'post_type' => 'news-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
        $get_posts = get_posts($post_tag_args);
        return $get_posts;
		echo $args['after_widget'];
	}
          
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'sigmaigaming' );
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
 
	// Class wpb_widget ends here
} 