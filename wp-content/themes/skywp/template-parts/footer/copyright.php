<?php
/**
 * Layout template Copyright
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

?>

<div id="copyright">

	<div class="wrapper">

		<div class="container widget-area">
			<div class="column">
				<?php dynamic_sidebar('copyright-1'); ?>
			</div>

			<?php do_action( 'skywp_copyright_template' ); ?>
		</div>

	</div>

</div><!-- #copyright -->