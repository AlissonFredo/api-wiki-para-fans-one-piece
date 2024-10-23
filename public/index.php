<?php

require_once('../vendor/autoload.php');

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__, '/../log/error.log');

use app\core\Main;

Main::initialize();
