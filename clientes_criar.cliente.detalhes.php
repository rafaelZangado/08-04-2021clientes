<?
    //clientes/views/contatos/criar.cliente.detalhes.php
	require_once 'modules/vendas/controllers/vendas.php';
	require_once 'modules/financeiro/controllers/financeiro.php';
	require_once 'modules/pessoas/controllers/pessoas.php';
	require_once 'modules/clientes/controllers/clientes.php';
	require_once 'modules/promocoes/controllers/promocoes.php';
	
    //[BLOCO 01-inicio]
        if ($_GET['idPessoa'] == '') {
            die();
        }
        
        //VER TODOS OS DÉBITOS DO CLIENTE
        $recParams['idPessoa'] = $_GET['idPessoa'];
        $recParams['dtPeriodo'] = '00-00-0000,'.date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
        $recParams['tpPeriodo'] = 'dtVencimentoCobrancaReceber';
        $recParams['statusCobranca'] = 'Aberto';
        $recParams['naoAgruparPessoa'] = true;
        $Financeiro->cobrancas_receber_listar($recParams);
        $receberArr = $Financeiro->fieldsarr['Financeiro_Cobrancas_Receber'];
        
        //PROCESSAR O CONTAS A RECEBER
        if (is_array($receberArr)) {
            foreach ($receberArr as $receber) {
                $vrTotalCobrancas += $receber['vrCobrancaReceber'];
            }
        }
            
        //CARREGAR A ÚLTIMA VENDA
        $vendParams['idPessoa'] = $_GET['idPessoa'];
        $Vendas->carregar($vendParams);
        $vendasFields = $Vendas->fields['Vendas'];
        
        $cliParams['idPessoa'] = $_GET['idPessoa'];
        $Pessoas->carregar($cliParams);
        $pesFields = $Pessoas->fields['Pessoas'];
            
        if ($pesFields['nrCelular1'] != '') {
            $numeros[$pesFields['nrCelular1']]['tipo'] = 'nrCelular1';
            $numeros[$pesFields['nrCelular1']]['icone'] = 'mobile';
        }
        
        if ($pesFields['nrCelular2'] != '') {
            $numeros[$pesFields['nrCelular2']]['tipo'] = 'nrCelular2';
            $numeros[$pesFields['nrCelular2']]['icone'] = 'mobile';
        }
        
        if ($pesFields['nrTelefone1'] != '') {
            $numeros[$pesFields['nrTelefone1']]['tipo'] = 'nrTelefone1';
            $numeros[$pesFields['nrTelefone1']]['icone'] = 'phone';
        }
        
        if ($pesFields['nrTelefone2'] != '') {
            $numeros[$pesFields['nrTelefone2']]['tipo'] = 'nrTelefone2';
            $numeros[$pesFields['nrTelefone2']]['icone'] = 'phone';
        }	
            
        //CARREGAR A ÚLTIMA CONSULTA SERASA
        $serParams['idPessoa'] = $_GET['idPessoa'];
        $Pessoas->serasa_carregar($serParams);
        $serasaFields = $Pessoas->fields['Pessoas_Serasa'];	
        $cliParams['idPessoa'] = $_GET['idPessoa'];
        $cliParams['hasColors'] = true;
        $cliParams['hasTicketMedio'] = true;
        $Clientes->carregar($cliParams);
        $cliFields = $Clientes->fields['Clientes'];	
        
        //CARREGAR O LIMITE DE CRÉDITO
        $limParams['idPessoa'] = $_GET['idPessoa'];
        $Clientes->limitesdecredito_carregar($limParams);
        $limFields = $Clientes->fields['Clientes_LimitesDeCredito'];

        $funParams['idPessoa'] = $_GET['idPessoa'];	
        $Financeiro->cobrancas_tipos_listar($funParams);
        $cobrancasTiposArr = $Financeiro->fieldsarr['Financeiro_Cobrancas_Tipos'];	
        
        if (is_array($cobrancasTiposArr)) {
            foreach ($cobrancasTiposArr as $cobranca) {
                $cobrancas .= $cobranca['cdCobrancaTipo'] . ", ";
            }
        }
        $cobrancas = substr($cobrancas, 0, -2);	
        
        $funParams['idPessoa'] = $_GET['idPessoa'];	
        $funParams['isAberto'] = 'Não';
        $Financeiro->planosdepagamentos_listar($funParams);
        $planosArr = $Financeiro->fieldsarr['Financeiro_PlanosDePagamentos'];
        
        if (is_array($planosArr)) {
            foreach ($planosArr as $plano) {
                $planos .= $plano['Financeiro_PlanosDePagamentos_nome'] . "<br>";
            }
        }
        
        $planos = substr($planos, 0, -2);
        
        if($cliFields['isBloqueado'] == 'Sim'){
            $isClasseRed = 'bg-color-red txt-color-white';
        
        }
        
        
        //VERIFICA SE EXISTE UMA PROMOÇÃO PARA LISTAR O SALDO DO CLIENTE
        $promoparams['idPessoa'] = $_GET['idPessoa'];
        $Promocoes->carregar($promoparams);
        $promocoesFields = $Promocoes->fields['Promocoes'];
	//[BLOCO 01-fim]
		
?>
<!--[BLOCO 02-inicio]-->
    <table class="table table-bordered">
        <tr>
            <td>Ticket Médio:</td>
            <td>R$ <?=number_format($cliFields['vrTicketMedio'], 2, ',', '.') ;?></td>
        </tr>
        <?
            if ($vrTotalCobrancas > 0) {
                ?>
                <tr>
                    <td>Débitos</td>
                    <td><a href="assistente:financeiro/cobrancas_receber/quadro&idPessoa=<?=$_GET['idPessoa']; ?>&statusCobranca=Aberto&dtPeriodo=00-00-0000,24-04-2016&hasntPesquisa=Sim">R$ <?=number_format($vrTotalCobrancas, 2, ',', '.'); ?></a></td>
                </tr>
                <?
            }
        ?>
        <tr>
            <td>Crédito de Cliente:</td>
            <td><?=number_format($cliFields['vrSaldo'], 2, ',', '.') ;?></td>
        </tr>
        <tr>
            <td>Limite de Crédito:</td>
            <td><?=number_format($limFields['Clientes_LimitesDeCredito_valor'], 2, ',', '.') ;?></td>
        </tr>
        <tr>
            <td>Limite de Crédito Utilizado:</td>
            <td><?=number_format($limFields['vrTotalConsumido'], 2, ',', '.') ;?></td>
        </tr>
        <tr>
            <td><strong>Limite de Crédito Disponível:</strong></td>
            <td><strong><?=number_format($limFields['vrSaldo'], 2, ',', '.') ;?></strong></td>
        </tr>
        <tr>
            <td>Bloqueado?</td>
            <td><?=$cliFields['isBloqueado']; ?></td>
        </tr>
        <tr>
            <td>Cons. Crédito</td>
            <td><?=$serasaFields['dtCriacaoOD']; ?></td>
        </tr>
        <tr>
            <td>Cobranças</td>
            <td><?=$cobrancas; ?></td>
        </tr>
        <tr>
            <td>Planos de Pagamento</td>
            <td><?=$planos; ?></td>
        </tr>        
    </table>
<!--[BLOCO 02-fim]-->

<!--[BLOCO 03-inicio]-->
    <div style="text-align:center">
    <?
        if (is_array($promocoesFields)) {
            ?>        
                <a href="assistente:promocoes/vendas/&Pessoas_idPessoa=<?=$_GET['idPessoa']; ?>" class="btn btn-warning">Saldo Cupons: <?=number_format($promocoesFields['vrSaldo'] / $promocoesFields['Promocoes_vrCriterio'], 2, ',', '.'); ?></a>
                    
            <?
        }
    ?>  
        
        <a onclick="window.open('#pessoas/index/central/<?=$_GET['idPessoa']; ?>')" class="btn btn-labeled btn-default"><span class="btn-label"><i class="fa fa-pencil" aria-hidden="true"></i></span>Editar Cadastro</a>
        <a onclick="window.open('#vendas/index/criar.unico/&idPessoa=<?=$_GET['idPessoa']; ?>')" class="btn btn-labeled btn-success"><span class="btn-label"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>Novo Pedido</a>
        <a onclick="window.open('#vendas/index/central/&dtPeriodo-ignorar=Sim&idPessoa=<?=$_GET['idPessoa']; ?>')" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>Pedidos</a>
        
        
    </div>
<!--[BLOCO 03-fim]-->

<hr>

<!--[BLOCO 04-inicio]-->
    <div style="text-align:center">
        <a href="" class="btn btn-xs txt-color-white bg-color-<?=$cliFields['dsColorVendaFaturada']; ?>"><i class="fa fa-money" aria-hidden="true"></i> Venda</a>
        <a href="" class="btn btn-xs txt-color-white bg-color-<?=$cliFields['dsColorPresencial']; ?>"><i class="fa fa-map-marker" aria-hidden="true"></i> Visita</a>
        <a href="" class="btn btn-xs txt-color-white bg-color-<?=$cliFields['dsColorDistancia']; ?>"><i class="fa fa-phone" aria-hidden="true"></i> Telemarketing</a>
    </div>
    <hr>
    <div style="text-align:center">
        <?
            if (is_array($numeros)) {
                foreach ($numeros as $numero => $num) {
                    ?>
                    <a class="btn bg-color-blue btn-xs txt-color-white" href="assistente:clientes/chamadas/ligar&idPessoa=<?=$pesFields['idPessoa']; ?>&tpTelefone=<?=$num['tipo']; ?>"><i class="fa fa-<?=$num['icone']; ?>" aria-hidden="true"></i> <?=$numero; ?></a>
                    <?									
                }
            }
        ?>
    </div>
<!--[BLOCO 04-fim]-->


<!--[BLOCO 05-inicio]-->
    <script>
        statusCliente = 'Aberto';
        $("#iniciarPedido").css('display', '');

        function carregarPagar(idPessoa) {
            var url = "financeiro/cobrancas_receber/lista&hasntPesquisa=true&dtPeriodo-ignorar=Sim&statusCobranca=Aberto&idPessoa="+idPessoa;
            console.log(url );
            navegarAssistente(url);
            /*$.get(url, function(data) {
            $("#areaReceber").html(data);
            });*/
        }
        function carregarUltimaVenda(idVenda) {
            var url = "vendas/index/listar&hasntPesquisa=true&dtPeriodo-ignorar=Sim&idVenda="+idVenda;
            console.log(url );
            navegarAssistente(url);
            /*$.get(url, function(data) {
            $("#areaReceber").html(data);
            });*/
        }
    </script>
<!--[BLOCO 05-fim]-->