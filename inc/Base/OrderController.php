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
        add_action('wp_ajax_get_orders', [$this, 'get_orders']);
    }

    public function enqueue(): void {
        // Only enqueue on plugin pages
        $screen = get_current_screen();
       
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
            
            filemtime($this->plugin_path . 'assets/js/order.js'),
            true
        );

      
        wp_localize_script('direx-order-script', 'direxAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('direx_order_nonce')
        ]);
    }

    public function get_orders() {
        // Fetch orders from your code
        $orders = [
            ['id' => 1, 'name' => 'Product A', 'price' => 100, 'stock' => 10, 'type' => 'Type A', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Product B', 'price' => 200, 'stock' => 5, 'type' => 'Type B', 'status' => 'Inactive'],
        ];

        wp_send_json_success($orders);
    }


 }