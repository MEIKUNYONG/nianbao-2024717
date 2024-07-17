<?php

namespace app\admin\controller;
use think\exception\FuncNotFoundException;
use think\exception\ValidateException;
use app\BaseController;
use think\facade\Db;

use think\facade\Config;
class Admin extends BaseController
{
	
	
	protected function initialize(){
		$controller = $this->request->controller();
		$action = $this->request->action();
		$app = app('http')->getName();
		
		$admin = session('admin');
        $userid = session('admin_sign') == data_auth_sign($admin) ? $admin['user_id'] : 0;
		
        if( !$userid && ( $app <> 'admin' || $controller <> 'Login' )){
			echo '<script type="text/javascript">top.parent.frames.location.href="'.url('admin/Login/index').'";</script>';exit();
        }

		if(session('admin.access')){
			foreach(session('admin.access') as $key=>$val){
				$newnodes[] = parse_url($val)['path'];
			}
		}

		$url =  "/{$app}/{$controller}/{$action}.html";
		if(session('admin.role_id') <> 1 && !in_array($url,config('my.nocheck'))  && !in_array($action,['getExtends','getInfo','getFieldList'])){	
			if(!in_array($url,$newnodes)){
				throw new ValidateException ('你没操作权限');
			}	
		}
		$oreoconfig=[];
	    $host=Config::get('database.connections.mysql.hostname');
	    $port=Config::get('database.connections.mysql.hostport');
	    $user=Config::get('database.connections.mysql.username');
	    $pwd=Config::get('database.connections.mysql.password');
	    $dbname=Config::get('database.connections.mysql.database');

	    $oreoconfig['host']=$host;
	    $oreoconfig['port']=$port;
	    $oreoconfig['user']=$user;
	    $oreoconfig['pwd']=$pwd;
	    $oreoconfig['dbname']=$dbname;
	    
  
		
		event('DoLog',session('admin.username'));	//写入操作日志
		
		$list = Db::name('base_config')->cache(true,60)->select()->column('data','name');
		
		config($list,'base_config');
	}
	

	public function vget($url){
        $info=curl_init();
        curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($info,CURLOPT_HEADER,0);
        curl_setopt($info,CURLOPT_NOBODY,0);
        curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($info,CURLOPT_URL,$url);
        $output= curl_exec($info);
        curl_close($info);
        return $output;
    }
	

	
	public function getTopDomainhuo(){
	    $host=$_SERVER['HTTP_HOST'];
		
		$matchstr="[^\.]+\.(?:(".$str.")|\w{2}|((".$str.")\.\w{2}))$";
		if(preg_match("/".$matchstr."/ies",$host,$matchs)){
			$domain=$matchs['0'];
		}else{
			$domain=$host;
		}
		return $domain;
	}
	
	
	
	//验证器 并且抛出异常
	protected function validate($data,$validate){
		try{
			validate($validate)->scene($this->request->action())->check($data);
		}catch(ValidateException $e){
			throw new ValidateException ($e->getError());
		}
		return true;
	}
	
	//格式化sql字段查询 转化为 key=>val 结构
	protected function query($sql,$connect='mysql'){
		preg_match_all('/select(.*)from/iUs',$sql,$all);
		if(!empty($all[1][0])){
			$sqlvalue = explode(',',trim($all[1][0]));
		}
		if(strpos($sql,'tkey') !== false){
			$sqlvalue[1] = 'tkey';
		}
		
		if(strpos($sql,'tval') !== false){
			$sqlvalue[0] = 'tval';
		}
		$sql = str_replace('pre_',config('database.connections.'.$connect.'.prefix'),$sql);
		$list = Db::connect($connect)->query($sql);
		$array = [];
		foreach($list as $k=>$v){
			$array[$k]['key'] = $v[$sqlvalue[1]];
			$array[$k]['val'] = $v[$sqlvalue[0]];
			if($sqlvalue[2]){
				$array[$k]['pid'] = $v[$sqlvalue[2]];
			}
		}
		return $array;
	}
	
	
	
	public function __call($method, $args){
        throw new FuncNotFoundException('方法不存在',$method);
    }
	
	
	
}