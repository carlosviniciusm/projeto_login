<?php

use framework\system\Router;
require_once "vendor/autoload.php";

$oRouter = new Router();
$oRouter->init();
$oRouter->route();