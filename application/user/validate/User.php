<?php
/**
 * User.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 16:11
 * Doing good deeds without asking for reward
 */

namespace app\user\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username'=>'require|alphaDash',
		'password' => ''
	];
}