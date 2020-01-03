<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h1><?php _e( 'Add new Featured Article Box', 'afb' ); ?></h1>

    <form action="" method="post">

        <?php
            $default_image = '';
            $phURL = esc_url( plugins_url('ph.png', __FILE__ ) ) ;
        ?>

        <table class="form-table">
            <tbody>

                <tr class="row-featuredName">
                    <th scope="row">
                        <label for="Featured-Name"><?php _e( 'Featured name', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Featured-Name" id="Featured-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" required="required" />
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
                            <img data-src="<?php echo $phURL ?>" src="<?php echo $phURL ?>" width="120px" height="120px" />
                            <div>
                                <input type="hidden" name="Featured-Image" id="Featured-Image" value="" />
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
                        <input type="text" name="Tagline" id="Tagline" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('A tagline is short and memorable (3-6 words)', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="Description"><?php _e( 'Description', 'afb' ); ?></label>
                    </th>
                    <td>
                        <textarea name="Description" id="Description"placeholder="<?php echo esc_attr( '', 'afb' ); ?>" rows="6" cols="46" required="required"></textarea>
                        <br/>
                        <span class="description"><?php _e('Write about 20-30 words (~200 characters) enticing your visitor to continue on to this article', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-URL">
                    <th scope="row">
                        <label for="URL"><?php _e( 'URL', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="URL" id="URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Featured affiliate link, including https://', 'afb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-buttonText">
                    <th scope="row">
                        <label for="Button-Text"><?php _e( 'Button text', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Button-Text" id="Button-Text" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Complete text as it should appear on the button', 'afb' ); ?></span>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add new Featured Article Box', 'afb' ), 'primary', 'submit_featured_box' ); ?>

    </form>
</div>
