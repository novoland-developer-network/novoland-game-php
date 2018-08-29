<?php
/**
 * User.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 21:01
 * Doing good deeds without asking for reward
 */

namespace app\user\model;

use Error;
use Exception;
use think\db\exception\{
	DataNotFoundException, ModelNotFoundException
};
use think\exception\DbException;
use think\Model;
use traits\model\SoftDelete;

/**
 * 用户模型
 * Class User
 * @package app\user\model
 */
class User extends Model
{
	protected $pk = 'user_id';
	
	use SoftDelete;
	/** @var string 开启软删除 */
	protected $deleteTime = 'delete_time';
	
	/** @var bool 开启自动写入时间戳字段 */
	protected $autoWriteTimestamp = true;
	
	/** @var string 定义时间戳字段名 */
	protected $createTime = 'create_time';
	protected $updateTime = 'update_time';
	
	/**
	 * login
	 * @param string $username
	 * @param string $password
	 * @return array
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function login (string $username, string $password)
	{
		try {
			$userInfo = self::issetUser($username);
			if ( empty($userInfo) ) throw new Error('用户不存在', 10101);
			
			$res = \password_verify($password, $userInfo['password']);
			if ( !$res ) throw new Error('密码错误', 10102);
			
			return [
				'data' => $userInfo,
				'code' => 0,
				'msg'  => '验证成功，正在和九州进行连接。<br>祝你好运，铁甲依然在！'
			];
		} catch ( Error $e ) {
			return [
				'code' => $e->getCode(),
				'msg'  => $e->getMessage()
			];
		}
	}
	
	/**
	 * 判断用户是否存在
	 * @param string $username
	 * @return array|null
	 * @throws \think\Exception
	 * @throws \think\db\exception\DataNotFoundException
	 * @throws \think\db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	private static function issetUser (string $username)
	: ?array
	{
		$usr = (new User())->where('username', $username)
		                   ->find();
		if ( empty($usr) ) return null;
		else return $usr->toArray();
	}
	
	/**
	 * 注册操作
	 * @param array $user
	 * @return array|null
	 */
	public function register (array $user)
	: ?array
	{
		try {
			$isset = self::issetUser($user['username']);
			if ( $isset ) throw new Error('用户已存在', 10111);
			$user['password'] = \password_hash($user['password'], PASSWORD_DEFAULT);
			$result = $this->data($user)
			               ->save();
			
			if ( $result <= 0 ) throw new Error('辰月出征，寸草不生', 10112);
			
			return [
				'data' => $result,
				'code' => 0,
				'msg'  => '信息已录入！<br>欢迎进入九州，请准备登录<br>星辰在上，指引你的道路！'
			];
		} catch ( Error $error ) {
			return [
				'data' => null,
				'code' => $error->getCode(),
				'msg'  => $error->getMessage()
			];
		} catch ( DataNotFoundException $e ) {
			return [
				'data' => null,
				'code' => 10113,
				'msg'  => $e->getMessage()
			];
		} catch ( ModelNotFoundException $e ) {
			return [
				'data' => null,
				'code' => 10114,
				'msg'  => $e->getMessage()
			];
		} catch ( DbException $e ) {
			return [
				'data' => null,
				'code' => 10115,
				'msg'  => $e->getMessage()
			];
		} catch ( Exception $e ) {
			return [
				'data' => null,
				'code' => 10116,
				'msg'  => $e->getMessage()
			];
		}
	}
}