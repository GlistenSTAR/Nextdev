<?php
/*
Classe MovEst - Movimentação de estoque automática

Essa classe faz a ligação com o banco de dados recebendo alguns valores que devem ser setados onde é necessário mover o estoque,
tanto para sair quanto para entrar

03/10/2007 - Emerson - Tninfo
*/

class MovEst {
  //Atributos
  private $codigo;
  private $entrada;
  private $qtd;
  private $pedido;
  private $cliente;
  private $usuario;

  //Construtor
  public function __construct(){

  }

  //Setando acesso e pegando atributos
  public function set_codigo($codigo){
    $this->codigo = $codigo;
  }
  public function get_codigo(){
    return $this->codigo;
  }

  public function set_entrada($entrada){
    $this->entrada = $entrada;
  }
  public function get_entrada(){
    return $this->entrada;
  }

  public function set_qtd($qtd){
    $this->qtd = $qtd;
  }
  public function get_qtd(){
    return $this->qtd;
  }

  public function set_pedido($pedido){
    $this->pedido = $pedido;
  }
  public function get_pedido(){
    return $this->pedido;
  }

  public function set_cliente($cliente){
    $this->cliente = $cliente;
  }
  public function get_cliente(){
    return $this->cliente;
  }
  
  public function set_usuario($usuario){
    $this->usuario = $usuario;
  }
  public function get_usuario(){
    return $this->usuario;
  }
  
  public function set_produto($produto){
    $this->produto = $produto;
  }
  public function get_produto(){
    return $this->produto;
  }

  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){
    include "abre_banco.inc.php";
    if (($this->codigo<>"") and ($this->qtd<>"")){
      if ($this->entrada){
        $Operador = "+";
        $SequenciaValores = "'1','1','0',";
      }else{
        $SequenciaValores = "'2','0','1',";
        $Operador = "-";
      }

      $Saldo = 0;

      #### Dados do produto
        $sql = pg_query("SELECT estocada, produto FROM estoques WHERE codigo = '".strtoupper($this->codigo)."'");
        // or die ("erro 1");
        $r= pg_fetch_array($sql);

        $Saldo = $r[estocada];
        $Produto = $this->produto;
        if (!$Saldo){
          $Saldo = 0;
        }
      #### Atualiza estoque
        $sql = "Update estoques set
                  estocada=estocada $Operador $this->qtd,
                  total_entrada=total_entrada + $this->qtd,
                  total_saida=total_saida + $this->qtd
                where codigo='".strtoupper($this->codigo)."'
               ";
        //echo $sql;
        $AtualizaEstoque = pg_query($sql);
        // or die ("Erro 2");

      #### Movimenta Estoque
        ###########################################
        # Pega proximo id movimentacao
        ###########################################
          $ProxId = pg_query("SELECT max(id + 1) as max_id_mov FROM movimentacao_estoque");
          $m = pg_fetch_array($ProxId);
          $MaxIdMov = $m[max_id_mov];
        ####
        $sql = "Insert into movimentacao_estoque (
                  id,
                  codigo,
                  produto,
                  qtd,
                  data_lancamento,
                  numero_documento,
                  numero_pedido,
                  valor_unitario,
                  usuario,
                  codigo_operacao,
                  entrada,
                  saida,
                  saldo_inicial,
                  obs
                )values(
                  '$MaxIdMov',
                  '".strtoupper($this->codigo)."',
                  '$Produto',
                  '$this->qtd',
                  '".date("m/d/Y")."',
                  '$this->pedido',
                  '$this->pedido',
                  '0',
                  '$this->usuario',
                  $SequenciaValores
                  '".str_replace(",",".",$Saldo)."',
                  '$this->cliente'
                )
               ";
        //echo $sql;
        $MovimentaEstoque = pg_query($sql);
        // or die ("Erro 3");
      ####
     }
  }
}
?>
