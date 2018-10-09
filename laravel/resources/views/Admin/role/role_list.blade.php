<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>角色展示</title>
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
            <xblock><button class="layui-btn layui-btn-danger" name="delete"><i class="layui-icon">&#xe640;</i>批量删除</button><span class="x-right" style="line-height:40px">共有数据：{{ $crm_amdin_role_count  }} 条</span></xblock>
            <table class="layui-table">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="checkall">
                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        角色名称
                    </th>
                    <th>
                        添加时间
                    </th>

                    <th>
                        操作
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($crm_amdin_role_data as $v)
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <tr>
                    <td>
                        <input type="checkbox" value="{{ $v['id']  }}" name="sub" class="all">
                    </td>
                    <td>
                        {{ $v['id']  }}
                    </td>
                    <td>
                        {{ $v['role_name']  }}
                    </td>
                    <td>
                        {{ $v['ctime'] }}
                    </td>
                    <td class="td-manage">
                        <a title="删除" href="javascript:;" onclick="view_del(this,'{{ $v['id']  }}')"
                           style="text-decoration:none">
                            <i class="layui-icon">&#xe640;</i>
                        </a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
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
<!-- 页面动态效果 -->
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
    layui.use(['laydate'], function(){
        laydate = layui.laydate;//日期插件

        //以上模块根据需要引入

    });

//批量删除
    $('[name=checkall]').on('click',function(){
        if(this.checked) {
            $("input[name='sub']").attr('checked',true);
        }else {
            $("input[name='sub']").attr('checked',false);
        }
    });

    $('[name=delete]').click(function(){
        var id_all='';
        $('.all').each(function(){
            if($(this).prop('checked')==true){
                id_all+=$(this).val()+',';
            }
        });
        if(id_all==''){
            alert('请选择要删除的角色')
        }
    });



    /*浏览-删除*/
    function view_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                //请求的路径
                url: "role_del",//你的路由地址url :‘/register_phone’
                //数据传输
                data: 'id='+id,
                //请求方式
                type: 'post',
                //返回数据类型  json|html|xml
                dataType: 'json',
                //回调方法
                success: function (info) {
                    if(info.status==1000){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }else{
                        layer.msg('删除失败!',{icon:1,time:1000});
                    }
                }
            });
        });
    }
</script>
</body>
</html>