<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h2><?php _e( 'Amazin\' Product Boxes', 'apb' ); ?> <a href="<?php echo admin_url( 'admin.php?page=amazinProductBox&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'apb' ); ?></a></h2>
    <div class="notice notice-info not-dismissible">
        <p><strong>Welcome!</strong><br>This is your list of product boxes. Here you can create, edit, and manage your product boxes. Copy and paste a shortcode into the editor to add a product box to your post.</p>
    </div>
    <form method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>  <!-- value="ttest_list_table">-->

        <?php
        $list_table = new Amazin_Product_Box_List_Table();
        $list_table->prepare_items();

        $message = '';
        if ('delete' === $list_table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Product Boxes deleted: %d', 'apb'), count($_REQUEST['id'])) . '</p></div>';
        }
        echo $message;

        $list_table->display();
        ?>
    </form>

    <form method="post" action="options.php">
        <?php

            $options = settings_fields( 'amazin_product_box_options_group' );
            $newTab = get_option('amazin_product_box_option_new_tab') ? 'checked' : ''; //$options['amazin_product_box_new_tab'];
        ?>
        <h3>Product box settings</h3>
        <p>These settings are shared by all product boxes on your site.</p>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="amazin_product_box_option_headline">Product Box headline</label>
                    </th>
                    <td>
                        <input type="text" id="amazin_product_box_option_headline" name="amazin_product_box_option_headline" value="<?php echo get_option('amazin_product_box_option_headline'); ?>" />
                        <br/>
                        <span class="description"><?php _e('Examples: "We recommend", "Our pick", "A Sitename Favorite", etc.', 'apb' ); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="amazin_product_box_option_new_tab">Open link in new tab</label>
                    </th>
                    <td>
                        <input type="checkbox" id="amazin_product_box_option_new_tab" name="amazin_product_box_option_new_tab" value="newTab" <?php checked( 'newTab', get_option('amazin_product_box_option_new_tab') ); ?> />
                        <br/>
                        <span class="description"><?php _e('The button link should open in a new browser tab', 'apb' ); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
