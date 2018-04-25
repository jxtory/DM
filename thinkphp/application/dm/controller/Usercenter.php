<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Usercenter extends Dmbase
{
    public function index()
    {
    	return $this->error("尚未开放");
    }

    public function cpw()
    {
    	return $this->error("修改密码, 暂未开放");
    }

}
