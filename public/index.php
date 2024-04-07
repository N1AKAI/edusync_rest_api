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

$app->add($restrictRoutesMiddleware);


require_once __DIR__ . '/../src/routes/routes.php';


$app->run();
