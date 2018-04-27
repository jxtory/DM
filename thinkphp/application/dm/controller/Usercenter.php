<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Usercenter extends Dmbase
{
    public function index()
    {
    	$datas = db("user a", $this->dbUser)
            ->field("a.*, b.uid, b.authlevel")
    		->join("auth b", "a.id = b.uid")
            ->paginate(15);

        $this->assign("datas", $datas);
    	return $this->fetch("");
    }

    public function cpw()
    {
    	return $this->error("修改密码, 暂未开放");
    }

}
