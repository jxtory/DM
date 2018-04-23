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
		$dmkey = [
			'host'	=>	'127.0.0.1',
			'user'	=>	'root',
			'pass'	=>	'',
		];

		$link = @mysqli_connect(
			$dmkey['host'],
			$dmkey['user'],
			$dmkey['pass']
		);

		if (!$link) {
			printf("ROOM: 数据库错误！");
			echo "<br>";
		    printf("Connect failed: [Errno] %s\n", mysqli_connect_errno());
		    echo "<br>";
		    printf("Connect failed: [Error] %s\n", mysqli_connect_error());
		    die("\n");
		}

		$res = $link->query("show databases");
		$row = $res->fetch_all(MYSQLI_NUM);
		$res->close();
		foreach ($row as $key => $value) {
			// echo $row[$key][0];
			dump($value);

		}

		/* If we have to retrieve large amount of data we use MYSQLI_USE_RESULT */
		if ($result = $mysqli->query("SELECT * FROM City", MYSQLI_USE_RESULT)) {

		    /* Note, that we can't execute any functions which interact with the
		       server until result set was closed. All calls will return an
		       'out of sync' error */
		    if (!$mysqli->query("SET @a:='this will not work'")) {
		        printf("Error: %s\n", $mysqli->error);
		    }
		    $result->close();
		}

		$link->close();
	}
}
