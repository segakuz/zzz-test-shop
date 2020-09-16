<?php

// settings for database connection
define('DB_HOST', 'localhost');
define('DB_NAME', 'abcshop');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('PDO_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);

//Root
if (DIRECTORY_SEPARATOR=='/')
  $absolute_path = dirname(__FILE__, 2).'/';
else
  $absolute_path = str_replace('\\', '/', dirname(__FILE__, 2)).'/';

define('ROOT', $absolute_path);

//settings for View
define('TEMPLATE_PATH' , './assets/tpl/');

// default view
define('DEFAULT_ACTION' , 'site/index');