<?php
namespace app\dm\controller;
use think\captcha;

class Passport extends Dmbase
{
	public function _initialize()
	{
		return;
	}

    public function login()
    {
        if(request()->isPost()){
            $data = input('post.');
            // if(!captcha_check($data['captcha'])){
            //     $this->error("验证码错误");
            //  //验证失败
            // };
            $user = db('user', $this->dbUser)->where('username', $data['username'])->find();
            if($user){
                if($user['password'] == md5($data['password'])){
                    $loginsum = ['loginsum' =>  $user['loginsum'] + 1, "loginlast" => date('Y-m-d H:i:s')];
                    $loginsum = db('user', $this->dbUser)->where("id", $user['id'])->update($loginsum);
                    session("username", $data['username']);
                    session("uid", $user['id']);
                    session("loginsum", $loginsum + 1);
                    $this->success('登陆成功', 'index/index');
                } else {
                    $this->error("用户名或密码不正确！");
                }

            } else {
                $this->error("用户名或密码不正确！");
            }
            // $this->success('登陆成功', 'index/index');
        }
        return $this->fetch("");
    }

    public function register()
    {
        if(request()->isPost()){
            $datas = input('post.');
            if(!captcha_check($datas['captcha'])){
                $this->error("验证码错误");
             //验证失败
            };

            if(db('user', $this->dbUser)->where("username", $datas['username'])->find()){
                return $this->error("账户已存在!", "passport/register");
            }

            $data = [
                'username'      =>      input('post.username'),
                'password'      =>      md5(input('post.password')),
                'createdate'    =>      date('Y-m-d'),
            ];

            $user = db('user', $this->dbUser)->insert($data);

            $data_auth = [
                'uid'       =>      db('user', $this->dbUser)->getLastInsID(),
                'authlevel' =>      0
            ];

            $userauth = db('auth', $this->dbUser)->insert($data_auth);
            if($user){
                $this->success("注册成功·立即跳转到登陆页面", "passport/login");
            } else {
                $this->error("注册失败", "passport/register");
            }            
        }
    	return $this->fetch("");
    }

    public function nopassport()
    {
        return $this->fetch("");
    }

    public function logout()
    {
        session(null);
        $this->success('退出成功！', 'passport/login');
    }

}
