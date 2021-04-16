<?php


class ContactsCpt
{
    private static $instance = null;


    public static  function  getInstance(){
        if(self::$instance === null){
            self::$instance = new ContactsCpt();
        }
        return self::$instance;
    }
    public function init(){
        add_action('init', array($this,'registerContacts' ));
        add_action('after_switch_theme', array($this,'my_rewrite_flush'));
    }
    public function registerContacts(){
        $singular = __( 'Contact' );
        $plural = __( 'Contacts' );
        //Used for the rewrite slug below.
        $plural_slug = str_replace( ' ', '_', $plural );

        //Setup all the labels to accurately reflect this post type.
        $labels = array(
            'name' 					=> $plural,
            'singular_name' 		=> $singular,
            'add_new' 				=> 'Add New',
            'add_new_item' 			=> 'Add New ' . $singular,
            'edit'		        	=> 'Edit',
            'edit_item'	        	=> 'Edit ' . $singular,
            'new_item'	        	=> 'New ' . $singular,
            'view' 					=> 'Show ' . $singular,
            'view_item' 			=> 'Show ' . $singular,
            'search_term'   		=> 'Search ' . $plural,
            'parent' 				=> 'Parent ' . $singular,
            'not_found' 			=> 'No ' . $plural .' found',
            'not_found_in_trash' 	=> 'No ' . $plural .' in Trash'
        );

        //Define all the arguments for this post type.
        $args = array(
            'labels' 			  => $labels,
            'public'              => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'show_in_nav_menus'   => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 7,
            'menu_icon'           => 'dashicons-admin-users',
            'can_export'          => true,
            'delete_with_user'    => false,
            'hierarchical'        => false,
            'has_archive'         => true,
            'query_var'           => true,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            // 'capabilities' => array(),
            'taxonomies'  => array( 'category' ),
            'rewrite'             => array(
                'slug' => strtolower( $plural_slug ),
                'with_front' => true,
                'pages' => true,
                'feeds' => false,

            ),
            'supports'            => array(
                'title','thumbnail',
            )
        );

        //Create the post type using the above two varaiables.
        register_post_type( 'contact', $args);
    }
    function my_rewrite_flush() {
        // First, we "add" the custom post type via the above written function.
        // Note: "add" is written with quotes, as CPTs don't get added to the DB,
        // They are only referenced in the post_type column with a post entry,
        // when you add a post of this CPT.
        $this->registerContacts();

        // ATTENTION: This is *only* done during plugin activation hook in this example!
        // You should *NEVER EVER* do this on every page load!!
        flush_rewrite_rules();
    }
}
$register_tips = ContactsCpt::getInstance();
$register_tips->init();