<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\TransactionsTableController;
use App\Controllers\UploadController;
use App\Router;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ ."/../vendor/autoload.php";

define("VIEW_PATH", __DIR__ . '/../Views/');
define("STORAGE_PATH", __DIR__ . '/../storage');

session_start();

(new Dotenv())->load(__DIR__ . '/' . '..' . '/' . '.env');


$router = new Router;

$router->get("/", [HomeController::class, "index"]);
$router->post("/upload", [UploadController::class, "index"]);
$router->get("/transactions", [TransactionsTableController::class, "index"]);



(new App($router, ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]))->run();