<?php
include ("inc/verifica.php");
include_once("inc/config.php");
if ($_REQUEST['cliente_id']){

  $SqlID = pg_query($db,"SELECT id FROM usuarios where cgc='$_REQUEST[cgc_cc]'");
  $ccc = pg_num_rows($SqlID);
  if ($ccc>0){
    echo "<blockquote><HR><BR><BR><font color='#FF0000'>Usuário já habilitado para acesso online.</font></blockquote>";
  }else{
    $SqlInserir = "INSERT INTO usuarios(
                               nome, senha, qtd_acessos, tempo_login, ativo, logado, nivel, cgc)
                   VALUES ('$_REQUEST[cgc_cc]', '$_REQUEST[cliente_id]', '0', '0', '1', '0', '1', '$_REQUEST[cgc_cc]')";
    pg_query($db,$SqlInserir);
    //echo $SqlInserir."<hr>";

    $SqlID = pg_query($db,"SELECT max(id) as maximo FROM usuarios");
    $SqlID = pg_fetch_array($SqlID);
    $SqlInserir2 = "INSERT INTO acesso (
                               id_usuario, id_dados, nivel)
                   VALUES ('$SqlID[maximo]','$_SESSION[base_selecionada_id]','1')";
    pg_query($db,$SqlInserir2);
    //echo $SqlInserir2."<hr>";

    echo "<blockquote><HR><BR><font color='#008000'>Cliente: <b>$_REQUEST[cliente_cc]</b> habilitado para acesso online.</font><BR><BR><BR>";
    echo "Usuário: <b>$_REQUEST[cgc_cc]</b><BR>";
    echo "Senha: <b>$_REQUEST[cliente_id]</b><BR></blockquote>";
  }
}else{
  ?>
  <table class="adminform" width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td>
        <table align="center" width="100%">
          <tr>
            <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $site_url;?>icones/usuarios.png" border="0" align="left">
              <center><h3>Gerenciamento de clientes</h3></center><hr></hr>
            </td>
          </tr>
          <tr>
            <td align="center"><img src="images/spacer.gif" width="1" height="3"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <form name="listar">
          <div id="listar">
            <table border="0" cellspacing="1" cellpadding="4" class="texto1" valign="top" align="center">
              <tr>
                <td colspan="6" valign="top">
                  <table border="1" cellspacing="1" cellpadding="1" class="adminform texto1" valign="top" width="100%">
                    <tr>
                      <td>Cliente:</td>
                      <td colspan="3">
                        <input type="hidden" name="cliente_id" id="cliente_id">
                        <input type="hidden" name="cgc_cc" id="cgc_cc">
                        <input type="text" size="60" name="cliente_cc" id="cliente_cc" value="<?php echo "$_REQUEST[cliente_cc]";?>" onfocus="this.select()" onkeyup="Acha1('listar.php','tipo=cliente&valor='+this.value+'','listar_cliente');">
                        <input type="button" name="Enviar" value="Habilitar" onclick="if(document.getElementById('cliente_id').value){acerta_campos('listar','msg_cliente','gerenciar_clientes.php',false);}else{alert('Selecione um cliente para ativar o acesso online')}">
                        <BR>
                        <div id="listar_cliente" style="position:absolute;"></div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div id="msg_cliente"></div>
          </div>
        </form>
        <?php
        $_SESSION['pagina'] = "inicio.php";
        ?>
      </td>
    </tr>
  </table>
  <?php
}
?>
