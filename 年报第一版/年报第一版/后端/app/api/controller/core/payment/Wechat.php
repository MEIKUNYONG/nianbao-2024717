<?php 

namespace app\api\controller\core\payment;
use app\admin\model\Order as OrderModel;
use think\exception\ValidateException;
use think\facade\Request;
use app\admin\model\OrderDetail;

use app\api\controller\core\payment\Wechat;
use app\api\controller\Wxapp;

use app\admin\model\PaymentOrderUnion;
use app\admin\model\PaymentOrder;
use EasyWeChat\Factory;
use think\App;
class Wechat extends Wxapp
{
	public $middleware = [\app\api\middleware\ApiMiddleware::class];
	protected $app;

	public function __construct(App $app)
    {
        parent::__construct($app);
        //$con = config('web');
        $app_id =  "";
        $mch_id =  "";
        $key=  "";
        $notify_url=url("api/OrderPayNotify/notify",[],'',true)->build();
        $config = [
            
            'app_id'             => $app_id,
            'mch_id'             => $mch_id,
            'key'                => $key,
            'notify_url' => $notify_url,//异步回调通知地址
        ];
        
        $this->app = Factory::payment($config);
        
     
    }
    public function pay($data)
    {
       
    
    	$amount = $data['order_amount'] * 100; //金额
        //$product_id = $data['id'];//产品ID必传，自定义
        $out_trade_no=$data['order_no'];//商户订单号
        $description=$data['title'];//商品描述

        $result = $this->app->order->unify([
            'trade_type' => 'JSAPI',
            'body'=>$description,
            'out_trade_no' => $out_trade_no,
            'notify_url' => url("api/OrderPayNotify/notify",[],'',true)->build(), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'total_fee' => $amount,
            "openid" => $this->request->user->openid // 当前用户的openId
        ]);
       

        if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
          
           $jssdk = $this->app->jssdk;
           $config = $jssdk->bridgeConfig($result['prepay_id'],false); // 返回数组
         
           
            return ['code' => 200, 'config' => $config];
        }

        if ($result["return_code"] == "FAIL" && array_key_exists("return_msg", $result)) {

            return $fail("错误：" .  $result["return_msg"]);
        }

        return $fail("错误" .  $result["err_code_des"]);

    	
    }


}