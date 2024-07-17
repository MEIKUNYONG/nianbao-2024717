<?php

namespace app\api\controller;

use think\exception\ValidateException;
use app\api\BaseController;
use app\admin\model\Member as MemberModel;
use app\admin\model\Baseconfig as BaseconfigModel;
/**
 * 登录模块
 */
class Login extends BaseController
{
    /**
     * 登录
     */
    public function login()
    {
        $data= $this->request->param();
        $code=$data['code'];
        
		$config = BaseconfigModel::column('data','name');
	
        $APPID = $config['appid'];
        $AppSecret =$config['appsecret'];
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$APPID."&secret=".$AppSecret."&js_code=".$code."&grant_type=authorization_code";
        $arr = $this->vget($url);  // 一个使用curl实现的get方法请求
        $response = json_decode($arr,true);
        
        
        $where = [];
        $where['openid']=$response['openid'];
        $member = MemberModel::where(formatWhere($where))->find();
        if (!$member) {
            $member=new MemberModel;
            $member->openid=$response['openid'];
            $member->nickname=$this->genUserName();
            $member->avatar="https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132";
            $member->unionid=$response['unionid']??$response['openid'];
            $member->create_time=date('Y-m-d H:i:s');
            if ($member->save()) {
                $user_id=$member->id;
                $member = MemberModel::find($user_id);
                $member->access_token=$this->encodeId($user_id);;
                $member->save();
                 
            }

        }
        $data = ['code' =>200,'data'=>$member,'msg' => '登录成功'];
        return json($data);

        
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
    public function genUserName()
    {
        $microtime = substr(microtime(true), strpos(microtime(true), ".") + 1);
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $username = "";
        for ($i = 0; $i < 6; $i++) {
            $username .= $chars[mt_rand(0, strlen($chars))];
        }
     
        return $microtime. $username;
    }
    
    
       /**
       * [encodeId ID加密]
       * @param int $id ID
       * @param int $time 时间戳
       */
     
     public function encodeId($id = 0, $time = '') {
        //时间戳
        if(empty($time)){
          $time = time();
        } else {
          $time = !empty(strtotime($time)) ? strtotime($time) : time();
        }
        //加密
        return base64_encode($time . $id);
      }
      



    
 
}