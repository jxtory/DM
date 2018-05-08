<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Datacenter extends Dmbase
{
    public function index()
    {
    	$mans_zaizhi = db("personnels")->where("status", "0")->count("id");
    	$mans_lizhi = db("personnels")->where("status", "1")->count("id");
    	$this->assign("mans_zaizhi", $mans_zaizhi);
    	$this->assign("mans_lizhi", $mans_lizhi);
    	return $this->fetch();
    }

}
