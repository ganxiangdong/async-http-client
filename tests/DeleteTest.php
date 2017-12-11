<?php
include __DIR__.'/../vendor/autoload.php';

class DeleteTest extends \PHPUnit_Framework_TestCase {

    public function testOne()
    {
        echo PHP_EOL.'开始测试'.__CLASS__;
        $start = microtime(1);

        //请求一：耗时3秒，form表单方式
        $req = (new \AsyncHttp\Delete("http://192.168.88.2/index.php?sleepTime=3"))->request();

        //请求二：json body 方式提交
        $req2 = (new \AsyncHttp\Delete("http://192.168.88.2/index.php?sleepTime=0"))->request();

        //模拟耗时任务3秒
        $times = 3;
        while ($times) {
            sleep(1);
            echo PHP_EOL."sleep 1s ...";
            $times--;
        }

        //取回响应数据
        $this->assertEquals("DELETE:sleepTime=3", $req->getResponse()->body);
        $this->assertEquals("DELETE:sleepTime=0", $req2->getResponse()->body);

        //大于等于6s表示是同步
        $costTime = microtime(1) - $start;
        $this->assertLessThan(6, $costTime);

        echo PHP_EOL."测试完成：同步需要耗时>6s，当前异步耗时:{$costTime}s".PHP_EOL.PHP_EOL;
    }
}








