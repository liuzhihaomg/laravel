<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PermissionController extends CommonController
{
    /***
     * 录入权限展示页面
     */
    public function entering_permission(){
        #查询左侧菜单栏
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        #查出所有的一级菜单
        $power_node_data=DB::table('crm_power_node')->where(['parent_id'=>0,'status'=>1])->get()->toArray();
        $power_node_data=json_decode(json_encode($power_node_data),true);
        return view('Admin.Permission.entering_permission',['power_node_data'=>$power_node_data,'new_node'=>$new_node]);
    }
    /***
     * 权限的添加
     */
    public function permission_add(){
        $input=Input::all();
        $level="";
        if($input['parent_id']==0){
            $level=1;
        }else{
            $level=2;
        }
        $data=[
            'power_name'=>$input['power_name'],
            'url'=>$input['url'],
            'parent_id'=>$input['parent_id'],
            'status'=>1,
            'level'=>$level,
            'ctime'=>time()
        ];
        $res=DB::table('crm_power_node')->insertGetId($data);
        if($res){
            return $this->success('权限添加成功');
        }else{
            return $this->fail('添加权限失败');
        }
    }
}
