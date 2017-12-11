<?php
//单元测试服务端
$rawBody = file_get_contents('php://input');
if (in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'POST']) && !empty($rawBody)) {
    $parsBody = json_decode($rawBody, 1);
    if (!empty($parsBody)) {
        $_REQUEST = $parsBody;
    }
}
$sleepTime = intval($_REQUEST['sleepTime']);
if ($sleepTime > 0) {
    $i = $sleepTime;
    while ($i) {
        $i--;
        file_put_contents('/www/pc/public/t', $i.PHP_EOL, FILE_APPEND);
        sleep(1);
    }
}
$testHeader = empty($_SERVER['HTTP_TEST']) ? '' : ';header.Test='.$_SERVER['HTTP_TEST'];
exit($_SERVER['REQUEST_METHOD'].':sleepTime='.$sleepTime.$testHeader);