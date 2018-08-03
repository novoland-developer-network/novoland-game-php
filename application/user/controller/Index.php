<?php
/**
 * Index.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 16:22
 * Doing good deeds without asking for reward
 */

namespace app\user\controller;

use app\user\model\User;
use \Error;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;

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
		if ( !empty(Session::get('user')) && !empty(Session::get('user.user_id')) ) {
			$this->redirect("/");
		}
		
		return $this->fetch();
	}
	
	/**
	 * 登录操作
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function login ()
	: array
	{
		try {
			// 参数过滤
			$params = Request::instance()
			                 ->param();
			$validate = Loader::validate('user');
			if ( !$validate->scene('login')
			               ->check($params) ) throw new Error($validate->getError(), 10301);
			
			// 登录验证
			$result = (new User())->login($params['username'], $params['password']);
			if ( $result['code'] !== 0 ) throw new Error($result['msg'], $result['code']);
			
			Session::set('user', $result['data']);
			
			return $result;
		} catch ( Error $e ) {
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
	
	/**
	 * 注册操作
	 * @return array
	 * @throws \think\Exception
	 */
	public function register ()
	: array
	{
		try {
			// 过滤参数
			$params = Request::instance()
			                 ->param();
			$validate = Loader::validate('User');
			
			if ( !$validate->scene('register')
			               ->check($params) ) throw new Error($validate->getError(), 10311);
			
			unset($params['repassword'], $params['captcha']);
			
			// 注册
			$result = (new User)->register($params);
			
			if ( $result['code'] !== 0 ) throw new Error($result['msg'], $result['code']);
			
			return $result;
		} catch ( Error $error ) {
			return [
				'code' => $error->getCode(),
				'msg'  => $error->getMessage(),
				'data' => null
			];
		}
	}
	
	/**
	 * 退出登录
	 * @throws \think\Exception
	 */
	public function logout ()
	{
		// 清除session（当前作用域）
		Session::clear();
		// 清除think作用域
		Session::clear('think');
		// 清除当前请求有效的session
		Session::flush();
		$this->redirect('/');
	}
}