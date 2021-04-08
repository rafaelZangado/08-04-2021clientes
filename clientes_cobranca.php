<h1>Cobranças a Receber</h1>
<!-- clientes/views/contatos/cobranca.php -->
<?

	$rand = rand(0,100000);
	$hasPrint = true;
	require_once 'modules/pessoas/controllers/pessoas.php';	
	require_once 'modules/clientes/controllers/clientes.php';
	require_once 'modules/configuracoes/views/parametros/request.php';	
	require_once 'modules/financeiro/controllers/financeiro.php';

	$funParams = $_GET;
	
    //[BLOCO 01-inicio]
        if($_GET['idFilial'] == ''){
            $funParams['idFilial'] = $_SESSION['idFilial'];
        }
        
        if ($funParams['statusCobranca'] == '') {
            $funParams['statusCobranca'] = 'Aberto';
        }
        if ($funParams['tpPeriodo'] == '') {
            $funParams['tpPeriodo'] = 'dtVencimentoCobrancaReceber';		
        }
        $funParams['dtPeriodo'] = '';
        
        $funParams['naoAgruparPessoa'] =true;
        $Financeiro->cobrancas_receber_listar($funParams);
        $cobrancasCarregadas = $Financeiro->fieldsarr['Financeiro_Cobrancas_Receber'];	
        
        $funParams['buscaNotaFiscal'] = true;
        unset($funParams['idCobrancaReceber'] ,$funParams['naoAgruparPessoa']);
        $Financeiro->cobrancas_receber_listar($funParams);
        $cobrancas = $Financeiro->fieldsarr['Financeiro_Cobrancas_Receber'];	
	//[BLOCO 01-fim]

    //[BLOCO 02-inicio]
        if (is_array($cobrancas)) {
            foreach ($cobrancas as $idPessoa => $cobrancasArr) {
                foreach ($cobrancasArr as $index => $cobranca) {

                    $pessoasArr[$idPessoa]['nmPessoa'] = $cobranca['nmPessoa'];
                    $cobranca['diasAtraso'] = $fieldsProcessing->calcularDias($cobranca['dtVencimentoCobrancaReceberOD'], date("d/m/Y")) - 1;

                    if ($cobranca['diasAtraso'] > 0) {

                        $cobranca['jurosAtraso'] = ($parametros['vrTaxaJuros'] / 100) * $cobranca['vrCobrancaReceber'];
                        $cobranca['jurosAtraso'] = $cobranca['jurosAtraso'] / 30;
                        $cobranca['jurosDia'] = $cobranca['jurosAtraso'];
                        $cobranca['jurosAtraso'] = $cobranca['jurosAtraso'] * $cobranca['diasAtraso'];
                        $cobranca['jurosAtraso'] = floor($cobranca['jurosAtraso'] * 100) / 100;
                        if ($cobranca['diasAtraso'] > 0) {
                            //$cobranca['vrMultas'] = ($parametros['vrMulta'] / 100) * $cobranca['vrCobrancaReceber'];
                        }
                        $cobranca['vrCobrancaReceber'] = $cobranca['vrCobrancaReceber'] + $cobranca['jurosAtraso'] + $cobranca['vrMultas'];
                    }
                    else {
                        $cobranca['diasAtraso'] = 0;	
                    }
                    $cobrancas[$idPessoa][$index] = $cobranca;
                }
            }
        }
    //[BLOCO 02-fim]

    //[BLOCO 03-inicio]
        unset($cobrancasArr);
        if (is_array($cobrancas)) {
            $vrTotal = 0;
            foreach ($cobrancas as $idPessoa => $cobrancasArr) {			
                $rand = rand(0,1000);		
                $pesParams['idPessoa'] = $idPessoa;
                $Pessoas->carregar($pesParams);
                $pesFields = $Pessoas->fields['Pessoas'];
                extract($pesFields);
                $cod = $idPessoa;

                if ($idPessoaExternal > 0) {
                    $cod = $idPessoaExternal;
                }

                $apelido = '';
                if (($nmApelido != '') && ($nmApelido != $nmPessoa)) {
                    $apelido = " - " . $nmApelido;
                }

                $Clientes->index_carregar($pesParams);
                $cliFields = $Clientes->fields['Clientes'];

                $pesParams['isEnderecoCobranca'] = 'Sim';
                $Pessoas->enderecos_carregar($pesParams);
                $enderecoFields = $Pessoas->fields['Pessoas_Enderecos'];
                
                ?>
                <div style="page-break-inside:avoid" class="smart-form">

                    <?
                        unset($colunas,$acoes);
                        //require 'index.formmaker.php';
                        //$idForm = $generate->formmaker($params);
                    ?>
                    <table class="table table-bordered" style="width:100%" id="formmaker-<?=$rand; ?>">
                        <thead>
                            <tr>
                                <td width="1"></td>
                                <td width="1">Cob</td>
                                <td width="30" align="center">RCA</td>
                                <td width="60" align="center">Duplic</td>
                                <td>Pedido</td>
                                <td>NF</td>
                                <td width="80">Venc</td>
                                <td width="80">Emissão</td>							
                                <td width="80">Baixa</td>
                                <td width="80">Caixa Baixa</td>
                                <td width="80" align="right">V.Aberto</td>
                                <td width="40" align="center">Atraso</td>
                                <td width="1" align="right">J.Dia</td>
                                <td width="50" align="right">J.Total</td>
                                <td width="50" align="right">Taxas</td>
                                <td width="80" align="right">V.Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                unset($totaisLocal);
                                foreach ($cobrancasArr as $id => $cobranca) {										
                                    $jurosDia = 0;
                                    $jurosAtraso = 0;
                                    extract($cobranca);							
                                    
                                    ?>
                                    <tr indexrow="<?=$id; ?>">
                                        <td class="tickbox">
                                            <?
                                                if (!$pages['print']) {
                                                    ?>
                                                    <label class="checkbox pull-left">
                                                        <input type="checkbox" class="clientes2" onclick="processarPessoasMarcadas2()" idCobrancaReceber2="<?=$idCobrancaReceber; ?>" 
                                                        <?
                                                            if(is_array($cobrancasCarregadas[$idCobrancaReceber])){
                                                                echo "checked";													
                                                            }																	
                                                        ?>
                                                        
                                                        >
                                                        <i></i>
                                                    </label>
                                                    <?
                                                }
                                            ?>
                                        </td>
                                        <td><?=strtoupper($cdCobrancaTipoC);?></td>
                                        <td align="center"><?=$idPessoaRca;?></td>
                                        <td align="center"><?=($idCobrancaReceberExternal > 0) ? $idCobrancaReceberExternal : $idCobrancaReceber;?></td>
                                        <td><?=$dsHistorico; ?><?=($idVendaExternal > 0) ? $idVendaExternal : ''; ?></td>
                                        <td><?=$ide_nNF; ?></td>
                                        <td><?=$dtVencimentoCobrancaReceberOD; ?></td>
                                        <td><?=$dtCobrancaReceberOD; ?></td>
                                        <td><?=$dtCobrancaReceberBaixa; ?></td>
                                        <td><?=$nmCaixaBaixa; ?></td>									
                                        <td align="right"><?=number_format($vrBruto, 2, ',', '.'); ?></td>
                                        <td align="center"><?=$diasAtraso; ?></td>
                                        <td align="right"><?=number_format($jurosDia, 2, ',', '.'); ?></td>
                                        <td align="right"><?=number_format($jurosAtraso, 2, ',', '.'); ?></td>
                                        <td align="right"><?=number_format($vrTaxas, 2, ',', '.'); ?></td>
                                        <td align="right"><?=number_format($vrCobrancaReceber, 2, ',', '.'); ?></td>
                                    </tr>
                                    <?
                                        $totais['vrBruto'] += $totaisLocal['vrBruto'] += $vrBruto;
                                        $totais['jurosAtraso'] += $totaisLocal['jurosAtraso'] += $jurosAtraso;
                                        $totais['vrCobrancaReceber'] += $totaisLocal['vrCobrancaReceber'] += $vrCobrancaReceber;
                                        $totais['vrTaxas'] += $totaisLocal['vrTaxas'] += $vrTaxas;                								
                                }
                            ?>

                            <tr>
                                <td colspan="8"><strong>Totais</strong></td>
                                <td></td>
                                <td></td>
                                <td align="right"><?=number_format($totaisLocal['vrBruto'], 2, ',', '.'); ?></td>
                                <td></td>
                                <td></td>							
                                <td align="right"><?=number_format($totaisLocal['jurosAtraso'], 2, ',', '.'); ?></td>
                                <td align="right"><?=number_format($totaisLocal['vrTaxas'], 2, ',', '.'); ?></td>
                                <td align="right"><strong><?=number_format($totaisLocal['vrCobrancaReceber'], 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <?
                    if ($cliFields['vrCreditoDisponivel'] > 0) {
                        ?>
                        <strong>NOTA: Esse cliente possuí um crédito de R$ <?=number_format($cliFields['vrCreditoDisponivel'], 2, ',','.'); ?></strong><br>
                        <?
                    }
                    echo "<br>";
                    unset($cobrancasArr);
                ?>
                </div>
                
                <?
            }
        }
        //23951
    //[BLOCO 03-fim]  		
?>

<br>
<!--[BLOCO 04-inicio]-->  
    <script>
    var idCobrancaReceber = '';
    processarPessoasMarcadas2();
        function processarPessoasMarcadas2() {
            idCobrancaReceber = '';
            $.each($(".clientes2:checked"), function(index, element) {
                console.log(idCobrancaReceber);
                idCobrancaReceber = idCobrancaReceber + "," + $(element).attr('idCobrancaReceber2');
                
            });
        }
    </script>
<!--[BLOCO 04-fim]-->  







