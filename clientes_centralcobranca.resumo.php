<?
    //clientes/views/contatos/centralcobranca.resumo.php
	require_once '../mtos_novo/controllers/charts.php';
	
?>
<!--[BLOCO inicio] -->
<div class="row">
    <!--[BLOCO 01 inicio] -->
	<div class="col col-md-4">
		<header>Modalidade</header>
		<?
            unset($contParams, $grArr);
            $contParams = $_GET;
            $contParams['dtPeriodo'] = $_GET['dtPeriodo'];
            $contParams['idContatoTipo'] = '1,7,12,14';
            $contParams['params']['fields'][] = array('sql' => 'COUNT(clicont.idContatoTipo)', 'nmField' => 'qtdContatos');
            $contParams['params']['fields'][] = array('sql' => 'clicont.idContatoTipo', 'nmField' => 'idContatoTipo');
            $contParams['params']['fields'][] = array('sql' => 'clicont.tpContatoTipo', 'nmField' => 'Clientes_Contatos_Ocorrencias_descricao');
            $contParams['params']['varRef'][] = 'Clientes_Contatos_Ocorrencias_descricao';
            $contParams['params']['groupby'] = 'clicont.idContatoTipo';
            $contParams['joinOcorrencias'] = true;
            $Clientes->contatos_listar($contParams);
            $resumoContatos = $Clientes->fieldsarr['Clientes_Contatos'];


            if (is_array($resumoContatos)) {
                foreach ($resumoContatos as $dados) {
                    $qtdContatos += $dados['qtdContatos'];
                }
                foreach ($resumoContatos as $index => $dados) {
                    $resumoContatos[$index]['pcntContatos'] = ($dados['qtdContatos'] / $qtdContatos) * 100;
                    $label = $dados['Clientes_Contatos_Ocorrencias_descricao'];
                    $grArr['linhas'][$label] = $label;
                    $grArr['valores'][$label]['Totais'] = $dados['qtdContatos'];
                    $grArr['colunas']['Totais'] = 'Totais';

                }

                unset($colunas,$acoes);
                require 'centralcobranca.resumo.formmaker.php';
                $params['novo'] = 1;
                $generate->formmaker($params);

            }
            else {
                $generate->message("danger", "Nenhum resultado encontrado");
            }

            $grArr['hasntTotalizadores'] = true;
            $grArr['hasTabela'] = false;
            $grArr['tipo'] = 'pie';
            $Charts->make($grArr);	
	    ?>
	</div>
    <!--[BLOCO 01 fim] -->

    <!--[BLOCO 02 inicio] -->
	<div class="col col-md-4">
		<header>Ocorrência</header>
		<?
            $contParams = $_GET;
            $contParams['dtPeriodo'] = $_GET['dtPeriodo'];
            $contParams['idContatoTipo'] = '1,7,13,14';
            $contParams['params']['fields'][] = array('sql' => 'COUNT(clicon.Clientes_Contatos_Ocorrencias_id)', 'nmField' => 'qtdContatos');
            $contParams['params']['fields'][] = array('sql' => 'clicon.Clientes_Contatos_Ocorrencias_id', 'nmField' => 'Clientes_Contatos_Ocorrencias_id');
            $contParams['params']['fields'][] = array('sql' => 'Clientes_Contatos_Ocorrencias_descricao', 'nmField' => 'Clientes_Contatos_Ocorrencias_descricao');
            $contParams['params']['varRef'][] = 'Clientes_Contatos_Ocorrencias_id';
            $contParams['params']['groupby'] = 'clicon.Clientes_Contatos_Ocorrencias_id';
            $contParams['joinOcorrencias'] = true;
            $Clientes->contatos_listar($contParams);
            $resumoContatos = $Clientes->fieldsarr['Clientes_Contatos'];

            if (is_array($resumoContatos)) {
                foreach ($resumoContatos as $dados) {
                    $qtdContatos += $dados['qtdContatos'];
                }
                foreach ($resumoContatos as $index => $dados) {
                    $resumoContatos[$index]['pcntContatos'] = ($dados['qtdContatos'] / $qtdContatos) * 100;
                    $label = $dados['Clientes_Contatos_Ocorrencias_descricao'];
                    $grArr['linhas'][$label] = $label;
                    $grArr['valores'][$label]['Totais'] = $dados['qtdContatos'];
                    $grArr['colunas']['Totais'] = 'Totais';
                }

                require 'centralcobranca.resumo.formmaker.php';
                $params['novo'] = 1;
                $generate->formmaker($params);

            }
            else {
                $generate->message("danger", "Nenhum resultado encontrado");
            }

            $grArr['hasntTotalizadores'] = true;
            $grArr['hasTabela'] = false;
            $grArr['tipo'] = 'pie';

            $Charts->make($grArr);
		?>
	</div>
    <!--[BLOCO 02 fim] -->

    <!--[BLOCO 03 inicio] -->
	<div class="col col-md-4">
		<header>Saldo de Resultados</header>
		<?
            unset($contParams, $grArr);
            $contParams = $_GET;
            $contParams['dtPeriodo'] = $_GET['dtPeriodo'];
            $contParams['idContatoTipo'] = '1,7,13,14';
            $contParams['params']['fields'][] = array('sql' => 'COUNT(clioco.Clientes_Contatos_Ocorrencias_tpResultado)', 'nmField' => 'qtdContatos');
            $contParams['params']['fields'][] = array('sql' => 'clioco.Clientes_Contatos_Ocorrencias_tpResultado', 'nmField' => 'Clientes_Contatos_Ocorrencias_id');
            $contParams['params']['fields'][] = array('sql' => 'Clientes_Contatos_Ocorrencias_tpResultado', 'nmField' => 'Clientes_Contatos_Ocorrencias_descricao');
            $contParams['params']['varRef'][] = 'Clientes_Contatos_Ocorrencias_descricao';
            $contParams['params']['groupby'] = 'clioco.Clientes_Contatos_Ocorrencias_tpResultado';
            $contParams['joinOcorrencias'] = true;
            $Clientes->contatos_listar($contParams);
            $resumoContatos = $Clientes->fieldsarr['Clientes_Contatos'];

            if (is_array($resumoContatos)) {
                foreach ($resumoContatos as $dados) {
                    $qtdContatos += $dados['qtdContatos'];
                }
                foreach ($resumoContatos as $index => $dados) {
                    $resumoContatos[$index]['pcntContatos'] = ($dados['qtdContatos'] / $qtdContatos) * 100;
                    $label = $dados['Clientes_Contatos_Ocorrencias_descricao'];
                    $grArr['linhas'][$label] = $label;
                    $grArr['valores'][$label]['Totais'] = $dados['qtdContatos'];
                    $grArr['colunas']['Totais'] = 'Totais';
                }
                unset($colunas,$acoes);
                require 'centralcobranca.resumo.formmaker.php';
                $params['novo'] = 1;
                $generate->formmaker($params);
            }
            else {
                $generate->message("danger", "Nenhum resultado encontrado");
            }

            $grArr['hasntTotalizadores'] = true;
            $grArr['hasTabela'] = false;
            $grArr['tipo'] = 'pie';

            $Charts->make($grArr);
		?>
	</div>
    <!--[BLOCO 03 fim] -->
</div>
<!--[BLOCO fim] -->