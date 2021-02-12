<?
include_once("inc/config.php");
$DebugSql = false;
$NumeroCasas = ($CONF['arredondamento']>"100")?"3":"2";
?>
<div id="GrdProdutos">
  <div class="TA1">
  <?
  pg_query ($db, "begin");
  if ($_REQUEST[numero]){
    $numero = $_REQUEST["numero"];
  }elseif($_REQUEST[numero_pedido]){
    $numero = $_REQUEST[numero_pedido];
  }
  if ($_REQUEST[acao]=="excluir"){
    $Excluir = pg_query("delete from itens_do_pedido_internet where codigo='$_REQUEST[codigo]' and numero_pedido='$numero'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
  }
  if ($numero){
      $consulta = "select * from itens_do_pedido_internet where numero_pedido = '".$numero."' AND codigo = '".$_REQUEST[codigo_cc]."' order by especial ASC" ;
      $resultado = pg_query($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      $linha = pg_fetch_array($resultado);
      if ($linha == 0){
        $Opcao = "Novo";
        $erro = 0;
      }else{
        $Opcao = "Editar";
        $erro = 1;
      }
      if (($_REQUEST[codigo_cc]) and ($_REQUEST[qtd_cc])){
        $consulta = "select codigo, nome_do_produto from itens_do_pedido_internet where numero_pedido = '".$numero."' AND codigo = '".$_REQUEST[codigo_cc]."' order by id ASC" ;
		//echo "<b>CONSULTA</b>: " . $consulta . "<br />";
        $resultado = pg_query($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
        $linha = pg_fetch_array($resultado);
        if ($linha == 0){
          $erro = 0;
          $Extra = ($CodigoEmpresa=="75")? " pode_ser_especial, ":"";
          $consulta1 = "select $Extra codigo, inativo, nome from produtos where codigo = '".$_REQUEST[codigo_cc]."'" ;
		 // echo "<b>CONSULTA 1</b>: " . $consulta1;
          $resultado1 = pg_query($db,$consulta1) or die ($MensagemDbError.$consulta1.pg_query ($db, "rollback"));
          $linha1 = pg_fetch_array($resultado1);
          if (($linha1 == 0) or ($linha1[inativo]=="1")){
            $errop = 0;
          }else{
            $errop = 1;
          }
        }else{
          $erro = 1;
        }
      }else{
        $erro=3;
      }
      if (!$_REQUEST[descricao_cc]){
        $_REQUEST[descricao_cc] = $linha1[nome];
      }
      if (!$_REQUEST[descricao_cc]){
        $_REQUEST[descricao_cc] = $linha[nome_do_produto];
      }
      $erro = ($_REQUEST["qtd1_cc"] == "")? "4":"$erro";
      $erro = ($_REQUEST["qtd2_cc"] == "")? "5":"$erro";
      $Ipi = ($_REQUEST["ipi_cc"]=="")? "0":"$_REQUEST[ipi_cc]";
      $_REQUEST[valor_total1_cc] = str_replace(",",".",$_REQUEST[valor_total1_cc]);
      $_REQUEST[valor_unitario1_cc] = str_replace(",",".",$_REQUEST[valor_unitario1_cc]);
      $ValorIpi1 = $_REQUEST[valor_total1_cc] * ($Ipi / 100);
      $_REQUEST[valor_total2_cc] = str_replace(",",".",$_REQUEST[valor_total2_cc]);
      $_REQUEST[valor_unitario2_cc] = str_replace(",",".",$_REQUEST[valor_unitario2_cc]);
      // Corrigindo o bug no preco_alterado
      // 20/02/2009
      $Alterado1 = (str_replace(",",".",$_REQUEST[unit1_original])!=str_replace(",",".",$_REQUEST[valor_unitario1_cc]))?"S":"N";
      $Alterado2 = (str_replace(",",".",$_REQUEST[unit2_original])!=str_replace(",",".",$_REQUEST[valor_unitario2_cc]))?"S":"N";
      //echo "<BR>Alterado1: $Alterado1<BR>";
      //echo "$_REQUEST[unit1_original]!=$_REQUEST[valor_unitario1_cc] - $Alterado1<BR>";
      //echo "$_REQUEST[unit2_original]!=$_REQUEST[valor_unitario2_cc] - $Alterado2<BR>";
      // O ipi deve ser calculado somente na parte normal.
      // E-mail dia 15/01/2009 pela Marcia.
      //$ValorIpi2 = $_REQUEST[valor_total2_cc] * ($Ipi / 100);
      $ValorIpi2 = 0;
      // PESO BRUTO E LIQUIDO 1 E 2
      $PesoBruto1 = str_replace(",",".",$_REQUEST[qtd1_cc]) * str_replace(",",".",$_REQUEST[peso_bruto]);
      $PesoLiquido1 = str_replace(",",".",$_REQUEST[qtd1_cc]) * str_replace(",",".",$_REQUEST[peso_liquido]);
      $PesoBruto2 = str_replace(",",".",$_REQUEST[qtd2_cc]) * str_replace(",",".",$_REQUEST[peso_bruto]);
      $PesoLiquido2 = str_replace(",",".",$_REQUEST[qtd2_cc]) * str_replace(",",".",$_REQUEST[peso_liquido]);
      // VERIFICAÇÃO DO ITEM PARA GRAVAÇÃO
      if (($errop=="1") or ($erro=="1")){ //ERRO nao pode seguir
        if (($Opcao=="Editar") and ($erro!=2)){
          $consulta = $consulta."";
          $consulta = "Update itens_do_pedido_internet set
                         qtd='$_REQUEST[qtd2_cc]',
                         valor_unitario='$_REQUEST[valor_unitario2_cc]',
                         valor_total='$_REQUEST[valor_total2_cc]',
                         ipi='$Ipi',
                         valor_ipi='$ValorIpi2',
                         nome_do_produto='$_REQUEST[descricao_cc]',
                         preco_alterado='$Alterado2',
                         preco_minimo='$_REQUEST[preco_minimo_cc]',
                         preco_venda='$_REQUEST[preco_venda_cc]',
                         peso_bruto='$PesoBruto2',
                         peso_liquido='$PesoLiquido2',
                         qtd_caixa='$_REQUEST[qtd_caixa_cc]' ";
          if (($_REQUEST["desconto11_cc"]) or ($_REQEUST["desconto1_cc"])){
            $consulta = $consulta.", fator1='$_REQUEST[desconto11_cc]'";
          }
          if (($_REQUEST["desconto22_cc"]) or ($_REQEUST["desconto2_cc"])){
            $consulta = $consulta.", fator2='$_REQUEST[desconto22_cc]'";
          }
          $consulta = $consulta." where codigo='$_REQUEST[codigo_cc]' and numero_pedido='$numero' and especial = 1";
          @pg_query ($db,$consulta);
          echo ($DebugSql)? "$consulta":"";
          $consulta = $consulta."";
          $consulta = "Update itens_do_pedido_internet set
                         qtd='$_REQUEST[qtd1_cc]',
                         valor_unitario='$_REQUEST[valor_unitario1_cc]',
                         valor_total='$_REQUEST[valor_total1_cc]',
                         ipi='$Ipi',
                         valor_ipi='$ValorIpi1',
                         nome_do_produto='$_REQUEST[descricao_cc]',
                         preco_alterado='$Alterado1',
                         preco_minimo='".str_replace(",",".",$_REQUEST[preco_minimo_cc])."',
                         preco_venda='".str_replace(",",".",$_REQUEST[preco_venda_cc])."',
                         peso_bruto='$PesoBruto1',
                         peso_liquido='$PesoLiquido1',
                         qtd_caixa='$_REQUEST[qtd_caixa_cc]' ";
          if (($_REQUEST["desconto11_cc"]) or ($_REQEUST["desconto1_cc"])){
            $consulta = $consulta.", fator1='$_REQUEST[desconto11_cc]'";
          }
          if (($_REQUEST["desconto22_cc"]) or ($_REQEUST["desconto2_cc"])){
            $consulta = $consulta.", fator2='$_REQUEST[desconto22_cc]'";
          }
          $consulta = $consulta." where codigo='$_REQUEST[codigo_cc]' and numero_pedido='$numero' and especial = 0";
          @pg_query ($db,$consulta);
          echo ($DebugSql)? "$consulta":"";
         $qtd =$_REQUEST["qtd_cc"];
      }else{
        if (($erro==0) and ($errop==1)){
          // NORMAL
          $consulta = "INSERT INTO itens_do_pedido_internet ";
          $consulta = $consulta." (numero_pedido,codigo,qtd,preco_venda,preco_minimo,valor_unitario,";
          $consulta = $consulta."valor_total,especial,";
          $consulta = $consulta."ipi,valor_ipi,nome_do_produto,preco_alterado,";
          $consulta = $consulta."qtd_caixa, peso_bruto, peso_liquido, ";
          if (($_REQUEST["desconto11_cc"]) or ($_REQUEST["desconto1_cc"])){
            $consulta = $consulta."fator1,";
          }
          $consulta = $consulta." especificado ) values( ";
          $consulta=  $consulta."$numero, '$_REQUEST[codigo_cc]', $_REQUEST[qtd1_cc], '$_REQUEST[preco_venda_cc]', '$_REQUEST[preco_minimo_cc]',";
          $consulta = $consulta."'$_REQUEST[valor_unitario1_cc]', ";
          $consulta = $consulta."'$_REQUEST[valor_total1_cc]', 0, ";
          $consulta = $consulta."'$Ipi', '$ValorIpi1', '$_REQUEST[descricao_cc]', ";
          $consulta = $consulta."'$Alterado1', '$_REQUEST[qtd_caixa_cc]', '$PesoBruto1', '$PesoLiquido1', ";
          if (($_REQUEST["desconto11_cc"]) or ($_REQUEST["desconto1_cc"])){
            if ($_REQUEST["desconto11_cc"]){
              $consulta = $consulta."'".str_replace("'","´",$_REQUEST[desconto11_cc])."', "; //Desconto do Item
            }elseif ($_REQUEST["desconto1_cc"]){
              $consulta = $consulta."'".str_replace("'","´",$_REQUEST[desconto1_cc])."', ";  //Desconto do Pedido
            }else{
              $consulta = $consulta."'', ";
            }
          }
          $consulta = $consulta."0 ) ";
          pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          echo ($DebugSql)? "$consulta":"";
          // Especial
          if ($_REQUEST[desconto]){
            $consulta = "INSERT INTO itens_do_pedido_internet ";
            $consulta = $consulta." (numero_pedido,codigo,qtd,preco_venda,preco_minimo,valor_unitario,";
            $consulta = $consulta."valor_total,especial,";
            $consulta = $consulta."ipi,valor_ipi,nome_do_produto,preco_alterado,";
            $consulta = $consulta."qtd_caixa, peso_bruto, peso_liquido, ";
            if (($_REQUEST["desconto22_cc"]) or ($_REQUEST["desconto2_cc"])){
              $consulta = $consulta."fator2,";
            }
            $consulta = $consulta." especificado ) values( ";
            $consulta=  $consulta."$numero, '$_REQUEST[codigo_cc]', $_REQUEST[qtd2_cc], '$_REQUEST[preco_venda_cc]', '$_REQUEST[preco_minimo_cc]'";
            $consulta = $consulta.",'$_REQUEST[valor_unitario2_cc]', ";
            $consulta = $consulta."'$_REQUEST[valor_total2_cc]', ";
            $consulta = $consulta."'1', '$Ipi', '$ValorIpi2', '$_REQUEST[descricao_cc]'";
            $consulta = $consulta.",'$Alterado2', '$_REQUEST[qtd_caixa_cc]', '$PesoBruto2', '$PesoLiquido2', ";
            if (($_REQUEST["desconto22_cc"]) or ($_REQUEST["desconto2_cc"])){
              if (($_REQUEST["desconto22_cc"]) or ($_REQUEST["desconto2_cc"])){
                if ($_REQUEST["desconto22_cc"]){
                  $consulta = $consulta."'".str_replace("'","´",$_REQUEST[desconto22_cc])."', "; //Desconto do Item
                }elseif ($_REQUEST["desconto2_cc"]){
                  $consulta = $consulta."'".str_replace("'","´",$_REQUEST[desconto2_cc])."', ";  //Desconto do Pedido
                }else{
                  $consulta = $consulta."'', ";
                }
              }
            }
            $consulta = $consulta."0 ) ";

            if ($CodigoEmpresa=="75"){
              if ($linha1[pode_ser_especial]=="1"){
                pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
              }elseif ($_SESSION[vende_qualquer_produto]=="1"){
                pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
              }
            }else{            
              pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
            }
            echo ($DebugSql)? "$consulta":"";
          }
          $qtd =$_REQUEST["qtd_cc"];
        }
      }
    }

    if ($_REQUEST[optcores]=="false"){
      $_SESSION[UltimoTemCores] = false;
    }
    if (($_REQUEST[optcores]=="false") and ($CodigoEmpresa=="86")){ // Perfil
      //   Gravação das cores baseado no cálculo por produto NORMAL
      ## abre a base para pegar as % de cores
      $Consulta2 = "select * from produtos where codigo = '$_REQUEST[codigo_cc]'" ;
      $Resultado2 = pg_query($db,$Consulta2) or die("Erro na consulta : $Consulta2. " .pg_last_error($db));
      $Linha = pg_fetch_array($Resultado2);
      $preto = 0;
      $branco = 0;
      $azul = 0;
      $verde = 0;
      $vermelho = 0;
      $amarelo = 0;
      $marrom = 0;
      $cinza = 0;
      $laranja = 0;
      $rosa = 0;
      $violeta = 0;
      $bege = 0;
      $outra = 0;
      $qtd = $_REQUEST[qtd1_cc];
      $qtd_verifica = $qtd;
      $SOMA_TUDO= 0;
      $Consulta3 = "select codigo from itens_do_pedido_internet where numero_pedido = '$numero' and codigo='$_REQUEST[codigo_cc]' and
      (preto>0 or branco>0 or azul>0 or verde>0 or vermelho>0 or amarelo>0 or marrom>0 or cinza>0 or laranja>0 or rosa>0 or violeta>0 or bege>0 or outra>0)" ;
      $Resultado3 = pg_query($db,$Consulta3) or die("Erro na consulta : $Consulta3. " .pg_last_error($db));
      $LinhaCores = pg_num_rows($Resultado3);
      //echo "<hr>SQL: $Consulta3<BR>";
      //echo "<BR>Linhas: $LinhaCores<hr>";
      if ($LinhaCores==0){
        if ($Linha["tem_divisao"] == 1) {
            if ($qtd_verifica > 0) {
               if ($Linha["preto"] <> "" and $Linha["preto"] <> "0") {
                  $preto = round($qtd*$Linha['preto']/100);
                  $SOMA_TUDO = $preto;
                  $ultima_cor = "preto";
                  $qtd_verifica = $qtd_verifica - $preto;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["branco"] <> "" and $Linha["branco"] <> "0") {
                  $branco = round($qtd*$Linha['branco']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $branco;
                  $ultima_cor = "branco";
                  $qtd_verifica = $qtd_verifica - $branco;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["azul"] <> "" and $Linha["azul"] <> "0") {
                  $azul = round($qtd*$Linha['azul']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $azul;
                  $ultima_cor = "azul";
                  $qtd_verifica = $qtd_verifica - $azul;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["verde"] <> "" and $Linha["verde"] <> "0") {
                  $verde = round($qtd*$Linha['verde']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $verde;
                  $ultima_cor = "verde";
                  $qtd_verifica = $qtd_verifica - $verde;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["vermelho"] <> "" and $Linha["vermelho"] <> "0") {
                  $vermelho = round($qtd*$Linha['vermelho']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $vermelho;
                  $ultima_cor = "vermelho";
                  $qtd_verifica = $qtd_verifica - $vermelho;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["amarelo"] <> "" and $Linha["amarelo"] <> "0") {
                  $amarelo = round($qtd*$Linha['amarelo']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $amarelo;
                  $ultima_cor = "amarelo";
                  $qtd_verifica = $qtd_verifica - $amarelo;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["marrom"] <> "" and $Linha["marrom"] <> "0") {
                  $marrom = round($qtd*$Linha['marrom']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $marrom;
                  $ultima_cor = "marrom";
                  $qtd_verifica = $qtd_verifica - $marrom;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["cinza"] <> "" and $Linha["cinza"] <> "0") {
                  $cinza = round($qtd*$Linha['cinza']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $cinza;
                  $ultima_cor = "cinza";
                  $qtd_verifica = $qtd_verifica - $cinza;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["laranja"] <> "" and $Linha["laranja"] <> "0") {
                  $laranja = round($qtd*$Linha['laranja']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $laranja;
                  $ultima_cor = "laranja";
                  $qtd_verifica = $qtd_verifica - $laranja;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["rosa"] <> "" and $Linha["rosa"] <> "0") {
                  $rosa = round($qtd*$Linha['rosa']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $rosa;
                  $ultima_cor = "rosa";
                  $qtd_verifica = $qtd_verifica - $rosa;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["violeta"] <> "" and $Linha["violeta"] <> "0") {
                  $violeta = round($qtd*$Linha['violeta']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $violeta;
                  $ultima_cor = "violeta";
                  $qtd_verifica = $qtd_verifica - $violeta;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["bege"] <> "" and $Linha["bege"] <> "0") {
                  $bege = round($qtd*$Linha['bege']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $bege;
                  $ultima_cor = "bege";
                  $qtd_verifica = $qtd_verifica - $bege;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["outra"] <> "" and $Linha["outra"] <> "0") {
                  $outra = round($qtd*$Linha['outra']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $outra;
                  $ultima_cor = "outra";
                  $qtd_verifica = $qtd_verifica - $outra;
               }
            }
           #####################################################################
           if ($ultima_cor == "branco") {
              $branco = $qtd - $preto;
           }
           if ($ultima_cor == "azul") {
              $azul = $qtd - $preto - $branco;
           }
           if ($ultima_cor == "verde") {
              $verde = $qtd - $preto - $branco - $azul;
           }
           if ($ultima_cor == "vermelho") {
              $vermelho = $qtd - $preto - $branco - $azul - $verde;
           }
           if ($ultima_cor == "amarelo") {
              $amarelo = $qtd - $preto - $branco - $azul - $verde - $vermelho;
           }
           if ($ultima_cor == "marrom") {
              $marrom = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo;
           }
           if ($ultima_cor == "cinza") {
              $cinza = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom;
           }
           if ($ultima_cor == "laranja") {
              $laranja = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza;
           }
           if ($ultima_cor == "rosa") {
              $rosa = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja;
           }
           if ($ultima_cor == "violeta") {
              $violeta = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa;
           }
           if ($ultima_cor == "bege") {
              $outra = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa - $violeta;
           }
           if ($ultima_cor == "outra") {
              $outra = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa - $violeta - $bege;
           }
           //insere na tabela
           $consulta = "UPDATE itens_do_pedido_internet set ";
           if ($preto <> "") {
              $consulta = $consulta."preto =$preto, ";
           }
           if ($branco <> "") {
              $consulta = $consulta."branco =$branco, ";
           }
           if ($azul <> "") {
              $consulta = $consulta."azul =$azul, ";
           }
           if ($verde <> "") {
              $consulta = $consulta."verde =$verde, ";
           }
           if ($vermelho <> "") {
              $consulta = $consulta."vermelho =$vermelho, ";
           }
           if ($amarelo <> "") {
              $consulta = $consulta."amarelo =$amarelo, ";
           }
           if ($marrom <> "") {
              $consulta = $consulta."marrom =$marrom, ";
           }
           if ($cinza <> "") {
              $consulta = $consulta."cinza =$cinza, ";
           }
           if ($laranja <> "") {
              $consulta = $consulta."laranja =$laranja, ";
           }
           if ($rosa <> "") {
              $consulta = $consulta."rosa =$rosa, ";
           }
           if ($violeta <> "") {
              $consulta = $consulta."violeta =$violeta, ";
           }
           if ($bege <> "") {
              $consulta = $consulta."bege =$bege, ";
           }
           if ($outra <> "") {
              $consulta = $consulta."outra =$outra, ";
           }
           $consulta = $consulta."especificado=0 ";
           $consulta = $consulta." WHERE numero_pedido=".$numero." AND codigo='$_REQUEST[codigo_cc]' and especial='0'";
           pg_query ($db,$consulta);
           //echo $consulta;
        //   Gravação das cores baseado no cálculo por produto ESPECIAL
        ## abre a base para pegar as % de cores
        $Consulta2 = "select * from produtos where codigo = '$_REQUEST[codigo_cc]'" ;
        $Resultado2 = pg_query($db,$Consulta2) or die("Erro na consulta : $Consulta2. " .pg_last_error($db));
        $Linha = pg_fetch_array($Resultado2);
        $preto = 0;
        $branco = 0;
        $azul = 0;
        $verde = 0;
        $vermelho = 0;
        $amarelo = 0;
        $marrom = 0;
        $cinza = 0;
        $laranja = 0;
        $rosa = 0;
        $violeta = 0;
        $bege = 0;
        $outra = 0;
        $qtd = $_REQUEST[qtd2_cc];
        $qtd_verifica = $qtd;
        $SOMA_TUDO= 0;
        if ($Linha["tem_divisao"] == 1) {
            if ($qtd_verifica > 0) {
               if ($Linha["preto"] <> "" and $Linha["preto"] <> "0") {
                  $preto = round($qtd*$Linha['preto']/100);
                  $SOMA_TUDO = $preto;
                  $ultima_cor = "preto";
                  $qtd_verifica = $qtd_verifica - $preto;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["branco"] <> "" and $Linha["branco"] <> "0") {
                  $branco = round($qtd*$Linha['branco']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $branco;
                  $ultima_cor = "branco";
                  $qtd_verifica = $qtd_verifica - $branco;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["azul"] <> "" and $Linha["azul"] <> "0") {
                  $azul = round($qtd*$Linha['azul']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $azul;
                  $ultima_cor = "azul";
                  $qtd_verifica = $qtd_verifica - $azul;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["verde"] <> "" and $Linha["verde"] <> "0") {
                  $verde = round($qtd*$Linha['verde']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $verde;
                  $ultima_cor = "verde";
                  $qtd_verifica = $qtd_verifica - $verde;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["vermelho"] <> "" and $Linha["vermelho"] <> "0") {
                  $vermelho = round($qtd*$Linha['vermelho']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $vermelho;
                  $ultima_cor = "vermelho";
                  $qtd_verifica = $qtd_verifica - $vermelho;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["amarelo"] <> "" and $Linha["amarelo"] <> "0") {
                  $amarelo = round($qtd*$Linha['amarelo']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $amarelo;
                  $ultima_cor = "amarelo";
                  $qtd_verifica = $qtd_verifica - $amarelo;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["marrom"] <> "" and $Linha["marrom"] <> "0") {
                  $marrom = round($qtd*$Linha['marrom']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $marrom;
                  $ultima_cor = "marrom";
                  $qtd_verifica = $qtd_verifica - $marrom;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["cinza"] <> "" and $Linha["cinza"] <> "0") {
                  $cinza = round($qtd*$Linha['cinza']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $cinza;
                  $ultima_cor = "cinza";
                  $qtd_verifica = $qtd_verifica - $cinza;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["laranja"] <> "" and $Linha["laranja"] <> "0") {
                  $laranja = round($qtd*$Linha['laranja']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $laranja;
                  $ultima_cor = "laranja";
                  $qtd_verifica = $qtd_verifica - $laranja;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["rosa"] <> "" and $Linha["rosa"] <> "0") {
                  $rosa = round($qtd*$Linha['rosa']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $rosa;
                  $ultima_cor = "rosa";
                  $qtd_verifica = $qtd_verifica - $rosa;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["violeta"] <> "" and $Linha["violeta"] <> "0") {
                  $violeta = round($qtd*$Linha['violeta']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $violeta;
                  $ultima_cor = "violeta";
                  $qtd_verifica = $qtd_verifica - $violeta;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["bege"] <> "" and $Linha["bege"] <> "0") {
                  $bege = round($qtd*$Linha['bege']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $bege;
                  $ultima_cor = "bege";
                  $qtd_verifica = $qtd_verifica - $bege;
               }
            }
            if ($qtd_verifica > 0) {
               if ($Linha["outra"] <> "" and $Linha["outra"] <> "0") {
                  $outra = round($qtd*$Linha['outra']/100);
                  $SOMA_TUDO = $SOMA_TUDO + $outra;
                  $ultima_cor = "outra";
                  $qtd_verifica = $qtd_verifica - $outra;
               }
            }
           #####################################################################
           if ($ultima_cor == "branco") {
              $branco = $qtd - $preto;
           }
           if ($ultima_cor == "azul") {
              $azul = $qtd - $preto - $branco;
           }
           if ($ultima_cor == "verde") {
              $verde = $qtd - $preto - $branco - $azul;
           }
           if ($ultima_cor == "vermelho") {
              $vermelho = $qtd - $preto - $branco - $azul - $verde;
           }
           if ($ultima_cor == "amarelo") {
              $amarelo = $qtd - $preto - $branco - $azul - $verde - $vermelho;
           }
           if ($ultima_cor == "marrom") {
              $marrom = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo;
           }
           if ($ultima_cor == "cinza") {
              $cinza = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom;
           }
           if ($ultima_cor == "laranja") {
              $laranja = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza;
           }
           if ($ultima_cor == "rosa") {
              $rosa = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja;
           }
           if ($ultima_cor == "violeta") {
              $violeta = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa;
           }
           if ($ultima_cor == "bege") {
              $outra = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa - $violeta;
           }
           if ($ultima_cor == "outra") {
              $outra = $qtd - $preto - $branco - $azul - $verde - $vermelho - $amarelo - $marrom - $cinza - $laranja - $rosa - $violeta - $bege;
           }
           //insere na tabela
           $consulta = "UPDATE itens_do_pedido_internet set ";
           if ($preto <> "") {
              $consulta = $consulta."preto =$preto, ";
           }
           if ($branco <> "") {
              $consulta = $consulta."branco =$branco, ";
           }
           if ($azul <> "") {
              $consulta = $consulta."azul =$azul, ";
           }
           if ($verde <> "") {
              $consulta = $consulta."verde =$verde, ";
           }
           if ($vermelho <> "") {
              $consulta = $consulta."vermelho =$vermelho, ";
           }
           if ($amarelo <> "") {
              $consulta = $consulta."amarelo =$amarelo, ";
           }
           if ($marrom <> "") {
              $consulta = $consulta."marrom =$marrom, ";
           }
           if ($cinza <> "") {
              $consulta = $consulta."cinza =$cinza, ";
           }
           if ($laranja <> "") {
              $consulta = $consulta."laranja =$laranja, ";
           }
           if ($rosa <> "") {
              $consulta = $consulta."rosa =$rosa, ";
           }
           if ($violeta <> "") {
              $consulta = $consulta."violeta =$violeta, ";
           }
           if ($bege <> "") {
              $consulta = $consulta."bege =$bege, ";
           }
           if ($outra <> "") {
              $consulta = $consulta."outra =$outra, ";
           }
           $consulta = $consulta."especificado=0 ";
           $consulta = $consulta." WHERE numero_pedido=".$numero." AND codigo='$_REQUEST[codigo_cc]' and especial='1'";
           echo ($DebugSql)? "$consulta":"";
           @pg_query ($db,$consulta);
          }
        }
      }
    }
    if ($_SESSION[sql_cores]){
      pg_query($_SESSION[sql_cores]);
      //echo $_SESSION[sql_cores];
      $_SESSION[sql_cores] = "";
    }
    $SqlCarregaItens = "Select codigo, nome_do_produto, qtd, valor_unitario, valor_total, especial from itens_do_pedido_internet where numero_pedido = '$numero' order by id, especial ASC";
    echo ($DebugSql)? "$SqlCarregaItens":"";
    $SqlCarregaItens = pg_query($SqlCarregaItens) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
    $cci = pg_num_rows($SqlCarregaItens);
    if ($cci>0){

    }else{
      $SqlCarregaItens = "Select codigo, nome_do_produto, qtd, valor_unitario, valor_total, especial from itens_do_pedido_vendas where numero_pedido in (Select numero from pedidos where numero_internet='$numero') order by id, especial ASC";
      //echo $SqlCarregaItens;
      $SqlCarregaItens = pg_query($SqlCarregaItens) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      $cci = pg_num_rows($SqlCarregaItens);
    }
      ?>
      <table cellspacing="0" cellpadding="0" border="0" class="texto1" width="100%">
        <tr>
          <td width="70"><b>Código</b></td>
          <td width="290">&nbsp;<b>Nome</b></td>
          <td width="50" align="center"><b>Qtd</b></td>
          <td width="60" align="center"><b>Vl. Unit.</b></td>
          <td width="60" align="center"><b>Vl. Tot.</b></td>
          <td width="25" align="center"><b>&nbsp;Editar&nbsp;</b></td>
          <td width="25" align="center"><b>&nbsp;Excluir&nbsp;</b></td>
        </tr>
        <?
        while ($r = pg_fetch_array($SqlCarregaItens)){
          // Confere se tem especial para liberar o campo desconto novamente.
          if ($cci==1){ //Não é especial e tem uma linha só.
            $LiberaDesconto = " document.getElementById('boxdesconto').innerHTML='';document.ped.desconto.style.display='block';InverteEstado('opcoes_empresa');";
          }elseif ($cci==2){
            $SqlConfereEspecial = pg_query("Select codigo from itens_do_pedido_internet where numero_pedido = '$numero' and codigo='$r[codigo]' and especial='1'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
            $cce = pg_num_rows($SqlConfereEspecial);
            if ($cce>0){
              $LiberaDesconto = " document.getElementById('boxdesconto').innerHTML='';document.ped.desconto.style.display='block';InverteEstado('opcoes_empresa');";
            }
          }
          $Cor = ($Cor=="FFFFFF")? "EEEEEE":"FFFFFF";
          ?>
          <tr bgcolor="<? echo $Cor;?>">
            <td width="70" class="item" <? if ($r[especial]==1){ echo "bgcolor='#FFC0C0'";}?>>&nbsp;<b><? echo "$r[codigo]";?></b></td>
            <td width="290" class="item">&nbsp;<? echo "$r[nome_do_produto]";?></td>
            <td width="50" class="item" align="right"><b><? echo "$r[qtd]";?></b>&nbsp;</td>
            <td width="60" class="item" align="right">
              <?
              echo FormataCasas($r[valor_unitario],$NumeroCasas,false);
              ?>
              &nbsp;
            </td>
            <td width="60" class="item" align="right"><b>
               <?
               echo FormataCasas($r[valor_total],2,false); //O total não formata em 3 casas
               ?>
               </b>&nbsp;
            </td>
            <td width="25" class="item" align="center">
              <?
              if (!$_SESSION[enviado]){
                ?>
                <img src="icones/alterar.gif" align="center" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para editar o ítem" onclick="Acha('editar_itens.php', 'numero=<? echo $numero;?>&codigo=<? echo $r[codigo]; ?>&especial=<? echo $r[especial];?>&desconto='+document.ped.desconto.value+'&fator1='+document.ped.desconto1_cc.value+'&fator2='+document.ped.desconto2_cc.value+'', 'itens')">
                <?
              }
              ?>
            </td>
            <td width="25" class="item" align="center">
              <?
              if (!$_SESSION[enviado]){
                ?>
                <img src="icones/excluir.png" align="center" style="border: 0pt none ; cursor: pointer;" border="0" title="Clique para excluir o ítem" onclick="if (confirm('Deseja realmente excluir o ítem - <? echo $r[codigo];?>?')){ Acha('incluir_itens.php', 'acao=excluir&numero=<? echo $numero;?>&codigo=<? echo $r[codigo]; ?>', 'GrdProdutos'); <? echo $LiberaDesconto;?> }">
                <?
              }
              ?>
            </td>
          </tr>
          <?
          if ($r[especial]==0){
            //Só tem Ipi o Normal
            $ValorIpi = $i[valor_total] * ($i[ipi] / 100);
            $TotalIpi = $TotalIpi + $ValorIpi;
            $TotalPedido1 = $TotalPedido1 + $r[valor_total];
          }else{
            $TotalPedido2 = $TotalPedido2 + $r[valor_total];
          }
          $TotalPedidoGeral = $TotalPedidoGeral + $r[valor_total];
          $i++;
        }
        if (($TotalPedido1) and ($TotalPedidoGeral)){
          $SqlAtualizaTotalPedido = pg_query("Update pedidos_internet_novo set total_com_desconto='$TotalPedido1', total_sem_desconto='$TotalPedidoGeral' where numero = $numero");
        }
        ?>
      </table>
      <?
    }else{
      ?>
      <BR><BR><center><b>Este pedido não contém itens.</b></center>
      <?
    }
    if ($erro == 1){
      ?>
      <BR><BR><center><b>Este item ja existe no pedido, os dados foram editados.</b></center>
      <?
    }
    if ($erro == 2){
      ?>
      <BR><BR><center><b>Digite as quantidades do produto!</b></center>
      <?
    }
    pg_query ($db, "commit");
  //}else{
    //echo "Digite o número do Pedido";
  //}
  ?>
  </div>
  <div class="TOTAL" style="position: absolute; float: right; left: 300px; top: 360px; height: 20px; width: 290px; border: 0px solid #000000; background: none;">
    <table cellspacing="0" cellpading="0" border="0" class="texto1" align="right">
      <?
      if ($TotalPedido2){
        ?>
        <tr>
          <td align="right" valign="top" colspan="3"><b>Total 1:</b>&nbsp;</td>
          <td valign="top" colspan="2" align="right" class="texto1"> R$<input style="border: 0px;" class="texto1" type="button" name="botao_total1" id="botao_total1" value="<? echo FormataCasas($TotalPedido1,2,false);?>"></b>&nbsp;</td>
          <td align="right" valign="top" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="top" colspan="3"><b>Total 2:</b>&nbsp;</td>
          <td valign="top" colspan="2" align="right"> R$<input style="border: 0px;" class="texto1" type="button" name="botao_total2" id="botao_total2" value="<? echo FormataCasas($TotalPedido2,2,false);?>"></b>&nbsp;</td>
          <td align="right" valign="top" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td align="right" valign="top" colspan="3"><b>Total Geral(1+2):</b>&nbsp;</td>
          <td valign="top" colspan="2" align="right">R$<input style="border: 0px;" class="texto1" type="button" name="botao_total" id="botao_total" value="<? echo FormataCasas($TotalPedidoGeral,2,false);?>"></b>&nbsp</td>
          <td align="right" valign="top" colspan="3">&nbsp;</td>
        </tr>
        <?
        $SqlAtualizaPedido = pg_query("Update pedidos set total_com_desconto='".str_replace(",", ".", $TotalPedidoGeral)."' where numero='$numero'");
      }else{
        ?>
        <tr>
          <td align="right" valign="top" colspan="3"><b>Total 1:</b>&nbsp;</td>
          <td valign="top" colspan="2" align="right" class="texto1"> R$<input style="border: 0px;" class="texto1" type="button" name="botao_total" id="botao_total" value="<? echo FormataCasas($TotalPedido1,2,false);?>"></b>&nbsp;</td>
          <td align="right" valign="top" colspan="3">&nbsp;</td>
        </tr>
        <?
      }
      ?>
    </table>
  </div>
</div>
<?
pg_close($db);
?>
