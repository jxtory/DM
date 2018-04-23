<?php
namespace app\dm\controller;
use think\Controller;
use think\Db;
use think\Validate;
use think\Loader;
class Dmbase extends Controller
{
	protected $dbUser = [
		'type'	=>	'mysql',
		'hostname'	=>	'127.0.0.1',
		'database'	=>	'test',
		'username'	=>	'root',
		'password'	=>	'',
		'charset'	=>	'utf8',
		'prefix'	=>	'dm_'
	];

	public function _initialize()
	{
		if(){
			
		}
	}

}
