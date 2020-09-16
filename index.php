<?php

require_once './core/Autoloader.php';
require_once './helpers/test_input.php';

ini_set('display_errors', '0');
error_reporting(E_ALL);

$app = App::getApp();
$app->router->run();
