<?php
include_once ("inc/common.php");
include "inc/config.php";
?>
<style>
  .lista {
    font:normal 8pt Arial;
    text-align:left;
    border-left:15px solid #B7BECC;
    width:400px;
  }
</style>
<?php
if ($_REQUEST['tipo']=="trans"){
  if (strlen($_REQUEST['valor'])>2){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Nome_Transportadora = strtoupper($_REQUEST['valor']);
            $sql = "SELECT id, nome FROM transportadoras where nome like '%$Nome_Transportadora%' order by nome limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','trans');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Nome_Transportadora, "<b>$Nome_Transportadora</b>", $l['nome']);
                echo "<a href='#' onclick=\"Adiciona('$l[id]','$l[nome]','$_REQUEST[tipo]');\">".left($Nome, 60)."</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="condpag"){
  if (strlen($_REQUEST['valor'])>0){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT codigo, descricao FROM condicao_pagamento where descricao like '%$Valor1%' and  codigo > 1 order by descricao limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','".$_REQUEST['tipo']."".$_REQUEST['complemento']."');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['descricao']);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[descricao]','".$_REQUEST['tipo']."".$_REQUEST['complemento']."');\">".left($Nome, 60)."</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="regiao"){
  if (strlen($_REQUEST['valor'])>0){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT codigo, descricao FROM regiao where descricao like '%$Valor1%' order by descricao limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[valor]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['descricao']);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[descricao]','$_REQUEST[tipo]');\">$Nome</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="ramo"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT codigo, descricao FROM ramo_de_atividade where descricao like '%$Valor1%' order by descricao limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[descricao]);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[descricao]','$_REQUEST[tipo]');\">$Nome</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="banco"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT cod_banco_cobranca, nome FROM bancos_cobranca where nome like '%$Valor1%' order by nome limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['nome']);
                echo "<a href='#' onclick=\"Adiciona('$l[cod_banco_cobranca]','$l[nome]','$_REQUEST[tipo]');\">$Nome</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="cliente"){
  if (strlen($_REQUEST['valor'])>3){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' and codigo_vendedor='".$_SESSION['id_vendedor']."' order by nome limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['nome']);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[cgc]','$l[cgc]','$_REQUEST[tipo]cnpj');Adiciona('$l[inscricao]','$l[inscricao]');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');\">".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="clientecnpj"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT cgc, apelido, codigo, contato, nome,inscricao FROM clientes where cgc like '%$Valor1%' order by nome limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = $l[nome];
                $CGC = str_replace($Valor1, "<b>$Valor1</b>", $l[cgc]);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[nome]','cliente');Adiciona('$l[cgc]','$l[cgc]','clientecnpj');Adiciona('$l[inscricao]','$l[inscricao]','inscricao');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');\">$CGC - ".left($Nome, 60)."</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="codigo"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            if ($CodigoEmpresa=="86"){ //Perfil
              $SqlCamposExtra = "preco_minimo, tem_divisao, ";
            }
            $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where codigo like '%$Valor1%' and inativo=0 order by codigo limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[codigo]','$_REQUEST[tipo]');Adiciona('$l[codigo]','$l[nome]','descricao');Adiciona('','$l[preco_venda]','valor_unitario');Adiciona('','$l[preco_venda]','valor_unitario1');Adiciona('','$l[preco_venda]','valor_unitario2');Adiciona('','$l[qtd_caixa]','qtd_caixa');Adiciona('','$l[preco_minimo]','preco_minimo');Adiciona('','$l[ipi]','ipi');CalculaValorUnitario('', '', '$l[preco_venda]','valor_unitario1','valor_unitario2');Adiciona('','$l[inativo]','inativo');Adiciona('','$l[preco_venda]','preco_venda');CalculaValorUnitarioDesconto();\">$l[codigo] - ".left($Nome, 60)."</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="descricao"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            if ($CodigoEmpresa=="86"){ //Perfil
              $SqlCamposExtra = "preco_minimo, tem_divisao, ";
            }
            $sql = "SELECT codigo, nome, preco_venda, qtd_caixa, $SqlCamposExtra ipi, produto_venda, inativo FROM produtos where nome like '%$Valor1%' order by nome limit 10";
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l[nome]);
                if ($i<1){
                  echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
                }
                $i++;
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[codigo]','$l[codigo]','codigo');Adiciona('','$l[preco_venda]','valor_unitario');Adiciona('','$l[preco_venda]','valor_unitario1');Adiciona('','$l[preco_venda]','valor_unitario2');Adiciona('','$l[qtd_caixa]','qtd_caixa');Adiciona('','$l[preco_minimo]','preco_minimo');Adiciona('','$l[ipi]','ipi');CalculaValorUnitario(document.ped.desconto1_cc.value, document.ped.desconto2_cc.value, '$l[preco_venda]','valor_unitario1','valor_unitario2');Adiciona('','$l[inativo]','inativo');Adiciona('','$l[preco_venda]','preco_venda');CalculaValorUnitarioDesconto();\">".left($Nome, 60)." - $l[codigo]</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}elseif ($_REQUEST['tipo']=="desconto"){
  if (strlen($_REQUEST['valor'])>0){
    ?>
    <table width="50">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT * FROM fatores where fator like '%$Valor1%' order by fator limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','".$_REQUEST['tipo']."".$_REQUEST['complemento']."');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['fator']);
                echo "<a href='#' onclick=\"Adiciona('$l[fator]','$l[fator]','".$_REQUEST['tipo']."".$_REQUEST['complemento']."');";
                if (!$_REQUEST['tela']){ //Se tiver complemento quer dizer que é um desconto por item e nao por pedido
                  echo "CalculaValorUnitarioDesconto()";
                }else{
                  echo "CalculaValorUnitario()";
                }
                echo "\">".left($Nome, 60)."</a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}else{

}
?>
