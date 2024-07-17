<?php 

namespace app\api\controller;
use app\admin\model\Order as OrderModel;
use think\exception\ValidateException;
use think\facade\Request;
use app\admin\model\OrderDetail;

use app\api\controller\core\payment\Wechat;

use app\api\controller\core\payment\Payment as PaymentModel;
class Payment extends Wxapp
{
	public $middleware = [\app\api\middleware\ApiMiddleware::class];
	public function paydata()
    {

       
        $payment = new PaymentModel($this->app);
        $payData = $payment->getPayData(Request::get());
      
        return json($payData);
        /*return [
            'code' => 200,
            'data' => $payData,
            
        ];*/
    }
    
}