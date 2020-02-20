<?php
/**
 * The template for displaying comments
 *
 * @package Urchenko Technologies
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$skywp_comment_count = get_comments_number();
			if ( '1' === $skywp_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'skywp' ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $skywp_comment_count, 'comments title', 'skywp' ) ),
					esc_html( number_format_i18n( $skywp_comment_count ) ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'             => 'ol',
				'reply_text'        => 'Reply',
				'avatar_size'       => 55,
				'format'            => 'html5',
				'short_ping'        => true,
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'skywp' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	$req      = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5';
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$commenter = wp_get_current_commenter();
	comment_form( array(
		'fields'	=> array(
			'author' => '<div class="comment-wrap"><p class="comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __( 'Name (required)', 'skywp' ) . '" size="30"' . $aria_req . $html_req . ' /></p>',

			'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (required)', 'skywp' ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',

			'url'    => '<p class="comment-form-url">' .
			'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website', 'skywp' ) . '" size="30" /></p></div>',
		),
		'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" required="required" placeholder="' . __( 'Comment...', 'skywp' ) . '"></textarea></p>',
		'title_reply'          => __( 'Leave a Comment', 'skywp' ),
		'title_reply_to'       => __( 'Leave a Comment to %s', 'skywp' ),
		'comment_notes_before' => '',
	) );
	?>

</div><!-- #comments -->
