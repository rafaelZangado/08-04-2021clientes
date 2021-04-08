<?
    // clientes/views/pesquisarCliente.php
	$rand = rand(0, 1000);
	require_once 'modules/lojas/controllers/lojas.php';	
	$nmModulo = $_GET['nmModulo'];
	
	if ($_GET['nmField'] == '') {
		$_GET['nmFields'] = 'idCliente';
	}
?>
<!--[BLOCO 01-inicio]-->
    <form id="formPesquisaCliente<?=$rand; ?>" name="querybox">
    <h1>Buscar Clientes</h1>
        <table class="noBorder">
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="fields[nmPessoa]" id="clientesnmPessoa<?=$rand; ?>" value="<?=$_GET['nmPessoa']; ?>"></td>
            </tr>
            <tr>
                <td>CPF ou CNPJ:</td>
                <td><input type="text" name="fields[nrCpfCnpj]" id="nrCpfCnpj<?=$rand; ?>" value="<?=$_GET['nrCpfCnpj']; ?>"></td>
            </tr>
            <tr>
                <td>Código:</td>
                <td><input type="text" name="fields[idCliente]" id="clientesidCliente<?=$rand; ?>" value="<?=$_GET['idCliente']; ?>"></td>
            </tr>        
            <tr>
                <td>Tipo:</td>
                <td>
                    <label><input type="radio" name="clientestpPessoa<?=$rand; ?>" value="" <? $tpPessoa = $_GET['tpPessoa']; if (($tpPessoa != "F") && ($tpPessoa != "J")) echo 'checked'; ?>>Ambos</label>
                    <label><input type="radio" name="clientestpPessoa<?=$rand; ?>" value="F" <? if ($tpPessoa == "F") echo 'checked'; ?>> Fisica</label>
                    <label><input type="radio" name="clientestpPessoa<?=$rand; ?>" value="J" <? if ($tpPessoa == "J") echo 'checked'; ?>> Jurídica</label>
                </td>
            </tr>
            <tr>
            <td>Loja:</td>
            <td>
                <select name='fields[idLoja]' id='clientesidLoja<?=$rand; ?>'>
                    <?
                        $Lojas->listar($_SESSION['idLoja']);
                        $lojasarr = $Lojas->fieldsarr['Lojas'];
                        if (count($lojasarr) > 0) {
                            foreach ($lojasarr as $loja) {
                                $nmLoja = $loja['nmLoja'];
                                $idLoja = $loja['idLoja'];
                                ?>
                                    <option value='<?=$idLoja; ?>'><?=$nmLoja; ?></option>
                                <?
                            }
                        }
                    ?>
                </select>
            </td>        
        </table>
        <br>
        <input type="submit" value="Pesquisar" id="btnPesquisar">
    </form>
<!--[BLOCO 01-fim]-->

<!--[BLOCO 02-inicio]-->
    <br><br>
    <div>
    <h1>Resultados da Pesquisa</h1>  
        <?
            if ($_GET['p']) {
                require 'pesquisarClienteResults.php';
            }
        ?>  
    </div>
<!--[BLOCO 02-fim]-->

<!--[BLOCO 03-inicio]-->
    <script>

        var idCliente;
        var nmPessoa;
        var tpPessoa;
        var idLoja;

        $("#formPesquisaCliente<?=$rand; ?>").submit(function() {
            
            idCliente = $("#clientesidCliente<?=$rand; ?>").val();
            nrCpfCnpj = $("#nrCpfCnpj<?=$rand; ?>").val();
            nmPessoa = $("#clientesnmPessoa<?=$rand; ?>").val();
            idLoja = $("#clientesidLoja<?=$rand; ?>").val();
            tpPessoa = $('input:radio[name=clientestpPessoa<?=$rand; ?>]:checked').val();
            url = 'clientes/pesquisarCliente&adt=<?=$_GET['adt']; ?>&nmField=<?=$_GET['nmField']; ?>&nmModulo=<?=$nmModulo; ?>&nrCpfCnpj='+nrCpfCnpj+'&fieldId=<?=$_GET['fieldId']; ?>&idCliente='+idCliente+'&nmPessoa='+nmPessoa+'&tpPessoa='+tpPessoa+'&idLoja='+idLoja+'&p=true&rand='+Math.random();
            
                <?            
                    if ($pages['isAssistente']) {
                        ?>
                        var windowsx = "#"+$("#formPesquisaCliente<?=$rand; ?>").closest('.internaAssistente').parent().attr('id');
                        carregarAssistente(url, windowsx);                    
                        <?
                    }
                    else {
                        ?>
                            document.location.hash = url;
                        <?
                    }                
                ?>
                return false;
        });

        $("#clientesnmPessoa<?=$rand; ?>").focus();

        function inserirCliente(idCliente, nmPessoa, nrPontos) {
            var html = "<input type='hidden' name='fields<?=$_GET['adt']; ?>[<?=$_GET['nmField']; ?>]' value='"+idCliente+"'><input type='hidden' name='fields<?=$_GET['adt']; ?>[nrPontos]' value='"+nrPontos+"' id='nrPontos'><input type='hidden' name='fields<?=$_GET['adt']; ?>[nmCliente]' value='"+nmPessoa+"'>Código:"+idCliente+" <br>Nome: "+nmPessoa+" <br>Pontos: "+nrPontos;
            $("#areaCliente<?=$_GET['fieldId']; ?>").html(html);
            fecharAssistente('Sec');
        }
    </script>
<!--[BLOCO 03-fim]-->

<!--[BLOCO 04-inicio]-->
    <?
        if ($_GET['sel']) {
            ?>
                <script>
                    inserirCliente(<?=$_GET['idCliente']; ?>, '<?=$_GET['nmPessoa']; ?>');
                    fecharAssistente('');
                    fecharAssistente('');
                </script>
            <?
        }
    ?>
<!--[BLOCO 04-fim]-->