@extends('layouts/admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑配置项 结束-->


    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>配置项列表</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>
                                    {{$error}}
                                </p>
                            @endforeach
                        @else
                            <p>
                                {{$errors}}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/conf/changContent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>

                    @foreach($data as $k => $v)
                    <tr>
                        <td class="tc" width="60px">
                            <input type="text" onchange="changeOrder(this,'{{$v->id}}')"  value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->id}}</td>
                        <td>{{$v->conf_title}}</td>
                        <td>{{$v->conf_name}}</td>
                        <td>{!! $v->_html !!}</td>
                        <td>
                            <a href="{{url('admin/config/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delConf({{$v->id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td align="center" colspan="6">
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </table>
                </form>







            </div>
        </div>

    <!--搜索结果页面 列表 结束-->

<script>
//删除配置项
function delConf(id){
    layer.confirm('确定要删除吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        $.post("{{url('admin/config')}}/"+id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
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

//更改配置项排序
function changeOrder(obj,id){
    var cate_order = $(obj).val();
    $.post("{{url('admin/conf/changOrder')}}", {'_token':'{{csrf_token()}}','id':id,'conf_order':cate_order}, function(data){
        if(data.status)
            layer.msg(data.msg, {icon: 6});
        else
            layer.msg(data.msg, {icon: 5});

    });
}
</script>

@endsection



