<?php

/**
 * @package DirexPlugin
 */
/*
Plugin Name: Direx Plugin
Plugin URI: http://direx.com/plugin
Description: The Direx Plugin is designed to secure user authentification, view and manage orders.
Version: 1.0.0
Author: Yosr Jemaa
Auther URI : http://direx.com 
License: Apache License 2.0 or later
License URI: https://www.apache.org/licenses/LICENSE-2.0
Text Domain: direx-plugin
*/

// If this file is called fircely, abort!!!
if(! defined('ABSPATH'))  {
    die;
}


//Require once the Composer Autoload
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}


/**
 * The code that runs during plugin activation
 */
function activate_direx_plugin()  {
    Jemaa\DirexPlugin\Base\Activate::activate();
}

register_activation_hook( __FILE__ , 'activate_direx_plugin');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_direx_plugin()  {
    Jemaa\DirexPlugin\Base\Deactivate::deactivate();
}
 
register_deactivation_hook( __FILE__ , 'deactivate_direx_plugin');

/**
 * Initialize all core classes of the plugin
 */

 function initialize_direx_plugin() {
    error_log('Direx Plugin Initialized');

    Jemaa\DirexPlugin\Init::get_instance()->register_services();
}
add_action('plugins_loaded', 'initialize_direx_plugin');    


    