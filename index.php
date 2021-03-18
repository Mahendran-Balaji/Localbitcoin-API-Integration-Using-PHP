<?php
function localbitcoins_query($path, array $req = Array()) {
   $key='YOUR_KEY';
   $secret='YOUR_SECRET_KEY';
   $mt = explode(' ', microtime());
   $nonce = $mt[1].substr($mt[0], 2, 6);
   if ($req) {
      $get=httpbuildquery($req);
      $path=$path.'?'.$get;
   }
   $postdata=$nonce.$key.$path;
   $sign = strtoupper(hash_hmac('sha256', $postdata, $secret));
   $headers = array(
      'Apiauth-Signature:'.$sign,
      'Apiauth-Key:'.$key,
      'Apiauth-Nonce:'.$nonce
   );
   $ch = null;
   $ch = curl_init('https://localbitcoins.com'.$path);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
   $res = curl_exec($ch);
   if ($res === false) throw new Exception('Curl error: '.curlerror($ch));
   $dec = json_decode($res, true);
   if (!$dec) throw new Exception('Invalid data: '.$res);
   curl_close($ch);
   return $dec;
}

$getinfo = array();
$devise = "INR";


//$url = "/buy-bitcoins-online/".$devise."/imps-bank-transfer-india/.json";

//$url = "/api/myself/"; // Get data

//$url  = "/api/wallet/";

//$url = "/api/notifications/";

//$url = "/api/recent_messages/";

//$url = "/api/ads/";

//$url ="/api/dashboard/released/";

$getinfo = localbitcoins_query($url);   

echo "<pre>"; print_r($getinfo); echo "</pre>";


