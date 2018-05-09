<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ConfigController extends Controller
{
    public function putFile(){
//        echo \Illuminate\Support\Facades\Config::get('web.web_title');
        $config = Config::pluck('conf_content', 'conf_name')->all();
        $config = var_export($config, true);
//        echo '<pre>';
        $path = base_path() . '\config\web.php' ;
        $str = "<?php ". PHP_EOL ." return $config ; ";
        file_put_contents($path,$str);
//        dd($str);
    }
    public function changContent(){
        $input = Input::all();
        foreach($input['conf_content'] as $k => $v){
            Config::find($k)->update(['conf_content' => $input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors', '配置项更新成功!');
    }
    public function changOrder()
    {
        $input = Input::all();
        $conf = Config::find($input['id']);
        $conf->conf_order = (int)$input['conf_order'];
        $res = $conf->update();
        if($res){
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新成功!',
            ];
        }else{
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新失败，请重试！',
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
        $data = Config::orderBy('conf_order','asc')->get();
        foreach($data as $k => $v){
            switch($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input class="lg" type="text" name="conf_content['.$v->id.']" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="conf_content['.$v->id.']">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',', $v->field_value);

                    $str = '';

                    foreach($arr as $m => $n){
                        //1|开启
                        $r = explode('|', $n);
                        $c = $v->conf_content==$r[0]?'checked':'';
                        $str .= '<input type="radio" '.$c.' name="conf_content['.$v->id.']" value="'.$r[0].'"> '. $r[1] .' 　 ';
                    }

                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.conf.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/conf/add');
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
            'conf_title' => 'required',
            'conf_name' => 'required',
        ];
        $message = [
            'conf_title.required' => '配置项标题不能为空',
            'conf_name.required' => '配置项名称不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);

        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                $this->putFile();
                return redirect('admin/config');
            }else{
                return back()->with('errors', '数据填充错误，请稍候再试!');
            }
        }else{
//            dd($validator);
            return back()->withErrors($validator);
        }



        return view('admin/conf/add');
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
        $field = Config::find($id);
        return view('admin.conf.edit',compact('field'));
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
            'conf_title' => 'required',
            'conf_name' => 'required',
        ];
        $message = [
            'conf_title.required' => '配置项标题不能为空',
            'conf_name.required' => '配置项名称不能为空',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->passes()){
            $re = Config::where('id',$id)->update($input);
            if($re){
                $this->putFile();
                return redirect('admin/config');
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
        $re = Config::where('id',$id)->delete();
        if($re){
            $this->putFile();
            $data = [
                'status' => 1,
                'msg' => '删除配置项成功！',
            ];
        }

        else
            $data = [
                'status' => 0,
                'msg' => '删除配置项失败！'
            ];
        return $data;
    }



}
