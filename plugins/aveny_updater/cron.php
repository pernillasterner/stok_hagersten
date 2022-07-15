<?php

#$WP_PATH = '/home/hagersten/www/';
$WP_PATH = '/mnt/persist/www/docroot_hagersten/';
$host = exec('hostname');

if(stristr($host, 'dev.203creative.com')) {
	$WP_PATH = '/home/chrisalb/www/projects/hagersten/';
}
/*
define('WP_USE_THEMES', false);
global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
require_once($WP_PATH . 'wp-load.php');
*/

require_once($WP_PATH . 'wp-content/themes/hagersten/AvenyAPI.class.php');
require_once($WP_PATH . 'wp-content/plugins/aveny_updater/aveny_updater.php');

do_aveny_update_hourly_cron();

