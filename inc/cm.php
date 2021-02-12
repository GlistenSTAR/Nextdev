<?
include "config.php";
?>
<center>
<div id="preloader" class="texto1">
    <BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
    <blockquote><blockquote>
    <img src="images/carregando.gif" alitn="center">
    <BR>
    <center><BLINK> Carregando...</BLINK></center>
    </blockquote></blockquote>
  <div id="preloadIMG" class="texto1">
  </div>
</div>
</center>
<script language="javascript">
  window.onload = function() { preload(); }
  window.document.write("<style type=\"text/css\">#preloader { display: block !important; }</style>");
</script>
<div id="dhtmltooltip"></div>
<title><? echo ucfirst($_SESSION[bd][descricao]);?> - Sistema de Pedidos ON-LINE </title>
<table width="772" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td background="images/fd_r1_c1.gif" height="10"><img src="images/spacer.gif" width="1" height="2"></td>
  </tr>
  <tr>
    <td valign="top" background="images/fd_r2_c1.gif">
      <table width="758" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <table width="758" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100" align="center">
                  <?
                  if (!$CONF['logotipo_site']){
                    $CONF['logotipo_site'] = "logo_geral.jpg";
                  }
                  ?>
                  <img src="images/<?=$CONF['logotipo_site']?>">
                </td>
                <td width="212"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="20" valign="bottom" class="arial00">
                        <?
                        setlocale(LC_TIME,'pt_BR','ptb');
                        echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
                        if ($IpServer=="10.1.2.200"){echo "<BR>$Host";}
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="arialg"><strong><?=ucfirst($Empresa);?></strong></td>
                    </tr>
                    <tr>
                      <td class="arial00">Base: <strong><?=ucfirst($Db);?></strong></td>
                    </tr>
                  </table>
                </td>
                <td width="446">
                  <table width="446" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="5"><img src="images/tp1_r1_c1.jpg" width="5" height="64"></td>
                      <td background="images/tp1_r1_c2.jpg">
                        <?
                        if (!$_SESSION[usuario]){
                          ?>
                          <table width="420" border="0" align="center" cellpadding="0" cellspacing="0" class="arial11">
                            <tr>
                              <td width="300">
                                <table width="300" border="0" cellpadding="0" cellspacing="0" class="arial11">
                                  <form action="login.php" method="POST" name="login">
                                    <tr>
                                      <td width="100" height="18"><strong>USUARIO</strong></td>
                                      <td width="100" height="18"><strong>SENHA</strong></td>
                                      <td width="60">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td width="100"><input name="usuario" type="text" class="arial00" size="21"></td>
                                      <td width="100"><input name="senha" type="password" class="arial00" size="21"></td>
                                      <td><input type="submit" value=" Ok " name=" Ok " style="background-color: red; border-color: #FFFFFF; color: #FFFFFF; font-weight: bold;"></td>
                                      <!--
                                      <td><img src="images/botao_ok.gif" width="25" height="18"  onclick="document.login.submit();" onmouseover="style.cursor='hand';" style="cursor: pointer;"></td>
                                      <td><img src="images/botao_ok.gif" width="25" height="18"  onclick="Acha('login.php','nome='+document.login.usuario.value+'&senha='+document.login.senha.value+'','Conteudo','Login');" onmouseover="style.cursor='hand';" style="cursor: pointer;"></td>
                                      -->
                                    </tr>
                                  </form>
                                </table>
                              </td>
                              <td width="120">
                                <?
                                if ($CodigoEmpresa=="75"){
                                  ?>
                                  <a href="/boletos">Imprimir boletos</a>
                                  <?
                                }
                                ?>
                              </td>
                            </tr>
                          </table>
                          <?
                        }else{
                          ?>
                          <table width="420" border="0" align="center" cellpadding="0" cellspacing="0" class="arial11">
                            <tr>
                              <td width="280">
                                Olá <b><? echo $_SESSION[usuario];?></b> <a href="inc/verifica.php?acao=SAIR">(sair)</a
                              </td>
                              <td width="150">
                                <?
                                if (($_SESSION[ultimo_login]) and ($_SESSION[qtd_entrada_site])){
                                  ?>
                                  Total Acessos: <b><? echo $_SESSION[qtd_entrada_site];?></b><BR>
                                  </td>
                                  </tr>
                                  <tr>
                                  <td align="right" colspan="2">
                                  Último acesso:
                                  <b>
                                    <?
                                    //if ($CodigoEmpresa=="75"){
                                      $ano  = substr($_SESSION[ultimo_login],  0, 4);
                                      $mes  = substr($_SESSION[ultimo_login],  5, 2);
                                      $dia  = substr($_SESSION[ultimo_login],  8, 2);
                                      $hora = substr($_SESSION[ultimo_login], 11, 8);
                                      echo $dia."/".$mes."/".$ano." às ".$hora;
                                    //}else{
                                    //  echo $_SESSION[ultimo_login];
                                    //}
                                    ?>
                                  </b>
                                  </td>
                                  <?
                                }
                                ?>
                              </td>
                            </tr>
                          </table>
                          <?
                        }
                        ?>
                      </td>
                      <td width="5"><img src="images/tp1_r1_c4.jpg" width="5" height="64"></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td colspan="3"><img src="images/spacer.gif" width="1" height="2"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td><img src="images/linha_menu.gif" width="100%" height="1"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
