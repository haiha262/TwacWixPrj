<?php
session_start();

//header("Content-Type: text/json; charset=utf8");



//https://twac.com.au/?
//settdate=20180427
//&expirydate=0120
//&callback_status_code=
//&restext=Approved
//&fingerprint=4807085e4bd9b58ca88bf0335e2388256288c1de
//&merchant=ABC0001
//&refid=Honeymoon+Registry-20180426231238
//&pan=441359...308
//&summarycode=1
//&rescode=00
//&txnid=314245
//&timestamp=20180426231238

// get the q parameter from URL
$amount = $_REQUEST["amount"];
$reference = $_REQUEST["reference"];

$honeymoonerNames = $_REQUEST["honeymoonerNames"];
$payerName = $_REQUEST["payerName"];
$currentURL = $_REQUEST["currentURL"];

$_SESSION["EPS_honeymoonerNames"] = $honeymoonerNames;
$_SESSION["EPS_payerName"] = $payerName;
$_SESSION["amount"] = $amount;

date_default_timezone_set('UTC');
$timestamp =  date("YmdHis");
//echo "<br/>GMTtimestamp = " . $timestamp;

//$timezone  = 10; //(GMT -5:00) EST (U.S. & Canada)
//$timestamp = gmdate("YmjHis", time() + 3600*($timezone+date("I")));
//echo " timestamp = " . $timestamp;

$resultUrl = $currentURL;

$release = true;
if($release) {
    $merchantId = "29R0031";
    $EPS_TXNTYPE = "0";
    $password = "Gkefupg0";
    $formAction = 'https://api.securepay.com.au/directpost/authorise';

}else {
    $merchantId = "ABC0001";
    $EPS_TXNTYPE = "0";
    $password = "abc123";
    $formAction = 'https://test.api.securepay.com.au/directpost/authorise';
}

$reference = $reference . "-". $timestamp;
$secret = $password;
$string_hash= $merchantId."|".$password."|".$EPS_TXNTYPE."|".$reference."|".$amount."|".$timestamp;
//echo "<br/>string_hash = " . $string_hash;

// $hash= sha1($string_hash);
//echo "<br/>This is a SHA1 fingerprint = " . $hash;
// $hash= hash('sha256', $string_hash);
// echo "<br/>hash = " . $hash;
$hash=  hash_hmac('sha256', $string_hash, $secret);
 //echo "<br/>This is a SHA256-HMAC fingerprint = ".$hash;

$return_arr['FormAction']=$formAction;
$return_arr['MerchantId']=$merchantId;
$return_arr['Eps_txntype']=$EPS_TXNTYPE;
//$return_arr['password']=$password;
$return_arr['ReferenceId']=$reference;
$return_arr['TimeStamp']=$timestamp;
$return_arr['ResultUrl']=$resultUrl;
$return_arr['TotalAmount']=$amount;
$return_arr['FingerPrint']=$hash;
echo json_encode($return_arr);
// echo $formAction
?>
