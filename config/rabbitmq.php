<?php
/**
 * Created by PhpStorm.
 * User: lihongjie
 * Date: 2019/8/25
 * Time: 18:29
 */

return [

    'rabbit_mq' => [
        'host' => '192.168.139.3',
        'port' => 5672,
        'user' => 'guest',
        'pwd' => 'guest',
        'vhost' => '/',
        'rabbit_mq_queue' => [
            'test' => [
                'exchange_name' => 'ex_test', // 交换机名称
                'queue_name' => 'que_test', // 队列名称
                'process_num' => 3, // 默认单台机器的进程数量
                'deal_num' => '50', // 单次处理数量
                'consumer' => 'Test' // 消费地址
            ]
        ]
    ]
];