<?php
defined( 'ABSPATH' ) OR exit;

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Amazin_Featured_Box_List_Table extends WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'featured_box',
            'plural'   => 'featured_boxes',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No Featured Boxes exist!', 'afb' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'name':
                return 'Name here'; //$item->post_title;

            case 'shortcode':
                return '[amazin-featured-box id="'.$item->ID.'"]';

            case 'author':
                return get_the_author_meta( 'display_name', $item->post_author );;

            case 'last_modified':
                return $item->post_date;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'name'      => __( 'Featured Article Name', 'afb' ),
            'shortcode'      => __( 'Shortcode', 'afb' ),
            'author'      => __( 'Author', 'afb' ),
            'last_modified'      => __( 'Last Modified', 'afb' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_name($item){
        $item_json = json_decode(json_encode($item), true);
        $content = json_decode($item_json['post_content'], true);
        $featuredPostID = $content['featuredPostID']; //ex: 1852

        $label = empty($content['customLabel']) ? get_option('amazin_featured_box_option_label') : $content['customLabel'];
        $featuredTagline = empty($content['featuredTagline']) ? 'NO TAGLINE' : $content['featuredTagline'];
        // if custom name is empty, use the post's title. Else, use the custom name. 
        $title = empty($content['customName']) ? get_the_title( $featuredPostID ) : $content['customName'];
        $postAuthorID = get_post_field( 'post_author', $featuredPostID );
        $postAuthorName = get_the_author_meta( 'display_name', $postAuthorID );

        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item_json['ID']),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item_json['ID']),
        );
        return sprintf('%s<br><b>%s</b><br>%s<br>By %s %s', $label, $title, $featuredTagline, $postAuthorName, $this->row_actions($actions));
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'post_title', true )
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'delete'  => __( 'Delete', 'afb' ),
        );
        return $actions;
    }

    function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();

        switch ( $action ) {
            case 'delete':
                if ('delete' === $this->current_action()) {
                    $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
                    if (!is_array($ids)) $ids = array($_REQUEST['id']);

                    afb_delete_featured_boxes($ids); //expects an array
                }
                break;

            default:
                return;
                break;
        }


    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */

    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item->ID
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=amazinFeaturedBox' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        $bulk_selected = array();

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        // process bulk actions if any
        $this->process_bulk_action();

        // now get all the items (minus any deleted ones from prior step)
        $this->items  = afb_get_all_featured_boxes( $args );

        $this->set_pagination_args( array(
            'total_items' => afb_get_featured_box_count(),
            'per_page'    => $per_page
        ) );
    }
}
