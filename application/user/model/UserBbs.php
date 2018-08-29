<?php
/**
 * UserBbs.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/8/28 17:44
 * Doing good deeds without asking for reward
 */

namespace app\user\model;

use think\Exception;
use think\Model;

/**
 * 用户论坛关联表
 * Class UserBbs
 * @package app\user\model
 */
class UserBbs extends Model
{
	// 关闭自动写入时间戳
	protected $autoWriteTimestamp = false;
	
	/**
	 * 绑定BBS账户
	 * bindAccount
	 * @param string $username
	 * @param string $bbs_id
	 * @return false|int
	 * @throws \think\Exception
	 * @throws \think\db\exception\BindParamException
	 * @throws \think\exception\PDOException
	 */
	public function bindAccount (string $username,string $bbs_id)
	{
		$user_id = (new User())->where('username', 'eq', $username)->find()->user_id;
		$result = (new UserBbs([
			'user_id' => $user_id,
			'bbs_email' => $bbs_id
		                       ]))->save();
		return $result;
	}
	
	/**
	 * 判断论坛账户是否存在
	 * issetAccount
	 * @param string $bbs_id
	 * @return bool
	 * @throws \think\exception\DbException
	 */
	public function issetAccount (string $bbs_id):bool
	{
		$total = $this->where('bbs_email', 'eq', $bbs_id)
		              ->count();
		
		return $total === false || $total === 0 || $total === '0'
			? false
			: true;
	}
}