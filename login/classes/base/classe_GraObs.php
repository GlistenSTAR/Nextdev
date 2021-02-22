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
  public function __construct(){

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
    pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $operacao = $this->operacao;
    $numero = $this->numero_internet;
    $observacao = $this->observacao;

    switch ($operacao) {
      case 'adiciona' :
        /// Escreve Observação.
        @pg_query("Delete from observacao_do_pedido where numero_pedido='".$numero."'");
        $OBS = "INSERT INTO observacao_do_pedido (numero_pedido, observacao) VALUES (";
        $OBS = $OBS.$numero.",";
        $OBS = $OBS."'".strtoupper($observacao)."')";
        if (!$_Err){
          pg_query($db, $OBS) or die ($MensagemDbError.$OBS.pg_query ($db, "rollback"));
        }

      break;
      case 'edita' :
        /// Escreve Observação.
        $OBS = "Update observacao_do_pedido set observacao='".strtoupper($observacao)."' where numero_pedido = $numero";
        if (!$_Err){
          pg_query($db, $OBS) or die ($MensagemDbError.$OBS.pg_query ($db, "rollback"));
          pg_query($db, "Update observacao_do_pedido set observacao='' where numero_pedido=''") or die ($MensagemDbError.$OBS.pg_query ($db, "rollback"));
        }
        //echo $OBS;
      break;
    }
    //echo $OBS;
//    pg_query ($db, "commit");
//    pg_close($db);
  }
}
?>
