<?php
namespace app\dm\controller;

class Passport extends Dmbase
{
	public function _initialize()
	{
		return;
	}

    public function login()
    {
        return $this->fetch("");
    }

    public function register()
    {
    	return $this->fetch("");
    }

    public function logout()
    {
        session(null);
        $this->success('退出成功！', 'passport/login');
    }

}
