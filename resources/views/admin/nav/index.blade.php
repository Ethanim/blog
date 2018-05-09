@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 自定义导航管理
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>自定义导航列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>导航地址</th>
                        <th>操作</th>
                    </tr>

                    @foreach($data as $k => $v)
                    <tr>
                        <td class="tc" width="60px">
                            <input type="text" onchange="changeOrder(this,'{{$v->id}}')" name="ord[]" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->id}}</td>
                        <td>{{$v->nav_name}}</td>
                        <td>{{$v->nav_alias}}</td>
                        <td>{{$v->nav_url}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delNav({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>







            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script>
//删除导航
function delNav(id){
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.post("{{url('admin/navs')}}/"+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
            if(data.status){
                history.go(0);
                layer.msg(data.msg, {icon: 6});
            }
            else
                layer.msg(data.msg, {icon: 5});
        });
    }, function(){

    });
}

//更改导航排序
function changeOrder(obj,id){
    var cate_order = $(obj).val();
    $.post("{{url('admin/nav/changOrder')}}", {'_token':'{{csrf_token()}}','id':id,'nav_order':cate_order}, function(data){
        if(data.status)
            layer.msg(data.msg, {icon: 6});
        else
            layer.msg(data.msg, {icon: 5});

    });
}
</script>

@endsection



