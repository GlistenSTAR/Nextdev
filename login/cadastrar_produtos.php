<?
include "inc/verifica.php";
$_SESSION[pagina] = "cadastrar_produtos.php";
$Ativa = "display: none;";
$DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.cad,false);',0);\"";
$Tirar = array(".","-","/",","," ");
$_REQUEST[localizar_numero] = str_replace($Tirar, "", $_REQUEST[localizar_numero]);
if (is_numeric($_REQUEST[localizar_numero])){
  include_once("inc/config.php");
  $SqlCarregaPedido = pg_query("Select * from produtos where codigo='$_REQUEST[localizar_numero]'");
  $pcc = pg_num_rows($SqlCarregaPedido);
  if ($pcc<>""){
    $p = pg_fetch_array($SqlCarregaPedido);
    if ($p[codigo]){
      if ($_SESSION['config']['cadastros']['VendedorCliente']){
        if ($p[codigo_vendedor]!=$_SESSION[id_vendedor]){
          $Ativa = "display: block;";
          $p = "";
          $Icones = "";
        }else{
          $Ativa = "display: none;";
        }
        $pgc = $p[codigo];
      }else{
        $Ativa = "display: none;";
      }
      $pgc = $p[codigo];
    }
  }else{
    $pgc = $_REQUEST[localizar_numero];
  }
}
if (!$_REQUEST[acao]){
  ?>
  <body <? echo $DesativaForm;?>>
    <table width="400" border="0" cellspacing="0" cellpadding="0" class="texto1" align="left">
      <tr>
        <td valign="top" width="400">
        <b>Cadastro de Produtos</b>
        <div id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaTopo" background="images/l1_r2_c1.gif">
            <div style="cursor: pointer;" id="clientes-corpoAba1" name="clientes-corpoAba1" class="divAbaAtiva">
              Dados gerais
            </div>
            <div id="clientes-aba1" name="clientes-aba1"><div class="divAbaAtivaFim"></div></div>
          </div>
          <div id="divAbaMeio">
             <table width="100%" height="200" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td height="214" valign="top" width="100%">
                   <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="100%" colspan="3" valign="top">
                         <form action="" name="cad" METHOD="POST" <? echo $DesativaForm;?>>
                           <?
                           if ($p[cgc]){
                             ?>
                             <input type="hidden" name="acao" value="Editar" id="acao">
                             <?
                           }else{
                             ?>
                             <input type="hidden" name="acao" value="Cadastrar" id="acao">
                             <?
                           }
                           ?>
                           <input type="hidden" name="pg" value="cadastrar_produtos" id="pg">
                           <span style="" name="clientes-corpo1" id="clientes-corpo1">
                              <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td width="100">Código</td>
                                  <td><? echo "$pgc";?></td>
                                </tr>
                                <div id="disable" style="position: absolute; background: none; <? echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" align="center">&nbsp;<div align="right">Esse cliente pertence a outro vendedor</div></div>
                                <tr>
                                  <td width="100">Descrição:</td>
                                  <td><? echo "$p[nome]";?></td>
                                </tr>
                                <tr>
                                  <td width="100">Unidade:</td>
                                  <td><? echo "$p[unidade]";?></td>
                                </tr>
                                <tr>
                                  <td width="100">Peso Bruto:</td>
                                  <td><? echo "$p[peso_bruto]";?></td>
                                </tr>
                                <tr>
                                  <td width="100">Peso Liquido:</td>
                                  <td><? echo "$p[peso_liquido]";?></td>
                                </tr>
                                <tr>
                                  <td width="100">IPI:</td>
                                  <td><? echo "$p[ipi]";?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </td>
                                <tr>
                                <b>Preço Venda  </b><img src="images/seta.gif">
                                </tr>
                                <tr>
                                  <td width="100">à vista:</td>
                                  <td><?=number_format($p[preco_venda], 2, ",", ".");?></td>
                                </tr>
                                <tr>
                                  <td width="100">Faturado:</td>
                                  <td><?=number_format($p[preco_venda_b], 2, ",", ".");?></td>
                                </tr>
                                <tr>
                                  <td width="100">Revenda:</td>
                                  <td><?=number_format($p[preco_venda_c], 2, ",", ".");?></td>
                                </tr>
                                <tr>
                                  <td width="100">Distribuição:</td>
                                  <td><?=number_format($p[preco_venda_d], 2, ",", ".");?></td>
                                </tr>
                                <tr>
                                  <td width="100">Manutenção:</td>
                                  <td><?=number_format($p[preco_venda_e], 2, ",", ".");?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </td>
                                <tr>
                                  <td width="100">Marca:</td>
                                  <td><? echo "$p[marca]";?></td>
                                </tr>
                                 <tr>
                                  <td width="100">Modelo:</td>
                                  <td><? echo "$p[modelo]";?></td>
                                </tr>
                                <tr>
                                  <td width="100">Descrição Tecnica:</td>
                                  <td><? echo "$p[descricao_tecnica]";?></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </td>
                              </table>
                           </span>
                         </form>
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
               <tr>
                 <td><img src="images/spacer.gif" width="1" height="5"></td>
               </tr>
               <tr>
                 <td align="center">
                   <?
                   if ($_SESSION[codigo_empresa]<>"95"){
                     if ($_REQUEST[cnpj_valido]==1){
                       ?>
                       <input type="button" onclick="if (checa(document.cad.cnpj.value,'document.cad.cnpj')){ acerta_campos('divAbaMeio','Inicio','cadastrar_produtos.php',true)}" name="Gravar" value="Gravar">
                       <?
                     }
                     ?>
                     <input type="button" onclick="Acha('inicio.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                     <?
                   }
                   ?>
                 </td>
               </tr>
               <tr>
                 <td><img src="images/spacer.gif" width="1" height="20"></td>
               </tr>
             </table>
          </div>
        </div>
      </td>
    </tr>
  </table>
  <?
}
?>
