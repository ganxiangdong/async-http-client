<?php
use Xd\AsyncHttp\AsyncHttp;

include __DIR__.'/../vendor/autoload.php';

//请求一：form表单方式
$postData = json_encode(['sleepTime' => 3]);
$req = AsyncHttp::put("http://192.168.88.2/server.php", $postData)->request();

//请求二：json body 方式提交
$postData = json_encode(['sleepTime' => 1]);
$req2 = AsyncHttp::put("http://192.168.88.2/server.php", $postData)->request();


//模拟耗时任务3秒
$times = 3;
while ($times) {
    sleep(1);
    echo PHP_EOL."sleep 1s ...";
    $times--;
}

//取回响应数据
echo $req->getResponse()->body; //PUT:sleepTime=3

echo $req2->getResponse()->body;//PUT:sleepTime=1






