<?php
namespace app\dm\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Loader;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch("index");
    }

}
