<?php

/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;

use Jemaa\DirexPlugin\Base\BaseController;

/**
 * Class Enqueue
 */

class Enqueue extends BaseController {
  
    
    public function register(): void {
        add_action('admin_enqueue_scripts',  [$this, 'enqueue']);
    }

    public function enqueue(): void {
        // Only enqueue on plugin pages
        $screen = get_current_screen();
        error_log('Current Screen ID: ' . $screen->id); // Debugging purposes
        if (strpos($screen->id, 'direx_plugin') === false) {
            return;
        }

        wp_enqueue_style(
            'direx-admin-style',
            $this->plugin_url . 'assets/css/mystyle.css',
            [],
            filemtime($this->plugin_path . 'assets/css/mystyle.css')
        );

        wp_enqueue_script(
            
            'direx-admin-script',
            $this->plugin_url . 'assets/js/myscript.js',
            ['jquery'],
            filemtime($this->plugin_path . 'assets/js/myscript.js'),
            true
        );

      
    }

       
    }
   

