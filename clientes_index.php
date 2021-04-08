<?
    // clientes/views/index.php
	require_once 'modules/lojas/controllers/lojas.php';	
	$nmModulo = $_GET['nmModulo'];
?>
<!--[BLOCO 01-inicio]-->
    <form id="formPesquisaCliente<?=$rand; ?>" name="querybox">
    <h1>Buscar Clientes</h1>
        <table class="noBorder">
            <tr>
                <td>Nome:</td>
                <td><input type="text" name="fields[nmPessoa]" id="clientesnmPessoa<?=$rand; ?>" value="<?=$_GET['nmPessoa']; ?>"></td>
            </tr>
            <!-- Tipo: Ambos -->
            <input type="hidden" name="fields[tpPessoa]" id="clientestpPessoa<?=$rand; ?>" value="" >

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
            </tr>
        </table>
        <br>
        <input type="submit" value="Pesquisar" id="btnPesquisar">
    </form>
<!--[BLOCO 01-inicio]-->

<br>
<br>
<!--[BLOCO 02-inicio]-->
    <div>
    <h1>Resultados da Pesquisa</h1>
    
    <?
        if ($_GET['p']) {
            require 'resultadosPesquisa.php';
        }
    ?>
    
    </div>
<!--[BLOCO 02-fim]-->

<!--[BLOCO 03-inicio]-->
    <script>

        var nmPessoa;
        var tpPessoa;
        var idLoja;

        $("#formPesquisaCliente<?=$rand; ?>").submit(function() {
            
            nmPessoa = $("#clientesnmPessoa<?=$rand; ?>").val();
            idLoja = $("#clientesidLoja<?=$rand; ?>").val();
            tpPessoa = $("#clientestpPessoa<?=$rand; ?>").val();
            url = 'clientes/&adt=<?=$_GET['adt']; ?>&nmModulo=<?=$nmModulo; ?>&fieldId=<?=$_GET['fieldId']; ?>&nmPessoa='+nmPessoa+'&tpPessoa='+tpPessoa+'&idLoja='+idLoja+'&p=true&rand='+Math.random();
            
                <?            
                    if ($pages['isAssistente']) {
                        ?>
                            var windowsx = "#"+$("#btnPesquisar").closest('.internaAssistente').parent().attr('id');
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

        function inserirCliente(idCliente, nmPessoa) {
            var html = "<input type='hidden' name='fields<?=$_GET['adt']; ?>[idCliente]' value='"+idCliente+"'><input type='hidden' name='fields<?=$_GET['adt']; ?>[nmCliente]' value='"+nmPessoa+"'>"+idCliente+" - "+nmPessoa;
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
                </script>
            <?
        }
    ?>
<!--[BLOCO 05-fim]-->
