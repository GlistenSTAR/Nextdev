<?php
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
$_SESSION['pagina'] = "listar_produtos.php";
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
              <h3>Relat�rio de produtos <i>ON-LINE</i></h3>
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
          <td class="normal" width="60"><b>C�digo: </b></td>
          <td class="normal" width="280"><b>Descri��o: </b></td>
          <td class="normal" width="180"><b>Marca: </b></td>
          <td class="normal" width="20"><b>Modelo: </b></td>
          <td class="normal" width="100"><b>Unidade: </b></td>
          <td class="normal" width="60"><b>Pre�o venda: </b></td>
        </tr>
        <?php
        $pagina = $_REQUEST['pagina'];
        if (!$_SESSION['id_vendedor']){
          $_SESSION['id_vendedor'] = 1;
        }
        $lista = "Select codigo, nome, marca, modelo, unidade, preco_venda from produtos where inativo=0 and produto_venda=1 order by nome ASC";
        $lista1 = pg_query($lista);
        //echo $lista;
        $ccc = pg_num_rows($lista1);
        $total_reg = "20";
        $pagina = $_REQUEST[pagina];
        if (!$pagina){
          $inicio = "0";
          $pc = "1";
          $pagina = 1;
        }else{
          if (is_numeric($pagina)){
            $q_pagina = $ccc / $pagina;
            if ($pagina>$q_pagina){
              $pagina = 1;
            }
          }else{
            $pagina = 1;
          }
          $pc = $pagina;
          $inicio = $pc - 1;
          $inicio = $inicio * $total_reg;
        }
        $sql = "$lista  LIMIT $total_reg OFFSET $inicio";
        $not1  = pg_query($sql);
        //echo $sql;
        while ($r = pg_fetch_array($not1)){
          if ($Cor=="cinza"){
            $Cor="normal";
          }else{
            $Cor="cinza";
          }
          ?>
          <tr>
            <td class="<?php echo $Cor;?>" width="60">
              <a href="#" onclick="Acha('cadastrar_produtos.php','localizar_numero=<?php echo $r['codigo'];?>','Conteudo');">
                <?php echo $r['codigo'];?>
              </a>
            </td>
            <td class="<?php echo $Cor;?>" width="280">
              <a href="#" onclick="Acha('cadastrar_produtos.php','localizar_numero=<?php echo $r['codigo'];?>','Conteudo');">
                &nbsp;<?php echo "$r[nome]";?>
              </a>
            </td>
            <td class="<?php echo $Cor;?>" width="200">&nbsp;<?php echo "$r[marca]";?></td>
            <td class="<?php echo $Cor;?>" width="20">&nbsp;<?php echo "$r[modelo]";?></td>
            <td class="<?php echo $Cor;?>" width="100">&nbsp;<?php echo "$r[unidade]";?></td>
            <td class="<?php echo $Cor;?>" width="60" align="right">&nbsp;<?php echo "$r[preco_venda]";?></td>
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
    </td>
  </tr>
  <tr>
    <td align="center" colspan="7">
      <table width="100%" border="0" class="texto1">
        <?php
        if ($ccc<>""){
          ?>
          <tr>
            <td height="25" align="center">
             <hr>
            <?php
            $anterior = $pc -1;
            $proximo = $pc +1;
            $qtd_paginas = $ccc / $total_reg;
            $ultima_pagina = $pc + 6;
            $primeira_pagina = $pc - 6;
            $anterior = $pc -1;
            $proximo = $pc +1;
            if ($pc>1) {
              echo "<a href='#' onclick=\"Acha('listar_produtos.php','pagina=$anterior&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> <- Anterior </a>";
              echo "  |  ";
            }else{
                echo " <- Anterior ";
                echo "  |  ";
            }
            for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
              echo "<a href='#' onclick=\"Acha('listar_produtos.php','pagina=$p&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\">";
              if ($pc==$p){
                echo "<strong>";
              }
              if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
                echo "$p&nbsp;";
              }else{
                if (!$ret){
                  echo "...";
                  $ret = true;
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
                echo " <a href='#' onclick=\"Acha('listar_produtos.php','pagina=$proximo&ordem=$_REQUEST[ordem]&pos$pos&data_inicial=$_REQUEST[data_inicial]&data_final=$_REQUEST[data_final]','Conteudo');\"> Pr�xima -> </a>";
            }else{
                echo " | ";
                echo " Pr�xima ->";
            }
            ?>
            </td>
          </tr>
          <tr>
            <td height="25" align="center" valign="top"><div>
              <?php
              echo "<div>Mostrando registro <strong>";
              echo $inicio + 1;
              echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong></div>";
              ?>
              </div>
            </td>
          </tr>
          <?php
        }
        ?>
     </table>
    </td>
  </tr>
</table>
