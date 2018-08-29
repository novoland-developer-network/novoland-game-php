<?php

namespace app\wiki\controller;

use think\Config;
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
	protected function _initialize ()
	{
		parent::_initialize();
		$this->assign('ws_chat',Config::get('ws.chat'));
		$this->assign('ws_unit',Config::get('ws.unit'));
	}
	
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
		
		$this->assign(Session::get('user'));
		
		return $this->fetch();
	}
}
