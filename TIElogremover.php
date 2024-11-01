<?php

/*
Plugin Name: TIElogremover
Plugin URI: http://www.setupmyvps.com/tielogremover/
Description: Log remover plugin. Creates a scheduled job which trashes error_log files without any kind of checking. This plugin is now available as part of TIEtools, which also includes post expiry and duplicate post control.
Version: 1.0.1
Author: TIEro
Author URI: http://www.setupmyvps.com
License: GPL2
*/

register_activation_hook(__FILE__, 'do_tielog_activate');
register_deactivation_hook(__FILE__, 'do_tielog_deactivate');

add_action('my_log_remover', 'do_tielog_remove_logs');

function do_tielog_activate() {
  if( !wp_next_scheduled( 'tielog_log_remover' ) ) {
    wp_schedule_event( current_time ( 'timestamp' ), 'daily', 'tielog_log_remover' ); }
}

function do_tielog_deactivate() {
	// Remove scheduled job
	wp_clear_scheduled_hook( 'tielog_log_remover' );
}

function do_tielog_remove_logs() {
	unlink(ABSPATH . 'error_log');
	unlink(ABSPATH . 'wp-admin/error_log');
	unlink(ABSPATH . 'wp-content/error_log');
}

?>