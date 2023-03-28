<?php

declare(strict_types=1);

use app\routes\Router;
use Dotenv\Dotenv;

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . "./../");
$dotenv->load();

Router::execute();