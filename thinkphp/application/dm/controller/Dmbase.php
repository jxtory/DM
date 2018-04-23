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
		//检查数据库是否准备好
		$this->initcheck();

	}

	private function initcheck()
	{
		//通过原生数据库连接方法
		$dmkey = [
			'host'	=>	'127.0.0.1',
			'user'	=>	'root',
			'pass'	=>	'',
		];
		//连接数据库库
		$link = @mysqli_connect(
			$dmkey['host'],
			$dmkey['user'],
			$dmkey['pass']
		);
		//连接检测！
		if (!$link) {
			printf("ROOM: 数据库错误！");
			echo "<br>";
		    printf("Connect failed: [Errno] %s\n", mysqli_connect_errno());
		    echo "<br>";
		    printf("Connect failed: [Error] %s\n", mysqli_connect_error());
		    die("\n");
		}
		//查询库
		$sql = "show databases";
		$dbname = [];
		//遍历并记录所有库名
		if($res = $link->query($sql)){
			while ($row = $res->fetch_assoc()) {
				if($row['Database'] == "dm" || $row['Database'] == "uc"){
					// $dbname[$row['Database']] = true;
					$dbname[] = $row['Database'];
				}
			}
			$res->close();
		} else {
			printf("ROOM: 检测库时出现错误！");
			$res->close();
			die("\n");
		}

		//查询完毕，关闭数据库
		$link->close();

		//判断是否可以正常运行程序
		// if(isset($dbname['dm']) && isset($dbname['uc'])){
		if(in_array("dm", $dbname) && in_array("uc", $dbname)){
			return "ok, Start Service";
		} else {
			if(!in_array("dm", $dbname)){
				//创建数据库连接
				$createdm = @mysqli_connect(
					$dmkey['host'],
					$dmkey['user'],
					$dmkey['pass']
				);

				//连接检测！
				if (!$createdm) {
					printf("ROOM: 数据库错误！无法继续运行程序，请检查!");
					echo "<br>";
				    printf("Connect failed: [Errno] %s\n", mysqli_connect_errno());
				    echo "<br>";
				    printf("Connect failed: [Error] %s\n", mysqli_connect_error());
				    die("\n");
				}

				//创建DM库并导入数据
				$sql = "CREATE DATABASE IF NOT EXISTS `dm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
				$_sql = file_get_contents(__DIR__ . "\../dm.sql");
				$_sql = preg_replace('/--.*/i', '', $_sql);
				$_sql = preg_replace('/\/\*.*\*\/(\;)?/i', '', $_sql);
				// dump($_sql);
				$_arr = explode(";", $_sql);
				// dump($_arr);
				if($res = $createdm->query($sql)){
					$sql = "use dm";
					$createdm->query($sql);
					foreach ($_arr as $value) {
						$r = $createdm->query($value . ";");
					}
				}

				$createdm->close();

			}

			if(!in_array("uc", $dbname)){
				//创建数据库连接
				$createuc = @mysqli_connect(
					$dmkey['host'],
					$dmkey['user'],
					$dmkey['pass']
				);

				//连接检测！
				if (!$createuc) {
					printf("ROOM: 数据库错误！无法继续运行程序，请检查!");
					echo "<br>";
				    printf("Connect failed: [Errno] %s\n", mysqli_connect_errno());
				    echo "<br>";
				    printf("Connect failed: [Error] %s\n", mysqli_connect_error());
				    die("\n");
				}

				//创建UC库并导入数据
				$sql = "CREATE DATABASE IF NOT EXISTS `uc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
				$_sql = file_get_contents(__DIR__ . "\../uc.sql");
				$_sql = preg_replace('/--.*/i', '', $_sql);
				$_sql = preg_replace('/\/\*.*\*\/(\;)?/i', '', $_sql);
				// dump($_sql);
				$_arr = explode(";", $_sql);
				// dump($_arr);
				if($res = $createuc->query($sql)){
					$sql = "use uc";
					$createuc->query($sql);
					foreach ($_arr as $value) {
						$r = $createuc->query($value . ";");
					}
				}

				$createuc->query("INSERT INTO uc_user (username, password) value('admin', md5('admin'))");

				$createuc->close();
			}
		}

	}
}
