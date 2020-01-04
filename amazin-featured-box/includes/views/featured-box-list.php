<?php
defined( 'ABSPATH' ) OR exit;
?>

<div class="wrap">
    <h2><?php _e( 'Amazin\' Featured Boxes', 'afb' ); ?> <a href="<?php echo admin_url( 'admin.php?page=amazinFeaturedBox&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'afb' ); ?></a></h2>
    <div class="notice notice-info not-dismissible">
        <p><strong>Welcome!</strong><br>This is your list of featured article boxes. Here you can create, edit, and manage your featured article boxes. Copy and paste a shortcode into the editor to embed a featured article box to your post.</p>
    </div>
    <form method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>  <!-- value="ttest_list_table">-->

        <?php
        $list_table = new Amazin_Featured_Box_List_Table();
        $list_table->prepare_items();

        $message = '';
        if ('delete' === $list_table->current_action()) {
            $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Featured Boxes deleted: %d', 'afb'), count($_REQUEST['id'])) . '</p></div>';
        }
        echo $message;

        $list_table->display();
        ?>
    </form>

    <!-- global plugin options -->
    <form method="post" action="options.php">
        <?php

            $options = settings_fields( 'amazin_featured_box_options_group' );
            $newTab = get_option('amazin_featured_box_option_new_tab') ? 'checked' : ''; //$options['amazin_featured_box_new_tab'];
            $byLabel = get_option( 'amazin_featured_box_option_by_label' );
            $displayPostDate = get_option('amazin_featured_box_option_display_post_date') ? 'checked' : '';
            $displayPostAuthor = get_option('amazin_featured_box_option_display_post_author') ? 'checked' : ''; 
        ?>
        <h3>Featured box settings</h3>
        <p>These settings are shared by all featured article boxes on your site.</p>
        <table class="form-table">
            <tbody>
                <!-- Label above header -->
                <tr>
                    <th scope="row">
                        <label for="amazin_featured_box_option_label">Featured Box Label</label>
                    </th>
                    <td>
                        <input type="text" id="amazin_featured_box_option_label" name="amazin_featured_box_option_label" value="<?php echo get_option('amazin_featured_box_option_label'); ?>" />
                        <br/>
                        <span class="description"><?php _e('Examples: "Related Content", "Read more about TOPIC", "Our Analysis", etc.', 'afb' ); ?></span>
                    </td>
                </tr>
                <!-- Open link in new tab -->
                <tr>
                    <th scope="row">
                        <label for="amazin_featured_box_option_new_tab">Open link in new tab</label>
                    </th>
                    <td>
                        <input type="checkbox" id="amazin_featured_box_option_new_tab" name="amazin_featured_box_option_new_tab" value="newTab" <?php checked( 'newTab', get_option('amazin_featured_box_option_new_tab') ); ?> />
                        <br/>
                        <span class="description"><?php _e('The featured post link should open in a new browser tab', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- What to put before author's name, if anything ("By") -->
                <tr>
                    <th scope="row">
                        <label for="amazin_featured_box_by_label">Author biline label (default "By")</label>
                    </th>
                    <td>
                        <input type="text" id="amazin_featured_box_option_by_label" name="amazin_featured_box_option_by_label" value="<?php echo get_option('amazin_featured_box_option_by_label'); ?>" />
                        <br/>
                        <span class="description"><?php _e('Examples: "By", "Author:", or leave blank', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Show the featured post's author -->
                <tr>
                    <th scope="row">
                        <label for="amazin_featured_box_option_display_post_author">Display the featured post's author</label>
                    </th>
                    <td>
                        <input type="checkbox" id="amazin_featured_box_option_display_post_author" name="amazin_featured_box_option_display_post_author" value="displayPostAuthor" <?php checked( 'displayPostAuthor', get_option('amazin_featured_box_option_display_post_author') ); ?> />
                        <br/>
                        <span class="description"><?php _e('Display the featured post\'s author', 'afb' ); ?></span>
                    </td>
                </tr>

                <!-- Show the featured post's date -->
                <tr>
                    <th scope="row">
                        <label for="amazin_featured_box_option_display_post_date">Display the featured post's date</label>
                    </th>
                    <td>
                        <input type="checkbox" id="amazin_featured_box_option_display_post_date" name="amazin_featured_box_option_display_post_date" value="displayPostDate" <?php checked( 'displayPostDate', get_option('amazin_featured_box_option_display_post_date') ); ?> />
                        <br/>
                        <span class="description"><?php _e('Display the featured post\'s date', 'afb' ); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
