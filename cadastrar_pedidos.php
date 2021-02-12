<?php
include_once ("inc/common.php");
include "inc/verifica.php";
$_SESSION['pagina'] = "pedidos.php";
$_SESSION['lista_preco'] = $_REQUEST['lista_preco'];
if (!$_REQUEST['acao']){
  $PedidoLiberado = false;
  if (is_numeric($_REQUEST['localizar_numero'])){
    include_once("inc/config.php");
    $SqlCarregaPedido = pg_query("Select * from pedidos_internet_novo where numero='".$_REQUEST['localizar_numero']."'");
    $ccc = pg_num_rows($SqlCarregaPedido);
    $PedidoNormal = false;
    if ($ccc==""){
      $SqlCarregaPedido = pg_query("Select * from pedidos where numero='".$_REQUEST['localizar_numero']."'");
      $ccc = pg_num_rows($SqlCarregaPedido);
      $PedidoNormal = true;
    }
    if ($ccc<>""){
      $p = pg_fetch_array($SqlCarregaPedido);
      $SqlObservacao = pg_query("Select observacao from observacao_do_pedido where numero_pedido='".$_REQUEST['localizar_numero']."'");
      $o = pg_fetch_array($SqlObservacao);
	  	   

      if ($p['codigo_pagamento']){
        $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$p['codigo_pagamento']."'");
        $c1 = pg_fetch_array($SqlCondicao);
        $_REQUEST['cod_pag'] = $p['codigo_pagamento'];
        include("inc/ParcelaMinima.php");
      }
      if ($p['codigo_pagamento1']){
        $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$p['codigo_pagamento1']."'");
        $c2 = pg_fetch_array($SqlCondicao);
        $_REQUEST['cod_pag2'] = $p['codigo_pagamento1'];
        include("inc/ParcelaMinima.php");
      }
      if ($p['transportadora']){
        $SqlTransportadora = pg_query("Select id, nome from transportadoras where nome='".$p['transportadora']."' and inativo=0");
        $t = pg_fetch_array($SqlTransportadora);
      }
      $sql = "Select id, email_nfe, cgc, apelido, contato, codigo_transportadora, codigo, nome, inscricao, codigo_vendedor, endereco,
                     cidade, bairro, estado, cep, telefone, estado_entrega, tel_entrega, cgc_entrega, inscricao_entrega, local_entrega,
                     cidade_entrega, bairro_entrega, endereco_entrega_numero, cep_entrega, codigo_ibge_entrega,  codigo_bloqueio, inativo
              from clientes where cgc='".$p['cgc']."'";
      $SqlProcuracliente = pg_query($sql);
      $ccc = pg_num_rows($SqlProcuracliente);
      $c = pg_fetch_array($SqlProcuracliente);
      if ($p['efetivado']){
        $PedidoLiberado = false;
      }else{
        $PedidoLiberado = true;
      }
      $DisplayAbas = "block";
      $c['estado_entrega'] = $p['estado_entrega'];
      $c['bairro_entrega'] = $p['bairro_entrega'];
      $c['tel_entrega'] = $p['tel_entrega'];
      $c['cgc_entrega'] = $p['cgc_entrega'];
      $c['inscricao_entrega'] = $p['inscricao_entrega'];
      $c['local_entrega'] = $p['local_entrega'];
      $c['cidade_entrega'] = $p['cidade_entrega'];
      $c['endereco_entrega_numero'] = $p['endereco_entrega_numero'];
      $c['cep_entrega'] = $p['cep_entrega'];
      $c['codigo_ibge_entrega'] = $p['codigo_ibge_entrega'];
    }else{
      $Loc = true;
    }
  }elseif ($_REQUEST['CgcCliente']){
    include_once("inc/config.php");
    $sql = "Select id, email_nfe, cgc, apelido, contato, codigo_transportadora, codigo, nome, inscricao, codigo_vendedor, endereco,
                   cidade, bairro, estado, cep, telefone, estado_entrega, tel_entrega, cgc_entrega, inscricao_entrega, local_entrega,
                   cidade_entrega, bairro_entrega, endereco_entrega_numero, cep_entrega, codigo_ibge_entrega,  codigo_bloqueio, inativo
            from clientes where cgc='".$_REQUEST['CgcCliente']."'";
    //echo $sql;
    $SqlProcuracliente = pg_query($sql);
    $ccc = pg_num_rows($SqlProcuracliente);
    if ($ccc<>""){
      $c = pg_fetch_array($SqlProcuracliente);
      if ($c['cgc']){
        if (($c['codigo_vendedor']!=$_SESSION['id_vendedor']) and ($_SESSION['nivel']<>"2")){
          $PedidoLiberado = false;
          $p = "";
          $Icones = "<BR><font color=red>Esse cliente pertence a outro vendedor</font>";
          $p['cgc'] = $_REQUEST['CgcCliente'];
        }else{
          $PedidoLiberado = true;
          $p['cgc'] = $c['cgc'];
          $p['id_cliente'] = $c['id'];
          $p['cliente'] = $c['nome'];
          $p['contato'] = $c['contato'];
          $p['inscricao'] = $c['inscricao'];
          $Icones = "<img src='icones/gravado.gif' title='CPF / CNPJ Válido'>";
        }
      }else{
        $PedidoLiberado = false;
        $p = "";
        $Icones = "Cliente não cadastrado";
        $p['cgc'] = $_REQUEST['CgcCliente'];
      }
    }else{
      $PedidoLiberado = false;
      $p = "";
      $Icones = "Cliente não cadastrado";
      $p['cgc'] = $_REQUEST['CgcCliente'];
    }
  }else{
    $PedidoLiberado = false;
    $DisplayAbas = "none";
  }
  if (($p['enviado']=="1") or ($PedidoNormal)){
    $Ativa = "display: block;";
    $DesativaForm = " onfocus=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onblur=\"setTimeout('DisableEnableForm(document.ped,true);',0);\" onclick=\"setTimeout('DisableEnableForm(document.ped,true);',0);\"";
    $_SESSION['enviado'] = 1;
    $SalvarRascunho = "";
  }else{
    $Ativa = "display: none;";
    $DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.ped,false);',0);\"";
    $_SESSION['enviado'] = "";
    //$SalvarRascunho = "document.getElementById('salvo').innerHTML = 'Rascunho salvo automaticamente dia <b>'+detbut();+'</b>!!'; acerta_campos('pedido','GrdProdutos','incluir_itens.php',false);";
    $SalvarRascunho = "acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true); document.ped.rascunho.value=1;";
  }
  if ($c['codigo_bloqueio']>0){
    $PedidoLiberado = false;
    $p = "";
    $Icones = "<BR><font color=red>Esse cliente está bloqueado!</font>";
    $p['cgc'] = $_REQUEST['CgcCliente'];
  }
  if ($c['inativo']>0){
    $PedidoLiberado = false;
    $p = "";
    $Icones = "<BR><font color=red>Esse cliente está Inativo!</font>";
    $p['cgc'] = $_REQUEST['CgcCliente'];
  }
  if (!$PermitirSalvarRascunho){
    $SalvarRascunho = "";
  }
  if ($p['local_entrega']){
    $c['local_entrega'] = $p['local_entrega'];
  }
  if ($_SESSION['vende_especial']=="0"){
    $DisplayDesconto = "none";
  }else{
    $DisplayDesconto = "block";
  }
  if ($_REQUEST['localizar_numero']){
    $SqlItens = pg_query("select codigo from itens_do_pedido_internet where numero_pedido='".$_REQUEST['localizar_numero']."'");
    $SqlItensccc = pg_num_rows($SqlItens);
    if ($SqlItensccc==""){
      $DisplayDesconto = "block";
    }else{
      $DisplayDesconto = "none";
    }
  }
  
  
//CARREGO OS DADOS DA OBSERVAÇÃO DO CADASTRO DO CLIENTE
$sqlObservacaoCliente = pg_query("SELECT incluir_obs_pedido, observacao FROM clientes WHERE cgc  = '".$p['cgc']."'");
$oCliente 			= pg_fetch_array($sqlObservacaoCliente);
	if($oCliente['incluir_obs_pedido'] == 1) {
		$obsPedido = $oCliente['observacao'];  
	} 
	  
  
  
  ?>
  <body <?php echo $DesativaForm;?>>
  <div id="CarregarPedido" style="position: absolute; top:40%; left:45%; background-color: #eee; border: 2px #cccccc; color: #FFFFFF; z-index:5000; <?php if ($Loc){echo "display: block;"; }else{ echo "display: none;";}?>">
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
  <form action="cadastrar_pedidos.php" name="ped" METHOD="POST" <?php echo $DesativaForm;?>>
    <div id="pedido">
      <table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
        <?php
        if ($PedidoLiberado){
          ?>
          <input type="hidden" name="enviar_pedido" id="enviar_pedido" value="0">
          <input type="hidden" name="acao" value="Cadastrar" id="acao">
          <input type="hidden" name="rascunho" value="" id="rascunho">
          <input type="hidden" name="pg" value="cadastrar_pedidos" id="pg">
          <input type="hidden" name="arredondamento" value="<?php echo $CONF['arredondamento']?>" id="arredondamento">
          <?php
          if (($IpServer=="192.168.0.2") or ($_SESSION['id_vendedor']=="471")){ // PAC 9474 e 10419
            ?>
            <input type="hidden" name="ValorParcelaMinima" value="1" id="ValorParcelaMinima">
            <?php
          }else{
            ?>
            <input type="hidden" name="ValorParcelaMinima" value="<?php echo $CONF['ValorParcelaMinima']?>" id="ValorParcelaMinima">
            <?php
          }
          ?>
          <input type="hidden" name="localizar_numero" id="localizar_numero" size="15">
          <div name="qtdParcelas" id="qtdParcelas" style="display: none;">></div>
          <div name="qtdParcelas2" id="qtdParcelas2" style="display: none;">></div>
          <?php
        }
        ?>
        <tr>
          <td valign="top">
            <span id="errovalor1" align="center" style="position: absolute; background: none; width: 605; color: red; z-index: 13000; text-align: right;"></span>
            <span id="errovalor2" align="center" style="position: absolute; background: none; width: 605; color: red; z-index: 13000; text-align: right;"></span>
            <center><b>Lançamento de Pedidos</b></center>
            <div id="cores" style="position: absolute;  width: 603px; height:200px; background-color: #FFFFFF; border: 2px #000000; color: #000000; z-index: 1; display: none;">
              <?php
              include "cores.php";
              ?>
            </div>
            <?php
            if ($PedidoLiberado){
              ?>
              <div name="divAbaGeral" id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
                <div id="divAbaTopo">
                  <div style="cursor: pointer;" id="corpoAba1" name="corpoAba1" class="divAbaAtiva">
                    <a onclick="trocarAba(1,3); <?php echo $SalvarRascunho;?>">Dados do cliente</a>
                  </div>
                  <div id="aba1" name="aba1"><div class="divAbaAtivaFim"></div></div>
                  <div style="cursor: pointer; display: <?php echo $DisplayAbas;?>" id="corpoAba2" name="corpoAba2" class="divAbaInativa">
                    <a onclick="ChecaPedido1(); <?php echo $SalvarRascunho;?>">Dados dos Produtos</a>
                  </div>
                  <div id="aba2" name="aba2" style="display: <?php echo $DisplayAbas;?>;"><div class="divAbaInativaFim"></div></div>
                  <div style="cursor: pointer; display: <?php echo $DisplayAbas;?>" id="corpoAba3" name="corpoAba3" class="divAbaInativa">
                    <a onclick="ChecaPedido2(); <?php echo $SalvarRascunho;?>">Dados Complementares</a>
                  </div>
                  <div id="aba3" name="aba3" style="display: <?php echo $DisplayAbas;?>;"><div class="divAbaInativaFim"></div></div>
                </div>
                <div id="disable" style="position: absolute; background: none; <?php echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" class="arialg" align="center">&nbsp;<div align="right">Pedido já enviado</div></div>
              <?php
            }else{
              ?>
              <tr>
                <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
              </tr>
              <?php
            }
            ?>
              <div id="divAbaMeio">
                 <table width="580" align="left" border="0" cellspacing="0" cellpadding="0" class="texto1">
                   <tr>
                     <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
                       <table width="592" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
                         <tr>
                           <td width="592" colspan="3" valign="top">
                             <span style="" name="corpo1" id="corpo1">
                                <table width="580" border="0" cellspacing="1" cellpadding="1" class="texto1" align="center">
                                  <tr>
                                    <td width="20%">CNPJ/CPF:</td>
                                    <td width="80%">
                                      <input type="text" size="20" name="clientecnpj_cc" maxlength="18" id="clientecnpj_cc" value="<?php echo $p['cgc'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+this.value+'','Conteudo');}">
                                      <?php echo $Icones;?>
                                      <BR>
                                      <div id="listar_clientecnpj" style="position:absolute; z-index: 7000;"></div>
                                      <?php if ($c['inscricao']){?>
                                      <div style="position: absolute; margin-top: -15px; margin-left:200px; ">
                                        Insc. Est.:
                                        <b> <?php echo $c['inscricao'];?></b>
                                      </div>
                                      <?php } ?>
                                    </td>
                                  </tr>
                                  <?php
                                  if (!$PedidoLiberado){
                                    ?>
                                    <tr>
                                      <td width="20%">Cliente:</td>
                                      <td width="80%">
                                        <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $p['id_cliente'];?>">
                                        <input type="text" size="60" name="cliente_cc" id="cliente_cc" value="<?php echo $p['cliente'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if(tecla==13){Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');}else{if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else { if (this.value.length>3){Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');}}}">
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
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Bairro:
                                        &nbsp;&nbsp;
                                        <b> <?php echo $c['bairro'];?></b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Estado:
                                        &nbsp;&nbsp;
                                        <b> <?php echo $c['estado'];?></b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>Telefone:</td>
                                      <td>
                                        <b> <?php echo $c['telefone'];?></b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Contato:
                                        &nbsp;&nbsp;
                                        <b> <?php echo $c['contato'];?></b>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        CEP:
                                        &nbsp;&nbsp;
                                        <b> <?php echo $c['cep'];?></b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="2"><img src="images/linha_menu.gif" width="100%" height="1"></td>
                                    </tr>
                                    <tr>
                                      <td width="20%">Local de Entrega:</td>
                                      <td width="80%">
                                        <b>
                                          <?php
                                          printf ("%s - %s - %s ", $c['local_entrega'], $c['bairro_entrega'], $c['cidade_entrega']);
                                          ?>
                                        </b>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td colspan="2" height="2"><img src="images/linha_menu.gif" width="100%" height="1"></td>
                                    </tr>
                                    <tr>
                                      <td width="20%">Transportadora:</td>
                                      <td width="80%">
                                        <select name="trans_cc" size="1" id="trans_cc" style=" z-index: 1000;" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.data_entrega.focus();}">
                                          <?php
                                          if ($t['id']){
                                            echo "<option value='".$t['nome']."'>".$t['nome']."</option>";
                                            echo "<option></option>";
                                            $RetiraTR = " and id<>'".$t['id']."' ";
                                          }elseif ((!$t['nome']) and ($c['codigo_transportadora'])){
                                            $SqlTransportadora = pg_query("Select id, nome from transportadoras where id='".$c['codigo_transportadora']."' and inativo=0");
                                            $trans = pg_fetch_array($SqlTransportadora);
                                            echo "<option value='".$trans['nome']."'>".$trans['nome']."</option>";
                                            echo "<option></option>";
                                            $RetiraTR = " and id<>'".$c['codigo_transportadora']."' ";
                                          }else{
                                            echo "<option></option>";
                                          }
                                          include_once("inc/config.php");
                                          $SqlCarregaTrans = pg_query("SELECT id, nome FROM transportadoras where inativo=0 $RetiraTR order by nome ASC");
                                          while ($tr = pg_fetch_array($SqlCarregaTrans)){
                                            echo "<option value='".$tr['nome']."'>".$tr['nome']."</option>";
                                          }
                                          ?>
                                        </select>
                                        Tipo frete:
                                        <select name="tipo_frete" id="tipo_frete">
                                          <?php
                                          if ($p['cif']=="0"){
                                            ?>
                                            <option value="FOB">FOB</option>
                                            <option value="CIF">CIF</option>
                                            <?php
                                          }else{
                                            ?>
                                            <option value="CIF">CIF</option>
                                            <option value="FOB">FOB</option>
                                            <?php
                                          }
                                          ?>
                                        </select>
                                        <!--
                                          <input type="radio" name="frete" id="frete" onclick="document.ped.frete1.checked=false;document.ped.frete1.value='';document.ped.frete.value='FOB';" <?php if (($p[cif]=="0") or (!$_REQUEST[localizar_numero])){ if ($p[cif]=="0") { echo "Checked value='FOB - $p[cif]'"; }else{ echo "value=''";}}else{ echo "value=''";}?>>FOB
                                          <input type="radio" name="frete1" id="frete1" onclick="document.ped.frete.checked=false;document.ped.frete.value='';document.ped.frete1.value='CIF';" <?php if (($p[cif]=="1") and ($_REQUEST[localizar_numero])){ echo "Checked value='CIF'";}else{ echo "value=''";}?>>CIF&nbsp;&nbsp;&nbsp;
                                        -->
                                        <BR>
                                      </td>
                                    </tr>
                                    <?php
                                    $datahoje = date("Ymd"); //ano4, mes2, dia2
                                    $prazo = AdicionarDias($datahoje,30);    // Adiciona 15 dias

                                    $ano30 = substr ( $prazo, 0, 4 );
                                    $mes30 = substr ( $prazo, 4, 2 );
                                    $dia30 =  substr ( $prazo, 6, 2 );

                                    $data_entrega30 = $dia30."/".$mes30."/".$ano30;
                                    if ($p['data_prevista_entrega']){
                                      $da = $p['data_prevista_entrega'];
                                      $d = explode("-", $da);
                                      $data_entrega30 = "".$d[2]."/".$d[1]."/".$d[0]."";
                                    }
                                    ?>
                                    <tr>
                                      <td>Data Entrega:</td>
                                      <td valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                                          <td>
                                            <input name="data_entrega" id="data_entrega"  type="text" size="10" maxlength="20" value="<?php echo $data_entrega30;?>" onclick="MostraCalendario(document.ped.data_entrega,'dd/mm/yyyy',this)" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (document.getElementById('yearDropDown')){closeCalendar();}document.ped.numero_cliente.focus();}">
                                          </td>
                                          <td valign="top">
                                            <!--Desconto:-->
                                          </td>
                                          <?php
                                          if (!$p['desconto_cliente']){
                                            $p['desconto_cliente'] = 0;
                                          }
                                          ?>
                                          <td valign="top">
                                            <b><span id='boxdesconto'><?php if (($DisplayDesconto=="block") and ($p['desconto_cliente']>0)){ echo intval($p['desconto_cliente']);}?></span></b>
                                            <input type="hidden" name="desconto" id="desconto" value="<?php echo intval($p['desconto_cliente']);?>" size="8" maxlength="3" style="display: <?php if($DisplayDesconto=="block"){ echo $DisplayDesconto;}else{ echo "none";}?>;" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (this.value>100){ alert('O desconto deve ser menor que 100'); this.value='0';}else{document.ped.condpag1_id.focus();}}" onblur="habilitapagto2();">
                                          </td>
                                        </table>
                                      </td>
                                    </tr>
                                    <?php
                                    if (($p['numero']) and ($p['numero_internet'])){
                                      $NumeroInternet = $p['numero_internet'];
                                      $Numero = $p['numero'];
                                    }else{
                                      $Numero = $_SESSION['id_vendedor'].date("dmy").date("His");
                                    }
                                    ?>
                                    <tr>
                                      <td>Numero:</td>
                                      <td>
                                        <input name="numero" id="numero"  type="hidden" size="20" maxlength="20" value="<?php if ($NumeroInternet){ echo $NumeroInternet;}else{echo $Numero;}?>" onclick="setTimeout('document.ped.numero.disabled=true',10);">
                                          <input name="numero_pedido_next" id="numero_pedido_next"  type="hidden" size="20" maxlength="20" value="<?php echo $Numero;?>">
                                        <b><?php echo $Numero;?></b>
                                        <?php
                                        if (!$NumeroInternet){
                                          ?>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <span onmouseover="ddrivetip('<strong><u>Número do Pedido</u></strong><BR><BR>O número é composto sequencialmente por <i>CodigoVendedor + Dia + Mes + Ano + Hora + Minuto + Segundo</i>, <BR>ex: 85+23+06+08+15+30+21')" onmouseout="hideddrivetip()" class="dwnx"><img src="icones/duvida.png" border="0" width="15" height="15"></span>
                                          <?php
                                        }
                                        ?>
                                        <!--<div style="position: absolute; margin-top: -15px; margin-left:200px; ">-->
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          Num. Cliente: &nbsp;&nbsp;&nbsp;
                                          <input name="numero_cliente" id="numero_cliente" value="<?php echo $p['numero_cliente'];?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.desconto.focus();}">
                                        <!--</div>-->
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="20%">Cond. Pagam. 1:</td>
                                      <td width="80%">
                                        <select name="condpag1_id" size="1" id="condpag1_id" onchange="Acha('inc/ParcelaMinima.php', 'cod_pag='+document.ped.condpag1_id.value+'', 'qtdParcelas');" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if (document.getElementById('box-dadospagto2').style.display=='block'){document.ped.condpag2_id.focus();}else{<?php if ($FatoresPedido){ echo 'document.ped.desconto1_cc.focus();';}else{ echo 'ChecaPedido1(); '.$SalvarRascunho.'; document.ped.codigo_cc.focus();';}?>}}">
                                          <?php
                                          if ($c1['codigo']){
                                            echo "<option value='".$c1['codigo']."'>".$c1['descricao']."</option>";
                                            echo "<option></option>";
                                            $RetiraCP = " and codigo<>'".$c1['codigo']."' ";
                                          }else{
                                            echo "<option></option>";
                                          }
                                          include_once("inc/config.php");
                                          $SqlCarregaCondpag = pg_query("SELECT codigo, descricao FROM condicao_pagamento where codigo > 0 $RetiraCP and site='1' order by descricao ASC");
                                          while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                            echo "<option value='".$cp['codigo']."'>$cp[descricao]</option>";
                                          }
                                          ?>
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="20%">
                                      <div id="box-labelpagto2" style="display: <?php echo ($c2['codigo'])? "block":"none";?>;">
                                      Cond. Pagam. 2:
                                      </div></td>
                                      <td width="80%">
                                      <div id="box-dadospagto2" style="display: <?php echo ($c2['codigo'])? "block":"none";?>;">
                                        <select name="condpag2_id" size="1" id="condpag2_id" onchange="Acha('inc/ParcelaMinima.php', 'cod_pag2='+document.ped.condpag2_id.value+'', 'qtdParcelas2');" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){ <?php if ($FatoresPedido){ echo 'document.ped.desconto1_cc.focus();';}else{ echo 'ChecaPedido1(); '.$SalvarRascunho.'; document.ped.codigo_cc.focus();';}?>}">
                                          <?php
                                          if ($c2['codigo']){
                                            echo "<option value='".$c2['codigo']."'>".$c2['descricao']."</option>";
                                            echo "<option></option>";
                                            $RetiraCP2 = " and codigo<>'".$c2['codigo']."' ";
                                          }else{
                                            echo "<option></option>";
                                          }
                                          include_once("inc/config.php");
                                          $SqlCarregaCondpag = pg_query("SELECT codigo, descricao FROM condicao_pagamento where codigo > 1 $RetiraCP2 and site='1' order by descricao ASC");
                                          while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                            echo "<option value='".$cp['codigo']."'>".$cp['descricao']."</option>";
                                          }
                                          ?>
                                        </select>
                                        </div>
                                      </td>
                                    </tr>
                                    <?php
                                    if ($FatoresPedido){
                                      ?>
                                      <tr>
                                        <td width="20%">Desc. 1:</td>
                                        <td width="80%">
                                          <select style="display: block;" name="desconto1_cc" size="1" id="desconto1_cc" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.desconto2_cc.focus();}">
                                            <?php
                                            if ($p['fator1']){
                                              echo "<option value='".$p['fator1']."'>".$p['fator1']."</option>";
                                              echo "<option></option>";
                                              $RetiraFator = " where valor<>'".$p['fator1']."' ";
                                            }else{
                                              echo "<option></option>";
                                            }
                                            include_once("inc/config.php");
                                            $SqlCarregaCondpag = pg_query("SELECT * FROM descontos $RetiraFator order by descricao ASC");
                                            while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                              echo "<option value='".$cp['valor']."'>".$cp['descricao']."</option>";
                                            }
                                            ?>
                                          </select>
                                          <input type="hidden" name="desconto2_cc" id="desconto2_cc">
                                        </td>
                                      </tr>
                                      <!--
                                      <tr>
                                        <td width="20%">
                                          <div id="box-labeldesc2" style="display: <?php echo ($p[fator2])? "block":"none";?>;">
                                            Desc. 2:
                                          </div>
                                        </td>
                                        <td width="80%">
                                          <div id="box-dadosdesc2" style="display: <?php echo ($p[fator2])? "block":"none";?>;">
                                            <select name="desconto2_cc" size="1" id="desconto2_cc" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){ChecaPedido1(); <?php echo $SalvarRascunho;?> document.ped.codigo_cc.focus();}">
                                            <?php
                                            if ($p[fator2]){
                                              echo "<option value='".$p['fator2']."'>".$p[fator2]."</option>";
                                              echo "<option></option>";
                                              $RetiraFator2 = " where fator<>'$p[fator2]' ";
                                            }else{
                                              echo "<option></option>";
                                            }
                                            include_once("inc/config.php");
                                            $SqlCarregaCondpag = pg_query("SELECT * FROM fatores $RetiraFator2 order by fator ASC");
                                              while ($cp = pg_fetch_array($SqlCarregaCondpag)){
                                                echo "<option value='".$cp['fator']."'>".$cp[fator]."</option>";
                                              }
                                              ?>
                                            </select>
                                          </div>
                                        </td>
                                      </tr>
                                      -->
                                      <?php
                                    }else{
                                      ?>
                                      <input type="hidden" name="desconto1_cc" id="desconto1_cc">
                                      <input type="hidden" name="desconto2_cc" id="desconto2_cc">
                                      <?php
                                    }
                                    if ($_SESSION['nivel']=="2"){
                                      ?>
                                      <tr>
                                        <td width="20%">
                                        <div id="box-vendedor">
                                        Vendedor:
                                        </div></td>
                                        <td width="80%">
                                        <div id="box-vendedor2">
                                        <?php if(($_SESSION['codigo_empresa'] == 2) && (($p['codigo_vendedor']) || ($c['codigo_vendedor']))) {
											$desabilitaVendedor = "disabled";	
										}?>
                                          <select name="vendedor2_id" size="1" id="vendedor2_id" <?php echo $desabilitaVendedor; ?>><!-- onchange="Acha('inc/ParcelaMinima.php', 'cod_pag2='+document.ped.condpag2_id.value+'', 'qtdParcelas2');" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){ <?php if ($FatoresPedido){ echo 'document.ped.desconto1_cc.focus();';}else{ echo 'ChecaPedido1(); '.$SalvarRascunho.'; document.ped.codigo_cc.focus();';}?>}">-->
                                            <?php
                                            if ($p['codigo_vendedor']){
                                              echo "<option value='".$p['codigo_vendedor']."'>".$p['vendedor']."</option>";
                                              echo "<option disabled></option>";
                                              $RetiraVendedor = " and codigo<>'".$p['codigo_vendedor']."' ";
                                            }elseif ($c['codigo_vendedor']){
                                              $SqlCarregaVend = pg_query("SELECT codigo, nome FROM vendedores where codigo='".$c['codigo_vendedor']."' and inativo=0");
                                              $cv = pg_fetch_array($SqlCarregaVend);
                                              echo "<option value='".$cv['codigo']."'>".$cv['nome']."</option>";
                                              echo "<option disabled></option>";
                                              $RetiraVendedor = " and codigo<>'".$c['codigo_vendedor']."' ";
                                            }else{
                                              echo "<option disabled></option>";
                                            
                                            include_once("inc/config.php");
												$SqlCarregaCondpag = pg_query("SELECT codigo, nome FROM vendedores where nome<>'SUPORTE' $RetiraVendedor  and inativo=0 order by nome ASC");
												while ($cp = pg_fetch_array($SqlCarregaCondpag)){
												  echo "<option value='".$cp['codigo']."'>".$cp['nome']."</option>";
												} 
											}
                                            ?>
                                          </select>
                                          </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" height="2"><img src="images/linha_menu.gif" width="100%" height="1"></td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
                                    <tr>
                                      <td>Lista de preço:</td>
                                      <td>
                                        <select name="lista_preco" size="1" id="lista_preco"><!-- onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){ChecaPedido1(); <?php echo $SalvarRascunho;?> document.ped.codigo_cc.focus();}">-->
                                          <?php
                                          include_once("inc/config.php");
                                          $SqlCarregaCondpag = pg_query("SELECT * FROM referencia_preco");
                                          $cp = pg_fetch_array($SqlCarregaCondpag);
                                          if ($p['lista_preco']==1){
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='4'>$cp[d]</option>";
                                            echo "<option value='5'>$cp[e]</option>";
                                          }elseif ($p['lista_preco']==2){
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='4'>$cp[d]</option>";
                                            echo "<option value='5'>$cp[e]</option>";
                                          }elseif ($p['lista_preco']==3){
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='4'>$cp[d]</option>";
                                            echo "<option value='5'>$cp[e]</option>";
                                          }elseif ($p['lista_preco']==4){
                                            echo "<option value='4'>$cp[d]</option>";
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='5'>$cp[e]</option>";
                                          }elseif ($p['lista_preco']==5){
                                            echo "<option value='5'>$cp[e]</option>";
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='4'>$cp[d]</option>";
                                          }else{
                                            echo "<option value='1'>$cp[a]</option>";
                                            echo "<option value='2'>$cp[b]</option>";
                                            echo "<option value='3'>$cp[c]</option>";
                                            echo "<option value='4'>$cp[d]</option>";
                                            echo "<option value='5'>$cp[e]</option>";
                                          }
                                          ?>
                                        </select>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>E-mail NFE:</td>
                                      <td>
                                        <?php
                                        if ($c['email_nfe']){
                                          ?>
                                          <input name="email_nfe" id="email_nfe" value="<?php echo if_utf8($c['email_nfe']);?>" type="hidden" size="60" maxlength="50">
                                          <?php
                                          echo $c['email_nfe'];
                                        }else{
                                          ?>
                                          <input name="email_nfe" id="email_nfe" value="<?php echo if_utf8($c['email_nfe']);?>" type="text" size="60" maxlength="50">
                                          <?php
                                        }
                                        ?>
                                      </td>
                                    </tr>
                                    <?php
                                  }
                                  ?>
                                </table>
                                <div id="opcoes_empresa" style="text-align: center;position: absolute;  margin-top: 0%; width: 550; background: none; <?php if (!$PedidoLiberado){echo "display: none;";}?>">
                                  <?php
                                  if ($CodigoEmpresa=="75"){ // Perlex
                                    if (($c['codigo_vendedor']=="471") or ($c['codigo_vendedor']=="624") or ($c['codigo_vendedor']=="533") or ($c['codigo_vendedor']=="487") or  ($IpServer=="192.168.0.2") or ($_SESSION['nivel']=="2")){ // PAC 9459
                                      ?>
                                      Venda Casada? <input type="checkbox" name="venda_casada" value="" id="venda_casada" <?php echo ($p['venda_casada'])? "checked":"unchecked";?>>
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                      <?php
                                    }else{
                                      ?>
                                      <input type="hidden" name="venda_casada" id="venda_casada" value="" unchecked>
                                      <?php
                                    }
                                    ?>
                                    Tipo pedido:
                                    <select name="tipo_pedido" id="tipo_pedido">
                                      <option value="<?php echo $p['tipo_pedido']?>"><?php echo $p['tipo_pedido']?></option>
                                      <option value="IND">IND</option>
                                      <option value="COM">COM</option>
                                      <option value="CONS">CONS</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    *Termo de responsabilidade? <input type="checkbox" name="termo" id="termo" <?php echo ($p['com_termo'])? "checked":"unchecked";?>>
                                    <?php
                                  }else{
                                    ?>
                                    <input type="hidden" name="venda_casada" id="venda_casada">
                                    <?php
                                  }
                                  ?>
                                </div>
                                <div style="position: <?php if (!$PedidoLiberado){ echo "relative;top: 20%; left: 150px;";}else{ echo "absolute; top: 365px; left: 50px;";}?>  background: none;" name="Prossiga" id="Prossiga">
                                  <input type="button" onclick="<?php if (!$PedidoLiberado){ echo "Acha1('cadastrar_pedidos.php','CgcCliente='+document.ped.clientecnpj_cc.value+'','Conteudo');"; }else{ echo "if (ChecaPedido1()){ $SalvarRascunho document.ped.codigo_cc.focus();}";}?>" name="Prossiga1" id="Prossiga1" value="Prossiga >>">
                                  <?php
                                  if (($SalvarRascunho) and ($PedidoLiberado)){
                                    //Retirado por indicação do gerente de vendas da Perlex
                                    // Ele disse achar interessante que o representante vá até o final do pedido para gravar o orçamento
                                    ?>
                                    <!--<input type="button" onclick="document.ped.enviar_pedido.value=0; document.ped.rascunho.value=1; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true);" style="width: 130px;" name="Somente gravar" id="Somente Gravar" value="Gravar Orçamento">-->
                                    <?php
                                  }
                                  ?>
                                  <input type="button" onclick="document.getElementById('CarregarPedido').style.display='block';document.getElementById('valor').focus();" name="Localizar" id="Localizar" value="Localizar">
                                </div>
                             </span>
                             <span name="corpo2" id="corpo2" style="display: none;">
                               <?php
                               if ($PedidoLiberado){
                                 ?>
                               <table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1">
                                 <tr>
                                   <td>
                                     <span name="itens" id="itens">
                                       <?php include "editar_itens.php"; ?>
                                     </span>
                                   </td>
                                 </tr>
                                 <tr>
                                   <td valign="top">
                                     <table width="590" border="0" cellspacing="2" cellpadding="2" class="texto1">
                                       <tr>
                                         <td colspan="2" valign="top">
                                           <?php
                                           //if ($p[numero_internet]){
                                             $numero = $p['numero_internet'];
                                             include_once("incluir_itens.php");
                                           //}
                                           ?>
                                         </td>
                                       </tr>
                                     </table>
                                   </td>
                                 </tr>
                               </table>
                               <div style="position: absolute; top: 365px; left: 50px; background: none;" name="Prossiga2" id="Prossiga2" style="<?php if (!$PedidoLiberado){echo "display: none;";}?>">
                                 <input type="button" onclick="ChecaPedido2();" name="Prossiga22" id="Prossiga22" value="Prossiga >>">
                                 <?php
                                 if (($SalvarRascunho) and ($PedidoLiberado)){
                                   ?>
                                   <!--<input type="button" onclick="document.ped.enviar_pedido.value=0; document.ped.rascunho.value=1; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true);" style="width: 130px;" name="Somente Gravar" id="Somente Gravar" value="Gravar Orçamento">
                                   <input type="button" onclick="document.getElementById('CarregarPedido').style.display='block';document.getElementById('valor').focus();" name="Localizar" id="Localizar" value="Localizar">                                                                   -->
                                   <?php
                                 }
                                 ?>
                               </div>
                               <?php
                               }
                               ?>
                             </span>
                             <span name="corpo3" id="corpo3" style="display: none;">
                               <?php
                               if ($PedidoLiberado){
                                 ?>
                                 <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                   <tr>
                                     <td valign="top">Observação:</td>
                                     <?php
                                     if($CodigoEmpresa=="2") { // ?>
									 <td><textarea name="observacao" id="observacao" type="text" rows="2" cols="65" onKeyDown="if(this.value.length >= 180){this.value = this.value.substring(0, 180)}" onKeyUp="if(this.value.length >= 180){this.value = this.value.substring(0, 180)}"><?php echo $obsPedido; ?><?php echo $o['observacao'];?></textarea></td>										 
									 <?php }elseif ($CodigoEmpresa=="75"){ ?>
                                       <td><textarea name="observacao" id="observacao" type="text" rows="2" cols="65" onKeyDown="if(this.value.length >= 150){this.value = this.value.substring(0, 150)}" onKeyUp="if(this.value.length >= 150){this.value = this.value.substring(0, 150)}"><?php echo $o['observacao'];?></textarea></td>
                                       <?php  }else{ ?>
                                       <td><textarea name="observacao" id="observacao" type="text" rows="2" cols="65" onKeyDown="if(this.value.length >= 180){this.value = this.value.substring(0, 180)}" onKeyUp="if(this.value.length >= 180){this.value = this.value.substring(0, 180)}"><?php echo $o['observacao'];?></textarea></td>
                                       <?php
                                     }
                                     ?>
                                   </tr>
                                 </table>
                                 <fieldset style="width: 100%; padding: 1; z-index: 1000;">
                                   <legend>Dados de entrega *</legend>
                                   <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                     <tr>
                                       <td colspan="2">
                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                                           <tr>
                                             <td width="100">CEP:</td>
                                             <td>
                                               <table border="0" cellspacing="1" cellpadding="1" class="texto1">
                                                 <tr>
                                                   <td>
                                                     <input name="cep_entrega" id="cep_entrega" value="<?php echo $c['cep_entrega'];?>" type="text" size="20" maxlength="9" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto_entrega.value==document.cad.cep_entrega.value){document.cad.endereco_entrega.focus();}else{acerta_campos('corpo3','boxendereco_entrega','cep_entrega.php',true);}}">
                                                   </td>
                                                   <td>
                                                     <div id="cpanel">
                                                       <div >
                                                        	<div class="icon">
                                                          	<a  href="#" onclick="acerta_campos('corpo3','boxendereco_entrega','cep_entrega.php',true);">
                                                        		  	<img src="icones/pesquisar.gif" alt="Pesquisar" align="middle" border="0" title="Clique para procurar automaticamente o endereço pelo CEP">
                                                        			</a>
                                                        	</div>
                                                       </div>
                                                     </div>
                                                   </td>
                                                 </tr>
                                               </table>
                                             </td>
                                           </tr>
                                         </table>
                                       </td>
                                     </tr>
                                     <tr>
                                       <td colspan="2" valign="top">
                                         <fieldset style="width: 80%; padding: 1; z-index: 1000;">
                                           <legend>Endereço: </legend>
                                           <div id="boxendereco_entrega" name="boxendereco_entrega" style="border:0px;padding=0px;">
                                             <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                               <input type="hidden" name="cep_oculto_entrega" id="cep_oculto_entrega">
                                               <tr>
                                                 <td>Endereço:</td>
                                                 <td>
                                                   <input name="endereco_entrega" id="endereco_entrega" value="<?php echo if_utf8($c['local_entrega']);?>" type="text" size="35" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.endereco_entrega_numero.focus();}">
                                                   Número:
                                                   <input name="endereco_entrega_numero" id="endereco_entrega_numero" value="<?php echo strtoupper($c['endereco_entrega_numero']);?>" type="text" size="8" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_entrega.focus();}">
                                                 </td>
                                               </tr>
                                               <tr>
                                                 <td>Cidade:</td>
                                                 <td><input name="cidade_entrega" id="cidade_entrega" value="<?php echo if_utf8($c['cidade_entrega']);?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_entrega.focus();}"></td>
                                               </tr>
                                               <tr>
                                                 <td>Bairro:</td>
                                                 <td><input name="bairro_entrega" id="bairro_entrega" value="<?php echo if_utf8($c['bairro_entrega']);?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado_entrega.focus();}"></td>
                                               </tr>
                                               <tr>
                                                 <td width="100">Estado:</td>
                                                 <td>
                                                   <select name="estado_entrega" size="1" id="estado_entrega" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_entrega.focus();}" style="z-index: 1000;">
                                                     <option value="<?php echo $c['estado_entrega'];?>"><?php echo $c['estado_entrega'];?></option>
                                                   		<option value="AC">Acre </option>
                                                   		<option value="AL">Alagoas</option>
                                                   		<option value="AM">Amazonas</option>
                                                   		<option value="AP">Amapa</option>
                                                   		<option value="BA">Bahia</option>
                                                   		<option value="CE">Ceara</option>
                                                   		<option value="DF">Distrito Federal</option>
                                                     <option value="ES">Espirito Santo</option>
                                                   		<option value="GO">Goias</option>
                                                   		<option value="MA">Maranhão</option>
                                                   		<option value="MG">Minas Gerais</option>
                                                   		<option value="MS">Mato G. Sul</option>
                                                   		<option value="MT">Mato Grosso</option>
                                                   		<option value="MA">Maranhão</option>
                                                   		<option value="PA">Para</option>
                                                   		<option value="PR">Parana</option>
                                                   		<option value="PB">Paraiba</option>
                                                   		<option value="PE">Pernambuco</option>
                                                   		<option value="PI">Piaui</option>
                                                   		<option value="RJ">Rio de Janeiro</option>
                                                   		<option value="RN">Rio G. Norte</option>
                                                   		<option value="RO">Rondonia</option>
                                                   		<option value="RR">Roraima</option>
                                                   		<option value="RS">Rio G. Sul</option>
                                                   		<option value="SC">Santa Catarina</option>
                                                   		<option value="SE">Sergipe</option>
                                                     <option value="SP">São Paulo</option>
                                                   		<option value="TO">Tocantins</option>
                                                   </select>
                                                 </td>
                                               </tr>
                                               <?php if ($CodigoEmpresa=="86"){?>
                                               <tr>
                                                 <td width="100">Código IBGE:</td>
                                                 <td><input name="codigo_ibge_entrega" id="codigo_ibge_entrega" value="<?php echo $c['codigo_ibge_entrega'];?>" type="text" size="10" maxlength="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_entrega.focus();}"></td>
                                               </tr>
                                               <?php } ?>
                                             </table>
                                           </div>
                                       </fieldset>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td>Fone:</td>
                                     <td><input name="tel_entrega" id="tel_entrega" value="<?php echo if_utf8($c['tel_entrega']);?>" type="text" size="60" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cnpj_entrega.focus();}"></td>
                                   </tr>
                                   <tr>
                                     <td>CNPJ/CPF:</td>
                                     <td><input name="cgc_entrega" id="cgc_entrega" value="<?php echo if_utf8($c['cgc_entrega']);?>" type="number" size="20" maxlength="18" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.inscricao_entrega.focus();}"></td>
                                   </tr>
                                   <tr>
                                     <td>Insc. Est.:</td>
                                     <td><input name="inscricao_entrega" id="inscricao_entrega" value="<?php echo if_utf8($c['inscricao_entrega']);?>" type="text" size="60" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba(4,4);setTimeout('document.cad.codigo_ibge_entrega.focus()',500);}"></td>
                                   </tr>
                                 </table>
                                 <div id="botoes3" style="position: absolute; top: 365px; left: 50px; background: none;">
                                   <!--
                                   <input type="button" onclick="if (confirm('Deseja realmente enviar esse pedido?')){ document.ped.enviar_pedido.value=1; document.ped.rascunho.value=0; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true);}" style="width: 130px;" name="Gravar e Enviar" id="Gravar e Enviar" value="Gravar e Enviar">
                                   -->
                                   <input type="button" onclick="if (confirm('Deseja realmente enviar esse pedido?')){ document.getElementById('botoes3').style.display='none'; document.ped.enviar_pedido.value=1; document.ped.rascunho.value=0; acerta_campos('pedido','Conteudo','cadastrar_pedidos.php',true);}" style="width: 130px;" name="Gravar e Enviar" id="Gravar e Enviar" value="Gravar e Enviar">
                                   <?php
                                   if (($SalvarRascunho) and ($PedidoLiberado)){
                                     ?>
                                     <input type="button" onclick="this.enabled='false'; document.ped.enviar_pedido.value=0; document.ped.rascunho.value=1; acerta_campos('pedido','Inicio','cadastrar_pedidos.php',true);" style="width: 130px;" name="Somente_Gravar" id="Somente_Gravar" value="Gravar Orçamento">
                                     <?php
                                   }
                                   ?>
                                 </div>
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
                     <td><img src="images/l1_r4_c1.gif" width="603" height="4">  <div id="botoes"></div></td>
                   </tr>
                 </table>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </form>
  <?php
}else{
  ###################################
  # Variaveis vindas do form anterior
  ###################################
  include_once ("inc/config.php");
  ?>
  <div id="Erro" class="erro" style="position: absolute; top: 470px; margin: 0px;">
    <?php
    $AvisoErro = "<img src='icones/aviso_erro.gif' border='0'>";
    $SalvoAutomaticamente = "<img src='icones/salvo_automaticamente.gif' border='0'>";
    $cgc = $_REQUEST["clientecnpj_cc"];
    if (strlen($cgc)<"8"){
      ?>
      <BR><?php echo $AvisoErro?> Verifique o CNPJ / CPF
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
      <BR><?php echo $AvisoErro?> Verifique o Nome do cliente
      <?php
      $_Err = true;
    }
    if (($_REQUEST['tipo_frete']=="FOB") and (!$_REQUEST['trans_cc'])){
      ?>
      <BR><?php echo $AvisoErro?> Para FOB a transportadora é obrigatória
      <?php
      $_Err = true;
    }
    if (($_REQUEST["desconto"]=="") or ($_REQUEST['desconto']=="0")) {
      $desconto = 0;
    }else {
      $desconto = $_REQUEST["desconto"];
      if ($_REQUEST['condpag2_id'] == "") {
        ?>
        <BR><?php echo $AvisoErro?> Aten&ccedil;&atilde;o, a condi&ccedil;&atilde;o de pagamento 2 &eacute; obrigat&oacute;ria!
        <?php
        $_Err = true;
      }
    }
    if ($_REQUEST["condpag1_id"] == "") {
      ?>
      <BR><?php echo $AvisoErro?> Verifique a Condição de Pagamento 1
      <?php
      $_Err = true;
    }
    if ($_SESSION['enviado']=="1"){
      $_Err = true;
    }
    if ((!VerificarEmail($_REQUEST["email_nfe"])) and ($_REQUEST['enviar_pedido']))   { echo "<BR>* Informe um E-mail NFE válido";  $_Err = true;       }
    if (!$_Err){
      ##########################################
      #   bloco de Includes
      ##########################################
      include("classes/base/classe_PedTmp.php");
      include("classes/base/classe_GraObs.php");
      include("classes/base/classe_PedOfi.php");
      ##########################################
      #   Inicializo banco de dados com begin
      ##########################################
      //Uso @ para ocultar erros se cursor
      @pg_query ($db, "begin");
      if ($_REQUEST['email_nfe']){
        pg_query("Update clientes set email_nfe='".$_REQUEST['email_nfe']."' where cgc='".$_REQUEST['clientecnpj_cc']."' and (email_nfe is null or email_nfe='' or email_nfe=' ')");
      }
      ##########################################
      #   Validação de dados
      ##########################################
      //pega cliente
      $consulta = "select id,nome,apelido,cgc,e_cgc,codigo_vendedor, email, codigo_bloqueio from clientes where id = ".$_REQUEST['cliente_id'];
      $resultado = pg_query($db, $consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      $row = pg_fetch_array($resultado);
      $cliente = $row['nome'];
      $cgc = $row['cgc'];
      if ($_REQUEST['vendedor2_id']){
        $_SESSION['id_vendedor'] = $_REQUEST['vendedor2_id'];
        $vendedor = "select nome from vendedores where codigo = ".$_REQUEST['vendedor2_id'];
        $vendedor = pg_query($db, $vendedor) or die ($MensagemDbError.$vendedor.pg_query ($db, "rollback"));
        $vendedor = pg_fetch_array($vendedor);
        $_SESSION['nome_vendedor'] = $vendedor['nome'];
        $_SESSION['vende_qualquer_produto'] = $vendedor['vende_qualquer_produto'];
      }else{
        $_SESSION['id_vendedor'] = $row['codigo_vendedor'];
        $_SESSION['nome_vendedor'] = $_SESSION['usuario'];
      }
      //echo "<HR>Codigo vendedor: $_REQUEST[vendedor2_id] - $id_vendedor<hr>";
      ######################################################
      # Formatando data entrega
      ######################################################
      // $DataPrevistaEntrega = substr($_POST["data_entrega"],3,2)."/".substr($_POST["data_entrega"],0,2)."/".substr($_POST["data_entrega"],6,4);
      //Pedido da Pat para retirar PAC 6434
      $DataPrevistaEntrega = "";
      ######################################################
      $DataPrevistaEntrega = substr($_REQUEST["data_entrega"],3,2)."/".substr($_REQUEST["data_entrega"],0,2)."/".substr($_REQUEST["data_entrega"],6,4);
      
      //echo "<BR><BR>$DataPrevistaEntrega<BR><BR>";
      ################################################################
      # Gravando dados do pedido parte1 admito, é uma meia classe :S
      ################################################################
      //instancia o objeto
      $PedidoTemp = new PedidoTemporario();
      // seta os atributos do objeto
      $PedidoTemp->set_clientecnpj($_REQUEST['clientecnpj_cc']);
      $PedidoTemp->set_local_entrega($_REQUEST['endereco_entrega']);
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
      $PedidoTemp->set_tipo_pedido($_REQUEST['tipo_pedido']);
      //echo "<HR>".$_REQUEST[venda_casada]."<HR>";
      $PedidoTemp->set_venda_casada($_REQUEST['venda_casada']);
      $PedidoTemp->set_com_termo($_REQUEST['termo']);
      $PedidoTemp->set_fob($_REQUEST['tipo_frete']);
      $PedidoTemp->set_cgc_entrega($_REQUEST['cgc_entrega']);
      $PedidoTemp->set_cidade_entrega($_REQUEST['cidade_entrega']);
      $PedidoTemp->set_bairro_entrega($_REQUEST['bairro_entrega']);
      $PedidoTemp->set_endereco_entrega_numero($_REQUEST['endereco_entrega_numero']);
      $PedidoTemp->set_estado_entrega($_REQUEST['estado_entrega']);
      $PedidoTemp->set_cep_entrega($_REQUEST['cep_entrega']);
      $PedidoTemp->set_codigo_ibge_entrega($_REQUEST['codigo_ibge_entrega']);
      $PedidoTemp->set_inscricao_entrega($_REQUEST['inscricao_entrega']);
      $PedidoTemp->set_tel_entrega($_REQUEST['tel_entrega']);
      $PedidoTemp->set_lista_preco($_REQUEST['lista_preco']);
      #########################################################################################
      #  Grava edição da Observação
      #########################################################################################
      //instancia o objeto
      $Obs = new Observacao();
      // seta os atributos do objeto
      if ($_REQUEST['numero_pedido_next']){ //quer dizer que o pedido ja foi gravado
        $Obs->set_numero_internet($_REQUEST['numero_pedido_next']);
      }else{
        $Obs->set_numero_internet($_REQUEST['numero']);
      }
      $Obs->set_observacao($_REQUEST['observacao']);
      ######################################################
      # Confere se já existe o pedido, ai só edita
      ######################################################
      $SqlConferePedido = pg_query("Select numero from pedidos_internet_novo where numero = '".$_REQUEST['numero']."'") or die ($MensagemDbError.$SqlConferePedido.pg_query ($db, "rollback"));
      $ConferePedido = pg_num_rows($SqlConferePedido);
      $SqlObservacao = pg_query("Select * from observacao_do_pedido where numero_pedido='".$_REQUEST['numero']."'");
      $cccObsPedido = pg_num_rows($SqlObservacao);
      if ($ConferePedido<>"") { //Verifica se é para editar ou adicionar.
        // seta os atributos restantes do objeto
        $PedidoTemp->set_operacao('edita');
        $Obs->set_operacao("edita");
      }else{
        // seta os atributos restantes do objeto
        $PedidoTemp->set_operacao('adiciona');
        $Obs->set_operacao("adiciona");
      }
      if ($cccObsPedido>0){
        $Obs->set_operacao("edita");
      }else{
        $Obs->set_operacao("adiciona");
      }
      // executa o objeto
      $PedidoTemp->fazer();
      $Obs->fazer();
      #########################################################################################
      #  Testa o início da divisão de pedidos
      #########################################################################################
      if ($_REQUEST['enviar_pedido']){
        $SqlContaItens = pg_query("Select count(codigo) as quantos from itens_do_pedido_internet where numero_pedido='".$_REQUEST['numero']."' and especial = 0");
        $ItensPedido = pg_fetch_array($SqlContaItens);
        $NumeroItensPedido = $ItensPedido['quantos'];
        ####### PEGA O NUMERO MAXIMO DE ITENS E O FATURAMENTO MINIMO
        $SqlReferencias = pg_query("Select numero_maximo_itens, fatmin from referencias") or die ("Erro 1");
        $ArrayReferencias = pg_fetch_array($SqlReferencias);
        $NumeroMaximoItens = $ArrayReferencias['numero_maximo_itens'];
        if (!$FatMin){
          $FatMin = $ArrayReferencias['fat_min'];
        }
        if ($NumeroItensPedido>$NumeroMaximoItens){
          echo "Dividindo Pedidos<img src=\"images/linha_menu.gif\" width=\"100%\" height=\"1\">";
          $numero = $_REQUEST['numero'];
          #### Arredonda baseado no resto, sempre pra cima.
          $Valor = $NumeroItensPedido / $NumeroMaximoItens;
          $CasasDepoisVirgula = 0;
          $Valor1 = pow (10, -($CasasDepoisVirgula + 1)) * 5;
          $QtdPedidosParaGerar = round ($Valor + $Valor1, $CasasDepoisVirgula);
          ####
          //echo "Itens $NumeroItensPedido - Maximo: $NumeroMaximoItens - Quantos pedidos preciso: $QtdPedidosParaGerar<BR><BR><hr><BR><BR>";
          $Numeros = array();
          $SqlItensTemp = pg_query("Select codigo from itens_do_pedido_internet where numero_pedido='".$numero."' and especial = 0 order by valor_total") or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$ultimopedido.pg_query ($db, "rollback"));
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
                    $Sql1 = "update itens_do_pedido_internet set numero_pedido = '".$numero.$i."' where numero_pedido='".$numero."' and codigo='".$Produto."'";
                    //echo $Sql1<BR>;
                    $SqlUpdateTemp = pg_query($Sql1) or die("A operação não foi realizada, copie esse texto e envie para suporte@tninfo.com.br, volte ao início e tente novamente : <BR>".$SqlPedidoTemp.pg_query ($db, "rollback"));
                  }
                }
              }
          }
          //////////////////////////////////////////////////////////////////$SqlRemoveTemp1 = pg_query("Delete from pedidos_internet where numero='".$numero."'");
          //Atualizo totais dos pedidos divididos.
          foreach ($Numeros as $Chave => $Pedido) {
            //echo "<BR><BR>Chave: $Chave; Pedido: $Pedido<br />\n";
            $numero = $Pedido;
            $TotalIPI = 0;
            $consulta = "select * from itens_do_pedido_internet where numero_pedido = '".$numero."'";
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
              pg_query($db,"UPDATE pedidos_internet_novo SET total_produtos = '".$total_pedido."',total_ipi = '".$TotalIPI."',tem_especial = '".$tem_especial."'  WHERE numero = '".$numero."'") ;
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
              $Pedido->set_obs($_REQUEST['observacao']);
              $Pedido->fazer();
              ?>
              <span class="titulo1 erro">Pedido <span class="titulo1"><b><?php echo $_SESSION['NumeroPedidoGravado'];?></b></span> Gravado e enviado com sucesso<BR></span>
              <?php
            }
          }
          //exit;
        }else{
          ### Fim Divisão
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
            $Pedido->set_obs($_REQUEST['observacao']);
            $Pedido->fazer();

            echo "
            <div class='titulo1 erro' align='center' style='position: absolute; width: 350; top: -300px; margin: 0px;  margin-left: -50px;'>
              <BR><BR><BR>
              Pedido <span class='titulo1'><b>$_SESSION[NumeroPedidoGravado]</b></span> Gravado e enviado com sucesso
              <BR><BR><BR>
              <a href='#' onclick=\"window.open('impressao.php?numero=$_SESSION[NumeroPedidoGravado]&t=1','_blank')\">
                <img src='icones/imprimir1.gif' border='0'>
                Clique para imprimir
              </a>
              <!--
              E-mail: Wed, Nov 19, 2008 at 11:44 AM
              <BR><BR><BR>
              <input type='button' style='width: 120px;' name='enviar' id='enviar' value='Enviar via e-mail' onclick=\"Acha('emails.php','email=<?php echo $row[email]?>&assunto=Pedido de venda - <?php echo $_SESSION[NumeroPedidoGravado];?>&msg=Olá $row[nome]!<BR><BR>Estou te enviando o pedido solicitado.&anexo=$_SESSION[NumeroPedidoGravado]','enviar_email');\">
              <BR><BR><BR>
              <div id='enviar_email'></div>
              -->
            </div>
            ";
          }else{
            echo "<span class='titulo1 erro'>$AvisoErro Esse pedido está sem ítens, é impossível enviar.</center></span>";
          }
        }
      }
      @pg_query($db, "commit");
      @pg_close($db);
      if ($_REQUEST['rascunho']>0){
        echo "
             <span class='texto1'>
               <BR><b>$SalvoAutomaticamente Orçamento salvo automaticamente em ".date("d/m/Y")." as ".date("H:i:s")."</b>
               &nbsp;&nbsp;&nbsp;
               <a href='#' onclick=\"window.open('impressao2.php?numero=$_REQUEST[numero]&t=1','_blank')\">
                 <img src='icones/imprimir1.gif' border='0'>
                 Clique para imprimir
               </a>
             </span>
             ";
      }
    }
    ?>
  </div>
  <?php
}
?>

