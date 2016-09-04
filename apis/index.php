<?php

require __DIR__.'/vendor/autoload.php';

$app = new Slim\App();

foreach (glob(__DIR__.'/src/View/*.php') as $router) {
    require_once $router;
}

$app->run();
