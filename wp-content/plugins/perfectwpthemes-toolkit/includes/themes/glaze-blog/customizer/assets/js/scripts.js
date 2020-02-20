(function( $ ) {

	wp.customize.bind( 'ready', function() {

		function customizer_label( id, title ) {

			if ( id === 'custom_logo' || id === 'site_icon' || id === 'background_image' || id === 'background_color' ) {
				$( '#customize-control-'+ id ).prepend('<p class="option-group-title customize-control"><strong>'+ title +'</strong></p>');
			} else {
				$( '#customize-control-'+ id ).prepend('<p class="option-group-title customize-control"><strong>'+ title +'</strong></p>');
			}
		}	

		customizer_label( 'glaze_blog_field_display_blog_social_share', 'Share On Pages' );
		customizer_label( 'glaze_blog_field_share_on_facebook', 'Share On Sites' );
	});
}) ( jQuery );