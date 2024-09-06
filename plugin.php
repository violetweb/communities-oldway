<?php
/*
 * Plugin Name: Moomore Communities Plugin
 * Plugin URI: https://www.moomore.ca/moomore-communities/
 * Description: A plugin that enables the management of new home builders communities.
 * Author: Valerie Trotter
 * Version: 0.1
 * Author URI: https://moomore.ca
 * License: GPL2+
 */


if ( ! defined( 'WPINC' ) ) {
    die( 'No direct access.' );
}

define( 'MOO_COM_MINIMUM_WP_VERSION', '6.2' );
define( 'MOO_COM_VERSION',            '0.1' );
define( 'MOO_COM_PLUGIN_DIR',         plugin_dir_path( __FILE__ ) );
define( 'MOO_COM_PLUGIN_URL',         plugin_dir_url( __FILE__ ) );
define( 'MOO_COM_PLUGIN_FILE',        __FILE__ );
define( 'MOO_COM_TITLE', 'Communities Plugin for New Home Builders');

// Main Class
if (!class_exists('MooCommunities')) {
    class MooCommunities {


        protected static $_instance = null;

        public static function getInstance()
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct()
        {
            $this->includes();
            $this->init_hooks();


        }

        private function init() {           
        
                
            add_action( 'save_post', 'save_communities_meta'); 
            add_action( 'add_meta_boxes', 'register_communities_meta_boxes' );
            add_action( 'init', 'register_communities_taxonomies' );         
            add_action( 'after_switch_theme', array( $this, 'activate' ) );
                        
            /** ADMIN / front end SECTION **/    
            add_action( 'admin_enqueue_scripts', array($this,'load_admin_script') );    
            add_action( 'wp_enqueue_scripts', array($this,'wpb_add_google_fonts') );
            
        
        
        }
        private function init_hooks()
        {


            register_activation_hook(__FILE__, array($this, 'activate'));
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        }

       
        function fnctn_add_thickbox () {
            add_thickbox();
        }
    
        function wpb_add_google_fonts() {   
            wp_enqueue_style( 'wpb-google-fonts-com', '//fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap', '',null ); 
        }

        private function includes()
        {
            include_once MOOMORE_PLUGIN_PATH . 'includes/cpt.php';

        }


        function enqueue_communities_template_styles() {

            if ( is_page_template( 'communities.php' ) ) {          
                wp_enqueue_style( 'communities-template.css', MOO_COM_PLUGIN_URL . 'includes/assets/communities.css', '', MOO_VERSION );                    
            }
        }

    
        function load_admin_script(){       
            wp_enqueue_script('admin-scripts', MOO_COM_PLUGIN_URL . 'includes/assets/admin.js', array(), '',false);  
            wp_enqueue_media();
            add_thickbox();
        }
    
        function activate() {           
            flush_rewrite_rules();
        }

        function deactivate() {
            flush_rewrite_rules();
        }
        

    }
}

$MooCommunities = MooProducts::getInstance();
$MooCommunities->init();
