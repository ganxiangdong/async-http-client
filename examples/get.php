<?php
use Xd\AsyncHttp\AsyncHttp;

include __DIR__.'/../vendor/autoload.php';

$req = AsyncHttp::get("http://192.168.88.2/server.php?sleepTime=3");
//        $req->requestHeaders = ["Test:1","Test-X:2"];
$req->addHeader("Test", 1);
$req->request();

//请求二，采用第二个参数传query，并设置5s的超时
$req2 = AsyncHttp::get("http://192.168.88.2/server.php", ['sleepTime' => 1])->setTimeout(5)->request();

//模拟耗时任务3秒
$times = 3;
while ($times) {
    sleep(1);
    echo PHP_EOL."sleep 1s ...";
    $times--;
}

//取回请求1的响应数据
$req->getResponse()->body;

//可以处理其它事

//取回请求2的响应数据
$req2->getResponse()->body;

//取出请求2的某一项header
$req2->getResponse()->getHeader("Content-Type");

//取出请求2的所有请求header
$req2->getResponse()->getHeaders();

//取出请求2的请求状态码
$req2->getResponse()->getStatusCode();









