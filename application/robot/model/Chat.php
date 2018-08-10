<?php
/**
 * Name: Chat.php-novoland
 * Author: lidongyun@shuwang-tech.com
 * Date: 2018/8/10
 * Time: 16:37
 */

namespace app\robot\model;

use think\Model;

/**
 * 聊天记录类
 * Class Chat
 * @package app\robot\model
 */
class Chat extends Model
{
	/**
	 * @param $data
	 * @return bool
	 * @throws \think\Exception
	 * @throws \think\db\exception\BindParamException
	 * @throws \think\exception\PDOException
	 */
	public static function put ($data)
	: bool
	{
		$result = (new Chat($data))->save();
		
		return ! !$result;
	}
}