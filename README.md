# EvolineAPI-PHP
Lib PHP para integração com a API Evoline

## Como utilizar (how to)

```php
<?php 
require_once "EvolineAPI.class.php";

$api = new EvolineAPI("{{access-token}}");

$api->debugOn(); //ativa o modo debug, printa todos os requests e responses

/* configura o retorno dos metodos como um array associativo, exemplo: $retorno['msg'] */
$api->returnAssoc();

/* configura o retorno dos metodos como um objeto, exemplo: $retorno->msg */
//$api->returnObject(); //comportamento default

//print_r($api->enviaSMS("**********", "Esta é uma mensagem de testes"));
//print_r($api->enviaTTS("**********", "Isto é um texto falado"));
//print_r($api->enviaAudio("**********", "http://fooooooo.bar/audio.mp3"));
print_r($api->enviaChamada("**********", "**********"));
echo "\n";
```

## Pré requisitos

- PHP deve estar compilado com a lib-curl


## Licença

MIT
