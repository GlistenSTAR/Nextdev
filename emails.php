<?php
include_once ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$msg = str_replace("<br>", chr(13), $_REQUEST['msg']);
?>
<link href="inc/css.css" rel="stylesheet" type="text/css">
<form name="listar">
  <div id="listar">
    <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td align="center">
          <b>Formulário para envio de e-mails</b>
        </td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
      </tr>
      <tr>
        <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
          <table width="580" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
            <tr>
              <td width="580" colspan="3" valign="top">
                <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                  <tr>
                    <td>
                      <table width="580" border="0" cellspacing="1" cellpadding="2" class="texto1" valign="top">
                        <tr>
                          <td colspan="7" valign="top">
                            <div name="enviar_email" id="enviar_email">
                              <input type="hidden" name="acao" value="enviar" id="acao">
                              <table width="100%" height="100%" border="0" cellspacing="3" cellpadding="0" class="texto1" valign="top">
                                <tr>
                                  <td>De:</td><td><?php echo $_SESSION['usuario'];?> <<?php echo $_SESSION['email'];?>></td>
                                </tr>
                                <tr>
                                  <td>Para:</td><td><input type="text" name="email" value="<?php echo $_REQUEST['email']?>" id="email" size="45"></td>
                                </tr>
                                <tr>
                                  <td>Assunto:</td><td><input type="text" name="assunto" value="<?php echo $_REQUEST['assunto']?>" id="assunto" size="45"></td>
                                </tr>
                                <tr>
                                  <td>Anexar pedido Nº:</td><td><input type="text" name="anexo" value="<?php echo $_REQUEST['anexo']?>" id="anexo" size="45"></td>
                                </tr>
                                <tr>
                                  <td>Mensagem:</td><td><textarea name="msg" id="msg" rows="6" cols="43"><?php echo $msg?></textarea></td>
                                </tr>
                                <tr>
                                  <td colspan="2" align="center">
                                    <input type="button" name="enviar" value="Enviar" id="enviar" onclick="acerta_campos('enviar_email','Inicio','enviar_email.php',false);">
                                  </td>
                                </tr>
                              </table>
                            </div>
                          </tr>
                        </td>
                      </table>
                      <div id="envio_email"></div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
      </tr>
    </table>
  </div>
</form>
<?php
$_SESSION['pagina'] = "emails.php";
?>
