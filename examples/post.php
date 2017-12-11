<?php
include __DIR__.'/../vendor/autoload.php';

class PostTest extends \PHPUnit_Framework_TestCase {

    public function testOne()
    {
        echo PHP_EOL.'开始测试'.__CLASS__;

        $start = microtime(1);

        //请求一：form表单方式，耗时3秒
        $postData = ['sleepTime' => 3];
        $req = (new \AsyncHttp\Post("http://192.168.88.2/server.php", $postData))->request();

        //请求二：json body 方式提交，耗时1秒
        $postData = json_encode(['sleepTime' => 1]);
        $req2 = (new \AsyncHttp\Post("http://192.168.88.2/server.php", $postData))->request();

        //模拟耗时任务3秒
        $times = 3;
        while ($times) {
            sleep(1);
            echo PHP_EOL."sleep 1s ...";
            $times--;
        }

        //取回响应数据
        $this->assertEquals("POST:sleepTime=3", $req->getResponse()->body);
        $this->assertEquals("POST:sleepTime=1", $req2->getResponse()->body);

        //大于等于6s表示是同步
        $costTime = microtime(1) - $start;
        $this->assertLessThan(7, $costTime);

        echo PHP_EOL."测试完成：同步需要耗时>7s，当前异步耗时:{$costTime}s".PHP_EOL.PHP_EOL;
    }
}








