<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Usercenter extends Dmbase
{
    public function login()
    {
        return $this->fetch("");
    }

    public function register()
    {
    	return $this->fetch("");
    }

}
