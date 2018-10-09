<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员添加</title>
    @include("Admin/public/style")
</head>
<body>
<!-- 顶部开始 -->
@include("Admin/public/header")
        <!-- 顶部结束 -->
<!-- 中部开始 -->
<div class="wrapper">
    <!-- 左侧菜单开始 -->
    @include("Admin/public/left")
            <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="content">
            <!-- 右侧内容框架，更改从这里开始 -->
            <div class="layui-form">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">管理员账号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="admin_name" lay-verify="text" placeholder="请输入管理员账号" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">管理员密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="admin_psd" lay-verify="required|number"placeholder="请输入管理员密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="admin_pwd" lay-verify="pass" placeholder="请输入管理员密码" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">真实姓名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="real_name" lay-verify="pass" placeholder="请输入管理员真实姓名" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" lay-verify="pass" placeholder="请输入管理员手机号" autocomplete="off" class="layui-input">
                    </div>
                </div>


                <div class="layui-form-item">
                    <label class="layui-form-label">是否启用</label>
                    <div class="layui-input-block">
                        <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                    </div>
                </div>

                <div class="layui-form-item" pane="">
                    <label class="layui-form-label">分配角色</label>
                    <div class="layui-input-block">
                        @foreach( $crm_admin_role_data as $v )
                            <input type="checkbox" name="role" lay-skin="primary" valie="{{$v['id'] }}" title="{{ $v['role_name']  }}">
                        @endforeach
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">备注</label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" type="button" lay-filter="demo1">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </div>
            <!-- 右侧内容框架，更改从这里结束 -->
        </div>
    </div>
    <!-- 右侧主体结束 -->
</div>
<!-- 中部结束 -->
<!-- 底部开始 -->
<div class="footer">
    <div class="copyright">Copyright ©2017 x-admin v2.3 All Rights Reserved. 本后台系统由X前端框架提供前端技术支持</div>
</div>
<!-- 底部结束 -->
<!-- 背景切换开始 -->
@include("Admin/public/background")
        <!-- 背景切换结束 -->
</body>
</html>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
    $('.layui-btn').click(function(){
        var admin_name=$('[name=admin_name]').val();
        if(admin_name==''){
            layer.msg('管理员账号不能为空',{time:2000})
            return false;
        }

        var admin_psd=$('[name=admin_psd]').val();
        if(admin_psd==''){
            layer.msg('管理员密码不能为空',{time:2000})
            return false;
        }

        var admin_pwd=$('[name=admin_pwd]').val();
        if(admin_pwd==''){
            layer.msg('管理员确认密码不能为空',{time:2000})
            return false;
        }
        if(admin_psd!=admin_pwd){
            layer.alert('密码与确认密码需要一致☺', {
                skin: 'layui-layer-molv' //样式类名
                ,closeBtn: 0
            });
            return false;
        }

        var real_name=$('[name=real_name]').val();
        if(real_name==''){
            layer.msg('真实姓名不能为空',{time:2000})
            return false;
        }

        var phone=$('[name=phone]').val();
        if(phone==''){
            layer.msg('手机号不能为空',{time:2000})
            return false;
        }

        var str="";
        var link=false;
        $('[name=role]').each(function (){
            if($(this).prop('checked')==true) {
                str+=$(this).attr('valie')+',';
                link = true;
            }
            })
        if(link==false){
            layer.alert('角色至少选择一项☺', {
                skin: 'layui-layer-molv' //样式类名
                ,closeBtn: 0
            });
            return false;
        }

        var textarea=$('.layui-textarea').val();
        if(textarea==''){
            layer.msg('备注不能为空',{time:2000})
            return false;
        }
        //ajax发送数据进行添加权限
        $.ajax({
            //请求的路径
            url: "administrator_do",//你的路由地址url :‘/register_phone’
            //数据传输
            data: 'admin_name=' + admin_name + '&admin_psd=' + admin_psd + '&real_name=' + real_name + '&phone=' + phone+'&str=' + str+'&textarea=' + textarea,
            //请求方式
            type: 'post',
            //返回数据类型  json|html|xml
            dataType: 'json',
            //回调方法
            success: function (info) {
                if(info.status==1000){
                    layer.msg(info.msg,{time:2000},function(){
                        history.go(0)
                    })
                }else{
                    layer.msg(info.msg,{time:2000})
                }
            }
        })

    })

</script>