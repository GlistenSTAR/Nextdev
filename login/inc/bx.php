<?php
if (isset($_SESSION['usuario'])){
  ?>
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr bgcolor="#EEEEEE">
      <td>
        <div>
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr bgcolor="#EEEEEE">
              <td>
                <table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" class="arial11">
                  <tr bgcolor="#EEEEEE">
                    <td width="180" valign="top">
                    Representação: <b><?php echo isset($_SESSION['usuario'])?$_SESSION['usuario']:'';?></b>
                    </td>
                    <td width="100" valign="top">
                      Base: <b><?php echo $base;?></b>
                    </td>
                    <td width="100" valign="top">
                      <?php
                      if (isset($_SESSION['ultimo_login']) and isset($_SESSION['qtd_entrada_site'])){
                        ?>
                        Total Acessos: <b><?php echo $_SESSION['qtd_entrada_site'];?></b>
                        </td>
                        <td align="right" width="250" valign="top" NOWRAP>
                          Último acesso
                          <b>
                            <?php
                            $ano  = substr($_SESSION['ultimo_login'],  0, 4);
                            $mes  = substr($_SESSION['ultimo_login'],  5, 2);
                            $dia  = substr($_SESSION['ultimo_login'],  8, 2);
                            $hora = substr($_SESSION['ultimo_login'], 11, 8);
                            echo $dia."/".$mes."/".$ano." às ".$hora;
                            ?>
                          </b>
                        </td>
                        <?php
                      }
                      ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  <?php
}
?>
