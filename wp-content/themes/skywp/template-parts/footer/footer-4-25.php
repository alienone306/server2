<?php
/**
 * Layout template footer four columns 25%
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.3
 */

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
?>
<div id="footer-wrapper">

	<div class="wrapper">

		<div class="footer-wrap">

			<div class="column">
				<?php dynamic_sidebar('footer-1'); ?>
			</div>

			<div class="column">
				<?php dynamic_sidebar('footer-2'); ?>
			</div>

			<div class="column">
				<?php dynamic_sidebar('footer-3'); ?>
			</div>

			<div class="column">
				<?php dynamic_sidebar('footer-4'); ?>
			</div>

		</div><!-- .footer-wrap -->

	</div><!-- .wrapper -->

</div><!-- #footer-wrapper -->
<?php endif; ?>