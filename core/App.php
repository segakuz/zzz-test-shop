<?php

/**
 * Singleton class for our application
 */
class App
{
    private static $app;
    private $request;
    public $router;

    private function __construct()
    {
        require_once './config/config.php';
        $this->request = new Request();
        $this->router = new Router();
    }

    public static function getApp()
    {
        if ( ! isset( self::$app ))
        {
            self::$app = new self();
        }
        return self::$app;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
