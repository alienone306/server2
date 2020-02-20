<?php
/**
* Header logo
*
* @package Urchenko
* @subpackage Kalina WordPress theme
* @since Kalina 1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="icom-search">
	<button type="button" class="menu_toggle_class">
		<i class="fas fa-search"></i>
	</button>
	<?php do_action( 'skywp_header_search' ); ?>
</div>