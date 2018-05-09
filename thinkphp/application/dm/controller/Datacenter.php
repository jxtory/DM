<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Datacenter extends Dmbase
{
    public function index()
    {
    	//人数统计
    	$mans_zaizhi = db("personnels")->where("status", "0")->count("id");
    	$mans_lizhi = db("personnels")->where("status", "1")->count("id");
    	$this->assign("mans_zaizhi", $mans_zaizhi);
    	$this->assign("mans_lizhi", $mans_lizhi);

    	//部门统计
    	$dept_level1 = db("dept1")->count("dept1");
    	$this->assign("dept1", $dept_level1);
    	$dept_level2 = db("dept2")->count("dept2");
    	$this->assign("dept2", $dept_level2);

    	//设备用量统计
    	$deviceoutside = db("holders")->count("id");
    	$this->assign("deviceoutside", $deviceoutside);
    	$deviceinside = db("devices")
    		->where("id", "not in", function($query){
    			$query->table("dm_holders")->field("did");
    		})
    		->count("id");

    	$this->assign("deviceinside", $deviceinside);

    	$devicesum = db("devices")->count("id");
    	$this->assign("devicesum", $devicesum);

    	return $this->fetch();
    }

}
