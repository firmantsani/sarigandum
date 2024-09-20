<?php
function generateRandomFingerprint() {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $fingerprint = '';
    for ($i = 0; $i < 32; $i++) {
        $fingerprint .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $fingerprint;
}
function save($data, $file) 
	{
		$handle = fopen($file, 'a+');
		fwrite($handle, $data);
		fclose($handle);
	}

while(true){
$get_url = "https://romasarigandum.com/";

$ch = curl_init($get_url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Host: romasarigandum.com",
    "Connection: keep-alive",
    "Pragma: no-cache",
    "Cache-Control: no-cache",
    'sec-ch-ua: "Android WebView";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
    "sec-ch-ua-mobile: ?1",
    'sec-ch-ua-platform: "Android"',
    "Upgrade-Insecure-Requests: 1",
    "User-Agent: Mozilla/5.0 (Linux; Android 14; M2101K6G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.6668.38 Mobile Safari/537.36",
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
    "x-requested-with: com.duckduckgo.mobile.android",
    "Sec-Fetch-Site: none",
    "Sec-Fetch-Mode: navigate",
    "Sec-Fetch-User: ?1",
    "Sec-Fetch-Dest: document",
    "Accept-Language: en,id-ID;q=0.9,id;q=0.8,en-US;q=0.7"
));

$response = curl_exec($ch);
//var_dump($response);
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
$cookies = implode("; ", $matches[1]);

preg_match('/XSRF-TOKEN=([^;]*)/', $cookies, $xsrf_matches);
$xsrf_token = isset($xsrf_matches[1]) ? $xsrf_matches[1] : '';

//var_dump($xsrf_token);
//var_dump($cookies);
curl_close($ch);

$post_url = "https://romasarigandum.com/getVoucher";

$data = array(
    "fingerprint" => generateRandomFingerprint()
);
$payload = json_encode($data);

$ch = curl_init($post_url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Host: romasarigandum.com",
    "Connection: keep-alive",
    "Content-Length: " . strlen($payload),
    "Pragma: no-cache",
    "Cache-Control: no-cache",
    'sec-ch-ua-platform: "Android"',
    "X-XSRF-TOKEN: ".urldecode($xsrf_token),
    "User-Agent: Mozilla/5.0 (Linux; Android 14; M2101K6G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.6668.38 Mobile Safari/537.36",
    "Accept: application/json, text/plain, */*",
    'sec-ch-ua: "Android WebView";v="129", "Not=A?Brand";v="8", "Chromium";v="129"',
    "Content-Type: application/json",
    "sec-ch-ua-mobile: ?1",
    "Origin: https://romasarigandum.com",
    "X-Requested-With: idm.internet.download.manager.plus",
    "Sec-Fetch-Site: same-origin",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Dest: empty",
    "Referer: https://romasarigandum.com/",
    "Accept-Language: en,id-ID;q=0.9,id;q=0.8,en-US;q=0.7",
    "Cookie: " . $cookies
));

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
die;
}

curl_close($ch);
var_dump( $response);
save($response."\n","voucher_sarigandum.txt");
}
?>
