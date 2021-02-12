<?php
/*
Classe PedOfi

Grava os pedidos da base temporária na base oficial, uma simples troca de tabelas de pedidos_internet_novo para pedidos.

Essa classe é usada em:

cadastrar_pedidos.php

27/11/2007 - Emerson - Tninfo
*/

class PedidoOficial {
  //Atributos
  private $operacao;
  private $numero_internet;

  //Construtor
  public function __construct(){

  }

  //Setando acesso e pegando atributos
  public function set_operacao($operacao){
    $this->operacao = $operacao;
  }
  public function get_operacao(){
    return $this->operacao;
  }
  
  public function set_numero_internet($numero_internet){
    $this->numero_internet = $numero_internet;
  }
  public function get_numero_internet(){
    return $this->numero_internet;
  }
  //Setando acesso e pegando atributos
  public function set_observacao($observacao){
    $this->observacao = $observacao;
  }
  public function get_observacao(){
    return $this->observacao;
  }

  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){
  
    include("inc/config.php");
    pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $numero = $this->numero_internet;
    $observacao = $this->observacao;
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
    if (!$ccc){
      ######################################################
      # Gravando dados do pedido Envio Oficial!
      ######################################################
      ##########################################################################
      # Verifica se o ultimo numero é mesmo o ultimo pedido
      ##########################################################################
      $ultimopedido = "SELECT numero_maximo_itens, ultimo_numero_pedido + 1 as maximo FROM referencias";
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
      $_SESSION['NumeroPedidoGravado'] = $max;
      #########################################################################
      # Carrega os dados do pedido da internet para gravar no pedidos oficial
      #########################################################################
      $SqlCarregaDados = pg_query("Select * from pedidos_internet_novo where numero='$numero'");
      $p = pg_fetch_array($SqlCarregaDados);
      ######################################################
      # Fim Rotina de carregamento
      ######################################################
      /*
      CONFERIR A ROTINA ATÉ O FIM, ALGUNS DADOS SÃO GRAVADOS SOMENTE AO FINAL
      */     
      $sql = "INSERT INTO pedidos (
                     cgc, cliente,
                     codigo_vendedor,
                     contato, data, emissao,
                     data_prevista_entrega, id_cliente,
                     local_entrega,
                     numero, numero_cliente,
                     transportadora, vendedor, comissao, ";
                     if ($p['codigo_pagamento']){
                       $sql = $sql."codigo_pagamento, ";
                     }
                     if ($p['codigo_pagamento1']){
                       $sql = $sql."codigo_pagamento1, ";
                     }
                     if ($p['desconto']){
                       $sql = $sql."desconto_cliente, ";
                     }
      $sql = $sql ."
                     frete_fob, numero_internet,
                     data_importacao, aprovado, venda_efetivada, outros
              ) VALUES (
                     '$p[cgc]', '$p[cliente]',
                     '$p[codigo_vendedor]',
                     '".left($p['contato'],20)."', '$data_hoje', '$Emissao',
                     '$p[data_prevista_entrega]', '$p[id_cliente]',
                     '',
                     '$max', '$p[numero_cliente]',
                     '$p[transportadora]', '$_SESSION[usuario]', '2', 
                     ";
                     if ($p['codigo_pagamento']){
                       $sql = $sql."'$p[codigo_pagamento]', ";
                     }
                     if ($p['codigo_pagamento1']){
                       $sql = $sql."'$p[codigo_pagamento1]', ";
                     }
                     if ($p['desconto']){
                       $sql = $sql."$p[desconto], ";
                     }
                     if ($p['fob']=="CIF") {
                       $fob = 0;
                     }else {
                       $fob = 1;
                     }
      $sql = $sql."$fob, $numero, '$data_hoje', -1 ,0,0)";
      //echo $sql;
      if (!$_Err){
        pg_query ($db,$sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
      }
      /////////////////////////////////////////////////////////
      // Itens
      /////////////////////////////////////////////////////////
      $SqlCarregaItens = pg_query("Select * from itens_do_pedido_internet where numero_pedido = '$numero'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      while($i = pg_fetch_array($SqlCarregaItens)){
        $consulta = "INSERT INTO itens_do_pedido_vendas(
                                   numero_pedido,codigo,qtd,valor_unitario,
                                   valor_total, valor_ipi,
                                   ipi,nome_do_produto,preco_alterado, peso_bruto, peso_liquido
                             ) values(
                                   $max, '$i[codigo]', '$i[qtd]', '$i[valor_unitario]',
                                   '$i[valor_total]', '$i[valor_ipi]',
                                   '$i[ipi]', '$i[nome_do_produto]',
                                   '$i[preco_alterado]', '$i[peso_bruto]', '$i[peso_liquido]'
                             )";
        $Total = $Total + $i['valor_total'];
        pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
        $PesoBruto = $PesoBruto + $i['peso_bruto'];
        $PesoLiquido = $PesoLiquido + $i['peso_liquido'];
      }
      $TotalComissao = $Total * (2 / 100);
      pg_query("update pedidos set total_com_desconto='$Total', total_comissao='$TotalComissao', peso_bruto='$PesoBruto', peso_liquido='$PesoLiquido' where numero='$max'");
      pg_query("update referencias set ultimo_numero_pedido='$max'");
      pg_query("INSERT INTO observacao_do_pedido (observacao, numero_pedido) VALUES ('".strtoupper($observacao)."','$max')");
    }else{
      ######################################################
      # Editando dados do pedido Envio Oficial!
      ######################################################
      $PedidoOficial = pg_fetch_array($SqlPedidoGravado);
      $_SESSION['NumeroPedidoGravado'] = $PedidoOficial['numero'];
      $max = $PedidoOficial['numero'];
      #########################################################################
      # Carrega os dados do pedido da internet para gravar no pedidos oficial
      #########################################################################
      $SqlCarregaDados = pg_query("Select * from pedidos_internet_novo where numero='$numero'");
      $p = pg_fetch_array($SqlCarregaDados);
      ######################################################
      # Fim Rotina de carregamento
      ######################################################
      /*
      CONFERIR A ROTINA ATÉ O FIM, ALGUNS DADOS SÃO GRAVADOS SOMENTE AO FINAL
      */
      $sql = "Update pedidos set
                     cgc='$p[cgc]',
                     cliente='$p[cliente]',
                     codigo_vendedor='$p[codigo_vendedor]',
                     contato='".left($p['contato'],20)."',
                     data='$data_hoje',
                     data_prevista_entrega='$p[data_prevista_entrega]',
                     id_cliente='$p[id_cliente]',
                     local_entrega='',
                     numero_cliente='$p[numero_cliente]',
                     transportadora='$p[transportadora]',
                     vendedor='$_SESSION[usuario]',
                     usuario_cadastrou='$_SESSION[usuario]',
                     comissao='0', ";
                     if ($p['codigo_pagamento']){
                       $sql = $sql."codigo_pagamento='$p[codigo_pagamento]', ";
                     }
                     if ($p[fob]=="CIF") {
                       $fob = 0;
                     }else {
                       $fob = 1;
                     }
      $sql = $sql ."
                     frete_fob='$fob',
                     numero_internet='$numero',
                     data_importacao='$data_hoje',
                     aprovado='-1',
                     venda_efetivada='0'
              Where numero='$max' ";
      //echo $sql;
      if (!$_Err){
//        pg_query ($db,$sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
      }
      /////////////////////////////////////////////////////////
      // Itens
      /////////////////////////////////////////////////////////
      $SqlCarregaItens = pg_query("Select * from itens_do_pedido_internet where numero_pedido = '$numero'") or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      while($i = pg_fetch_array($SqlCarregaItens)){
        $SqlConfereItemPedido = pg_query("Select codigo from itens_do_pedido_vendas where codigo='$i[codigo]' and numero_pedido='$max'");
        $VerificaSeTemItem = pg_num_rows($SqlConfereItemPedido);
        if ($VerificaSeTemItem>0){
          $consulta = "Update itens_do_pedido_vendas set
                                   codigo='$i[codigo]',
                                   qtd='$i[qtd]',
                                   valor_unitario='$i[valor_unitario]',
                                   valor_total='$i[valor_total]',
                                   valor_ipi='$i[valor_ipi]',
                                   ipi='$i[ipi]',
                                   nome_do_produto='$i[nome_do_produto]',
                                   preco_alterado='$i[preco_alterado]',
                                   peso_bruto='$i[peso_bruto]',
                                   peso_liquido='$i[peso_liquido]'
                       Where numero_pedido='$max' and codigo='$i[codigo]' ";
        }else{
          $consulta = "INSERT INTO itens_do_pedido_vendas(
                            numero_pedido,codigo,qtd,valor_unitario,
                            valor_total, valor_ipi,
                            ipi,nome_do_produto,preco_alterado,
                            peso_bruto, peso_liquido
                       ) values(
                            $max, '$i[codigo]', '$i[qtd]', '$i[valor_unitario]',
                            '$i[valor_total]','$i[valor_ipi]',
                            '$i[ipi]', '$i[nome_do_produto]', '$i[preco_alterado]',
                            '$i[peso_bruto]', '$i[peso_liquido]'
                       )";
        }
        $Total = $Total + $i['valor_total'];
        $TotalGeral = $TotalGeral + $i['valor_total'] + $i['valor_ipi'];
        pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
        $PesoBruto = $PesoBruto + $i['peso_bruto'];
        $PesoLiquido = $PesoLiquido + $i['peso_liquido'];
      }
      $TotalComissao = $Total * (2 / 100);
      $Sql = "update pedidos set total_com_desconto='$Total', total_sem_desconto='$TotalGeral', total_comissao='$TotalComissao', peso_bruto='$PesoBruto', peso_liquido='$PesoLiquido' where numero='$max'";
      pg_query($Sql);
      pg_query("Update observacao_do_pedido set observacao='".strtoupper($observacao)."' where numero_pedido = '$max'");
    }
  }
}
?>
