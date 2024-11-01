<?php
/**
* Plugin Name: WS Comments Hider
* Plugin URI: https://www.silvermuru.ee/en/wordpress/plugins/ws-comments-hider/
* Description: Hide comments functionality in frontend and backend
* Version: 1.0.1
* Author: UusWeb.ee
* Author URI: https://www.wordpressi-kodulehe-tegemine.ee/
* Text Domain: ws-comments-hider
**/
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WS_Comments_Hider {
	public function __construct(){
		add_action( 'plugins_loaded', array( $this, 'ws_comments_hider_load_textdomain' ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'ws_hide_comments_admin_bar') );
		add_filter( 'comments_open', array( $this, 'ws_disable_comments_status'), 20, 2 );
		add_filter( 'pings_open', array( $this, 'ws_disable_comments_status'), 20, 2 );
	}

	public function ws_comments_hider_load_textdomain() {
		load_plugin_textdomain( 'ws-comments-hider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function ws_hide_comments_admin_bar(){
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
	}

	public function ws_disable_comments_status() {
		return false;
	}
}

if ( is_admin() ) {
	require plugin_dir_path( __FILE__ ) . '/admin/ws-comments-hider-admin.php';
}

$wpse_ws_comments_hider_plugin = new WS_Comments_Hider();
?>
