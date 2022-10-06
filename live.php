<?php

require('token.php');

session_start();

header("Content-Type: application/vnd.apple.mpegurl");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length,Content-Range");
header("Access-Control-Allow-Headers: Range");
header("Accept-Ranges: bytes");

$_SESSION["p"] = $token;

if ($token != "" && @$_REQUEST["c"] != "") {
    $opts = ["http" => ["method" => "GET", "header" => "User-Agent: plaYtv/6.0.9 (Linux; Android 5.1.1) ExoPlayerLib/2.13.2"]];
    var_dump ($opts);
    $cx = stream_context_create($opts);
    var_dump ($cx);
    $hs = file_get_contents("https://jiotv.live.cdn.jio.com/" . $_REQUEST["c"] . "/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] . ".m3u8" . $token, false, $cx);
    var_dump ($hs);
    $hs = @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] . "-([^.]+\.)key/", 'stream.php?key=' . $_REQUEST["c"] . '/' . $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1key', $hs);
    var_dump ($hs);
    $hs = @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] . "-([^.]+\.)ts/", 'stream.php?ts=' . $_REQUEST["c"] . '/' . $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1ts', $hs);
    var_dump ($hs);
    $hs = str_replace("https://tv.media.jio.com/streams_live/" . $_REQUEST["c"] . "/", "", $hs);
    var_dump ($hs);
    print $hs;
}
//  Return the contents of the output buffer
$htmlStr = ob_get_contents();
// Clean (erase) the output buffer and turn off output buffering
ob_end_clean(); 
// Write final string to file
file_put_contents($fileName, $htmlStr);