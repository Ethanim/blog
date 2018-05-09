<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '齐齐哈尔大学',
                'link_title' => '中国最北大学',
                'link_url' => 'www.qqhru.edu.cn',
                'link_order' => '1',
            ],
            [
                'link_name' => '百度',
                'link_title' => '世界最大的中文搜索引擎',
                'link_url' => 'www.baidu.com',
                'link_order' => '2',
            ],
        ];
        DB::table('links')->insert($data);
    }
}
