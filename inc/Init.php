<?php
/**
 * @package  DirexPlugin
 */
namespace Jemaa\DirexPlugin;



final class Init
{
     /**
     * @var Init|null The single instance of the class
     */
    private static $instance = null;

     /**
     * Private constructor to prevent creating a new instance of the
     * class via the new operator from outside of this class.
     */
    private function __construct() {
       
    }


    /**
     * Store all the classes inside an array
     * @return array Full list of classes 
     */
   public static function get_services()  
   {
    return [
        Base\Enqueue::class,
        Pages\Admin::class,
        Base\SettingsLinks::class ,
        Base\AuthController::class,
        Base\OrderController::class,
        Base\ApiController::class,
        Base\BaseController::class,
    ];
   }
    /**
     * @return Init Instance
     */
    public static function get_instance() 
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

   /**
    *loop through the classes, initialize them, 
    *and call the register() method if it exists 
    * @return void
    */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {
            $service = self::instantiate($class);
                if (method_exists($service, 'register')) {
                    $service->register();
                   
            }
        }
    }
    
   /**
    *initialize the class 
    *@param class $class      class form the services array 
    *@return class instance   new instance of the class
    */
   private static function instantiate( $class )
   {
    
       return new $class();
   }
 
}



   
   


