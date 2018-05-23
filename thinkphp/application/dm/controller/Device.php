<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Device extends Dmbase
{
    public function _initialize()
    {
        parent::_initialize();
        return $this->levelCheck(2);
    }

    public function index()
    {
        $datas = db('devices')->paginate(15);
        $this->assign('datas', $datas);
        return $this->fetch("index");
    }

    public function other()
    {
        return $this->error("尚未开放");
    }

    //添加设备页面
    public function add_device()
    {
        $devicetype = db('devicetype')->select();
        $this->assign("types", $devicetype);
        $brand = db('brand')->select();
        $this->assign("brands", $brand);
        $model = db('model')->select();
        $this->assign("models", $model);
        if(empty($devicetype)){
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
                    <div class=\"box1\"><button class=\"bu1\" onclick=\"window.location.href = 'content.html';\">现在就去</button>
                    </div>
                    <script>
                        var time = 9;
                        var interval = setInterval(function(){
                            if(time == 0){
                                window.location.href = 'content.html';
                                clearInterval(this);
                            } else {
                                document.getElementById('box').innerHTML = '设备类型配置不完整，请先设置设备类型<br><span class=\"text1\"><i>' + time + '</i> </span>秒后跳转到<span class=\"text2\"> [内容设置]</span>';
                                time--;
                            }
                        }, 1000);
                    </script>
            ";            
        }
        return $this->fetch('add_device');
    }

    //编辑设备
    public function editDevice()
    {
        if(input("post.types") == "editDevice"){
            $devicetype = db('devicetype')->select();
            $this->assign("types", $devicetype);
            $brand = db('brand')->select();
            $this->assign("brands", $brand);
            $model = db('model')->select();
            $this->assign("models", $model);
            $ddata = db('devices')->where('id', input('post.did'))->find();
            $this->assign('did', input('post.did'));
            $this->assign('ddata', $ddata);

            if(empty($devicetype)){
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
                        <div class=\"box1\"><button class=\"bu1\" onclick=\"window.location.href = 'content.html';\">现在就去</button>
                        </div>
                        <script>
                            var time = 9;
                            var interval = setInterval(function(){
                                if(time == 0){
                                    window.location.href = 'content.html';
                                    clearInterval(this);
                                } else {
                                    document.getElementById('box').innerHTML = '设备类型配置不完整，请先设置设备类型<br><span class=\"text1\"><i>' + time + '</i> </span>秒后跳转到<span class=\"text2\"> [内容设置]</span>';
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

    //显示内容
    public function content()
    {
        $fdt = db('devicetype')->select();
        $this->assign('devicetypedata', $fdt);

        $fbd = db('brand')->select();
        $this->assign('branddata', $fbd);

        $fml = db('model')->select();
        $this->assign('modeldata', $fml);

    	return $this->fetch('content');
    }

    public function component()
    {
        $components = db('components')->select();
        $this->assign("components", $components);
        return $this->fetch();
    }

    //内容设置处理
    public function handle()
    {
        if(input('post.type') == "add_devicetype"){
            $data = [
                'devicetype' => input('post.content'),
                ];

            $res = db('devicetype')->insert($data,true);

            return $res;
        }

        if(input('post.type') == "add_brand"){
            $data = [
                'brand' => input('post.content'),
                ];

            $res = db('brand')->insert($data,true);

            return $res;
        }

        if(input('post.type') == "add_model"){
            $data = [
                'model' => input('post.content'),
                ];

            $res = db('model')->insert($data,true);

            return $res;
        }

        if(input('post.type') == "add_component"){
            $data = [
                'component' => input('post.content'),
                ];

            $res = db('components')->insert($data,true);

            return $res;
        }

        if(input('post.type') == "edit_devicetype"){
            if(input('post.action') == "editdt"){
                $who = "dt";
                $name = input('post.title');
                $this->assign('who', $who);
                $this->assign('thisname', $name);
                return $this->fetch("editcontentname");
            }

            if(input('post.action') == "delete"){
                $data = input("post.title");
                $res = db('devicetype')->where('devicetype', $data)->delete();
                return $res;
            }
        }

        if(input('post.type') == "edit_brand"){
            if(input('post.action') == "editbd"){
                $who = "bd";
                $name = input('post.title');
                $this->assign('who', $who);
                $this->assign('thisname', $name);
                return $this->fetch("editcontentname");
            }

            if(input('post.action') == "delete"){
                $data = input("post.title");
                $res = db('brand')->where('brand', $data)->delete();
                return $res;
            }
        }

        if(input('post.type') == "edit_model"){
            if(input('post.action') == "editml"){
                $who = "ml";
                $name = input('post.title');
                $this->assign('who', $who);
                $this->assign('thisname', $name);
                return $this->fetch("editcontentname");
            }

            if(input('post.action') == "delete"){
                $data = input("post.title");
                $res = db('model')->where('model', $data)->delete();
                return $res;
            }
        }

        if(input('post.type') == "edit_component"){
            if(input('post.action') == "editcomponent"){
                $who = "component";
                $name = input('post.title');
                $this->assign('who', $who);
                $this->assign('thisname', $name);
                return $this->fetch("editcontentname");
            }

            if(input('post.action') == "delete"){
                $data = input("post.title");
                $res = db('components')->where('component', $data)->delete();
                return $res;
            }
        }

        if(input('post.type') == "edit_content"){
            if(input('post.who') == "dt"){
                $on = input('post.oldname');
                $nn = input('post.newname');
                $newdata = [
                    'devicetype'    =>  $nn
                ];
                $res = db('devicetype')->where('devicetype', $on)->update($newdata);
                return $res;
            }

            if(input('post.who') == "bd"){
                $on = input('post.oldname');
                $nn = input('post.newname');
                $newdata = [
                    'brand'    =>  $nn
                ];
                $res = db('brand')->where('brand', $on)->update($newdata);
                return $res;
            }

            if(input('post.who') == "ml"){
                $on = input('post.oldname');
                $nn = input('post.newname');
                $newdata = [
                    'model'    =>  $nn
                ];
                $res = db('model')->where('model', $on)->update($newdata);
                return $res;
            }

            if(input('post.who') == "component"){
                $on = input('post.oldname');
                $nn = input('post.newname');
                $newdata = [
                    'component'    =>  $nn
                ];
                $res = db('components')->where('component', $on)->update($newdata);
                return $res;
            }
        }

        return $this->rehome;
    }

    //添加设备
    public function devicehandle()
    {
        if(input("post.types") == "addDevice"){
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
            $res = db('devices')->insert($data, true);

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

    public function repeatcheck()
    {
        $who = input("post.ds_an");
        $res = db('devices')->where('an', $who)->find();
        if(empty($res)){
            return true;
        } else {
            return false;
            // exit( "false" );
        }

        return $this->rehome;

    }

}
