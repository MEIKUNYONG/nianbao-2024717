<?php 

namespace app\api\controller;
use app\admin\model\Order as OrderModel;
use think\exception\ValidateException;

class OrderSubmit extends Wxapp
{
	/** @var User $user */
    public $user;

    /** @var array $data */
    public $form_data;

    /** @var string $token */
    public $token;

  
    public $status;

    public function orderadd($datas)
    {
        
        $this->user=$datas['user'];
        $this->form_data=$datas['form_data'];
        $this->token=$datas['token'];
        $this->status=$datas['status'];
     
        $oldOrder = OrderModel::where(['token' => $this->token, 'is_delete' => 0])->find();
        if ($oldOrder) {
            return json(['msg'=>'重复下单','code'=>201]);
            
        }
        $form = new Order($this->app);
        $form->form_data = $this->form_data;
        $data = $form->getAllData();
      
       // $mchItem=$data['mch_list'];
        
        foreach ($data['mch_list'] as $mchItem) {
          
            $order = new OrderModel();
            $order->uniacid = $this->request->uniacid;
            $order->user_id = $this->user->id;
            $order->order_no = date('YmdHis') . rand(100000, 999999);
            $order->total_price = $mchItem['total_price'];
            $order->total_pay_price = $mchItem['total_price'];
    
            $order->total_goods_price = $mchItem['total_goods_price'];
            $order->total_goods_original_price = $mchItem['total_goods_original_price'];
            $order->name = $data['address'] ? $data['address']['name'] : '昵称';
            $order->mobile = $data['address'] ? $data['address']['mobile'] : '1555555555';
            
            $order->remark = $mchItem['remark'];
            $order->order_form = $mchItem['order_form_data'];
        
            
            // $order->address = $data['address']['province']. ' '. $data['address']['city']
            //                 . ' '
            //                 . $data['address']['detail'];
            $order->address_id=$data['address']['id'];
            $order->address=$data['address']['detail'];
            
           
            $order->words = '';
            $order->is_pay = 0;
            $order->pay_type = 0;
            $order->is_send = 0;
            $order->is_confirm = 0;
            $order->is_sale = 0;
            $order->support_pay_types = [];
            $order->token = $this->token;
            $order->status = $this->status;
            $order->create_time = date('Y-m-d H:i:s');
            if (!$order->save()) {

                return json(['msg'=>'失败','code'=>201]);
                 
            }
            $orderDetails = [];
       
            foreach ($mchItem['goods_list'] as $goodsItem) {
                  
                   
                   $orderDetails[] = $form->extraGoodsDetail($order, $goodsItem);
         
            }
          
        }
 
    }
}