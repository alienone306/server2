<?php
/**
* Header logo
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

<div id="site-logo" class="clr">

	<?php if ( has_custom_logo() ) { ?>
		<div id="site-logo-inner" class="clr">
			<?php the_custom_logo() ?>
		</div><!-- #site-logo-inner -->
	<?php } ?>

	<?php if ( display_header_text() ) { ?>
		<div class="branding-text">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>

			<p class="site-description"><?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?></p>
		</div><!-- .branding-text -->
	<?php } ?>
	
</div><!-- #site-logo -->