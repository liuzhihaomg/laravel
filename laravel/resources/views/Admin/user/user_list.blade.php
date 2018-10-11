<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员展示</title>
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

            <span class="x-right" style="line-height:40px">共有数据：{{ $user_count  }} 条</span>

            <form>

                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            客户姓名
                        </th>
                        <th>
                            客户手机号
                        </th>
                        <th>
                            客户所在地
                        </th>
                        <th>
                            客户类型
                        </th>
                        <th>
                            客户来源
                        </th>
                        <th>
                            备注
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $user_data as $v )
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <tr>
                            <td>
                                {{ $v['user_id'] }}
                            </td>
                            <td>
                                {{ $v['user_name']  }}
                            </td>
                            <td>
                                {{ $v['user_phone'] }}
                            </td>
                            <td>
                                所在地
                            </td>
                            <td>
                                客户类型
                            </td>
                            <td >
                                客户来源
                            </td>
                            <td >
                                {{ $v['user_remark'] }}
                            </td>
                            <td class="td-manage">
                                <a title="删除" href="javascript:;" onclick="view_del(this,'{{ $v['admin_id']  }}')"
                                   style="text-decoration:none">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
<!-- 页面动态效果 -->
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}})
    layui.use(['laydate'], function(){
        laydate = layui.laydate;//日期插件
        //以上模块根据需要引入
        //
        var start = {
            min: laydate.now()
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };

        var end = {
            min: laydate.now()
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

    });


    /*浏览-删除*/
    function view_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            //ajax发送数据进行添加权限
            $.ajax({
                //请求的路径
                url: "administrator_del",//你的路由地址url :‘/register_phone’
                //数据传输
                data: 'id='+id,
                //请求方式
                type: 'post',
                //返回数据类型  json|html|xml
                dataType: 'json',
                //回调方法
                success: function (info) {
                }
            });
            //发异步删除数据
            $(obj).parents("tr").remove();
            layer.msg('已删除!',{icon:1,time:1000});
        });
    }
</script>
</body>
</html>