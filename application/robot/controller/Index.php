<?php
/**
 * Created by PhpStorm.
 * User: ch4o5
 * Date: 18-7-18
 * Time: 下午11:38
 */

namespace app\robot\controller;

use think\Config;
use think\Controller;

/**
 * 机器人训练控制器
 * @package app\robot\controller
 */
class Index extends Controller
{
	/**
	 * 渲染聊天页面
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function index ()
	{
		$client_id = password_hash(time() . $_SERVER['REMOTE_ADDR'], PASSWORD_DEFAULT);
		
		$this->assign('ws_unit',Config::get('ws.unit'));
		$this->assign('client_id', $client_id);
		
		return $this->fetch();
	}
}