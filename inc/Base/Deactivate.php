<?php

/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;

class Deactivate  
{
    public static function deactivate()  {
        
        flush_rewrite_rules();
        
       
    }


}