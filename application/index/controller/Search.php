<?php

namespace app\index\controller;

use Elasticsearch\ClientBuilder;
use think\App;
use think\Controller;
use think\Db;
use think\Request;

class Search extends Controller
{

    private $client;
    public function __construct()
    {
        $param = ['127.0.0.1:9200'];
        $this->client = ClientBuilder::create()->setHosts($param)->build();
    }

    /**
     * 创建索引
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Db::name('test')->limit(100)->select();
        foreach ($data as $row){
            $param = [
                'body'=>[
                    'id'=>$row['id'],
                    'title'=>$row['title']
                ],
                'id'=>'test'.$row['id'],
                'index'=>'test',
                'type'=>'test'
            ];
            $this->client->index($param);
        }
    }

    /**
     * 获取索引
     */
    public function getIndex(){
       $param = [
           'index'=>'test',
           'type'=>'test',
           'id'=>'test1'
       ];
       $res = $this->client->get($param);
       print_r($res);
    }
}
