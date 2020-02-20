<?php

/**
 * Add admin notice when active theme, just show one time
 *
 * @return bool|null
 */
if( ! function_exists( 'perfectwpthemes_toolkit_admin_notice' ) ) {

    function perfectwpthemes_toolkit_admin_notice() {

        global $current_user;

        $user_id = $current_user->ID;

        $theme = perfectwpthemes_toolkit_theme();

        $admin_url = 'themes.php?page=' . esc_html( $theme->get( 'TextDomain' ) ) . '-about';
        
        if ( !get_user_meta( $user_id, esc_html( $theme->get( 'TextDomain' ) ) . '_notice_ignore' ) ) {
            ?>
            <div class="notice perfectwpthemes-toolkit-notice">

                <h1>
                    <?php
                    /* translators: %1$s: theme name, %2$s theme version */
                    printf( esc_html__( 'Welcome to %1$s - Version %2$s', 'perfectwpthemes-toolkit' ), esc_html( $theme->Name ), esc_html( $theme->Version ) );
                    ?>
                </h1>

                <p>
                    <?php
                    /* translators: %1$s: theme name, %2$s link */
                    printf( __( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'perfectwpthemes-toolkit' ), esc_html( $theme->Name ), esc_url( admin_url( $admin_url ) ) );
                    printf( '<a href="%1$s" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>', '?' . esc_html( $theme->get( 'TextDomain' ) ) . '_notice_ignore=0' );
                    ?>
                </p>
                <p>
                    <a href="<?php echo esc_url( admin_url( $admin_url ) ); ?>" class="button button-primary button-hero" style="text-decoration: none;">
                        <?php
                        /* translators: %s theme name */
                        printf( esc_html__( 'Get started with %s', 'perfectwpthemes-toolkit' ), esc_html( $theme->Name ) )
                        ?>
                    </a>
                </p>
            </div>
            <?php
        }
    }
}


if( !function_exists( 'perfectwpthemes_toolkit_notice_ignore' ) ) {

    function perfectwpthemes_toolkit_notice_ignore() {

        global $current_user;

        $theme  = wp_get_theme();

        $user_id     = $current_user->ID;

        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset( $_GET[ esc_html( $theme->get( 'TextDomain' ) ) . '_notice_ignore' ] ) && '0' == $_GET[ esc_html( $theme->get( 'TextDomain' ) ) . '_notice_ignore' ] ) {

            add_user_meta( $user_id, esc_html( $theme->get( 'TextDomain' ) ) . '_notice_ignore', 'true', true );
        }
    }
}