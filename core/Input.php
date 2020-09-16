<?php

/**
 * Input class
 */
class Input
{
    private $input;

    public function __construct()
    {
        $this->input = array_merge($_GET, $_POST);
    }

    public function get($key)
    {
        $result = (isset($this->input[$key]))? $this->input[$key] : null ;
        return $result;
    }

    public function set($key, $value)
    {
        $this->input[$key] = $value;
    }
}