<?php
/**
 * Function for customizer field's value sanitization.
 * 
 * @package Perfectwpthemes_Toolkit
 */


/**
 * Sanitization function for number field whose value is in range.
 */
if ( ! function_exists( 'perfectwpthemes_toolkit_sanitize_range' ) ) {

    function perfectwpthemes_toolkit_sanitize_range( $input, $setting ) {

        if(  $input <= $setting->manager->get_control( $setting->id )->input_attrs['max'] ) {

            if( $input >= $setting->manager->get_control( $setting->id )->input_attrs['min'] ) {

                return absint( $input );
            }
        }
    }
}


/**
 * Sanitization function for number field's value.
 */
if ( ! function_exists( 'perfectwpthemes_toolkit_sanitize_number' ) ) {

    function perfectwpthemes_toolkit_sanitize_number( $input, $setting ) {

        return (int)$input;
    }
}


/**
 * Sanitization function for select field.
 */
if ( !function_exists('perfectwpthemes_toolkit_sanitize_select') ) {

    function perfectwpthemes_toolkit_sanitize_select( $input, $setting ) {

        $input = sanitize_key( $input );
        
        $choices = $setting->manager->get_control( $setting->id )->choices;
        
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }
}


/**
 * Sanitization function for multiple select.
 */
if( !function_exists( 'perfectwpthemes_toolkit_sanitize_multiple_select' ) ) {

    function perfectwpthemes_toolkit_sanitize_multiple_select( $input, $setting ) {

        if( !empty( $input ) ) {

            $input = array_map( 'sanitize_text_field', $input );
        }

        return $input;
    } 
}

/**
 * Sanitization function for repeater field.
 */
if( ! function_exists( 'perfectwpthemes_toolkit_repeater_sanitize' ) ) {

    function perfectwpthemes_toolkit_repeater_sanitize( $input, $setting ){

        $input_decoded = json_decode( $input, true );

        $allowed_html = array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'a' => array(
                'href' => array(),
                'class' => array(),
                'id' => array(),
                'target' => array()
            ),
            'button' => array(
                'class' => array(),
                'id' => array()
            )
        );        
        
        if( !empty( $input_decoded ) ) {

            foreach( $input_decoded as $boxes => $box ) {

                foreach( $box as $key => $value ) {
                    
                    $input_decoded[$boxes][$key] = sanitize_text_field( $value );
                }
            }
            return json_encode( $input_decoded );
        }        
        return $input;
    }
}