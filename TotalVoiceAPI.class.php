<?php

class TotalVoiceAPI 
{
    protected $accessToken;
    protected $debug = false;
    protected $assoc = false;

    public function __construct($accessToken, $assoc=false, $debug=false) 
    {
        $this->accessToken = $accessToken;
        $this->assoc = $assoc;
        $this->debug = $debug;
    }

    public function debugOn() 
    {
        $this->debug = true;
    
    }
    public function debugOff() 
    {
        $this->debug = false;
    }

    //Todos os metodos retornam uma array associativa
    public function returnAssoc()
    {
        $this->assoc = true;
    }
    //Todos os metodos retornam uma objeto
    public function returnObject()
    {
        $this->assoc = false;
    }

    private function sendRequest($path, $method, $body=null) 
    {
        if ($this->debug) {
            echo "Evoline Request: $path  Method:  $method   Body:  $body \n";
        }
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, "https://api.totalvoice.com.br".$path);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        if ($body) {
            curl_setopt($request, CURLOPT_POST, true);
            curl_setopt($request, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($request, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Access-Token: '.$this->accessToken));
        $responseBody = curl_exec($request); 
        if ($this->debug) {
            echo "Evoline Response: $responseBody \n";
        }
            return json_decode($responseBody, $this->assoc);
        }

    /* CONTA */
    public function consultaSaldo() 
    {
        return $this->sendRequest('/saldo', 'GET');
    }


    public function minhaConta() 
    {
        return $this->sendRequest('/conta', 'GET');
    }

    public function atualizaDadosConta($nome, $login, $senha, $cpfCnpj, $telefone) 
    {
        $body = array();
        if ($nome) {
            $body['nome'] = $nome;
        }
        if ($login != null) {
            $body['login'] = $login;
        }
        if ($senha != null) {
            $body['senha'] = $senha;
        }
        if ($cpfCnpj != null) {
            $body['cpf_cnpj'] = $cpfCnpj;
        }
        if ($telefone != null) {
            $body['telefone'] = $telefone;
        }
        return $this->sendRequest('/conta', 'PUT', json_encode($body));
    }

    /* CHAMADA */
    public function enviaChamada($origem, $destino, $gravarAudio=false, $binaOrigem=null, $binaDestino=null) 
    {
        $body = array();
        $body['numero_origem'] = $origem;
        $body['numero_destino'] = $destino;
        $body['gravar_audio'] = $gravarAudio;
        if ($binaOrigem != null) {
            $body['bina_origem'] = $binaOrigem;
        }
        if ($binaDestino != null) {
            $body['bina_destino'] = $binaDestino;
        }
        return $this->sendRequest('/chamada', 'POST', json_encode($body));
    }


    public function cancelaChamada($chamadaId) 
    {
        return $this->sendRequest("/chamada/$chamadaId", 'DELETE');
    }

    public function statusChamada($chamadaId) 
    {
        return $this->sendRequest("/chamada/$chamadaId", 'GET');
    }
    
    public function relatorioChamadas($dataInicio, $dataFim) 
    {
        return $this->sendRequest("/chamada/relatorio?data_inicio=$dataInicio&data_fim=$dataFim", 'GET');
    }

    /* SMS */
    public function enviaSMS($numeroDestino, $mensagem, $respostaUsuario=false, $multiSMS = false, $dataCriacao = null) 
    {
        $body = array();
        $body['numero_destino'] = $numeroDestino;
        $body['mensagem'] = $mensagem;
        $body['resposta_usuario'] = $respostaUsuario;
        $body['multi_sms'] = $multiSMS;
        $body['data_criacao'] = $dataCriacao;
        return $this->sendRequest('/sms', 'POST', json_encode($body));
    }


    public function statusSMS($smsId) 
    {
        return $this->sendRequest("/sms/$smsId", 'GET');
    }

    public function relatorioSMS($dataInicio, $dataFim) 
    {
        return $this->sendRequest("/sms/relatorio?data_inicio=$dataInicio&data_fim=$dataFim", 'GET');
    }

    /* TTS */
    public function enviaTTS($numeroDestino, $mensagem, $velocidade=0, $respostaUsuario=false, $bina = null) 
    {
        $body = array();
        $body['numero_destino'] = $numeroDestino;
        $body['mensagem'] = $mensagem;
        $body['velocidade'] = $velocidade;
        $body['resposta_usuario'] = $respostaUsuario;
        $body['bina'] = $bina;
        return $this->sendRequest('/tts', 'POST', json_encode($body));
    }

    public function enviaComposto($numeroDestino, $dados, $bina) 
    {
        $body = array();
        $body['numero_destino'] = $numeroDestino;
        $body['dados'] = $dados;
        $body['bina'] = $bina;
        return $this->sendRequest('/composto', 'POST', json_encode($body));
    }

    public function statusTTS($ttsIs) 
    {
        return $this->sendRequest('/tts/' . $ttsIs, 'GET');
    }

    public function relatorioTTS($dataInicio, $dataFim) 
    {
        return $this->sendRequest("/tts/relatorio?data_inicio=$dataInicio&data_fim=$dataFim", 'GET');
    }

    /* Audio */
    public function enviaAudio($numeroDestino, $urlAudio, $respostaUsuario=false) 
    {
        $body = array();
        $body['numero_destino'] = $numeroDestino;
        $body['url_audio'] = $urlAudio;
        $body['resposta_usuario'] = $respostaUsuario;
        return $this->sendRequest('/audio', 'POST', json_encode($body));
    }

    
    public function statusAudio($audioId) 
    {
        return $this->sendRequest('/audio/' . $audioId, 'GET');
    }
    
    public function relatorioAudio($dataInicio, $dataFim) 
    {
        return $this->sendRequest("/audio/relatorio?data_inicio=$dataInicio&data_fim=$dataFim", 'GET');
    }
}
