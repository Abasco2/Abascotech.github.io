<?php
/**
 * Set element Border options and generate css.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Border properties control.
 */
class Border extends Field {

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$args = $this->args;

		$style = array(
			'solid'  => esc_html__( 'Solid', 'basel' ),
			'dashed' => esc_html__( 'Dashed', 'basel' ),
			'dotted' => esc_html__( 'Dotted', 'basel' ),
			'double' => esc_html__( 'Double', 'basel' ),
			'none'   => esc_html__( 'None', 'basel' ),
		);

		?>

		<div class="xts-border">
			<?php if ( isset( $args['bottom'] ) && $args['bottom'] ) : ?>
				<div class="xts-border-bottom-width">
					<input type="text" name="<?php echo esc_attr( $this->get_input_name( 'bottom' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'bottom' ) ); ?>" placeholder="<?php echo esc_attr( 'Bottom', 'basel' ); ?>">
				</div>
			<?php endif; ?>

			<div class="xts-border-style">
				<select name="<?php echo esc_attr( $this->get_input_name( 'style' ) ); ?>">
					<?php foreach ( $style as $key => $value ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $this->get_field_value( 'style' ), $key ); ?>>
							<?php echo esc_html( $value ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="xts-border-color xts-color-control">
				<input type="text" data-alpha="<?php echo isset( $args['alpha'] ) ? esc_attr( $args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( 'color' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'color' ) ); ?>" />
			</div>
		</div>

		<?php
	}

	/**
	 * Enqueue color picker libs.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', BASEL_ASSETS . '/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), basel_get_theme_info( 'Version' ), true );
	}

	/**
	 * Output field's css code based on the settings..
	 *
	 * @since 1.0.0
	 *
	 * @return  string $output Generated CSS code.
	 */
	public function css_output() {
		if ( ! isset( $this->args['selector'] ) || empty( $this->args['selector'] ) || empty( $this->get_field_value() ) ) {
			return false;
		}

		$value = $this->get_field_value();

		$output = $this->args['selector'];

		$output .= '{';
		if ( isset( $value['color'] ) && ! empty( $value['color'] ) ) {
			$output .= 'border-color:' . $value['color'] . ';';
		}
		if ( isset( $value['style'] ) && ! empty( $value['style'] ) ) {
			$output .= 'border-style:' . $value['style'] . ';';
		}
		if ( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) {
			$output .= 'border-bottom-width:' . $value['bottom'] . 'px;';
		}

		$output .= '}';

		return $output;
	}
}


