<?php
namespace app\dm\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Loader;
class Personnels extends Controller
{
    private $rehome = "<script>window.location.replace('/dm');</script>";
    public function index()
    {   
        $datas = db('personnels')->paginate(5);
        $this->assign('datas', $datas);
        return $this->fetch('index');

    }

    //新增加人员
    public function addPersonnel()
    {
        $dept1 = db('dept1')->select();
        $dept2 = db('dept2')->select();
        $this->assign('dept1box', $dept1);
        $this->assign('dept2box', $dept2);
        if(empty($dept1) || empty($dept2)){
            return "
                    <style>
                        *{transition:0.5s;-moz-transition:0.5s;-webkit-transition:0.5s;-o-transition:0.5s;}
                        #box {font-size: 18px; text-align: center; color: #fff; background: #2dc3e8; padding:20px; margin: 100px auto 0 auto; width: 400px; line-height: 24px; height: 50px; border-radius: 50px; display: block;}
                        .box1{width: 200px; height: 20px; line-height: 20px; margin: 20px auto; text-align: center;}
                        .text1{font:20px bold; margin: 0 3px; color: #f00;}
                        .text2{color: #eee;}
                        .bu1{color:#222; font-weight: bold; width: 120px; height: 40px; line-height: 30px;}
                        .bu1:hover {color:#2dc3e8;; }

                        

                    </style>
                    <div id=\"box\"></div>
                    <div class=\"box1\"><button class=\"bu1\" onclick=\"window.location.href = 'dept.html';\">现在就去</button>
                    </div>
                    <script>
                        var time = 9;
                        var interval = setInterval(function(){
                            if(time == 0){
                                window.location.href = 'dept.html';
                                clearInterval(this);
                            } else {
                                document.getElementById('box').innerHTML = '部门配置不完整，请先设置一、二级部门<br><span class=\"text1\"><i>' + time + '</i> </span>秒后跳转到<span class=\"text2\"> [部门设置]</span>';
                                time--;
                            }
                        }, 1000);
                    </script>
            ";
        }
        return $this->fetch();
    }

    //编辑人员
    public function editPersonnel()
    {
        if(input('post.type') == "editPersonnel"){
            $dept1 = db('dept1')->select();
            $dept2 = db('dept2')->select();
            $udata = db('personnels')->where('id', input('post.uid'))->find();
            $this->assign('dept1box', $dept1);
            $this->assign('dept2box', $dept2);
            $this->assign('uid', input('post.uid'));
            $this->assign('udata', $udata);
            if(empty($dept1) || empty($dept2)){
                return "
                    <style>
                        *{transition:0.5s;-moz-transition:0.5s;-webkit-transition:0.5s;-o-transition:0.5s;}
                        #box {font-size: 18px; text-align: center; color: #fff; background: #2dc3e8; padding:20px; margin: 100px auto 0 auto; width: 400px; line-height: 24px; height: 50px; border-radius: 50px; display: block;}
                        .box1{width: 200px; height: 20px; line-height: 20px; margin: 20px auto; text-align: center;}
                        .text1{font:20px bold; margin: 0 3px; color: #f00;}
                        .text2{color: #eee;}
                        .bu1{color:#222; font-weight: bold; width: 120px; height: 40px; line-height: 30px;}
                        .bu1:hover {color:#2dc3e8;; }

                        

                    </style>
                    <div id=\"box\"></div>
                    <div class=\"box1\"><button class=\"bu1\" onclick=\"window.location.href = 'dept.html';\">现在就去</button>
                    </div>
                    <script>
                        var time = 9;
                        var interval = setInterval(function(){
                            if(time == 0){
                                window.location.href = 'dept.html';
                                clearInterval(this);
                            } else {
                                document.getElementById('box').innerHTML = '部门配置不完整，请先设置一、二级部门<br><span class=\"text1\"><i>' + time + '</i> </span>秒后跳转到<span class=\"text2\"> [部门设置]</span>';
                                time--;
                            }
                        }, 1000);
                    </script>
                ";
            }
            return $this->fetch();
        }

        return $this->rehome;

    }

    // 查看人员
    public function findPersonnel()
    {
        return $this->fetch();
    }

    //部门设置主页
    public function dept()
    {
        $res = db('dept1')->select();
        $res2 = db('dept2')->select();
        $this->assign('dept1data', $res);
        $this->assign('dept2data', $res2);

        return $this->fetch("dept");
    }

    //编辑部门
    public function deptedit()
    {
        if(input("post.action") == "editdept"){
            $level = input("post.level");
            $data = input("post.dept");
            $this->assign("deptlevel", $level);
            $this->assign("deptname", $data);
            return $this->fetch("depteditname");
        }

        if(input("post.action") == "editdeptcomment"){
            $level = input("post.level");
            $data = input("post.dept");
            if($level == 1){
                $comment = db('dept1')->where('dept1', $data)->find()['comment'];
            }
            if($level == 2){
                $comment = db('dept2')->where('dept2', $data)->find()['comment'];
            }
            $this->assign("deptlevel", $level);
            $this->assign("deptname", $data);
            $this->assign("deptcomment", $comment);
            return $this->fetch("depteditcomment");
        }

        if(input("post.action") == "delete"){
            if(input("post.level") == "1"){
                $data = input("post.dept");
                $res = db('dept1')->where('dept1', $data)->delete();
                return $res;
            }
            if(input("post.level") == "2"){
                $data = input("post.dept");
                $res = db('dept2')->where('dept2', $data)->delete();
                return $res;
            }
        }

        if(input("post.action") == "editname"){
            $data = input("post.newname");
            $olddata = input("post.oldname");
            if(input("post.level") == 1){
                $newdata = ['dept1' => $data];
                $res = db('dept1')->where('dept1', $olddata)->update($newdata);
                return $res;
            }
            if(input("post.level") == 2){
                $newdata = ['dept2' => $data];
                $res = db('dept2')->where('dept2', $olddata)->update($newdata);
                return $res;
            }
        }

        if(input("post.action") == "editcomment"){
            $data = input("post.newcomment");
            $deptname = input("post.deptname");
            if(input("post.level") == 1){
                $newdata = ['comment' => $data];
                $res = db('dept1')->where('dept1', $deptname)->update($newdata);
                return $res;
            }
            if(input("post.level") == 2){
                $newdata = ['comment' => $data];
                $res = db('dept2')->where('dept2', $deptname)->update($newdata);
                return $res;
            }
        }

        return $this->rehome;
    }

    //添加部门1
    public function box1()
    {
        if(input('post.type') == "adddept"){
            $ctt = input("post.content");

            $data = [
                'dept1' => $ctt,
                'comment'   =>  '无'
                ];

            $res = db('dept1')->insert($data,true);

            return $res;
        }
        return $this->rehome;

    }

    //添加部门2
    public function box2()
    {
        if(input('post.type') == "adddept"){
            $ctt = input("post.content");

            $data = [
                'dept2' => $ctt,
                'comment'   =>  '无'
                ];

            $res = db('dept2')->insert($data,true);

            return $res;
        }
        return $this->rehome;

    }

    //添加人员
    public function box3()
    {
        if(input("post.types") == "addPersonnel"){
            $datas = input();
            unset($datas['types']);
            $data = [
                'personnel'  =>  $datas['personnel'],
                'phoneticize'  =>  $datas['phoneticize'],
                'sex'  =>  $datas['sex'],
                'dept1'  =>  $datas['dept1'],
                'dept2'  =>  $datas['dept2'],
                'leader'  =>  $datas['leader'],
                'position'  =>  $datas['position'],
                'status'  =>  (int)$datas['statusdm'],
                'time'  =>  date("Y-m-d",strtotime($datas['timedm'])) 

            ];
            $res = db('personnels')->insert($data, true);

            return $res;
        }
        return $this->rehome;

    }

    //修改人员
    public function box4()
    {
        if(input("post.types") == "editPersonnel"){
            $datas = input();
            unset($datas['types']);
            $data = [
                'personnel'  =>  $datas['personnel'],
                'phoneticize'  =>  $datas['phoneticize'],
                'sex'  =>  $datas['sex'],
                'dept1'  =>  $datas['dept1'],
                'dept2'  =>  $datas['dept2'],
                'leader'  =>  $datas['leader'],
                'position'  =>  $datas['position'],
                'status'  =>  (int)$datas['statusdm'],
                'time'  =>  date("Y-m-d",strtotime($datas['timedm'])) 

            ];
            $res = db('personnels')->where('id', $datas['uid'])->update($data);

            return $res;
        }

        if(input("post.types") == "deletePersonnel"){
            $data = input("post.uid");
            $res = db('personnels')->where('id', $data)->delete();
            return $res;
        }

        return $this->rehome;

    }

    //清空部门设置
    public function tcd()
    {
        if(input("post.level") == 1){
            $sql = "truncate table dm_dept1";
            $res = db()->query($sql);
            return $res;
       }

        if(input("post.level") == 2){
            $sql = "truncate table dm_dept2";
            $res = db()->query($sql);
            return $res;
       }

        return $this->rehome;

    }

}