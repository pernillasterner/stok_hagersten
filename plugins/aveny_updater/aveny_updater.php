<?php
/*
Plugin Name: Audo-updater for Aveny Calendar-sync
Plugin URI: http://203creative.se
Description: Adds a job to the wordpress core that triggers the update-script on a specific time interval.
Version: 1.0
Author: Pierre Vahlberg

This script is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This script is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define('AVENY_UPDATER_LOG', __DIR__."/log.txt");

// --- Filters
if(function_exists('add_filter'))
    add_filter( 'cron_schedules', 'cron_add_minutely' );

// --- Actions
if(function_exists('add_action'))
    add_action('aveny_update_hourly_cron','do_aveny_update_hourly_cron');

// --- Hooks
if(function_exists('register_activation_hook'))
    register_activation_hook( __FILE__, 'aveny_updater_plugin_activation' );

if(function_exists('register_deactivation_hook'))
    register_deactivation_hook(__FILE__, 'aveny_updater_plugin_deactivation');


// Manual update?
if(isset($_GET['key']) && $_GET['key'] === "203admin"){
    echo "Doin aveny update hourly cron";

    if(isset($_GET['DateFrom'])) {
        $DateFrom = $_GET['DateFrom'];
        do_aveny_update_hourly_cron($DateFrom);
    } else {
        do_aveny_update_hourly_cron();
    }

}

//---------------------------------------------------------------------------------
//  Activate the scheduling upon plugin activation
//---------------------------------------------------------------------------------
function aveny_updater_plugin_activation() {

    # Do logging
    aveny_updater_log_row("Plugin actvated!");
    aveny_updater_log_row("Source file: ".__FILE__);

    // If our cron hook doesn't yet exist, create it.
    if (!wp_next_scheduled('aveny_update_hourly_cron')) {
        wp_schedule_event( time(), 'custom_interval', 'aveny_update_hourly_cron');
        aveny_updater_log_row("Re-initiated cron-scheduling this time");
    }
}

function aveny_updater_plugin_deactivation(){

    // If our cron hook exists. remove it.
    if (wp_next_scheduled('my_hourly_cron')) {
        wp_clear_scheduled_hook('my_hourly_cron');

        # Message logging
        aveny_updater_log_row("Removed job");
    }
    # logging
    aveny_updater_log_row("Deactivated plugin");
}

//---------------------------------------------------------------------------------
//  Add schedule-interval for scheduling events/hooks. We need a short interval
//---------------------------------------------------------------------------------
function cron_add_minutely( $schedules ) {

    // add a short schedule interval to the existing set
    $schedules['custom_interval'] = array(   // the variable name of the interval
        'interval' => 300,                   // in seconds
        'display' => __('Custom Interval for dev') // only for show
    );

    return $schedules;
}

//---------------------------------------------------------------------------------
//  Add action hook which can be triggered from within wordpress, or this plugins scheduled job
//---------------------------------------------------------------------------------
function do_aveny_update_hourly_cron($DateFrom = null) {

    if(!$DateFrom) $DateFrom = date('Ymd');

    # Run update
    $error = false;
    try {
        if(! class_exists("AvenyApi")){
            require("../../themes/hagersten/AvenyAPI.class.php");
        }

        $args = Array ('datum' => $DateFrom, 'datum-ti' => date('Ymd', strtotime('+1 year', mktime())), 'pagesize'=>'200');
        $test = new AvenyAPI($args);
        $test->save();
        # Message logging
        aveny_updater_log_row("Update done".'  '. date('Y-m-d H:i:s'));
    }
    catch(Exception $e){
        $error = $e;
    }

    if($error)
        aveny_updater_log_row( "Error occured".'   '.$error->getMessage());
}

//---------------------------------------------------------------------------------
//  Logging function
//---------------------------------------------------------------------------------
function aveny_updater_log_row( $message ){

    if(!file_exists( AVENY_UPDATER_LOG )){
         $h = fopen( AVENY_UPDATER_LOG, 'w') or die ("can't open file");
         fclose($h);
    }

    # Do logging
    $handle = fopen( AVENY_UPDATER_LOG, 'a' );
    fwrite($handle, $message.PHP_EOL);
    fclose($handle);
}

?>
