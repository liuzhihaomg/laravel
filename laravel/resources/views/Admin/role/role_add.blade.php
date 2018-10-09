<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>角色添加</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="backstage/css/font.css">
    <link rel="stylesheet" href="backstage/css/xadmin.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    {{--<script src="backstage/lib/layui/layui.js" charset="utf-8"></script>--}}
    <script src="backstage/tmplayui/layui.js"></script>
    <script type="text/javascript" src="backstage/js//xadmin.js"></script>


    {{--<script src="backstage/jquery-3.2.1.min.js"></script>--}}
    {{--<link rel="stylesheet" href="backstage/tmplayui/css/layui.css">--}}
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
            <form class="layui-form" action="" style="margin-top: 20px">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">角色名称</label>
                        <div class="layui-input-inline">
                            <input type="tel" name="title" lay-verify="required"
                                   placeholder="请输入角色名称" autocomplete="off" class="layui-input" style="width:212px">
                        </div>
                    </div>
                </div>



                <div class="layui-form-item">
                    <label class="layui-form-label">是否启用</label>
                    <div class="layui-input-block">
                        <input type="checkbox"  name="switch" lay-skin="switch" lay-filter="switchTest" >
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">权限节点</label>
                    <div class="layui-input-block">
                        @foreach($new_node as $v)
                            <fieldset class="layui-elem-field" style="width: 500px;">
                                <legend><input type="checkbox"  name="node[]" value="{{ $v['id'] }}" lay-skin="primary" lay-filter="one" title="{{ $v['power_name']  }}" ></legend>
                                <div class="layui-field-box" style="margin-left:50px;">
                                    @foreach($v['son'] as $vv)
                                        <input type="checkbox"  name="node[]" value="{{ $vv['id'] }}" lay-skin="primary" lay-filter="two" title="{{ $vv['power_name']  }}">
                                  @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit type="button" lay-filter="formDemo">立即提交</button>
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
    layui.use('form', function(){
        var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        //layui checkbox点击事件   --- 一级菜单的点击事件
        form.on('checkbox(one)', function (data) {
//            console.log($(this).parents('fieldset').find('input').eq(0).prop('checked'));
            if ($(this).parents('fieldset').find('input').eq(0).prop('checked') == true) {
             $(this).parents('fieldset').find('input').prop('checked', true);
            } else {
                $(this).parents('fieldset').find('input').prop('checked', false);
            }
            form.render();
        });

        //layui 二级点击事件
        form.on('checkbox(two)', function (data) {
            var mark = 0;
            $(this).parents('fieldset').find('input:gt(0)').each(function(){
                if( $(this).prop('checked') == true){
                    mark = 1;
                }
            });
            if( mark == 1 ){
                $(this).parents('fieldset').find('input').eq(0).prop('checked', true);
            } else {
                $(this).parents('fieldset').find('input').eq(0).prop('checked', false);
            }
            form.render();
        });

        //监听提交
        form.on('submit(formDemo)', function (data) {
            $.ajax({
                url:'role_do',
                data:data.field,
                dataType:'json',
                type:'post',
                async:false,
                success:function(json_info){
                    if(json_info.status == 1000){
                        layer.msg(json_info.msg,{time:2000},function(){
                            history.go(0)
                        })
                    }else{
                        alert(json_info.msg);
                    }
                }
            })
//                layer.msg(JSON.stringify(data.field));
            return false;
        })
//
    });
</script>
