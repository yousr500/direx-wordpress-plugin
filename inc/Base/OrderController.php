<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;

use Jemaa\DirexPlugin\Base\BaseController;
/**
 *  class OrderController
 */

  class OrderController extends BaseController {
    public function register(): void {
        add_action('admin_enqueue_scripts',  [$this, 'enqueue']);
    }

    public function enqueue(): void {
        // Only enqueue on plugin pages
        $screen = get_current_screen();
        error_log('Current Screen ID: ' . $screen->id); // Debugging purposes
        if (strpos($screen->id, 'direx_ord') === false) {
            return;
        }

        wp_enqueue_style(
            'direx-order-style',
            $this->plugin_url . 'assets/css/order.css',
            [],
            filemtime($this->plugin_path . 'assets/css/order.css')
        );

        wp_enqueue_script(
            
            'direx-order-script',
            $this->plugin_url . 'assets/js/order.js',
            ['jquery'],
            '1.0.0',
            true,
            filemtime($this->plugin_path . 'assets/js/order.js'),
            true
        );

      
    }


 }