<?php

/**
 * Request class
 */
class Request
{
    private $input;
    private $server;
    private $session;

    public function __construct()
    {
        $this->input = new Input();
        $this->server = new Server();
        $this->session = new Session();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getInput()
    {
        return $this->input;
    }
}
