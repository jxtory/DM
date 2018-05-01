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
                switch ($authlevel['authlevel']) {
                    case 0:
                        $aln = "审核中";
                        break;
                    case 1:
                        $aln = "浏览者";
                        break;
                    case 2:
                        $aln = "管理员";
                        break;
                    case 3:
                        $aln = "超级管理员";
                        break;
                    
                    default:
                        $aln = "未知";
                        break;
                }
            }

            $this->assign('aln', $aln);

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

        }

        if(input("post.types") == "deleteUser"){
            $data = input("post.uid");
            $res = db('user a, auth b', $this->dbUser)->where('id', $data)->delete();
            return $res;
        }

        return $this->rehome;
    }

    public function test()
    {
        $sql = db("user, uc_auth", $this->dbUser)
            // ->table("uc_user a, uc_auth b")
            ->using("uc_user, uc_auth")
            ->where("uc_user.id = uc_auth.uid")
            ->where("uc_user.id = 3")
            ->fetchSql(true)
            ->delete();

        // $res = db("", $this->dbUser)->query($sql);

        return dump($sql);
    }

}
