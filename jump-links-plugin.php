<?php
/**
 * @package JJP_ShareCSV_Plugin
 * @version 1
 */
/*
	Plugin Name: Jump Links (JJP)
	Plugin URI: http://apps.omorphos.com/share-csv
	Description: share-csv
	Author: John Proestakes
	Version: 1
	Author URI: http://johnproestakes.com/
*/

	//if (session_status() !== PHP_SESSION_ACTIVE) { session_start();}



	class JJP_JumpLinks_Plugin {

		public $guid_pattern = "a#xxxxxx";

		public function activation_hook(){
			require "scripts/php/table-setup.php";
		}

		public function generate_guid($str){
	    $alph = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
	    $a = str_split($str);
	    $output = "";
	    foreach($a as $k => $char){
	      switch($char){
	        case "a":
	          $output .= $alph[rand(0,count($alph))];
	        break;
	        case "#":
	          $output .= rand(0,9);
	        break;
	        case "x":
	          if(!rand(0,1)){
	            $output .= $alph[rand(0,count($alph))];
	          } else {
	            $output .= rand(0,9);
	          }
	        break;

	      }
	    }
	    return $output;
	  }


		public function render_plugin_page(){
			$plugins_url = plugins_url('/',__FILE__);
			include "scripts/php/plugin-page.php";
		}
		public function render_meta_box(){
			$plugin_url = plugins_url('/', __FILE__);
			global $post;
			include "scripts/php/meta-box.php";
		}
		public function create_meta_box(){
			add_meta_box( 'jump-links-jjp-create', __( 'Create Jump Link', 'jumplinks' ), array($this, 'render_meta_box'), 'post' );
		}

		public function create_plugin_page(){
			add_management_page('Jump Links', 'Jump Links', 'read', 'jump-links-jjp', array($this, 'render_plugin_page'), 'dashicons-cloud');
				//add_action( 'admin_init', array($this, 'register_settings') );

				if(is_admin() && isset($_GET['page']) && $_GET['page']=="jump-links-jjp"){
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_style('thickbox');
					wp_enqueue_script('jquery');

					}
		}

		function __construct(){
			if(is_admin()){
				add_action( 'add_meta_boxes', array($this, 'create_meta_box') );
				add_action('admin_menu', array($this, "create_plugin_page"));
			}
			register_activation_hook( __FILE__, array($this, 'activation_hook') );
			}
		}

if(defined('DOING_AJAX') && DOING_AJAX){

	require "scripts/php/traits/ajax.php";
	class JJP_JumpLinks_Plugin_AJAX extends JJP_JumpLinks_Plugin {
		use \JumpLinks\Ajax;
		function __construct(){
			parent::__construct();
			add_action('wp_ajax_jump_links_get_list', 	array($this, 'ajax_get_url_list'));
			add_action('wp_ajax_jump_links_get_id', 		array($this, 'ajax_get_id'));
			add_action('wp_ajax_jump_links_rm_id', 			array($this, 'ajax_remove_id'));
			add_action('wp_ajax_jump_links_update_id', 	array($this, 'ajax_update_id'));
			add_action('wp_ajax_jump_links_insert_url', array($this, 'ajax_insert_new_url'));
		}
	}
	$Plugin_JumpLinks = new JJP_JumpLinks_Plugin_AJAX();

} else if(
	preg_match('/([A-Za-z]{1}[0-9]{1}([a-zA-Z0-9]{1}){6})/',
	$_SERVER['REQUEST_URI'])) {

		//if the pattern matches, then we're ready to redirect;
		require "scripts/php/traits/detect.php";
		class JJP_JumpLinks_Plugin_Detect extends JJP_JumpLinks_Plugin {
			use \JumpLinks\Detect;
			function __construct(){
				parent::__construct();
				add_action('init', array($this,'detect'));
			}
		}
	$Plugin_JumpLinks = new JJP_JumpLinks_Plugin_Detect();

} else {

	// Load the default plugin
	$Plugin_JumpLinks = new JJP_JumpLinks_Plugin();
}
