<?php

mb_internal_encoding('utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

require_once ROOT . '/Models/Call.php';
require_once ROOT . '/Models/Router.php';

require_once ROOT . '/Config/Router.php';

Router::Run();