<?php
//include "inc/verifica.php";
include ("inc/common.php");
include "inc/config.php";
?>
<style>
  .cinza {
    color: #000000;
    background-color: #EEEEEE;
    font-size: 10px;
  }
  .normal {
    color: #000000;
    background-color: #FFFFFF;
    font-size: 10px;
  }
  .texto_print {
   	font-family: Tahoma;
  	 font-size: 11px;
   	color: #666666;
  }
  .titulo_print {
   	font-family: Tahoma;
  	 font-size: 16px;
   	color: #666666;
  }
</style>
<style type="text/css" media="print">
@page {size: landscape;}

BODY {
size: landscape;
margin: 1;}
	@PAGE landscape	{size: LANDSCAPE;}
	TABLE 		{PAGE: landscape;}
</style>
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<table width="950" border="0" cellspacing="1" cellpadding="1" class="texto_print">
  <tr>
    <td align="center">
      <table border = "0" width="950" cellspacing="0" cellpadding="0">
        <tr>
          <td width="77">
            &nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logo.jpg" width="77" height="62" border="0" align="left">
          </td>
          <td valign="bottom">
            <span class="arialg"><strong>perfil</strong></span>
          </td>
          <td class="texto_print">
            <center>
              <span class="titulo_print">
                Relatório de clientes <i>ON-LINE</i>
              </span>
            </center>
            <div align="right" class="texto_print">
              <?php
              setlocale(LC_TIME,'pt_BR','ptb');
              echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
              ?><BR>
              Vendedor: <b><?php echo $_SESSION['usuario'E];?></b>
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
      <table width="950" border="0" cellspacing="1" cellpadding="1" class="texto_print">
        <tr>
          <td width="70"><b>CNPJ</b></td>
          <td width="300"><b>Nome</b></td>
          <td width="200"><b>Endereço</b></td>
          <td width="100"><b>Cidade</b></td>
          <td width="30"><b>Estado</b></td>
          <td width="70"><b>Telefone</b></td>
        </tr>
        <?php
        $pagina = $_REQUEST['pagina'];
        $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '".$_SESSION['id_vendedor']."' order by nome ASC";
        $lista1 = pg_query("Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '".$_SESSION['id_vendedor']."' order by nome ASC");
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
          $total_reg = "20";
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
          if ($Cor=="normal"){
            $Cor="cinza";
          }else{
            $Cor="normal";
          }
          ?>
          <tr>
            <td class="<?php echo $Cor;?>"><?php echo $r['cgc'];?></td>
            <td class="<?php echo $Cor;?>">
              <?php
              $Nome = $r['nome'];
              //if (strlen($Nome)>100) {
              //  $Nome = substr($Nome,0,100)."";
              //}
              echo $Nome;
              ?>
            </td>
            <td class="<?php echo $Cor;?>"><?php echo $r['endereco'];?></td>
            <td class="<?php echo $Cor;?>"><?php echo $r['cidade'];?></td>
            <td class="<?php echo $Cor;?>"><?php echo $r['estado'];?></td>
            <td class="<?php echo $Cor;?>"><?php echo $r['telefone'];?></td>
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
        <table align="center" width="100%" class="texto_print">
          <tr>
            <td align="center">
              <div id="listagem_clientes">
                <table width="100%" border="0" class="texto_print">
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
                          echo " <a href='?pagina=$proximo&total_reg=$total_reg'> Próxima -> </a>";
                      }else{
                          echo " | ";
                          echo " Próxima ->";
                      }
                      ?>
                      </td>
                    </tr>
                    <div id="paginacao" class="texto_print">
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
            <tr>
              <td align="center" valign="top">
                <input type="button" value="Imprimir" id="botao" name="TESTE" onclick="imprimir(); return false;" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Limitar registros" onclick="document.limitador.submit();" id="todos" name="todos" STYLE="width: 120;font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="total_reg" size="1">
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="TODOS">Todos</option>
                </select>
              </td>
            </tr>
          </form>
          <tr>
            <td>
              <BR>
              <b>* Para retirar o cabeçalho e o rodapé da página acesse:</b><BR>
              1 - Arquivo/ Configurar página;<BR>
              2 - Retire o conteúdo dos campos Cabeçalho e Rodapé;<BR>
              3 - Clique em OK e faça a impressão. <BR
              ** Essa observação não sairá na impressão, contanto que o botão Imprimir seja clicado.
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>
