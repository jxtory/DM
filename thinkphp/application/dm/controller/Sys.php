<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Sys extends Dmbase
{
    public function index()
    {   
        return $this->error("尚未开放");
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
