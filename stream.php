<?php
require('token.php');

$crm = $creds['sessionAttributes']['user']['subscriberId'];
$uniqueId = $creds['sessionAttributes']['user']['unique'];

if (@$_REQUEST["key"] != "") {
    $headers = array(
        'appkey' => 'NzNiMDhlYzQyNjJm',
        'channelid' => '0',
        'crmid' => "$crm",
        'deviceId' => '3022048329094879',
        'devicetype' => 'phone',
        'isott' => 'true',
        'languageId' => '6',
        'lbcookie' => '1',
        'os' => 'android',
        'osVersion' => '5.1.1',
        'srno' => '200206173037',
        'ssotoken' => "$ssoToken",
        'subscriberId' => "$crm",
        'uniqueId' => "$uniqueId",
        'User-Agent' => 'plaYtv/6.0.9 (Linux; Android 5.1.1) ExoPlayerLib/2.13.2',
        'usergroup' => 'tvYR7NSNn7rymo3F',
        'versionCode' => '260'
    );
    $opts = ['http' => ['method' => 'GET', 'header' => array_map(function ($h, $v) {
        return "$h: $v";
    }
        , array_keys($headers), $headers),]];

    $cache = str_replace("/", "_", $_REQUEST["key"]);

    if (!file_exists($cache)) {
        $context = stream_context_create($opts);
        $haystack = file_get_contents("https://tv.media.jio.com/streams_live/" . $_REQUEST["key"] . $token, false, $context);
        var_dump ($haystack);
    } else {
        $haystack = file_get_contents($cache);
        var_dump ($opts);

    }
    echo $haystack;
}

if (@$_REQUEST["ts"] != "") {
    header("Content-Type: video/mp2t");
    header("Connection: keep-alive");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Expose-Headers: Content-Length,Content-Range");
    header("Access-Control-Allow-Headers: Range");
    header("Accept-Ranges: bytes");
    $opts = ["http" => ["method" => "GET", "header" => "User-Agent: plaYtv/6.0.9 (Linux; Android 5.1.1) ExoPlayerLib/2.13.2"]];
    var_dump ($opts);

    $context = stream_context_create($opts);
    $haystack = file_get_contents("https://jiotv.live.cdn.jio.com/" . $_REQUEST["ts"], false, $context);
    var_dump ($haystack);
    echo $haystack;
}
//  Return the contents of the output buffer
$htmlStr = ob_get_contents();
// Clean (erase) the output buffer and turn off output buffering
ob_end_clean(); 
// Write final string to file
file_put_contents($fileName, $htmlStr);