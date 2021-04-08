<?
	//clientes/views/chamadas_ligacoes/carregar.json.php
    $_GET['forceDateUnformmating'] = true;
	
	if ($_GET['Clientes_Chamadas_Ligacoes_id'] > 0 || $_GET['Clientes_Chamadas_Ligacoes_nrRamal'] != '') {
		$funParams = $_GET;
		$funParams['Clientes_Chamadas_Ligacoes_status'] = 'Aberto';
		$funParams['ultimahora'] = true;
		
		$Clientes->chamadas_ligacoes_carregar($funParams);
		$chamadasFields = $Clientes->fields['Clientes_Chamadas_Ligacoes'];
		
		if($chamadasFields['Clientes_Chamadas_Ligacoes_id'] > 0 ) {	
			
			$chamadasFields['Clientes_Chamadas_Ligacoes_status'] = 'Fechado';
			$_POST['fields']['Clientes_Chamadas_Ligacoes'] =$chamadasFields;
			$Clientes_Chamadas_Ligacoes_id = $Clientes->chamadas_ligacoes_atualizar();
			ob_clean();
			echo json_encode($chamadasFields);
		}else{
			ob_clean();
			echo "0";
		}
		
        }else{
            ob_clean();
            echo "0";
        }
?>