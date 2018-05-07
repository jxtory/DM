<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Datacenter extends Dmbase
{
    public function index()
    {
    	return $this->fetch();
    }

}
