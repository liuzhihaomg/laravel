<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends CommonController
{
   public function order(){
       $user_info=$this->sessioninfo();
       $new_node=$this->judge_admin($user_info['admin_id']);
       //生成订单编号
       $order_no = md5(date('Ymd').rand(1000,9999).$user_info['admin_id']);
       //添加时间
       $time = date('Y-m-d');
       return view('Admin.order.order_add',['new_node'=>$new_node,'order_no'=>$order_no,'time'=>$time]);
   }
    /**
     * 添加订单
     */
    public function order_add_do(){
        //接受数据
        $arr = $_POST;
        $arr['order_status'] = 1;
        //添加数据
        $id = DB::table('crm_order') -> insertGetId($arr);
        if(empty($id)){
            return  ['status'=>1,'msg'=>'添加失败'];
        }else{
            return  ['status'=>1000,'msg'=>'添加成功'];
        }
    }
    /**
     * 展示订单
     */
    public function order_list(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        //查询订单表
        $order_list = DB::table('crm_order') -> where('order_status','=',1) ->  get() ;
        $order_list = json_decode(json_encode($order_list),true);
        return view('Admin.order.order_list',['new_node'=>$new_node,'order_list'=>$order_list]);
    }

    /**
     * 删除订单
     */
    public function order_delete(){
        //接受要删除的id
        $order_id = $_POST['order_id'];
        //根据id删除数据
        $num = DB::table('crm_order')->where('order_id',$order_id)->update(['order_status'=>2]);

        if( $num > 0  ){
            return ['status'=>1000 , 'msg'=> '删除成功'];
        }else{
            return ['status'=>1 , 'msg'=> '删除失败'];
        }
    }

    //修改订单
    public  function order_update(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        //接受要修改的id
        $order_id = $_POST['order_id'];
        //根据id查询数据
        $data = DB::table('crm_order') -> where('order_id','=',$order_id) -> get();
        $data = json_decode(json_encode($data),true);
        return view('Admin.order.order_list',['new_node'=>$new_node,'data'=>$data]);
    }
}
