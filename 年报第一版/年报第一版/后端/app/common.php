<?php
// +----------------------------------------------------------------------
// | 应用公共文件
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 
// +----------------------------------------------------------------------


use think\facade\Db; 
use think\facade\Log; 
use think\facade\Config; 

error_reporting(0);


/**
 * 随机字符
 * @param int $length 长度
 * @param string $type 类型
 * @param int $convert 转换大小写 1大写 0小写
 * @return string
 */
function random($length=10, $type='letter', $convert=0)
{
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if(!isset($config[$type])) $type = 'letter';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string[mt_rand(0, $strlen)];
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}


//后台sql输入框语句过滤
function sql_replace($str){
	$farr = ["/insert[\s]+|update[\s]+|create[\s]+|alter[\s]+|delete[\s]+|drop[\s]+|load_file|outfile|dump/is"];
	$str = preg_replace($farr,'',$str);
	return $str;
}


//上传文件黑名单过滤
function upload_replace($str){
	$farr = ["/php|php3|php4|php5|phtml|pht|/is"];
	$str = preg_replace($farr,'',$str);
	return $str;
}


//查询方法过滤
function serach_in($str){
	$farr = ["/^select[\s]+|insert[\s]+|and[\s]+|or[\s]+|create[\s]+|update[\s]+|delete[\s]+|alter[\s]+|count[\s]+|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/i"];
	$str = preg_replace($farr,'',$str);
	return trim($str);
}


//获取键值对信息
function getItemData($data){
	$str = in_array(json_encode(array_values($data)),['[]','[[]]']) ? '' : json_encode(array_values($data),JSON_UNESCAPED_UNICODE);
	return $str;
}


/**
 * tp官方数组查询方法废弃，数组转化为现有支持的查询方法
 * @param array $data 原始查询条件
 * @return array
 */
function formatWhere($data){
	$where = [];
	foreach( $data as $k=>$v){
		if(is_array($v)){
			if(((string) $v[1] <> null && !is_array($v[1])) || (is_array($v[1]) && (string) $v[1][0] <> null)){
				switch(strtolower($v[0])){			
					//模糊查询
					case 'like':
						$v[1] = '%'.$v[1].'%';
					break;
					
					case 'regex':
						$v[0] = 'like';
					break;
					
					//表达式查询
					case 'exp':
						$v[1] = Db::raw($v[1]);
					break;
				}
				$where[] = [$k,$v[0],$v[1]];
			}
		}else{
			if((string) $v != null){
				$where[] = [$k,'=',$v];
			}
		}
	}
	return $where;
}



/*获取应用url前缀*/
function getBaseUrl(){
	$baseAppName = app('http')->getName();
	if(config('app.app_map')){
		$newapp = array_flip(config('app.app_map'))[$baseAppName];
		if($newapp) $baseAppName = $newapp;
	}

	$basename ='/'.$baseAppName;

	if(config('app.domain_bind')){
		$newapp = array_flip(config('app.domain_bind'))[$baseAppName];
		if($newapp) $basename = '';
	}
	
	return $basename;
}


/**
 * 实例化数据库类
 * @param string        $name 操作的数据表名称（不含前缀）
 * @param array|string  $config 数据库配置参数
 * @param bool          $force 是否强制重新连接
 * @return \think\db\Query
 */
if (!function_exists('db')) {
	
    function db($name = '',$connect='')
    {
		if(empty($connect)){
			$connect = config('database.default');
		}
        return Db::connect($connect,false)->name($name);
    }
}

