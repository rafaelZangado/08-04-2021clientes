<? 
    //clientes/views/concorrentes/index.appmaker.php
    extract($_GET); 
    if (($modo != "editor") && (is_array($appmaker["sql"]))) { 
        foreach ($appmaker["sql"] as $params) { 
            $sys->listarDados($params); 
            $export[$params["dsVariavelRetorno"]] = $sys->fieldsarr[$params["nmTabela"]];	
        } 
        extract($export); 
        unset($export, $appmaker["appmaker"]["sql"]); 
    } 

    $menu['nmLabel'] = 'NOVA INFORMAÇÃO SOBRE CONCORRENTE';
    $menu['dsLink'] = 'clientes/concorrentes/criar';
    $programMenu[] = $menu;
    $gridformsearch = $fields;                  
                
    $coluna['nmField'] = 'Clientes_Concorrentes_id';
    $coluna['nmLabel'] = 'Código';
    $coluna['width'] = '5';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'nmPessoa';
    $coluna['nmLabel'] = 'Pessoa';
    $coluna['width'] = '150';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'dtCriacaoOD';
    $coluna['nmLabel'] = 'Data';
    $coluna['width'] = '50';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'nmCidade';
    $coluna['nmLabel'] = 'Cidade';
    $coluna['width'] = '100';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'nmProduto';
    $coluna['nmLabel'] = 'Produto';
    $coluna['width'] = '';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'nmSubcategoria';
    $coluna['nmLabel'] = 'Subcategoria';
    $coluna['width'] = '250';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'dsMarca';
    $coluna['nmLabel'] = 'Marca';
    $coluna['width'] = '80';
    $coluna['isNumeric'] = 'Não';
    $coluna['isFloat'] = 'Não';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $coluna['nmField'] = 'vrProduto';
    $coluna['nmLabel'] = 'Valor Unit';
    $coluna['width'] = '80';
    $coluna['isNumeric'] = 'Sim';
    $coluna['isFloat'] = 'Sim';
    $coluna['ifZeroNull'] = 'Não';
    $coluna['tpFuncaoGrafico'] = '';
    $coluna['hasTotalizador'] = 'Não';
    $coluna['colorConditions'] = '';
    $coluna['vrCampo'] = '';
    $coluna['component'] = '';
    $colunas[] = $coluna; unset($coluna);

    $formmaker[0]['contentTxt'] = '$concorrentesArr';
    $formmaker[0]['content'] = $generate->formmaker_formatFields($concorrentesArr, $colunas, $options);
    $formmaker[0]['headers'] = $generate->formmaker_formatColunas($colunas);
    $formmaker[0]['actions'] = $acoes;
    $formmaker[0]['options']['levels'] = '1';
    $formmaker[0]['options']['hasCheckboxLateral'] = 'Não';
    $formmaker[0]['options']['menuFile'] = '';
    $formmaker[0]['options']['formId'] = 'undefined';
    unset($colunas,$acoes,$options, $coluna);

    $appmaker['cards'][0]['label'] = 'Informações sobre Concorrentes';
    $appmaker['cards'][0]['options']['class'] = 'undefined';

    $appmaker['cards'][0]['tabs'][0]['options']['label'] = '';
    $appmaker['cards'][0]['tabs'][0]['options']['tpLayout'] = 'list';
    $appmaker['cards'][0]['tabs'][0]['options']['tpGraph'] = '';
    $appmaker['cards'][0]['tabs'][0]['options']['hasCheckboxLateral'] = '';
    $appmaker['cards'][0]['tabs'][0]['options']['scriptPesquisaTxt'] = 'undefined';
    $appmaker['cards'][0]['tabs'][0]['options']['linkBotao'] = 'undefined';
    $appmaker['cards'][0]['tabs'][0]['formmaker'] = '0';

    $appmaker['programMenu'] = $generate->formmaker_formatProgramMenu($programMenu);

    $appmaker['formmaker'] = $formmaker;
    $appmaker['gridformsearch'] = $gridformsearch;
    $appmaker['label'] = '';
    
    $app = $appmaker;
    unset($appmaker);
    $appmaker['appmaker'] = $app;?>