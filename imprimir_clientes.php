<?
//include "inc/verifica.php";
include "inc/config.php";
?>
<style>
a:link,a:visited{color:#000;text-decoration:none;}
.arialg{font-family:arial;font-size:28px;color:#ED1C24;}
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
<!--<link href="inc/css.css" rel="stylesheet" type="text/css" media="screen">-->
<center>
<table width="950" border="0" cellspacing="1" cellpadding="1" class="texto_print">
  <tr>
    <td align="center">
      <table border = "0" width="950" cellspacing="0" cellpadding="0">
        <tr>

            &nbsp;&nbsp;&nbsp;&nbsp;
            <td align="left" valign="top" width="200">
              <? if ($CONF['logotipo_empresa']){
                  echo "aa<img src='images/$CONF[logotipo_empresa]' border='0'>"; 
                }else{
                  echo "<span class='arialg'><strong>".ucfirst($Empresa)."</strong></span>";
                }
              ?>
            </td>

          <td valign="bottom">
            
          </td>
          <td class="texto_print">
            <div align="right" class="texto_print">
              <?
              setlocale(LC_TIME,'pt_BR','ptb');
              //echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
              echo "Data: <b>".date("d/m/Y")."</b>";
              ?><BR>
              Vendedor: <b><? echo $_SESSION[usuario];?></b>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="5">              
              <span class="titulo_print">Relatório de clientes <i>ON-LINE</i></span><br>
              <hr style="color:#cccccc; height:1px;"></hr>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="950" border="0" cellspacing="1" cellpadding="1" class="texto_print">
        <tr height="30px" bgcolor="#CCC">
          <td width="70"><b>&nbsp;CNPJ</b></td>
          <td width="300"><b>&nbsp;Nome</b></td>
          <td width="200"><b>&nbsp;Endereço</b></td>
          <td width="100"><b>&nbsp;Cidade</b></td>
          <td width="30"><b>&nbsp;Estado</b></td>
          <td width="70"><b>&nbsp;Telefone</b></td>
        </tr>
        <?
        if ($_REQUEST[filtro]){
          if ($_REQUEST[filtro]=="ATIVOS"){
            $Filtro = " AND inativo='0'";
          }elseif ($_REQUEST[filtro]=="INATIVOS"){
            $Filtro = " AND inativo='1'";
          }
        }
        $pagina = $_REQUEST[pagina];
        if ($_SESSION[nivel]=="2"){
          $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where 1=1 $Filtro order by nome ASC";
        }else{
          if($_SESSION[id_vendedor]=="77"){ //Regra Groupack          
             $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '87' $Filtro order by nome ASC";
          }else{
             $lista = "Select nome, endereco, cidade, estado, telefone, cgc from clientes where codigo_vendedor = '$_SESSION[id_vendedor]' $Filtro order by nome ASC";
          }          
        }
        $lista1 = pg_query($lista);
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
          <tr height="18px">
            <td class="<? echo $Cor;?>">&nbsp;<? echo "$r[cgc]";?></td>
            <td class="<? echo $Cor;?>">&nbsp;
              <?
              $Nome = $r[nome];
              //if (strlen($Nome)>100) {
              //  $Nome = substr($Nome,0,100)."";
              //}
              echo $Nome;
              ?>
            </td>
            <td class="<? echo $Cor;?>">&nbsp;<? echo "$r[endereco]";?></td>
            <td class="<? echo $Cor;?>">&nbsp;<? echo "$r[cidade]";?></td>
            <td class="<? echo $Cor;?>">&nbsp;<? echo "$r[estado]";?></td>
            <td class="<? echo $Cor;?>">&nbsp;<? echo "$r[telefone]";?></td>
          </tr>
          <?
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
                  <?
                  if ($ccc<>""){
                    ?>
                    <tr>
                      <td height="25" align="center">
                      <?
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
                          <?
                          echo "<div>Mostrando registro <strong>";
                          echo $inicio + 1;
                          echo "</strong> a <strong>$qtd_registros</strong> de <strong>$ccc</strong> - Página: <b>$pagina</b></div>";
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
              <td align="center" valign="top">
                <input type="button" value="Imprimir" id="botao" name="TESTE" onclick="imprimir(); return false;" STYLE="font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">               
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <select name="total_reg" size="1">
                  <option value="20">Listar 20</option>
                  <option value="30">Listar 30</option>
                  <option value="40">Listar 40</option>
                  <option value="50">Listar 50</option>
                  <option value="100">Listar 100</option>
                  <option value="TODOS">Listar Todos</option>
                </select>
                <input type="button" value="Filtrar" onclick="document.limitador.submit();" id="todos" name="todos" STYLE="width: 120;font-size: 10pt; color:#ffffff ; background:#182463; border-width: 2; border-color: #ffffff">                
              </td>
            </tr>
          </form>
          <tr>
            <td>
              <BR>
              <b>* Para retirar o cabeçalho e o rodapé da página acesse:</b><BR>
              1 - Arquivo/ Configurar página;<BR>
              2 - Retire o conteúdo dos campos Cabeçalho e Rodapé;<BR>
              3 - Clique em OK e faça a impressão.
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>
