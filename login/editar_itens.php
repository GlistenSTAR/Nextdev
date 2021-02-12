<?php
include ("inc/common.php");
include_once("inc/config.php");
if ($_SESSION['bloqueio_pedido']=="itens"){
  $_REQUEST['codigo'] = "";
  $_SESSION['bloqueio_pedido'] = "";
}
if ((!$_REQUEST['EnterCodigo']) and ($_REQUEST['codigo'])){
  $SqlCarregaItens = pg_query("Select * from itens_do_pedido_internet where numero_pedido = '".$_REQUEST['numero']."' and codigo='".strtoupper($_REQUEST['codigo'])."' order by codigo");
  $i = pg_fetch_array($SqlCarregaItens);
  $ValorUnitario1 = $i['valor_unitario'];
  $Qtd1 = $i['qtd'];
  $ValorTotal1 = $i['valor_total'];
  $Fator1 = $i['fator1'];
  $PrecoAlterado1 = $i['preco_alterado'];
  $Nome = $i['nome_do_produto'];
}elseif ($_REQUEST['codigo']){
  $SQL = "SELECT codigo, nome, preco_venda, qtd_caixa, ipi, produto_venda, inativo, peso_bruto, peso_liquido FROM produtos where codigo='".strtoupper($_REQUEST['codigo'])."' and (inativo=0 or inativo is null)";
  $SqlCarregaItens = pg_query($SQL);
  $i = pg_fetch_array($SqlCarregaItens);
  $ValorUnitario1 = $i['preco_venda'];
  $ValorUnitario2 = $i['preco_venda'];
  $Nome = $i['nome'];
  if (!$ValorUnitario1){
    $SqlEncontraValorUnitatio = pg_query("Select valor_unitario from itens_do_pedido_vendas where codigo='".strtoupper($_REQUEST['codigo'])."' order by id DESC");
    $ArrayValor = pg_fetch_array($SqlEncontraValorUnitatio);
    $ValorUnitario1 = $ArrayValor['valor_unitario'];
  }
  $SqlCarregaItem = pg_query("Select * from itens_do_pedido_internet where numero_pedido = '".$_REQUEST['numero']."' and codigo='".strtoupper($_REQUEST['codigo'])."' order by codigo");
  $cci = pg_num_rows($SqlCarregaItem);
  if ($cci>0){
    $ProdutoInexistente = "<span class=erro id=produtoinexistente>Atenção! esse ítem já existe no pedido se prosseguir os dados serão atualizados</span>";
    $Enter = true;
  }
}
if ($Fator1=="0"){ $Fator1 = "";}
$QtdItens = $Qtd1;
if ($i['numero_pedido']){
  $Numero = $i['numero_pedido'];
}else{
  $Numero = $_REQUEST['numero'];
}
if ((!$Nome) and ($_REQUEST['codigo'])){
  $ProdutoInexistente = "<span class=erro id=produtoinexistente>Produto Inexistente</span>";
}
//echo "<BR>Valor sem desconto: $ValorUnitario1<BR>";
if ($_REQUEST['desconto_pedido']>0){ //Calcula Desconto
  $ValorUnitario1 = $ValorUnitario1 * ($_REQUEST['desconto_pedido'] / 100);
}
//echo "<BR>Valor com desconto: $ValorUnitario1<BR>";
?>
    <fieldset id="titulo_frame">
      <legend>&nbsp;&nbsp;Dados dos produtos</legend>
      <table width="620" border="0" cellspacing="0" cellpadding="2" class="texto1" id="aba_produtos">
        <input type="hidden" name="produto_venda_cc"        id="produto_venda_cc" value="<?php echo $i['produto_venda'];?>">
        <input type="hidden" name="inativo_cc"              id="inativo_cc" value="<?php echo $i['inativo'];?>">
        <input type="hidden" name="preco_minimo_cc"         id="preco_minimo_cc" value="<?php echo $i['preco_minimo'];?>">
        <input type="hidden" name="qtd_caixa_cc"            id="qtd_caixa_cc" value="<?php echo $i['qtd_caixa'];?>">
        <input type="hidden" name="preco_venda_cc"          id="preco_venda_cc" value="<?php echo $i['preco_venda'];?>">
        <input type="hidden" name="alterado1"               id="alterado1" value="<?php echo $PrecoAlterado1;?>">
        <input type="hidden" name="opcao"                   id="opcao" value="editar">
        <input type="hidden" name="peso_bruto"              id="peso_bruto" value="<?php echo $i['peso_bruto'];?>">
        <input type="hidden" name="peso_liquido"            id="peso_liquido" value="<?php echo $i['peso_liquido'];?>">
        <input name="numero_pedido" id="numero_pedido"  type="hidden" size="20" maxlength="10" value="<?php echo $Numero;?>">
        <tr>
          <td width="10">Código:</td>
          <td>
            <input type="text" tabindex="10" size="8" name="codigo_cc" value="<?php echo strtoupper($_REQUEST['codigo']);?>" id="codigo_cc" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (this.value){Acha('editar_itens.php', 'numero='+document.ped.numero.value+'&codigo='+document.ped.codigo_cc.value+'&desconto_pedido='+document.ped.desconto.value+'&EnterCodigo=1', 'itens');document.ped.qtd_cc.value='';document.getElementById('errovalor1').innerHTML = '';document.getElementById('errovalor2').innerHTML = '';document.ped.qtd_cc.focus();}}">
            <BR>
            <div id="listar_codigo" style="position:absolute; z-index:7000;"></div>
          </td>
          <td align="right">Qtd:</td>
          <td><input type="number" step="1" minvalue="1" name="qtd_cc" tabindex="11" id="qtd_cc" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if (tecla == 13) {document.ped.ipi_cc.focus(); }" dir="rtl" value="<?php echo $QtdItens;?>"  type="text" size="6" maxlength="10" onfocus="this.select()" onblur="if (document.ped.codigo_cc.value){return calculavalor(this.value)}"></td>
          <td valign="top" align="right">Ipi</td>
          <td valign="top">
            <input type="text" name="ipi_cc" tabindex="12" dir="rtl" value="<?php echo $i['ipi'];?>" id="ipi_cc" size="6" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.valor_unitario_cc.focus();}">
          </td>
          <td align="right">Valor :</td>
          <td><input name="valor_unitario_cc" dir="rtl" id="valor_unitario_cc" value="<?php echo $ValorUnitario1;?>" type="text" size="8" maxlength="20" onfocus="this.select()" onblur="calculavalor();" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.getElementById('Ok').style.display='block';document.ped.Ok.focus();}"></td>
          <td align="right">Total :</td>
          <td>
          <input name="valor_total_cc" id="valor_total_cc" value="<?php echo $ValorTotal;?>" type="button" style="width: 90px; border: 1px solid #aba8a8; background-color:#FFFFFF; text-align: right;" size="8" maxlength="20" onfocus="this.select()" onblur="calculavalor();" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.getElementById('Ok').style.display='block';document.ped.Ok.focus();}">
          </td>
        </tr>
        <tr>
          <td width="70" width="top">Descrição:</td>
          <td colspan="8" width="top">
            <input type="text" size="65" name="descricao_cc" value="<?php echo $Nome;?>" id="descricao_cc" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=descricao&valor='+this.value+'','listar_descricao');">
            <?php
            if ($_SESSION['config']['vendas']['UltimosItensPedido']){
              ?>
              <a href="#" OnClick="document.getElementById('UltimosItens').style.display='block';Acha1('vendas/ultimos_itens_pedido.php','IdCliente='+document.getElementById('cliente_id').value+'<?php echo $ListaNumero;?>&CodProd='+document.getElementById('codigo_cc').value+'','UltimosItens');"><input type="button" name="ult_itens" id="ult_itens" value="Ult. Ítens"></a>
              <?php
            }
            ?>
            <BR>
            <div id="listar_descricao" style="position:absolute; z-index:7000;"></div>
          </td>
          <td valign="top" align="right">
            <div id="cpanel">
              <div style="float: left;">
               	<div class="icon">
                  <input type="button" name="Ok" value="Ok" border="0" id="Ok" style="width: 70px; height: 15px;" onclick="editaritens();">
               	</div>
              </div>
            </div>
          </td>
        </tr>
        <?php
        if ($ProdutoInexistente){
          ?>
          <tr>
            <td colspan="10"><?php echo $ProdutoInexistente;?></td>
          </tr>
          <?php
        }
        ?>
      </table>
    </fieldset>
    <?php
    if ($ProdutoInexistente){
      ?>
      <script>
        document.ped.codigo_cc.focus();
      </script>
      <?php
    }else{
      ?>
      <script>
        document.ped.qtd_cc.focus();
      </script>
      <?php
    }
    $ProdutoInexistente = "";
    ?>
