<?
include "inc/config.php";
?>
<html>
<head>
<div id='msgsContainer' class="lista">
<?
$OnFocus =  " class='link' onfocus=\"this.className='focus';\" onblur=\"this.className='link';\"";
if ($_REQUEST[tipo]=="trans"){
  if (strlen($_REQUEST[valor])>2){
    $Nome_Transportadora = strtoupper($_REQUEST[valor]);
    $sql = "SELECT id, nome FROM transportadoras where nome like '%$Nome_Transportadora%' order by nome limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','transportadora');Adiciona('','','trans_cc');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','$l[nome]','transportadora');Adiciona('','$l[nome]','trans_cc');document.cad.transportadora.focus();\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
      }
    }    
    
    // if ($ccc<>""){
      // echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      // $i=1;
      // while ($l = pg_fetch_array($Listar_Leitura)){
        // $i++;
        // $Nome = str_replace($Nome_Transportadora, "<b>$Nome_Transportadora</b>", $l[nome]);
        // echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[id]','$l[nome]','$_REQUEST[tipo]');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)."</a><BR>";
      // }
    // }
  }
}elseif ($_REQUEST[tipo]=="condpag"){
  if (strlen($_REQUEST[valor])>0){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT codigo, descricao FROM condicao_pagamento where descricao like '%$Valor1%' and  codigo > 1 order by descricao limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[descricao]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[descricao]','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)."</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="regiao"){
  if (strlen($_REQUEST[valor])>0){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT codigo, descricao FROM regiao where descricao like '%$Valor1%' order by descricao limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[descricao]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[descricao]','$_REQUEST[tipo]');\">$Nome</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="ramo"){
  if (strlen($_REQUEST[valor])>1){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT codigo, descricao FROM ramo_de_atividade where descricao like '%$Valor1%' order by descricao limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[descricao]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[descricao]','$_REQUEST[tipo]');\">$Nome</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="banco"){
  if (strlen($_REQUEST[valor])>1){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT cod_banco_cobranca, nome FROM bancos_cobranca where nome like '%$Valor1%' order by nome limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[cod_banco_cobranca]','$l[nome]','$_REQUEST[tipo]');\">$Nome</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="cliente"){
  if (strlen($_REQUEST[valor])>3){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if (($_SESSION[nivel]=="2") AND ($_SESSION[login]!=="ANGELINA") ){
      $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    }else{
				  if($_SESSION[login]=="ANGELINA"){
								$sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
						}else{
								$sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
						}						
    }
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[cgc]','$l[cgc]','$_REQUEST[tipo]cnpj');Adiciona('$l[inscricao]','$l[inscricao]');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 35)." - <b>$l[cgc]</b></a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="nome"){
  if (strlen($_REQUEST[valor])>3){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($_SESSION[nivel]=="2"){
      $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    }else{
      $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
    }
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[cgc]','$l[cgc]','cnpj');Adiciona('$l[inscricao]','$l[inscricao]');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');checa(document.cad.cnpj.value,'document.cad.cnpj');document.cad.inscricao.focus();\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="credito"){
  if (strlen($_REQUEST[valor])>3){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($_SESSION[nivel]=="2"){
      $sql = "SELECT cgc, nome FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    }else{
      $sql = "SELECT cgc, nome FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
    }
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="pedidos_clientes"){
  if (strlen($_REQUEST[valor])>3){
    $Valor1 = strtoupper($_REQUEST[valor]);
/*     if ($_SESSION[nivel]=="2"){
      $sql = "SELECT cgc, apelido, contato, id as codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    }else{
      $sql = "SELECT cgc, apelido, contato, id as codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
    } */
    
    if ($_SESSION[nivel]=="2"){
      $sql = "SELECT cgc, apelido, contato, id as codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' order by nome limit 10";
    }else{
      $sql = "SELECT cgc, apelido, contato, id as codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
    }    

//    echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
//    echo $ccc;
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="previsao_pedido"){
  if (strlen($_REQUEST[valor])>3){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($_SESSION[nivel]=="2"){
      $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    }else{
      $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 and codigo_vendedor='$_SESSION[id_vendedor]' order by nome limit 10";
    }
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      $i=1;
      echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' onkeyup=\"if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if (tecla == '38'){ getPrevNode('$i');}else if (tecla == '40'){ getProxNode('$i');}\" href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="clientecnpj"){
  if (strlen($_REQUEST[valor])>1){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT cgc, apelido, codigo, contato, nome,inscricao FROM clientes where cgc like '%$Valor1%' and (codigo_bloqueio=0 or codigo_bloqueio is null) and inativo=0 order by nome limit 10";
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = $l[nome];
        $CGC = str_replace($Valor1, "<b>$Valor1</b>", $l[cgc]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','cliente');Adiciona('$l[cgc]','$l[cgc]','clientecnpj');Adiciona('$l[inscricao]','$l[inscricao]','inscricao');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');\">$CGC - ".left($Nome, 60)."</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="codigo"){
  if (strlen($_REQUEST[valor])>1){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($CodigoEmpresa=="86"){ //Perfil
      $SqlCamposExtra = "preco_minimo, tem_divisao, ";
    }
    $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where codigo like '%$Valor1%' ";
    if ($CONF[UsaQtdCaixa]){
      $sql .= "and qtd_caixa > 0 ";
    }
    $sql .= "and inativo=0 order by codigo limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[codigo]','$_REQUEST[tipo]');Adiciona('$l[codigo]','$l[nome]','descricao');Adiciona('','$l[preco_venda]','valor_unitario');Adiciona('','$l[preco_venda]','valor_unitario1');Adiciona('','$l[preco_venda]','valor_unitario2');Adiciona('','$l[qtd_caixa]','qtd_caixa');Adiciona('','$l[preco_minimo]','preco_minimo');Adiciona('','$l[ipi]','ipi');CalculaValorUnitario('', '', '$l[preco_venda]','valor_unitario1','valor_unitario2');Adiciona('','$l[inativo]','inativo');Adiciona('','$l[preco_venda]','preco_venda');CalculaValorUnitarioDesconto();\">$l[codigo] - ".left($Nome, 60)."</a><BR>";
      }
    }
  }
}elseif ($_REQUEST[tipo]=="descricao"){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($CodigoEmpresa=="86"){ //Perfil
      $SqlCamposExtra = "preco_minimo, tem_divisao, ";
    }
    $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where nome like '%$Valor1%' ";
    if ($CONF[UsaQtdCaixa]){
      $sql .= "and qtd_caixa > 0 ";
    }
    $sql .= "and inativo=0 order by nome limit 10";
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    //echo $sql;
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[codigo]','$l[codigo]','codigo');Adiciona('','$l[preco_venda]','valor_unitario');Adiciona('','$l[preco_venda]','valor_unitario1');Adiciona('','$l[preco_venda]','valor_unitario2');Adiciona('','$l[qtd_caixa]','qtd_caixa');Adiciona('','$l[preco_minimo]','preco_minimo');Adiciona('','$l[ipi]','ipi');CalculaValorUnitario(document.ped.desconto1_cc.value, document.ped.desconto2_cc.value, '$l[preco_venda]','valor_unitario1','valor_unitario2');Adiciona('','$l[inativo]','inativo');Adiciona('','$l[preco_venda]','preco_venda');CalculaValorUnitarioDesconto();\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - $l[codigo]</a><BR>";
      }
    }
}elseif ($_REQUEST[tipo]=="descricao_pesquisa"){
    $Valor1 = strtoupper($_REQUEST[valor]);
    if ($CodigoEmpresa=="86"){ //Perfil
      $SqlCamposExtra = "preco_minimo, tem_divisao, ";
    }
    if ($_REQUEST[pesquisa]=="codigo"){
      $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where codigo like '%$Valor1%' ";
      if ($CONF[UsaQtdCaixa]){
        $sql .= "and qtd_caixa > 0 ";
      }
      $sql .= "and inativo=0 order by codigo limit 10";
    }else{
      $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where nome like '%$Valor1%' ";
      if ($CONF[UsaQtdCaixa]){
        $sql .= "and qtd_caixa > 0 ";
      }
      $sql .= "and inativo=0 order by nome limit 10";
    }
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    //echo $sql;
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[codigo]','$l[codigo]','codigo_pesquisa');Adiciona('','$l[preco_venda]','valor_unitario');Adiciona('','$l[preco_venda]','valor_unitario1');Adiciona('','$l[preco_venda]','valor_unitario2');Adiciona('','$l[qtd_caixa]','qtd_caixa');Adiciona('','$l[preco_minimo]','preco_minimo');Adiciona('','$l[ipi]','ipi');Adiciona('','$l[inativo]','inativo');Adiciona('','$l[preco_venda]','preco_venda');\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)." - $l[codigo]</a><BR>";
      }
    }
}elseif ($_REQUEST[tipo]=="desconto"){
  if (strlen($_REQUEST[valor])>0){
    $Valor1 = strtoupper($_REQUEST[valor]);
    $sql = "SELECT * FROM fatores where fator like '%$Valor1%' order by fator limit 10";
    //echo $sql;
    $Listar_Leitura = pg_query($sql);
    $ccc = pg_num_rows($Listar_Leitura);
    if ($ccc<>""){
      echo "<a id='elemento1' href='#' $OnFocus onclick=\"Adiciona('','','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');\">NENHUM</a><BR>";
      $i=1;
      while ($l = pg_fetch_array($Listar_Leitura)){
        $i++;
        $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[fator]);
        echo "<a id='elemento$i' href='#' $OnFocus onclick=\"Adiciona('$l[fator]','$l[fator]','".$_REQUEST[tipo]."".$_REQUEST[complemento]."');";
        if (!$_REQUEST[tela]){ //Se tiver complemento quer dizer que é um desconto por item e nao por pedido
          echo "CalculaValorUnitarioDesconto()";
        }else{
          echo "CalculaValorUnitario()";
        }
        echo "\"><img src='icones/icone_listar.gif' border='0'>&nbsp;".left($Nome, 60)."</a><BR>";
      }
    }
  }
}else{

}
?>
</div>
