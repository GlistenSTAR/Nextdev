<?php
include ("inc/verifica.php");
$_SESSION['pagina'] = "cadastrar_clientes.php";
if (is_numeric($_REQUEST['localizar_numero'])){
  include_once("inc/config.php");
  $SqlCarregaNoticia = pg_query("Select * from clientes where codigo='".$_REQUEST['localizar_numero']."'");
  $ccc = pg_num_rows($SqlCarregaNoticia);
  if ($ccc<>""){
    $v = pg_fetch_array($SqlCarregaNoticia);
    $Editar = true;
  }
}
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<?php
if (!$_REQUEST['acao']){
  ?>
<table class="adminform" align="center" width="100%" height="600">
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/usuarios.png" border="0" align="left">
      <center><h3>Cadastrar cliente</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <table align="center" cellspacing="0" cellpadding="0" class="texto1">
        <tr>
          <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
        </tr>
    <tr>
      <td valign="top">
        <div id="divAbaGeral" xmlns:funcao="http://www.oracle.com/XSL/Transform/java/com.seedts.cvc.xslutils.XSLFuncao">
          <div id="divAbaMeio">
             <table width="580" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td height="214" valign="top" background="images/l1_r2_c1.gif">
                   <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="592" colspan="3" valign="top">
                         <form action="index.php" name="cad" METHOD="POST">
                           <?php
                           if ($Editar){
                             ?>
                             <input type="hidden" name="acao" value="Editar" id="acao">
                             <input type="hidden" name="codigo" value="<?php echo $v['codigo'];?>" id="codigo">
                             <?php
                           }else{
                             ?>
                             <input type="hidden" name="acao" value="Cadastrar" id="acao">
                             <?php
                           }
                           ?>
                           <input type="hidden" name="pg" value="cadastrar_cliente" id="pg">
                           <span style="" name="corpo1" id="corpo1">
                              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                                <tr>
                                  <td>CNPJ/CPF:</td>
                                  <td><input name="cnpj" value="<?php echo $v['cgc'];?>" id="cnpj" type="text" size="20" maxlength="18" onblur="checa(this.value,'document.cad.cnpj')">
                                </tr>
                                <tr>
                                  <td>Insc. Est.:</td>
                                  <td><input name="inscricao" value="<?php echo $v['inscricao'];?>" id="inscricao"  type="text" size="20" maxlength="20"></td>
                                </tr>
                                <tr>
                                  <td>Apelido:</td>
                                  <td><input name="apelido" id="apelido" value="<?php echo $v['apelido'];?>" type="text" size="60" maxlength="60"></td>
                                </tr>
                                <tr>
                                  <td>Nome:</td>
                                  <td><input name="nome" id="nome" type="text" value="<?php echo $v['nome'];?>" size="60" maxlength="50"></td>
                                </tr>
                                <tr>
                                  <td>Endereço:</td>
                                  <td><input name="endereco" id="endereco" value="<?php echo $v['endereco'];?>" type="text" size="60" maxlength="50"></td>
                                </tr>
                                <tr>
                                  <td>Cidade:</td>
                                  <td><input name="cidade" id="cidade" value="<?php echo $v['cidade'];?>" type="text" size="60" maxlength="30"></td>
                                </tr>
                                <tr>
                                  <td>Bairro:</td>
                                  <td><input name="bairro" id="bairro" value="<?php echo $v['bairro'];?>" type="text" size="60" maxlength="30"></td>
                                </tr>
                                <tr>
                                  <td>Estado:</td>
                                  <td>
                                    <select name="estado" size="1" id="estado">
                                      <option value="<?php echo $v['estado'];?>"><?php echo $v['estado'];?></option>
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
                                <tr>
                                  <td>CEP:</td>
                                  <td><input name="cep" id="cep" value="<?php echo $v['cep'];?>" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Fone:</td>
                                  <td><input name="telefone" id="telefone" value="<?php echo $v['telefone'];?>" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Fax:</td>
                                  <td><input name="fax" id="fax" value="<?php echo $v['fax'];?>" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Comissão:</td>
                                  <td><input name="comissao" id="comissao" value="<?php echo $v['comissao'];?>" dir="rtl" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Meta R$:</td>
                                  <td><input name="meta_rs" id="meta_rs" value="<?php echo $v['meta_rs'];?>" dir="rtl" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Meta Qtd:</td>
                                  <td><input name="meta_qtd" id="meta_qtd" value="<?php echo $v['meta_qtd'];?>" dir="rtl" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Observação:</td>
                                  <td><input name="obs" id="obs" value="<?php echo $v['obs'];?>" type="text" size="55" maxlength="255"></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr></hr></td>
                                </tr>
                                <tr>
                                  <td>Login:</td>
                                  <td><input name="login" id="login" value="<?php echo $v['login'];?>" type="text" size="20" maxlength="10"></td>
                                </tr>
                                <tr>
                                  <td>Senha:</td>
                                  <td><input name="senha" id="senha" value="<?php echo $v['senha'];?>" type="text" size="20" maxlength="10"></td>
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
                 <td><img src="images/l1_r4_c1.gif" width="603" height="4"></td>
               </tr>
               <tr>
                 <td align="center">
                   <input type="button" onclick="if (checa(document.cad.cnpj.value,'document.cad.cnpj')){ acerta_campos('divAbaMeio','Conteudo','cadastrar_cliente.php',true)}" name="Gravar" value="Gravar">
                   <input type="button" onclick="Acha('clientes.php','','Conteudo');" name="Cancelar" value="Cancelar">
                 </td>
               </tr>
               <tr>
                 <td><img src="images/spacer.gif" width="1" height="50"></td>
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
    <BR><BR><BR><BR><BR><BR><BR><BR>
    <?php
    $cgc = $_REQUEST["cnpj"];
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
    if ($_REQUEST["nome"] == "") {
      echo "* Verifique o Nome<BR>";
      $_Err = true;
    }
    if ($_REQUEST["login"] == "") {
      echo "* Verifique o login<BR>";
      $_Err = true;
    }
    if (($_REQUEST["senha"] == "") or (strlen($_REQUEST["senha"])<"3")) {
      echo "* Verifique a senha<BR>";
      $_Err = true;
    }
    if (!$_Err){
      include_once("inc/config.php");
        $DataAtual = date("m/d/Y");
        if (!$_REQUEST['comissao']){ $Comissao = "0"; }else{$Comissao=$_REQUEST['comissao']; }
        if (!$_REQUEST['meta_rs']) { $MetaRs = "0";   }else{$MetaRs = $_REQUEST['meta_rs'];  }
        if (!$_REQUEST['meta_qtd']){ $MetaQtd = "0";  }else{$MetaQtd= $_REQUEST['meta_qtd']; }
        if ($_REQUEST['acao']=="Editar"){
          ##########################################
          #   Insere o vendedor novo
          ##########################################
          $Sql = "Update vendedores set
                    apelido=upper('".str_replace("'","´",$_REQUEST["apelido"])."'),
                    cgc='".$_REQUEST['cnpj']."',
                    bairro=upper('".str_replace("'","´",$_REQUEST["bairro"])."'),
                    nome=upper('".str_replace("'","´",$_REQUEST["nome"])."'),
                    endereco=upper('".str_replace("'","´",$_REQUEST["endereco"])."'),
                    cidade=upper('".str_replace("'","´",$_REQUEST["cidade"])."'),
                    estado='".$_REQUEST['estado']."',
                    cep='".$_REQUEST['cep']."',
                    telefone='".$_REQUEST['telefone']."',
                    fax='".$_REQUEST['fax']."',
                    inscricao='".$_REQUEST['inscricao']."',
                    contato=upper('".str_replace("'","´",$_REQUEST["contato"])."'),
                    email=upper('".str_replace("'","´",$_REQUEST["email"])."'),
                    obs=upper('".str_replace("'","´",$_REQUEST["obs"])."'),
                    e_cgc='".$e_cgc."',
                    meta_valor='".str_replace(",",".",$MetaRs)."',
                    meta_qtd='".str_replace(",",".",$MetaQtd)."',
                    login=upper('".str_replace("'","´",$_REQUEST["login"])."'),
                    senha=upper('".str_replace("'","´",$_REQUEST["senha"])."'),
                    comissao='".$Comissao."'
                  Where codigo='".$_REQUEST['codigo']."'
                 ";
          //echo $Sql;
            ?>
            <span class="titulo1"><center>Vendedor atualizado com sucesso</center></span>
            <?php
        }else{
          ###################################
          # Inicia consulta
          ###################################
          $consulta = "select * from vendedores where cgc = '".$cgc."'";
          $resultado = pg_query($db, $consulta) or die("Erro na consulta : ".$consulta.pg_last.error($db));
          $NumeroLinhas = pg_num_rows($resultado);
          if ($NumeroLinhas != 0) {
            echo "<BR>* Esse CNPJ/CPF já está cadastrado, verifique";
            $_Err = true;
          }else{
            ##########################################
            # Determina ID do cliente
            ##########################################
            $acha_id = "SELECT (MAX(id) + 1) as max FROM vendedores";
            $resultado = pg_query($db, $acha_id) or die("Erro na consulta : ".$acha_id.pg_last_error($db));
            $row = pg_fetch_object($resultado, 0);
            $id=$row->max;
            ##########################################
            #   Insere o vendedor novo
            ##########################################
            $Sql = "Insert Into vendedores (
                      id, codigo,  apelido, cgc, bairro,
                      nome, endereco, cidade, estado,
                      cep, telefone, fax, inscricao,
                      contato, email, obs, e_cgc,
                      meta_valor, meta_qtd, inativo,
                      login, senha, comissao
                    )values(
                      '$id','$id',upper('".str_replace("'","´",$_REQUEST["apelido"])."'),'$_REQUEST[cnpj]', upper('".str_replace("'","´",$_REQUEST["bairro"])."'),
                      upper('".str_replace("'","´",$_REQUEST["nome"])."'),upper('".str_replace("'","´",$_REQUEST["endereco"])."'), upper('".str_replace("'","´",$_REQUEST["cidade"])."'),
                      '$_REQUEST[estado]', '$_REQUEST[cep]','$_REQUEST[telefone]','$_REQUEST[fax]', '$_REQUEST[inscricao]',
                      upper('".str_replace("'","´",$_REQUEST["contato"])."'), upper('".str_replace("'","´",$_REQUEST["email"])."'),
                      upper('".str_replace("'","´",$_REQUEST["obs"])."'), '$e_cgc',
                      '".str_replace(",",".",$MetaRs)."','".str_replace(",",".",$MetaQtd)."',0,
                      upper('".str_replace("'","´",$_REQUEST["login"])."'),upper('".str_replace("'","´",$_REQUEST["senha"])."'),
                      '$Comissao'
                      )
                   ";
            //echo $Sql;
            ?>
            <span class="titulo1"><center>Vendedor cadastrado com sucesso</center></span>
            <?php
          }
        }
        pg_query($db, $Sql);
        pg_close($db);
     }
    ?>
  </div>
  <?php
}
?>
