<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Allocation extends Dmbase
{
    public function _initialize()
    {
        parent::_initialize();
        return $this->levelCheck(2);
    }
    
    public function index()
    {
        return $this->rehome;
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
        $datas = db("history a, dm_devices b, dm_personnels c")
            ->field("a.*, b.an, c.personnel")
            ->where("a.did = b.id and a.holder = c.id")
            ->paginate(15);
        $this->assign("datas", $datas);
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

        if(input("post.type") == "getHoldersInfo"){
            $who = input("post.content");
            if(!empty($who)){
                $res = db("holders a, dm_devices b, dm_personnels c")
                    ->field("a.*, b.an, c.personnel")
                    ->where("a.did = b.id and a.holder = c.id")
                    ->where("b.an|c.personnel|c.phoneticize", "like", "%" . $who ."%")
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

        if(input("post.types") == "editHoldInfo"){
            $datas = input();
            unset($datas['types']);
            $data = [
                'components'    =>  empty($datas['ds_component']) ? "" : $datas['ds_component']
            ];
            $res = db('holders')->where('id', $datas['hid'])->update($data);

            return $res;
        }

        if(input("post.types") == "deleteHoldInfo"){
            $data = input("post.hid");
            $res = db('holders')->where('id', $data)->delete();
            return $res;
        }

        if(input("post.types") == "storageHoldInfo"){
            $hid = input("post.hid");
            $history = db("holders")->where("id", $hid)->find();
            $history['return_time'] = date("Y-m-d");
            unset($history['id']);
            unset($history['components']);
            $upd = db("history")->insert($history);
            $res = db("holders")->where("id", $hid)->delete();
            return $res;
        }

        return $this->rehome;
    }

}
