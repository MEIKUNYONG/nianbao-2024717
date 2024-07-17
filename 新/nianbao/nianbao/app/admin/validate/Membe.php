<?php 
/*
 module:		会员管理控制器
 create_time:	2022-08-19 17:06:02
 author:		
 contact:		
*/

namespace app\admin\validate;
use think\validate;

class Membe extends validate {


	protected $rule = [
		'username'=>['require'],
		'mobile'=>['regex'=>'/^1[3456789]\d{9}$/'],
		'email'=>['regex'=>'/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/'],
	];

	protected $message = [
		'username.require'=>'用户名不能为空',
		'mobile.regex'=>'手机号格式错误',
		'email.regex'=>'邮箱格式错误',
	];

	protected $scene  = [
		'add'=>['username','mobile','email'],
		'update'=>['username','mobile','email'],
	];



}

