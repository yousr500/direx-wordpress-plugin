<?php

/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;



class Activate  
{
    public static function activate()  {

        flush_rewrite_rules();
    }


}