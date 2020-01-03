<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Amazin_Featured_Box_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the featured box new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit_featured_box'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Security check failed.', 'afb' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission denied!', 'afb' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=amazinFeaturedBox' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $field_featuredURL = isset( $_POST['Featured-URL'] ) ? sanitize_text_field( $_POST['Featured-URL'] ) : '';
        
        // get post ID from the URL provided (hopefully they provided one, else the error checking below will catch)
        $featuredPostID = isset( $_POST['Featured-URL'] ) ? url_to_postid(sanitize_text_field( $_POST['Featured-URL'] )) : '';

        // either use the custom label the user entered or enter blank to indicate the user wants to use the 'global' one
        $field_customLabel = isset( $_POST['Custom-Label'] ) ? sanitize_text_field( $_POST['Custom-Label'] ) : '';

        // either use the name the user entered or leave blank to indicate the post name should be retrieved when displaying the featured box 
        $field_customName = isset( $_POST['Custom-Name'] ) ? sanitize_text_field( $_POST['Custom-Name'] ) : '';

        // either use the custom tagline the user entered or leave it blank (and don't display it later on)
        $field_tagline = isset( $_POST['Tagline'] ) ? sanitize_text_field( $_POST['Tagline'] ) : '';

        // button text is optional 
        $field_buttonText = isset( $_POST['Button-Text'] ) ? sanitize_text_field( $_POST['Button-Text'] ) : '';

        // user can upload an image or use the one associated with the post by its ID 
        $field_featuredImage = isset( $_POST['Featured-Image'] ) ? sanitize_text_field( $_POST['Featured-Image'] ) : '';

        // some basic validation
        if ( ! $field_featuredURL ) {
            $errors[] = __( 'Error: URL is required', 'afb' );
        }
        if ( ! $featuredPostID ) {
            $errors[] = __( 'Error: URL could not be transformed into a post ID', 'afb' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $content = array(
            'featuredURL' => $field_featuredURL,
            'featuredPostID' => $field_featuredPostID,
            'customLabel' => $field_customLabel,
            'customName' => $field_customName,
            'featuredTagline' => $field_tagline,
            'featuredButtonText' => $field_buttonText,
            'featuredImage' => $field_featuredImage //ID of media attachment
        );

        $featured_box = array(
            'ID'            => $field_id,
            'post_title'    => $field_featuredName,
            'post_type'     => 'amazin_featured_box',
            'post_content'  => wp_json_encode($content, JSON_HEX_APOS), //broke when switched this from 'none' to the content array
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 8,39 )
        );

        // New or edit?
        if ( ! $field_id ) {
            $insert_id = afb_new_featured_box( $featured_box );
        } else {
            $insert_id = afb_update_featured_box( $featured_box );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Amazin_Featured_Box_Form_Handler();
