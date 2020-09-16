<?php

/**
 * Server class
 */
class Server
{
    private $server;

    public function __construct()
    {
        $this->server = $_SERVER;
    }

    public function get($key)
    {
        $result = (isset($this->server[$key]))? $this->server[$key] : null ;
        return $result;
    }

    public function set($key, $value)
    {
        $this->server[$key] = $value;
    }
}
