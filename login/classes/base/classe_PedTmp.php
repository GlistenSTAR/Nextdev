<?php
/*
Classe PedTmp

Grava os pedidos da base temporária

Essa classe é usada em:

cadastrar_pedidos.php

27/11/2007 - Emerson - Tninfo
*/

//echo $_SESSION[id_vendedor];
//exit;

class PedidoTemporario {
  //Atributos
  private $operacao;
  private $clientecnpj;
  private $cliente_cc;
  private $contato_cc;
  private $DataPrevistaEntrega;
  private $cliente_id;
  private $trans_id;
  private $numero;
  private $numero_cliente;
  private $trans_cc;
  private $condpag1_id;
  private $condpag2_id;
  private $vendedor2_id;
  private $desconto;
  private $desconto11_cc;
  private $desconto1_cc;
  private $desconto22_cc;
  private $desconto2_cc;
  private $fob;

  //Construtor
  public function MovEst(){

  }

  //Setando acesso e pegando atributos
  public function set_operacao($operacao){
    $this->operacao = $operacao;
  }
  public function get_operacao(){
    return $this->operacao;
  }

  public function set_clientecnpj($clientecnpj){
    $this->clientecnpj = $clientecnpj;
  }
  public function get_clientecnpj(){
    return $this->clientecnpj;
  }
  
  public function set_cliente_cc($cliente_cc){
    $this->cliente_cc = $cliente_cc;
  }
  public function get_cliente_cc(){
    return $this->cliente_cc;
  }

  public function set_contato_cc($contato_cc){
    $this->contato_cc = $contato_cc;
  }
  public function get_contato_cc(){
    return $this->contato_cc;
  }
  
  public function set_DataPrevistaEntrega($DataPrevistaEntrega){
    $this->DataPrevistaEntrega = $DataPrevistaEntrega;
  }
  public function get_DataPrevistaEntrega(){
    return $this->DataPrevistaEntrega;
  }
  
  public function set_cliente_id($cliente_id){
    $this->cliente_id = $cliente_id;
  }
  public function get_cliente_id(){
    return $this->cliente_id;
  }
  
  public function set_trans_id($trans_id){
    $this->trans_id = $trans_id;
  }
  public function get_trans_id(){
    return $this->trans_id;
  }
  
  public function set_numero($numero){
    $this->numero = $numero;
  }
  public function get_numero(){
    return $this->numero;
  }
  
  public function set_numero_cliente($numero_cliente){
    $this->numero_cliente = $numero_cliente;
  }
  public function get_numero_cliente(){
    return $this->numero_cliente;
  }
  
  public function set_trans_cc($trans_cc){
    $this->trans_cc = $trans_cc;
  }
  public function get_trans_cc(){
    return $this->trans_cc;
  }
  
  public function set_condpag1_id($condpag1_id){
    $this->condpag1_id = $condpag1_id;
  }
  public function get_condpag1_id(){
    return $this->condpag1_id;
  }
  
  public function set_condpag2_id($condpag2_id){
    $this->condpag2_id = $condpag2_id;
  }
  public function get_condpag2_id(){
    return $this->condpag2_id;
  }

  public function set_desconto($desconto){
    $this->desconto = $desconto;
  }
  public function get_desconto(){
    return $this->desconto;
  }

  public function set_desconto11_cc($desconto11_cc){
    $this->desconto11_cc = $desconto11_cc;
  }
  public function get_desconto11_cc(){
    return $this->desconto11_cc;
  }

  public function set_desconto1_cc($desconto1_cc){
    $this->desconto1_cc = $desconto1_cc;
  }
  public function get_desconto1_cc(){
    return $this->desconto1_cc;
  }
  
  public function set_desconto22_cc($desconto22_cc){
    $this->desconto22_cc = $desconto22_cc;
  }
  public function get_desconto22_cc(){
    return $this->desconto22_cc;
  }
  
  public function set_desconto2_cc($desconto2_cc){
    $this->desconto2_cc = $desconto2_cc;
  }
  public function get_desconto2_cc(){
    return $this->desconto2_cc;
  }
  
  public function set_vendedor2_id($vendedor2_id){
    $this->vendedor2_id = $vendedor2_id;
  }
  public function get_vendedor2_id(){
    return $this->vendedor2_id;
  }
  
  public function set_fob($fob){
    $this->fob = $fob;
  }
  public function get_fob(){
    return $this->fob;
  }
  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){

    include("inc/config.php");
    pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $operacao                   = $this->operacao;
    $clientecnpj_cc             = $this->clientecnpj;
    $cliente_cc                 = $this->cliente_cc;
    $contato_cc                 = $this->contato_cc;
    $DataPrevistaEntrega        = $this->DataPrevistaEntrega;
    $cliente_id                 = $this->cliente_id;
    $trans_id                   = $this->trans_id;
    $numero                     = $this->numero;
    $numero_cliente             = $this->numero_cliente;
    $trans_cc                   = $this->trans_cc;
    $condpag1_id                = $this->condpag1_id;
    $condpag2_id                = $this->condpag2_id;
    $desconto                   = $this->desconto;
    $desconto11_cc              = $this->desconto11_cc;
    $desconto1_cc               = $this->desconto1_cc;
    $desconto22_cc              = $this->desconto22_cc;
    $desconto2_cc               = $this->desconto2_cc;
    $fob                        = $this->fob;
    $vendedor2_id               = $this->vendedor2_id;

    switch ($operacao) {
      case 'adiciona' :
        ######################################################
        # Gravando dados do pedido parte1
        ######################################################
        $sql = "
        INSERT INTO pedidos_internet_novo (
                cgc, cliente,
                codigo_vendedor,
                contato, data,
                data_prevista_entrega, id_cliente,
                local_entrega,
                numero, numero_cliente,
                transportadora, vendedor,";
                if ($condpag1_id){
                  $sql = $sql."codigo_pagamento, ";
                }
                if ($condpag2_id){
                  $sql = $sql."codigo_pagamento1, ";
                }
                if ($desconto){
                  $sql = $sql."desconto, ";
                }
                if (($desconto11_cc) or ($desconto1_cc)){
                  $sql = $sql."fator1,";
                }
                if (($desconto22_cc) or ($desconto2_cc)){
                  $sql = $sql."fator2,";
                }
        $sql = $sql ."
                fob, cif, numero_internet,
                baixou_estoque, data_importacao
        ) VALUES (
                  '$clientecnpj_cc', '$cliente_cc',
                  '$vendedor2_id',
                  '".left($contato_cc,20)."', '$data_hoje',
                  '$DataPrevistaEntrega', $cliente_id,
                  '',
                  '$numero', '$numero_cliente',
                  '$trans_cc', '$_SESSION[usuario]',
                  ";
                  if ($condpag1_id){
                    $sql = $sql."'$condpag1_id', ";
                  }
                  if ($condpag2_id){
                    $sql = $sql."'$condpag2_id', ";
                  }
                  if ($desconto){
                    $sql = $sql."$desconto, ";
                  }
                  if (($desconto11_cc) or ($desconto1_cc)){
                    if ($desconto11_cc){
                      $sql = $sql."$desconto11_cc, "; //Desconto do Item
                    }elseif ($desconto1_cc){
                      $sql = $sql."$desconto1_cc, ";  //Desconto do Pedido
                    }else{
                      $sql = $sql."0, ";
                    }
                  }
                  if (($desconto22_cc) or ($desconto2_cc)){
                    if ($desconto22_cc){
                      $sql = $sql."desconto22_cc, "; //Desconto do Item
                    }elseif ($desconto2_cc){
                      $sql = $sql."desconto2_cc, ";   //Desconto do Pedido
                    }else{
                      $sql = $sql."0, ";
                    }
                  }
                  if ($fob == "CIF") {
                    $cif = 1;
                    $fob = 0;
                  }else {
                    $cif = 0;
                    $fob = 1;
                  }
        $sql = $sql."$fob, $cif, $numero,
                  '0', '$data_hoje'
                  )";
//        echo $sql;
//        exit;
        if (!$_Err){
          pg_query ($db,$sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
        }
        //pg_query ($db, "commit");
        //pg_close($db);
        break;
      case 'edita' :
        if ($fob == "CIF") {
          $cif = 1;
        }else {
          $cif = 0;
        }
        if ($condpag2_id){ $CondicaoPagamento2 = "codigo_pagamento1='$condpag2_id', ";}
        $sql = "Update pedidos_internet_novo set
                  cgc='$clientecnpj_cc',
                  cliente='$cliente_cc',
                  contato='".left($contato_cc,20)."',
                  id_cliente='$cliente_id',
                  codigo_pagamento='$condpag1_id',
                  codigo_vendedor='$vendedor2_id',
                  $CondicaoPagamento2
                  numero_cliente='$numero_cliente',
                  transportadora='$trans_cc',
                  data_prevista_entrega='$DataPrevistaEntrega', ";
                  if (($desconto11_cc) or ($desconto1_cc)){
                    if ($desconto11_cc){
                      $sql = $sql."fator1='$desconto11_cc', "; //Desconto do Item
                    }elseif ($desconto1_cc){
                      $sql = $sql."fator1='$desconto1_cc', ";  //Desconto do Pedido
                    }else{
                      $sql = $sql."0, ";
                    }
                  }
                  if (($desconto22_cc) or ($desconto2_cc)){
                    if ($desconto22_cc){
                      $sql = $sql."fator2='$desconto22_cc', "; //Desconto do Item
                    }elseif ($desconto2_cc){
                      $sql = $sql."fator2='$desconto2_cc', ";  //Desconto do Pedido
                    }else{
                      $sql = $sql."0, ";
                    }
                  }
                  if ($desconto>0){
                    $sql = $sql."desconto='$desconto', ";
                  }
        $sql = $sql." cif='$cif' where numero='$numero' ";

        //echo $sql;

        if (!$_Err){
          pg_query ($db,$sql)  or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
        }
        //pg_query ($db, "commit");
        //pg_close($db);
        break;
    }
  }
}
?>
