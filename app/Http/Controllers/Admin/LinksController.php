<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LinksController extends Controller
{
    public function changOrder()
    {
        $input = Input::all();
        $link = Links::find($input['id']);
        $link->link_order = (int)$input['link_order'];
        $res = $link->update();
        if($res){
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新失败，请重试！',
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
        $data = Links::orderBy('link_order','asc')->get();
        return view('admin.link.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/link/add');
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
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        $message = [
            'link_name.required' => '友情链接名称不能为空',
            'link_url.required' => '友情链接地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors', '数据填充错误，请稍候再试!');
            }
        }else{
//            dd($validator);
            return back()->withErrors($validator);
        }



        return view('admin/link/add');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Links::find($id);
        return view('admin.link.edit',compact('field'));
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
            'link_name' => 'required',
            'link_url' => 'required',
        ];
        $message = [
            'link_name.required' => '友情链接名称不能为空',
            'link_url.required' => '友情链接地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
            $re = Links::where('id',$id)->update($input);
            if($re){
                return redirect('admin/links');
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
        $re = Links::where('id',$id)->delete();
        if($re)
            $data = [
                'status' => 1,
                'msg' => '删除友情链接成功！',
            ];
        else
            $data = [
                'status' => 0,
                'msg' => '删除友情链接失败！'
            ];
        return $data;
    }



}
