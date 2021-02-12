<?php
include ("inc/common.php");
include "inc/verifica.php";
$_SESSION['pagina'] = "cadastrar_clientes.php";
$Ativa = "display: none;";
$DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.cad,false);',0);\"";
$Tirar = array(".","-","/",","," ");
$_REQUEST['localizar_numero'] = str_replace($Tirar, "", $_REQUEST['localizar_numero']);
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  //echo "CNPJ valido: $_REQUEST[cnpj_valido]";
  if ($_REQUEST'[cnpj_valido']==1){
    $Icones = "<img src='icones/gravado.png' title='CPF / CNPJ Válido'><span class=texto1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CPF / CNPJ Válido</span>";
  }else{
    $Icones = "<img src='icones/cancela.png' title='CPF / CNPJ Inválido'><span class=erro>CPF / CNPJ Inválido</span>";
  }
  $SqlCarregaPedido = pg_query("Select * from clientes where cgc='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaPedido);
  if ($ccc<>""){
    $c = pg_fetch_array($SqlCarregaPedido);
    if ($c['cgc']){
      if ($_SESSION['config']['cadastros']['VendedorCliente']){
        if ($c['codigo_vendedor']!=$_SESSION['id_vendedor']){
          $Ativa = "display: block;";
          $c = "";
          $Icones = "";
        }else{
          $Ativa = "display: none;";
        }
        $Cgc = $c['cgc'];
      }else{
        $Ativa = "display: none;";
      }
      $Cgc = $c['cgc'];
    }
    if ($c['codigo_pagto']){
      $SqlCondicao = pg_query("Select codigo, descricao from condicao_pagamento where codigo='".$c['codigo_pagto']."'");
      $c1 = pg_fetch_array($SqlCondicao);
    }
    if ($c['codigo_transportadora']){
      $SqlTrans = pg_query("Select nome from transportadoras where id='".$c['codigo_transportadora']."'");
      $Trans = pg_fetch_array($SqlTrans);
      $p['transportadora'] = $Trans['nome'];
    }
  }else{
    $Cgc = $_REQUEST['localizar_numero'];
  }
}
if (!$_REQUEST['acao']){
  ?>
  <body <?php echo $DesativaForm;?>>
    <table width="400" border="0" cellspacing="0" cellpadding="0" class="texto1" align="left">
      <tr>
        <td valign="top" width="400">
        <b>Cadastro de clientes</b>
        <div id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaTopo" background="images/l1_r2_c1.gif">
            <div style="cursor: pointer;" id="clientes-corpoAba1" name="clientes-corpoAba1" class="divAbaAtiva">
              <a onclick="return trocarAba('clientes-',1,4)">Dados do cliente</a>
            </div>
            <div id="clientes-aba1" name="clientes-aba1"><div class="divAbaAtivaFim"></div></div>
            <div style="cursor: pointer;" id="clientes-corpoAba2" name="clientes-corpoAba3" class="divAbaInativa">
              <a onclick="if (!document.cad.cnpj.value){trocarAba('clientes-',1,4);document.cad.cnpj.focus();}else{trocarAba('clientes-',2,4)}">Cobrança</a>
            </div>
            <div id="clientes-aba2" name="clientes-aba2"><div class="divAbaInativaFim"></div></div>
            <div style="cursor: pointer;" id="clientes-corpoAba3" name="clientes-corpoAba3" class="divAbaInativa">
              <a onclick="if (!document.cad.cnpj.value){trocarAba('clientes-',1,4);document.cad.cnpj.focus();}else{trocarAba('clientes-',3,4)}">Entrega</a>
            </div>
            <div id="clientes-aba3" name="clientes-aba3"><div class="divAbaInativaFim"></div></div>
            <div style="cursor: pointer;" id="clientes-corpoAba4" name="clientes-corpoAba4" class="divAbaInativa">
              <a onclick="if (!document.cad.cnpj.value){trocarAba('clientes-',1,4);document.cad.cnpj.focus();}else{trocarAba('clientes-',4,4)}">Outros</a>
            </div>
            <div id="clientes-aba4" name="clientes-aba4"><div class="divAbaInativaFim"></div></div>
          </div>
          <div id="divAbaMeio">
             <table width="100%" height="200" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td height="214" valign="top" width="100%">
                   <table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="100%" colspan="3" valign="top">
                         <form action="" name="cad" METHOD="POST" <?php echo $DesativaForm;?>>
                           <?php
                           if ($c['cgc']){
                             ?>
                             <input type="hidden" name="acao" value="Editar" id="acao">
                             <?php
                           }else{
                             ?>
                             <input type="hidden" name="acao" value="Cadastrar" id="acao">
                             <?php
                           }
                           ?>
                           <input type="hidden" name="pg" value="cadastrar_vendedores" id="pg">
                           <span style="" name="clientes-corpo1" id="clientes-corpo1">
                              <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td width="100">CNPJ/CPF:</td>
                                  <td>
                                    <input name="cnpj" id="cnpj" value="<?php echo $Cgc;?>" type="text" size="20" maxlength="18" onblur="checa(this.value,'document.cad.cnpj')"  onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){checa(this.value,'document.cad.cnpj');document.cad.inscricao.focus();}">
                                    <?php echo $Icones;?>
                                  </td>
                                </tr>
                                <div id="disable" style="position: absolute; background: none; <?php echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" align="center">&nbsp;<div align="right">Esse cliente pertence a outro vendedor</div></div>
                                <tr>
                                  <td width="100">Insc. Est.:</td>
                                  <td><input name="inscricao" id="inscricao" value="<?php echo $c['inscricao'];?>" type="text" size="20" maxlength="20" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.nome.focus();}"></td>
                                </tr>
                                <tr>
                                  <td width="100">Nome:</td>
                                  <td><input name="nome" id="nome" type="text" value="<?php echo $c['nome'];?>" size="60" maxlength="50" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.apelido.focus();}"></td>
                                </tr>
                                <tr>
                                  <td width="100">Apelido:</td>
                                  <td><input name="apelido" id="apelido" value="<?php echo $c['apelido'];?>" type="text" size="60" maxlength="60" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cep.focus();}"></td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                                      <tr>
                                        <td width="100">CEP:</td>
                                        <td>
                                          <table border="0" cellspacing="2" cellpadding="2" class="texto1">
                                            <tr>
                                              <td>
                                                <input name="cep" id="cep" value="<?php echo $c['cep'];?>" type="text" size="20" maxlength="10" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto.value==document.cad.cep.value){document.cad.endereco.focus();}else{acerta_campos('corpo1','boxendereco','cep.php',true);}}">
                                              </td>
                                              <td>
                                                <div id="cpanel">
                                                  <div >
                                                   	<div class="icon">
                                                     	<a  href="#" onclick="acerta_campos('divAbaMeio','boxendereco','cep.php',true);">
                                                   		  	<img src="icones/pesquisar.png" alt="Pesquisar" align="middle" border="0" title="Clique para procurar automaticamente o endereço pelo CEP">
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
                                    <fieldset style="width: 80%; padding: 1;">
                                      <legend>Endereço: </legend>
                                      <div id="boxendereco" name="boxendereco" style="border:0px;padding=0px; z-index: 1000;">
                                        <input type="hidden" name="cep_oculto" id="cep_oculto">
                                        <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                          <tr>
                                            <td width="100">Endereço:</td>
                                            <td><input name="endereco" id="endereco" value="<?php echo $c['endereco'];?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td width="100">Cidade:</td>
                                            <td><input name="cidade" id="cidade" value="<?php echo $c['cidade'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td width="100">Bairro:</td>
                                            <td><input name="bairro" id="bairro" value="<?php echo $c['bairro'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td width="100">Estado:</td>
                                            <td>
                                              <select name="estado" size="1" id="estado" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.ddd.focus();}" style="z-index: 1000;">
                                                <option value="<?php echo $c['estado'];?>"><?php echo $c['estado'];?></option>
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
                                        </table>
                                      </div>
                                    </fieldset>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="100">DDD:</td>
                                  <td>
                                    <input name="ddd" id="ddd" value="<?php echo $c['ddd'];?>" type="text" size="2" maxlength="2" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone.focus();}">
                                    &nbsp;&nbsp;&nbsp;Fone:&nbsp;&nbsp;&nbsp;
                                    <input name="telefone" id="telefone" value="<?php echo $c['telefone'];?>" type="text" size="20" maxlength="14" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.fax.focus();}">
                                </tr>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="100">Fax:</td>
                                  <td><input name="fax" id="fax" value="<?php echo $c['fax'];?>" type="text" size="20" maxlength="14" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba('clientes-',2,4);setTimeout('document.cad.cep_cobranca.focus()',500);}"></td>
                                </tr>
                              </table>
                           </span>
                           <span name="clientes-corpo2" id="clientes-corpo2" style="display: none;">
                              <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td colspan="2" valign="top">
                                    Opção de endereço:&nbsp;&nbsp;&nbsp;
                                    <?php
                                    if (($c['endereco']) and ($c['local_cobranca']) and ($c['endereco']==$c['local_cobranca']) and ($c['cidade']==$c['cidade_cobranca'])){
                                      $EndPrincipalCob = "checked";
                                    }else{
                                      $EndPrincipalCob = "unchecked";
                                    }
                                    ?>
                                    <input type="checkbox" name="MesmoCobranca" id="MesmoCobranca" onclick="mesmocobranca();" <?php echo $EndPrincipalCob;?>>O mesmo que o principal
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </td>
                                <tr>
                                  <td colspan="2">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                                      <tr>
                                        <td width="100">CEP:</td>
                                        <td>
                                          <table border="0" cellspacing="2" cellpadding="2" class="texto1">
                                            <tr>
                                              <td>
                                                <input name="cep_cobranca" id="cep_cobranca" value="<?php echo $c['cep_cobranca'];?>" type="text" size="20" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto_cobranca.value==document.cad.cep_cobranca.value){document.cad.endereco_cobranca.focus();}else{acerta_campos('corpo2','boxendereco_cobranca','cep_cobranca.php',true);}}">
                                              </td>
                                              <td>
                                                <div id="cpanel">
                                                  <div >
                                                   	<div class="icon">
                                                     	<a  href="#" onclick="acerta_campos('divAbaMeio','boxendereco_cobranca','cep_cobranca.php',true);">
                                                   		  	<img src="icones/pesquisar.png" alt="Pesquisar" align="middle" border="0" title="Clique para procurar automaticamente o endereço pelo CEP">
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
                                      <div id="boxendereco_cobranca" name="boxendereco_cobranca" style="border:0px;padding=0px;">
                                        <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                          <input type="hidden" name="cep_oculto_cobranca" id="cep_oculto_cobranca">
                                          <tr>
                                            <td>Endereço:</td>
                                            <td><input name="endereco_cobranca" id="endereco_cobranca" value="<?php echo $c['local_cobranca'];?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Cidade:</td>
                                            <td><input name="cidade_cobranca" id="cidade_cobranca" value="<?php echo $c['cidade_cobranca'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Bairro:</td>
                                            <td><input name="bairro_cobranca" id="bairro_cobranca" value="<?php echo $c['bairro_cobranca'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td width="100">Estado:</td>
                                            <td>
                                              <select name="estado_cobranca" size="1" id="estado_cobranca" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_cobranca.focus();}" style="z-index: 1000;">
                                                <option value="<?php echo $c[estado_cobranca];?>"><?php echo $c['estado_cobranca'];?></option>
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
                                        </table>
                                      </div>
                                    </fieldset>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Fone:</td>
                                  <td><input name="telefone_cobranca" id="telefone_cobranca" value="<?php echo $c['tel_cobranca'];?>" type="text" size="60" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba('clientes-',3,4);setTimeout('document.cad.cep_entrega.focus()',500);}"></td>
                                </tr>
                                </tr>
                                <tr>
                                  <td colspan="2"><BR>* Atenção, o endereço de Cobrança é obrigatório!</td>
                                </tr>
                              </table>
                           </span>
                           <span name="clientes-corpo3" id="clientes-corpo3" style="display: none;">
                              <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td colspan="2" valign="top">
                                    Opção de endereço:&nbsp;&nbsp;&nbsp;
                                    <?php
                                    if (($c['endereco']) and ($c['local_entrega']) and ($c['endereco']==$c['local_entrega']) and ($c['cidade']==$c['cidade_entrega'])){
                                      $EndPrincipalEnt = "checked";
                                    }else{
                                      $EndPrincipalEnt = "";
                                    }
                                    ?>
                                    <input type="checkbox" name="MesmoEntrega" id="MesmoEntrega" onclick="mesmoentrega();" value="" <?php echo $EndPrincipalEnt;?>>O mesmo que o principal
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </td>
                                <tr>
                                  <td colspan="2">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texto1" align="center">
                                      <tr>
                                        <td width="100">CEP:</td>
                                        <td>
                                          <table border="0" cellspacing="2" cellpadding="2" class="texto1">
                                            <tr>
                                              <td>
                                                <input name="cep_entrega" id="cep_entrega" value="<?php echo $c['cep_entrega'];?>" type="text" size="20" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto_entrega.value==document.cad.cep_entrega.value){document.cad.endereco_entrega.focus();}else{acerta_campos('corpo3','boxendereco_entrega','cep_entrega.php',true);}}">
                                              </td>
                                              <td>
                                                <div id="cpanel">
                                                  <div >
                                                   	<div class="icon">
                                                     	<a  href="#" onclick="acerta_campos('corpo3','boxendereco_entrega','cep_entrega.php',true);">
                                                   		  	<img src="icones/pesquisar.png" alt="Pesquisar" align="middle" border="0" title="Clique para procurar automaticamente o endereço pelo CEP">
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
                                            <td><input name="endereco_entrega" id="endereco_entrega" value="<?php echo $c['local_entrega'];?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_entrega.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Cidade:</td>
                                            <td><input name="cidade_entrega" id="cidade_entrega" value="<?php echo $c['cidade_entrega'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_entrega.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Bairro:</td>
                                            <td><input name="bairro_entrega" id="bairro_entrega" value="<?php echo $c['bairro_entrega'];?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado_entrega.focus();}"></td>
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
                                        </table>
                                      </div>
                                    </fieldset>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Fone:</td>
                                  <td><input name="telefone_entrega" id="telefone_entrega" value="<?php echo $c['tel_entrega'];?>" type="text" size="60" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cnpj_entrega.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>CNPJ/CPF:</td>
                                  <td><input name="cnpj_entrega" id="cnpj_entrega" value="<?php echo $c['cgc_entrega'];?>" type="number" size="20" maxlength="18" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.inscricao_entrega.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>Insc. Est.:</td>
                                  <td><input name="inscricao_entrega" id="inscricao_entrega" value="<?php echo $c['inscricao_entrega'];?>" type="text" size="60" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba('clientes-',4,4);setTimeout('document.cad.contato.focus()',500);}"></td>
                                </tr>
                              </table>
                           </span>
                           <span name="clientes-corpo4" id="clientes-corpo4" style="display: none;">
                              <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1">
                                <tr>
                                  <td>Contato:</td>
                                  <td><input name="contato" id="contato" value="<?php echo $c['contato'];?>" type="text" size="20" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.email.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>E-mail:</td>
                                  <td><input name="email" id="email" value="<?php echo $c['email'];?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.homepage.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>Home Page:</td>
                                  <td><input name="homepage" id="homepage" value="<?php echo $c['homepage'];?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.observacao.focus();}"></td>
                                </tr>
                                <tr>
                                  <td valign="top">Observação:</td>
                                  <td><textarea name="observacao" id="observacao" rows="4" cols="57" onKeyDown="if(this.value.length >= 250){this.value = this.value.substring(0, 250)}" onKeyUp="if(this.value.length >= 50){this.value = this.value.substring(0, 250)}"><?php echo $c['observacao'];?></textarea></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </tr>
                                <tr>
                                  <td width="100">Cod. Suframa:</td>
                                  <td><input name="codigosuframa" id="codigosuframa" value="<?php echo $c['numero_suframa'];?>" type="text" size="20" maxlength="40" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.trans_cc.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>Transportadora:</td>
                                  <td>
                                    <input type="hidden" name="trans_id" id="trans_id" value="<?php echo $c['codigo_transportadora'];?>">
                                    <input type="text" size="50" name="trans_cc" id="trans_cc" value="<?php echo $p['transportadora'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.condpag1_id.focus();}else{Acha1('listar.php','tipo=trans&valor='+this.value+'','listar_trans');}"><BR>
                                    <div id="listar_trans" style="position:absolute;"></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Cond. Pagam.:</td>
                                  <td>
                                    <select name="condpag1_id" size="1" id="condpag1_id">
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
                   <?php
                   if ($_SESSION['codigo_empresa']<>"95"){
                     if ($_REQUEST['cnpj_valido']==1){
                       ?>
                       <input type="button" onclick="if (checa(document.cad.cnpj.value,'document.cad.cnpj')){ acerta_campos('divAbaMeio','Inicio','cadastrar_clientes.php',true)}" name="Gravar" value="Gravar">
                       <?php
                     }
                     ?>
                     <input type="button" onclick="Acha('inicio.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                     <?php
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
  <?php
}else{
  ###################################
  # Variaveis vindas do form anterior
  ###################################
  ?>
  <div id="Erro" class="erro">
    <BR><BR><BR>
    <?php
    $cgc = $_REQUEST["cnpj"];
    if (strlen($cgc)<"8"){
      echo "* Verifique o CNPJ / CPF<BR>";
      $_Err = true;
    }elseif (strlen($cgc)<"12"){ //CNPJ pode ter até 12 digitos
      $e_cgc = 0;
    }else{ //> 8 e > 12 tem que ser cpf
      $e_cgc = 1;
      if ($_REQUEST["inscricao"] == "") {
        echo "* Verifique a Inscrição<BR>";
        $_Err = true;
      }
    }
    ##################################################
    #### Verifica valores ### Campos Obrigatórios ####
    ##################################################
    if ($_REQUEST["nome"] == "") {
      echo "* Verifique o Nome<BR>";
      $_Err = true;
    }
    if ($_REQUEST["endereco"] == "") {
      echo "* Verifique o Endereço<BR>";
      $_Err = true;
    }
    if ($_REQUEST["cidade"] == "") {
      echo "* Verifique a Cidade<BR>";
      $_Err = true;
    }
    if ($_REQUEST["bairro"] == "") {
      echo "* Verifique o Bairro<BR>";
      $_Err = true;
    }
    if ($_REQUEST["cep"] == "") {
      echo "* Verifique o Cep<BR>";
      $_Err = true;
    }
    if ($_REQUEST["telefone"] == "") {
      echo "* Verifique o Telefone<BR>";
      $_Err = true;
    }
    if ($_REQUEST["ddd"] == "") {
      echo "* Verifique o DDD";
      $_Err = true;
    }
    if (($_REQUEST['estado']=="RO") and (($_REQUEST['cidade']=="GUAJARA MIRIM") or ($_REQUEST['cidade']=="BONFIM")) and $_REQUEST['codigosuframa']==""){
      echo "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AC") and (($_REQUEST['cidade']=="BRASILEIA") or ($_REQUEST['cidade']=="CRUZEIRO DO SUL")or ($_REQUEST['cidade']=="EPITACIOLANDIA")) and $_REQUEST['codigosuframa']==""){
      echo "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AM") and (($_REQUEST['cidade']=="MANAUS") or ($_REQUEST['cidade']=="PRESIDENTE FIGUEIREDO") or ($_REQUEST['cidade']=="RIO PRETO DA EVA")or ($_REQUEST['cidade']=="TABATINGA")) and $_REQUEST['codigosuframa']==""){
      echo "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AP") and (($_REQUEST['cidade']=="MACAPA") or ($_REQUEST['cidade']=="SANTANA")) and $_REQUEST['codigosuframa']==""){
      echo "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="RR") and ($_REQUEST['cidade']=="PACARAIMA") and $_REQUEST['codigosuframa']==""){
      echo "* Verifique o Código Suframa"; $_Err = true;
    }
    if ($_REQUEST["MesmoCobranca"]){
      //echo "<BR>FALSE 1";
      if ($_REQUEST['cep_cobranca']=="")     { echo "* Verifique o cep de Cobrança<BR>";      $_Err = true;}
      if ($_REQUEST['endereco_cobranca']==""){ echo "* Verifique o endereço de Cobrança<BR>"; $_Err = true;}
      if ($_REQUEST['cidade_cobranca']=="")  { echo "* Verifique a cidade de Cobrança<BR>";   $_Err = true;}
      if ($_REQUEST['bairro_cobranca']=="")  { echo "* Verifique o bairro de Cobrança<BR>";   $_Err = true;}
      if ($_REQUEST['estado_cobranca']=="")  { echo "* Verifique o estado de Cobrança<BR>";   $_Err = true;}
    }else{
      //echo "<BR>TRUE 1";
      if ($_REQUEST['cep']=="")     { echo "* Verifique o cep<BR>";                  $_Err = true;}
      if ($_REQUEST['endereco']==""){ echo "* Verifique o endereço<BR>";             $_Err = true;}
      if ($_REQUEST['cidade']=="")  { echo "* Verifique a cidade<BR>";               $_Err = true;}
      if ($_REQUEST['bairro']=="")  { echo "* Verifique o bairro<BR>";               $_Err = true;}
      if ($_REQUEST['estado']=="")  { echo "* Verifique o estado<BR>";               $_Err = true;}
    }
    //echo "<BR>COBRANCA: $_REQUEST[MesmoCobranca]<BR>";
    //echo "<BR>MESMO ENTREGA: $_REQUEST[MesmoEntrega]<BR>";
    //echo "<BR>endereco cobranca: $_REQUEST[endereco_cobranca]<BR>";
    if (!$_Err){
      include_once("inc/config.php");
      if ($_REQUEST['codigosuframa']){
        $CodigoSuframa = $_REQUEST['codigosuframa'];
      }else{
        $CodigoSuframa = "0";
      }
      if ($_REQUEST['meta_qtd']){
        $MetaQtd = $_REQUEST['meta_qtd'];
      }else{
        $MetaQtd = "0";
      }
      if ($_REQUEST['meta_rs']){
        $MetaRs = $_REQUEST['meta_rs'];
      }else{
        $MetaRs = "0";
      }
      if ($_REQUEST['limitecredito']){
        $LimiteCredito = $_REQUEST['limitecredito'];
      }else{
        $LimiteCredito = "0";
      }
      ##########################################
      # Confere se o cliente já está cadastrado
      ##########################################
      $achacgc = "SELECT id FROM clientes where cgc='".$_REQUEST['cnpj']."'";
      $resultado1 = pg_query($db, $achacgc) or die("Erro na consulta : ".$achacgc);
      $ccc = pg_num_rows($resultado1);
      if (($_REQUEST['acao']=="Editar") or ($ccc>0)){
        ##########################################
        #   Editar o cliente
        ##########################################
        if ($_REQUEST['trans_id']){
          $Transportadora = "codigo_transportadora='".$_REQUEST['trans_id']."'', ";
        }else{
          $Transportadora = " ";
        }
        if ($_REQUEST['condpag1_id']){
          $CodigoPagamento = "codigo_pagto='".$_REQUEST['condpag1_id']."',  ";
        }else{
          $CodigoPagamento = " ";
        }
        $Sql = "Update clientes set
                  cgc='".$_REQUEST['cnpj']."', apelido=upper('".str_replace("'","´",$_REQUEST["apelido"])."'),
                  nome=upper('".str_replace("'","´",$_REQUEST["nome"])."'), endereco=upper('".str_replace("'","´",left($_REQUEST["endereco"],50))."'),
                  cidade=upper('".str_replace("'","´",left($_REQUEST["cidade"],25))."'), bairro=upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),
                  estado='".$_REQUEST['estado']."', '".$Transportadora.$CodigoPagamento."
                  cep='".$_REQUEST['cep']."', ddd='".$_REQUEST['ddd']."', telefone='".$_REQUEST['telefone']."', fax='".$_REQUEST['fax']."',
                  inscricao='".$_REQUEST['inscricao']."', contato=upper('".str_replace("'","´",$_REQUEST["contato"])."'),
                  email=upper('".str_replace("'","´",$_REQUEST["email"])."'), homepage=upper('".str_replace("'","´",$_REQUEST["homepage"])."'),
                  observacao=upper('".str_replace("'","´", $_REQUEST["observacao"])."'),
                  e_cgc='".$e_cgc."', numero_suframa='".$CodigoSuframa."',
                  ";
                  if (!$_REQUEST["MesmoCobranca"]){
                    $Sql = $Sql."
                                 local_cobranca=upper('".str_replace("'","´",left($_REQUEST["endereco"],50))."'),
                                 cidade_cobranca=upper('".str_replace("'","´",left($_REQUEST["cidade"],25))."'),
                                 bairro_cobranca=upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),
                                 estado_cobranca=upper('".str_replace("'","´",$_REQUEST["estado"])."'),
                                 cep_cobranca=upper('".str_replace("'","´",$_REQUEST["cep"])."'),
                                 tel_cobranca='".$_REQUEST['ddd'].$_REQUEST['telefone']."',
                                ";
                  }else{
                    $Sql = $Sql."
                                 local_cobranca=upper('".str_replace("'","´",left($_REQUEST["endereco_cobranca"],50))."'),
                                 cidade_cobranca=upper('".str_replace("'","´",left($_REQUEST["cidade_cobranca"],25))."'),
                                 bairro_cobranca=upper('".str_replace("'","´",left($_REQUEST["bairro_cobranca"],20))."'),
                                 estado_cobranca=upper('".str_replace("'","´",$_REQUEST["estado_cobranca"])."'),
                                 cep_cobranca=upper('".str_replace("'","´",$_REQUEST["cep_cobranca"])."'),
                                 tel_cobranca='".$_REQUEST['telefone_cobranca']."',
                                ";
                  }

                  if (!$_REQUEST['MesmoEntrega']){
                    $Sql = $Sql."
                                 cgc_entrega=upper('".str_replace("'","´",$_REQUEST["cnpj"])."'),
                                 local_entrega=upper('".str_replace("'","´",left($_REQUEST["endereco"],50))."'),
                                 cidade_entrega=upper('".str_replace("'","´",left($_REQUEST["cidade"],25))."'),
                                 bairro_entrega=upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),
                                 estado_entrega=upper('".str_replace("'","´",$_REQUEST["estado"])."'),
                                 cep_entrega=upper('".str_replace("'","´",$_REQUEST["cep"])."'),
                                 inscricao_entrega=upper('".str_replace("'","´",$_REQUEST["inscricao"])."'),
                                 tel_entrega='".$_REQUEST[telefone]."'
                                ";
                  }else{
                    $Sql = $Sql."
                                 cgc_entrega=upper('".str_replace("'","´",$_REQUEST["cnpj_entrega"])."'),
                                 local_entrega=upper('".str_replace("'","´",left($_REQUEST["endereco_entrega"],50))."'),
                                 cidade_entrega=upper('".str_replace("'","´",left($_REQUEST["cidade_entrega"],25))."'),
                                 bairro_entrega=upper('".str_replace("'","´",left($_REQUEST["bairro_entrega"],20))."'),
                                 estado_entrega=upper('".str_replace("'","´",$_REQUEST["estado_entrega"])."'),
                                 cep_entrega=upper('".str_replace("'","´",$_REQUEST["cep_entrega"])."'),
                                 inscricao_entrega=upper('".str_replace("'","´",$_REQUEST["inscricao_entrega"])."'),
                                 tel_entrega='".$_REQUEST['telefone_entrega']."'
                                ";
                  }
                  $Sql = $Sql."
                              where cgc='".$_REQUEST['cnpj']."'
               ";
        $Msg = "<span class=titulo1><center>Cliente editado com sucesso</center></span>";
      }else{
        ##########################################
        # Determina ID do cliente
        ##########################################
        $acha_id = "SELECT (MAX(id) + 1) as max FROM clientes";
        $resultado = pg_query($db, $acha_id) or die("Erro na consulta : ".$acha_id.pg_last_error($db));
        $row = pg_fetch_object($resultado, 0);
        $id=$row->max;
        ##########################################
        #   Insere o cliente novo
        ##########################################
        if ($_REQUEST['trans_id']){
          $CampoTransportadora = "codigo_transportadora, ";
          $ValorTransportadora = " '$_REQUEST[trans_id]',";
        }else{
          $CampoTransportadora = " ";
          $ValorTransportadora = " ";
        }
        if ($_REQUEST['condpag1_id']){
          $CampoCodigoPagamento = "codigo_pagto, ";
          $ValorCodigoPagamento = " '$_REQUEST[condpag1_id]',";
        }else{
          $CampoCodigoPagamento = " ";
          $ValorCodigoPagamento = " ";
        }
        $Sql = "Insert Into clientes (
                  id, codigo, data_cadastro, cgc, apelido,
                  nome, endereco, cidade, bairro, estado, $CampoTransportadora
                  cep, ddd, telefone, fax, inscricao,
                  contato, email, homepage, observacao, data_ultima_compra,
                  e_cgc, classificacao_cliente, codigo_vendedor, limite_credito, meta_valor,
                  meta_qtd, $CampoCodigoPagamento
                  local_cobranca, cidade_cobranca, bairro_cobranca, estado_cobranca, cep_cobranca, tel_cobranca,
                  cgc_entrega, local_entrega, cidade_entrega, bairro_entrega, estado_entrega,  cep_entrega, tel_entrega, inscricao_entrega,
                  vendedor
                )values(
                  '$id','$id','$data_hoje','$_REQUEST[cnpj]', upper('".str_replace("'","´",$_REQUEST["apelido"])."'),
                  upper('".str_replace("'","´",$_REQUEST["nome"])."'),upper('".str_replace("'","´",$_REQUEST["endereco"])."'), upper('".str_replace("'","´",$_REQUEST["cidade"])."'), upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),'$_REQUEST[estado]', $ValorTransportadora
                  '$_REQUEST[cep]','$_REQUEST[ddd]','$_REQUEST[telefone]','$_REQUEST[fax]', '$_REQUEST[inscricao]',
                  upper('".str_replace("'","´",$_REQUEST["contato"])."'), upper('".str_replace("'","´",$_REQUEST["email"])."'), upper('".str_replace("'","´",$_REQUEST["homepage"])."'), upper('".str_replace("'","´", $_REQUEST["observacao"])."'),'01/01/1998',
                  '$e_cgc', '0', '$_SESSION[id_vendedor]', '".str_replace(",",".",$LimiteCredito)."', '".str_replace(",",".",$MetaRs)."',
                  '".str_replace(",",".",$MetaQtd)."', $ValorCodigoPagamento
                  ";
                  if (!$_REQUEST["MesmoCobranca"]){
                    $Sql = $Sql."
                                 upper('".str_replace("'","´",left($_REQUEST["endereco"],50))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["cidade"],25))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),
                                 upper('".str_replace("'","´",$_REQUEST["estado"])."'),
                                 upper('".str_replace("'","´",$_REQUEST["cep"])."'),
                                 '$_REQUEST[ddd] $_REQUEST[telefone]',
                                ";
                  }else{
                    $Sql = $Sql."
                                 upper('".str_replace("'","´",left($_REQUEST["endereco_cobranca"],50))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["cidade_cobranca"],25))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["bairro_cobranca"],20))."'),
                                 upper('".str_replace("'","´",$_REQUEST["estado_cobranca"])."'),
                                 upper('".str_replace("'","´",$_REQUEST["cep_cobranca"])."'),
                                 '$_REQUEST[ddd_cobranca] $_REQUEST[telefone_cobranca]',
                                ";
                  }
                  if (!$_REQUEST['MesmoEntrega']){
                    $Sql = $Sql."
                                 upper('".str_replace("'","´",$_REQUEST["cnpj"])."'),
                                 upper('".str_replace("'","´",left($_REQUEST["endereco"],50))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["cidade"],25))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["bairro"],20))."'),
                                 upper('".str_replace("'","´",$_REQUEST["estado"])."'),
                                 upper('".str_replace("'","´",$_REQUEST["cep"])."'),
                                 '$_REQUEST[ddd] $_REQUEST[telefone]',
                                 upper('".str_replace("'","´",$_REQUEST["inscricao"])."'),
                                ";
                  }else{
                    $Sql = $Sql."
                                 upper('".str_replace("'","´",$_REQUEST["cnpj_entrega"])."'),
                                 upper('".str_replace("'","´",left($_REQUEST["endereco_entrega"],50))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["cidade_entrega"],25))."'),
                                 upper('".str_replace("'","´",left($_REQUEST["bairro_entrega"],20))."'),
                                 upper('".str_replace("'","´",$_REQUEST["estado_entrega"])."'),
                                 upper('".str_replace("'","´",$_REQUEST["cep_entrega"])."'),
                                 '$_REQUEST[ddd_entrega] $_REQUEST[telefone_entrega]',
                                 upper('".str_replace("'","´",$_REQUEST["inscricao_entrega"])."'),
                                ";
                  }
                  $Sql = $Sql."
                  '$_SESSION[usuario]'
                  )
               ";
        $Msg = "<span class=titulo1><center>Cliente cadastrado com sucesso</center></span>";
      }
      //echo $Sql;
      if (!@pg_query($db, $Sql)){
        include "log_erro.php";
      }else{
        echo $Msg;
      }
      pg_close($db);
     }
    ?>
  </div>
  <?php
}
?>
