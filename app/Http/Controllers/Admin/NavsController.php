<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class NavsController extends Controller
{
    public function changOrder()
    {
        $input = Input::all();
        $nav = Navs::find($input['id']);
        $nav->nav_order = (int)$input['nav_order'];
        $res = $nav->update();
        if($res){
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新失败，请重试！',
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
        $data = Navs::orderBy('nav_order','asc')->get();
        return view('admin.nav.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/nav/add');
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
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        $message = [
            'nav_name.required' => '自定义导航名称不能为空',
            'nav_url.required' => '自定义导航地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors', '数据填充错误，请稍候再试!');
            }
        }else{
//            dd($validator);
            return back()->withErrors($validator);
        }



        return view('admin/nav/add');
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
        $field = Navs::find($id);
        return view('admin.nav.edit',compact('field'));
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
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];
        $message = [
            'nav_name.required' => '自定义导航名称不能为空',
            'nav_url.required' => '自定义导航地址不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
            $re = Navs::where('id',$id)->update($input);
            if($re){
                return redirect('admin/navs');
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
        $re = Navs::where('id',$id)->delete();
        if($re)
            $data = [
                'status' => 1,
                'msg' => '删除自定义导航成功！',
            ];
        else
            $data = [
                'status' => 0,
                'msg' => '删除自定义导航失败！'
            ];
        return $data;
    }



}
