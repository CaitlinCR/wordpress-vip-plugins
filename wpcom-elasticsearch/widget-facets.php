<?php

class WPCOM_elasticsearch_Widget_Facets extends WP_Widget {

	function __construct() {
		if ( ! function_exists( 'WPCOM_elasticsearch' ) )
			return;

		parent::__construct(
			'wpcom-elasticsearch-facets',
			__( 'WP.com VIP Search: Facets', 'wpcom-elasticsearch' ),
			array(
				'classname'   => 'wpcom-elasticsearch-facets',
				'description' => __( 'Displays search result faceting when viewing a search result. Is hidden otherwise.', 'wpcom-elasticsearch' ),
			)
		);
	}

	function widget( $args, $instance ) {
		if ( ! function_exists( 'WPCOM_elasticsearch' ) || ! is_search() )
			return;

		$facets = WPCOM_elasticsearch()->get_search_facet_data();

		if ( ! $facets )
			return;

		$facets_found = false;
		foreach ( $facets as $facet ) {
			if ( count( $facet['items'] ) > 1 ) {
				$facets_found = true;
				break;
			}
		}
		if ( ! $facets_found )
			return;


		$title = apply_filters( 'widget_title', ! empty( $instance['title'] ) ? $instance['title'] : 'Search Refinement', $instance, $this->id_base );

		echo $args['before_widget'];

		echo $args['before_title'] . $title . $args['after_title'];

		foreach ( $facets as $label => $facet ) {
			$item_count = count( $facet['items'] );

			if ( $item_count < 2 )
				continue;

			// Some facet types like date_histogram don't support the max results parameter
			if ( ! empty( WPCOM_elasticsearch()->facets[ $label ] ) && ! empty( WPCOM_elasticsearch()->facets[ $label ]['count'] ) && $item_count > WPCOM_elasticsearch()->facets[ $label ]['count'] ) {
				$facet['items'] = array_slice( $facet['items'], 0, WPCOM_elasticsearch()->facets[ $label ]['count'] );
			}

			echo '<h3>' . $label . '</h3>';
			echo '<ul>';

			foreach ( $facet['items'] as $item ) {
				echo '<li><a href="' . esc_url( $item['url'] ) . '">' . $item['name'] . '</a> (' . number_format_i18n( absint( $item['count'] ) ). ')</li>';
			}

			echo '</ul>';
		}

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags( $instance['title'] );
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
<?php
	}
}