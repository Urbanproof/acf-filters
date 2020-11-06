<?php

declare( strict_types = 1 );
namespace Urbanproof\ACF\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FilterField extends \acf_field {

	private $settings;

	public function __construct( array $settings )
	{
		$this->name = 'FILTERS';
		$this->label = __( 'Post filters', 'acf-filters' );
		$this->category = 'relational';
		$this->settings = $settings;
		parent::__construct();
	}

	public function render_field( array $field )
	{
		/**
		 * Sorting options
		 */
		$order_by_fields = array(
			'none'          => __( 'No ordering', 'acf-filters' ),
			'ID'            => __( 'Order by post ID', 'acf-filters' ),
			'author'        => __( 'Order by author', 'acf-filters' ),
			'title'         => __( 'Order by title.', 'acf-filters' ),
			'name'          => __( 'Order by post name', 'acf-filters' ),
			'type'          => __( 'Order by post type', 'acf-filters' ),
			'date'          => __( 'Order by date', 'acf-filters' ),
			'modified'      => __( 'Order by last modified date', 'acf-filters' ),
			'parent'        => __( 'Order by post/page parent id', 'acf-filters' ),
			'rand'          => __( 'Random order', 'acf-filters' ),
			'comment_count' => __( 'Order by number of comments', 'acf-filters' ),
			'menu_order'    => __( 'Order by Page Order', 'acf-filters' ),
		);
		?>
		<fieldset>
			<legend>
				<?php esc_html_e( 'Sorting options', 'acf-filters' ); ?>
			</legend>
			<label>
				<?php esc_html_e( 'Order results by:', 'acf-filters' ); ?>
				<select name="<?php echo esc_attr( $field['name'] ); ?>[orderby]">
					<?php foreach ( $order_by_fields as $value => $label ) : ?>
						<option
							value="<?php echo esc_attr( $value ); ?>"
							<?php selected( $field['value']['orderby'] === $value ); ?>
						>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>
				<?php esc_html_e( 'Sorting order:', 'acf-filter' ); ?>
				<select name="<?php echo esc_attr( $field['name'] ); ?>[order]">
					<option
						value="ASC"
						<?php selected( $field['value']['order'] === $value ); ?>
					>
						<?php esc_html_e( 'Ascending', 'acf-filters' ); ?>
					</option>
					<option
						value="DESC"
						<?php selected( $field['value']['order'] === $value || ! isset( $field['value']['order'] ) ); ?>
					>
						<?php esc_html_e( 'Descending', 'acf-filters' ); ?>
					</option>
				</select>
			</label>
		</fieldset>
		<?php
		/**
		 * Post types
		 */
		$post_types = get_post_types( array( 'exclude_from_search' => false ), 'objects' );
		?>
		<fieldset>
			<legend>
				<?php echo esc_html( __( 'Post types', 'acf-filters' ) ); ?>
			</legend>
			<?php foreach ( $post_types as $post_type_object ) : ?>
				<label>
					<input
						name="<?php echo esc_attr( $field['name'] ); ?>[post_types][]"
						type="checkbox"
						value="<?php echo esc_attr( $post_type_object->name ); ?>"
						<?php
						checked( in_array(
							$post_type_object->name,
							( $field['value']['post_types'] ?? [] ),
							true
						) );
						?>
					/>
					<?php echo esc_html( $post_type_object->label ); ?>
				</label>
			<?php endforeach; ?>
		</fieldset>
		<?php
		/**
		 * Taxonomies
		 * This is going to look messy;
		 * Iterate over post types
		 *   -> iterate over post type taxonomies
		 *     -> iterate over taxonomy terms
		 */
		?>
		<?php
		foreach ( $post_types as $post_type_object ) :
			$taxonomies = get_object_taxonomies( $post_type_object->name, 'objects' );
			foreach ( $taxonomies as $taxonomy_obj ) :
		?>
				<details>
					<summary>
						<?php echo esc_html( $taxonomy_obj->label ); ?>
						&nbsp;(<?php echo esc_html( $post_type_object->label ); ?>)
					</summary>
					<ul>
					<?php
					$terms = get_terms( array(
						'taxonomy'   => $taxonomy_obj->name,
						'hide_empty' => false,
						'fields'     => 'id=>name',
					) );
					foreach ( $terms as $term_id => $term_name ) :
					?>
						<li>
							<label>
								<input
									name="<?php echo esc_attr( $field['name'] ); ?>[taxonomies][<?php echo esc_attr( $taxonomy_obj->name ); ?>][terms][]"
									type="checkbox"
									value="<?php echo esc_attr( $term_id ); ?>"
									<?php
									checked( in_array(
										$term_id,
										array_map( 'absint', $field['value']['taxonomies'][ $taxonomy_obj->name ]['terms'] ?? [] ),
										true
									) );
									?>
								/>
								<?php echo esc_html( $term_name ); ?>
							</label>
						</li>
					<?php endforeach; ?>
					</ul>
				</details>
			<?php endforeach; ?>
		<?php endforeach; ?>
		<?php
	}

}
