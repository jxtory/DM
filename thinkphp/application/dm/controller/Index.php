<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

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

}
