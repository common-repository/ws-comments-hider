<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WS_Comments_Hider_admin {
    
    public function __construct(){
		add_action( 'admin_menu', array( $this, 'ws_hide_comments_admin_menu_link') );
		add_action( 'admin_init', array( $this, 'ws_remove_comments_post_types_support') );
		add_filter( 'dashboard_recent_posts_query_args', array( $this, 'ws_remove_comments_dashboard') );
    }

	public function ws_hide_comments_admin_menu_link() {
		remove_menu_page( 'edit-comments.php' );
	}

	public function ws_remove_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
	}

	public function ws_remove_comments_dashboard($args ) {
		add_action( 'pre_get_comments', function( \WP_Comment_Query $q )
        {
            if( 1 === did_action( 'pre_get_comments' ) )
                $q->set( 'count', true );

            // Override the WHERE part
            add_filter( 'comments_clauses', function( $clauses )
            {
                if( 1 === did_action( 'pre_get_comments' ) )
                    $clauses['where'] = ' 0=1 ';
                return $clauses;
            }, PHP_INT_MAX );

        } );
        return $args;
	}
}

$wpse_ws_comments_hider_plugin_admin = new WS_Comments_Hider_admin();
?>