<?php

namespace app\index\model;


use Elasticsearch\ClientBuilder;

class Elasticsearch
{
    private $api;
    private $config = [
        'hosts'=>['http//127.0.0.1:9200']
    ];
    public function __construct()
    {
       $this->api = ClientBuilder::create()->setHosts($this->config['hosts'])->build();
    }

    /*************************************************************
    /**
     * 索引一个文档
     * 说明：索引没有被创建时会自动创建索引
     */
    public function addOne()
    {
        $params = [];
        $params['index'] = 'xiaochuan';
        $params['type']  = 'cat';
        $params['id']  = '20180407001';  # 不指定就是es自动分配
        $params['body']  = array('uname' => '高');
        return $this->api->index($params);
    }

    /**
     * 索引多个文档
     * 说明：索引没有被创建时会自动创建索引
     */
    public function addAll()
    {
        $params = [];
        for($i = 1; $i < 21; $i++) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'test_index'.$i,
                    '_type'  => 'cat_test',
                    '_id'    => $i,
                ]
            ];
            $params['body'][] = [
                'name' => '小川编程'.$i,
                'content' => '内容'.$i
            ];
        }
        return $this->api->bulk($params);
    }

    /**
     * 获取一个文档
     */
    public function getOne()
    {
        $params = [];
        $params['index'] = 'xiaochuan';
        $params['type']  = 'cat';
        $params['id']    = '20180407001';
        return $this->api->get($params);
    }

    /**
     * 搜索文档
     */
    public function search()
    {
        $params = [];
        $params['index'] = 'xiaochuan';
        $params['type']  = 'cat';
        $params['body']['query']['match']['uname'] = '高';
        return $this->api->search($params);
    }

    /**
     * 删除文档
     * 说明：文档删除后，不会删除对应索引。
     */
    public function delete()
    {
        $params = [];
        $params['index'] = 'xiaochuan';
        $params['type'] = 'cat';
        $params['id'] = '20180407001';
        return $this->api->delete($params);
    }

    /*************************************************************
    /**
     * 创建索引
     */
    public function createIndex()
    {
        $params = [];
        $params['index']  = 'xiaochuan';
        return $this->api->indices()->create($params);
    }

    /**
     * 删除索引：匹配单个 | 匹配多个
     * 说明： 索引删除后，索引下的所有文档也会被删除
     */
    public function deleteIndex()
    {
        $params = [];
        $params['index'] = 'test_index';  # 删除test_index单个索引
        #$params['index'] = 'test_index*'; # 删除以test_index开始的所有索引
        return $this->api->indices()->delete($params);
    }
}
