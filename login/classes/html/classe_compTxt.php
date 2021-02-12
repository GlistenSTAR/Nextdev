<?php

//Classe CompTxt - escreve texto em html.

// aqui nos come�amos nossa classe
class compTxt {

/*Estes s�o os atributos da classe, notem que os atributos s�o precedidos da palavra "private", isto significa que esses atributos s� ser�o acessados pela pr�pria classe, ou seja, n�o ser� poss�vel acess�-los de outro lugar a n�o ser esta classe, fique calmo voc� entender� melhor mais adiante. */

  private $face;
  private $size;
  private $color;
  private $negrito;
  private $texto;


/*Este M�todo � chamado de construtor, pois ele � executado quando se instancia esta classe, ou seja, podemos realizar v�rias a��es quando a classe for instanciada, basta colocar os c�digos aqui e pronto. */

  public function compTxt(){

  }

/* Aqui � que resolvemos o problema de se alcan�ar os atributos da classe, notem para se modificar o conte�do dos atributos usa-se o m�todo set, e para acessar o conte�do usa-se o m�todo get, ent�o dessa forma s� acessa-se os atributos da classe pela pr�pria classe, os m�todos get e set ficam dispon�veis para todos, criando assim um acesso controlado aos atributos. */

  public function set_face($Vface){
    $this->face = $Vface;
  }
  public function get_face(){
    return $this->face;
  }

  public function set_size($Vsize){
    $this->size = $Vsize;
  }
  public function get_size(){
    return $this->size;
  }

  public function set_color($Vcolor){
    $this->color = $Vcolor;
  }
  public function get_color(){
    return $this->color;
  }

  public function set_negrito($Vnegrito){
    $this->negrito = $Vnegrito;
  }
  public function get_negrito(){
    return $this->negrito;
  }

  public function set_texto($Vtexto){
    $this->texto = $Vtexto;
  }
  public function get_texto(){
    return $this->texto;
  }

/* Este m�todo � que realmente cria o html que n�s queremos, e � muito simples mesmo, notem que o texto ser� formatado na cria��o. */

  public function cria(){
    echo "<font face='$this->face' size='$this->size' color='$this->color'>";
    if ($this->negrito == "true" or $this->negrito == "True"){
     echo "<b>";
    }
    //escreve o texto
    echo $this->texto;
    if ($this->negrito){
     echo "</b>";
    }
    echo "</font>";
  }
}
?>
