<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;
use Room\Names\RndChinaName;

class Sys extends Dmbase
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

    public function user()
    {
        return $this->redirect("dm/usercenter/index");
    }
    public function datas()
    {
        return $this->supperCheck();
        return $this->rehome;
    }

    public function demodatas()
    {
        return $this->fetch();
        return $this->rehome;
    }

    public function getdemodata()
    {
        if(input("post.type") == "dp" && input("post.action") == "addDept"){
            $datas = [
                ["dept1"    =>  "管理部"],
                ["dept1"    =>  "产品部"],
                ["dept1"    =>  "技术部"],
                ["dept1"    =>  "运营部"],
                ["dept1"    =>  "审核部"],
            ];

            $datas2 = [
                ["dept2"    =>  "人力资源部"],
                ["dept2"    =>  "财务部"],
                ["dept2"    =>  "美术部"],
                ["dept2"    =>  "设计部"],
                ["dept2"    =>  "行政部"],
            ];

            $res = db("dept1")->insertAll($datas, true);
            $res2 = db("dept2")->insertAll($datas2, true);

            if($res && $res2){
                return true;
            }

            return false;
        }

        if(input("post.type") == "cn" && input("post.action") == "addComponents"){
            $datas = [
                ["devicetype"    =>  "台式机"],
                ["devicetype"    =>  "笔记本"],
                ["devicetype"    =>  "显示器"],
                ["devicetype"    =>  "测试手机"],
                ["devicetype"    =>  "打印机"],
            ];

            $datas2 = [
                ["model"    =>  "Pro 13'"],
                ["model"    =>  "Air"],
                ["model"    =>  "P8"],
                ["model"    =>  "5s"],
                ["model"    =>  "6s"],
            ];

            $datas3 = [
                ["brand"    =>  "苹果"],
                ["brand"    =>  "三星"],
                ["brand"    =>  "微软"],
                ["brand"    =>  "华硕"],
                ["brand"    =>  "小米"],
            ];

            $res = db("devicetype")->insertAll($datas, true);
            $res2 = db("brand")->insertAll($datas3, true);
            $res3 = db("model")->insertAll($datas2, true);

            if($res && $res2 && $res3){
                return true;
            }

            return false;
        }

        if(input("post.type") == "ps"){
            $nums = input("post.nums");
            $rcn = new RndChinaName();
            $dept1 = db("dept1")->select();
            $dept2 = db("dept2")->select();
            for ($i=0; $i < $nums; $i++) { 
                # code...
                $name = $rcn->getName(2);
                $data = [
                    "personnel" =>  $name,
                    "dept1" =>  $dept1[mt_rand(0, count($dept1) - 1)]['dept1'],
                    "dept2" =>  $dept2[mt_rand(0, count($dept2) - 1)]['dept2'],
                    "position"  =>  "Other",
                    "sex" =>    mt_rand(0,1) ? "男" : "女",
                    "status"    =>  mt_rand(0, 1),
                    "time"  =>  date("Y-m-d")
                ];
                $res = db("personnels")->insert($data, true);
                if(!$res){return false;}
            }
            return true;
        }

        if(input("post.type") == "ds"){
            $nums = input("post.nums");
            $devicetype = db("devicetype")->select();
            $brand = db("brand")->select();
            $model = db("model")->select();
            for ($i=0; $i < $nums; $i++) { 
                # code...
                $data = [
                    "an"    =>  mt_rand(10000, 99999),
                    "type"  =>  $devicetype[mt_rand(0, count($devicetype) - 1)]['devicetype'],
                    "brand"  =>  $brand[mt_rand(0, count($brand) - 1)]['brand'],
                    "model"  =>  $model[mt_rand(0, count($model) - 1)]['model'],
                    "sn"    =>  mt_rand(111111, 999999),
                    "comment"   =>  "正常"

                ];

                $res = db("devices")->insert($data, true);
                if(!$res){return false;}
            }
            return true;
        }

        return $this->rehome;
    }

    public function tc()
    {
        if(input('post.type') == "personnels"){
            $sql = "truncate table dm_personnels";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "devicetype"){
            $sql = "truncate table dm_devicetype";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "brand"){
            $sql = "truncate table dm_brand";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "model"){
            $sql = "truncate table dm_model";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "devices"){
            $sql = "truncate table dm_devices";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "holders"){
            $sql = "truncate table dm_holders";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "components"){
            $sql = "truncate table dm_components";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "history"){
            $sql = "truncate table dm_history";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "macaddress"){
            $sql = "truncate table dm_macaddress";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "quality"){
            $sql = "truncate table dm_qualityandhealth";
            $res = db()->query($sql);
            return $res;
        }

        if(input('post.type') == "repair"){
            $sql = "truncate table dm_repair_record";
            $res = db()->query($sql);
            return $res;
        }

        return $this->rehome;

    }

    public function god()
    {
        if(input('post.type') == "all"){
            $sql = [
                "TRUNCATE TABLE dm_dept1;",
                "TRUNCATE TABLE dm_dept2;",
                "TRUNCATE TABLE dm_personnels;",
                "TRUNCATE TABLE dm_devicetype;",
                "TRUNCATE TABLE dm_brand;",
                "TRUNCATE TABLE dm_model;",
                "TRUNCATE TABLE dm_devices;",
                "TRUNCATE TABLE dm_history;",
                "TRUNCATE TABLE dm_holders;",
                "TRUNCATE TABLE dm_macaddress;",
                "TRUNCATE TABLE dm_qualityandhealth;",
                "TRUNCATE TABLE dm_repair_record;",
                "TRUNCATE TABLE dm_components"
            ];
            foreach ($sql as $key => $value) {
                $res = db()->query($sql[$key]);
            }
            // $link = mysqli_connect("127.0.0.1", "root", "", "dm");
            // $aaa = mysqli_query($link, $sql[0]);
            // mysqli_close($link);
            return "ok";

        }
        return $this->rehome;
    }

}
