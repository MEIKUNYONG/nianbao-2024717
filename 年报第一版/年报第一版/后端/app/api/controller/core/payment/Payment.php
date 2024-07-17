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
class Payment extends Wxapp
{
	
	const PAY_TYPE_WECHAT = 'wechat';

	public function createOrder($paymentOrders, $user = null){
        $user = $user ?: $this->request->user;

        if (!is_array($paymentOrders)) {
            if ($paymentOrders instanceof PaymentOrder) {
                
                $paymentOrders = [$paymentOrders];
            } else {
                
                return ['msg'=>"`$paymentOrders`不是有效的PaymentOrder对象。",'code'=>201];
            }
        }
        if (!count($paymentOrders)) {
            return ['msg'=>"`$paymentOrders`不能为空。",'code'=>201];
        }
        $orderNos = [];
        $amount = 0;
        $title = '';
        foreach ($paymentOrders as $paymentOrder) {
             
            $orderNos[] = $paymentOrder['orderNo'];
            $amount = $amount + $paymentOrder['amount'];
           
            $title = $title . str_replace(';', '', $this->filter_emoji($paymentOrder['title'])) . ';';
        }
        sort($orderNos);
        $orderNos[] = $amount;
        $orderNos[] = time();
        $unionOrderNo = 'HM' . mb_substr(md5(json_encode($orderNos)), 2);
         
        $title = mb_substr($title, 0, 32);
        
        $paymentOrderUnion = new PaymentOrderUnion();
        $paymentOrderUnion->uniacid = $this->request->uniacid;
        $paymentOrderUnion->user_id = $user->id;
        $paymentOrderUnion->order_no = $unionOrderNo;
        $paymentOrderUnion->amount = $amount;
        $paymentOrderUnion->title = $title;
        $paymentOrderUnion->create_time = date('Y-m-d H:i:s');
        foreach ($paymentOrders as $paymentOrder) {
            $supportPayTypes = $paymentOrder['supportPayTypes'];
            if ($supportPayTypes) {
                $supportPayTypes = (array)$supportPayTypes;
            }
        }
        if (!empty($supportPayTypes) && is_array($supportPayTypes)) { 
            $appendPayTypes = [];
            foreach ($supportPayTypes as $index => $payType) {
                if ($payType == 'online_pay') {
                    $appendPayTypes[] = 'wechat';
                  
                    unset($supportPayTypes[$index]);
                    break;
                }
            }
            $supportPayTypes = array_merge($supportPayTypes, $appendPayTypes);
            
        }
       
        $paymentOrderUnion->support_pay_types = json_encode($supportPayTypes, JSON_UNESCAPED_UNICODE);
        try {
            
            if (!$paymentOrderUnion->save()) {
                return ['msg'=>"失败",'code'=>201];
            }
           
            foreach ($paymentOrders as $paymentOrder) {
                $model = new PaymentOrder();
        
                $model->payment_order_union_id = $paymentOrderUnion->id;
                $model->order_no = $paymentOrder['orderNo'];
                $model->amount = $paymentOrder['amount'];
                $model->title = $paymentOrder['title'];
                $model->notify_class = $paymentOrder['notifyClass'];
                $model->create_time = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    return ['msg'=>"失败2",'code'=>201];
                    
                }
            }
            
        } catch (\Exception $e) {
           
            throw $e;
        }
        return $paymentOrderUnion->id;
        
          

       
    }
    public function filter_emoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    public function getPayData($data)
    {


        $id=$data['id'];
        $payType=$data['pay_type'];
        $paymentOrderUnion = PaymentOrderUnion::find(['id' => $id]);
        
      
        if (!$paymentOrderUnion) {
          
            return ['msg'=>"待支付订单不存在。",'code'=>201];
        }
        
        $supportPayTypes = (array)json_decode($paymentOrderUnion->support_pay_types, true);
       
        if (!empty($supportPayTypes)
            && is_array($supportPayTypes)
            && !in_array($payType, $supportPayTypes)) {
            if ($paymentOrderUnion->amount != 0) { // 订单金额为0时使用余额支付
                return ['msg'=>"该订单不支持此支付方式。",'code'=>201];
               
            }
        }
      
        switch ($payType) {
           
            case static::PAY_TYPE_WECHAT:
                
                $data = [
                    'pay_type' => $payType,
                    'id' => $paymentOrderUnion->id,
                    'order_amount' => $paymentOrderUnion->amount,
                    'title' => $paymentOrderUnion->title,
                    'order_no'=>$paymentOrderUnion->order_no,
                ];
           
                  
                $wechat = new Wechat($this->app);
                $code = $wechat->pay($data);
                return $code;
              
                break;
            default:
                throw new PaymentException('未知的`payType`。');
                break;
        }
       
         
        
        
        
    }
    public function price_format($val, $returnType = 'string', $decimals = 2)
    {
        $val = floatval($val);
        $result = number_format($val, $decimals, '.', '');
      
        return $result;
    }
    

}