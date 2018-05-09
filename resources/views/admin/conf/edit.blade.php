    @extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项添加
    </div>
    <!--面包屑配置项 结束-->

    <!--结果集标题与配置项组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
                    <h3>添加配置项</h3>
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/config/'.$field->id)}}" method="post">
            {{method_field('put')}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>标题：</th>
                    <td>
                        <input type="text" id="conf_title" name="conf_title" value="{{$field->conf_title}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题不能为空</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" id="conf_name" name="conf_name" value="{{$field->conf_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称不能为空</span>
                    </td>
                </tr>
                <tr>
                    <th>类型：</th>
                    <td>
                        <input type="radio" name="field_type" onclick="showTr()" @if($field->field_type=='input') checked @endif value="input">input　
                        <input type="radio" name="field_type" onclick="showTr()" @if($field->field_type=='textarea') checked @endif value="textarea">textarea　
                        <input type="radio" name="field_type" onclick="showTr()" @if($field->field_type=='radio') checked @endif value="radio">radio
                    </td>
                </tr>
                <tr class="field_value">
                    <th>类型值：</th>
                    <td>
                        <input type="text" class="lg" id="field_value" name="field_value" value="{{$field->field_value}}"><br />
                        <span><i class="fa fa-exclamation-circle yellow"></i>类型值只有在radio的情况下才需要配置，格式 1|开启,0|关闭</span>
                    </td>
                </tr>

                <tr>
                    <th>排序：</th>
                    <td>
                        <input style="width:5%" type="text" name="conf_order" value="{{$field->conf_order}}">
                    </td>
                </tr>
                <tr>
                    <th>说明：</th>
                    <td>
                        <textarea name="conf_tips" >{{$field->conf_tips}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
<script>
    showTr();
    function showTr(){
      var type = $("input[name=field_type]:checked").val();
      if(type == 'radio')
          $('.field_value').show();
      else
          $('.field_value').hide();
    }
</script>
@endsection

