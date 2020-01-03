<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h1><?php _e( 'Add new Product Box', 'apb' ); ?></h1>

    <form action="" method="post">

        <?php
            $default_image = '';
            $phURL = esc_url( plugins_url('ph.png', __FILE__ ) ) ;
        ?>

        <table class="form-table">
            <tbody>

                <tr class="row-productName">
                    <th scope="row">
                        <label for="Product-Name"><?php _e( 'Product name', 'apb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Product-Name" id="Product-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'apb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Product name, model, etc.', 'apb' ); ?></span>
                    </td>
                </tr>

                <tr class="row-Product-Image">
                    <th scope="row">
                        <label for="Product-Name"><?php _e( 'Product image', 'apb' ); ?></label>
                    </th>
                    <td>
                        <div class="upload">
                            <img data-src="<?php echo $phURL ?>" src="<?php echo $phURL ?>" width="120px" height="120px" />
                            <div>
                                <input type="hidden" name="Product-Image" id="Product-Image" value="" />
                                <button type="submit" class="upload_image_button button"><?php _e( 'Upload/Choose', 'apb' ); ?></button>
                                <button type="submit" class="remove_image_button button"><?php _e( 'Clear', 'apb' ); ?></button>
                                <br/>
                                <span class="description"><?php _e('Choose an image that is large (at least 1000x1000 pixels) and square', 'apb' ); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="row-tagline">
                    <th scope="row">
                        <label for="Tagline"><?php _e( 'Tagline', 'apb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Tagline" id="Tagline" class="regular-text" placeholder="<?php echo esc_attr( '', 'apb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('A tagline is short and memorable (3-6 words)', 'apb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="Description"><?php _e( 'Description', 'apb' ); ?></label>
                    </th>
                    <td>
                        <textarea name="Description" id="Description"placeholder="<?php echo esc_attr( '', 'apb' ); ?>" rows="6" cols="46" required="required"></textarea>
                        <br/>
                        <span class="description"><?php _e('Write about 20-30 words (~200 characters) enticing your visitor to choose this product', 'apb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-URL">
                    <th scope="row">
                        <label for="URL"><?php _e( 'URL', 'apb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="URL" id="URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'apb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Product affiliate link, including https://', 'apb' ); ?></span>
                    </td>
                </tr>
                <tr class="row-buttonText">
                    <th scope="row">
                        <label for="Button-Text"><?php _e( 'Button text', 'apb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Button-Text" id="Button-Text" class="regular-text" placeholder="<?php echo esc_attr( '', 'apb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Complete text as it should appear on the button', 'apb' ); ?></span>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add new Product Box', 'apb' ), 'primary', 'submit_product_box' ); ?>

    </form>
</div>
