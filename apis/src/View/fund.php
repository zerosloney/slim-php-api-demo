<?php
require   dirname(dirname(__FILE__)).'/Controller/FundController.php';

use APISController\Controller\FundController;

$app->get('/funds/', function ($request, $response, $args) {
    return (new FundController($request,$response,$args))->defaultAction();
});