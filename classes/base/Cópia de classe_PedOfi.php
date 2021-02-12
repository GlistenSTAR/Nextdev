<?php
/*
Classe PedOfi

Grava os pedidos da base temporária na base oficial, uma simples troca de tabelas de pedidos_internet para pedidos.

Essa classe é usada em:

cadastrar_pedidos.php

27/11/2007 - Emerson - Tninfo
*/

class PedidoOficial {
  //Atributos
  private $numero_internet;

  //Construtor
  public function PedidoOficial(){

  }

  //Setando acesso e pegando atributos
  public function set_numero_internet($numero_internet){
    $this->numero_internet = $numero_internet;
  }
  public function get_numero_internet(){
    return $this->numero_internet;
  }
  //Setando acesso e pegando atributos
  public function set_obs($Obs){
    $this->obs = $Obs;
  }
  public function get_obs(){
    return $this->obs;
  }

  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){
//    echo "<BR><BR><BR>TERMO: $_REQUEST[termo]<BR><BR><BR><BR>";
//    exit;

    include("inc/config.php");
    pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $numero = $this->numero_internet;
    $Observacao = $this->obs;
    ######################################################
    # Armazena envio de pedido
    ######################################################
    $sql = "Update pedidos_internet_novo set enviado='1' where numero='$numero'";
    pg_query($sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
    ######################################################
    # Conferindo se o pedido ja foi gravado
    ######################################################
    $SqlPedidoGravado = pg_query("Select numero from pedidos where numero_internet='$numero'") or die ($MensagemDbError.pg_query ($db, "rollback"));
    $ccc = pg_num_rows($SqlPedidoGravado);
    //echo "<BR><BR><BR>TEM?? - $ccc<BR><BR><BR>";
    if ($ccc){
      $ped = pg_fetch_array($SqlPedidoGravado);
      $original = $ped[numero];
      $original = $ped[numero];
      $max = $original.date("His");
    }
      ######################################################
      # Gravando dados do pedido Envio Oficial!
      ######################################################
      #########################################################################
      # Carrega os dados do pedido da internet para gravar no pedidos oficial
      #########################################################################
      $SqlCarregaDados = pg_query("Select * from pedidos_internet_novo where numero='$numero'");
      $p = pg_fetch_array($SqlCarregaDados);
      if (!$max){
        ##########################################################################
        # Verifica se o ultimo numero é mesmo o ultimo pedido
        ##########################################################################
        if ($CodigoEmpresa=="75"){ // Perlex
          $ultimopedido = "SELECT numero_maximo_itens, ultimo_numero_pedido_internet + 1 as maximo FROM referencias";
        }else{
          $ultimopedido = "SELECT numero_maximo_itens, ultimo_numero_pedido + 1 as maximo FROM referencias";
        }
        $pedido = pg_query($db, $ultimopedido) or die ($MensagemDbError.$ultimopedido.pg_query ($db, "rollback"));
        $maximo = pg_fetch_array($pedido);
        $max = $maximo[maximo];
        $ACHEI = 0;
        while ($ACHEI == 0) {
          $SE_EXISTE = "select numero from pedidos where numero = ".$max;
          $PROCURA = pg_query($db, $SE_EXISTE) or die ($MensagemDbError.$SE_EXISTE.pg_query ($db, "rollback"));
          $ACHEI = pg_num_rows($PROCURA);
          if ($ACHEI > 0) {
            $max = $max + 1;
            $ACHEI = 0;
          }else {
            $ACHEI = 1;
          }
        }
        $_SESSION[NumeroPedidoGravado] = $max;
      }else{
        $_SESSION[NumeroPedidoGravado] = $original;
      }
      ######################################################
      # Fim Rotina de carregamento
      ######################################################
      /*
      CONFERIR A ROTINA ATÉ O FIM, ALGUNS DADOS SÃO GRAVADOS SOMENTE AO FINAL
      */
      $sql = "INSERT INTO pedidos (
                     cgc, cliente,
                     codigo_vendedor,
                     contato, data,
                ";
                if ($p[data_prevista_entrega]<>""){
                  $sql .= " data_prevista_entrega, ";
                }
                if ($CodigoEmpresa=="75"){ // Perlex
                  $sql .= " venda_casada, tipo_pedido, com_termo, ";
                }
        $sql .= "    id_cliente,
                     local_entrega, numero_pedido_vendedor,
                     numero, numero_cliente,
                     transportadora, vendedor, comissao, ";
                     if ($p[codigo_pagamento]){
                       $sql = $sql."codigo_pagamento, ";
                     }
                     if ($p[codigo_pagamento1]){
                       $sql = $sql."codigo_pagamento1, ";
                     }
                     if ($p[desconto_cliente]){
                       $sql = $sql."desconto_cliente,";
                     }
                     if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
                       $sql .= "tem_especial, especificado, ";
                     }
                     if ($p[fator1]){
                       $sql = $sql."fator1,";
                     }
                     if ($p[fator2]){
                       $sql = $sql."fator2,";
                     }
      $sql = $sql ."
                     fob, cif, numero_internet,
                     data_importacao, aprovado, venda_efetivada
              ) VALUES (
                     '$p[cgc]', '".left($p[cliente], 50)."',
                     '$id_vendedor',
                     '".left($p[contato],20)."', '$data_hoje',
                   ";
                   if ($p[data_prevista_entrega]<>""){
                     $sql .= " '$p[data_prevista_entrega]',  ";
                   }
                   if ($CodigoEmpresa=="75"){ // Perlex
                     $sql .= ($_REQUEST[venda_casada]=="true")? " '1', " : " '0', ";
                     $sql .= " '$_REQUEST[tipo_pedido]', ";
                     $sql .= ($_REQUEST[termo]=="true")? " '1', " : " '0', ";
                   }
        $sql .= "   '$p[id_cliente]',
                     '$p[local_entrega]', '$p[numero_pedido_vendedor]',
                     '$max', '$p[numero_cliente]',
                     '$p[transportadora]', '$_SESSION[nome_vendedor]', '$Comissao',
                     ";
                     if ($p[codigo_pagamento]){
                       $sql = $sql."'$p[codigo_pagamento]', ";
                     }
                     if ($p[codigo_pagamento1]){
                       $sql = $sql."'$p[codigo_pagamento1]', ";
                     }
                     if ($p[desconto_cliente]){
                       $sql = $sql."$p[desconto_cliente], ";
                     }
                     if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
                       if ($p[desconto_cliente]>0){
                         $sql .= " '1', $p[especificado], ";
                       }else{
                         $sql .= " '0', $p[especificado], ";
                       }
                     }

                     if ($p[fator1]){
                       $sql = $sql."'$p[fator1]', "; //Desconto do Item
                     }
                     if ($p[fator2]){
                       $sql = $sql."'$p[fator2]', "; //Desconto do Item
                     }
                     /*
                     Isso só serve para o pedido temporário
                     if ($p[fob]=="CIF") {
                       $cif = 1;
                       $fob = 0;
                     }else {
                       $cif = 0;
                       $fob = 1;
                     }
                     */
      $sql = $sql."$p[fob], $p[cif], $numero, '$data_hoje', -1 ,0)";
      //echo "<BR><BR>sql: $sql<BR><BR>";
      //exit;
      if (!$_Err){
        pg_query ($db,$sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
      }
      /////////////////////////////////////////////////////////
      $SqlAlter = "Update pedidos set usuario_cadastrou='".left($_SESSION[usuario], 10)."', data_alteracao='$data_hoje' where numero='$max'";
      pg_query($db, $SqlAlter);

      $Sql = "Insert into alteracao_pedidos (
                                                 numero_pedido,
                                                 usuario_alterou,
                                                 data_alteracao,
                                                 ip,
                                                 alteracao
                                              ) VALUES (
                                                 '$max',
                                                 '".left($_SESSION[usuario], 10)."',
                                                 '$data_hoje',
                                                 '$_SERVER[REMOTE_ADDR]',
                                                 'CADASTROU NOVO PEDIDO VIA SITE'
                                              )
             ";
      pg_query($db, $Sql);
      /////////////////////////////////////////////////////////
      // Itens
      /////////////////////////////////////////////////////////
      $SqlCarregaItens = "Select * from itens_do_pedido_internet where numero_pedido = '$numero' order by id";
      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
        $SqlCarregaItens .= " , especial ";
      }
      $SqlCarregaItens = $SqlCarregaItens." ASC ";
      $SqlCarregaItens = pg_query($SqlCarregaItens) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      while($i = pg_fetch_array($SqlCarregaItens)){
        //echo "<BR>$i[especial]";
        if ($i[especificado]=="1"){
          $Especificado = "1";
        }else{
          $Especificado = "0";
        }
        $prod = pg_query("Select base_reduzida from produtos where codigo='$i[codigo]'");
        $prod = pg_fetch_array($prod);

        $Cliente = pg_query("Select estado from clientes where cgc='$p[cgc]'");
        $Cliente = pg_fetch_array($Cliente);

        $Aliquota = pg_query("Select aliquota_01 from aliquotas_de_icm where est='$Cliente[estado]'");
        $Aliquota = pg_fetch_array($Aliquota);
        $IcmItem = $Aliquota[aliquota_01] / 100;
        if ($prod[base_reduzida]=="1"){
          if ($Cliente[estado]=="SP"){
            $IcmItem = $prod[codigo_icms] / 100;
          }
        }
        $IcmItem = $i[valor_total] * $IcmItem;
        $TotalIcm += $IcmItem;
        $TotalItens += $i[valor_total];
        
        if ($i[especial]==0){
          /////////////////////////////////////////////////////////
          // NORMAL
          /////////////////////////////////////////////////////////
          $ValorLiquido = $i[valor_total] - $IcmItem;
          if ($i[qtd]>0){
            $consulta = "INSERT INTO itens_do_pedido_vendas ";
            $consulta = $consulta." (numero_pedido,codigo,qtd,valor_unitario,";
            $consulta = $consulta."valor_total,";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " especial,especificado, valor_liquido, ";
            }
            $consulta = $consulta."ipi,valor_ipi,nome_do_produto, peso_bruto, peso_liquido, ";
            if ($i["fator1"]){
              $consulta = $consulta."fator1, ";
            }
            $consulta = $consulta." quantidade_reservada, reservado, preco_alterado) values( ";
            $consulta=  $consulta."$max, '$i[codigo]', $i[qtd], ";
            $consulta = $consulta."'$i[valor_unitario]', ";
            $consulta = $consulta."'$i[valor_total]', ";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " 0, '$Especificado',  '$ValorLiquido', ";
            }
            $consulta = $consulta."'$i[ipi]', '$i[valor_ipi]', '$i[nome_do_produto]', ";
            $consulta = $consulta."'$i[peso_bruto]', '$i[peso_liquido]', ";
            if ($i["fator1"]){
              $consulta = $consulta."'$i[fator1]', ";
            }
            $consulta = $consulta." '$i[qtd]','1', '$i[preco_alterado]') ";
            $Total = $Total + $i[valor_total];
            pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          }
        }else{
          /////////////////////////////////////////////////////////
          // Especial
          /////////////////////////////////////////////////////////
          $ValorLiquido = $i[valor_total];
          if ($i[qtd]>0){
            $consulta = "INSERT INTO itens_do_pedido_vendas ";
            $consulta = $consulta." (numero_pedido,codigo,qtd,valor_unitario,";
            $consulta = $consulta."valor_total,";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " especial, ";
            }
            $consulta = $consulta."ipi, valor_ipi, nome_do_produto,preco_alterado, peso_bruto, peso_liquido, ";
            if ($i["fator2"]){
              $consulta = $consulta."fator2,";
            }
            $consulta = $consulta."especificado, quantidade_reservada, reservado, valor_liquido) values( ";
            $consulta=  $consulta."$max, '$i[codigo]', $i[qtd],";
            $consulta = $consulta."'$i[valor_unitario]', ";
            $consulta = $consulta."'$i[valor_total]',";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " 1, ";
            }
            $consulta = $consulta."'$i[ipi]', '$i[valor_ipi]', '$i[nome_do_produto]'";
            $consulta = $consulta.",'$i[preco_alterado]', '$i[peso_bruto]', '$i[peso_liquido]', ";
            if ($i["fator2"]){
              $consulta = $consulta."'$i[fator2]', ";
            }
            $consulta = $consulta."'$Especificado', '$i[qtd]','1', '$ValorLiquido') ";
            $Total = $Total + $i[valor_total];
            $TotalEspecial = $TotalEspecial + $i[valor_total];
            pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          }
        }
        //echo $consulta;
        $TotalLiquido += $ValorLiquido;
        //insere na tabela oficial todas as cores
        if ($CodigoEmpresa=="86"){ //só tem cores pra Perfil
          $consulta = "UPDATE itens_do_pedido_vendas set ";
          if ($i[preto] <> "") {
             $consulta .= "preto =".$i[preto];
             $divisor = ",";
          }
          if ($i[branco] <> "") {
             $consulta .= $divisor."branco =".$i[branco];
             $divisor = ",";
          }
          if ($i[azul] <> "") {
             $consulta .= $divisor."azul =".$i[azul];
             $divisor = ",";
          }
          if ($i[verde] <> "") {
             $consulta .= $divisor."verde =".$i[verde];
             $divisor = ",";
          }
          if ($i[vermelho] <> "") {
             $consulta .= $divisor."vermelho =".$i[vermelho];
             $divisor = ",";
          }
          if ($i[amarelo] <> "") {
             $consulta .= $divisor."amarelo =".$i[amarelo];
             $divisor = ",";
          }
          if ($i[marrom] <> "") {
             $consulta .= $divisor."marrom =".$i[marrom];
             $divisor = ",";
          }
          if ($i[cinza] <> "") {
             $consulta .= $divisor."cinza =".$i[cinza];
             $divisor = ",";
          }
          if ($i[laranja] <> "") {
             $consulta .= $divisor."laranja =".$i[laranja];
             $divisor = ",";
          }
          if ($i[rosa] <> "") {
             $consulta .= $divisor."rosa =".$i[rosa];
             $divisor = ",";
          }
          if ($i[violeta] <> "") {
             $consulta .= $divisor."violeta =".$i[violeta];
             $divisor = ",";
          }
          if ($i[bege] <> "") {
             $consulta .= $divisor."bege =".$i[bege];
             $divisor = ",";
          }
          if ($i[outra] <> "") {
             $consulta .= $divisor."outra =".$i[outra];
             $divisor = ",";
          }
          $consulta .= ",especificado=1, quantidade_reservada=$i[qtd], reservado=1 ";
          $consulta .= " WHERE numero_pedido=".$max." AND codigo='$i[codigo]'";
          if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
            $consulta .= " and especial='$i[especial]' ";
          }
          //echo $consulta;
          pg_query ($db,$consulta);
          $CodigoReserva = $i[codigo];
        }
        $PesoBruto = $PesoBruto + $i[peso_bruto];
        $PesoLiquido = $PesoLiquido + $i[peso_liquido];
//        $QtdTotal = $QtdTotal + $i[qtd];
        if ($CodigoEmpresa=="86"){ //Perfil
          //$SqlEstoque = "Update estoques set reservado=reservado + $i[qtd] where codigo='$i[codigo]'";
          //echo $SqlEstoque;
          //pg_query($SqlEstoque);
        }
      }
      $TotalComissao = $Total * (2 / 100);
      if ($p[desconto_cliente]){
        $TotalDesconto = $Total  - $TotalEspecial; // TOTAL COM DESCONTO = TOTAL - ESPECIAL.
        // Forma antiga de calculo to total_com_desconto [errada]
        //$TotalDesconto = $Total  - ($Total * ($p[desconto_cliente] /  100)); // TOTAL SEM DESCONTO = TOTAL - ESPECIAL.
      }else{
        $TotalDesconto = $Total;
      }
      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
        $SqlCamposExtra = "valor_total_liquido='$TotalLiquido', ";
      }
      $SqlUpdate = "update pedidos set especificado='$Especificado', $SqlCamposExtra total_sem_desconto='$Total', total_com_desconto='$TotalDesconto', total_comissao='$TotalComissao', peso_bruto='$PesoBruto', peso_liquido='$PesoLiquido' where numero='$max'";
      pg_query($SqlUpdate);
      if ($original){
        //////////////////////////////////////////////////////////////////
        pg_query("delete from pedidos where numero = $original");
        pg_query("delete from itens_do_pedido_vendas where numero_pedido = $original");
        pg_query("Update pedidos set numero=$original where numero = $max");
        pg_query("Update itens_do_pedido_vendas set numero_pedido=$original where numero_pedido = $max");
        pg_query("delete from pedidos where numero = $max");
        pg_query("delete from itens_do_pedido_vendas where numero_pedido = $max");
        $max = $numero; //desfaz o negreiro
        /////////////////////////////////////////////////////////////////
      }else{
        pg_query("update referencias set ultimo_numero_pedido='$max'");
      }

      #########################################################################################
      #  Grava edição da Observação
      #########################################################################################
      //instancia o objeto
//      $Obs = new Observacao();
//      $Obs->set_numero_internet($max);
//      $Obs->set_observacao($Observacao);
//      $Obs->set_operacao("adiciona");
//      $Obs->fazer();
        $OBS = "INSERT INTO observacao_do_pedido (numero_pedido, observacao) VALUES (";
        $OBS = $OBS.$max.",";
        $OBS = $OBS."'".$Observacao."')";
        //echo $OBS;
        //if (!$_Err){
          //pg_query($db, TrocaCaracteres($OBS)) or die ($MensagemDbError."PedOfi".TrocaCaracteres($OBS).pg_query ($db));
          pg_query($OBS);
        //}
      /*
      $SqlAAAA = "Select * from observacao_do_pedido where numero_pedido='$max'";
      echo $SqlAAAA;
      $SqlObservacao = pg_query($SqlAAAA);
      #########################################################################################
      #  Atualiza Observação
      #########################################################################################
//      $cccObs = pg_num_rows($SqlObservacao);
      $oo = pg_fetch_array($SqlObservacao);
//      echo "Count- $cccObs";
      echo "OBS: $oo[observacao]";
      if ($oo[observacao]<>""){
        $OBS1 = "Update observacao_do_pedido set observacao='$oo[observacao]', numero_pedido='$max' where numero_pedido = $numero";
        $Observacao = $oo[observacao];
      }else{
        $OBS1 = "Insert into observacao_do_pedido (observacao, numero_pedido) values ('$Observacao', '$max')";
      }
      //echo $OBS1;
      if (!$_Err){
        pg_query($db, TrocaCaracteres($OBS1)) or die ($MensagemDbError.$OBS1.pg_query ($db, "rollback"));
      }
      //pg_query ($db, "commit");
      //pg_close($db);
      */
      //pg_query ($db, "commit");
      pg_query ($db, "commit");
  }
}
?>
