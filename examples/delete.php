<?php
use Xd\AsyncHttp\AsyncHttp;

include __DIR__.'/../vendor/autoload.php';

//请求一
$req = AsyncHttp::delete("http://192.168.88.2/index.php?sleepTime=3")->request();

//请求二
$req2 = AsyncHttp::delete("http://192.168.88.2/index.php?sleepTime=0")->request();

//做一些其它事：模拟耗时任务3秒
$times = 3;
while ($times) {
    sleep(1);
    echo PHP_EOL."sleep 1s ...";
    $times--;
}

//取回请求1的响应数据
//get response
$response = $req->getResponse();
//获取响应的body数据
$resBody = $response->body;
//获取请求的HTTP状态码
$httpStatus = $response->statusCode;
//获取响应求头
$headers = $response->headers;
//获取响应的某一项头
$header = $response->getHeader('Server');


//取回请求2的响应数据
$response = $req2->getResponse();








