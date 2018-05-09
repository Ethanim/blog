@extends('layouts.home')

@section('info')
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <title>{{$field->cate_name}} - {{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$field->cate_keywords}}" />
    <meta name="description" content="{{$field->cate_description}}" />
    
@endsection

@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{$field->cate_description}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('category/'.$field->id)}}" class="n2">{{$field->cate_name}}</a></h1>
        <div class="newblog left">
            @foreach($data as $v)
            <h2><a href="{{url('a/'.$v->id)}}">{{$v->art_title}}</a></h2>
            <p class="dateview"><span>发布时间：{{date('Y-m-d', $v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('category/'.$field->id)}}">{{$field->cate_name}}</a>]</span></p>
            <figure><a href="{{url('a/'.$v->id)}}"><img src="{{url($v->art_thumb)}}"></a></figure>
            <ul class="nlist">
                <p>{{$v->art_description}}</p>
                <a title="{{$v->art_title}}" href="{{url('a/'.$v->id)}}"  class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
            @endforeach



            
            <div class="page">

            {{$data->links()}}

            </div>
        </div>
        <aside class="right">
            @if($submenu->all())
            <div class="rnav" >
                <ul>
                    @foreach($submenu as $k => $v)
                    <li class="rnav{{$k+1}}"><a href="{{url('category/'.$v->id)}}" target="_blank">{{$v->cate_name}}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Baidu Button BEGIN -->
                <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
                <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
                <script type="text/javascript" id="bdshell_js"></script>
                <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
                </script>
                <!-- Baidu Button END -->
            <div class="news" style="float: right;">
                @parent
            </div>


        </aside>
    </article>
@endsection

