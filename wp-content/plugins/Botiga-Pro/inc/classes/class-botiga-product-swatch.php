<?php
/**
 * Botiga Product Swatch
 *
 * @package Botiga_Pro
 */

 class Botiga_Product_Swatch {
    public function __construct() {
        $enable = get_theme_mod( 'product_swatch', 1 );

        if( ! $enable ) {
            return;
        }

        if( is_admin() ) {
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_filter( 'product_attributes_type_selector', array( $this, 'available_attributes_types' ) );
            add_action( 'admin_init', array( $this, 'add_custom_attribute_fields' ) );
        }

        add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'variation_attribute_options_html' ), 10, 2 );
    }

    public function admin_enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
    }

    public function available_attributes_types() {
        if( ! wp_doing_ajax() && ( ! isset( $_GET['post'] ) && ! isset( $_GET['action'] ) ) ) {
            return array(
                'select' => __( 'Select', 'botiga' ),
                'color'  => __( 'Color', 'botiga' ),
                // 'image'  => __( 'Image', 'botiga' ),
                'button' => __( 'Button', 'botiga' )
            );
        }
	}

    public function add_custom_attribute_fields() {
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        foreach( $attribute_taxonomies as $att_tax ) {
            add_action( "pa_{$att_tax->attribute_name}_add_form_fields", array( $this, 'add' ) );
            add_action( "pa_{$att_tax->attribute_name}_edit_form_fields", array( $this, 'edit' ) );
            add_action( "created_term", array( $this, 'save' ), 10, 3 );
            add_action( "edit_term", array( $this, 'save' ), 10, 3 );
        }
    }

    public function get_the_term_handled( $tax_slug = '' ) {
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        foreach( $attribute_taxonomies as $tax ) {
            if( $tax_slug === 'pa_' . $tax->attribute_name ) {
                return $tax;
            }
        }

        return false;
    }

    public function add( $tax_slug ) {
        if( $tax = $this->get_the_term_handled( $tax_slug ) ) {
            $this->custom_attribute_field_html_content( $tax->attribute_type, $tax->attribute_label );
        }
    }

    public function edit( $term ) {
        if( $tax = $this->get_the_term_handled( $term->taxonomy ) ) {
            $value = '';
            $term_meta = get_term_meta( $term->term_id );

            foreach( $term_meta as $meta_key => $meta_value ) {
                if( 'product_attribute_color' === $meta_key ) {
                    $value = $meta_value[0];
                }
            }

            $this->custom_attribute_field_html_content( $tax->attribute_type, $tax->attribute_label, $value, $term );
        }
    }

    public function custom_attribute_field_html_content( $att_type = 'select', $att_label = '', $default_value = '', $term = false ) {
        
        // Do nothing with button type for now
        // improvements will come later
        if( $att_type === 'button' || $att_type === 'select' ) {
            return;
        }

        $this->custom_attribute_field_html_open( $term, $att_label );
        
        switch ( $att_type ) {
            case 'color':
                echo '<input type="text" name="tag-color" value="'. esc_attr( $default_value ) .'" class="botiga-color-field" />';
                echo '<script type="text/javascript">';
                echo '    jQuery(document).ready(function($){';
                echo '          $(".botiga-color-field").wpColorPicker();';
                echo '    });';
                echo '</script>';
                break;

            case 'button':
                // Nothing for now
                break;
            
        }

        $this->custom_attribute_field_html_close( $term );
    }
    
    public function custom_attribute_field_html_open( $term, $att_label ) {
        if( ! $term ) {
            echo '<div class="form-field">';
            echo '  <label for="attribute_type">'. esc_html( $att_label ) .'</label>';
        } else {
            echo '<tr class="form-field form-required term-name-wrap">';
            echo '    <th scope="row"><label>'. esc_html( $att_label ) .'</label></th>';
            echo '    <td>';
        }
    }

    public function custom_attribute_field_html_close( $term ) {
        if( ! $term ) {
            echo '</div>';
        } else {
            echo '    </td>';
            echo '</tr>';
        }
    }

    public function save( $term_id, $tid, $tax_slug ) {        
        $field_id = '';

        if( $tax = $this->get_the_term_handled( $tax_slug ) ) {
            switch ( $tax->attribute_type ) {
                case 'color':
                    $field_id    = 'product_attribute_color';
                    $field_value = isset( $_POST['tag-color'] ) ? sanitize_text_field( wp_unslash( $_POST['tag-color'] ) ) : '';
                    break;
    
                case 'select':

                    break;
    
                case 'image':
                    $field_id    = 'product_attribute_image';
                    $field_value = isset( $_POST['tag-image'] ) ? absint( $_POST['tag-image'] ) : '';
                    break;
            }
        }

        if( $field_id ) {
            update_term_meta( $term_id, $field_id, $field_value );
        }
    }

    public function variation_attribute_options_html( $html, $args ) {
        $select_html = $html;

        $args = wp_parse_args(
			apply_filters( 'botiga_dropdown_variation_attribute_options_args', $args ),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => __( 'Choose an option', 'botiga' ),
			)
		);

		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key = 'attribute_' . sanitize_title( $args['attribute'] );
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
        
		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

        $tax = $this->get_the_term_handled( $attribute );
        
        if( ! $tax ) {
            return $html;
        }

        $attribute_type = $tax->attribute_type;

        if( 'select' === $attribute_type ) {
            return $html;
        }

		$html  = '<div class="botiga-variations-wrapper" data-type="'. esc_attr( $attribute_type ) .'">';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);

                $html .= '<div class="botiga-variation-type-'. esc_attr( $attribute_type ) .'">';

                    if( 'color' === $attribute_type ) {
                        foreach ( $terms as $term ) {
                            $color_code = get_term_meta( $term->term_id, 'product_attribute_color', true );
        
                            if ( in_array( $term->slug, $options, true ) ) {
                                $html .= '<a href="#" role="button" class="botiga-variation-item" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . ' data-color="'. esc_attr( $color_code ) .'" style="background-color: '. $color_code .';">'. esc_html( $term->name ) .'</a>';
                            }
                        }
                    }

                    if( 'button' === $attribute_type ) {
                        foreach ( $terms as $term ) {
                            if ( in_array( $term->slug, $options, true ) ) {
                                $html .= '<a href="#" role="button" class="botiga-variation-item" value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>'. esc_html( $term->name ) .'</a>';
                            }
                        }
                    }

                $html .= '</div>';
			}
		}
            $html .= $select_html;
		$html .= '</div>';

        return $html;
    }
}

new Botiga_Product_Swatch();