<?php
/**
 * Created by PhpStorm.
 * User: ch4o5
 * Date: 18-7-18
 * Time: 下午9:28
 */

namespace app\robot\controller;

use think\worker\Server;

/**
 * Class Worker
 * WorkerMan-Socket控制器
 * @package app\robot\controller
 */
class Worker extends Server
{
	protected $socket = 'websocket://novoland.game:9999';
	
	/**
	 * 收到信息
	 * @param $connection
	 * @param $data
	 */
	public function onMessage ($connection, $data)
	{
		$result = Api::send($data);
		$connection->send($result);
	}
	
	/**
	 * 当连接建立时触发的回调函数
	 * @param $connection
	 */
	public function onConnect ($connection)
	{
	
	}
	
	/**
	 * 当连接断开时触发的回调函数
	 * @param $connection
	 */
	public function onClose ($connection)
	{
	
	}
	
	/**
	 * 当客户端的连接上发生错误时触发
	 * @param $connection
	 * @param $code
	 * @param $msg
	 */
	public function onError ($connection, $code, $msg)
	{
		echo "error $code $msg\n";
	}
	
	/**
	 * 每个进程启动
	 * @param $worker
	 */
	public function onWorkerStart ($worker)
	{
	
	}
}