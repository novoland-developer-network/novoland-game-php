<?php
/**
 * Index.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 16:22
 * Doing good deeds without asking for reward
 */

namespace app\user\controller;

use think\Controller;

/**
 * 用户控制器
 * @package app\user\controller
 */
class Index extends Controller
{
	/**
	 * 登录
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function index ()
	{
		return $this->fetch();
	}
	
	public function login ()
	{
	
	}
}