<?php

namespace app\test\controller;

use app\common\tool\RabbitMQTool;
use think\Controller;

class Test extends Controller
{
   public function test(){
       //RabbitMQTool::instance('test')->wMq(['name'=>'郭亚超']);

       $conn = new \Redis();
       $conn->pconnect('127.0.0.1',6379);
       while(true){
           try{
               $value = $conn->rPop('click');
               if (!$value){
                   break;
               }
               print_r($value);
           }catch(\Exception $e){
               echo $e->getMessage();
           }
       }

   }
}
