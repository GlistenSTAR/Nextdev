<?php
/*
Classe GravObs

Grava a observação no pedido

Essa classe é usada em:

cadastrar_pedidos.php

27/11/2007 - Emerson - Tninfo
*/

class Observacao {
  //Atributos
  private $numero_internet;
  private $operacao;
  private $observacao;

  //Construtor
  public function Observacao(){

  }

  //Setando acesso e pegando atributos
  public function set_numero_internet($numero_internet){
    $this->numero_internet = $numero_internet;
  }
  public function get_numero_internet(){
    return $this->numero_internet;
  }
  public function set_operacao($operacao){
    $this->operacao = $operacao;
  }
  public function get_operacao(){
    return $this->operacao;
  }
  public function set_observacao($observacao){
    $this->observacao = $observacao;
  }
  public function get_observacao(){
    return $this->observacao;
  }

  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){

    include("inc/config.php");
    //pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $operacao = $this->operacao;
    $numero = $this->numero_internet;
    $observacao = $this->observacao;
    
//    $SqlAAAA = "Select * from observacao_do_pedido where numero_pedido='$numero'";
//  //  echo $SqlAAAA;
//    $SqlObservacao = pg_query($SqlAAAA);
//    #########################################################################################
//    #  Atualiza Observação
//    #########################################################################################
////      $cccObs = pg_num_rows($SqlObservacao);
//    $oo = pg_fetch_array($SqlObservacao);
////      echo "Count- $cccObs";
//    //echo "OBS: $oo[observacao]";
//    if ($oo[observacao]<>""){
//      $operacao = "edita";
//    }

    switch ($operacao) {
      case 'adiciona' :
        /// Escreve Observação.
        $OBS = "INSERT INTO observacao_do_pedido (numero_pedido, observacao) VALUES (";
        $OBS = $OBS.$numero.",";
        $OBS = $OBS."'".$observacao."')";
        if (!$_Err){
          pg_query($db, TrocaCaracteres($OBS)) or die ($MensagemDbError.TrocaCaracteres($OBS).pg_query ($db));
        }

      break;
      case 'edita' :
        /// Escreve Observação.
        $OBS = "Update observacao_do_pedido set observacao='$observacao' where numero_pedido = $numero";
        if (!$_Err){
          pg_query($db, TrocaCaracteres($OBS)) or die ($MensagemDbError.TrocaCaracteres($OBS).pg_query ($db));
        }

      break;
    }
   // echo $OBS;
   //pg_query ($db);
   // pg_query ($db, "commit");
//    pg_close($db);
  }
}
?>
