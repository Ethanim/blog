<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Admin\NavsController;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;


class IndexController extends CommonController
{
    public function index(){
        //点击最高的6篇文章
        $pic = Article::orderBy('art_view','desc')->take(6)->get();



        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home/index', compact('pic','data','links'));
    }

    public function category($id){
        //分类查看次数
        Category::find($id)->increment('cate_view');

        //当前分类字段
        $field = Category::find($id);

        //图文列表4篇（带分页）
        $data = Article::where('cate_id',$id)->orderBy('art_time','desc')->paginate(4);

        //当前分类的子分类

        $submenu = Category::where('cate_pid', $id)->take(4)->get();


        return view('home/list', compact('field','data', 'submenu'));
    }

    public function article($id){
        //文章查看次数
        Article::find($id)->increment('art_view');

        $field = Article::Join('category','article.cate_id','=','category.id')->where('article.id',$id)->first();

        //上一篇
        $article['pre'] = Article::where('id','<',$id)->orderBy('id','desc')->first();
        //下一篇
        $article['next'] = Article::where('id','>',$id)->orderBy('id','asc')->first();
//        dd($article);

        //相关文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('id','desc')->take(6)->get();


        return view('home/new', compact('field', 'article','data'));
    }
}
