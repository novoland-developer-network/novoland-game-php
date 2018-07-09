<?php

namespace app\wiki\controller;

use think\Controller;
use think\Session;
use think\Url;

/**
 * wiki
 * Class Index
 * @package app\wiki\controller
 */
class Index extends Controller
{
	/**
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function index ()
	{
		if ( empty(Session::get('user')) || empty(Session::get('user.user_id')) ) {
			$this->redirect(Url::build('User/Index/index'));
			
			return false;
		}
		
		return $this->fetch();
	}
}
