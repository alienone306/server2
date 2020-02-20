<?php
/**
 * The template for displaying search forms
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

<form method="get" class="searchform" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	
	<input type="text" class="field" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', 'skywp' ); ?>">

</form>