<?
//include "inc/verifica.php";
include "inc/config.php";
if ($_REQUEST[data_inicial]){
  $DataInicial = $_REQUEST[data_inicial];
}else{
  //$DataInicial = date("d/m/Y");
  $DataInicial = date("d/m/Y", mktime(0,0,0, date("m")-1, date("d"), date("Y"))); //M�s + 1
}
if ($_REQUEST[data_final]){
  $DataFinal = $_REQUEST[data_final];
}else{
  $DataFinal = date("d/m/Y", mktime(0,0,0, date("m")+1, date("d"), date("Y"))); //M�s + 1
}
if ($_REQUEST[total_reg]){
  $filtrou = true;
}else{
  $filtrou = false;
}
if ($pos=="ASC"){
  $pos1 = "ASC";
  $pos = "DESC";
}else{
  $pos1 = "DESC";
  $pos = "ASC";
}
if ($_REQUEST[ordem]){
  $Ordem = "order by $_REQUEST[ordem] $pos";
}else{
  $Ordem = "order by numero $pos";
}
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
<script>
  function imprimir(){
    document.getElementById('naoimprimir').style.display='none';
    //alert(document.getElementById('nao-imprimir').style.display);
    window.print();
    setTimeout("document.getElementById('naoimprimir').style.display='block';",1000);
  }
</script>
<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">
<body <? if (!$filtrou){ ?> onload="alert('Para filtrar os pedidos por data utilize os campos (Data Inicial e Data Final) no rodap� e clique no bot�o Visualizar.')" <?}?>>
<table width="700" border="0" cellspacing="1" cellpadding="1" class="texto_print">
  <tr>
    <td align="center">
      <table border = "0" width="700" cellspacing="0" cellpadding="0">
        <tr>
          <td width="77">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <td align="left" valign="top" width="200">
              <img src="images/<?=$CONF['logotipo_empresa']?>">
            </td>
          </td>
          <td valign="bottom">
            <span class="arialg"><strong><? echo ucfirst($Empresa);?></strong></span>
          </td>
          <td class="texto_print">
            <center>
              <span class="titulo_print">
                <b>Relat�rio de Pedidos <i>ON-LINE</i></b>
              </span>
            </center>
            <div align="right" class="texto_print">
              <?
              setlocale(LC_TIME,'pt_BR','ptb');
              echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
              ?><BR>
              Vendedor: <b><? echo $_SESSION[usuario];?></b>
            <table class="texto_print">
              <tr>
                <td valign="top">Data Inicial:</td>
                <td valign="top"><b><? echo $DataInicial;?></b>
                <td valign="top">Data Final:</td>
                <td valign="top"><b><? echo $DataFinal;?></b>
              </tr>
            </table>
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
      <table width="700" border="0" cellspacing="1" cellpadding="1" class="texto_print">
        <tr>
          <td width="70"><b>N�mero</b></td>
          <td width="60"><b>Data</b></td>
          <td width="80"><b>CNPJ</b></td>
          <td width="350"><b>Cliente</b></td>
          <td width="80"><b>Valor Total</b></td>
        </tr>
        <?
        if (($_REQUEST[data_inicial]) and ($_REQUEST[data_final])){
          $di = explode("/", $DataInicial);
          $df = explode("/", $DataFinal);
          $FiltroData = " data>='".$di[2]."-".$di[1]."-".$di[0]."' and data<='".$df[2]."-".$df[1]."-".$df[0]."'";
        }else{
          $DataInicial = date("d/m/Y", mktime(0,0,0, date("m"), date("d")-7, date("Y"))); //M�s + 1
          $DataFinal = date("d/m/Y", mktime(0,0,0, date("m"), date("d"), date("Y"))); //M�s + 1
          $FiltroData = " data>='".date("Y-m-d", mktime(0,0,0, date("m"), date("d")-7, date("Y")))."' and data<='".date("Y-m-d", mktime(0,0,0, date("m"), date("d"), date("Y")))."'";
        }
        $pagina = $_REQUEST[pagina];
        if ($_SESSION[nivel]=="2"){

        }else{
          $Filtro = " codigo_vendedor = '$_SESSION[id_vendedor]' and ";
        }
        $lista = "Select numero, data, cliente, cgc, total_com_desconto from pedidos where $Filtro $FiltroData order by data DESC";
        $lista1 = pg_query("Select numero, data, cliente, cgc, total_com_desconto from pedidos where $Filtro $FiltroData order by data DESC");
        $ccc = pg_num_rows($lista1);
        $offset = $_REQUEST[offset];
        if ($_REQUEST[total_reg]){
          if (is_numeric($_REQUEST[total_reg])){
            $total_reg = $_REQUEST[total_reg];
          }elseif ($_REQUEST[total_reg]=="TODOS"){
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
            <td class="<? echo $Cor;?>"><? echo "$r[numero]";?></td>
            <td class="<? echo $Cor;?>">
              <?
              $da = $r[data];
              $d = explode("-", $da);
              echo "".$d[2]."/".$d[1]."/".$d[0]."";
              ?>
            </td>
            <td class="<? echo $Cor;?>"><? echo "$r[cgc]";?></td>
            <td class="<? echo $Cor;?>">
              <?
              $Nome = $r[cliente];
              //if (strlen($Nome)>100) {
              //  $Nome = substr($Nome,0,100)."";
              //}
              echo $Nome;
              ?>
            </td>
            <td class="<? echo $Cor;?>" align="right"><? echo number_format($r[total_com_desconto], 2, ",", ".");?></td>
          </tr>
          <?
          if ($pagina){
            if (!$qtd_registros){
              $qtd_registros = $qtd_registros + $inicio + 1;
            }else{
              $qtd_registros = $qtd_registros +  1;
            }
          }
          $Total = $Total + $r[total_com_desconto];
        }
        ?>
        <tr>
          <td class="<? echo $Cor;?>"></td>
          <td class="<? echo $Cor;?>"></td>
          <td class="<? echo $Cor;?>"></td>
          <td class="<? echo $Cor;?>" align="right"><BR>Total </td>
          <td class="<? echo $Cor;?>" align="right"><hr></hr><? echo number_format($Total, 2, ",", ".");?></td>
        </tr>
      </table>
      <hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center">
      <div id="naoimprimir" style="display: block;">
        <table align="center" width="100%" class="texto_print">
          <tr>
            <td align="center" colspan="2">
              <div id="listagem_clientes">
                <table width="100%" border="0" class="texto_print">
                  <?
                  if ($ccc<>""){
                    ?>
                    <tr>
                      <td height="25" align="center" colspan="2">
                      <?
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      $qtd_paginas = $ccc / $total_reg;
                      $ultima_pagina = $pc + 6;
                      $primeira_pagina = $pc - 6;
                      $anterior = $pc -1;
                      $proximo = $pc +1;
                      if ($pc>1) {
                        echo "<a href='?pagina=$anterior&total_reg=$total_reg&data_inicial=$DataInicial&data_final=$DataFinal'> <- Anterior </a>";
                        echo "  |  ";
                      }else{
                          echo " <- Anterior ";
                          echo "  |  ";
                      }
                      for ($i=0, $p=1; $i<$ccc; $i+=$total_reg, $p++){
                        echo "<a href='?pagina=$p&total_reg=$total_reg&data_inicial=$DataInicial&data_final=$DataFinal'>";
                        if ($pc==$p){
                          echo "<strong>";
                        }
                        if (($p>$primeira_pagina) and ($p<$ultima_pagina)){
                          echo "$p&nbsp;";
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
                          echo " <a href='?pagina=$proximo&total_reg=$total_reg&data_inicial=$DataInicial&data_final=$DataFinal'> Pr�xima -> </a>";
                      }else{
                          echo " | ";
                          echo " Pr�xima ->";
                      }
                      ?>
                      </td>
                    </tr>
                    <div id="paginacao" class="texto_print">
                      <tr>
                        <td height="25" align="center" valign="top" colspan="2"><div>
                          <?
                          echo "<div>Mostrando registro <strong>";
                          echo $inicio + 1;
                          echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong> - P�gina: <b>$pagina</b></div>";
                          ?>
                          </div>
                        </td>
                      </tr>
                    </div>
                    <?
                  }
                  ?>
                </table>
              </div>
            </td>
          </tr>
          <form method="POST" name="limitador">
            <input type="hidden" name="pagina" value="<? echo $pagina;?>">
            <input type="hidden" name="offset" value="<? echo $inicio;?>">
            <tr>
              <td>
                <table class="texto_print">
                    <td valign="top">Data Inicial:</td>
                    <td valign="top"><input name="data_inicial" id="data_inicial"  type="text" size="12" maxlength="20" value="<? echo $DataInicial;?>"></td>
                    <td valign="top">Data Final:</td>
                    <td valign="top"><input name="data_final" id="data_final"  type="text" size="12" maxlength="20" value="<? echo $DataFinal;?>"></td>
                </table>
              </td>
              <td align="center" valign="top">
                <input type="button" value="Visualizar" onclick="document.limitador.submit();" id="todos" name="todos" STYLE="width: 120;font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="total_reg" size="1">
                  <option value="20">20</option>
                  <option value="30">30</option>
                  <option value="40">40</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="TODOS">Todos</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" value="Imprimir" id="botao" name="TESTE" onclick="imprimir(); return false;" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">
              </td>
            </tr>
          </form>
          <tr>
            <td>
              <BR>
              <b>* Para retirar o cabe�alho e o rodap� da p�gina acesse:</b><BR>
              1 - Arquivo/ Configurar p�gina;<BR>
              2 - Retire o conte�do dos campos Cabe�alho e Rodap�;<BR>
              3 - Clique em OK e fa�a a impress�o.
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>
