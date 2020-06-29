<!DOCTYPE html>
<html>
<head>
<title>蓝奏直链解析</title>
<meta name="viewport" content="width=device-width" />
<link href="https://lib.baomitu.com/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<?php
if(!empty($_POST['url'])){
$UA='Mozilla/5.0 (Linux; Android 10; PCLM10 Build/QKQ1.191021.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 Mobile Safari/537.36';

function Curl($url,$guise,$UA,$cookie){
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_REFERER, $guise);
curl_setopt($curl, CURLOPT_COOKIE , $cookie);
curl_setopt($curl, CURLOPT_USERAGENT, $UA);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($curl);
curl_close($curl);
return $data;
}

//随机IP
function Rand_IP(){

    $ip2id = round(rand(600000, 2550000) / 10000);
    $ip3id = round(rand(600000, 2550000) / 10000);
    $ip4id = round(rand(600000, 2550000) / 10000);
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
}

//CURL $url=>需要访问链接;$guise=>伪装来源地址;$cookie=>需要提交的cookie;
function Curl_Download($url,$guise,$UA,$cookie){
$headers = array(
	'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
	'Accept-Encoding: gzip, deflate',
	'Accept-Language: zh-CN,zh;q=0.9',
	'Cache-Control: no-cache',
	'Connection: keep-alive',
	'Pragma: no-cache',
	'Upgrade-Insecure-Requests: 1',
	'User-Agent: '.$UserAgent
);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
if(!empty($guise)){
curl_setopt($curl, CURLOPT_REFERER, $guise);
}
if(!empty($guise)){
curl_setopt($curl, CURLOPT_COOKIE , $cookie);
}
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_NOBODY, true);
curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
curl_setopt($curl, CURLOPT_USERAGENT, $UA);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$data = curl_exec($curl);
$data=curl_getinfo($curl)['redirect_url'];
curl_close($curl);
return $data;
}

$url=$_POST['url'];
preg_match('~com/(\w+)~', $url, $url);
$html=Curl('https://www.lanzous.com/tp/'.$url[1],'',$UA,'');
$html = str_replace(array("\r","\n","\r\n"),'',$html);
$download= "/var urlpt = '(.*?.)'; var link = '(.*?.)';/";
preg_match($download,$html,$download);
$url=$download['1'].$download['2'];
if(empty($url)){
$download= "/var hadot = '(.*?.)';\/\/var nmousedow = '\/';var hado = '(.*?.)';/";
preg_match($download,$html,$download);
$url=$download['2'].$download['1'];
}
?>
<br>
<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"><?php 
echo Curl_Download($url,$url,$UA,'down_ip=1; expires=Mon, 20-Jul-2020 03:04:06 GMT; path=/; domain=.baidupan.com');?></textarea>
<?php }?>
<br>
<form class="form-inline" action="./index.php" method="POST" autocomplete="off">
  <div class="form-group">
    <input type="text" class="form-control" name="url" placeholder="蓝奏云盘分享链接（非短链接）">
  </div><br>
  <button type="submit" class="btn btn-primary mb-2">开始解析</button>
</form>
</div>
</body>
</html>