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
        add_action('wp_ajax_nopriv_get_orders', [$this, 'get_orders']);
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
            ['id' => 1, 'name' => 'Violin', 'price' => 1000, 'stock' => 56, 'brand' => 'Stentor', 'status' => 'Active', 'category' => 'String instrument'],
            ['id' => 2, 'name' => 'Cello', 'price' => 1674, 'stock' => 53, 'brand' => 'Yamaha', 'status' => 'Inactive', 'category' => 'String instrument'],
            ['id' => 3, 'name' => 'Piano', 'price' => 1934, 'stock' => 106, 'brand' => 'Yamaha', 'status' => 'Active', 'category' => 'String instrument'],
            ['id' => 4, 'name' => 'Flute', 'price' => 656, 'stock' => 45, 'brand' => 'Yamaha', 'status' => 'Inactive', 'category' => 'Woodwind instrument'],
            ['id' => 5, 'name' => 'Guitar', 'price' => 87, 'stock' => 190, 'brand' => 'Yamaha', 'status' => 'Active', 'category' => 'String instrument'],
            ['id' => 6, 'name' => 'Harp', 'price' => 8557, 'stock' => 512, 'brand' => 'Lyon & Healy', 'status' => 'Inactive', 'category' => 'String instrument'],
        ];

        wp_send_json_success($orders);
    
  
       
    }

   

  


 }