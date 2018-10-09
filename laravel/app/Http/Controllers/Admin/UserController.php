<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
class UserController extends CommonController
{
    public function user_add(){
        //客户来源
        $source=DB::table('crm_user_source')->get();
        $source=json_decode(json_encode($source),true);

        //客户类型
        $type=DB::table('crm_user_type')->get();
        $type=json_decode(json_encode($type),true);

        $province_list=DB::table('crm_area')->where(['area_parent_id'=>0])->get();
        $province_list=json_decode(json_encode($province_list),true);
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        return view('Admin.user.user_add',['new_node'=>$new_node,'province_list'=>$province_list,'source'=>$source,'type'=>$type]);
    }

    public function user_address(){
            $id = $_POST['id'];
            $city_list =DB::table('crm_area')->where(['area_parent_id'=>$id])->get();
            $city_list=json_decode(json_encode($city_list),true);
            echo json_encode(
                [
                    'data' => $city_list
                ]
            );exit;
    }

    public function user_add_do(){
        $arr=Input::post();
        $arr['user_status']=1;
        $arr['ctime']=time();
        $user_name=DB::table('crm_user')->where(['user_name'=>$arr['user_name']])->get();

        if(!$user_name){
            echo json_encode(['status'=>0,'msg'=>'用户名已存在']);
            exit;
        }
        $res=DB::table('crm_user')->insert($arr);
        if($res){
            echo json_encode(['status'=>1000,'msg'=>'添加成功']);
        }else{
            echo json_encode(['statsu'=>1000,'msg'=>'添加失败']);
        }
    }
}
