<?php
class TotalVoiceAPI {
	var $accessToken;
	var $debug = false;
	var $assoc = false;
	function TotalVoiceAPI($accessToken, $assoc=false, $debug=false) {
		$this->accessToken = $accessToken;
		$this->assoc = $assoc;
		$this->debug = $debug;
	}
	public function debugOn() {
		$this->debug = true;
	}
	public function debugOff() {
		$this->debug = false;
	}
	//Todos os metodos retornam uma array associativa
	public function returnAssoc(){
		$this->assoc = true;
	}
	//Todos os metodos retornam uma objeto
	public function returnObject(){
		$this->assoc = false;
	}
	private function sendRequest($path, $method, $body=null) {
		if ($this->debug) {
			echo "Evoline Request: " . $path . " Method: " . $method . " Body: " . $body . "\n";
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.totalvoice.com.br".$path);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//if ssl problems uncomment:
		//curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 0);
		if($body){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Access-Token: ".$this->accessToken));
		$response_body = curl_exec($ch); 
		if ($this->debug) {
			echo "Evoline Response: " . $response_body . "\n";
		}
		return json_decode($response_body, $this->assoc);
	}
	/* CONTA */
	public function consultaSaldo() {
		return $this->sendRequest("/saldo", "GET");
	}
	public function minhaConta() {
		return $this->sendRequest("/conta", "GET");
	}
	public function atualizaDadosConta($nome, $login, $senha, $cpf_cnpj, $telefone) {
		$body = array();
		if ($nome) {
			$body["nome"] = $nome;
		}
		if ($login != null) {
			$body["login"] = $login;
		}
		if ($senha != null) {
			$body["senha"] = $senha;
		}
		if ($cpf_cnpj != null) {
			$body["cpf_cnpj"] = $cpf_cnpj;
		}
		if ($telefone != null) {
			$body["telefone"] = $telefone;
		}
		return $this->sendRequest("/conta", "PUT", json_encode($body));
	}
	/* CHAMADA */
	public function enviaChamada($origem, $destino, $gravar_audio=false, $bina_origem=null, $bina_destino=null) {
		$body = array();
		$body["numero_origem"] = $origem;
		$body["numero_destino"] = $destino;
		$body["gravar_audio"] = $gravar_audio;
		if ($bina_origem != null) {
			$body["bina_origem"] = $bina_origem;
		}
		if ($bina_destino != null) {
			$body["bina_destino"] = $bina_destino;
		}
		return $this->sendRequest("/chamada", "POST", json_encode($body));
	}
	public function cancelaChamada($chamadaId) {
		return $this->sendRequest("/chamada/" . $chamadaId, "DELETE");
	}
	public function statusChamada($chamadaId) {
		return $this->sendRequest("/chamada/" . $chamadaId, "GET");
	}
	public function relatorioChamadas($dataInicio, $dataFim) {
		return $this->sendRequest("/chamada/relatorio?data_inicio=" . $dataInicio . "&data_fim=" . $dataFim, "GET");
	}
	/* SMS */
	public function enviaSMS($numero_destino, $mensagem, $resposta_usuario=false) {
		$body = array();
		$body["numero_destino"] = $numero_destino;
		$body["mensagem"] = $mensagem;
		$body["resposta_usuario"] = $resposta_usuario;
		return $this->sendRequest("/sms", "POST", json_encode($body));
	}
	public function statusSMS($smsId) {
		return $this->sendRequest("/sms/" . $smsId, "GET");
	}
	public function relatorioSMS($dataInicio, $dataFim) {
		return $this->sendRequest("/sms/relatorio?data_inicio=" . $dataInicio . "&data_fim=" . $dataFim, "GET");
	}
	/* TTS */
	public function enviaTTS($numero_destino, $mensagem, $velocidade=0, $resposta_usuario=false) {
		$body = array();
		$body["numero_destino"] = $numero_destino;
		$body["mensagem"] = $mensagem;
		$body["velocidade"] = $velocidade;
		$body["resposta_usuario"] = $resposta_usuario;
		return $this->sendRequest("/tts", "POST", json_encode($body));
	}
	
	public function enviaComposto($numero_destino, $dados, $bina) {
	        $body = array();
	        $body["numero_destino"] = $numero_destino;
	        $body["dados"] = $dados;
	        $body["bina"] = $bina;
	        return $this->sendRequest("/composto", "POST", json_encode($body));
	}

	
	public function statusTTS($ttsIs) {
		return $this->sendRequest("/tts/" . $ttsIs, "GET");
	}
	public function relatorioTTS($dataInicio, $dataFim) {
		return $this->sendRequest("/tts/relatorio?data_inicio=" . $dataInicio . "&data_fim=" . $dataFim, "GET");
	}
	/* Audio */
	public function enviaAudio($numero_destino, $url_audio, $resposta_usuario=false) {
		$body = array();
		$body["numero_destino"] = $numero_destino;
		$body["url_audio"] = $url_audio;
		$body["resposta_usuario"] = $resposta_usuario;
		return $this->sendRequest("/audio", "POST", json_encode($body));
	}
	public function statusAudio($audioId) {
		return $this->sendRequest("/audio/" . $audioId, "GET");
	}
	public function relatorioAudio($dataInicio, $dataFim) {
		return $this->sendRequest("/audio/relatorio?data_inicio=" . $dataInicio . "&data_fim=" . $dataFim, "GET");
	}
}
