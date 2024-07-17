<?php 

namespace app\api\controller;
use app\admin\model\Order as OrderModel;
use think\exception\ValidateException;
use think\facade\Request;
use app\admin\model\OrderDetail;
use app\api\controller\core\payment\Payment;
class OrderPay extends Wxapp
{
	public $token;
	public function getResponseData($data){
        $this->token=$data['token'];
        //$user_id=2;
        $orders = OrderModel::where([
        	"uniacid"=>$this->request->uniacid,
            'token' => $this->token,
            'is_delete' => 0,
            'user_id' =>$this->request->user->id,
        ])->select();
        if (!$orders || !count($orders)) {
            
            return [
                'code' => 201,
                'msg' => '订单不存在或已失效。',
            ];
        }
        
        return $this->getReturnData($orders);
        
    }
    protected function getReturnData($orders)
    {
        $supportPayTypes =[];
        if (!count($supportPayTypes)) {
            $supportPayTypes = [
               'wechat',
            ];
        }
        $paymentOrders = [];
        foreach ($orders as $order) {
            $totalPayPrice = $order->total_pay_price;
            
            
            $paymentOrder =[
                'title' => $this->getOrderTitle($order),
                'amount' => (float)$totalPayPrice,
                'orderNo' => $order->order_no,
                'notifyClass' => OrderPayNotify::class,
                'supportPayTypes' => $supportPayTypes,
            ];
            $paymentOrders[] = $paymentOrder;
        }
        $id = $this->createOrder($paymentOrders);
         return [
            'code' => 200,
            'data' => [
                'id' => $id,
            ],
        ];
     
    }
    public function createOrder($paymentOrders)
    {

        $class = new Payment($this->app);
        $id=$class->createOrder($paymentOrders);
        return $id;
    }

    
    /**
     * @param Order $order
     */
    private function getOrderTitle($order)
    {
        /** @var OrderDetail[] $details */

        
        // $details = $order->getDetail()->where(['is_delete' => 0])->with('goods')->select();
        
        // if (!$details || !count($details)) {
        //     return $order->order_no;
        // }
         
        // $titles = [];
        // foreach ($details as $detail) {
          
        //     if (!$detail->goods) {
        //         return;
        //     }
        //     $titles[] = $detail->goods->name;
        // }
        $title = "{观赛季}CG16香辣鸡腿堡1人餐";
         
        if (mb_strlen($title) > 32) {
            return mb_substr($title, 0, 32);
        } else {
            return $title;
        }
    }
    
    

}