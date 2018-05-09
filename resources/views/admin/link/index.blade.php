@extends('layouts/admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接管理
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情链接列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部链接</a>
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
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>

                    @foreach($data as $k => $v)
                    <tr>
                        <td class="tc" width="60px">
                            <input type="text" onchange="changeOrder(this,'{{$v->id}}')" name="ord[]" value="{{$v->link_order}}">
                        </td>
                        <td class="tc">{{$v->id}}</td>
                        <td>{{$v->link_name}}</td>
                        <td>{{$v->link_title}}</td>
                        <td>{{$v->link_url}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delLink({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>







            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script>
//删除链接
function delLink(id){
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.post("{{url('admin/links')}}/"+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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

//更改链接排序
function changeOrder(obj,id){
    var cate_order = $(obj).val();
    $.post("{{url('admin/link/changOrder')}}", {'_token':'{{csrf_token()}}','id':id,'link_order':cate_order}, function(data){
        if(data.status)
            layer.msg(data.msg, {icon: 6});
        else
            layer.msg(data.msg, {icon: 5});

    });
}
</script>

@endsection



