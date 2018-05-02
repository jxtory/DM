<?php
namespace app\dm\controller;
use app\dm\controller\Dmbase;

class Usercenter extends Dmbase
{
    public function index()
    {
        $this->levelCheck(2);
    	$datas = db("user a", $this->dbUser)
            ->field("a.*, b.uid, b.authlevel")
    		->join("auth b", "a.id = b.uid")
            ->paginate(15);

        $this->assign("datas", $datas);
    	return $this->fetch("");

    }

    public function lookAuth()
    {
        return $this->fetch("");
    }

    public function cpw()
    {
        if(request()->isPost()){
            $datas = input('post.');
            if(!captcha_check($datas['captcha'])){
                $this->error("验证码错误");
             //验证失败
            };

            $data = [
                'password'      =>      md5($datas['password'])
            ];

            $user = db('user', $this->dbUser)->where('username', session('username'))->update($data);

            if($user){
                $this->success("修改成功", "passport/login");
            } else {
                $this->error("修改失败", "passport/register");
            }
        }

        if(session('username')){
            $this->assign('username', session('username'));
            return $this->fetch();
        }
        return $this->rehome;
    }

    public function editUser()
    {
        if(input('post.types') == "editUser"){
            $this->assign('uid', input('post.uid'));
            $data = db('user', $this->dbUser)->where('id', input('post.uid'))->find();
            $this->assign('username', $data['username']);

            if($authlevel = db("auth", $this->dbUser)->field('authlevel')->where('uid', input('post.uid'))->find()){
                $this->assign('aln', $authlevel['authlevel']);
            }

            if($data['username'] == "admin"){
                return $this->fetch("noeditadmin");
            }

            return $this->fetch();
        }

        return $this->rehome;
    }

    public function userHandle()
    {
        if(input('post.types') == 'editUser'){
            $datas = input();
            unset($datas['types']);
            $data = [
                "authlevel" =>  $datas['authlevel']
            ];
            $res = db("auth", $this->dbUser)->where("uid", $datas['uid'])->update($data);

            return $res;
        }

        if(input("post.types") == "resetUserPassword"){
            $datas = input();
            unset($datas['types']);
            $newpassword = $this->generate_password();
            $data = [
                "password"  =>  md5($newpassword)
            ];

            
            if($res = db("user", $this->dbUser)->where("id", $datas['uid'])->update($data)){
                return $newpassword;
            }

            return null;
        }

        if(input("post.types") == "deleteUser"){
            $userid = input("post.uid");
            $res = db("user, uc_auth", $this->dbUser)
                // ->table("uc_user a, uc_auth b")
                ->using("uc_user, uc_auth")
                ->where("uc_user.id = uc_auth.uid")
                ->where("uc_user.id = " . $userid)
                ->delete();

            return $res;
        }

        return $this->rehome;
    }

    private function generate_password($length = 8) 
    { 
        // 密码字符集，可任意添加你需要的字符 
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|'; 
        $password = ""; 
        for ($i = 0; $i < $length; $i++){ 
            // 这里提供两种字符获取方式 
            // 第一种是使用 substr 截取$chars中的任意一位字符； 
            // 第二种是取字符数组 $chars 的任意元素 
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
        } 
        return $password; 
    } 

}
