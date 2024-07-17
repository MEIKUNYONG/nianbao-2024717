<?php 

declare (strict_types = 1);

namespace app\api\controller;
use app\admin\model\Order as OrderModel;

use think\exception\ValidateException;
use EasyWeChat\Factory;
use think\facade\Db;
use app\api\middleware\ApiMiddleware;
use app\api\BaseController;
use app\admin\model\Enterprise as EnterpriseModel;
use app\admin\model\Baseconfig as BaseconfigModel;
use app\admin\model\Pay as PayModel;
use app\admin\model\Area as AreaModel;
use think\facade\Log;

use app\api\middleware\AopClient;
/**
 * 订单
 */

class Order extends BaseController
{
	/**
     * 用户鉴权
     */
   
    protected $middleware = [ 
    	ApiMiddleware::class . ':api' 	=> ['except' 	=> ['notify','sxnotify'] ]
    ];

  
 
	public function oldsubmit() 
	{
	    
        $data= $this->request->param();
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        $total_price=$data['total_price'];
        
        $enterprise_id=$data['enterprise_id'];//中间表id
        $title=$data['title'];
   
        $where = [];
        $where['id']=$enterprise_id;
        $where['status'] =1;
        
        $enterprise = EnterpriseModel::where(formatWhere($where))->find();
        
        $configs = BaseconfigModel::column('data','name');
        
        
        $paytype=$configs['type'];//支付类型
        $lastYear = date('Y', strtotime('-1 year'));
        $order = new OrderModel();
        $order->member_id = $member->id;
        $order->enterprise_id =$enterprise_id;
        $order->mobile =$mobile;
        $order->title =$title;
        $order->order_no = date('YmdHis') . rand(100000, 999999);
        $order->total_price = $total_price;
        $order->enterprise_name =$enterprise->enterprise_name;
        $order->enterprise_code =$enterprise->enterprise_code;
        $order->report_year = $lastYear;
        
        $order->is_declaration =0;
        $order->is_success =0;
        $order->is_pay =0;
        $order->pay_type = 0;
        $order->create_time = date('Y-m-d H:i:s');
      
        if (!$order->save()) {
            
            return json(['code' =>201,'msg' =>'订单存储失败']);
           
        }
        
        if($paytype==1){
            
            $notify_url=$configs['domain']."/api/order/notify";
            $config = [
            
                "app_id"=> $configs['appid'],
                "mch_id" =>$configs['mch_id'] ,
                "key" => $configs['pay_secretkey'],
                "notify_url" =>$notify_url
            ];
            $app = Factory::payment($config);
            
            
            $pay_info = [
                "trade_type" => "JSAPI",              // 支付方式，小程序支付使用JSAPI
                "body" => $title,            // 订单说明
                "out_trade_no" => $order->order_no,  // 自定义订单号
                "total_fee" => $total_price * 100,               // 单位：分
                "openid" => $member->openid                   // 当前用户的openId
            ];
           
            $result = $app->order->unify($pay_info);
            
            if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
                $prepayId = $result["prepay_id"];
                $jssdk = $app->jssdk;
                $config = $jssdk->sdkConfig($prepayId); 
                
                return json(['code' =>200,'data'=>$config,'msg' => '获取成功']);
             
            }
            
            if ($result["return_code"] == "FAIL" && array_key_exists("return_msg", $result)) {
                return json(['code' =>201,'msg' => $result["return_msg"]]);
    
     
            }
            
            return json(['code' =>201,'msg' => $result["err_code_des"]]);

        }elseif($paytype==2){
            $privateKey=$configs['privatekey'];
            $sxfPublic=$configs['sxfpublic'];
            $aopClient = new AopClient();
            $notifyUrl=$configs['domain']."/api/order/sxnotify";
            $array = [
                "mno"=> $configs['mno'], //商户编号
                "ordNo"=> $order->order_no, //商户订单号
                //"subMechId"=> "1641117957", //子商户号
    		    "subAppid"=> $configs['appid'], //微信 subAppId
    		    "amt"=> $total_price, //订单总金额
    		    "payType"=> "WECHAT", //支付渠道
    		    "payWay"=> "03", //支付方式  02 公众号/服 务窗/js支付 03 小程序
    		    "subject"=> $title,
    		    "tradeSource"=> "01", //交易来源 01服务商，02收银台，03硬件
    		    "trmIp"=> "127.0.0.1",
    		    "customerIp"=> "", //持卡人ip地址，银联js支付时必传
    		    "userId"=> $member->openid, //用户号 微信：openid； 支付宝：userid；银联：userid；微信&支付宝必传，银联js为非必传
    		    "notifyUrl"=> $notifyUrl, //回调地址
    		    
            ];
            $reqBean = [
        		"orgId" =>$configs['orgid'],
        		"reqData"=>$array,
        		"reqId" => time(),
        		"signType" => "RSA",
        		"timestamp" => date("Y-m-d h:i:s"),
        		"version" => "1.0",
        	];
        	$signContent = $aopClient->generateSign($reqBean,$privateKey);
           
            $sign =["sign" => $signContent];
            
            $reqStr = array_merge($reqBean, $sign);
        	$reqStr = json_encode($reqStr,320);
        	$requestUrl = 'https://openapi.tianquetech.com/order/jsapiScan';
        	$resp = $aopClient->curl($requestUrl, $reqStr);
        
        	$result = json_decode($resp,true);
        
        	$signResult = $result["sign"];
        	unset($result["sign"]);
        	if ($result['respData']['bizCode'] == '0000'){
        	    $respData=$result['respData'];
        	    OrderModel::where('order_no', $result['respData']['ordNo'])->update(['sxfuuid' => $result['respData']['sxfUuid']]);
        	    $list=[];
        	    $list['timestamp']=$respData['payTimeStamp'];
        	    $list['nonceStr']=$respData['paynonceStr'];
        	    $list['package']=$respData['payPackage'];
        	    $list['signType']=$respData['paySignType'];
        	    $list['paySign']=$respData['paySign'];
        	    return json(['code' =>200,'data'=>$list,'msg' => '获取成功']);
           
            }else{
                return json(['code' =>201,'msg' => $result['respData']['bizMsg']]);
        
            }
            
        }
        
        
    
		
	}
	
	public function sxnotify(){
        
        //$order = new OrderModel();
        Log::info('随行付============');
        $data = file_get_contents('php://input');
        // file_put_contents('b.txt',$data);
        Log::info('异步支付回调执行开始============');
        $notifyData = json_decode($data,true);

        if($notifyData['bizCode'] == '0000'){

            Log::info('响应成功，订单号为：'.$notifyData['ordNo']);

                //查询订单信息
            $orderInfo = OrderModel::where('order_no',$notifyData['ordNo'])->find();
          
            //判断订单是否存在 是否已支付
            if(empty($orderInfo)){
                Log::info('订单号为：'.$notifyData['ordNo'].'的订单不存在============');
                return 1;exit;
            }else if($orderInfo && $orderInfo['status'] == 1){
                Log::info('订单号为：'.$notifyData['ordNo'].'的订单已支付============');
                return 1;exit;
            }else if($orderInfo && $orderInfo['status'] == 3){
                Log::info('订单号为：'.$notifyData['ordNo'].'的订单已退款============');
                return 1;exit;
            }
            
           

            $updateInfo = OrderModel::where('order_no',$notifyData['ordNo'])->update(['pay_time'=>date('Y-m-d H:i:s'),'is_pay'=>1,'pay_type'=>2]);
            if($updateInfo){
                Log::info('订单支付完成=============');
                return 1;exit;
            }
        Log::info('回调结束==========');
        }else{
            Log::info('响应失败，响应码为：'.$notifyData['bizCode'].'=============');
        }
    }
    
	public function notifysss() 
	{
	    $configs = BaseconfigModel::column('data','name');
        $notify_url=$configs['domain']."/api/order/notify";
        $config = [
            
            "app_id"=> $configs['appid'],
            "mch_id" =>$configs['mch_id'] ,
            "key" => $configs['pay_secretkey'],
            "notify_url" => $notify_url
        ];
        $app = Factory::payment($config);
        $response = $app->handlePaidNotify(function($message, $fail){
       
         // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
           Log::write('订单号'.$message["out_trade_no"],'notice');
           $where = [];
           $where['order_no']=$message["out_trade_no"];
  
           $order = OrderModel::where(formatWhere($where))->find();
         
            if (!$order || $order->is_pay==1) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
        
            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
        
            if ($message["return_code"] === "SUCCESS") { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (isset($message['result_code']) && $message['result_code'] === 'SUCCESS') {
                    $order->pay_time = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                    $order->is_pay = 1;
                    $order->pay_type = 1;
                    $order->save(); // 保存订单
                    
                   Log::write('成功回调','SUCCESS');
                // 用户支付失败
                } elseif (isset($message['result_code']) && $message['result_code'] === 'FAIL') {
                    Log::write('失败回调'.$message['result_code'],'FAIL');
                    return $message['result_code'];
                }
            } else {
                Log::write('通信失败，请稍后再通知我','FAIL');
                return '通信失败，请稍后再通知我';
           
            }
        
            return true; // 返回处理完成
        });
        
        return $response;
 
	}
	
	public function notify() 
	{
	    $xml = file_get_contents("php://input");
        if(empty($xml)) return '非法访问';
   
		//xml数据转数组
		$data = json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
		//保存微信服务器返回的签名sign
		$data_sign = $data['sign'];
		//sign不参与签名算法
		unset($data['sign']);
		Log::write('数据mch_id'.$data['mch_id'],'noticess');
		Log::write('数据out_trade_no'.$data['out_trade_no'],'noticess');
		$mch_id=$data['mch_id'];//微信返回的
	    
	    $paylist = PayModel::where(['mch_id' => $mch_id])->find()->toArray();
	    
	    $configs = BaseconfigModel::column('data','name');
        $notify_url=$configs['domain']."/api/order/notify";
        $config = [
            
            "app_id"=> $configs['appid'],
            "mch_id" =>$paylist['mch_id'] ,
            "key" => $paylist['pay_secretkey'],
            "notify_url" => $notify_url
        ];
        $app = Factory::payment($config);
        $response = $app->handlePaidNotify(function($message, $fail){
       
         // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
           Log::write('订单号'.$message["out_trade_no"],'notice');
           $where = [];
           $where['order_no']=$message["out_trade_no"];
  
           $order = OrderModel::where(formatWhere($where))->find();
         
            if (!$order || $order->is_pay==1) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
        
            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
        
            if ($message["return_code"] === "SUCCESS") { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (isset($message['result_code']) && $message['result_code'] === 'SUCCESS') {
                    $order->pay_time = date('Y-m-d H:i:s'); // 更新支付时间为当前时间
                    $order->is_pay = 1;
                    $order->pay_type = 1;
                    $order->save(); // 保存订单
                    
                   Log::write('成功回调','SUCCESS');
                // 用户支付失败
                } elseif (isset($message['result_code']) && $message['result_code'] === 'FAIL') {
                    Log::write('失败回调'.$message['result_code'],'FAIL');
                    return $message['result_code'];
                }
            } else {
                Log::write('通信失败，请稍后再通知我','FAIL');
                return '通信失败，请稍后再通知我';
           
            }
        
            return true; // 返回处理完成
        });
        
        return $response;
 
	}
	
	
	//订单列表
	public function orderlist() 
	{
	    $data= $this->request->post();
        $is_status=$data['is_status'];//0是全部 1是待申报 2是已申报 3是申报失败
	    
	    $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        $wheres = [];
        $wheres['member_id']=$member->id;
        $wheres['mobile']=$mobile;
        
        $wheres['is_pay']=1;
        
        if($is_status==1){
            $wheres['is_declaration']=0;
            $wheres['is_success']=0;
            $wheres['is_refund']=0;
        }elseif($is_status==2){
            $wheres['is_declaration']=1;
            $wheres['is_success']=0;
            $wheres['is_refund']=0;
        }elseif($is_status==3){
            $wheres['is_declaration']=1;
            $wheres['is_success']=2;
        }
        

        $order = OrderModel::where(formatWhere($wheres))->order('pay_time desc')->select();
        $arr=[];
        foreach ($order as $k=>$v){
            $str=[];
            $str['id']=$v['id'];
            $str['order_no']=$v['order_no'];
            $str['enterprise_name']=$v['enterprise_name'];
            $str['title']=$v['title'];
            $str['pay_type']="微信支付";
            $str['pay_time']=$v['pay_time'];
            $str['total_price']=$v['total_price'];
            if($v['is_declaration']==0  && $v['is_success']==0 && $v['is_refund']==0){
                $str['status']="待申报";
            }elseif($v['is_declaration']==1 && $v['is_success']==0 && $v['is_refund']==0){
                $str['status']="已申报";
            }elseif($v['is_declaration']==1  && $v['is_success']==1 && $v['is_refund']==0){
                $str['status']="申报成功";
            }elseif($v['is_declaration']==1  && $v['is_success']==2 && $v['is_refund']==0){
                $str['status']="申报失败";
            }elseif($v['is_refund']==1){
                $str['status']="已退款";
            }
            $arr[]=$str;
        }
        
      
        return json(['code' =>200,'data'=>$arr,'msg' => '成功']);
  
	}
	
	//新支付方式随机支付
	public function submit() 
	{
	    
        $data= $this->request->param();
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        $total_price=$data['total_price'];
        
        $enterprise_id=$data['enterprise_id'];//中间表id
        $title=$data['title'];
        
        $idcard=$data['idcard'];
   
        $where = [];
        $where['id']=$enterprise_id;
        $where['status'] =1;
        
        $enterprise = EnterpriseModel::where(formatWhere($where))->find();
        
        $configs = BaseconfigModel::column('data','name');
        
        //新
        $orwhere = [];
        $orwhere[] = ['pay_id', '<>', 0];
  
        $orderlist = OrderModel::where($orwhere)->count();
      
        if($orderlist==0){
            $paytype=1;
            
            $paylist = PayModel::where(['type' => 1,'status' => 1])->orderRaw('rand()')->limit(1)->select()->toArray();
            if(!$paylist){
                return json(['code' =>201,'msg' =>'支付配置获取失败，请联系商家进行配置']);
            }else{
                $payconfig=$paylist[0];
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
            }
            
        }else{
            $orwheres = [];
            $orwheres[] = ['pay_id', '<>', 0];
            $orderlists = OrderModel::where($orwheres)->order('id desc')->find();
            $payid=$orderlists->pay_id;//3
            
            $payss= PayModel::where(['id' => $payid,'status'=>1])->count();
            if($payss!=0){
                 $paynum = PayModel::where(['status' => 1])->count();
                if($paynum>1){
                    $payheres = [];
                    $payheres[] = ['id', '<>', $payid];
                    $payheres[] = ['status', '=', 1];
                }else{
                    $payheres = [];
                    $payheres[] = ['id', '=', $payid];
                    $payheres[] = ['status', '=', 1];
                }
            }else{
                $payone = PayModel::where(['status' => 1])->find();
                $payheres = [];
                $payheres[] = ['id', '=', $payone->id];
                $payheres[] = ['status', '=', 1];
               
            }
            
            /*$paynum = PayModel::where(['status' => 1])->count();
            if($paynum>1){
                $payheres = [];
                $payheres[] = ['id', '<>', $payid];
                $payheres[] = ['status', '=', 1];
            }else{
                $payheres = [];
                $payheres[] = ['id', '=', $payid];
                $payheres[] = ['status', '=', 1];
            }
            */
            
            $paylist = PayModel::where($payheres)->orderRaw('rand()')->limit(1)->select()->toArray();
            $payconfig=$paylist[0];
            if($payconfig['type']==1){
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
                $paytype=1;
            }else{
                $paytype=2;
                $pay_id=$payconfig['id'];
                $orgid=$payconfig['orgid'];
                $mno=$payconfig['mno'];
                $privatekey=$payconfig['privatekey'];
                $sxfpublic=$payconfig['sxfpublic'];
               
            }
            
        }
        
       
      
        $paytype=$paytype;//支付类型

        $lastYear = date('Y', strtotime('-1 year'));
        $order = new OrderModel();
        $order->member_id = $member->id;
        $order->pay_id =$pay_id;
        $order->enterprise_id =$enterprise_id;
        $order->mobile =$mobile;
        $order->title =$title;
        $order->order_no = date('YmdHis') . rand(100000, 999999);
        $order->total_price = $total_price;
        $order->enterprise_name =$enterprise->enterprise_name;
        $order->enterprise_code =$enterprise->enterprise_code;
        $order->report_year = $lastYear;
        $order->idcard =$idcard;
        $order->is_declaration =0;
        $order->is_success =0;
        $order->is_pay =0;
        $order->pay_type = 0;
        $order->create_time = date('Y-m-d H:i:s');
      
        if (!$order->save()) {
            
            return json(['code' =>201,'msg' =>'订单存储失败']);
           
        }
        
        if($paytype==1){
            $notify_url=$configs['domain']."/api/order/notify";
            $config = [
            
                "app_id"=> $configs['appid'],
                "mch_id" =>$mch_id ,
                "key" => $pay_secretkey,
                "notify_url" => $notify_url
            ];
            $app = Factory::payment($config);
            
            
            $pay_info = [
                "trade_type" => "JSAPI",              // 支付方式，小程序支付使用JSAPI
                "body" => $title,            // 订单说明
                "out_trade_no" => $order->order_no,  // 自定义订单号
                "total_fee" => $total_price * 100,               // 单位：分
                "openid" => $member->openid                   // 当前用户的openId
            ];
           
            $result = $app->order->unify($pay_info);
            
            if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
                $prepayId = $result["prepay_id"];
                $jssdk = $app->jssdk;
                $config = $jssdk->sdkConfig($prepayId); 
                
                return json(['code' =>200,'data'=>$config,'msg' => '获取成功']);
             
            }
            
            if ($result["return_code"] == "FAIL" && array_key_exists("return_msg", $result)) {
                return json(['code' =>201,'msg' => $result["return_msg"]]);
    
     
            }
            
            return json(['code' =>201,'msg' => $result["err_code_des"]]);

        }elseif($paytype==2){
            $privateKey=$privatekey;
            $sxfPublic=$sxfpublic;
            
            $aopClient = new AopClient();
            $notifyUrl=$configs['domain']."/api/order/sxnotify";
            $array = [
                "mno"=> $mno, //商户编号
                "ordNo"=> $order->order_no, //商户订单号
                //"subMechId"=> "1641117957", //子商户号
    		    "subAppid"=> $configs['appid'], //微信 subAppId
    		    "amt"=> $total_price, //订单总金额
    		    "payType"=> "WECHAT", //支付渠道
    		    "payWay"=> "03", //支付方式  02 公众号/服 务窗/js支付 03 小程序
    		    "subject"=> $title,
    		    "tradeSource"=> "01", //交易来源 01服务商，02收银台，03硬件
    		    "trmIp"=> "127.0.0.1",
    		    "customerIp"=> "", //持卡人ip地址，银联js支付时必传
    		    "userId"=> $member->openid, //用户号 微信：openid； 支付宝：userid；银联：userid；微信&支付宝必传，银联js为非必传
    		    "notifyUrl"=> $notifyUrl, //回调地址
    		    
            ];
            $reqBean = [
        		"orgId" =>$orgid,
        		"reqData"=>$array,
        		"reqId" => time(),
        		"signType" => "RSA",
        		"timestamp" => date("Y-m-d h:i:s"),
        		"version" => "1.0",
        	];
        	
        	$signContent = $aopClient->generateSign($reqBean,$privateKey);
           
        
            $sign =["sign" => $signContent];
            
            $reqStr = array_merge($reqBean, $sign);
        	$reqStr = json_encode($reqStr,320);
        	$requestUrl = 'https://openapi.tianquetech.com/order/jsapiScan';
        	$resp = $aopClient->curl($requestUrl, $reqStr);
        
        	$result = json_decode($resp,true);
        
        	$signResult = $result["sign"];
        	unset($result["sign"]);
        	if ($result['respData']['bizCode'] == '0000'){
        	    $respData=$result['respData'];
        	    OrderModel::where('order_no', $result['respData']['ordNo'])->update(['sxfuuid' => $result['respData']['sxfUuid']]);
        	    $list=[];
        	    $list['timestamp']=$respData['payTimeStamp'];
        	    $list['nonceStr']=$respData['paynonceStr'];
        	    $list['package']=$respData['payPackage'];
        	    $list['signType']=$respData['paySignType'];
        	    $list['paySign']=$respData['paySign'];
        	    return json(['code' =>200,'data'=>$list,'msg' => '获取成功']);
           
            }else{
                return json(['code' =>201,'msg' => $result['respData']['bizMsg']]);
        
            }
            
        }
        
        
    
		
	}
	
	
	//获取地方价格
	public function getareaprice(){
	    
	    $data= $this->request->param();
	    $area_sheng=$data['area_sheng'];
	    $area_shi=$data['area_shi'];
	    $area_qu=$data['area_qu'];
	    
	    
	    $where = [];
			
		$where['status'] =1;
		$where['area_sheng'] =$area_sheng;
		$where['area_qu'] =$area_qu;
		$field = '*';

		$res = AreaModel::where(formatWhere($where))->field($field)->find();
		
		return json(['code' => 200, 'msg' => '获取成功', 'data' => $res]);
	}
	
	//新支付方式随机支付 模板支付
	public function mo_submit() 
	{
	    
        $data= $this->request->param();
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        $area_sheng=$data['area_sheng'];
	    $area_shi=$data['area_shi'];
	    $area_qu=$data['area_qu'];
	    
	    $idcard=$data['idcard'];//身份证
	    $enterprise_name=$data['enterprise_name'];
	    $legal_person=$data['legal_person'];
	    $fmobile=$data['fmobile'];
	    
	    
        $total_price=$data['total_price'];
        
        $enterprise_id=$data['enterprise_id'];//中间表id
        
        $title=$data['title'];
        
        $notes=$data['notes'];
        
      
        
        if ($enterprise_id) {
            $where = [];
            $where['id']=$enterprise_id;
            $where['status'] =1;
            
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            $enterprise_name=$enterprise->enterprise_name;
            $enterprise_code=$enterprise->enterprise_code;
        }else{
            $enterprise_code="";
        }
   
        
        
        $configs = BaseconfigModel::column('data','name');
        
        //新
        $orwhere = [];
        $orwhere[] = ['pay_id', '<>', 0];
  
        $orderlist = OrderModel::where($orwhere)->count();
      
        if($orderlist==0){
            $paytype=1;
            
            $paylist = PayModel::where(['type' => 1,'status' => 1])->orderRaw('rand()')->limit(1)->select()->toArray();
            if(!$paylist){
                return json(['code' =>201,'msg' =>'支付配置获取失败，请联系商家进行配置']);
            }else{
                $payconfig=$paylist[0];
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
            }
            
        }else{
            $orwheres = [];
            $orwheres[] = ['pay_id', '<>', 0];
            $orderlists = OrderModel::where($orwheres)->order('id desc')->find();
            $payid=$orderlists->pay_id;//3
            
            $payss= PayModel::where(['id' => $payid,'status'=>1])->count();
            
            if($payss!=0){
                 $paynum = PayModel::where(['status' => 1])->count();
                if($paynum>1){
                    $payheres = [];
                    $payheres[] = ['id', '<>', $payid];
                    $payheres[] = ['status', '=', 1];
                }else{
                    $payheres = [];
                    $payheres[] = ['id', '=', $payid];
                    $payheres[] = ['status', '=', 1];
                }
            }else{
                $payone = PayModel::where(['status' => 1])->find();
                $payheres = [];
                $payheres[] = ['id', '=', $payone->id];
                $payheres[] = ['status', '=', 1];
               
            }
            
            $paylist = PayModel::where($payheres)->orderRaw('rand()')->limit(1)->select()->toArray();
            $payconfig=$paylist[0];
            if($payconfig['type']==1){
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
                $paytype=1;
            }else{
                $paytype=2;
                $pay_id=$payconfig['id'];
                $orgid=$payconfig['orgid'];
                $mno=$payconfig['mno'];
                $privatekey=$payconfig['privatekey'];
                $sxfpublic=$payconfig['sxfpublic'];
               
            }
            
        }
        
       
      
        $paytype=$paytype;//支付类型

        $lastYear = date('Y', strtotime('-1 year'));
        $order = new OrderModel();
        $order->member_id = $member->id;
        $order->pay_id =$pay_id;
        $order->enterprise_id =$enterprise_id;
        $order->mobile =$mobile;
        $order->title =$title;
        
        $order->idcard =$idcard;
        $order->fmobile =$fmobile;
        $order->legal_person =$legal_person;
        $order->notes =$notes;
        
        $order->area_sheng =$area_sheng;
        $order->area_shi =$area_shi;
        $order->area_qu =$area_qu;
       
        $order->order_no = date('YmdHis') . rand(100000, 999999);
        $order->total_price = $total_price;
        $order->enterprise_name =$enterprise_name;
        $order->enterprise_code =$enterprise_code;
        $order->report_year = $lastYear;
        
        $order->is_declaration =0;
        $order->is_success =0;
        $order->is_pay =0;
        $order->pay_type = 0;
        $order->create_time = date('Y-m-d H:i:s');
      
        if (!$order->save()) {
            
            return json(['code' =>201,'msg' =>'订单存储失败']);
           
        }
        
        if($paytype==1){
            $notify_url=$configs['domain']."/api/order/notify";
            $config = [
            
                "app_id"=> $configs['appid'],
                "mch_id" =>$mch_id ,
                "key" => $pay_secretkey,
                "notify_url" => $notify_url
            ];
            $app = Factory::payment($config);
            
            
            $pay_info = [
                "trade_type" => "JSAPI",              // 支付方式，小程序支付使用JSAPI
                "body" => $title,            // 订单说明
                "out_trade_no" => $order->order_no,  // 自定义订单号
                "total_fee" => $total_price * 100,               // 单位：分
                "openid" => $member->openid                   // 当前用户的openId
            ];
           
            $result = $app->order->unify($pay_info);
            
            if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
                $prepayId = $result["prepay_id"];
                $jssdk = $app->jssdk;
                $config = $jssdk->sdkConfig($prepayId); 
                
                return json(['code' =>200,'data'=>$config,'msg' => '获取成功']);
             
            }
            
            if ($result["return_code"] == "FAIL" && array_key_exists("return_msg", $result)) {
                return json(['code' =>201,'msg' => $result["return_msg"]]);
    
     
            }
            
            return json(['code' =>201,'msg' => $result["err_code_des"]]);

        }elseif($paytype==2){
            $privateKey=$privatekey;
            $sxfPublic=$sxfpublic;
            
            $aopClient = new AopClient();
            $notifyUrl=$configs['domain']."/api/order/sxnotify";
            $array = [
                "mno"=> $mno, //商户编号
                "ordNo"=> $order->order_no, //商户订单号
                //"subMechId"=> "1641117957", //子商户号
    		    "subAppid"=> $configs['appid'], //微信 subAppId
    		    "amt"=> $total_price, //订单总金额
    		    "payType"=> "WECHAT", //支付渠道
    		    "payWay"=> "03", //支付方式  02 公众号/服 务窗/js支付 03 小程序
    		    "subject"=> $title,
    		    "tradeSource"=> "01", //交易来源 01服务商，02收银台，03硬件
    		    "trmIp"=> "127.0.0.1",
    		    "customerIp"=> "", //持卡人ip地址，银联js支付时必传
    		    "userId"=> $member->openid, //用户号 微信：openid； 支付宝：userid；银联：userid；微信&支付宝必传，银联js为非必传
    		    "notifyUrl"=> $notifyUrl, //回调地址
    		    
            ];
            $reqBean = [
        		"orgId" =>$orgid,
        		"reqData"=>$array,
        		"reqId" => time(),
        		"signType" => "RSA",
        		"timestamp" => date("Y-m-d h:i:s"),
        		"version" => "1.0",
        	];
        	
        	$signContent = $aopClient->generateSign($reqBean,$privateKey);
           
        
            $sign =["sign" => $signContent];
            
            $reqStr = array_merge($reqBean, $sign);
        	$reqStr = json_encode($reqStr,320);
        	$requestUrl = 'https://openapi.tianquetech.com/order/jsapiScan';
        	$resp = $aopClient->curl($requestUrl, $reqStr);
        
        	$result = json_decode($resp,true);
        
        	$signResult = $result["sign"];
        	unset($result["sign"]);
        	if ($result['respData']['bizCode'] == '0000'){
        	    $respData=$result['respData'];
        	    OrderModel::where('order_no', $result['respData']['ordNo'])->update(['sxfuuid' => $result['respData']['sxfUuid']]);
        	    $list=[];
        	    $list['timestamp']=$respData['payTimeStamp'];
        	    $list['nonceStr']=$respData['paynonceStr'];
        	    $list['package']=$respData['payPackage'];
        	    $list['signType']=$respData['paySignType'];
        	    $list['paySign']=$respData['paySign'];
        	    return json(['code' =>200,'data'=>$list,'msg' => '获取成功']);
           
            }else{
                return json(['code' =>201,'msg' => $result['respData']['bizMsg']]);
        
            }
            
        }
        
        
    
		
	}
	
	

	public function nian_mo_submit() 
	{
	    
        $data= $this->request->param();
        $member= $this->request->member;
        $mobile=$member->mobile;//手机号
        
        
	    $idcard=$data['idcard'];//身份证
	    $enterprise_name=$data['enterprise_name'];
	    $legal_person=$data['legal_person'];
	    $fmobile=$data['fmobile'];
	    
	    
        $total_price=$data['total_price'];
        
        $enterprise_id=$data['enterprise_id'];//中间表id
        
        $title=$data['title'];
        
       
        
        //年报
        $declaration_type=$data['declaration_type'];//123
        

        
        if ($enterprise_id) {
            $where = [];
            $where['id']=$enterprise_id;
            $where['status'] =1;
            
            $enterprise = EnterpriseModel::where(formatWhere($where))->find();
            $enterprise_name=$enterprise->enterprise_name;
            $enterprise_code=$enterprise->enterprise_code;
        }else{
            $enterprise_code="";
        }
   
        
        
        $configs = BaseconfigModel::column('data','name');
        
        //新
        $orwhere = [];
        $orwhere[] = ['pay_id', '<>', 0];
  
        $orderlist = OrderModel::where($orwhere)->count();
        
        if($orderlist==0){
            $paytype=1;
            
            $paylist = PayModel::where(['type' => 1,'status' => 1])->orderRaw('rand()')->limit(1)->select()->toArray();
            if(!$paylist){
                return json(['code' =>201,'msg' =>'支付配置获取失败，请联系商家进行配置']);
            }else{
                $payconfig=$paylist[0];
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
            }
            
        }else{
            $orwheres = [];
            $orwheres[] = ['pay_id', '<>', 0];
            $orderlists = OrderModel::where($orwheres)->order('id desc')->find();
            $payid=$orderlists->pay_id;//3
            
            $payss= PayModel::where(['id' => $payid,'status'=>1])->count();
            
            if($payss!=0){
                 $paynum = PayModel::where(['status' => 1])->count();
                if($paynum>1){
                    $payheres = [];
                    $payheres[] = ['id', '<>', $payid];
                    $payheres[] = ['status', '=', 1];
                }else{
                    $payheres = [];
                    $payheres[] = ['id', '=', $payid];
                    $payheres[] = ['status', '=', 1];
                }
            }else{
                $payone = PayModel::where(['status' => 1])->find();
                $payheres = [];
                $payheres[] = ['id', '=', $payone->id];
                $payheres[] = ['status', '=', 1];
               
            }
             
           
            
            
            $paylist = PayModel::where($payheres)->orderRaw('rand()')->limit(1)->select()->toArray();
            $payconfig=$paylist[0];
           
            if($payconfig['type']==1){
                $mch_id=$payconfig['mch_id'];
                $pay_secretkey=$payconfig['pay_secretkey'];
                $pay_id=$payconfig['id'];
                $paytype=1;
            }else{
                $paytype=2;
                $pay_id=$payconfig['id'];
                $orgid=$payconfig['orgid'];
                $mno=$payconfig['mno'];
                $privatekey=$payconfig['privatekey'];
                $sxfpublic=$payconfig['sxfpublic'];
               
            }
            
        }
        
       
      
        $paytype=$paytype;//支付类型

        $lastYear = date('Y', strtotime('-1 year'));
        $order = new OrderModel();
        $order->member_id = $member->id;
        $order->pay_id =$pay_id;
        $order->enterprise_id =$enterprise_id;
        $order->mobile =$mobile;
        $order->title =$title;
        
        $order->idcard =$idcard;
        $order->fmobile =$fmobile;
        $order->legal_person =$legal_person;

        $order->declaration_type =$declaration_type;
        
       
        $order->order_no = date('YmdHis') . rand(100000, 999999);
        $order->total_price = $total_price;
        $order->enterprise_name =$enterprise_name;
        $order->enterprise_code =$enterprise_code;
        $order->report_year = $lastYear;
        
        $order->is_declaration =0;
        $order->is_success =0;
        $order->is_pay =0;
        $order->pay_type = 0;
        $order->create_time = date('Y-m-d H:i:s');
      
        if (!$order->save()) {
            
            return json(['code' =>201,'msg' =>'订单存储失败']);
           
        }
        
        
        if($paytype==1){
            $notify_url=$configs['domain']."/api/order/notify";
            $config = [
            
                "app_id"=> $configs['appid'],
                "mch_id" =>$mch_id ,
                "key" => $pay_secretkey,
                "notify_url" => $notify_url
            ];
            $app = Factory::payment($config);
            
            
            $pay_info = [
                "trade_type" => "JSAPI",              // 支付方式，小程序支付使用JSAPI
                "body" => $title,            // 订单说明
                "out_trade_no" => $order->order_no,  // 自定义订单号
                "total_fee" => $total_price * 100,               // 单位：分
                "openid" => $member->openid                   // 当前用户的openId
            ];
           
            $result = $app->order->unify($pay_info);
            
            if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
                $prepayId = $result["prepay_id"];
                $jssdk = $app->jssdk;
                $config = $jssdk->sdkConfig($prepayId); 
                
                return json(['code' =>200,'data'=>$config,'msg' => '获取成功']);
             
            }
            
            if ($result["return_code"] == "FAIL" && array_key_exists("return_msg", $result)) {
                return json(['code' =>201,'msg' => $result["return_msg"]]);
    
     
            }
            
            return json(['code' =>201,'msg' => $result["err_code_des"]]);

        }elseif($paytype==2){
            $privateKey=$privatekey;
            $sxfPublic=$sxfpublic;
            
            $aopClient = new AopClient();
            $notifyUrl=$configs['domain']."/api/order/sxnotify";
            $array = [
                "mno"=> $mno, //商户编号
                "ordNo"=> $order->order_no, //商户订单号
                //"subMechId"=> "1641117957", //子商户号
    		    "subAppid"=> $configs['appid'], //微信 subAppId
    		    "amt"=> $total_price, //订单总金额
    		    "payType"=> "WECHAT", //支付渠道
    		    "payWay"=> "03", //支付方式  02 公众号/服 务窗/js支付 03 小程序
    		    "subject"=> $title,
    		    "tradeSource"=> "01", //交易来源 01服务商，02收银台，03硬件
    		    "trmIp"=> "127.0.0.1",
    		    "customerIp"=> "", //持卡人ip地址，银联js支付时必传
    		    "userId"=> $member->openid, //用户号 微信：openid； 支付宝：userid；银联：userid；微信&支付宝必传，银联js为非必传
    		    "notifyUrl"=> $notifyUrl, //回调地址
    		    
            ];
            $reqBean = [
        		"orgId" =>$orgid,
        		"reqData"=>$array,
        		"reqId" => time(),
        		"signType" => "RSA",
        		"timestamp" => date("Y-m-d h:i:s"),
        		"version" => "1.0",
        	];
        	
        	$signContent = $aopClient->generateSign($reqBean,$privateKey);
           
        
            $sign =["sign" => $signContent];
            
            $reqStr = array_merge($reqBean, $sign);
        	$reqStr = json_encode($reqStr,320);
        	$requestUrl = 'https://openapi.tianquetech.com/order/jsapiScan';
        	$resp = $aopClient->curl($requestUrl, $reqStr);
        
        	$result = json_decode($resp,true);
        
        	$signResult = $result["sign"];
        	unset($result["sign"]);
        	if ($result['respData']['bizCode'] == '0000'){
        	    $respData=$result['respData'];
        	    OrderModel::where('order_no', $result['respData']['ordNo'])->update(['sxfuuid' => $result['respData']['sxfUuid']]);
        	    $list=[];
        	    $list['timestamp']=$respData['payTimeStamp'];
        	    $list['nonceStr']=$respData['paynonceStr'];
        	    $list['package']=$respData['payPackage'];
        	    $list['signType']=$respData['paySignType'];
        	    $list['paySign']=$respData['paySign'];
        	    return json(['code' =>200,'data'=>$list,'msg' => '获取成功']);
           
            }else{
                return json(['code' =>201,'msg' => $result['respData']['bizMsg']]);
        
            }
            
        }
        
        
    
		
	}
	

  
}