<?php 

namespace app\admin\controller;
use think\facade\Log;
use think\facade\Db;
use think\facade\Validate;
use think\facade\Filesystem;
use think\exception\ValidateException;
use think\Image;
use app\admin\model\Files as FilesModel;

class Upload extends Admin{
	
	
	
	//上传前先检测上传模式 如果是oss客户端直传则直接返回 token 、key等信息
	public function upload(){
		$file = $this->request->file('file');
		$file_type = upload_replace(config('base_config.filetype')); //上传黑名单过滤
		if(!Validate::fileExt($file,$file_type)){
			throw new ValidateException('文件类型验证失败');
		}
		
		if(!Validate::fileSize($file,config('base_config.filesize') * 1024 * 1024)){
			throw new ValidateException('文件大小验证失败');
		}
		$filepath = $this->getFile($file);
		if($filepath){
			return json(['status'=>200,'data'=>$filepath,'filestatus'=>true]);
		}else{
			$edit = $this->request->post('edit');	//检测是否编辑器上传  如果是则不走oss客户端传
			if(config('my.oss_status') && config('my.oss_upload_type') == 'client' && !$edit){
				switch(config('my.oss_default_type')){
					case 'qiniuyun';
						$data['serverurl'] = config('my.qny_oss_client_uploadurl');
						$data['domain'] = config('my.qny_oss_domain');
						$data['token'] = $this->getQnyToken();
					break;
					
					case 'tencent';
						$data['SecretId'] = config('my.tencent_oss_secretId');
						$data['SecretKey'] = config('my.tencent_oss_secretKey');
						$data['Bucket'] = config('my.tencent_oss_bucket');
						$data['Region'] = config('my.tencent_oss_region');
						$data['Schema'] = config('my.tencent_oss_schema');
					break;
					
					case 'ali':
						$options = array();
						$expire = 30;  //设置该policy超时时间是30s. 即这个policy过了这个有效时间，将不能访问。
						$now = time();
						$end = $now + $expire;
						$options['expiration'] = $this->gmtIso8601($end); /// 授权过期时间
						$conditions = array();
						array_push($conditions, array('bucket'=>config('my.ali_oss_bucket')));
						
						//$callbackUrl = 'http://b.cdlfvip.com/admin/Login/aliOssCallBack';	//oss异步回调地址，通过这个地址返回上传的文件名
						$callbackUrl = 'http://vue2.whpj.vip/admin/Upload/aliOssCallBack';

						$callback_param = array('callbackUrl'=>$callbackUrl,
							'callbackBody'=>'${object}',
							'callbackBodyType'=>"application/x-www-form-urlencoded");
						$callback_string = json_encode($callback_param);

						$base64_callback_body = base64_encode($callback_string);
						
						$content_length_range = array();
						array_push($content_length_range, 'content-length-range');
						array_push($content_length_range, 0);
						array_push($content_length_range, 2048 * 1024 * 1024);
						array_push($conditions, $content_length_range);
						$options['conditions'] = $conditions;
						$policy = base64_encode(stripslashes(json_encode($options)));
						$sign = base64_encode(hash_hmac('sha1',$policy,config('my.ali_oss_accessKeySecret'), true));
						
						$data['serverurl'] = $this->getendpoint(config('my.ali_oss_endpoint'));
						$data['sign'] = $sign;
						$data['policy'] = $policy;
						$data['callback'] = $base64_callback_body;
						$data['OSSAccessKeyId'] = config('my.ali_oss_accessKeyId');
					break;
				}
				$data['key'] = $this->getFileName().'/'.$file->hash('md5').'.'.$file->extension();
				$data['type'] = config('my.oss_default_type');
				return json(['status'=>200,'data'=>$data]);
			}else{
				if($url = $this->up($file)){
					return json(['status'=>200,'data'=>$url]);
				}
			}
		}
	}
	
	//开始上传
	protected function up($file){
		
		try{
		   
		    $file_type=$file->extension();
		   
			if(config('my.oss_status') && $file_type!="pem"){
				$url = \utils\oss\OssService::OssUpload($file);
				$disk = config('my.oss_default_type');
			}else{
			  
			    $filename = Filesystem::disk('public')->putFile($this->getFileName(),$file,'uniqid');
			   
			    if($file_type=="pem"){
			        $url = config('filesystem.disks.public.url').'/'.$filename;
			    }else{
			        $url = config('base_config.domain').config('filesystem.disks.public.url').'/'.$filename;
			    }
				
				$disk = 'local';
			}
		}catch(\Exception $e){
			throw new ValidateException('上传失败');
		}
		
		$data = ['filepath'=>$url,'hash'=>$file->hash('md5'),'create_time'=>time(),'disk'=>$disk];
		if($url && explode('/',$file->getMime())[0] == 'image'){
			$data['type'] = 1;
		}
		FilesModel::create($data);
		return $url;
	}
	
	

	//获取上传的文件完整路径
	private function getFileName(){
		return app('http')->getName().'/'.date(config('my.upload_subdir'));
	}
	
	//oss上传成功后写入图片路径
	public function createFile(){
		$filepath = $this->request->post('filepath');
		$disk = $this->request->post('disk');
		$hash = explode('.',basename($filepath))[0];
		$data = ['filepath'=>$filepath,'hash'=>$hash,'create_time'=>time(),'disk'=>$disk];
		if($filepath  && in_array(explode('.',basename($filepath))[1],['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])){
			$data['type'] = 1;
		}
		FilesModel::create($data);
		return json(['status'=>200]);
	}
	
	//检测数据库的同图片的路径是否存在 存在则返回
	private function getFile($file){
		$filepath = FilesModel::where('hash',$file->hash('md5'))->value('filepath');
		if($filepath  && config('my.check_file_status')){
			return $filepath;
		}
	}
	

	
	//获取七牛云上传的token
	private function getQnyToken(){
		$auth = new \Qiniu\Auth(config('my.qny_oss_accessKey'), config('my.qny_oss_secretKey'));
		$upToken = $auth->uploadToken(config('my.qny_oss_bucket'));
		return $upToken;
	}
	
	
	//获取阿里云oss客户端上传地址
	private function getendpoint($str){
		if(strpos(config('my.ali_oss_endpoint'),'aliyuncs.com') !== false){
			if(strpos($str,'https') !== false){
				$point = 'https://'.config('my.ali_oss_bucket').'.'.substr($str,8);
			}else{
				$point = 'http://'.config('my.ali_oss_bucket').'.'.substr($str,7);
			}	
		}else{
			$point = config('my.ali_oss_endpoint');
		}
		return $point;
	}
	
	
	//阿里云oss客户端上传 授权过期时间
	private function gmtIso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
	
	
    
}