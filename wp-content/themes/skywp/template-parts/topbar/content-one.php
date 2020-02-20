<?php
/**
* Topbar layout
*
* @package Urchenko Technologies
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="top-bar-content-one" class="classes">
	<?php echo wp_kses_post( get_theme_mod( 'sky_topbar_content_textarea_one' ) ); ?>
</div><!-- top-bar-content-one -->