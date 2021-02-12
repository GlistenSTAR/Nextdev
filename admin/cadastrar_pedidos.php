<?php
include "inc/verifica.php";
$_SESSION['pagina'] = "pedidos.php";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $SqlCarregaPedido = pg_query("Select * from pedidos_internet_novo where numero='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaPedido);
  if ($ccc<>""){
    $p = pg_fetch_array($SqlCarregaPedido);
    $SqlObservacao = pg_query("Select observacao from observacao_do_pedido where numero_pedido='".$_REQUEST['localizar_numero']."'");
    $o = pg_fetch_array($SqlObservacao);

    if ($p['codigo_pagamento']){
      $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$p['codigo_pagamento']."'");
      $c1 = pg_fetch_array($SqlCondicao);
    }
    if ($p['codigo_pagamento1']){
      $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$p['codigo_pagamento1']."'");
      $c2 = pg_fetch_array($SqlCondicao);
    }
  }else{
    $Loc = true;
  }
}
if ($p['enviado']=="1"){
  $Ativa = "display: block;";
  $DesativaForm = " onfocus=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onblur=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onclick=\"setTimeout('DisableEnableForm(document.ped,true);',0);\"";
  $_SESSION['enviado'] = 1;
  $SalvarRascunho = "";
}else{
  $Ativa = "display: none;";
  $DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.ped,false);',0);\"";
  $_SESSION['enviado'] = "";
  //$SalvarRascunho = "document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!'; acerta_campos('divAbaMeio','GrdProdutos','incluir_itens.php',false);";
  //$SalvarRascunho = "acerta_campos('divAbaMeio','Inicio','cadastrar_pedidos.php',true); document.ped.rascunho.value=1; document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!';";
}
if (!$_REQUEST['acao']){
  ?>
  <body <?php echo $DesativaForm;?>>
  <div id="CarregarPedido" style="position: absolute; top:40%; left:45%; background-color: #F7F7F7; border: 2px #cccccc; color: #FFFFFF; z-index:5000; <?php if ($Loc){echo "display: block;"; }else{ echo "display: none;";}?>">
    <table width="200" border="0" cellspacing="0" cellpadding="0" class="texto1 item">
      <tr>
        <td valign="top" align="center">
          <BR>
          Número
          <BR>
        </td>
        <td valign="top">
          <BR>
          <input type="text" name="valor" value="<?php echo $_REQUEST['localizar_numero'];?>" id="valor" size="15" onkeyup="if (!e) var e = window.event;if(e){tecla = event.keyCode;}else{tecla = event.which;}if(tecla==13){Acha('cadastrar_pedidos.php','localizar_numero='+document.getElementById('valor').value+'','Conteudo');}">
          <BR>
        </td>
      </tr>
      <?php
      if ($Loc){
        ?>
        <tr>
          <td colspan="2"><div class="erro">Pedido não encontrado</div></td>
        </tr>
        <?php
      }
      ?>
      <tr>
        <td valign="top" align="right">
          <BR>
          <input type="button" onclick="Acha('cadastrar_pedidos.php','localizar_numero='+document.getElementById('valor').value+'','Conteudo');" name="Carregar" value="Carregar">
          <BR><BR>
        </td>
        <td valign="top" align="center">
          <BR>
          <input type="button" name="Cancelar" value="Cancelar" onclick="document.getElementById('CarregarPedido').style.display='none';">
          <BR><BR>
        </td>
      </tr>
    </table>
  </div>
<table class="adminform" align="center" width="100%" height="350">
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/vendas.gif" border="0" align="left">
      <center><h3>Lançamento de Pedidos</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <table align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top">
        <div name="divAbaGeral" id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaTopo">
            <div style="cursor: pointer;" id="corpoAba1" name="corpoAba1" class="divAbaAtiva">
              <a onclick="trocarAba(1,3); <?php echo $SalvarRascunho;?>">Dados do cliente</a>
            </div>
            <div id="aba1" name="aba1"><div class="divAbaAtivaFim"></div></div>
            <div style="cursor: pointer;" id="corpoAba2" name="corpoAba2" class="divAbaInativa">
              <a onclick="trocarAba(2,3); <?php echo $SalvarRascunho;?>">Dados dos Produtos</a>
            </div>
            <div id="aba2" name="aba2"><div class="divAbaInativaFim"></div></div>
            <div style="cursor: pointer;" id="corpoAba3" name="corpoAba3" class="divAbaInativa">
              <a onclick="trocarAba(3,3); <?php echo $SalvarRascunho;?>">Observação</a>
            </div>
            <div id="aba3" name="aba3"><div class="divAbaInativaFim"></div></div>
          </div>
          <div id="disable" style="position: absolute; background: none; <?php echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" class="arialg" align="center">&nbsp;<div align="right">Pedido já enviado</div></div>
          <div id="divAbaMeio">
             <form action="index.php" name="ped" METHOD="POST" <?php echo $DesativaForm;?>>
             <input type="hidden" name="enviar_pedido" id="enviar_pedido" value="0">
             <input type="hidden" name="acao" value="Cadastrar" id="acao">
             <input type="hidden" name="rascunho" value="" id="rascunho">
             <input type="hidden" name="pg" value="cadastrar_pedidos" id="pg">
             <input type="hidden" name="localizar_numero" id="localizar_numero" size="15">
             <table height="300" width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1">
               <tr>
                 <td height="214" valign="top" background="images/l1_r2_c1.gif">
                   <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
                     <tr>
                       <td width="592" colspan="3" valign="top">
                           <span style="" name="corpo1" id="corpo1">
                              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td width="20%">Cliente:</td>
                                  <td width="80%">
                                    <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $p['id_cliente'];?>">
                                    <input type="text" size="60" name="cliente_cc" id="cliente_cc" value="<?php echo $p['cliente'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');">
                                    <BR>
                                    <div id="listar_cliente" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="20%">CNPJ/CPF:</td>
                                  <td width="80%">
                                    <input type="text" size="20" name="clientecnpj_cc" maxlength="18" id="clientecnpj_cc" value="<?php echo $p['cgc'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=clientecnpj&valor='+this.value+'','listar_clientecnpj');">
                                    <BR>
                                    <div id="listar_clientecnpj" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Insc. Est.:</td>
                                  <td><input name="inscricao_cc" id="inscricao_cc" type="text" size="20" maxlength="20" onclick="setTimeout('document.ped.inscricao_cc.disabled=true',0);"></td>
                                </tr>
                                <tr>
                                  <td>Contato:</td>
                                  <td><input name="contato_cc" id="contato_cc"  value="<?php echo $p['contato'];?>" type="text" size="60" maxlength="60"></td>
                                </tr>
                               <tr>
                                 <td>Transportadora:</td>
                                 <td>
                                   <input type="hidden" name="trans_id" id="trans_id" value="0">
                                   <input type="text" size="50" name="trans_cc" id="trans_cc" value="<?php echo $p['transportadora'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=trans&valor='+this.value+'','listar_trans');">
                                   &nbsp;&nbsp;&nbsp;&nbsp;
                                   <input type="radio" name="fob" id="fob" value="FOB" <?php if (($p['cif']==0) and ($_REQUEST['localizar_numero'])){ echo "Checked";}?>>FOB
                                   <input type="radio" name="fob" id="fob" value="CIF" <?php if (($p['cif']==1) or (!$_REQUEST['localizar_numero'])){ echo "Checked";}?>>CIF&nbsp;&nbsp;&nbsp;
                                   <BR>
                                   <div id="listar_trans" style="position:absolute;"></div>
                                 </td>
                               </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </tr>
                                <?php
                                function AdicionarDias($datahoje, $dias) {

                                  $anohoje = substr ( $datahoje, 0, 4 );
                                  $meshoje = substr ( $datahoje, 4, 2 );
                                  $diahoje =  substr ( $datahoje, 6, 2 );

                                  $prazo = mktime ( 0, 0, 0, $meshoje, $diahoje + $dias, $anohoje );

                                  return strftime("%Y%m%d", $prazo);
                                }
                                $datahoje = date("Ymd"); //ano4, mes2, dia2
                                //$datahoje = date("20060601"); //ano4, mes2, dia2

                                $prazo = AdicionarDias($datahoje,30);    // Adiciona 15 dias

                                $ano30 = substr ( $prazo, 0, 4 );
                                $mes30 = substr ( $prazo, 4, 2 );
                                $dia30 =  substr ( $prazo, 6, 2 );

                                $data_entrega30 = $dia30."/".$mes30."/".$ano30;
                                if ($p[data_prevista_entrega]){
                                  $da = $p[data_prevista_entrega];
                                  $d = explode("-", $da);
                                  $data_entrega30 = "".$d[2]."/".$d[1]."/".$d[0]."";
                                }
                                ?>
                                <tr>
                                  <td>Data Entrega:</td>
                                  <td><input name="data_entrega" id="data_entrega"  type="text" size="20" maxlength="20" value="<?php echo $data_entrega30;?>" onclick="MostraCalendario(document.ped.data_entrega,'dd/mm/yyyy',this)"></td>
                                </tr>
                                <?php
                                if ($p['numero']){
                                  $Numero = $p['numero'];
                                }else{
                                  $Numero = $_SESSION['id_vendedor'].date("dmy").date("His");
                                }
                                ?>
                                <tr>
                                  <td>Numero:</td>
                                  <td>
                                    <input name="numero" id="numero"  type="hidden" size="20" maxlength="20" value="<?php echo $Numero;?>" onclick="setTimeout('document.ped.numero.disabled=true',10);">
                                    <b><?php echo $Numero;?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span onmouseover="ddrivetip('<strong><u>Número do Pedido</u></strong><BR><BR>O número é composto sequencialmente por <i>CodigoVendedor + Dia + Mes + Ano + Hora + Minuto + Segundo</i>, <BR>ex: 85+05+11+2007+15+30+21')" onmouseout="hideddrivetip()" class="dwnx"><img src="icones/duvida.png" border="0" width="15" height="15"></span>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Num. Cliente:</td>
                                  <td><input name="numero_cliente" id="numero_cliente" value="<?php echo $p['numero_cliente'];?>" type="text" size="20" maxlength="20"></td>
                                </tr>
                                <tr>
                                  <td>Desconto:</td>
                                  <td><input name="desconto" id="desconto" value="<?php echo $p['desconto'];?>"  type="text" size="20" maxlength="10" onblur="CalculaValor();"></td>
                                </tr>
                                <!--
                                <tr>
                                  <td>Lista de preço:</td>
                                  <td><input name="lista_preco" id="lista_preco"  type="text" size="20" maxlength="10"></td>
                                </tr>
                                -->
                                <tr>
                                  <td width="20%">Cond. Pagam. 1:</td>
                                  <td width="80%">
                                    <input type="hidden" name="condpag1_id" id="condpag1_id" value="<?php echo $c1['codigo'];?>">
                                    <input type="text" size="50" name="condpag1_cc" id="condpag1_cc" value="<?php echo $c1['descricao'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=condpag&complemento=1&valor='+this.value+'','listar_condpag1');">
                                    <BR><div id="listar_condpag1" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="20%">Cond. Pagam. 2:</td>
                                  <td width="80%">
                                    <select name="condpag_cc" size="1" id="condpag_cc">
                                      <option></option>
                                      <?php
                                      include_once("inc/config.php");
                                      $SqlCarregaCondpag = pg_query("SELECT codigo, descricao FROM condicao_pagamento where codigo > 1 order by descricao ASC");
                                      while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                        echo "<option value='".$cp['codigo']."'>".$cp['descricao']."</option>";
                                      }
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                <!--
                                <tr>
                                  <td width="20%">Cond. Pagam. 2:</td>
                                  <td width="80%">
                                    <input type="hidden" name="condpag2_id" id="condpag2_id" value="<?php echo $c2['codigo'];?>">
                                    <input type="text" size="50" name="condpag2_cc" id="condpag2_cc" value="<?php echo $c2['descricao'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=condpag&complemento=2&valor='+this.value+'','listar_condpag2');">
                                    <BR><div id="listar_condpag2" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                -->
                                <tr>
                                  <td width="20%">Desc. 1:</td>
                                  <td width="80%">
                                    <input type="text" size="50" name="desconto1_cc" id="desconto1_cc" value="<?php echo $p['fator1'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=desconto&complemento=1&tela=principal&valor='+this.value+'','listar_desconto1');">
                                    <BR><div id="listar_desconto1" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="20%">Desc. 2:</td>
                                  <td width="80%">
                                    <select name="desconto2_cc" size="1" id="desconto2_cc">
                                      <option></option>
                                      <?php
                                      include_once("inc/config.php");
                                      $SqlCarregaCondpag = pg_query("SELECT * FROM fatores order by fator ASC");
                                      while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                        echo "<option value='".$cp['fator']."'>".$cp['fator']."</option>";
                                      }
                                      ?>
                                    </select>
                                  </td>
                                </tr>
                                <!--
                                <tr>
                                  <td width="20%">Desc. 2:</td>
                                  <td width="80%">
                                    <input type="text" size="50" name="desconto2_cc" id="desconto2_cc" value="<?php echo $p['fator2'];?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=desconto&complemento=2&tela=principal&valor='+this.value+'','listar_desconto2');">
                                    <BR><div id="listar_desconto2" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                -->
                              </table>
                           </span>
                           <span name="corpo2" id="corpo2" style="display: none;">
                             <table width="603" border="0" cellspacing="2" cellpadding="2" class="texto1">
                               <tr>
                                 <td>
                                   <span name="itens" id="itens">
                                     <table width="590" border="0" cellspacing="0" cellpadding="2" class="texto1">
                                       <input type="hidden" name="produto_venda_cc"        id="produto_venda_cc">
                                       <input type="hidden" name="inativo_cc"              id="inativo_cc">
                                       <input type="hidden" name="preco_minimo_cc"         id="preco_minimo_cc">
                                       <input type="hidden" name="qtd_caixa_cc"            id="qtd_caixa_cc">
                                       <input type="hidden" name="preco_venda_cc"          id="preco_venda_cc">
                                       <input type="hidden" name="alterado1"               id="alterado1">
                                       <input type="hidden" name="alterado2"               id="alterado2">
                                       <input type="hidden" name="opcao"                   id="opcao">
                                       <input name="numero_pedido" id="numero_pedido"  type="hidden" size="20" maxlength="10">
                                       <tr>
                                         <td width="70">Código:</td>
                                         <td>
                                           <input type="text" size="15" name="codigo_cc" id="codigo_cc" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){Acha('editar_itens.php', 'numero='+document.ped.numero.value+'&codigo='+document.ped.codigo_cc.value+'&EnterCodigo=true', 'itens');document.ped.qtd_cc.value='';setTimeout('document.ped.qtd_cc.focus()',50);}">
                                           <input type="button" name="Loc" id="Loc" value="Loc." onclick="Acha1('listar.php','tipo=codigo&valor='+document.ped.codigo_cc.value+'','listar_codigo');">
                                           <BR>
                                           <div id="listar_codigo" style="position:absolute;"></div>
                                         </td>
                                         <td>Qtd:</td>
                                         <td><input name="qtd_cc" id="qtd_cc"  type="text" size="8" maxlength="10" onfocus="this.select()" onblur="return calculavalor(this.value)"></td>
                                         <td valign="top" align="center">Ipi</td>
                                         <td valign="top" align="center">
                                           <input type="text" name="ipi_cc" id="ipi_cc" size="8">
                                         </td>
                                         <td valign="top" align="center">&nbsp;</td>
                                         <td valign="top" align="center">ex: 1000.50</td>
                                       </tr>
                                       <tr>
                                         <td>Desc 1:</td>
                                         <td>
                                           <input type="text" size="8" name="desconto11_cc" id="desconto11_cc" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=desconto&complemento=11&valor='+this.value+'','listar_desconto11');" onkeyup="if (!e) var e = window.event;if(e){tecla = event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.qtd1_cc.value='';setTimeout('document.ped.qtd1_cc.focus()',500);}">
                                           <BR>
                                           <div id="listar_desconto11" style="position:absolute;"></div>
                                         </td>
                                         <td>Qtd 1:</td>
                                         <td><input name="qtd1_cc" id="qtd1_cc"  type="text" size="8" maxlength="10" onclick="setTimeout('document.ped.qtd1_cc.disabled=true',0);"></td>
                                         <td>Valor 1:</td>
                                         <td><input name="valor_unitario1_cc" id="valor_unitario1_cc"  type="text" size="8" maxlength="20" onfocus="this.select()" onblur="CalculaValor();"></td>
                                         <td>Total 1:</td>
                                         <td><input name="valor_total1_cc" id="valor_total1_cc" type="text" size="8" maxlength="20" onfocus="this.select()" onblur="CalculaValor();"></td>
                                       </tr>
                                       <tr>
                                         <td>Desc 2:</td>
                                         <td>
                                           <input type="text" size="8" name="desconto22_cc" id="desconto22_cc" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=desconto&complemento=22&valor='+this.value+'','listar_desconto22');">
                                           <BR>
                                           <div id="listar_desconto22" style="position:absolute;"></div>
                                         </td>
                                         <td>Qtd 2:</td>
                                         <td><input name="qtd2_cc" id="qtd2_cc"  type="text" size="8" maxlength="10" onclick="setTimeout('document.ped.qtd2_cc.disabled=true',0);"></td>
                                         <td>Valor 2:</td>
                                         <td><input name="valor_unitario2_cc" id="valor_unitario2_cc"  type="text" size="8" maxlength="20" onfocus="this.select()" onblur="CalculaValor(true);"></td>
                                         <td>Total 2:</td>
                                         <td><input name="valor_total2_cc" id="valor_total2_cc"  type="text" size="8" maxlength="20" onfocus="this.select()" onblur="CalculaValor(true);"></td>
                                       </tr>
                                     </table>
                                     <table width="590" border="0" cellspacing="0" cellpadding="2" class="texto1">
                                       <tr>
                                         <td width="70" width="top">Descrição:</td>
                                         <td colspan="3" width="top">
                                           <input type="text" size="75" name="descricao_cc" id="descricao_cc" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=descricao&valor='+this.value+'','listar_descricao');">
                                           <BR>
                                           <div id="listar_descricao" style="position:absolute;"></div>
                                         </td>
                                         <td valign="top" colspan="4" align="center">
                                           <input type="button" onclick="calculavalor(); acerta_campos('divAbaMeio','GrdProdutos','incluir_itens.php',true); LimpaCamposItens();" name="Ok" value="Ok"><BR>
                                         </td>
                                       </tr>
                                     </table>
                                   </span>
                                 </td>
                               </tr>
                               <tr>
                                 <td>
                                   <table width="590" border="0" cellspacing="2" cellpadding="2" class="texto1">
                                     <tr>
                                       <td height="200" colspan="2" valign="top">
                                         <div class="TA1">
                                           <div id="GrdProdutos" class="TA">
                                             <?php
                                             if ($_REQUEST['localizar_numero']){
                                               $numero = $_REQUEST['localizar_numero'];
                                               include_once("../incluir_itens.php");
                                             }
                                             ?>
                                           </div>
                                         </div>
                                       </td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                             </table>
                           </span>
                           <span name="corpo3" id="corpo3" style="display: none;">
                              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td valign="top">Observação:</td>
                                  <td><textarea name="observacao" id="observacao"  maxlength="250" type="text" rows="5" cols="80"><?php echo $o['observacao'];?></textarea></td>
                                </tr>
                              </table>
                           </span>
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
               <tr>
                 <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR>*Dica - Use a tecla TAB para mudar de campo mais rapidamente.</td>
               </tr>
               <!--
               <tr>
                 <td align="center">
                   <input type="button" onclick="if (checa(document.ped.clientecnpj_cc.value, 'document.ped.clientecnpj_cc')){ document.ped.enviar_pedido.value=0; document.ped.rascunho.value=1; acerta_campos('divAbaMeio','Inicio','cadastrar_pedidos.php',true)}" style="width: 130px;" name="Somente Gravar" value="Somente Gravar">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="button" onclick="if (checa(document.ped.clientecnpj_cc.value, 'document.ped.clientecnpj_cc')){ document.ped.enviar_pedido.value=1; document.ped.rascunho.value=0; document.getElementById('salvo').innerHTML = ' '; acerta_campos('divAbaMeio','Inicio','cadastrar_pedidos.php',false)}" style="width: 130px;" name="Gravar e Enviar" value="Gravar e Enviar">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="button" onclick="Acha('pedidos.php','','Conteudo');" name="Cancelar" value="Cancelar">
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="button" onclick="document.getElementById('CarregarPedido').style.display='block';document.loc.valor.focus();" name="Localizar" value="Localizar">
                 </td>
               </tr>
               -->
             </table>
          </div>
          </form>
        </div>
      </td>
    </tr>
  </table>
  <?php
}else{
  ###################################
  # Variaveis vindas do form anterior
  ###################################
  ?>
  <div id="Erro" class="erro">
  <?php
  $cgc = $_REQUEST["clientecnpj_cc"];
  if (strlen($cgc)<"8"){
    echo "* Verifique o CNPJ / CPF<BR>";
    $_Err = true;
  }elseif (strlen($cgc)<"12"){ //CNPJ pode ter até 12 digitos
    $e_cgc = 0;
  }else{ //> 8 e > 12 tem que ser cpf
    $e_cgc = 1;
  }
  ##################################################
  #### Verifica valores ### Campos Obrigatórios ####
  ##################################################
  if ($_REQUEST["cliente_cc"] == "") {
    echo "* Verifique o Nome<BR>";
    $_Err = true;
  }
  if ($_REQUEST["desconto"]=="") {
    $desconto = 0;
  }else {
    $desconto = $_REQUEST["desconto"];
    if ($_REQUEST['condpag2_cc'] == "") {
      echo "<BR>* Aten&ccedil;&atilde;o, a condi&ccedil;&atilde;o de pagamento &eacute; obrigat&oacute;ria!";
      $_Err = true;
    }
  }
  if ($_SESSION['enviado']=="1"){
    $_Err = true;
  }
  if (!$_Err){
    ##########################################
    #   bloco de Includes
    ##########################################
    include("classes/base/classe_PedTmp.php");
    include("classes/base/classe_GraObs.php");
    include("inc/config.php");
    include("classes/base/classe_PedOfi.php");
    ##########################################
    #   Inicializo banco de dados com begin
    ##########################################
    //Uso @ para ocultar erros se cursor
    @pg_query ($db, "begin");
    ##########################################
    #   Validação de dados
    ##########################################
    //pega cliente
    $consulta = "select id,nome,apelido,cgc,e_cgc,codigo_vendedor from clientes where id = ".$_REQUEST['cliente_id'];
    $resultado = pg_query($db, $consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
    $row = pg_fetch_array($resultado);
    $cliente = $row[nome];
    $cgc = $row[cgc];
    $id_vendedor = $row[codigo_vendedor];
    ######################################################
    # Formatando data entrega
    ######################################################
    // $DataPrevistaEntrega = substr($_POST["data_entrega"],3,2)."/".substr($_POST["data_entrega"],0,2)."/".substr($_POST["data_entrega"],6,4);
    //Pedido da Pat para retirar PAC 6434
    $DataPrevistaEntrega = "";
    ######################################################
    $DataPrevistaEntrega = substr($_REQUEST["data_entrega"],3,2)."/".substr($_REQUEST["data_entrega"],0,2)."/".substr($_REQUEST["data_entrega"],6,4);
    ################################################################
    # Gravando dados do pedido parte1 admito, é uma meia classe :S
    ################################################################
    //instancia o objeto
    $PedidoTemp = new PedidoTemporario();
    // seta os atributos do objeto
    $PedidoTemp->set_clientecnpj($_REQUEST['clientecnpj_cc']);
    $PedidoTemp->set_cliente_cc($_REQUEST['cliente_cc']);
    $PedidoTemp->set_contato_cc($_REQUEST['contato_cc']);
    $PedidoTemp->set_DataPrevistaEntrega($DataPrevistaEntrega);
    $PedidoTemp->set_cliente_id($_REQUEST['cliente_id']);
    $PedidoTemp->set_trans_id($_REQUEST['trans_id']);
    $PedidoTemp->set_numero($_REQUEST['numero']);
    $PedidoTemp->set_numero_cliente($_REQUEST['numero_cliente']);
    $PedidoTemp->set_trans_cc($_REQUEST['trans_cc']);
    $PedidoTemp->set_condpag1_id($_REQUEST['condpag1_id']);
    $PedidoTemp->set_condpag2_id($_REQUEST['condpag2_id']);
    $PedidoTemp->set_desconto($desconto);
    $PedidoTemp->set_desconto11_cc($_REQUEST['desconto11_cc']);
    $PedidoTemp->set_desconto1_cc($_REQUEST['desconto1_cc']);
    $PedidoTemp->set_desconto22_cc($_REQUEST['desconto22_cc']);
    $PedidoTemp->set_desconto2_cc($_REQUEST['desconto2_cc']);
    $PedidoTemp->set_fob($_REQUEST['fob']);
    #########################################################################################
    #  Grava edição da Observação
    #########################################################################################
    //instancia o objeto
    $Obs = new Observacao();
    // seta os atributos do objeto
    $Obs->set_numero_internet($_REQUEST['numero']);
    $Obs->set_observacao($_REQUEST['observacao']);
    ######################################################
    # Confere se já existe o pedido, ai só edita
    ######################################################
    $SqlConferePedido = pg_query("Select numero from pedidos_internet_novo where numero = '".$_REQUEST['numero']."'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
    $ConferePedido = pg_num_rows($SqlConferePedido);
    if ($ConferePedido<>"") { //Verifica se é para editar ou adicionar.
      // seta os atributos restantes do objeto
      $PedidoTemp->set_operacao('edita');
      $Obs->set_operacao("edita");
    }else{
      // seta os atributos restantes do objeto
      $PedidoTemp->set_operacao(adiciona);
      $Obs->set_operacao("adiciona");
    }
    // executa o objeto
    $PedidoTemp->fazer();
    $Obs->fazer();
    if ($_REQUEST['enviar_pedido']){
      $SqlValidaItensPedido = pg_query("Select numero from itens_do_pedido_internet where numero='".$_REQUEST['numero']."'");
      $cci = pg_num_rows($SqlValidaItensPedido);
      if ($cci>0){
        ###########################################################################################
        #  Grava pedido oficial novo - Obrigatoriamente na execução dessa rotina marca enviado = 1
        ###########################################################################################
        //instancia o objeto
        $Pedido = new PedidoOficial();
        // seta os atributos do objeto
        $Pedido->set_numero_internet($_REQUEST['numero']);
        $Pedido->fazer();
        ?>
        <span class="titulo1 erro"><center>Pedido Gravado e enviado com sucesso</center></span>
        <?php
      }else{
        ?>
        <span class="titulo1 erro"><center>Esse pedido está sem ítens, é impossível enviar.</center></span>
        <?php
      }
    }
    //Uso @ para ocultar erros se cursor
    @pg_query ($db, "commit");
    @pg_close($db);
    if ($_REQUEST['rascunho']>0){
      ?>
      <BR><BR>
      <span class="titulo1"><center>Pedido Gravado com sucesso</center></span>
      <?php
    }
  }
  ?>
  </div>
  <?php
}
?>
