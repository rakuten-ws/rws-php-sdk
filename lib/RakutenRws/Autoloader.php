<?php

/**
 * This file is part of Rakuten Web Service SDK
 *
 * (c) Rakuten, Inc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with source code.
 */

/**
 * Autoloader of RakutenRws
 *
 * @package RakutenRws
 */
class RakutenRws_Autoloader
{
    /**
     * Registers RakutenRws_Autoloader spl_autoload_register
     *
     */
    static public function register()
    {
        spl_autoload_register(array('RakutenRws_Autoloader', 'autoload'));
    }

    static public function autoload($class)
    {
        if (0 !== strpos($class, 'RakutenRws_')) {

            return;
        }

        $filename = dirname(__FILE__).'/../'.str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';

        if (is_file($filename)) {

            require_once $filename;
        }
    }
}
