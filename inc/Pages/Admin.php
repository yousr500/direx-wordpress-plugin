<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Pages;

use Jemaa\DirexPlugin\Base\BaseController;
use Jemaa\DirexPlugin\Core\SettingsApi;


use Jemaa\DirexPlugin\Core\Callbacks\AdminCallbacks;

/**
 * Class Admin  
 */
class Admin extends BaseController
{
   public $settings;

   public $callbacks;

   protected $pages = [];

   protected $subpages = [];

     public function register()
     {
      $this->settings = new SettingsApi();

      $this->callbacks = new AdminCallbacks();

      $this->set_pages();

      $this->set_subpages();

      $this->set_settings();

      $this->set_sections();

      $this->set_fields();

      $this->settings->add_pages( $this->pages )->with_subpage( 'Dashboard' )->add_subpages( $this->subpages )->register();
     }
    
     
     public function set_pages()
     {
      $this->pages = [
         [
            'page_title' => 'Direx Plugin',
            'menu_title' => 'Direx',
            'capability' => 'manage_options',
            'menu_slug' => 'direx_plugin',
            'callback' => array( $this->callbacks, 'adminDashboard' ),
            'icon_url' => 'dashicons-store',
            'position' => 110
         ]
         ];
     }
     public function set_subpages()
     {
      $this->subpages = [
         [
            'parent_slug' => 'direx_plugin',
            'page_title' => ' Authentification',
            'menu_title' => 'Login',
            'capability' => 'manage_options',
            'menu_slug' => 'direx_auth',
            'callback' => array( $this->callbacks, 'adminAuth' ),
         ],
         [
            'parent_slug' => 'direx_plugin',
            'page_title' => 'Order list',
            'menu_title' => 'Orders',
            'capability' => 'manage_options',
            'menu_slug' => 'direx_ord',
            'callback' => array( $this->callbacks, 'adminOrd' ),
         ]
       
      ];
     }

     public function set_settings() 
     {
      $args = [
        
         [
            'option_group' => 'direx_options_group',
            'option_name' => 'direx_options',
            'callback' => array( $this->callbacks, 'direxOptionsGroup' )
         ]
         

      ];
      $this->settings->set_settings( $args );
     }
       public function set_sections()
       {
         $args = [
         
          [
            'id' => 'direx_admin_index',
               'callback' => array( $this->callbacks, 'direxAdminSection' ),
               'title' => '',
               'page' => 'direx_plugin'
          ]
      
          ];
         $this->settings->set_sections( $args );
       }
         public function set_fields()
         {
           
            $args = [];
            $this->settings->set_fields( $args );
         }   
}
