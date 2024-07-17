<?php

namespace app\api\controller;

use think\exception\ValidateException;

use app\admin\model\Member as MemberModel;
use app\admin\model\Address as AddressModel;

class Address extends Wxapp
{
    /**
     * 登录
     */
    public $middleware = [\app\api\middleware\ApiMiddleware::class];
    public function getlist()
    {
        $where = [];
		$where['user_id']=$this->request->user_id;
			
		$field = '*';
        $address = AddressModel::where(formatWhere($where))->field($field)->select();
     
        
        $data = ['code' =>200,'data'=>$address,'msg' => '获取成功'];
        return json($data);

        
    }
    
    public function getadd()
    {
        $data= $this->request->param();
        $detail=$data['detail'];
        $house_num=$data['house_num'];
        $name=$data['name'];
        $mobile=$data['mobile'];
        $longitude=$data['longitude'];
        $latitude=$data['latitude'];
      
        $address = new AddressModel();
        $address->user_id=$this->request->user_id;
        $address->house_num=$house_num;
        $address->detail=$detail;
        $address->name=$name;
        $address->mobile=$mobile;
        $address->longitude=$longitude;
        $address->latitude=$latitude;
        
        
        
        $datas = $detail;
        
        preg_match('/.*省/', $datas,$provinces_arr);
        $datas=preg_replace ( '/.*省/' , '', $datas );
        preg_match('/.*市/', $datas,$city_arr);
        $datas=preg_replace ( '/.*市/' , '', $datas );
        preg_match('/.*区/', $datas,$region_arr);
        $datas=preg_replace ( '/.*区/' , '', $datas );
        preg_match('/.*(街道|街)/', $datas,$street_arr);
        if(count($provinces_arr)>0){
            $provinces_name=$provinces_arr[0];
        }else{
            $provinces_name=$city_arr[0];
        }
        if(count($city_arr)>0){
            $city_name=$city_arr[0];
        }else{
            $city_name='无';
        }
        if(count($region_arr)>0){
            $region_name=$region_arr[0];
        }else{
            $region_name='无';
        }
        if(count($street_arr)>0){
            $street_name=$street_arr[0];
        }else{
            $street_name='无';
        }
     
        $address->province = $provinces_name;/* 省 */
         
        $address->city = $city_name;/* 市 */
         
        $address->district = $region_name;/* 区 */
        
        
        if ($address->save()) {
           $data = ['code' =>200,'msg' => '添加成功'];
        }else {
           $data = ['code' =>100,'msg' => '添加失败'];
        }
     
        return json($data);

        
    }
    
    public function getdelete()
    {
        $data= $this->request->param();
        $id=$data['id'];
        $where = [];
		$where['user_id']=$this->request->user_id;
		$where['id']=$id;
			
		$field = '*';
        $address = AddressModel::where(formatWhere($where))->field($field)->find();
        
        if ($address->delete()) {
           $data = ['code' =>200,'msg' => '成功'];
        }else {
           $data = ['code' =>100,'msg' => '失败'];
        }
     
        return json($data);

        
    }
  



    
 
}