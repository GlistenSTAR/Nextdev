<?php
include_once ("inc/common.php");
include "inc/verifica.php";
$_SESSION['bloqueio_pedido']="";
$_SESSION['pagina'] = "inicio.php";
$PedidoLiberado = false;
//echo "numero internet: $_REQUEST[localizar_numero]";
$Tirar = array(".","-","/",","," ");
$_REQUEST['localizar_numero'] = str_replace($Tirar, "", $_REQUEST['localizar_numero']);
$_REQUEST['CgcCliente'] = str_replace($Tirar, "", $_REQUEST['CgcCliente']);
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $Sql = "Select * from pedidos_internet_novo where numero='".$_REQUEST['localizar_numero']."'";
//  echo $Sql;
  $SqlCarregaPedido = pg_query($Sql);
  $ccc = pg_num_rows($SqlCarregaPedido);
  if ($ccc<>""){
    $p = pg_fetch_array($SqlCarregaPedido);
    $SqlObservacao = pg_query("Select observacao from observacao_do_pedido where numero_pedido='".$_REQUEST['localizar_numero']."'");
    $o = pg_fetch_array($SqlObservacao);
    $PedidoLiberado = true;
    //Carrega dados do cliente
    $sql = "Select id, cgc, apelido, contato, codigo, nome, inscricao, codigo_vendedor, endereco, cidade, bairro, estado, cep, telefone, codigo_transportadora, observacao, codigo_pagto, bloqueio_cliente from clientes where cgc='".$p['cgc']."'";
//    echo $sql;
    $SqlProcuracliente = pg_query($sql);
    $ccc = pg_num_rows($SqlProcuracliente);
    if ($ccc<>""){
      $c = pg_fetch_array($SqlProcuracliente);
      $PedidoLiberado = true;
    }
  }else{
    $SqlCarregaPedido = pg_query("Select * from pedidos where numero='".$_REQUEST['localizar_numero']."'");
    $ccc = pg_num_rows($SqlCarregaPedido);
    if ($ccc<>""){
      $p = pg_fetch_array($SqlCarregaPedido);
      $SqlObservacao = pg_query("Select observacao from observacao_do_pedido where numero_pedido='".$_REQUEST['localizar_numero']."'");
      $o = pg_fetch_array($SqlObservacao);
      $PedidoLiberado = true;
      //Carrega dados do cliente
      $sql = "Select id, cgc, apelido, contato, codigo, nome, inscricao, codigo_vendedor, endereco, cidade, bairro, estado, cep, telefone, codigo_transportadora, observacao, codigo_pagto, bloqueio_cliente from clientes where cgc='".$p['cgc']."' and bloqueio_cliente='0'";
      $SqlProcuracliente = pg_query($sql);
      $ccc = pg_num_rows($SqlProcuracliente);
      if ($ccc<>""){
        $c = pg_fetch_array($SqlProcuracliente);
        $PedidoLiberado = true;
      }
      if ($p['venda_efetivada']){
        $Ativa = " display: block; ";
        $DesativaForm = " onfocus=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onblur=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onclick=\"setTimeout('DisableEnableForm(document.ped,true);',0);\"";
        $_SESSION['enviado'] = 1;
      }else{
        $Ativa = "display: none;";
        $DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.ped,false);',0);\"";
        $_SESSION['enviado'] = "";
        //$SalvarRascunho = "document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!'; acerta_campos('pedido','GrdProdutos','incluir_itens.php',false);";
      }
    }else{
      $SqlConfereEfetivacao = pg_query("Select venda_efetivada from pedidos where numero_internet='".$_REQUEST['localizar_numero']."'");
      $ConferePedidoEfetivado = pg_fetch_array($SqlConfereEfetivacao);
      //echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>venda efetiv. $ConferePedidoEfetivado[venda_efetivada]<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
      if ($ConferePedidoEfetivado['venda_efetivada']){
        $Ativa = " display: block; ";
        $DesativaForm = " onfocus=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onblur=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onclick=\"setTimeout('DisableEnableForm(document.ped,true);',0);\"";
        $_SESSION['enviado'] = 1;
      }else{
        $Ativa = "display: none;";
        $DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.ped,false);',0);\"";
        $_SESSION['enviado'] = "";
        //$SalvarRascunho = "document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!'; acerta_campos('pedido','GrdProdutos','incluir_itens.php',false);";
      }
      $Loc = true;
    }
  }
}elseif ($_REQUEST['CgcCliente']){
  include_once("inc/config.php");
  $sql = "Select id, cgc, apelido,obs_cobranca_pedido, mostrar_observacao,obs_dupl, contato, codigo, nome, inscricao, codigo_vendedor, endereco, cidade, bairro, estado, cep, telefone, codigo_transportadora, observacao, codigo_pagto, bloqueio_cliente from clientes where cgc='".$_REQUEST['CgcCliente']."'";
  //echo $sql;
  $SqlProcuracliente = pg_query($sql);
  $ccc = pg_num_rows($SqlProcuracliente);
  if ($ccc<>""){
    $c = pg_fetch_array($SqlProcuracliente);
    if ($c[cgc]){
      //echo "Valida: ".$_SESSION[config][ConfereVendedorCliente]."<BR><BR>";
      if ($_SESSION['config']['vendas']['VendedorCliente']){
        if ($c['codigo_vendedor']!=$_SESSION['id_vendedor']){
          $PedidoLiberado = false;
          $p = "";
          $Icones = "Esse cliente pertence a outro vendedor";
          $p['cgc'] = $_REQUEST['CgcCliente'];
        }else{
          $PedidoLiberado = true;
        }
      }else{
          $PedidoLiberado = true;
      }
    }else{
        $PedidoLiberado = false;
        $p = "";
        $Icones = "Cliente não cadastrado";
        $p[cgc] = $_REQUEST['CgcCliente'];
    }
  }else{
    $PedidoLiberado = false;
    $p = "";
    $Icones = "Cliente não cadastrado";
    $p[cgc] = $_REQUEST['CgcCliente'];
  }
  if ($_REQUEST['numero_pedido']){
    $p['numero'] = $_REQUEST['numero_pedido'];
  }
  if (intval($c['mostrar_observacao'])=="1"){
    $o['observacao'] = "".$c['mostrar_observacao'].$c['observacao']."";
  }
  if (intval($c['obs_cobranca_pedido'])=="1"){
    $o['observacao'] = $o['observacao']."-".$c['obs_dupl'];
  }
}else{
  $PedidoLiberado = false;
}
if ($c['bloqueio_cliente']=="1"){
  $PedidoLiberado = false;
  $p = "";
  $Icones = "Cliente bloqueado.";
  $p[cgc] = $_REQUEST['CgcCliente'];
}
if ($PedidoLiberado){
  $p['cgc'] = $c['cgc'];
  $p['id_cliente'] = $c['id'];
  $p['cliente'] = $c['nome'];
  if (!$p['contato']){
    $p['contato'] = $c['contato'];
  }
  $p['inscricao'] = $c['inscricao'];
  if (!$p['codigo_pagamento']){
    $p['codigo_pagamento'] = $c['codigo_pagto'];
  }
  if (!$p['transportadora']){
    $SqlTransp = pg_query("Select nome from transportadoras where id='".$c['codigo_transportadora']."'");
    $trans = pg_fetch_array($SqlTransp);
    $p['transportadora'] = $trans['nome'];
  }
  $Icones = "<img src='icones/gravado.png' title='CPF / CNPJ Válido'>";
  if ($p['codigo_pagamento']){
    $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$p['codigo_pagamento']."'");
    $c1 = pg_fetch_array($SqlCondicao);
  }
  if ($p[transportadora]){
    $SqlTransportadora = pg_query("Select id, nome from transportadoras where nome='".$p['transportadora']."'");
    $t = pg_fetch_array($SqlTransportadora);
  }
  if (!$Ativa){
    $Ativa = "display: none;";
    $DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.ped,false);',0);\"";
    $_SESSION['enviado'] = "";
    //$SalvarRascunho = "document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!'; acerta_campos('pedido','GrdProdutos','incluir_itens.php',false);";
  }
}
if (!$_REQUEST['acao']){
  ?>
  <body <?php echo $DesativaForm;?>>
  <div id="CarregarPedido" style="position: absolute; top:40%; left:45%; background-color: #CCCCCC; border: 2px #cccccc; color: #FFFFFF; z-index:5000; <?php if ($Loc){echo "display: block;"; }else{ echo "display: none;";}?>">
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
          <input type="button" onclick="Acha('cadastrar_pedidos.php','localizar_numero='+document.getElementById('valor').value+'','Conteudo');" name="Carregar" id="Carregar" value="Carregar">
          <BR><BR>
        </td>
        <td valign="top" align="center">
          <BR>
          <input type="button" name="Cancelar" id="Cancelar" value="Cancelar" onclick="document.getElementById('CarregarPedido').style.display='none';">
          <BR><BR>
        </td>
      </tr>
    </table>
  </div>
  <div id="pedido">
    <form action="cadastrar_pedidos.php" name="ped" METHOD="POST" <?php echo $DesativaForm;?>>
      <?php
      if ($PedidoLiberado){
        $ListaNumero = "&numero_pedido='+document.ped.numero.value+'";
        ?>
        <input type="hidden" name="enviar_pedido" id="enviar_pedido" value="0">
        <input type="hidden" name="acao" value="Cadastrar" id="acao">
        <input type="hidden" name="rascunho" value="" id="rascunho">
        <input type="hidden" name="pg" value="cadastrar_pedidos" id="pg">
        <input type="hidden" name="localizar_numero" id="localizar_numero" size="15">
        <?php
      }
      ?>
      <table width="400" border="0" cellspacing="0" cellpadding="0" class="texto1" align="left">
        <tr>
          <td valign="top" width="400">
            <span id="errovalor1" align="center" style="position: absolute; background: none; width: 605; color: red; z-index: 13000; text-align: right;"></span>
            <span id="errovalor2" align="center" style="position: absolute; background: none; width: 605; color: red; z-index: 13000; text-align: right;"></span>
            <b>Lançamento de Pedidos</b>
            <?php
            if ($_SESSION['config']['vendas']['UltimosItensPedido']){
              ?>
              <div id="UltimosItens" style="position: absolute; width: 503px; height:300px; background-color: #none; border: 2px #000000; color: #000000; z-index: 1; display: none;">
              </div>
              <?php
            }
            if ($PedidoLiberado){
              ?>
              <div id="cores" style="position: absolute;  width: 603px; height:400px; background-color: #FFFFFF; border: 2px #000000; color: #000000; z-index: 1; display: none;">
                <?php
                include "cores.php";
                ?>
              </div>
              <div name="divAbaGeral" id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
                <div id="divAbaTopo">
                  <div style="cursor: pointer;" id="pedidos-corpoAba1" name="pedidos-corpoAba1" class="divAbaAtiva">
                    <a onclick="trocarAba('pedidos-',1,3); <?php echo $SalvarRascunho;?>">Dados do cliente</a>
                  </div>
                  <div id="pedidos-aba1" name="pedidos-aba1"><div class="divAbaAtivaFim"></div></div>
                  <div style="cursor: pointer;" id="pedidos-corpoAba2" name="pedidos-corpoAba2" class="divAbaInativa">
                    <a onclick="trocarAba('pedidos-',2,3); <?php echo $SalvarRascunho;?>">Dados dos Produtos</a>
                  </div>
                  <div id="pedidos-aba2" name="pedidos-aba2"><div class="divAbaInativaFim"></div></div>
                  <div style="cursor: pointer;" id="pedidos-corpoAba3" name="pedidos-corpoAba3" class="divAbaInativa">
                    <a onclick="trocarAba('pedidos-',3,3); <?php echo $SalvarRascunho;?>">Observação</a>
                  </div>
                  <div id="pedidos-aba3" name="pedidos-aba3"><div class="divAbaInativaFim"></div></div>
                </div>
                <div id="disable" style="position: absolute; background: none; <?php echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" class="arialg" align="center">&nbsp;<div align="right">Pedido já efetivado - não é possível editar</div></div>
              <?php
            }
            ?>
              <div id="divAbaMeio">
                 <table width="400" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
                   <tr>
                     <td height="214" width="100%" valign="top" valign="top">
                       <table width="100%" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
                         <tr>
                           <td width="100%" colspan="3" valign="top">
                             <span style="" name="pedidos-corpo1" id="pedidos-corpo1">
                                <table width="100%" border="0" cellspacing="1" cellpadding="1" class="texto1" align="center">
                                  <tr>
                                    <td width="20%">CNPJ/CPF:</td>
                                    <td width="80%">
                                      <input type="text" size="20" name="clientecnpj_cc" maxlength="18" id="clientecnpj_cc" value="<?php echo $p['cgc'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+this.value+'<?php echo $ListaNumero;?>','Conteudo');}">
                                      <?php echo $Icones;?>
                                      <BR>
                                      <div id="listar_clientecnpj" style="position:absolute; z-index: 7000;"></div>
                                    </td>
                                  </tr>
                                  <?php
                                  if (!$PedidoLiberado){
                                    ?>
                                    <tr>
                                      <td width="20%">Cliente:</td>
                                      <td width="80%">
                                        <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $p['id_cliente'];?>">
                                        <input type="text" size="60" name="cliente_cc" id="cliente_cc" value="<?php echo $p['cliente'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');}else{if (this.value.length>3){Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');}}">
                                        <BR>
                                        <div id="listar_cliente" style="position:absolute; z-index: 7000;"></div>
                                      </td>
                                    </tr>
                                    <?php
                                  }else{
                                  ?>
                                  <tr>
                                    <td width="20%">Cliente:</td>
                                    <td width="80%">
                                      <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $p['id_cliente'];?>">
                                      <input type="hidden" name="cliente_cc" id="cliente_cc" value="<?php echo $p['cliente'];?>">
                                      <b><?php echo $p['cliente'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Endereço:</td>
                                    <td>
                                      <b> <?php echo $c['endereco'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Cidade:</td>
                                    <td>
                                      <b> <?php echo $c['cidade'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Bairro:</td>
                                    <td>
                                      <b> <?php echo $c['bairro'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Estado:</td>
                                    <td>
                                      <b> <?php echo $c['estado'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>CEP:</td>
                                    <td>
                                      <b> <?php echo $c['cep'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Telefone:</td>
                                    <td>
                                      <b> <?php echo $c['telefone'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Insc. Est.:</td>
                                    <td>
                                      <b> <?php echo $c['inscricao'];?></b>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Contato:</td>
                                    <td>
                                      <input name="contato_cc" id="contato_cc" value="<?php echo $p['contato'];?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.trans_cc.focus();}">
                                      <!--<b><?php echo $p['contato'];?></b>-->
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="2"><img src="images/linha_menu.gif" width="100%" height="1"></td>
                                  </tr>
                                  <tr>
                                    <td>Transportadora:</td>
                                    <td>
                                      <input type="hidden" name="trans_id" id="trans_id" value="<?php echo $c['codigo_transportadora'];?>">
                                      <input type="text" size="35" name="trans_cc" id="trans_cc" value="<?php echo $p['transportadora'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.data_entrega.focus();}else{Acha1('listar.php','tipo=trans&valor='+this.value+'','listar_trans');}">
                                      &nbsp;&nbsp;
                                      <input type="radio" name="frete" id="frete" value="FOB" <?php if (($p['cif']==0) and ($_REQUEST['localizar_numero'])){ echo "Checked";}?>>FOB
                                      <input type="radio" name="frete" id="frete" value="CIF" <?php if (($p['cif']==1) or (!$_REQUEST['localizar_numero'])){ echo "Checked";}?>>CIF&nbsp;&nbsp;&nbsp;
                                      <BR>
                                      <div id="listar_trans" style="position:absolute;"></div>
                                    </td>
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
                                    <td><input name="data_entrega" id="data_entrega"  type="text" size="20" maxlength="20" value="<?php echo $data_entrega30;?>" onclick="MostraCalendario(document.ped.data_entrega,'dd/mm/yyyy',this)" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (document.getElementById('yearDropDown')){closeCalendar();}document.ped.numero_cliente.focus();}"></td>
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
                                      <span onmouseover="ddrivetip('<strong><u>Número do Pedido</u></strong><BR><BR>O número é composto sequencialmente por <i>CodigoVendedor + Dia + Mes + Ano + Hora + Minuto + Segundo</i>, <BR>ex: 85+11+01+08+15+30+21')" onmouseout="hideddrivetip()" class="dwnx"><img src="icones/duvida.png" border="0" width="15" height="15"></span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Num. Cliente:</td>
                                    <td><input name="numero_cliente" id="numero_cliente" value="<?php echo $p['numero_cliente'];?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.desconto.focus();}"></td>
                                  </tr>
                                  <tr>
                                    <td>Desconto:</td>
                                    <td><b><div id="boxdesconto"></div></b><input name="desconto" id="desconto" value="<?php echo $p['desconto'];?>"  type="text" size="8" maxlength="3" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (this.value>100){ alert('O desconto deve ser menor que 100'); this.value='0';}else{document.ped.condpag1_id.focus();}}"></td>
                                  </tr>
                                  <tr>
                                    <td width="20%">Cond. Pagam.:</td>
                                    <td width="80%">
                                      <select name="condpag1_id" size="1" id="condpag1_id" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba('pedidos-',2,3); <?php echo $SalvarRascunho;?> document.ped.codigo_cc.focus();}">
                                        <?php
                                        if ($c1['codigo']){
                                          echo "<option value='".$c1['codigo']."'>".$c1['descricao']."</option>";
                                          echo "<option></option>";
                                          $RetiraCP = " and codigo<>'".$c1['codigo']."' ";
                                        }else{
                                          echo "<option></option>";
                                        }
                                        include_once("inc/config.php");
                                        $SqlCarregaCondpag = pg_query("SELECT codigo, descricao FROM condicao_pagamento where codigo > 1 $RetiraCP order by descricao ASC");
                                        while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                          echo "<option value='".$cp['codigo']."'>".$cp['descricao']."</option>";
                                        }
                                        ?>
                                      </select>
                                    </td>
                                  </tr>
                                  <?php
                                  }
                                  if (($_SESSION['nivel_site']=="2") and ($PedidoLiberado)){
                                    ?>
                                    <tr>
                                      <td>Vendedor:</td>
                                      <td>
                                        <select name="vendedor2_id" size="1" id="vendedor2_id">
                                          <?php
                                          include_once("inc/config.php");
                                          if ($p['codigo_vendedor']){
                                            echo "<option value='".$p['codigo_vendedor']."'>".$p['vendedor']."</option>";
                                            echo "<option></option>";
                                            $RetiraVendedor = " and codigo<>'".$p['codigo_vendedor']."' ";
                                          }elseif ($c['codigo_vendedor']){
                                            $SqlCarregaVend = pg_query("SELECT codigo, nome FROM vendedores where codigo='".$c['codigo_vendedor']."'");
                                            $cv = pg_fetch_array($SqlCarregaVend);
                                            echo "<option value='".$c['codigo_vendedor']."'>".$cv['nome']."</option>";
                                            echo "<option></option>";
                                            $RetiraVendedor = " and codigo<>'".$c['codigo_vendedor']."' ";
                                          }else{
                                            echo "<option value='".$_SESSION['id_vendedor']."'>".$_SESSION['usuario']."</option>";
                                            $RetiraVendedor = " and codigo<>'".$_SESSION['id_vendedor']."' ";
                                          }
                                          $SqlCarregaCondpag = pg_query("SELECT codigo, nome FROM vendedores where nome<>'SUPORTE' $RetiraVendedor order by nome ASC");
                                          while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                            echo "<option value='".$cp['codigo']."'>".$cp['nome']."</option>";
                                          }
                                          ?>
                                        </select>
                                        </div>
                                      </td>
                                    </tr>
                                    <?php
                                  }else{
                                    ?>
                                    <input type="hidden" name="vendedor2_id" id="vendedor2_id" value="<?php echo $_SESSION['id_vendedor']?>">
                                    <?php
                                  }
                                  ?>
                                </table>
                             </span>
                             <span name="pedidos-corpo2" id="pedidos-corpo2" style="display: none;">
                               <?php
                               if ($PedidoLiberado){
                                 ?>
                               <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1">
                                 <tr>
                                   <td>
                                     <span name="itens" id="itens">
                                       <?php include "editar_itens.php"; ?>
                                     </span>
                                   </td>
                                 </tr>
                                 <tr>
                                   <td valign="top">
                                     <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1">
                                       <tr>
                                         <td height="200" colspan="2" valign="top">
                                           <div class="TA1" id="GrdProdutos">
                                               <?php
                                               if ($_REQUEST['localizar_numero']){
                                                 $numero = $_REQUEST['localizar_numero'];
                                                 include_once("incluir_itens.php");
                                               }
                                               ?>
                                           </div>
                                         </td>
                                       </tr>
                                     </table>
                                   </td>
                                 </tr>
                               </table>
                               <?php
                               }
                               ?>
                             </span>
                             <span name="pedidos-corpo3" id="pedidos-corpo3" style="display: none;">
                               <?php
                               if ($PedidoLiberado){
                                 ?>
                                 <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                   <tr>
                                     <td valign="top">Observação:</td>
                                     <td><textarea name="observacao" id="observacao"  maxlength="250" type="text" rows="5" cols="70"><?php echo $o['observacao'];?></textarea></td>
                                   </tr>
                                 </table>
                                 <?php
                               }
                               ?>
                             </span>
                           </td>
                         </tr>
                       </table>
                     </td>
                   </tr>
                   <tr>
                     <td align="center">
                       <div id="botoes">
                         <BR>
                         <?php
                         if ($PedidoLiberado){
                           if ($SalvarRascunho){
                             ?>
                             <input type="button" onclick="document.ped.enviar_pedido.value=0; document.ped.rascunho.value=1; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true); <?php echo $SalvarRascunho;?>" style="width: 130px;" name="Somente Gravar" id="Somente Gravar" value="Somente Gravar">
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <?php
                           }
                           if ((!$_SESSION['enviado']) and (!$p['venda_efetivada'])){
                             ?>
                             <input type="button" onclick="document.ped.enviar_pedido.value=1; document.ped.rascunho.value=0; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',false);" style="width: 130px;" name="Gravar e Enviar" id="Gravar e Enviar" value="Gravar e Enviar">
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <?php
                           }
                         }else{
                           ?>
                           <input type="button" onclick=" Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');" style="width: 130px;" name="iniciarpedido" id="iniciarpedido" value="Iniciar Pedido">
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <?php
                         }
                         ?>
                         <input type="button" onclick="Acha('inicio.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         <!--
                         <input type="button" onclick="document.getElementById('CarregarPedido').style.display='block';document.loc.valor.focus();" name="Localizar" id="Localizar" value="Localizar">
                         -->
                       </div>
                     </td>
                   </tr>
                 </table>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <BR>
  <span class="titulo1" id="salvo"></span>
  <?php
}else{
  ###################################
  # Variaveis vindas do form anterior
  ###################################
  ?>
  <div id="Erro" class="erro" style="position: absolute;" height="100%">
    <center>
    <?php
    $cgc = $_REQUEST["clientecnpj_cc"];
    if (strlen($cgc)<"8"){
      ?>
      <BR>* Verifique o CNPJ / CPF
      <?php
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
      ?>
      <BR>* Verifique o Nome do cliente
      <?php
      $_Err = true;
    }
    if (($_REQUEST['frete']) and (!$_REQUEST['trans_cc'])){
      ?>
      <!--<BR>* Para FOB a transportadora é obrigatória-->
      <?php
      //$_Err = true;
    }
    if ($_REQUEST['frete']){
      $Frete = "1";
    }else{
      $Frete = "0";
    }
    if ($_REQUEST["desconto"]=="") {
      $desconto = 0;
    }else {
      $desconto = $_REQUEST["desconto"];
    }
    if ($_REQUEST["condpag1_id"] == "") {
      ?>
      <BR>* Verifique a Condição de Pagamento
      <?php
      $_Err = true;
    }
    if ($_SESSION['enviado']=="1"){
      $_Err = true;
    }
    if (!$_Err){
      ##########################################
      #   bloco de Includes
      ##########################################
      include("inc/config.php");
      include("classes/base/classe_PedTmp.php");
      include("classes/base/classe_GraObs.php");
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
      //$id_vendedor = $row[codigo_vendedor];
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
      $PedidoTemp->set_vendedor2_id($_REQUEST['vendedor2_id']);
      $PedidoTemp->set_numero_cliente($_REQUEST['numero_cliente']);
      $PedidoTemp->set_trans_cc($_REQUEST['trans_cc']);
      $PedidoTemp->set_condpag1_id($_REQUEST['condpag1_id']);
      $PedidoTemp->set_condpag2_id($_REQUEST['condpag2_id']);
      $PedidoTemp->set_desconto($desconto);
      $PedidoTemp->set_desconto11_cc($_REQUEST['desconto11_cc']);
      $PedidoTemp->set_desconto1_cc($_REQUEST['desconto1_cc']);
      $PedidoTemp->set_desconto22_cc($_REQUEST['desconto22_cc']);
      $PedidoTemp->set_desconto2_cc($_REQUEST['desconto2_cc']);
      $PedidoTemp->set_fob($Frete);
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
      $SqlConferePedido = pg_query("Select numero from pedidos_internet_novo where numero = '".$_REQUEST['numero']."'") or die ($MensagemDbError.$SqlConferePedido.pg_query ($db, "rollback"));
      $ConferePedido = pg_num_rows($SqlConferePedido);
      if ($ConferePedido<>"") { //Verifica se é para editar ou adicionar.
        // seta os atributos restantes do objeto
        $PedidoTemp->set_operacao('edita');
        $Obs->set_operacao("adiciona");
      }else{
        // seta os atributos restantes do objeto
        $PedidoTemp->set_operacao('adiciona');
        $Obs->set_operacao("adiciona");
      }
      // executa o objeto
//      echo "Vend: $_SESSION[id_vendedor]";
//      exit;
      $PedidoTemp->fazer();
      $Obs->fazer();
      #########################################################################################
      #  Testa o início da divisão de pedidos
      #########################################################################################
        $SqlContaItens = pg_query("Select count(codigo) as quantos from itens_do_pedido_internet where numero_pedido='".$_REQUEST['numero']."'");
        $ItensPedido = pg_fetch_array($SqlContaItens);
        $NumeroItensPedido = $ItensPedido['quantos'];
        ####### PEGA O NUMERO MAXIMO DE ITENS E O FATURAMENTO MINIMO
        $SqlReferencias = pg_query("Select numero_maximo_itens, fatmin from referencias") or die ("Erro 1");
        $ArrayReferencias = pg_fetch_array($SqlReferencias);
        $NumeroMaximoItens = $ArrayReferencias['numero_maximo_itens'];
        $FatMin = $ArrayReferencias['fat_min'];
        if ($NumeroItensPedido>$NumeroMaximoItens){
          echo "Dividindo Pedidos<BR><BR>";
          $numero = $_REQUEST['numero'];
          #### Arredonda baseado no resto, sempre pra cima.
          $Valor = $NumeroItensPedido / $NumeroMaximoItens;
          $CasasDepoisVirgula = 0;
          $Valor1 = pow (10, -($CasasDepoisVirgula + 1)) * 5;
          $QtdPedidosParaGerar = round ($Valor + $Valor1, $CasasDepoisVirgula);
          ####
          //echo "Itens $NumeroItensPedido - Maximo: $NumeroMaximoItens - Quantos pedidos preciso: $QtdPedidosParaGerar<BR><BR><hr><BR><BR>";
          $Numeros = array();
          $SqlItensTemp = pg_query("Select codigo from itens_do_pedido_internet where numero_pedido='".$numero."' order by valor_total") or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$ultimopedido.pg_query ($db, "rollback"));
          $CodigoProduto  = array();
          while($ArrayItemTemp = pg_fetch_array($SqlItensTemp)){
            foreach ($ArrayItemTemp as $Chave => $Produto) {
              if ($Chave=="0"){
                $CodigoProduto[] = $Produto;
              }
            }
          }
          for ($i=1; $i<=$QtdPedidosParaGerar;$i++){
            $SqlPedidoTemp = pg_query("insert into pedidos_internet_novo select * from pedidos_internet_novo where numero = '".$numero."'") or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$SqlPedidoTemp.pg_query ($db, "rollback"));
            $Sql = "update pedidos_internet_novo set numero = '".$numero.$i."'
                      where numero = '".$numero."'
                      and (Select max(oid) as max_oid from pedidos_internet_novo where numero = '".$numero."') > oid
                   ";
            $SqlUpdateTemp = pg_query($Sql) or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$SqlPedidoTemp.pg_query ($db, "rollback"));
            $Numeros[] = $numero.$i;
              for ($j=$i-1;$j<=$NumeroItensPedido;$j+=$QtdPedidosParaGerar){

                foreach ($CodigoProduto as $Chave => $Produto) {
                  if ($Chave==$j){
                    //echo "Chave: $Chave; Produto: $Produto<br />\n";
                    $Sql1 = "Produto: $Produto - update itens_pedidos_internet_novo set numero = '".$numero.$i."' where numero='".$numero."' and codigo='".$Produto."'";
                    $Sql1 = "update itens_do_pedido_internet set numero_pedido = '".$numero.$i."' where numero_pedido='".$numero."' and codigo='".$Produto."'";
                    //echo $Sql1."<BR>";
                    $SqlUpdateTemp = pg_query($Sql1) or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$SqlPedidoTemp.pg_query ($db, "rollback"));
                  }
                }

              }
          }
          //////////////////////////////////////////////////////////////////$SqlRemoveTemp1 = pg_query("Delete from pedidos_internet_novo where numero='".$numero."'");
          //Atualizo totais dos pedidos divididos.
          foreach ($Numeros as $Chave => $Pedido) {
            //echo "<BR><BR>Chave: $Chave; Pedido: $Pedido<br />\n";
            $numero = $Pedido;
            $TotalIPI = 0;
            $consulta = "select * from itens_do_pedido_internet where numero_pedido = ".$numero;
            $resultado = pg_query($consulta) or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$SqlPedidoTemp.pg_query ($db, "rollback"));
            if (empty($TotalProdutos1)){$TotalProdutos1 = 0;}
            if (empty($TotalProdutos2)){$TotalProdutos2 = 0;}
            while ($array1 = pg_fetch_array($resultado)){
              $TotalProdutos1 = $TotalProdutos1 + ( $array1['qtd1'] * $array1['valor_unitario1'] );
              $TotalProdutos2 = $TotalProdutos2 + ( $array1['qtd2'] * $array1['valor_unitario2'] );
              $TotalIPI = ($array1['ipi']*$TotalProdutos1)/100;
              $total_pedido = $TotalProdutos1 + $TotalProdutos2;
              if ($desconto > 0){
                  $tem_especial = 1;
              }else{
                  $tem_especial = 0;
              }
              pg_query($db,"UPDATE pedidos_internet_novo SET total_produtos =".$total_pedido.",total_ipi = ".$TotalIPI.",tem_especial = ".$tem_especial."  WHERE numero = '".$numero."'") ;
            }
            $SqlValidaItensPedido = pg_query("Select numero_pedido from itens_do_pedido_internet where numero_pedido='".$numero."'");
            $cci = pg_num_rows($SqlValidaItensPedido);
            if ($cci>0){
              ###########################################################################################
              #  Grava pedido oficial novo - Obrigatoriamente na execução dessa rotina marca enviado = 1
              ###########################################################################################
              //instancia o objeto
              $Pedido = new PedidoOficial();
              // seta os atributos do objeto
              $Pedido->set_numero_internet($numero);
              $Pedido->set_observacao($_REQUEST['observacao']);
              $Pedido->fazer();
              ?>
              <span class="titulo1 erro"><center>Pedido <span class="titulo1"><b><?php echo $_SESSION['NumeroPedidoGravado'];?></b></span> Gravado e enviado com sucesso</center><BR><BR></span>
              <?php
            }
          }
          //exit;
        }else{
          ### Fim Divisão
          if ($_REQUEST['enviar_pedido']){
            $SqlValidaItensPedido = pg_query("Select numero_pedido from itens_do_pedido_internet where numero_pedido='".$_REQUEST['numero']."'");
            $cci = pg_num_rows($SqlValidaItensPedido);
            if ($cci>0){
              ###########################################################################################
              #  Grava pedido oficial novo - Obrigatoriamente na execução dessa rotina marca enviado = 1
              ###########################################################################################
              //instancia o objeto
              $Pedido = new PedidoOficial();
              // seta os atributos do objeto
              $Pedido->set_numero_internet($_REQUEST['numero']);
              $Pedido->set_observacao($_REQUEST['observacao']);
              $Pedido->fazer();
              ?>
              <span class="titulo1 erro"><center>Pedido <span class="titulo1"><b><?php echo $_SESSION['NumeroPedidoGravado'];?></b></span> Gravado e enviado com sucesso  - <a href="#" onclick="window.open('impressao.php?numero=<?php echo $_SESSION['NumeroPedidoGravado'];?>&t=1','_blank');return false;">Clique para imprimir</a></center></span>
              <?php
            }else{
              ?>
              <span class="titulo1 erro"><center>Esse pedido está sem ítens, é impossível enviar.</center></span>
              <?php
            }
          }
        }
      //Uso @ para ocultar erros de cursor
      pg_query ($db, "commit");
      @pg_close($db);
      if ($_REQUEST['rascunho']>0){
        ?>
        <!--<span class="titulo1"><center><BR><BR><BR>Rascunho salvo automaticamente dia <b><?php echo date("d/m/Y")." as ".date("H:i:s");?></b></center></span>-->
        <?php
      }
    }
    ?>
  </div>
  <BR><BR>
  <?php
}
?>

