<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $this->getTree($categorys,'cate_name','id','cate_pid');
    }

    public function getTree($data, $field_name, $field_id='id', $field_pid='pid', $pid=0){
        $arr = array();
        foreach($data as $k => $v){
            if($v->$field_pid == $pid){
                $data[$k]['_'.$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach($data as $k1 => $v1){
                    if($v1->$field_pid == $v->$field_id){
                        $data[$k1]['_'.$field_name] = '—'.$data[$k1][$field_name];
                        $arr[] = $data[$k1];
                    }
                }
            }
        }
        return $arr;
    }
}
