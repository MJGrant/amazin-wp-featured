<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h1><?php _e( 'Edit Featured Box', 'afb' ); ?></h1>

    <?php
    $item = afb_get_featured_box( $_GET['id'] );
    $content = json_decode($item->post_content, true);
    
    $featuredURL = $content['featuredURL']; // ex: https://www.url.com/post-id

    $featuredPostID = $content['featuredPostID']; //ex: 1852

    // use the custom name if one exists, else leave field blank 
    $title = $content['customName'] ? $content['customName'] : '';

    // use custom label if one exists, else leave field blank
    $customLabel = $content['customLabel'] ? $content['customLabel'] : '';

    // use custom tagline if one exists, else leave field blank
    $tagline = $content['featuredTagline'] ? $content['featuredTagline'] : '';

    $phURL = esc_url( plugins_url('ph.png', __FILE__ ) ) ;

    $image = esc_attr( wp_get_attachment_url( $content['featuredImage'] ) );

    if (!$image) {
        $image = $phURL;
    }

    ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>

                <!-- Edit the URL -->
                <tr class="row-URL">
                    <th scope="row">
                        <label for="Featured-URL"><?php _e( 'Featured article URL', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Featured-URL" id="Featured-URL" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $featuredURL ); ?>" required="required" />
                        <br/>
                        <span class="description"><?php _e('Link to the featured post or page (REQUIRED)', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Label such as "Editor's Choice" or "Related" -->
                <tr class="row-customLabel">
                    <th scope="row">
                        <label for="Custom-Label"><?php _e( 'Custom label', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Custom-Label" id="Custom-Label" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $customLabel ); ?>"/>
                        <br/>
                        <span class="description"><?php _e('Label, such as "Editor\'s Choice". Leave blank to use site-wide plugin default.', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Enter a name or leave blank to use the featured article's name -->
                <tr class="row-customName">
                    <th scope="row">
                        <label for="Custom-Name"><?php _e( 'Featured article name', 'afb' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="Custom-Name" id="Custom-Name" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
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
                        <input type="text" name="Tagline" id="Tagline" class="regular-text" placeholder="<?php echo esc_attr( '', 'afb' ); ?>" value="<?php echo esc_attr( $tagline ); ?>" />
                        <br/>
                        <span class="description"><?php _e('Entice users to click over to this article (or leave blank to have no tagline at all)', 'afb' ); ?></span>
                    </td>
                </tr>

                <tr class="row-Featured-Image">
                    <th scope="row">
                        <label for="Featured-Name"><?php _e( 'Custom featured image', 'afb' ); ?></label>
                    </th>
                    <td>
                        <div class="upload">
                            <img data-src="<?php echo $phURL ?>" src="<?php echo $image; ?>" width="120px" height="120px" />
                            <div>
                                <input type="hidden" name="Featured-Image" id="Featured-Image" value="<?php echo $content['featuredImage'] ?>" />
                                <button type="submit" class="upload_image_button button"><?php _e( 'Upload/Choose', 'afb' ); ?></button>
                                <button type="submit" class="remove_image_button button"><?php _e( 'Clear', 'afb' ); ?></button>
                                <br/>
                                <span class="description"><?php _e('Upload a large image or leave blank to use the post\'s featured image.', 'afb' ); ?></span>
                            </div>
                        </div>
                    </td>
                </tr>
                
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->ID; ?>">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Update Featured Box', 'afb' ), 'primary', 'submit_featured_box' ); ?>

    </form>
</div>
