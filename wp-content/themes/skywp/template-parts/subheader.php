<?php
/**
 * Template part for displaying page content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.3
 */

?>
<?php if ( ( is_archive() || is_single() || is_page() || is_404() || is_search() || is_home() ) && !is_page_template( 'template-parts/full-width-page.php' ) && !is_attachment() ) { ?>
<div id="site-subheader">

	<div class="wrapper">

		<div class="content">

			<?php
			if ( is_archive() ) {
				add_filter( 'get_the_archive_title', function( $title ){
					return preg_replace('~^[^:]+: ~', '', $title );
				});
				?>

				<ul>
					<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

					<li><a href="<?php echo esc_url( get_category_link( get_queried_object_id() ) ); ?>"><?php the_archive_title() ?></a></li>
				</ul>
				<?php
			}

			else if ( is_single() ) {
				if ( !is_attachment() ) { ?>
					<ul>
						<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

						<?php if ( get_the_category( $post->ID ) ) : ?>

						<li><a href="<?php $skywp_category = get_the_category(); $skywp_cat = $skywp_category[0]; $skywp_id = $skywp_cat->cat_ID; $skywp_name = $skywp_cat->cat_name; $skywp_link = get_category_link( $skywp_id );  echo esc_url( $skywp_link ); ?>"><?php $skywp_cat = get_the_category( $post->ID ); echo esc_html( $skywp_name ); ?></a><i class="fas fa-chevron-right arrows-right"></i></li>

						<?php endif; ?>

						<li><?php single_post_title(); ?></li>
					</ul>
				<?php } else { ?>
					<h1><?php single_post_title(); ?></h1>

					<ul>
						<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

						<li><?php single_post_title(); ?></li>
					</ul>
				<?php } ?>

				
				<?php
			}

			else if ( is_page() ) {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

					<li><?php single_post_title(); ?></li>
				</ul>
				<?php
			}

			else if ( is_404() ) {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

					<li><?php esc_html_e( '404 Not Found', 'skywp' ); ?></li>
				</ul>
				<?php
			}

			else if ( is_search() ) {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a><i class="fas fa-chevron-right arrows-right"></i></li>

					<li><?php esc_html_e( 'Search results for', 'skywp' ); ?> "<?php echo get_search_query(); ?>"</li>
				</ul>
				<?php
			}

			// Homepage - displays your latest posts if not a static page
			else if ( is_front_page() && ! is_singular( 'page' ) ) {
				?><h1><?php 
					echo esc_html( get_bloginfo( 'name' ) );
				?></h1>
				<?php
			}

			// Homepage - if a static page
			else if ( is_home() && ! is_singular( 'page' ) ) {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url() ); ?>"><i class="fas fa-home"></i></a></li>

					<li><i class="fas fa-chevron-right arrows-right"></i><?php echo esc_html( get_the_title( get_option( 'page_for_posts', true ) ) ); ?></li>
				</ul>
				<?php
			}
			?>
			
		</div><!-- .content -->
		
	</div><!-- .wrapper -->
	
</div>
<?php } ?>















