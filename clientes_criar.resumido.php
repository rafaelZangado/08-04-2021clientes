<!-- clientes/views/contatos/criar.resumido.php -->

<h1>Clientes - Registrar Contato</h1>
<!--[BLOCO 01-inicio]-->
    <?
        require_once 'modules/pessoas/controllers/pessoas.php';
        require_once 'modules/clientes/controllers/clientes.php';
        
        $pesParams['idPessoa'] = $_GET['idPessoa'];
        $Pessoas->carregar($pesParams);
        $pesFields = $Pessoas->fields['Pessoas'];	
        $Pessoas->enderecos_carregar($pesParams);
        $enderecoFields = $Pessoas->fields['Pessoas_Enderecos'];	
        $Clientes->carregar($pesParams);
        $cliFields = $Clientes->fields['Clientes'];	
        //CARREGAR O LIMITE DE CRÉDITO			
        $Clientes->limitesdecredito_carregar($pesParams);
        $limFields = $Clientes->fields['Clientes_LimitesDeCredito'];
        if($limFields['vrSaldo'] < 0){
            $limFields['vrSaldo'] = 0;	
        }
    ?>
<!--[BLOCO 01-fim]-->

<!--[BLOCO 02-inicio]-->
	<header>
	<?=$pesFields['idPessoa']; ?> - <?=$pesFields['nmPessoa']; ?>:  <?=$apelido; ?> </header>
	    <?
            if ($pesFields['tpPessoa'] == 'J') {
                ?>
                CNPJ: <?=$fieldsProcessing->mask($pesFields['nrCnpj'], "##.###.###/####-##"); ?>
                <?
            }
            else {
                ?>
                    CPF: <?=$fieldsProcessing->mask($pesFields['nrCpf'], "###.###.###-##"); ?>
                <?
            }
	    ?>
        <br>
		  
        ENDEREÇO: <?=$enderecoFields['dsLogradouro'] ; ?>, <?=$enderecoFields['nrNumero']; ?>, <?=$enderecoFields['nmBairro']; ?> - <?=$enderecoFields['nmCidade']; ?> - <?=$enderecoFields['dsUF']; ?> - FONES: <?=$nrTelefone1; ?> <?=$nrTelefone2; ?> <?=$nrCelular1; ?><br>
        BQ: <?=$cliFields['isBloqueado']; ?> - BQD: <?=$cliFields['isBloqueadoDefinitivo']; ?> - ULT. COMPRA: <?=$vendasFields['dtVendaOD']; ?> - SERASA: <?=$serasaFields['dtCriacaoOD']; ?> <br>
        Tel: <?=$pesFields['nrTelefone1']; ?> <?=$pesFields['nrTelefone2']; ?> <?=$pesFields['nrCelular1']; ?>  <?=$pesFields['nrCelular2']; ?>
        <br>
        <br>
<!--[BLOCO 02-fim]-->

<!--[BLOCO 03-inicio]-->
    <?            
        $contatosFields['tpParceiro'] = 'Cliente';
        $funParams2['tpAtuacao'] = 'Distancia,Cobranca,Sem Contato,Presencial';
        $funParams2['isVenda'] = 'Não';
        $Clientes->contatos_tipos_listar($funParams2);
        $tipos = $Clientes->fieldsarr['Clientes_Contatos_Tipos'];
        $tiposArr['']['tpContatoTipo'] = 'Selecione';
        foreach ($tipos as $index => $tipo) {
            $tiposArr[$index] = $tipo;
        }

        $Clientes->contatos_ocorrencias_listar($ocoParams);
        $ocorrencias = $Clientes->fieldsarr['Clientes_Contatos_Ocorrencias'];
        $ocorrenciasArr['']['Clientes_Contatos_Ocorrencias_descricao'] = 'Selecione';
        foreach ($ocorrencias as $index => $tipo) {
            $ocorrenciasArr[$index] = $tipo;
        }       
        
        unset($fields);
        $contatosFields['pid'] = rand(0,99999);
        $contatosFields['idAgendamento'] = $_GET['idAgendamento'];
        $contatosFields['idContatoTipo'] = $_GET['idContatoTipo'];
        $contatosFields['idPessoa'] = $_GET['idPessoa'];
        $contatosFields['hasOcorrencias'] = 'Sim';
        require 'criar.cliente.form.php';
        $idForm = $generate->gridform($params);
    ?>
<!--[BLOCO 03-fim]-->