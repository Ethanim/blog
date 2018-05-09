<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::Join('article','category.id','=','article.cate_id')
            ->orderBy('article.id','desc')
            ->paginate(7);
//        dd($data);
        return view('admin/article/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = (new Category)->tree();
        return view('admin/article/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'cate_id' => 'required',
            'art_title' => 'required'
        ];
        $message = [
            'cate_id.required' => '分类名称不能为空',
            'art_title.required' => '文章标题不能为空',
        ];

        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors', '数据填充错误，请稍候再试!');
            }
        }else{
            return back()->withErrors($validator);
        }



        return view('admin/category/add');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = (new Category)->tree();
//        dd($data);
        $field = Article::find($id);

        return view('admin/article/edit',compact('data','field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = Input::except('_method','_token');
//        dd($input);
        $rules = [
            'cate_id' => 'required',
            'art_title' => 'required'
        ];
        $message = [
            'cate_id.required' => '分类名称不能为空',
            'art_title.required' => '文章标题不能为空',
        ];

        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            //取出原图片路径
//            $thumb_path = Article::where('id',$id)->pluck('art_thumb');

            $re = Article::where('id',$id)->update($input);

            if($re){

                //原图片路径不为空，删除图片
//                if(!empty($thumb_path[0])){
//                    $path = base_path() . '\\' . $thumb_path[0];
//                    unlink($path);
//                }

                return redirect('admin/article');
            }else{
                return back()->with('errors', '数据修改错误，请稍候再试!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //要删除的图片原路径
        $thumb_path = Article::where('id',$id)->pluck('art_thumb');


        $re = Article::where('id',$id)->delete();



        if($re){
            //原图片路径不为空，删除图片
            if(!empty($thumb_path[0])){
                $path = base_path() . '\\' . $thumb_path[0];
                unlink($path);
            }

            $data = [
                'status' => 1,
                'msg' => '删除分类成功！',
            ];
        }

        else{
            $data = [
                'status' => 0,
                'msg' => '删除分类失败！'
            ];
        }

        return $data;
    }
}
