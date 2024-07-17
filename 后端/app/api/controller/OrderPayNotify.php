<?php 

namespace app\api\controller;
use app\admin\model\Order as OrderModel;
use think\exception\ValidateException;
use think\facade\Request;
use app\admin\model\OrderDetail;
use app\admin\model\PaymentOrderUnion;
use app\admin\model\PaymentOrder;

use EasyWeChat\Factory;
use think\App;
use app\api\BaseController;
class OrderPayNotify extends BaseController
{
    protected $app;
    public function __construct(App $app)
    {
        parent::__construct($app);
        //$con = config('web');
       
        $notify_url=url("api/OrderPayNotify/notify",[],'',true)->build();
        $config = [
           
            'app_id'             => $app_id,
            'mch_id'             => $mch_id,
            'key'                => $key,
            'notify_url' => $notify_url,//异步回调通知地址
           
        ];
       
        $this->app = Factory::payment($config);
       
    }
    
    public function notifys($paymentOrder)
    {
      
        try {
            $order = OrderModel::where([
                'order_no' => $paymentOrder['orderNo'],
            ])->find();
            
            if (!$order) {
             
                return ['msg'=>"订单不存在。",'code'=>201];
           
            }
            $order->is_pay = 1;
                   
            switch ($paymentOrder['payType']) {
               case 'wechat':
                    $order->pay_type = 1;
                    break;
                default:
                    break;
            }
            $order->pay_time = date('Y-m-d H:i:s');
            $order->save();

            return true;
        } catch(\Exception $exception) {
            
            return false;
        }
    }
     
    
    /*
     * 支付回调
     */
    public function notify(){
        
        
        $response=$this->app->handlePaidNotify(function ($message, $fail) {
            $out_trade_no = $message['out_trade_no'];//订单号
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                if (isset($message['result_code']) && $message['result_code'] === 'SUCCESS') {
                    //付款成功
                    $payment= PaymentOrderUnion::where([
                        'order_no' => $out_trade_no,
                    ])->find();
                    if (!$payment) {
                        return ['msg'=>"订单不存在。". $res['out_trade_no'],'code'=>201];
                        
                    }
                    $paymentorders = PaymentOrder::where(['payment_order_union_id' => $payment->id])->select();
                    $payment->is_pay = 1;
                    $payment->pay_type = 1;
                    $payment->save();
                    
                    foreach ($paymentorders as $paymentorder) {
                        $paymentorder->is_pay = 1;
                        $paymentorder->pay_type = 1;
                        $paymentorder->save();
                        $po = [
                            'orderNo' => $paymentorder->order_no,
                            'amount' => (float)$paymentorder->amount,
                            'title' => $paymentorder->title,
                            'notifyClass' => $paymentorder->notify_class,
                            'payType' => "wechat",
                        ];
                        $this->notifys($po);
                    }
                 
       
                } elseif (isset($message['result_code']) && $message['result_code'] === 'FAIL') {
                    //付款失败
                    return $message['result_code'];

                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }
            // 你的逻辑
            return true;
        });
       return $response;
    }
    
}