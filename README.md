# TotalVoiceAPI-PHP (LEGADO)

Nova Library [PHP Totalvoice](https://github.com/totalvoice/totalvoice-php)

## Como utilizar (how to)

```php
<?php 
require_once "TotalVoiceAPI.class.php";

$api = new TotalVoiceAPI("SEU-ACCESS-TOKEN");

$api->debugOn(); //ativa o modo debug, printa todos os requests e responses

/* configura o retorno dos metodos como um array associativo, exemplo: $retorno['msg'] */
$api->returnAssoc();

/* configura o retorno dos metodos como um objeto, exemplo: $retorno->msg */
//$api->returnObject(); //comportamento default

//print_r($api->enviaSMS("**********", "Esta é uma mensagem de testes"));
//print_r($api->enviaTTS("**********", "Isto é um texto falado"));
//print_r($api->enviaAudio("**********", "http://fooooooo.bar/audio.mp3"));

/*
$dados = array();

$tts['mensagem'] = 'lendo texto 222';
$tts['velocidade'] = -2;
$dados_tts['acao'] = 'tts';
$dados_tts['acao_dados'] = $tts;
array_push($dados, $dados_tts);



$audio['url_audio'] = 'http://www.totalvoice.com.br/central/ola_opcoes.mp3';
$audio['resposta_usuario'] = true;
$dados_audio['acao'] = 'audio';
$dados_audio['acao_dados'] = $audio;
array_push($dados, $dados_audio);


$tts2['mensagem'] = 'Obrigado! aguarde nosso contato em ate 24 horas';
$tts2['velocidade'] = -2;
$dados_tts2['acao'] = 'tts';
$dados_tts2['acao_dados'] = $tts2;
array_push($dados, $dados_tts2);
print_r($api->enviaComposto("48996281618", $dados, "4832830151"));
*/

print_r($api->enviaChamada("**********", "**********"));
echo "\n";
```

## Pré requisitos

- PHP deve estar compilado com a lib-curl


## Licença

MIT
