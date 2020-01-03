<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h1><?php _e( 'Edit Featured Box', 'afb' ); ?></h1>

    <?php
    $item = afb_get_featured_box( $_GET['id'] );
    $content = json_decode($item->post_content, true);
    $phURL = esc_url( plugins_url('ph.png', __FILE__ ) ) ;

    $image = esc_attr( wp_get_attachment_url( $content['featuredImage'] ) );

    if (!$image) {
        $image = $phURL;
    }

    ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>

                <tr class="row-featuredName">
                    <th scope="row">
                        <label for="Featured-Name"><?php _e( 'Featured name', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Featured-Name" id="Featured-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $item->post_title ); ?>" required="required" />
                        <br/>
                        <span class="description"><?php _e('Featured name, model, etc.', 'afb' ); ?></span>
                    </td>
                </tr>

                <tr class="row-Featured-Image">
                    <th scope="row">
                        <label for="Featured-Name"><?php _e( 'Featured image', 'afb' ); ?></label>
                    </th>
                    <td>
                        <div class="upload">
                            <img data-src="<?php echo $phURL ?>" src="<?php echo $image; ?>" width="120px" height="120px" />
                            <div>
                                <input type="hidden" name="Featured-Image" id="Featured-Image" value="<?php echo $content['featuredImage'] ?>" />
                                <button type="submit" class="upload_image_button button"><?php _e( 'Upload/Choose', 'afb' ); ?></button>
                                <button type="submit" class="remove_image_button button"><?php _e( 'Clear', 'afb' ); ?></button>
                                <br/>
                                <span class="description"><?php _e('Choose an image that is large (at least 1000x1000 pixels) and square', 'afb' ); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="row-tagline">
                    <th scope="row">
                        <label for="Tagline"><?php _e( 'Tagline', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Tagline" id="Tagline" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $content['featuredTagline'] ); ?>" required="required" />
                        <br/>
                        <span class="description"><?php _e('A tagline is short and memorable (3-6 words)', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="Description"><?php _e( 'Description', 'afb' ); ?></label>
                    </th>
                    <td>
                        <textarea name="Description" id="Description"placeholder="<?php echo esc_attr( '', 'afb' ); ?>" rows="6" cols="46" required="required"><?php echo esc_textarea( $content['featuredDescription'] ); ?></textarea>
                        <br/>
                        <span class="description"><?php _e('Write about 20-30 words (~200 characters) enticing your visitor to choose this featured post', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-URL">
                    <th scope="row">
                        <label for="URL"><?php _e( 'URL', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="URL" id="URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $content['featuredUrl'] ); ?>" required="required" />
                        <br/>
                        <span class="description"><?php _e('Featured affiliate link, including https://', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-buttonText">
                    <th scope="row">
                        <label for="Button-Text"><?php _e( 'Button text', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Button-Text" id="Button-Text" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $content['featuredButtonText'] ); ?>" required="required" />
                        <br/>
                        <span class="description"><?php _e('Complete text as it should appear on the button', 'afb' ); ?></span>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->ID; ?>">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Update Featured Box', 'afb' ), 'primary', 'submit_featured_box' ); ?>

    </form>
</div>
