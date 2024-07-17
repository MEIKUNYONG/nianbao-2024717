<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 自定义配置
// +----------------------------------------------------------------------
return [
	'upload_subdir'		=> 'Ym',				//文件上传二级目录 标准的日期格式
	'nocheck'			=> ['/admin/Login/verify.html','/admin/Login/index.html','/admin/Login/logout.html','/admin/Base/getMenu.html','/admin/Index/index.html','/admin/Upload/upload.html','/admin/Upload/createFile.html','/admin/Login/aliOssCallBack.html'],	//不需要验证权限的url
	
	'password_secrect'	=> 'xhadmin',			//密码加密秘钥
		
	'dump_extension'	=> 'xlsx',				//默认导出格式
	'verify_status'		=> false,				//后台登录验证码开关
	'water_img'			=>	'./static/images/water.png',	//水印图片路径
	
	'check_file_status'	=> true,			//上传图片是否检测图片存在

	
	//oss开启状态 以及配置指定oss
	'oss_status'			=> false,			//true启用  false 不启用
	'oss_upload_type'		=> 'server',		//client 客户端直传  server 服务端传
	'oss_default_type'		=> 'qiniuyun',			//oss使用类别 ali(阿里),qiniuyun(七牛),tencent(腾讯)
	
	//阿里云oss配置
	'ali_oss_accessKeyId'		=> 'LTAI5t63SkZxAqKEyy8VZf',						//阿里云短信 keyId	
	'ali_oss_accessKeySecret'	=> '4UI62NuZepXUqetGtpPBbv2049El',					//阿里云短信 keysecret
	'ali_oss_endpoint'			=> 'http://i.whpj.vip',							//建议填写自己绑定的域名
	'ali_oss_bucket'			=> 'xhadmin',					
	
	//腾讯云cos配置
	'tencent_oss_secretId'		=> 'AKIDGMB24LkbTUEhtoSqxnMegRv84',				//腾讯云keyId	
	'tencent_oss_secretKey'		=> 'g5D5gz1LlO6YjFafSzFENXQ2N',		//腾讯云keysecret
	'tencent_oss_bucket'		=> 'vueadmin-1254365669',							//腾讯云bucket
	'tencent_oss_region'		=> 'ap-nanjing',									//地区，根据自己的填写
	'tencent_oss_schema'		=> 'http',							//访问前缀 支持http  https	
	
	//七牛云oss配置
	'qny_oss_accessKey' 		=> 'bm1sR9bx0F5HK7KYqRtAhZMJ8zOxb-HCGYx5pJU',  //access_key
	'qny_oss_secretKey' 		=> 'YrRaySbqu7M1PIzZHOgJMT0ObUdb7GBPRiYa7Lq',     //secret_key
	'qny_oss_bucket'	  		=> 'xhadmin',							//bucket
	'qny_oss_domain'	  		=> 'http://images.whpj.vip', 		//七牛云访问的域名
	'qny_oss_client_uploadurl'	=> 'http://up-z0.qiniup.com',		//七牛云客户端直传上传地址 不用动如果提示地址错误 根据提示换就行
  

];
