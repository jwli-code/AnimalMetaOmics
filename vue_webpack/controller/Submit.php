<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;
use think\Request;

class Submit extends Controller
{
    public function submitAdd(Request $request)
    {
        // 获取请求参数
        $host = $request->post('host');
        $accession = $request->post('accession');
        $microbiome = $request->post('microbiome');
        $pmid = $request->post('pmid');
        $email = $request->post('email');
        $detail = $request->post('detail');

        // 将数据插入到数据库
        $result = Db::table('Submit_table')->insert([
            'host' => $host,
            'accession' => $accession,
            'microbiome' => $microbiome,
            'pmid' => $pmid,
            'email' => $email,
            'detail' => $detail,
        ]);
    }
}