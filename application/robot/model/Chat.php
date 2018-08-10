<?php
/**
 * Name: Chat.php-novoland
 * Author: lidongyun@shuwang-tech.com
 * Date: 2018/8/10
 * Time: 16:37
 */

namespace app\robot\model;

use think\db\exception\BindParamException;
use think\Exception;
use think\exception\PDOException;
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
	 */
	public static function put ($data)
	: bool
	{
		try {
			$result = (new Chat($data))->save();
			if ($result !== false) throw new \Error();
			return true;
		} catch ( BindParamException|PDOException|Exception|\Error $e ) {
			return false;
		}
	}
}