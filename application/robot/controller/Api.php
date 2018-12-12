<?php
/**
 * Created by PhpStorm.
 * User: ch4o5
 * Date: 18-7-19
 * Time: 上午12:59
 */

namespace app\robot\controller;

use Error;
use think\Controller;

/**
 * Class Api
 * 百度Unit2.0API调用控制器
 * @package app\robot\controller
 */
class Api extends Controller
{
	
	const API_KEY    = 'zVpKfGMvZpCoZphyiqTvlv9X';
	
	const SECRET_KEY = 'HNneE5cozx9f7VE4BnM7PtuudOVYv7NZ';
	
	private static $url          = 'https://aip.baidubce.com/rpc/2.0/unit/bot/chat';
	private static $aturl        = 'https://aip.baidubce.com/oauth/2.0/token';
	private static $access_token = '';
	
	/**
	 * 发送事件
	 * @param $content
	 * @return bool|mixed
	 */
	public static function send ($content)
	{
		$array = explode('!@#$%', $content);
		$token = self::setAccessToken();
		$url = self::$url . '?access_token=' . $token;
		$request = json_encode([
			                       'version'     => '2.0',
			                       'bot_id'      => '7519',
			                       'log_id'      => $array[1],
			                       'request'     => [
				                       'user_id'        => 'UNIT_DEV_秋戟',
				                       'query'          => $array[0],
				                       'query_info'     => [
					                       'type'   => 'TEXT',
					                       'source' => 'KEYBOARD',
				                       ],
				                       'client_session' => json_encode([
					                                                       'client_results'    => '',
					                                                       'candidate_options' => []
				                                                       ]),
				                       'bernard_level'  => 1
			                       ],
			                       'bot_session' => \json_encode(['session_id'=>$array[1]])
		                       ]);
		
		try {
			$res = \json_decode(self::request_post($url, $request));
			
			// return \json_encode($res);
			if ( $res->error_code !== 0 ) throw new Error('功能暂时无法使用，请稍后刷新页面并重试，如果总这样，请提供错误码给刀哥或乱世人魔', 30001);
			
			$final_res = $res->result->response->action_list[0]->say;
			return $final_res === '我不知道应该怎么答复您。'?'我不知道应该怎么答复您。请换个方式回答或者刷新后重新测试':$final_res;
		} catch ( Error $error ) {
			return '[Error::' . $error->getCode() . ']' . $error->getMessage();
		}
	}
	
	/**
	 * 设置token
	 * @return bool|mixed
	 */
	private static function setAccessToken ()
	{
		$post_data['grant_type'] = 'client_credentials';
		$post_data['client_id'] = self::API_KEY;
		$post_data['client_secret'] = self::SECRET_KEY;
		$o = "";
		foreach ( $post_data as $k => $v ) {
			$o .= "$k=" . urlencode($v) . "&";
		}
		$post_data = substr($o, 0, -1);
		
		$res = self::request_post(self::$aturl, $post_data);
		
		return json_decode($res)->access_token;
	}
	
	/**
	 * 发起http post请求(REST API), 并获取REST请求的结果
	 * @param string $url
	 * @param string $param
	 * @return bool|mixed - http response body if succeeds, else false.
	 */
	public static function request_post ($url = '', $param = '')
	{
		if ( empty($url) || empty($param) ) {
			return false;
		}
		$postUrl = $url;
		
		$curlPost = $param;
		
		// 初始化curl
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $postUrl);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		// 要求结果为字符串且输出到屏幕上
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		// post提交方式
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		// 运行curl
		$data = curl_exec($curl);
		curl_close($curl);
		
		return $data;
	}
	
	/**
	 * 获取token
	 * @return string
	 */
	public static function getAccessToken ()
	: string
	{
		return self::$access_token;
	}
	
}