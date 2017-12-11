<?php
include __DIR__.'/../vendor/autoload.php';

use Xd\AsyncHttp\AsyncHttp;

class GetTest extends \PHPUnit_Framework_TestCase {

    public function testOne()
    {
        echo PHP_EOL.'开始测试'.__CLASS__;

        $start = microtime(1);

        //请求一：耗时3秒
        $req = AsyncHttp::get("http://192.168.88.2/server.php?sleepTime=3");
//        $req->requestHeaders = ["Test:1","Test-X:2"];
        $req->addHeader("Test", 1);
        $req->request();

        //请求二，采用第二个参数传query，耗时1秒
        $req2 = AsyncHttp::get("http://192.168.88.2/server.php", ['sleepTime' => 1])->request();

        //模拟耗时任务3秒
        $times = 3;
        while ($times) {
            sleep(1);
            echo PHP_EOL."sleep 1s ...";
            $times--;
        }

        //取回响应数据
        $this->assertEquals("GET:sleepTime=3;header.Test=1", $req->getResponse()->body);
        $this->assertEquals("GET:sleepTime=1", $req2->getResponse()->body);
        $this->assertNotEmpty($req->getResponse()->headers);
        $this->assertEquals("text/html", $req->getResponse()->getHeader('Content-Type'));
        $this->assertEquals(200, $req->getResponse()->getStatusCode());

        //大于等于6s表示是同步
        $costTime = microtime(1) - $start;
        $this->assertLessThan(7, $costTime);

        echo PHP_EOL."测试完成：同步需要耗时>7s，当前异步耗时:{$costTime}s".PHP_EOL.PHP_EOL;
    }

    /**
     * 测试超时
     */
    public function testTimeout()
    {
        $start = microtime(1);
        $req = AsyncHttp::get("http://192.168.88.2/server.php?sleepTime=120")->setTimeout(1)->request();
        $response = $req->getResponse();

        $costTime = microtime(1) - $start;

        $this->assertEmpty($response->body);
        $this->assertEmpty($response->headers);
        $this->assertLessThan(2, $costTime);
    }

    /**
     * 测试超时后再接收
     */
    public function testTimeoutReceive()
    {
        $req = AsyncHttp::get("http://192.168.88.2/server.php?sleepTime=0")->setTimeout(2)->request();

        sleep(3);

        $response = $req->getResponse();

        $this->assertNotEmpty($response->body);
        $this->assertNotEmpty($response->headers);
    }
}








