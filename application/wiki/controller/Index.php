<?php
namespace app\wiki\controller;

use think\Controller;

class Index extends Controller
{
	/**
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function index()
    {
		return $this->fetch();
    }
}
