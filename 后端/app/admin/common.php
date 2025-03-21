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


use think\helper\Str;

error_reporting(0);



//根据键名获取键值
function getItemVal($val,$item_config){
	if(!is_null($val)){
		$str = '';
		foreach(explode(',',$val) as $v){
			foreach(json_decode($item_config,true) as $m){
				if($v == $m['val']){
					$str .= $m['key'].',';
				}
			}
		}
		return rtrim($str,',');
	}
}

//根据键值获取键名
function getValByKey($val,$item_config){
	if($val){
		$str = '';
		foreach(explode(',',$val) as $v){
			foreach(json_decode($item_config,true) as $m){
				if($v == $m['key']){
					$str .= $m['val'].',';
				}
			}
		}
		return rtrim($str,',');
	}
}

//无限极分类转为带有 children的树形select结构
function _generateSelectTree ($data, $pid = 0) {
	$tree = [];
	if ($data && is_array($data)) {
		foreach($data as $v) {
			if($v['pid'] == $pid) {
				$tree[] = [
					'key' => $v['key'],
					'val' => $v['val'],
					'children' => _generateSelectTree($data, $v['val']),
				];
			}
		}
	}
	return $tree;
}

//无限极分类转为带有 children的树形list表格结构
function _generateListTree ($data, $pid = 0,$config=[]) {
	$tree = [];
	if ($data && is_array($data)) {
		foreach($data as $v) {
			if($v[$config[1]] == $pid) {
				$tree[] = array_merge($v,['children' => _generateListTree($data, $v[$config[0]],$config)]);
			}
		}
	}
	return $tree;
}

function deldir($dir) {
//先删除目录下的文件：
   if(is_dir($dir)){
	   $dh=opendir($dir);
	   while ($file=readdir($dh)) {
		  if($file!="." && $file!="..") {
			 $fullpath=$dir."/".$file;
			 if(!is_dir($fullpath)) {
				unlink($fullpath);
			 } else {
				deldir($fullpath);
			 }
		  }
	   }
	 
	   closedir($dh);
	   //删除当前文件夹：
	   if(rmdir($dir)) {
		  return true;
	   } else {
		  return false;
	   }
   }
}


/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

