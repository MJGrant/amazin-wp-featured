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
                <!-- Pick URL of article or page to be featured -->
                 <tr class="row-URL">
                    <th scope="row">
                        <label for="Featured-URL"><?php _e( 'Featured article URL', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Featured-URL" id="Featured-URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" required="required" />
                        <br/>
                        <span class="description"><?php _e('Link to the featured post or page', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Label such as "Editor's Choice" or "Related" -->
                <tr class="row-customLabel">
                    <th scope="row">
                        <label for="Custom-Label"><?php _e( 'Custom label', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Custom-Label" id="Custom-Label" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Label, such as "Editor\'s Choice". Leave blank to use site-wide plugin default.', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Enter a name or leave blank to use the article's name -->
                <tr class="row-customName">
                    <th scope="row">
                        <label for="Custom-Name"><?php _e( 'Featured article name', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Custom-Name" id="Custom-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value=""/>
                        <br/>
                        <span class="description"><?php _e('Leave blank to use the post or page\'s title', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Tagline for the article, should be short -->
                <tr class="row-tagline">
                    <th scope="row">
                        <label for="Tagline"><?php _e( 'Tagline', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Tagline" id="Tagline" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="" />
                        <br/>
                        <span class="description"><?php _e('Entice users to click over to this article (or leave blank to have no tagline at all)', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Upload a featured image or leave blank to use the article's own featured image -->
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
                                <span class="description"><?php _e('Leave blank to use the featured image already associated with this post or page', 'afb' ); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>

            
                <!-- Button below image -->
                <tr class="row-buttonText">
                    <th scope="row">
                        <label for="Button-Text"><?php _e( 'Button text', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Button-Text" id="Button-Text" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value=""/>
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
