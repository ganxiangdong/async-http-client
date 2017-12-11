AsyncHttp is a very simple and agile HTTP asynchrony request library.

### Install

----

composer require xd/async-http

### Examples

---

1. GET：

   ```php
   //requsting 
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3")->request();

   //do somthing...

   //get response
   $response = $req->getResponse();
   //get body
   $resBody = $response->body;
   //get http status code
   $httpStatusCode = $response->statusCode;
   //get response all header
   $headers = $response->headers;
   //get one header
   $header = $response->getHeader('Server');
   ```

2. POST

   ```php
   //requesting by x-www-form-urlencode
   $postData = ['sleepTime' => 3];
   $req = AsyncHttp::post("http://192.168.88.2", $postData)->request();
   //requesting by raw JSON
   $postData = json_encode(['sleepTime' => 1]);
   $req2 = AsyncHttp::post("http://192.168.88.2", $postData)->request();
   //requesting by raw XML
   $req2 = AsyncHttp::post("http://192.168.88.2", $xmlDataStr)->addHeader("Content-Type":"application/xml")->request();

   //do somthing...

   //get response
   $body1 = $req->getResponse()->body;
   $body2 = $req2->getResponse()->body; 
   $body3 = $req3->getResponse()->body; 
   ```

3. PUT

   ```php
   //requesting by x-www-form-urlencode
   $putData = json_encode(['sleepTime' => 3]);
   $req = AsyncHttp::put("http://192.168.88.2/index.php", $putData)->request();
   //requesting by raw JSON
   $putData = json_encode(['sleepTime' => 1]);
   $req2 = AsyncHttp::put("http://192.168.88.2/index.php", $postData)->request();

   //do somthing...

   //get response
   $body1 = $req->getResponse()->body;
   $body2 = $req2->getResponse()->body;
   ```

4. DELETE

   ```php
   //requesting
   $req = AsyncHttp::delete("http://192.168.88.2/index.php?sleepTime=3")->request();
   //requesting
   $req2 = AsyncHttp::delete("http://192.168.88.2/index.php?sleepTime=0")->request();

   //do somthing...

   //get response
   $body1 = $req->getResponse()->body;
   $body2 = $req2->getResponse()->body;
   ```

### Other usage

----

1. Custom header

   ```php
   //example 1
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3");
   $req->addHeader("Test", 1);
   $req->request();

   //example 2
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3")->addHeader("Test", 1)->addHeader("Test-X", "2")->request();

   //example 3
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3");
   $req->requestHeaders = ["Test" => "1","Test-X" => "2"];
   $req->request();
   ```


2. Set timeout（default 8 second）

   ```php
   //example 1
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3");
   $req->setTimeout(8);
   $req->request();

   //example 2
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3")->setTimeout(8)->request();

   //example 3
   $req = AsyncHttp::get("http://192.168.88.2?sleepTime=3");
   $req->setTimeout = 8;
   $req->request();
   ```

3. How to judge timeout or network unreachable

   ```
   if ($response->getStatusCode() == 0){
     
   } 
   ```

   ​

