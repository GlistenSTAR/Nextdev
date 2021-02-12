var req;
var id_html,OForm;
var nr_aba = 4;
function $(id) { return document.getElementById(id); }
function preload(){
 	if (document.getElementById){
    $('preloader').style.visibility='hidden';
  }else{
 	   if (document.layers){
       document.preloader.visibility = 'hidden';
     }else{
       document.all.preloader.style.visibility = 'hidden';
     }
 	}
}
function Acha(tela,filtro,id_htm){
    if ($('carregando')){$('carregando').style.display='block';}
    id_html = null;
    id_html = id_htm;
    loadXMLDoc(tela,filtro);
}
function loadXMLDoc(url,filtro){
    req = null;
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processa;
        req.open("GET", url+'?'+filtro, true);
        req.send(null);
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processa;
            req.open("GET", url+'?'+filtro, true);
            req.send();
        }
    }
}
function processa(){
  if (req.readyState == 4) {
      if (req.status == 200) {
          $('Inicio').innerHTML = "";
          $(id_html).innerHTML = req.responseText;
          if (id_html=="itens"){
            if (!$('produtoinexistente')){
              setTimeout('document.ped.qtd_cc.focus()',50);
            }else{
              if ($('codigo_cc')){
                setTimeout('document.ped.codigo_cc.focus()',50);
              }
            }
          }
          if (id_html=="cores"){
            setTimeout('document.ped.preto.focus()',50);
          }
      } else {
          alert("Você precisa logar no sistema\n");
      }
      if ($('carregando')){$('carregando').style.display="none";}
  }
}
function Acha1(tela,filtro,id_htm){
    if ($('carregando')){$('carregando').style.display='block';}
    id_html = null;
    id_html = id_htm;
    loadXMLDoc1(tela,filtro);
}
function loadXMLDoc1(url,filtro){
    req = null;
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processa;
        req.open("GET", url+'?'+filtro, true);
        req.send(null);
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = processa;
            req.open("GET", url+'?'+filtro, true);
            req.send();
        }
    }
}
function processa1(){
  if (req.readyState == 4) {
      if (req.status == 200) {
          $('Inicio').innerHTML = "";
          $(id_html).innerHTML = req.responseText;
      } else {
          alert("Você precisa logar no sistema\n");
      }
      if ($('carregando')){$('carregando').style.display="none";}
  }
}
function Adiciona(Id, Nome, Destino,foco){
  if ($(Destino+"_id")){
    $(Destino+"_id").value=Id;
  }
  if ($(Destino)){
    $(Destino).value=Nome;
  }
  if ($(Destino+"_cc")){
    $(Destino+"_cc").value=Nome;
    if (Destino=="cliente"){
      $(Destino+"_cc").focus();
    }
  }
  if ($("listar_"+Destino)){
    $("listar_"+Destino).innerHTML = "";
  }
  return false;
}
/*
@ Função usada em vários lugares.


*/
function CalculaValorUnitario(Fator1,Fator2,ValorUnitario,CampoDestino,CampoDestino2){
  var ValorUnitario1=0, ValorUnitario2=0; ValorUnitario22=0; d=document.ped;;
  Alterado1 = (d.alterado1.value)? d.alterado1.value:"N";
  Alterado2 = (d.alterado2.value)? d.alterado2.value:"N";
  valor_unitario_cheio = d.preco_minimo_cc.value
  if (d.valor_unitario1_cc.value!=ValorUnitario){
    if (Math.floor(d.valor_unitario1_cc.value)<Math.floor(valor_unitario_cheio) && d.confereminimo.value=="true"){ //Verifica se é menor que o valor minimo
      ValorUnitario = 0;
    }else{
       ValorUnitario = d.valor_unitario1_cc.value;
    }
  }
  ValorUnitario22 = ValorUnitario;
  if (d.valor_unitario2_cc.value!=ValorUnitario22){ //Verifica se é diferente do preço original do produto.
    if (Math.floor(d.valor_unitario2_cc.value)<Math.floor(valor_unitario_cheio) && d.confereminimo.value=="true"){ //Verifica se é menor que o valor minimo
      ValorUnitario22 = 0;
    }else{
       ValorUnitario22 = d.valor_unitario2_cc.value;
    }
  }
  if (ValorUnitario>0){
    if (Fator1>0 && Alterado1=="N"){ //Checa se veio fator do ítem
      ValorUnitario1 = Math.round(ValorUnitario * Fator1 * 100)/100;
      Alterado1="S";
    }else{
      if (d.desconto1_cc){
        Fator1 = d.desconto1_cc.value;
      }else{
        Fator1 = 0;
      }
      if (Fator1>0 && Alterado1=="N"){ //Checa se veio fator do pedido
        ValorUnitario1 = Math.round(ValorUnitario * Fator1 * 100)/100;;
        Alterado1="S";
      }else{
        ValorUnitario1 = ValorUnitario;
      }
    }
    if (Fator2>0 && Alterado2=="N"){ //Checa se veio fator do ítem
      ValorUnitario2 = Math.round(ValorUnitario22 * Fator2 * 100)/100;;
      Alterado2="S";
    }else{
      if (d.desconto2_cc){
        Fator2 = d.desconto2_cc.value;
      }else{
        Fator2 = 0;
      }
      if (Fator2>0 && Alterado2=="N"){ //Checa se veio fator do pedido
        ValorUnitario2 = Math.round(ValorUnitario22 * Fator2 * 100)/100;;
        Alterado2="S";
      }else{
        ValorUnitario2 = ValorUnitario22;
      }
    }
    Adiciona('',Alterado1,'alterado1')
    Adiciona('',Alterado2,'alterado2')
    Adiciona('',ValorUnitario1,CampoDestino)
    Adiciona('',ValorUnitario2,CampoDestino2)
  }
}
function CalculaValorUnitarioDesconto(){
  var d = document.ped;
  var Fator1 = (d.desconto11_cc.value>0) ? d.desconto11_cc.value : d.desconto1_cc.value;
  var Fator2 = (d.desconto22_cc.value>0) ? d.desconto22_cc.value : d.desconto2_cc.value;
  var ValorUnitario = d.preco_minimo_cc.value;
  var CampoDestino = 'valor_unitario1';
  var CampoDestino2 = 'valor_unitario2';
  valor_unitario_cheio = d.preco_venda_cc.value
  if (Fator1>0){
    valor_unitario10 = valor_unitario_cheio * Fator1 ;
    d.valor_unitario1_cc.value = Math.round(valor_unitario10*100)/100;
  }else{
    if (Math.floor(d.valor_unitario1_cc.value)<Math.floor(d.preco_minimo_cc.value)) {
      d.valor_unitario1_cc.value = 0;
    }
  }
  if (Fator2>0){
    valor_unitario20 = valor_unitario_cheio * Fator2 ;
    d.valor_unitario2_cc.value = Math.round(valor_unitario20*100)/100;
  }else{
    if (Math.floor(d.valor_unitario2_cc.value)<Math.floor(d.preco_minimo_cc.value)) {
      d.valor_unitario2_cc.value = 0;
    }
  }
  calculavalor();
}
function trocarAba(js_cd_aba,nr_aba){
  if (!nr_aba){return false;}
  for(j=1; j <= nr_aba; j++){
    $("corpo" + j).style.display = 'none';
    $("aba" + j).innerHTML = '<div class="divAbaInativaFim"></div>';
    $("corpoAba" + j).className = 'divAbaInativa';
  }
  $("corpo" + js_cd_aba).style.display =  '';
  $("aba" + js_cd_aba).innerHTML = '<div class="divAbaAtivaFim"></div>';
  $("corpoAba" + js_cd_aba).className = 'divAbaAtiva';
}
function strin(str,codigo,valor){
  if(str){
    str = str + '&' + codigo + '=' + valor;
  }else{
    str = codigo + '=' + valor;
  }
  return str;
}
function funcRev(){
  this.pos = "";
  for (var i=this.length; i>-1; i--){
    this.pos += this.charAt(i);
  }
  return this.pos;
}
String.prototype.reversao = funcRev;
function acerta_campos(OForm,IdRetorno, TelaRetorno, Limpar) {
    var grupo=$(OForm).getElementsByTagName('input');
    var stri="", codigo="",descricao="",i;
    for (i = 0; i < grupo.length; i++) {
      codigo = "";
      codigo = grupo[i].name;
      if (grupo[i].getAttribute('type') == 'checkbox') {
        descricao = $(codigo).checked;
        stri = strin(stri,codigo,descricao);
      }else{
        if ($(codigo)){
          descricao = $(codigo).value;
          stri = strin(stri,codigo,descricao);
        }
      }
    }
    var grupo = $(OForm).getElementsByTagName('select');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        if ($(codigo)){
          descricao = $(codigo).value;
          stri = strin(stri,codigo,descricao);
        }
    }
    var grupo = $(OForm).getElementsByTagName('textarea');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        if ($(codigo)){
          descricao = $(codigo).value;
          stri = strin(stri,codigo,descricao);
        }
    }
    if (Limpar){$(IdRetorno).innerHTML = "";}
    Acha(TelaRetorno , stri , IdRetorno);
}
