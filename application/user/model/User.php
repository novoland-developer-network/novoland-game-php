<?php
/**
 * User.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 21:01
 * Doing good deeds without asking for reward
 */

namespace app\user\model;

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
	
	public function login (string $username,string $password)
	{
		try{
			$usr = $this->where('username', $username)->find();
			if (empty($user))   throw new \Error('用户不存在',10101);
			
			$psd = \md5(\md5($password) . 'novoland') === $usr['password'];
			if (!$psd)  throw new \Error('密码错误',10102);
			
			return [
				'code' => 0,
				'msg' => '登录成功'
			];
		}catch (\Error $e){
			return [
				'code' => $e->getCode(),
				'msg' => $e->getMessage()
			];
		}
	}
}