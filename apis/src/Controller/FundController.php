<?php

namespace APISController\Controller;

include_once 'Controller.php';

class FundController extends  ApiController
{
    public function defaultAction()
    {

        return $this->writeJson(array("error"=>1,"data"=>"数据为空"));
    }

}