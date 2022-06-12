<?php

/**
 * This file is part of MVC Core framework
 * (c) Matija Božić, www.matijabozic.com
 * 
 * Settings class, uses ini_set to set directives of php.ini directives.
 * 
 * This enables you to setup PHP the way you like it. Not all php.ini
 * directives can be changed on the runtime, check here for reference:
 * http://www.php.net/manual/en/ini.list.php 
 * 
 * This class is usefull on shared hosting where you don't have access to 
 * php.ini file. Joust instanciate this class at bootstrap level and setup
 * PHP the way you like it.
 * 
 * @package    Settings
 * @author     Matija Božić <matijabozic@gmx.com>
 * @license    MIT - http://opensource.org/licenses/MIT
 * @version    20120812
 */

namespace Core\Settings;

class Settings
{
    /**
     * Set new directive
     * 
     * @access  public
     * @param   string
     * @param   mixed
     * @return  string | false
     */

    public function set($option, $value)
    {
        ini_set($option, $value);
    }

    /**
     * Returns current value of configuration option
     * 
     * @access  public
     * @param   string
     * @return  string | empty | false
     */

    public function get($option)
    {
        return ini_get($option);
    }

    /**
     * Sets directives for a list of settings defined in configuration
     * 
     * @access  public
     * @param   array
     * @return  void
     */

    public function process($settings)
    {
        foreach ($settings as $directive => $value) {
            $this->set($directive, $value);
        }
    }

    /**
     * Returns all the registered configuration options
     * 
     * @access  public
     * @return  array
     */

    public function getAll()
    {
        return ini_get_all();
    }

    /**
     * Sets configuration option to its default value
     * 
     * @access  public
     * @return  void
     */

    public function restore($value)
    {
        ini_restore($value);
    }
}
