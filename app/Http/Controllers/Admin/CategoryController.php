<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    public function changOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['id']);
        $cate->cate_order = (int)$input['cate_order'];
        $res = $cate->update();
        if($res){
            $data = [
                'status' => 1,
                'msg' => '分类排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 0,
                'msg' => '分类排序更新失败，请重试！',
            ];
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (new Category)->tree();
        return view('admin.category.index')->with('data', $data);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/add', compact('data'));
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

        $rules = [
            'cate_name' => 'required',
            'cate_title' => 'required',
            'cate_order' => 'numeric|max:255',
        ];
        $message = [
            'cate_name.required' => '分类名称不能为空',
            'cate_title.required' => '分类标题不能为空',
            'cate_order.numeric' => '排序必须是数字',
            'cate_order.max' => '排序必须在1到255位之间',
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors', '数据填充错误，请稍候再试!');
            }
        }else{
//            dd($validator);
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
        echo '显示';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Category::find($id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin/category/edit', compact('field','data'));
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


        $rules = [
            'cate_name' => 'required',
            'cate_title' => 'required',
        ];
        $message = [
            'cate_name.required' => '分类名称不能为空',
            'cate_title.required' => '分类标题不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Category::where('id',$id)->update($input);
            if($re){
                return redirect('admin/category');
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
        $re = Category::where('id',$id)->delete();
        Category::where('cate_pid',$id)->update(['cate_pid' => 0]);
        if($re)
            $data = [
                'status' => 1,
                'msg' => '删除分类成功！',
            ];
        else
            $data = [
                'status' => 0,
                'msg' => '删除分类失败！'
            ];
        return $data;
    }
}
