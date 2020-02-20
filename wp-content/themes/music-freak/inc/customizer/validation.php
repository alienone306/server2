<?php
/**
* Customizer validation functions
*
* @package Theme Palace
* @subpackage Music Freak
* @since Music Freak 1.0.0
*/

if ( ! function_exists( 'music_freak_validate_long_excerpt' ) ) :
  function music_freak_validate_long_excerpt( $validity, $value ){
         $value = intval( $value );
     if ( empty( $value ) || ! is_numeric( $value ) ) {
         $validity->add( 'required', esc_html__( 'You must supply a valid number.', 'music-freak' ) );
     } elseif ( $value < 5 ) {
         $validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 5', 'music-freak' ) );
     } elseif ( $value > 100 ) {
         $validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'music-freak' ) );
     }
     return $validity;
  }
endif;
