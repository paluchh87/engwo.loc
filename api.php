<?php
//define('ROOT',dirname(__FILE__));
require_once 'vendor/autoload.php';

//echo 'fdg';
//$text = mb_strtolower($_REQUEST['text']);
$text = $_REQUEST['text'];
$get_audio = $_REQUEST['get_audio'];
$ru = $_REQUEST['ru'];
if ($ru == 1) {
    $lang = 'ru-RU';
} else {
    $lang = 'en-EN';
}

if ($get_audio) {
    $provider = new \duncan3dc\Speaker\Providers\ResponsiveVoiceProvider("$lang");
    $tts = new \duncan3dc\Speaker\TextToSpeech($text, $provider);
    //header("Content-Type: audio/mpeg");
    echo $tts->getAudioData();
} else {
    echo $text;
}
//echo 'fdg';
