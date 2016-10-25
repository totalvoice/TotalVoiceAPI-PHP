<?php 

require_once "TotalVoiceAPI.class.php";


$api = new TotalVoiceAPI("{{access-token}}");

$api->debugOn();

$api->returnAssoc();

//print_r($api->enviaSMS("**********", "Esta é uma mensagem de testes"));


//print_r($api->enviaTTS("**********", "Isto é um texto falado"));


//print_r($api->enviaAudio("**********", "http://fooooooo.bar/audio.mp3"));


print_r($api->enviaChamada("**********", "**********"));


echo "\n";
