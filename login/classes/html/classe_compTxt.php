<?php

//Classe CompTxt - escreve texto em html.

// aqui nos começamos nossa classe
class compTxt {

/*Estes são os atributos da classe, notem que os atributos são precedidos da palavra "private", isto significa que esses atributos só serão acessados pela própria classe, ou seja, não será possível acessá-los de outro lugar a não ser esta classe, fique calmo você entenderá melhor mais adiante. */

  private $face;
  private $size;
  private $color;
  private $negrito;
  private $texto;


/*Este Método é chamado de construtor, pois ele é executado quando se instancia esta classe, ou seja, podemos realizar várias ações quando a classe for instanciada, basta colocar os códigos aqui e pronto. */

  public function compTxt(){

  }

/* Aqui é que resolvemos o problema de se alcançar os atributos da classe, notem para se modificar o conteúdo dos atributos usa-se o método set, e para acessar o conteúdo usa-se o método get, então dessa forma só acessa-se os atributos da classe pela própria classe, os métodos get e set ficam disponíveis para todos, criando assim um acesso controlado aos atributos. */

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

/* Este método é que realmente cria o html que nós queremos, e é muito simples mesmo, notem que o texto será formatado na criação. */

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
