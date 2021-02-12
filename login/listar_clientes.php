<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_clientes.php";
?>
<style>
  .cinza {
    color: #666666;
    background-color: #EEEEEE;
    border: 1px dashed #CCCCCC;
  }
  .normal {
    color: #000000;
    background-color: #FFFFFF;
    border: 1px dashed #CCCCCC;
  }
</style>
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="texto1">
  <tr>
    <td align="center">
      <table border = "0" width="700" cellspacing="0" cellpadding="0">
        <tr>
          <td class="texto1">
            <center>
              <h3>Relat�rio de clientes <i>ON-LINE</i></h3>
            </center>
            <div align="right" class="texto1">
              <?php
              setlocale(LC_TIME,'pt_BR','ptb');
              echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
              ?><BR>
              Representação: <b><?php echo $_SESSION['usuario'];?></b>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="3"><hr style="color:#cccccc; height:1px;"></hr></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="1" style="border: 1px dashed #CCCCCC;" cellspacing="0" cellpadding="4" class="texto1">
        <tr>
          <td class="normal" width="230"><b>Nome: </b>
          </td>
          <td class="normal" width="80"><b>CNPJ: </b></td>
          <td class="normal" width="180"><b>Endere�o: </b></td>
          <td class="normal" width="20"><b>UF: </b></td>
          <td class="normal" width="100"><b>Cidade: </b></td>
          <td class="normal" width="60"><b>Telefone: </b></td>
        </tr>
        <?php
        $pagina = $_REQUEST['pagina'];
        if (!$_SESSION['id_vendedor']){
          $_SESSION['id_vendedor'] = 1;
        }
        if ($_SESSION['codigo_empresa']<>"95"){
          $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '".$_SESSION['id_vendedor']."' order by nome ASC";
          $lista1 = pg_query("Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '".$_SESSION['id_vendedor']."' order by nome ASC");
        }else{
          $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor in ('3','43','51','52') order by nome ASC";
          $lista1 = pg_query("Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor in ('3','43','51','52') order by nome ASC");
        }
        //echo $lista;
        $ccc = pg_num_rows($lista1);
        $offset = $_REQUEST['offset'];
        if ($_REQUEST['total_reg']){
          if (is_numeric($_REQUEST['total_reg'])){
            $total_reg = $_REQUEST['total_reg'];
          }elseif ($_REQUEST['total_reg']=="TODOS"){
            $total_reg = $ccc;
            $pagina = "1";
            $offset = "0";
          }
        }else{
          $total_reg = "5000";
        }
        if (!$pagina){
          $inicio = "0";
          $pc = "1";
          $pagina = "1";
        }else{
          if (is_numeric($pagina)){
//            $q_pagina = $ccc / $pagina;
//            if ($pagina>$q_pagina){
//              $pagina = 1;
//            }
          }else{
            $pagina = 1;
          }
          $pc = $pagina;
          $inicio = $pc - 1;
          if ($offset){
            $inicio = $offset;
          }else{
            $inicio = $inicio * $total_reg;
          }
        }
        $sql = "$lista  LIMIT $total_reg OFFSET $inicio";
        //echo $sql;
        $not1  = pg_query($sql);
        while ($r = pg_fetch_array($not1)){
          if ($Cor=="cinza"){
            $Cor="normal";
          }else{
            $Cor="cinza";
          }
          ?>
          <tr>
            <td class="<?php echo $Cor;?>" width="260">
              <?php
              $Nome = $r['nome'];
//              if ($_SESSION['codigo_empresa']<>"95"){
                ?>
                <a href="#" onclick="Acha('cadastrar_clientes.php','localizar_numero=<?php echo $r['cgc'];?>&cnpj_valido=1','Conteudo');">
                  <?php
                  echo $Nome;
                  ?>
                </a>
                <?php
//              }else{
//                echo $Nome;
//              }
              ?>
            </td>
            <td class="<?php echo $Cor;?>" width="80">
              <?php
              if ($_SESSION['codigo_empresa']<>"95"){
                ?>
                <a href="#" onclick="Acha('cadastrar_clientes.php','localizar_numero=<?php echo $r['cgc'];?>&cnpj_valido=1','Conteudo');">
                  <?php echo $r['cgc'];?>
                </a>
                <?php
              }else{
                echo $r['cgc'];
              }
              ?>
            </td>
            <td class="<?php echo $Cor;?>" width="200"><?php echo $r['endereco'];?></td>
            <td class="<?php echo $Cor;?>" width="20"><?php echo $r['estado'];?></td>
            <td class="<?php echo $Cor;?>" width="100"><?php echo $r['cidade'];?></td>
            <td class="<?php echo $Cor;?>" width="60"><?php echo $r['telefone'];?></td>
          </tr>
          <?php
          if ($pagina){
            if (!$qtd_registros){
              $qtd_registros = $qtd_registros + $inicio + 1;
            }else{
              $qtd_registros = $qtd_registros +  1;
            }
          }
        }
        ?>
      </table>
      <hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center">
      <div id="naoimprimir" style="display: block;">
        <table align="center" width="100%" class="texto1">
          <!--
          <tr>
            <td align="center">
              <div id="listagem_clientes">
                <table width="100%" border="0" class="texto1">
                  <?php
                  if ($ccc<>""){
                    ?>
                    <tr>
                      <td height="25" align="center">
                      <?php
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      $qtd_paginas = $ccc / $total_reg;
                      $ultima_pagina = $pc + 6;
                      $primeira_pagina = $pc - 6;
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      if ($pc>1) {
                        echo "<a href='?pagina=$anterior&total_reg=$total_reg'> <- Anterior </a>";
                        echo "  |  ";
                      }else{
                          echo " <- Anterior ";
                          echo "  |  ";
                      }
                      for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                        echo "<a href='?pagina=$p&total_reg=$total_reg'>";
                        if ($pc==$p){
                          echo "<strong>";
                        }
                        if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
                          echo $p."&nbsp;";
                        }else{
                          if (!$ret){
                            echo "...";
                            $ret = true;
                          }else{
                             if (($p>$ultima_pagina) and (!$retfim)){
                               echo "...";
                               $retfim = true;
                             }
                          }
                        }
                        if ($pc==$p){
                          echo "</strong>";
                        }
                        echo "</a>";
                      }
                      $fim = $ccc / $total_reg;
                      if ($pc<$fim) {
                          echo " | ";
                          echo " <a href='?pagina=$proximo&total_reg=$total_reg'> Pr�xima -> </a>";
                      }else{
                          echo " | ";
                          echo " Pr�xima ->";
                      }
                      ?>
                      </td>
                    </tr>
                    <div id="paginacao" class="noPrint">
                      <tr>
                        <td height="25" align="center" valign="top"><div>
                          <?php
                          echo "<div>Mostrando registro <strong>";
                          echo $inicio + 1;
                          echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong> - Página: <b>$pagina</b></div>";
                          ?>
                          </div>
                        </td>
                      </tr>
                    </div>
                    <?php
                  }
                  ?>
                </table>
              </div>
            </td>
          </tr>
          <form method="POST" name="limitador">
            <input type="hidden" name="pagina" value="<?php echo $pagina;?>">
            <input type="hidden" name="offset" value="<?php echo $inicio;?>">
          -->
            <tr>
              <td align="center" valign="top">
                <input type="button" value="Imprimir" id="botao" name="TESTE" onclick="imprimir(); return false;" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
              </td>
            </tr>
          <!--
          </form>
          -->
          <tr>
            <td>
              <BR>
              <b>* Para retirar o cabe�alho e o rodap� da Página acesse:</b><BR>
              1 - Arquivo/ Configurar Página;<BR>
              2 - Retire o conte�do dos campos Cabe�alho e Rodap�;<BR>
              3 - Clique em OK e fa�a a impress�o.<BR>
              <b>**</b> Essa observa��o n�o sair� na impress�o, contanto que o bot�o Imprimir seja clicado.
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>
