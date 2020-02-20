<?php
/**
 * The header for our theme
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */ 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="outer-wrap" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'skywp' ); ?></a>

		<div id="wrap" class="outer-wrapper">

			<?php do_action( 'skywp_custom_header' ); ?>

			<?php do_action( 'skywp_topbar' ); ?>

			<?php do_action( 'skywp_header' ) ?>

			<div id="content" class="site-content">

			<?php get_template_part( 'template-parts/subheader' ); ?>



