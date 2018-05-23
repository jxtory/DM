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
    	return $this->error("正在开发中…………");
    }

}
