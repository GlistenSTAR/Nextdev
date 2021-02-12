<?php
include ("inc/common.php");
include_once("../inc/config.php");
$CorFundo = "#EFEFEF";
?>
<table width="630" border="0" cellspacing="0" cellpadding="0" class="texto1" align="left" bgcolor="<?php echo "$CorFundo";?>">
  <tr>
    <td width="20" bgcolor="<?php echo "$CorFundo";?>">&nbsp;</td>
    <td valign="top" bgcolor="<?php echo "$CorFundo";?>">
      <table width="600" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center" bgcolor="<?php echo "$CorFundo";?>">
        <tr>
          <td valign="top" valign="top" class="texto1" bgcolor="<?php echo "$CorFundo";?>">
            <table width="600" border="1" align="center" cellspacing="0" cellpadding="0" class="texto1" background="images/l1_r2_c1.gif" bgcolor="<?php echo "$CorFundo";?>">
              <tr>
                <td colspan="6" align="center" bgcolor="<?php echo "$CorFundo";?>">
                  <div align="right" style="position: relative;"><a href="#" onclick="document.getElementById('UltimosItens').style.display='none';"><font color="#FF0000"><b>[ X ]</b></font></a></div>
                  <b>Selecione o código desejado para incluir no pedido</b>
                  <hr></hr>
                </td>
              </tr>
              <tr>
                <td width="60" align="center" bgcolor="#FFFFFF"><b>Código</b></td>
                <td width="70" align="right" bgcolor="#FFFFFF"><b>Núm. Ped.</b>&nbsp;&nbsp;</td>
                <td width="70" align="center" bgcolor="#FFFFFF"><b>Data</b>&nbsp;&nbsp;</td>
                <td width="300" align="center" bgcolor="#FFFFFF"><b>Nome</b></td>
                <td width="70" align="center" bgcolor="#FFFFFF"><b>Valor Unit.</b>&nbsp;&nbsp;</td>
                <td width="50" align="left" bgcolor="#FFFFFF"><b>Ipi</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6" valign="top" bgcolor="<?php echo "$CorFundo";?>">
                    <table width="600" border="0" align="center" cellspacing="0" cellpadding="2" class="texto1">
                      <tr>
                        <td bgcolor="<?php echo "$CorFundo";?>" valign="top">
                          <div style="padding: 0px;height:370px; overflow:auto;">
                            <table  border="0" style="border: 1px solid #CCCCCC;" align="center" cellspacing="0" cellpadding="2" class="texto1">
                              <tr height="1">
                                <td width="60">&nbsp;</td>
                                <td width="60">&nbsp;</td>
                                <td width="60">&nbsp;</td>
                                <td width="320">&nbsp;</td>
                                <td width="70" align="right">&nbsp;</td>
                                <td width="40" align="right">&nbsp;</td>
                              </tr>
                              <?php
                              $Data = date("m/d/Y", mktime(0,0,0, date("m"), date("d"), date("Y")-1)); //Ano- 1
                              if ($_REQUEST['CodProd']){
                                $FiltraCodigo = " and itens_do_pedido_vendas.codigo='".strtoupper($_REQUEST['CodProd'])."' ";
                                $ChecarCodigos = false;
                              }else{
                                $ChecarCodigos = true;
                              }
                              $Sql = "Select upper(codigo) as codigo,nome_do_produto, valor_unitario, ipi, max(numero_pedido) as numero_pedido
                              from itens_do_pedido_vendas
                              where numero_pedido in (
                                                      Select numero from pedidos
                                                      where id_cliente='$_REQUEST[IdCliente]' and data>'$Data' order by data desc
                                                      )
                              $FiltraCodigo
                              group by codigo,nome_do_produto, valor_unitario, ipi
                              ORDER BY numero_pedido desc";

                              $SqlCarregaCores = pg_query($Sql);
                              while ($i = pg_fetch_array($SqlCarregaCores)){
                                $Produto = pg_query("Select nome from produtos where codigo='$i[codigo]'");
                                $Produto = pg_fetch_array($Produto);
                                $Pedido = pg_query("Select numero, data from pedidos where numero='$i[numero_pedido]'");
                                $Pedido = pg_fetch_array($Pedido);
                                $DataPedido = explode("-", $Pedido[data]);
                                $DataPedido = $DataPedido[2]."/".$DataPedido[1]."/".$DataPedido[0];
                                if ($ChecarCodigos){
                                   if ($ultimo<>$i[codigo]){
                                     $Display = true;
                                   }else{
                                     $Display = false;
                                   }
                                }else{
                                  $Display = true;
                                }
                                if ($Display){
                                  if ($Cor=="#EEEEEE"){
                                    $Cor="#FFFFFF";
                                  }else{
                                    $Cor="#EEEEEE";
                                  }
                                  ?>
                                  <tr bgcolor="<?php echo "$Cor";?>" onMouseout="this.style.backgroundColor='<?php echo "$Cor";?>';" onmouseover="this.style.backgroundColor='lightgray';" onclick="Adiciona('<?php echo $i['codigo'];?>','<?php echo $i['codigo'];?>','codigo');Adiciona('<?php echo $i['codigo'];?>','<?php echo $Produto['nome'];?>','descricao');Adiciona('','<?php echo $i['valor_unitario'];?>','valor_unitario');Adiciona('','<?php echo $i['ipi'];?>','ipi');document.getElementById('UltimosItens').style.display='none';document.getElementById('qtd_cc').focus();" style="cursor: pointer;">
                                    <td align="left"><?php echo "&nbsp;$i[codigo]";?></td>
                                    <td align="left"><?php echo "&nbsp;$Pedido[numero]";?></td>
                                    <td align="left"><?php echo "&nbsp;$DataPedido";?></td>
                                    <td><?php echo "$Produto[nome]";?></td>
                                    <td align="right"><?php echo "R$ ".FormataCasas($i['valor_unitario'],2,false);?>&nbsp;</td>
                                    <td align="right"><?php echo FormataCasas($i['ipi'],0,false)." %";?>&nbsp;</td>
                                  </tr>
                                  <?php
                                }
                                $ultimo = $i['codigo'];
                              }
                              ?>
                            </table>
                          </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td bgcolor="<?php echo "$CorFundo";?>">&nbsp;</td>
  </tr>
</table>
