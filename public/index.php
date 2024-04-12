<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/util/constants.php';
require_once __DIR__ . '/../src/util/middleware.php';
require_once __DIR__ . '/../src/util/functions.php';


$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);



// Enabling CORS
$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->add($restrictRoutesMiddleware);


require_once __DIR__ . '/../src/routes/routes.php';


$app->run();
