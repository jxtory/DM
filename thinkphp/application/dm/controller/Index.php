<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;
use Room\Names\RndChinaName;

class Index extends Dmbase
{
    public function index()
    {
        return $this->fetch("index");
    }

    public function window()
    {
    	return $this->error("尚未开放");
    }

    public function test()
    {
    	$rCN = new RndChinaName();

    	return $rCN->getName(2);
    }

}
