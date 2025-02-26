<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Core\Callbacks;

use Jemaa\DirexPlugin\Base\BaseController;


class AdminCallbacks extends BaseController
{
    public function adminDashboard() 
    {
        return require_once( "$this->plugin_path/templates/admin.php" );
    }
    public function adminAuth()
	{
		return require_once( "$this->plugin_path/templates/auth.php" );
	}
    public function adminOrd()
	{
		return require_once( "$this->plugin_path/templates/order.php" );
	}

public function direxOptionsGroup( $input )
    {
        return $input;
    }
    public function direxAdminSection()
    {
    }
  

   
}
    
   
