<?php

use framework\system\Router;
phpinfo();
die();
require_once "vendor/autoload.php";

$oRouter = new Router();
$oRouter->init();
$oRouter->route();