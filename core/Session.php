<?php

/**
 * Session class
 */
class Session
{

    public function __construct()
    {
        if( ! isset($_SESSION) )
        {
            session_start();
        }
    }

    public function get($key)
    {

        $result = (isset($_SESSION[$key]))? $_SESSION[$key] : null ;
        return $result;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function clear($key)
    {
        unset($_SESSION[$key]);
    }
}
