<?php
include __DIR__.'/../vendor/autoload.php';

class GetTest extends \PHPUnit_Framework_TestCase {

    public function testOne()
    {
        echo PHP_EOL.'开始测试'.__CLASS__;

        $start = microtime(1);

        //请求一：耗时3秒
        $req = (new \AsyncHttp\Get("http://192.168.88.2?sleepTime=3"))->request();

        //请求二，采用第二个参数传query，耗时1秒
        $req2 = (new \AsyncHttp\Get("http://192.168.88.2", ['sleepTime' => 1]))->request();

        //模拟耗时任务3秒
        $times = 3;
        while ($times) {
            sleep(1);
            echo PHP_EOL."sleep 1s ...";
            $times--;
        }

        //取回响应数据
        $this->assertEquals("GET:sleepTime=3", $req->getResponse()->body);
        $this->assertEquals("GET:sleepTime=1", $req2->getResponse()->body);

        //大于等于6s表示是同步
        $costTime = microtime(1) - $start;
        $this->assertLessThan(7, $costTime);

        echo PHP_EOL."测试完成：同步需要耗时>7s，当前异步耗时:{$costTime}s".PHP_EOL.PHP_EOL;
    }
}








