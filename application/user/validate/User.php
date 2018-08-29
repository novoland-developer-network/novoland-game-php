<?php
/**
 * User.php-novoland
 * By lidongyun@shuwang-tech.com
 * On 2018/7/4 16:11
 * Doing good deeds without asking for reward
 */

namespace app\user\validate;

use think\Validate;

/**
 * 用户验证类
 * Class User
 * @package app\user\validate
 */
class User extends Validate
{
	protected $rule = [
		'username'   => 'require|chsDash',
		'password'   => 'require|alphaDash|confirm:repassword',
		'repassword' => 'require',
		'mobile'     => 'number',
		'email'      => 'email',
		'qq'         => 'require|number|min:8|max:12',
		'captcha'    => 'require|captcha'
	];
	
	protected $scene = [
		'login' => [
			'username',
			'password' => 'require|alphaDash'
		],
		'register' => [
			'username',
			'password',
			'repassword',
			'mobile',
			'email',
			'qq',
			'captcha'
		]
	];
	
	protected $field = [
		'username'   => '用户名',
		'password'   => '密码',
		'repassword' => '确认密码',
		'mobile'     => '手机号',
		'email'      => '电子邮箱',
		'qq'         => 'QQ号',
		'captcha'    => '验证码'
	];
}