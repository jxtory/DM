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

}
