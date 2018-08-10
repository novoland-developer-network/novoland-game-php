<?php
/**
 * Created by PhpStorm.
 * User: ch4o5
 * Date: 18-7-18
 * Time: 下午9:28
 */

namespace app\robot\controller;

use app\robot\model\Chat as ChatModel;
use think\worker\Server;

/**
 * WorkerMan-chat-Socket控制器
 * Class Worker
 * @package app\robot\controller
 */
class Chat extends Server
{
	const HEARTBEAT_TIME = 55;
	
	protected $socket    = 'websocket://0.0.0.0:4619';
	protected $processes = 1;
	
	/**
	 * 收到信息
	 * @param $connection
	 * @param $data
	 * @return void
	 */
	public function onMessage ($connection, $data)
	: void
	{
		// $connection->lastMessageTime = time();
		if ( !isset($connection->uid) ) {
			// 没验证的话把第一个包当做uid，即客户端发送过来的uuid
			$connection->uid = $data;
			// 保存uid到connection的映射，这样可以方便的通过uid查找connection，实现针对特定uid推送数据
			$this->worker->uidConnections[ $connection->uid ] = $connection;
			list($username) = \explode(' ', $connection->uid);
			$this->sendAll(1, $connection->uid . '来了', [ $username ]);
			
			return;
		}
		list($username, $user_id) = \explode(' ', $connection->uid);
		// uid 为 all 时是全局广播
		list($rec_uid, $message) = explode(':', $data);
		// 全局广播
		if ( $rec_uid === 'all' ) {
			$put_res = ChatModel::put([ 'user_id' => $user_id, 'content' => $message, 'chat_id' => 0 ]);
			$this->sendAll(0, '', [
				'username' => $username,
				'content'  => $message,
				'time'     => \date('m-d H:i:s'),
				'uuid'     => $connection->uid
			]);
			
			return;
		}
		// 给特定uid发送
		else {
			list($rec_username, $rec_user_id) = \explode(' ', $rec_uid);
			
			$this->sendTo($rec_uid, $message, $connection, [
				'username'     => $username,
				'content'      => $message,
				'time'         => \date('m-d H:i:s'),
				'uuid'         => $rec_uid,
				'rec_username' => $rec_username
			]);
			ChatModel::put([ 'user_id' => $user_id, 'content' => $message, 'chat_id' => $rec_user_id ]);
			
			return;
		}
	}
	
	/**
	 * 全局广播
	 * @param int        $code
	 * @param string     $msg
	 * @param array|null $data
	 */
	private function sendAll (int $code, string $msg, ?array $data = null)
	: void
	{
		foreach ( $this->worker->uidConnections as $uid_connection => $connection ) {
			if ( isset($data['uuid']) && !empty($data['uuid']) ) {
				$data['color'] = $data['uuid'] !== $uid_connection
					? '#5FB878'
					: '#000';
			}
			
			$array = [
				'code' => $code,
				'msg'  => $msg,
				'data' => $data
			];
			$json = \json_encode($array);
			$connection->send($json);
		}
	}
	
	private function sendTo (string $rec_uid, string $msg, $connection, ?array $data = null)
	: void
	{
		$data['color'] = '#FF5722';
		$data['uuid'] = $connection->uid;
		$data['username'] .= '私聊你';
		$data_self = $data;
		$data_self['color'] = '#c2c2c2';
		$data_self['username'] = '发送给' . $data_self['rec_username'];
		if ( isset($this->worker->uidConnections[ $rec_uid ]) ) {
			$connection_to = $this->worker->uidConnections[ $rec_uid ];
			$connection_to->send(\json_encode([
				                                  'code' => 3,
				                                  'msg'  => $msg,
				                                  'data' => $data
			                                  ]));
			$connection->send(\json_encode([
				                               'code' => 3,
				                               'msg'  => $msg,
				                               'data' => $data_self
			                               ]));
			
			return;
		}
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
		$this->sendAll(2, \explode(' ', $connection->uid)[0] . '已下线');
		if ( isset($connection->uid) ) {
			// 连接断开时删除映射
			unset($this->worker->uidConnections[ $connection->uid ]);
		}
	}
	
	/**
	 * 当客户端的连接上发生错误时触发
	 * @param $connection
	 * @param $code
	 * @param $msg
	 */
	public function onError ($connection, $code, $msg)
	{
	
	}
	
	/**
	 * 每个进程启动
	 * @param $worker
	 */
	public function onWorkerStart ($worker)
	{
		/*Timer::add(1, function () use ($worker) {
			$time_now = time();
			foreach ( $worker->connections as $connection ) {
				// 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
				if ( empty($connection->lastMessageTime) ) {
					$connection->lastMessageTime = $time_now;
					continue;
				}
				// 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
				if ( $time_now - $connection->lastMessageTime > self::HEARTBEAT_TIME ) {
					$connection->close();
				}
			}
		});*/
	}
}