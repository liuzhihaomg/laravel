<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台登录-X-admin1.1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="backstage/css/font.css">
    <link rel="stylesheet" href="backstage/css/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <script src="backstage/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="backstage/js//xadmin.js"></script>

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
            <form class="layui-form">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">权限名称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="power_name" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">访问路径</label>
                        <div class="layui-input-inline">
                            <input type="text" name="url" lay-verify="required|number" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">父级权限</label>
                    <div class="layui-input-inline">
                        <select name="quiz1">
                            <option value="0">请选择</option>
                            @foreach($power_node_data as $v)
                            <option value="{{ $v['id']  }}">{{ $v['power_name']  }}</option>
                                @endforeach
                        </select>
                    </div>
                    </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否启用</label>
                    <div class="layui-input-block">
                        <input type="checkbox" checked  name="open" opens="1" lay-skin="switch"  lay-text="ON|OFF">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" type="button" lay-filter="demo1">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
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
        //获取权限名称
        var power_name=$('[name=power_name]').val();
        //获取访问路径
        var url=$('[name=url]').val();
        //获取父极权限id
        var parent_id=$('[name=quiz1]').val();
        //获取是否启用(默认启用)
         var status=0;
        var radio=$('[name=open]').prop('checked');
            if(radio==true){
                status=1;
            }else{
                status=2;
            }
        //ajax发送数据进行添加权限
        $.ajax({
            //请求的路径
            url: "permission_add",//你的路由地址url :‘/register_phone’
            //数据传输
            data: 'power_name=' + power_name + '&url=' + url+ '&parent_id=' + parent_id+ '&status=' + status,
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