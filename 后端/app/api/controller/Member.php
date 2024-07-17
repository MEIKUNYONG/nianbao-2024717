<?php

namespace app\api\controller;
use think\facade\Db;
use app\api\BaseController;
use think\facade\Filesystem;
use think\exception\ValidateException;
use app\admin\model\Member as MemberModel;
use app\admin\model\Baseconfig as BaseconfigModel;
/**
 * 个人中心模块
 */
class Member extends BaseController
{
    /**
     * 用户鉴权
     */
     
    public $middleware = [\app\api\middleware\ApiMiddleware::class];
    
    
    public function userperfect()
    {
      
        $data= $this->request->param();
        $avatar=$data['avatar'];
        $nickname=$data['nickname'];
        
        $mobile=$data['mobile'];
        $memberId=$this->request->member_id;
       
      
        // $arr=['avatar'=>$avatar,'nickname'=>$nickname];
        $result=[];
    
        if($avatar)
        {
           
            $result["avatar"]=$avatar;
            $result["is_perfect"]=1;
            
        }
        
        if($nickname)
        {
            $result["nickname"]=$nickname;
   
        }
        if($mobile)
        {
            $result["mobile"]=$mobile;
            
        }
        
        
        
        Db::table('kt_lk_member')->where(['id'=>$memberId])->update($result);
      

        return json(['code' =>200,'msg' => '修改成功']);
  

    }
  
    /**
     * 新的用户资料
     */
    public function userinfo()
    {
        
        return json(['code' => 200, 'message' => '获取成功', 'data' => $this->request->member]);
    } 
    

   
    //获取手机号
    
     /*获取access_token,不能用于获取用户信息的token*/
   public function getAccessToken()
    {
     
		$config = BaseconfigModel::column('data','name');
	
        $APPID = $config['appid'];
        $AppSecret = $config['appsecret'];

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$AppSecret."";

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
        exit();
    }
    //图片合法性验证
    public function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
        exit();

    }

    
    public function getPhoneNumber(){
        $datas= $this->request->param();
        $tmp = $this->getAccessToken();
        $tmptoken = json_decode($tmp);
        $token = $tmptoken->access_token;
        $data['code'] = $datas['code'];//前端获取code

        $url = "https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=$token";
        $info = $this->http_request($url,json_encode($data),'json');
        // 一定要注意转json，否则汇报47001错误
        $tmpinfo = json_decode($info);

        $code = $tmpinfo->errcode;
        $phone_info = $tmpinfo->phone_info;
        //手机号
        $phoneNumber = $phone_info->phoneNumber;
        
        $where = [];
        $where['id']=$this->request->member_id;
        $member = MemberModel::where(formatWhere($where))->find();
        
        if($code == '0'){
            $member->mobile=$phoneNumber;
           
            if ($member->save()) {
                return json(['code' =>200,'data'=>$member,'msg' => '登录成功']);
            }else{
                return json(['code' =>201,'msg' => '登录失败']);
            }
            
        }else{
            return json(['code' =>201,'msg' => '获取手机号失败']);

        }

    }
    

}
