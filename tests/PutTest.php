<?php
include __DIR__.'/../vendor/autoload.php';

use Xd\AsyncHttp\AsyncHttp;

class PutTest extends \PHPUnit_Framework_TestCase {

    public function testOne()
    {
        echo PHP_EOL.'开始测试'.__CLASS__;

        $start = microtime(1);

        //请求一：form表单方式，耗时3秒
        $putData = json_encode(['sleepTime' => 3]);
        $req = AsyncHttp::put("http://192.168.88.2/server.php", $putData)->request();

        //请求二：json body 方式提交，耗时1秒
        $putData = json_encode(['sleepTime' => 1]);
        $req2 = AsyncHttp::put("http://192.168.88.2/server.php", $putData)->request();

        //模拟耗时任务3秒
        $times = 3;
        while ($times) {
            sleep(1);
            echo PHP_EOL."sleep 1s ...";
            $times--;
        }

        //取回响应数据
        $this->assertEquals("PUT:sleepTime=3", $req->getResponse()->body);
        $this->assertEquals("PUT:sleepTime=1", $req2->getResponse()->body);
        $this->assertNotEmpty($req->getResponse()->headers);
        $this->assertEquals("text/html", $req->getResponse()->getHeader('Content-Type'));
        $this->assertEquals(200, $req->getResponse()->getStatusCode());

        //大于等于6s表示是同步
        $costTime = microtime(1) - $start;
        $this->assertLessThan(7, $costTime);

        echo PHP_EOL."测试完成：同步需要耗时>7s，当前异步耗时:{$costTime}s".PHP_EOL.PHP_EOL;
    }
}








