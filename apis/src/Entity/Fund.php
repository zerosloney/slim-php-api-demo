<?php

namespace  APISModel\Entity\Fund;

class Fund
{
    protected $fundcode;

    protected $fundname;

    protected $fundvalue;

    protected $fundrate;

    protected $estimatevalue;

    protected $estimaterate;

    protected $deviationrate;

    public  function __construct($code,$name,$value,$rate,$estimatevalue,$estimaterate,$deviationrate){

        $this->fundcode = $code;

        $this->fundname = $name;

        $this->fundvalue = $value;

        $this->estimatevalue = $estimatevalue;

        $this->estimaterate = $estimaterate;

        $this->deviationrate = $deviationrate;
    }

    public function getFundCode()
    {
        return $this->fundcode;
    }

    public function getFundName(){
        return $this->fundname;
    }
}