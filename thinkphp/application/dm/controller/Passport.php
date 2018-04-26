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
                    session("username", $data['username']);
                    session("uid", $user['id']);
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
            if(!captcha_check($data['captcha'])){
                $this->error("验证码错误");
             //验证失败
            };
            $data = [
                'username'      =>      input('post.username'),
                'password'      =>      md5(input('post.password')),
                'createdate'    =>      now(),
            ];

            $user = db('user', $this->dbUser)->insert($data);
            if($user){
                $this->success("注册成功·立即跳转到登陆页面", "passport/login");
            } else {
                $this->error("注册失败", "passport/register");
            }            
        }
    	return $this->fetch("");
    }

    public function logout()
    {
        session(null);
        $this->success('退出成功！', 'passport/login');
    }

}
