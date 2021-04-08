<?	

	//clientes/views/chamadas/get_telebrand.php
	$json = file_get_contents('http://192.168.0.26:8080/Getchamadasroque');
	$json = json_decode($json);
	$cabecalho = explode(",", $json->Chamada[0]->Registro);
	//[BLOCO 01-inicio]
		//INVERTER O CABECALHO
		foreach ($cabecalho  as $index => $campo) {
			$campos[$campo] = $index;
		}
		
		foreach ($json->Chamada as $index => $dados) {
			if ($index > 0) {
				$linha = explode(",", $dados->Registro);			
				foreach ($linha as $l => $valor) {
					$novasLinhas[$index][$cabecalho[$l]] = $valor;
				}
			}
		}
			
		foreach ($novasLinhas as $index => $valores) {		
			$pular = false;		
			switch ($valores['Status']) {
				case "ANSWERED":
					$status = "Atendida";
					break;
				default: 
					$status = 'Não Atendida';
					break;
			}
					
			//ARQUIVO
			$a = explode("/", $valores['Arquivo']);
			foreach ($a as $arquivo) {
				
			}
				
			$codigo = substr($valores['Chave'], 5, 99);
			$codigo = str_replace(".", "", $codigo);
			
			//REPRESENTA O GRUPO
			if ($valores['Destino'] < 999) {
				$destino = substr($valores['Destino'], 4, 8);
			}
			else {
				$destino = $valores['Destino'];
			}
			
			if (strlen($destino) == 4) {
				$nrRamal = $destino;
				$nrExtenro = $valores['Origem'];
			}
			if (strlen($valores['Origem']) == 4) {
				$nrRamal = $valores['Origem'];
				$nrExterno = $destino;
			}
			
			if ((strlen($destino) == 4) && (strlen($valores['Origem']) == 4)) {
				$pular = true;
			}
					
			if (!$pular) {			
				$chamadasArr[$codigo]['Clientes_Chamadas_id'] = $codigo;
				$chamadasArr[$codigo]['Clientes_Chamadas_nrOrigem'] = $valores['Origem'];
				$chamadasArr[$codigo]['Clientes_Chamadas_nmOrigem'] = $valores['caller id'];
				$chamadasArr[$codigo]['Clientes_Chamadas_tpTransferenciaDestino'] = $valores['caller id'];		
				$chamadasArr[$codigo]['Clientes_Chamadas_nrDestino'] = $destino;
				$chamadasArr[$codigo]['Clientes_Chamadas_status'] = $status;
				$chamadasArr[$codigo]['Clientes_Chamadas_vrDuracao'] = $valores['Tempo_Falado'];
				$chamadasArr[$codigo]['Clientes_Chamadas_arquivo'] = $arquivo;
				$chamadasArr[$codigo]['Clientes_Chamadas_nrRamal'] = $nrRamal;
				$chamadasArr[$codigo]['Clientes_Chamadas_nrExterno'] = $nrExterno;
				$chamadasArr[$codigo]['Clientes_Chamadas_link'] = $valores['Arquivo'];
				$chamadasArr[$codigo]['dtCriacao'] = $valores['Data_Hora'];
				$chamadasArr[$codigo]['pid'] = $valores['Chave'];				
			}		
		}
	//[BLOCO 01-fim]

	//[BLOCO 02-inicio]
		//FORMATAR NUMEROS
		foreach ($chamadasArr as $index => $chamada) {
					
			$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = '';		
			$tamanho = strlen($chamada['Clientes_Chamadas_nrOrigem']);

			if ($tamanho == 12) {
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigem'] = substr($chamada['Clientes_Chamadas_nrOrigem'], 1, 12);
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrOrigem'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 13) {
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigem'] = substr($chamada['Clientes_Chamadas_nrOrigem'], 2, 13);
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrOrigem'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 10) {
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigem'] = substr($chamada['Clientes_Chamadas_nrOrigem'], 2, 10);
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrOrigem'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 4) {			
				$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = $chamada['Clientes_Chamadas_nrOrigem'];
			}

			if ($chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] == '') {	

				$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos']  = 12;			
				$tamanho = strlen($chamada['Clientes_Chamadas_nrDestino']);
				if ($tamanho == 9) {
					$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 12) {
					$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 13) {
					$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 10) {
					$chamadasArr[$index]['Clientes_Chamadas_nrOrigemUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}			
			}
					
			$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = '';		
			$tamanho = strlen($chamada['Clientes_Chamadas_nrDestino']);

			if ($tamanho == 12) {
				$chamadasArr[$index]['Clientes_Chamadas_nrDestino'] = substr($chamada['Clientes_Chamadas_nrDestino'], 1, 12);
				$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 13) {
				$chamadasArr[$index]['Clientes_Chamadas_nrDestino'] = substr($chamada['Clientes_Chamadas_nrDestino'], 2, 13);
				$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 10) {
				$chamadasArr[$index]['Clientes_Chamadas_nrDestino'] = substr($chamada['Clientes_Chamadas_nrDestino'], 2, 10);
				$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
			}

			if ($tamanho == 4) {			
				$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = $chamada['Clientes_Chamadas_nrDestino'];
			}
			
			if ($chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] == '') {	
				
				$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos']  = 12;			
				$tamanho = strlen($chamada['Clientes_Chamadas_nrDestino']);

				if ($tamanho == 9) {
					$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 12) {
					$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 13) {
					$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}

				if ($tamanho == 10) {
					$chamadasArr[$index]['Clientes_Chamadas_nrDestinoUltimos'] = substr($chamada['Clientes_Chamadas_nrDestino'], $tamanho - 8, $tamanho);
				}
				
			}
			
			$chamadasArr[$index]['Clientes_Chamadas_arquivo'] = "telebrand/".$chamada['Clientes_Chamadas_arquivo'];		
			$_POST['fields']['Clientes_Chamadas'] = $chamadasArr[$index];
			$id = $Clientes->chamadas_atualizar();		
		}
	//[BLOCO 02-fim]
	
	//[BLOCO 03-inicio]
		foreach ($chamadasArr as $chamada) {				
			if (substr($chamada['Clientes_Chamadas_arquivo'], -3) == 'gsm') { 		
				$arrContextOptions = [
					"ssl" => [
					"verify_peer" => false,
					"verify_peer_name" => false,
					],
				];  

				$arquivo = 'http:'.$chamada['Clientes_Chamadas_link'];

				$pasta = $_SERVER['DOCUMENT_ROOT'] . '/clientes/'.$_SESSION['gerencia']['alias'].'/mgerencia/chamadas/';
				@mkdir($pasta);

				if (substr($valores['Arquivo'], 0, -3) != 'gsm') {
					$pular = true;
				}

				$nmArquivo = $chamada['Clientes_Chamadas_arquivo'] . '.mp3';

				if (!file_exists($pasta . $nmArquivo)) { 

					$file = file_get_contents($arquivo, false, stream_context_create($arrContextOptions));
					//echo $pasta . $nmArquivo . "\n";
					$fp = fopen($pasta . $chamada['Clientes_Chamadas_arquivo'], 'w');
					fwrite($fp, $file);
					fclose($fp);

					$comando = "sox ".$pasta.$chamada['Clientes_Chamadas_arquivo']." /var/www/localhost/htdocs/temp/teste.raw; lame -s 4 /var/www/localhost/htdocs/temp/teste.raw ".$pasta . $nmArquivo ."; rm ";
					echo exec("sox ".$pasta.$chamada['Clientes_Chamadas_arquivo']." /var/www/localhost/htdocs/temp/teste.raw; lame -s 4 /var/www/localhost/htdocs/temp/teste.raw ".$pasta . $nmArquivo ."; rm /var/www/localhost/htdocs/temp/teste.raw") . "\n";
					//die();
				}

				if (!file_exists($pasta . $chamada['Clientes_Chamadas_arquivo'])) { 
					$arr['Clientes_Chamadas_id'] = $chamada['Clientes_Chamadas_id'];	
					$Clientes->chamadas_deletar($arr);
				}
				else {
					echo $chamada['Clientes_Chamadas_arquivo'] . "<br>";
				}
			}
			
			
		}
	//[BLOCO 03-fim]
	
	
