<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| InfinityFree front controller
|--------------------------------------------------------------------------
|
| Upload this file into /htdocs and upload the Laravel project directory as a
| sibling folder named /leboncoin. If your folder name is different, update
| the path below.
|
*/

$basePath = realpath(__DIR__.'/../leboncoin');

if ($basePath === false) {
    http_response_code(500);
    echo 'Laravel project folder not found. Check the path in htdocs/index.php.';
    exit;
}

if (file_exists($maintenance = $basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $basePath.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $basePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
