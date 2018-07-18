<?php
/**
 * Created by PhpStorm.
 * User: ch4o5
 * Date: 18-7-18
 * Time: 下午11:38
 */

namespace app\robot\controller;


use think\Controller;

class Index extends Controller
{
	public function index ()
	{
		$client_id = password_hash(time() . $_SERVER['REMOTE_ADDR'], PASSWORD_DEFAULT);
		
		$this->assign('client_id', $client_id);
		
		return $this->fetch();
	}
}