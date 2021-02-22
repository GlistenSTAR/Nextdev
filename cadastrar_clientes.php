<?php
include_once ("inc/common.php");
include "inc/verifica.php";
$_SESSION['pagina'] = "clientes.php";
$Ativa = "display: none;";
$DesativaForm = " onclick=\"setTimeout('DisableEnableForm(document.cad,false);',0);\"";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  if ($_REQUEST['cnpj_valido']==1){
    $Icones = "<img src='icones/gravado.gif' title='CPF / CNPJ Válido'><span class=texto1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CPF / CNPJ Válido</span>";
  }else{
    $Icones = "<img src='icones/cancela.gif' title='CPF / CNPJ Inválido'><span class=erro>CPF / CNPJ Inválido</span>";
  }
  $SqlCarregaPedido = pg_query("Select * from clientes where cgc='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaPedido);
  if ($ccc<>""){
    $c = pg_fetch_array($SqlCarregaPedido);
    if ($c['cgc']){
      if ($c['codigo_vendedor']!=$_SESSION['id_vendedor']){
        if ($_SESSION['nivel']<2){
          $Ativa = "display: block;";
          $c = "";
          $Icones = "";
        }else{
          $Ativa = "display: none;";
        }
      }else{
        $Ativa = "display: none;";
      }
      $Cgc = $c['cgc'];
    }
  }else{
    $Cgc = $_REQUEST['localizar_numero'];
  }
}
if (!$_REQUEST['acao']){
  ?>
  <body <?php echo $DesativaForm;?>>
  <table width="603" border="0" cellspacing="0" cellpadding="0" class="texto1" align="left">
    <tr>
      <td valign="top">
        <div id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaTopo">
            <div style="cursor: pointer;" id="corpoAba1" name="corpoAba1" class="divAbaAtiva">
              <a onclick="return trocarAba(1,4)">Dados do Cliente</a>
            </div>
            <div id="aba1" name="aba1"><div class="divAbaAtivaFim"></div></div>
            <?php
            if ($_REQUEST['cnpj_valido']==1){
              ?>
              <div style="cursor: pointer;" id="corpoAba2" name="corpoAba3" class="divAbaInativa">
                <a onclick="CliqueCobranca();">Cobrança</a>
              </div>
              <div id="aba2" name="aba2"><div class="divAbaInativaFim"></div></div>
              <div style="cursor: pointer;" id="corpoAba3" name="corpoAba3" class="divAbaInativa">
                <a onclick="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}else{trocarAba(3,4)}">Entrega</a>
              </div>
              <div id="aba3" name="aba3"><div class="divAbaInativaFim"></div></div>
              <div style="cursor: pointer;" id="corpoAba4" name="corpoAba4" class="divAbaInativa">
                <a onclick="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}else{trocarAba(4,4)}">Outros</a>
              </div>
              <div id="aba4" name="aba4"><div class="divAbaInativaFim"></div></div>
              <?php
            }
            ?>
          </div>
          <div id="divAbaMeio">
             <table width="580" height="350" border="0" cellspacing="0" cellpadding="0" align="left">
               <tr>
                 <td height="214" valign="top" background="images/l1_r2_c1.gif">
                   <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td colspan="3"><img src="images/spacer.gif" width="1" height="5"></td>
                     </tr>
                     <tr>
                       <td width="592" colspan="3" valign="top">
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
                           <span style="" name="corpo1" id="corpo1">
                              <table width="580" border="0" cellspacing="1" cellpadding="1" class="texto1" align="center">
                                <tr>
                                  <td width="100">CNPJ/CPF:</td>
                                  <td>
                                    <?php
                                    if ($c['cgc']){
                                      ?>
                                      <?php echo $Cgc;?>
                                      <input name="cnpj" id="cnpj" value="<?php echo $Cgc;?>" type="hidden" size="16" maxlength="14" onblur="if (this.value){checa(this.value,'document.cad.cnpj')}"  onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){checa(this.value,'document.cad.cnpj');document.cad.inscricao.focus();}">
                                      <?php
                                    }else{
                                      ?>
                                      <input name="cnpj" id="cnpj" value="<?php echo $Cgc;?>" type="text" size="16" maxlength="14" onblur="if (this.value){checa(this.value,'document.cad.cnpj')}"  onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){checa(this.value,'document.cad.cnpj');document.cad.inscricao.focus();}">
                                      <?php
                                    }
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $Icones;?>
                                    <i> * Não utilize pontos, traço ou barra!</i>
                                  </td>
                                </tr>
                                <div id="disable" style="position: absolute; background: none; <?php echo $Ativa;?> width: 590; z-index: 7000; color: red; font-weight: bold;" align="center">&nbsp;<div align="right">Esse cliente pertence a outro vendedor</div></div>
                                <tr>
                                  <td width="100">Insc. Est.:</td>
                                  <td>
                                    <input name="inscricao" id="inscricao" value="<?php echo $c['inscricao'];?>" type="text" size="20" maxlength="16" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.nome_cc.focus();}">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Código: <b><?php echo $c['codigo'];?></b>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="20%">Nome:</td>
                                  <td width="80%">
                                    <input type="hidden" name="nome_id" id="nome_id" value="<?php echo $c['id'];?>">
                                    <input type="text"  maxlength="50" size="60" name="nome_cc" id="nome_cc" value="<?php echo $c['nome'];?>" onfocus="this.select()" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;} if(tecla==13){document.cad.apelido.focus();document.getElementById('listar_nome').style.display='none';}else{if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else { if (this.value.length>3) { if (this.value.length<6) {Acha1('listar.php','tipo=nome&valor='+this.value+'','listar_nome');}}}}">
                                    <BR>
                                    <div id="listar_nome" style="position:absolute; z-index: 7000;"></div>
                                  </td>
                                </tr>
                                <?php
                                if ($_REQUEST['cnpj_valido']==1){
                                  ?>
                                  <tr>
                                    <td width="100">Apelido:</td>
                                    <td><input name="apelido" id="apelido" value="<?php echo $c['apelido'];?>" type="text" size="30" maxlength="20" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cep.focus();}"></td>
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
                                                  <input name="cep" id="cep" onkeypress="mascara(this,masc_cep)" value="<?php echo $c['cep'];?>" type="text" size="10" maxlength="9" onkeyup="if (!document.cad.cnpj.value){document.cad.cnpj.focus();}if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto.value==document.cad.cep.value){document.cad.endereco.focus();}else{acerta_campos('corpo1','boxendereco','cep.php',true);}}">
                                                </td>
                                                <td>
                                                  <div id="cpanel">
                                                    <div >
                                                     	<div class="icon">
                                                       	<a  href="#" onclick="acerta_campos('divAbaMeio','boxendereco','cep.php',true);">
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
                                      <fieldset style="width: 80%; padding: 1;">
                                        <legend>Endereço: </legend>
                                        <div id="boxendereco" name="boxendereco" style="border:0px;padding=0px; z-index: 1000;">
                                          <input type="hidden" name="cep_oculto" id="cep_oculto">
                                          <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                            <tr>
                                              <td>Endereço:</td>
                                              <td>
                                                <input name="endereco" id="endereco" value="<?php echo strtoupper($c['endereco']);?>" type="text" size="35" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.endereco_numero.focus();}">
                                                Número:
                                                <input name="endereco_numero" id="endereco_numero" value="<?php echo strtoupper($c['endereco_numero']);?>" type="text" size="8" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade.focus();}"></td>
                                            </tr>
                                            <tr>
                                              <td width="100">Cidade:</td>
                                              <td><input name="cidade" id="cidade" value="<?php echo $c['cidade'];?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro.focus();}"></td>
                                            </tr>
                                            <tr>
                                              <td width="100">Bairro:</td>
                                              <td><input name="bairro" id="bairro" value="<?php echo $c['bairro'];?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado.focus();}"></td>
                                            </tr>
                                            <tr>
                                              <td width="100">Estado:</td>
                                              <td>
                                                <select name="estado" size="1" id="estado" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}<?php if ($CodigoEmpresa=="86"){?>if(tecla==13){document.cad.ddd.focus();}<?php } ?>" style="z-index: 1000;">
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
                                            <?php if ($CodigoEmpresa=="86"){?>
                                            <tr>
                                              <td width="100">Código IBGE:</td>
                                              <td><input name="codigo_ibge" id="codigo_ibge" value="<?php echo $c['codigo_ibge'];?>" type="text" size="10" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.ddd.focus();}"></td>
                                            </tr>
                                            <?php }else{ ?>
                                             <input name="codigo_ibge" id="codigo_ibge" value="" type="hidden">
                                            <?php } ?>
                                          </table>
                                        </div>
                                      </fieldset>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td width="100">DDD:</td>
                                    <td><input name="ddd" id="ddd" value="<?php echo $c['ddd'];?>" type="text" size="2" maxlength="2" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone.focus();}"></td>
                                  </tr>
                                  <tr>
                                    <td width="100">Fone:</td>
                                    <td><input name="telefone" id="telefone" value="<?php echo $c['telefone'];?>" type="text" size="10" maxlength="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.fax.focus();}"></td>
                                  </tr>
                                  <tr>
                                    <td width="100">Fax:</td>
                                    <td><input name="fax" id="fax" value="<?php echo $c['fax'];?>" type="text" size="10" maxlength="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.codigosuframa.focus();}"></td>
                                  </tr>
                                  <tr>
                                    <td width="100">Cod. Suframa:</td>
                                    <td><input name="codigosuframa" id="codigosuframa" value="<?php echo $c['numero_suframa'];?>" type="text" size="40" maxlength="40" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba(2,4);setTimeout('document.cad.cep_cobranca.focus()',500);}"></td>
                                  </tr>
                                  <?php
                                }
                                ?>
                              </table>
                              <div style="position: absolute; top: 390px; left: 50px;  background: none;" name="Prossiga" id="Prossiga">
                                <?php
                                if ($_REQUEST['cnpj_valido']==1){
                                  ?>
                                  <input type="button" onclick="trocarAba(2,4); " name="Prossiga1" id="Prossiga1" value="Prossiga >>">
                                  <?php
                                }else{
                                  ?>
                                  <input type="button" onclick="checa(document.cad.cnpj.value,'document.cad.cnpj');" name="Prossiga1" id="Prossiga1" value="Prossiga >>">
                                  <?php
                                }
                                ?>
                                <input type="button" onclick="Acha('clientes.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                              </div>
                           </span>
                           <span name="corpo2" id="corpo2" style="display: none; ">
                              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td colspan="2" valign="top">
                                    Opção de endereço:
                                    <?php
                                    if (($c['endereco']==$c['local_cobranca']) and ($c['cidade']==$c['cidade_cobranca'])){
                                      $EndCobranca = " value='checked'";
                                    }else{
                                      $EndCobranca = " ";
                                    }
                                    ?>
                                    <input type="checkbox" name="MesmoCobranca" id="MesmoCobranca" onclick="mesmocobranca();" <?php echo $EndCobranca?>>O mesmo que o principal
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
                                                <input name="cep_cobranca" id="cep_cobranca"  onkeypress="mascara(this,masc_cep)" value="<?php echo $c['cep_cobranca'];?>" type="text" size="10" maxlength="9" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto_cobranca.value==document.cad.cep_cobranca.value){document.cad.endereco_cobranca.focus();}else{acerta_campos('corpo2','boxendereco_cobranca','cep_cobranca.php',true);}}"<?php if($c['local_cobranca']){ echo " onfocus=\"setTimeout('DisableEnableForm(document.corpo2,true);',0);\" onblur=\"setTimeout('DisableEnableForm(document.corpo2,true);',0);\" onclick=\"setTimeout('DisableEnableForm(document.corpo2,true);',0);\"";}?>>
                                              </td>
                                              <td>
                                                <div id="cpanel">
                                                  <div >
                                                   	<div class="icon">
                                                     	<a  href="#" onclick="acerta_campos('divAbaMeio','boxendereco_cobranca','cep_cobranca.php',true);">
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
                                      <div id="boxendereco_cobranca" name="boxendereco_cobranca" style="border:0px;padding=0px;">
                                        <table width="100%" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                          <input type="hidden" name="cep_oculto_cobranca" id="cep_oculto_cobranca">
                                          <!--
                                          <tr>
                                            <td>Endereço:</td>
                                            <td><input name="endereco_cobranca" id="endereco_cobranca" value="<?php echo if_utf8($c['local_cobranca']);?>" type="text" size="50" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_cobranca.focus();}"></td>
                                          </tr>
                                          -->
                                          <tr>
                                            <td>Endereço:</td>
                                            <td>
                                              <input name="endereco_cobranca" id="endereco_cobranca" value="<?php echo if_utf8($c['local_cobranca']);?>" type="text" size="35" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.endereco_cobranca_numero.focus();}">
                                              Número:
                                              <input name="endereco_cobranca_numero" id="endereco_cobranca_numero" value="<?php echo $c['endereco_cobranca_numero'];?>" type="text" size="8" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Cidade:</td>
                                            <td><input name="cidade_cobranca" id="cidade_cobranca" value="<?php echo if_utf8($c['cidade_cobranca']);?>" type="text" size="25" maxlength="25" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Bairro:</td>
                                            <td><input name="bairro_cobranca" id="bairro_cobranca" value="<?php echo if_utf8($c['bairro_cobranca']);?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado_cobranca.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td width="100">Estado:</td>
                                            <td>
                                              <select name="estado_cobranca" size="1" id="estado_cobranca" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_cobranca.focus();}" style="z-index: 1000;">
                                                <option value="<?php echo $c['estado_cobranca'];?>"><?php echo $c['estado_cobranca'];?></option>
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
                                            <td><input name="codigo_ibge_cobranca" id="codigo_ibge_cobranca" value="<?php echo $c['codigo_ibge_cobranca'];?>" type="text" size="10" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.ddd.focus();}"></td>
                                          </tr>
                                          <?php }else{ ?>
                                            <input name="codigo_ibge_cobranca" id="codigo_ibge_cobranca" value="" type="hidden">
                                          <?php } ?>
                                        </table>
                                      </div>
                                    </fieldset>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Fone:</td>
                                  <td><input name="telefone_cobranca" id="telefone_cobranca" value="<?php echo if_utf8($c['tel_cobranca']);?>" type="text" size="10" maxlength="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba(3,4);setTimeout('document.cad.cep_entrega.focus()',500);}"></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><BR>* Atenção, TODOS os dados de Cobrança são obrigatórios!</td>
                                </tr>
                              </table>
                              <div style="position: absolute; top: 390px; left: 50px;  background: none;" name="Prossiga" id="Prossiga">
                                <input type="button" onclick="trocarAba(3,4);" name="Prossiga2" id="Prossiga2" value="Prossiga >>">
                                <input type="button" onclick="Acha('clientes.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                              </div>
                           </span>
                           <span name="corpo3" id="corpo3" style="display: none;">
                              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td colspan="2" valign="top">
                                    Opção de endereço:
                                    <?php
                                    if (($c['endereco']==$c['local_entrega']) and ($c['cidade']==$c['cidade_entrega'])){
                                      $EndEntrega = "  value='checked'";
                                    }else{
                                      $EndEntrega = " ";
                                    }
                                    ?>
                                    <input type="checkbox" name="MesmoEntrega" id="MesmoEntrega" onclick="mesmoentrega();" <?php echo $EndEntrega?>>O mesmo que o principal
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
                                                <input name="cep_entrega" id="cep_entrega" onkeypress="mascara(this,masc_cep)" value="<?php echo $c['cep_entrega'];?>" type="text" size="10" maxlength="9" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){if(document.cad.cep_oculto_entrega.value==document.cad.cep_entrega.value){document.cad.endereco_entrega.focus();}else{acerta_campos('corpo3','boxendereco_entrega','cep_entrega.php',true);}}">
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
                                              <input name="endereco_entrega_numero" id="endereco_entrega_numero" value="<?php echo strtoupper($c['endereco_entrega_numero']);?>" type="text" size="8" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_entrega.focus();}"></td>
                                          </tr>
                                          <tr>
                                            <td>Cidade:</td>
                                            <td><input name="cidade_entrega" id="cidade_entrega" value="<?php echo if_utf8($c['cidade_entrega']);?>" type="text" size="25" maxlength="25" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_entrega.focus();}"></td>
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
                                            <td><input name="codigo_ibge_entrega" id="codigo_ibge_entrega" value="<?php echo $c['codigo_ibge_entrega'];?>" type="text" size="10" maxlength="10" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_entrega.focus();}"></td>
                                          </tr>
                                          <?php }else{ ?>
                                            <input name="codigo_ibge_entrega" id="codigo_ibge_entrega" value="" type="hidden">
                                          <?php } ?>
                                        </table>
                                      </div>
                                    </fieldset>
                                  </td>
                                </tr>
                                <tr>
                                  <td>Fone:</td>
                                  <td><input name="telefone_entrega" id="telefone_entrega" value="<?php echo if_utf8($c['tel_entrega']);?>" type="text" size="10" maxlength="8" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cnpj_entrega.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>CNPJ/CPF:</td>
                                  <td><input name="cnpj_entrega" id="cnpj_entrega" value="<?php echo if_utf8($c['cgc_entrega']);?>" type="number" size="20" maxlength="18" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.inscricao_entrega.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>Insc. Est.:</td>
                                  <td><input name="inscricao_entrega" id="inscricao_entrega" value="<?php echo if_utf8($c['inscricao_entrega']);?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){trocarAba(4,4);<?php if ($CodigoEmpresa=="86"){?>setTimeout('document.cad.codigo_ibge_entrega.focus()',500);<?php } ?>}"></td>
                                </tr>
                              </table>
                              <div style="position: absolute; top: 390px; left: 50px;  background: none;" name="Prossiga" id="Prossiga">
                                <input type="button" onclick="trocarAba(4,4);" name="Prossiga3" id="Prossiga3" value="Prossiga >>">
                                <input type="button" onclick="Acha('clientes.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                              </div>
                           </span>
                           <span name="corpo4" id="corpo4" style="display: none;">
                              <table width="603" border="0" cellspacing="2" cellpadding="2" class="texto1">
                                <tr>
                                  <td>Contato:</td>
                                  <td><input name="contato" id="contato" value="<?php echo if_utf8($c['contato']);?>" type="text" size="20" maxlength="20" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.email.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>E-mail:</td>
                                  <td><input name="email" id="email" value="<?php echo if_utf8($c['email']);?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.email_nfe.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>E-mail NFE:</td>
                                  <td><input name="email_nfe" id="email_nfe" value="<?php echo if_utf8($c['email_nfe']);?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.homepage.focus();}"></td>
                                </tr>
                                <tr>
                                  <td>Home Page:</td>
                                  <td><input name="homepage" id="homepage" value="<?php echo if_utf8($c['homepage']);?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.observacao.focus();}"></td>
                                </tr>
                                <tr>
                                  <td valign="top">Observação:</td>
                                  <td><textarea name="observacao" id="observacao" rows="4" cols="57" onKeyDown="if(this.value.length >= 250){this.value = this.value.substring(0, 250)}" onKeyUp="if(this.value.length >= 50){this.value = this.value.substring(0, 250)}"><?php echo $c['observacao'];?></textarea></td>
                                </tr>
                             </table>
                             <div style="position: absolute; top: 390px; left: 50px;  background: none;" name="Prossiga" id="Prossiga">
                               <input type="button" onclick="if (checa(document.cad.cnpj.value,'document.cad.cnpj')){ acerta_campos('divAbaMeio','Inicio','cadastrar_clientes.php',true)}" name="Gravar" value="Gravar">
                               <input type="button" onclick="Acha('clientes.php','','Conteudo');" name="Cancelar" id="Cancelar" value="Cancelar">
                             </div>
                           </span>
                         </form>
                       </td>
                     </tr>
                   </table>
                 </td>
               </tr>
               <tr>
                 <td><img src="images/l1_r4_c1.gif" width="603" height="4"></td>
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
  include_once("inc/config.php");
  ?>
  <div id="Erro" class="erro" style="position: absolute; width: 250px; top: 250px; left: 60%; margin: 0px; background-color: #eee;">
    <?php
    $cgc = $_REQUEST["cnpj"];
    if (strlen($cgc)<"8"){
      $Erro1 .= "* Verifique o CNPJ / CPF<BR>";
      $_Err = true;
    }elseif (strlen($cgc)<"12"){ //CNPJ pode ter até 12 digitos
      $e_cgc = 0;
    }else{ //> 8 e > 12 tem que ser cpf
      $e_cgc = 1;
      if ($_REQUEST["inscricao"] == "") { $Erro1 .= "* Verifique a Inscrição<BR>"; $_Err = true; }
    }
    ##################################################
    #### Verifica valores ### Campos Obrigatórios ####
    ##################################################
    if ($_REQUEST["nome_cc"]=="")     { $Erro1 .= "* Verifique o Nome<BR>"; $_Err = true;       }
    if ($_REQUEST["endereco"]=="")    { $Erro1 .= "* Verifique o Endereço<BR>"; $_Err = true;   }
    if ($_REQUEST["cidade"]=="")      { $Erro1 .= "* Verifique a Cidade<BR>";  $_Err = true;    }
    if ($_REQUEST["bairro"]=="")      { $Erro1 .= "* Verifique o Bairro<BR>";  $_Err = true;    }
    if (strlen($_REQUEST["bairro"])>20)      { $Erro1 .= "* Verifique o Bairro, ele deve ter até 20 caracteres<BR>";  $_Err = true;    }
    if ($_REQUEST["cep"]=="")         { $Erro1 .= "* Verifique o Cep<BR>";  $_Err = true;       }
    if ($_REQUEST["telefone"]=="")    { $Erro1 .= "* Verifique o Telefone<BR>";  $_Err = true;  }
    if ($_REQUEST["ddd"]=="")         { $Erro1 .= "* Verifique o DDD<BR>";  $_Err = true;       }
    if ($CodigoEmpresa=="86"){
      if ($_REQUEST["codigo_ibge"]=="") {
        $Erro1 .= "* Verifique o código IBGE (ele é carregado automaticamente na busca por CEP)<BR>";
        $_Err = true;
      }
    }
    if (($_REQUEST['estado']=="RO") and (($_REQUEST['cidade']=="GUAJARA MIRIM") or ($_REQUEST['cidade']=="BONFIM")) and $_REQUEST['codigosuframa']==""){
      $Erro1 .= "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AC") and (($_REQUEST['cidade']=="BRASILEIA") or ($_REQUEST['cidade']=="CRUZEIRO DO SUL")or ($_REQUEST['cidade']=="EPITACIOLANDIA")) and $_REQUEST['codigosuframa']==""){
      $Erro1 .= "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AM") and (($_REQUEST['cidade']=="MANAUS") or ($_REQUEST['cidade']=="PRESIDENTE FIGUEIREDO") or ($_REQUEST['cidade']=="RIO PRETO DA EVA")or ($_REQUEST['cidade']=="TABATINGA")) and $_REQUEST['codigosuframa']==""){
      $Erro1 .= "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="AP") and (($_REQUEST['cidade']=="MACAPA") or ($_REQUEST['cidade']=="SANTANA")) and $_REQUEST['codigosuframa']==""){
      $Erro1 .= "* Verifique o Código Suframa"; $_Err = true;
    }elseif (($_REQUEST['estado']=="RR") and ($_REQUEST['cidade']=="PACARAIMA") and $_REQUEST['codigosuframa']==""){
      $Erro1 .= "* Verifique o Código Suframa"; $_Err = true;
    }
    if ($_REQUEST["MesmoCobranca"]){
      if ($_REQUEST['cep_cobranca']=="")     { $Erro2 .= "* Verifique o cep de Cobrança<BR>";      $_Err = true;}
      if ($_REQUEST['endereco_cobranca']==""){ $Erro2 .= "* Verifique o endereço de Cobrança<BR>"; $_Err = true;}
      if ($_REQUEST['cidade_cobranca']=="")  { $Erro2 .= "* Verifique a cidade de Cobrança<BR>";   $_Err = true;}
      if ($_REQUEST['bairro_cobranca']=="")  { $Erro2 .= "* Verifique o bairro de Cobrança<BR>";   $_Err = true;}
      if (strlen($_REQUEST["bairro_cobranca"])>20)      { $Erro1 .= "* Verifique o Bairro de Cobrança, ele deve ter até 20 caracteres<BR>";  $_Err = true;    }
      if ($_REQUEST['estado_cobranca']=="")  { $Erro2 .= "* Verifique o estado de Cobrança<BR>";   $_Err = true;}
      //if ($_REQUEST[endereco_cobranca_numero]=="") { $Erro2 .= "* Verifique o número do endereço de Cobrança<BR>"; $_Err = true;}
      if ($CodigoEmpresa=="86"){
        if ($_REQUEST['codigo_ibge_cobranca']=="") { $Erro2 .= "* Verifique o código IBGE de Cobrança (ele é carregado automaticamente na busca por CEP)<BR>"; $_Err = true;}
      }
    }else{
      if ($_REQUEST['cep']=="")     { $Erro2 .= "* Verifique o cep<BR>";                  $_Err = true;}
      if ($_REQUEST['endereco']==""){ $Erro2 .= "* Verifique o endereço<BR>";             $_Err = true;}
      if ($_REQUEST['cidade']=="")  { $Erro2 .= "* Verifique a cidade<BR>";               $_Err = true;}
      if ($_REQUEST['bairro']=="")  { $Erro2 .= "* Verifique o bairro<BR>";               $_Err = true;}
      if (strlen($_REQUEST["bairro"])>20)      { $Erro1 .= "* Verifique o Bairro, ele deve ter até 20 caracteres<BR>";  $_Err = true;    }
      if ($_REQUEST['estado']=="")  { $Erro2 .= "* Verifique o estado<BR>";               $_Err = true;}
      if ($_REQUEST['endereco_numero']=="") { $Erro2 .= "* Verifique o número do endereço<BR>"; $_Err = true;}
      if ($CodigoEmpresa=="86"){
        if ($_REQUEST['codigo_ibge']=="") { $Erro2 .= "* Verifique o código IBGE (ele é carregado automaticamente na busca por CEP)<BR>"; $_Err = true;}
      }
    }
    if ($_REQUEST["MesmoEntrega"]){
      if ($_REQUEST['cep_entrega']=="")     { $Erro3 .= "* Verifique o cep de Entrega<BR>";      $_Err = true;}
      if ($_REQUEST['endereco_entrega']==""){ $Erro3 .= "* Verifique o endereço de Entrega<BR>"; $_Err = true;}
      if ($_REQUEST['cidade_entrega']=="")  { $Erro3 .= "* Verifique a cidade de Entrega<BR>";   $_Err = true;}
      if ($_REQUEST['bairro_entrega']=="")  { $Erro3 .= "* Verifique o bairro de Entrega<BR>";   $_Err = true;}
      if (strlen($_REQUEST["bairro_entrega"])>20)      { $Erro1 .= "* Verifique o Bairro de Entrega, ele deve ter até 20 caracteres<BR>";  $_Err = true;    }
      if ($_REQUEST['estado_entrega']=="")  { $Erro3 .= "* Verifique o estado de Entrega<BR>";   $_Err = true;}
      if ($_REQUEST['endereco_entrega_numero']=="") { $Erro3 .= "* Verifique o número do endereço de Entrega<BR>"; $_Err = true;}
      if ($CodigoEmpresa=="86"){
        if ($_REQUEST['codigo_ibge_entrega']=="") { $Erro3 .= "* Verifique o código IBGE de Entrega (ele é carregado automaticamente na busca por CEP)<BR>"; $_Err = true;}
      }
    }else{
      if ($_REQUEST['cep']=="")     { $Erro3 .= "* Verifique o cep<BR>";                  $_Err = true;}
      if ($_REQUEST['endereco']==""){ $Erro3 .= "* Verifique o endereço<BR>";             $_Err = true;}
      if ($_REQUEST['cidade']=="")  { $Erro3 .= "* Verifique a cidade<BR>";               $_Err = true;}
      if ($_REQUEST['bairro']=="")  { $Erro3 .= "* Verifique o bairro<BR>";               $_Err = true;}
      if ($_REQUEST['estado']=="")  { $Erro3 .= "* Verifique o estado<BR>";               $_Err = true;}
      if ($_REQUEST['endereco_numero']=="") { $Erro3 .= "* Verifique o número do endereço<BR>"; $_Err = true;}
      if ($CodigoEmpresa=="86"){
        if ($_REQUEST['codigo_ibge']=="") { $Erro3 .= "* Verifique o código IBGE (ele é carregado automaticamente na busca por CEP)<BR>"; $_Err = true;}
      }
    }
    if (!VerificarEmail($_REQUEST["email"]))       { $Erro4 .= "* Informe um E-mail válido<BR>";  $_Err = true;           }
    if (!VerificarEmail($_REQUEST["email_nfe"]))   { $Erro4 .= "* Informe um E-mail NFE válido<BR>";  $_Err = true;       }
    if ($_Err){
      ?>
      <fieldset>
        <legend style="color: red">Erros no cadastro de cliente</legend>
        <?php
        if ($Erro1){
          ?>
          <fieldset>
            <legend style="color: blue">Dados do cliente</legend>
              <?php echo $Erro1;?>
          </fieldset>
          <?php
        }
        if ($Erro2){
          ?>
          <fieldset>
            <legend style="color: blue">Cobrança</legend>
              <?php echo $Erro2;?>
          </fieldset>
          <?php
        }
        if ($Erro3){
          ?>
          <fieldset>
            <legend style="color: blue">Entrega</legend>
              <?php echo $Erro3;?>
          </fieldset>
          <?php
        }
        if ($Erro4){
          ?>
          <fieldset>
            <legend style="color: blue">Outros</legend>
              <?php echo $Erro4;?>
          </fieldset>
          <?php
        }
        ?>
      </fieldset>
      <?php
    }
    if (!$_Err){
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
      $resultado1 = pg_query($db, $achacgc) or die("Erro na consulta : ".$acha_cdr);
      $ccc = pg_num_rows($resultado1);
      if (($_REQUEST[acao]!="Editar") or ($ccc==0)){
        ##########################################
        # Determina ID do cliente se é novo cadastro
        ##########################################
        $acha_id = "SELECT (MAX(id) + 1) as max FROM clientes";
        $resultado = pg_query($db, $acha_id) or die("Erro na consulta : ".$acha_id.pg_last_error($db));
        $row = pg_fetch_object($resultado, 0);
        $id=$row->max;
        $SqlCampo['id'] = $id;
        $SqlCampo['codigo'] = $id;
        $SqlCampo['data_cadastro'] = date("m/d/Y");;
        $SqlCampo['meta_qtd'] = str_replace($teclas,".",$MetaQtd);
        $SqlCampo['meta_valor'] = str_replace($teclas,".",$MetaRs);
        $SqlCampo['limite_credito'] = str_replace($teclas,".",$LimiteCredito);
        $SqlCampo['codigo_vendedor'] = $_SESSION['id_vendedor'];
        $SqlCampo['classificacao_cliente'] = "0";
      }
      $SqlCampo['cgc'] = $_REQUEST['cnpj'];
      $SqlCampo['apelido'] = "upper('".str_replace($teclas,"",left($_REQUEST["apelido"],20))."')";
      $SqlCampo['nome'] = "upper('".str_replace($teclas,"",left($_REQUEST["nome_cc"],50))."')";
      $SqlCampo['endereco'] = "upper('".str_replace($teclas,"",left($_REQUEST["endereco"],50))."')";
      $SqlCampo['cidade'] = "upper('".str_replace($teclas,"",left($_REQUEST["cidade"],25))."')";
      $SqlCampo['bairro'] = "upper('".str_replace($teclas,"",left($_REQUEST["bairro"],20))."')";
      $SqlCampo['estado'] = $_REQUEST['estado'];
      if ($CodigoEmpresa=="86"){
        $SqlCampo['codigo_ibge'] = $_REQUEST['codigo_ibge'];
      }
      $SqlCampo['endereco_numero'] = str_replace($teclas,"",left($_REQUEST["endereco_numero"],20));
      $SqlCampo['cep'] = str_replace($teclas,"", $_REQUEST['cep']);
      $SqlCampo['ddd'] = $_REQUEST['ddd'];
      $SqlCampo['telefone'] = $_REQUEST['telefone'];
      $SqlCampo['fax'] = $_REQUEST['fax'];
      $SqlCampo['vendedor'] = left($_SESSION['usuario'],20);
      $SqlCampo['inscricao'] = str_replace($teclas,"",$_REQUEST["inscricao"]);
      
      if ($CodigoEmpresa=="75"){
        $SqlCampo['tipo_comercio'] = 3;
      }
      
      $SqlCampo['contato'] = "upper('".str_replace($teclas,"",left($_REQUEST["contato"],20))."')";
      $SqlCampo['email'] = "upper('".str_replace($teclas,"",$_REQUEST["email"])."')";
      $SqlCampo['homepage'] = "upper('".str_replace($teclas,"",$_REQUEST["homepage"])."')";
      $SqlCampo['email_nfe'] = "upper('".str_replace($teclas,"",$_REQUEST["email_nfe"])."')";
      $SqlCampo['observacao'] = "upper('".str_replace($teclas,"", $_REQUEST["observacao"])."')";
      $SqlCampo['e_cgc'] = $e_cgc;
      $SqlCampo['numero_suframa'] = $CodigoSuframa;

      $SqlCampo['local_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"endereco":"endereco_cobranca"],50))."')";
      $SqlCampo['endereco_cobranca_numero'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"endereco_numero":"endereco_cobranca_numero"],20))."')";
      $SqlCampo['cidade_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"cidade":"cidade_cobranca"],50))."')";
      $SqlCampo['bairro_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"bairro":"bairro_cobranca"],20))."')";
      $SqlCampo['estado_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"estado":"estado_cobranca"],2))."')";
      $SqlCampo['cep_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"cep":"cep_cobranca"],9))."')";
      $SqlCampo['tel_cobranca'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"telefone":"telefone_cobranca"],14))."')";
      if ($CodigoEmpresa=="86"){
        $SqlCampo['codigo_ibge_cobranca'] = $_REQUEST[codigo_ibge];
      }
      $SqlCampo['cgc_entrega'] = "upper('".str_replace($teclas,"",$_REQUEST[(!$_REQUEST["MesmoCobranca"])?"cnpj":"cnpj_entrega"])."')";
      $SqlCampo['local_entrega'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"endereco":"endereco_entrega"],50))."')";
      $SqlCampo['endereco_entrega_numero'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"endereco_numero":"endereco_entrega_numero"],20))."')";
      $SqlCampo['cidade_entrega'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"cidade":"cidade_entrega"],25))."')";
      $SqlCampo['bairro_entrega'] = "upper('".str_replace($teclas,"",left($_REQUEST[(!$_REQUEST["MesmoCobranca"])?"bairro_entrega":"bairro_entrega"],20))."')";
      $SqlCampo['estado_entrega'] = "upper('".str_replace($teclas,"",$_REQUEST[(!$_REQUEST["MesmoCobranca"])?"estado":"estado_entrega"])."')";
      $SqlCampo['cep_entrega'] = "upper('".str_replace($teclas,"",$_REQUEST[(!$_REQUEST["MesmoCobranca"])?"cep":"cep_entrega"])."')";
      $SqlCampo['inscricao_entrega'] = "upper('".str_replace($teclas,"",$_REQUEST[(!$_REQUEST["MesmoCobranca"])?"inscricao":"inscricao_entrega"])."')";
      $SqlCampo['tel_entrega'] = "upper('".str_replace($teclas,"",$_REQUEST[(!$_REQUEST["MesmoCobranca"])?"telefone":"telefone_entrega"])."')";
      if ($CodigoEmpresa=="86"){
        $SqlCampo['codigo_ibge_entrega'] = $_REQUEST['codigo_ibge_entrega'];
      }

      while( $Campo = each($SqlCampo)){
        if (($_REQUEST['acao']=="Editar") or ($ccc>0)){
          $SqlInicio = "Update clientes set ";
          if (strrpos($Campo['value'], "upper(")===false){
            $SqlExecutar .= " $Campo[key]='".$Campo['value']."',";
          }else{
            $SqlExecutar .= " $Campo[key]=$Campo[value],";
          }
          $SqlFim = " where cgc='".$_REQUEST['cnpj']."'";
          $Msg = "Cliente editado com sucesso";
        }else{
          $SqlInicio = "Insert into clientes (";
          $SqlExecutar .= " $Campo[key],";
          $SqlExecutar2 = " ) VALUES ( ";
          if (strrpos($Campo['value'], "upper(")===false){
            $SqlExecutar3 .= " '$Campo[value]',";
          }else{
            $SqlExecutar3 .= " $Campo[value],";
          }
          $SqlFim = ")";
          $Msg = "Cliente cadastrado com sucesso";
        }
      }
      $Grava = $SqlInicio."".substr($SqlExecutar, 0, -1)."".$SqlExecutar2."".substr($SqlExecutar3, 0, -1)."".$SqlFim;
      //echo $Grava;
      //exit;
      echo "<span class='titulo1'><center>$Msg</center></span>";
      if (!$_Err){
        pg_query ($db,TrocaCaracteres($Grava)) or die ($MensagemDbError.$Grava.pg_query ($db, "rollback"));
      }
    }
    ?>
  </div>
  <?php
}
?>

