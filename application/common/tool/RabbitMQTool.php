<?php
/**
 * Created by PhpStorm.
 * User: lihongjie
 * Date: 2019/8/25
 * Time: 18:26
 */

namespace app\common\tool;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use think\facade\Config;

class RabbitMQTool
{
    private $channel;
    private $mqConf;
    public function __construct($mqName)
    {
        $rabconfig = Config::get('rabbitmq.rabbit_mq');
        if (!isset($rabconfig['rabbit_mq_queue'])){
            die('没有定义rabbit_mq_queue');
        }

        //建立生产者与mq之间的连接
        $this->conn = new AMQPStreamConnection(
            $rabconfig['host'], $rabconfig['port'], $rabconfig['user'], $rabconfig['pwd'], $rabconfig['vhost']
        );
        $channal = $this->conn->channel();
        if (!isset($rabconfig['rabbit_mq_queue'][$mqName])) {
            die('没有定义'.$mqName);
        }
        // 获取具体mq信息
        $mqConf = $rabconfig['rabbit_mq_queue'][$mqName];
        $this->mqConf = $mqConf;
        // 声明初始化交换机
        $channal->exchange_declare($mqConf['exchange_name'], 'direct', false, true, false);
        // 声明初始化一条队列
        $channal->queue_declare($mqConf['queue_name'], false, true, false, false);
        // 交换机队列绑定
        $channal->queue_bind($mqConf['queue_name'], $mqConf['exchange_name']);
        $this->channel = $channal;
    }

    /**
     * User: yuzhao
     * @param $mqName
     * @return RabbitMQTool
     * Description: 返回当前实例
     */
    public static function instance($mqName) {
        return new RabbitMQTool($mqName);
    }

    /**
     * User: yuzhao
     * @param $data
     * Description: 写mq
     * @return bool
     */
    public function wMq($data) {
        try {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $msg = new AMQPMessage($data, ['content_type' => 'text/plain', 'delivery_mode' => 2]);
            $this->channel->basic_publish($msg, $this->mqConf['exchange_name']);
        } catch (\Throwable $e) {
            $this->closeConn();
            return false;
        }
        $this->closeConn();
        return true;
    }

    /**
     * User: yuzhao
     * @param int $num
     * @return array
     * Description:
     * @throws \ErrorException
     */
    public function rMq($num=1) {
        $rData = [];
        $callBack = function ($msg) use (&$rData){
            $rData[] = json_decode($msg->body, true);
        };
        for ($i=0;$i<$num;$i++) {
            $this->channel->basic_consume($this->mqConf['queue_name'], '', false, true, false, false, $callBack);
        }
        $this->channel->wait();
        $this->closeConn();
        return $rData;
    }

    /**
     * User: yuzhao
     * Description: 关闭连接
     */
    public function closeConn() {
        $this->channel->close();
        $this->conn->close();
    }
}