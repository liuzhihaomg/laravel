<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class RoleController extends CommonController
{
    /***
     * 角色添加页面
     */
    public function role_add(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        return view('Admin.role.role_add',['new_node'=>$new_node]);
    }

    /***
     * 执行添加
     */
    public function role_do(){
        $input=Input::all();
        $title=$input['title'];
        if(empty($title)){
            return $this->fail('角色名称不能为空');
        }

        $status=input::post('switch',1);
        if($status =='on'){
            $status=2;
        }
//        DB::beginTransaction();
        $node_list=input::post('node');
        $insert=[];
        $insert['role_name']=$title;
        $insert['status']=$status;
        $insert['ctime']=time();
        $insert_id=DB::table('crm_admin_role')->insertGetId($insert);

        if(!empty($insert_id)) {
            $role_node = [];
            foreach ($node_list as $k => $v) {
                $role_node[$k]['role_id'] = $insert_id;
                $role_node[$k]['node_id'] = $v;
            }
            $node_data=array_values($role_node);
            $res=DB::table('crm_role_node')->insert($node_data);
            if($insert_id && $res){
                return $this->success('添加成功');
                DB::commit();
            }else{
                DB::rollBack();
                return $this->fail('添加失败');
            }
        }
    }
    /***
     * 角色展示
     */
    public function role_list(){
        $user_info=$this->sessioninfo();
        $new_node=$this->judge_admin($user_info['admin_id']);
        $crm_amdin_role_data=DB::table('crm_admin_role')->get()->toArray();
        $crm_amdin_role_data=json_decode(json_encode($crm_amdin_role_data),true);
        foreach($crm_amdin_role_data as $k=>$v){
            $crm_amdin_role_data[$k]['ctime']=date('Y-m-d H:i:s',$v['ctime']);
        }
        $crm_amdin_role_count=DB::table('crm_admin_role')->count();
        return view('Admin.role.role_list',['new_node'=>$new_node,'crm_amdin_role_data'=>$crm_amdin_role_data,'crm_amdin_role_count'=>$crm_amdin_role_count]);
    }

    /***
     * 角色删除
     */
    public function role_del(){
        $input=Input::all();
        DB::beginTransaction();
        $id=$input['id'];
        $res=DB::table('crm_admin_role')->where(['id'=>$id])->delete();;
        $node_res=DB::table('crm_role_node')->where(['role_id'=>$id])->delete();
        if($res && $node_res){
            DB::commit();
            return $this->success();
        }else{
            DB::rollBack();
            return $this->fail();
        }
    }
    /****
     * 角色批量删除
     */
    public function role_delete(){
        $input=Input::all();
        $id=$input['id'];
        //开启事物
        DB::beginTransaction();
        $id=rtrim($id,',');
        $arr=explode(',',$id);
        $res=DB::table('crm_admin_role')->whereIn('id',$arr)->delete();
        $node_res=DB::table('crm_role_node')->whereIn('role_id',$arr)->delete();
        if($res && $node_res){
            DB::commit();
            return $this->success('批量删除成功');
        }else{
            DB::rollBack();
            return $this->fail('批量删除失败');
        }
    }
}
