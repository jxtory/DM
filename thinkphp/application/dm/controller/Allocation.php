<?php
namespace app\dm\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Loader;
class Allocation extends Controller
{
    private $rehome = "<script>window.location.replace('/dm');</script>";
    public function index()
    {
        return $this->fetch("index");
    }

    public function editHoldInfo()
    {
        if(input("post.type") == "editHoldInfo"){
            $components = db("components")->select();
            $this->assign("components", $components);
            $hid = input("post.hid");
            $this->assign("hid", $hid);
            $holdinfo = db("holders")->where("id", $hid)->find();
            $this->assign("holdinfo", $holdinfo);
            $an = db('devices')->field('an')->where('id', $holdinfo['did'])->find();
            $this->assign("holdinfoan", $an);
            return $this->fetch();
        }
        return $this->rehome;
    }

    public function grant()
    {
        $components = db("components")->select();
        $this->assign("components", $components);
        return $this->fetch();
    }

    public function storage()
    {
        return $this->fetch();
    }

    public function holders()
    {
        $res = db("holders a")
            ->field("a.id, a.grant_date, a.components, b.an, c.personnel")
            ->join("dm_devices b", "a.did = b.id")
            ->join("dm_personnels c", "a.holder = c.id")
            ->paginate(15);
        $this->assign("datas", $res);
        return $this->fetch();
   }

    public function warehouse()
    {
    	$res = db("devices")
    		->where("id", "not in", function($query){
    			$query->table("dm_holders")->field("did");
    		})
    		->paginate(15);

    	$this->assign("datas", $res);
    	return $this->fetch();
    }

    public function history()
    {
        return $this->fetch();
    }

    public function inputcheck()
    {
        if(input("post.type") == "grant_pid"){
            $who = input("post.ds_pid");
            $res = db("personnels")->where("id", $who)->find();
            if(!empty($res)){
                return true;
            } else {
                return false;
            }
        }

        if(input("post.type") == "grant_an"){
            $who = input("post.ds_an");
            $res = db("devices")->where("an", $who)
                ->where("id", "not in", function($query){
                    $query->table("dm_holders")->field("did");
                })
                ->find();
            if(!empty($res)){
                return true;
            } else {
                return false;
            }
        }

        return $this->rehome;
    }

    public function getInfos()
    {
        if(input("post.type") == "getHolderInfo"){
            $who = input("post.content");
            if(!empty($who)){
                $res = db("personnels")->where("id|personnel|phoneticize", "like", "%" . $who ."%")->select();
                return $res;
            } else {
                return "";
            }
        }

        if(input("post.type") == "getDeviceInfo"){
            $who = input("post.content");
            if(!empty($who)){
                $res = db("devices")->where("an|type|brand|model", "like", "%" . $who ."%")
                    ->where("id", "not in", function($query){
                        $query->table("dm_holders")->field("did");
                    })
                    ->select();
                return $res;
            } else {
                return "";
            }
        }

        return $this->rehome;
    }

    public function allochandle()
    {
        if(input("post.types") == "addGrant"){
            $datas = input();
            unset($datas['types']);
            $did = db("devices")->field("id")->where("an", input("post.ds_an"))->find();

            $data = [
                'did'  =>  $did['id'],
                'holder'  =>  $datas['ds_pid'],
                'grant_date'  =>  $datas['ds_time'],
                'components'    =>  empty($datas['ds_component']) ? "" : $datas['ds_component']
            ];
            $res = db('holders')->insert($data, true);

            return $res;
        }

        if(input("post.types") == "editDevice"){
            $datas = input();
            unset($datas['types']);
            $data = [
                'an'  =>  $datas['an'],
                'type'  =>  $datas['devicetype'],
                'brand'  =>  $datas['brand'],
                'model'  =>  $datas['model'],
                'sn'  =>  $datas['sn'],
                'comment'  =>  $datas['comment'],
            ];
            $res = db('devices')->where('id', $datas['did'])->update($data);

            return $res;
        }

        if(input("post.types") == "deleteDevice"){
            $data = input("post.did");
            $res = db('devices')->where('id', $data)->delete();
            return $res;
        }

        return $this->rehome;
    }

}
