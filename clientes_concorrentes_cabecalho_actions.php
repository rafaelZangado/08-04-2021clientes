<?
		
	switch ($id) {
		case "criar":
		
			if ($_POST['fields']['Clientes_Concorrentes_Cabecalho']['dsArquivo'] == '') {
				echo "Precisa de um arquivo";
				die();
			}
			$dir = $_SERVER['DOCUMENT_ROOT'] . '/clientes/'.$_SESSION['gerencia']['alias'] . '/mgerencia/arquivos/';
			@mkdir($dir);
			$dir = $_SERVER['DOCUMENT_ROOT'] . '/clientes/'.$_SESSION['gerencia']['alias'] . '/mgerencia/arquivos/concorrentes/';
			@mkdir($dir);			
			
            $arquivo = base64_decode($_POST['fields']['Clientes_Concorrentes_Cabecalho']['dsArquivo']);				
            $pathArquivo = date('YmdHis');				
            $file = 'random_'.rand(0,1000000000)."_".$pathArquivo .'.jpg';
            
            if ($arquivo != '') {            
                //$msg = $file;
                $fp = fopen ($dir . $file, 'w');
                fwrite($fp, $arquivo);
                fclose($fp);                                
                $_POST['fields']['Clientes_Concorrentes_Cabecalho']['dsArquivo'] = $file;             
            }
			
			$Clientes_Concorrentes_Cabecalho_id = $Clientes->concorrentes_cabecalho_atualizar();
			if ($Clientes_Concorrentes_Cabecalho_id > 0) {
				$msg = "Coleta aberta com sucesso. Insira os itens desta coleta.";
				$dest = 'clientes/concorrentes/criar&Clientes_Concorrentes_Cabecalho_id='.$Clientes_Concorrentes_Cabecalho_id;
			}
			break;
		case "deletar":
			$Clientes->concorrentes_cabecalho_deletar($_POST['fields']);
			$msg = "Item deletado com sucesso";
			$dest = "clientes/concorrentes_cabecalho";
			break;
	}
?>