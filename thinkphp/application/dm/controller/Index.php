<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Index extends Dmbase
{
    public function index()
    {
        return $this->fetch("index");
    }

}
