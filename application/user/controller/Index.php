<?php
/**
 * Index.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 16:22
 * Doing good deeds without asking for reward
 */

namespace app\user\controller;

use app\user\model\User;
use think\Controller;
use think\Loader;
use think\Request;

/**
 * 用户控制器
 * @package app\user\controller
 */
class Index extends Controller
{
	/**
	 * 登录页面
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function index ()
	{
		return $this->fetch();
	}
	
	/**
	 * login
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function login ()
	{
		try {
			// 参数过滤
			$params = Request::instance()
			                 ->param();
			$validate = Loader::validate('user');
			if ( !$validate->scene('login')
			               ->check($params) ) throw new \Error($validate->getError(), 10301);
			
			// 登录验证
			$result = (new User())->login($params['username'], $params['password']);
			if ( $result['code'] !== 0 ) throw new \Error($result['msg'], $result['code']);
			
			return $result;
		} catch ( \Error $e ) {
			return [
				'data' => null,
				'code' => $e->getCode(),
				'msg'  => $e->getMessage()
			];
		}
	}
	
	/**
	 * 注册页面
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function signIn ()
	{
		return $this->fetch();
	}
}