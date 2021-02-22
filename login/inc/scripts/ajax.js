var req;
var id_html,OForm;
var nr_aba = 4;
function preload(){
 	if (document.getElementById){
    document.getElementById('preloader').style.visibility='hidden';
  }else{
 	   if (document.layers){
       document.preloader.visibility = 'hidden';
     }else{
       document.all.preloader.style.visibility = 'hidden';
     }
 	}
}

function Acha(tela,filtro,id_htm){
    document.getElementById('carregando').style.display='block';
    id_html = null;
    id_html = id_htm;
    //alert(tela);
    loadXMLDoc(tela,filtro);
}
function loadXMLDoc(url,filtro){
    req = null;
    //document.getElementById("aguarde").style.display='block';
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processa;
        req.open("GET", url+'?'+filtro, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
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
  // apenas quando o estado for "completado"
  if (req.readyState == 4) {
      // apenas se o servidor retornar "OK"
      if (req.status == 200) {
          // retornado nela, como texto HTML
          document.getElementById('Inicio').innerHTML = "";
          document.getElementById(id_html).innerHTML = req.responseText;
          //alert(id_html);
          if (id_html=="itens"){
            if (!document.getElementById('produtoinexistente')){
              setTimeout('document.ped.qtd_cc.focus()',50);
            }else{
              if (document.getElementById('codigo_cc')){
                setTimeout('document.ped.codigo_cc.focus()',50);
              }
            }
          }
          if (id_html=="cores"){
            //if (document.getElementById('preto')){
            //  document.getElementById('preto').style.display='block';
            setTimeout('document.ped.preto.focus()',50);
            //}
          }
          //alert(document.getElementById('preto').style.display);

      } else {
          //alert("Houve um problema ao obter os dados:\n" + req.statusText);
          alert("Você precisa logar no sistema\n");
      }
      document.getElementById('carregando').style.display="none";
  }
}
//POR POST
function Acha1(tela,filtro,id_htm){
    document.getElementById('carregando').style.display='block';
    id_html = null;
    id_html = id_htm;
    //alert(filtro);
    loadXMLDoc1(tela,filtro);
}
function loadXMLDoc1(url,filtro){
    req = null;
    //document.getElementById('carregando').style.display='block';
    // Procura por um objeto nativo (Mozilla/Safari)
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = processa;
        req.open("GET", url+'?'+filtro, true);
        req.send(null);
    // Procura por uma versao ActiveX (IE)
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
  // apenas quando o estado for "completado"
  if (req.readyState == 4) {
      // apenas se o servidor retornar "OK"
      if (req.status == 200) {
          // retornado nela, como texto HTML
          document.getElementById('Inicio').innerHTML = "";
          document.getElementById(id_html).innerHTML = req.responseText;
      } else {
          //alert("Houve um problema ao obter os dados:\n" + req.statusText);
          alert("Você precisa logar no sistema\n");
      }
      document.getElementById('carregando').style.display="none";
  }
}
//FIM
function voltar(tela){
  document.getElementById('carregando').style.display="block";
  go(tela);
  document.getElementById('carregando').style.display="none";
}
function Adiciona(Id, Nome, Destino,foco){
  if (document.getElementById(Destino+"_id")){
    document.getElementById(Destino+"_id").value=Id;
  }
  if (document.getElementById(Destino+"_cc")){
    document.getElementById(Destino+"_cc").value=Nome;
    if (Destino=="cliente"){
      document.getElementById(Destino+"_cc").focus();
    }
  }
  if (document.getElementById("listar_"+Destino)){
    document.getElementById("listar_"+Destino).innerHTML = "";
  }
  return false;
}
function CalculaValorUnitario(Fator1,Fator2,ValorUnitario,CampoDestino,CampoDestino2){
  /*
  Função usada em vários lugares.
  */
  var ValorUnitario1=0;
  valor_unitario_cheio = document.ped.preco_minimo_cc.value
  if (document.ped.valor_unitario_cc.value!=ValorUnitario){ //Verifica se é diferente do preço original do produto.
    if (Math.floor(document.ped.valor_unitario_cc.value)<Math.floor(valor_unitario_cheio)){ //Verifica se é menor que o valor minimo
      //ValorUnitario = valor_unitario_cheio;
      ValorUnitario = 0;
     // document.getElementById('errovalor1').innerHTML = 'Valor unitário (1) menor que o valor mínimo';
    }else{
       ValorUnitario = document.ped.valor_unitario_cc.value;
       //document.getElementById('errovalor1').innerHTML = "";
    }
  }
  if (ValorUnitario!=ValorUnitario1){
    //alert("calculavalorunitario() - Campo valor1: "+ ValorUnitario);
    Adiciona('',ValorUnitario,'preco_venda')
    //Adiciona('',ValorUnitario1,CampoDestino)
  }
}
function trocarAba(local, js_cd_aba,nr_aba){
  if (!nr_aba){nr_aba=4;}
  for(j=1; j <= nr_aba; j++){
    document.getElementById(local + "corpo" + j).style.display = 'none';
    document.getElementById(local + "aba" + j).innerHTML = '<div class="divAbaInativaFim"></div>';
    document.getElementById(local + "corpoAba" + j).className = 'divAbaInativa';
  }
  document.getElementById(local + "corpo" + js_cd_aba).style.display =  '';
  document.getElementById(local + "aba" + js_cd_aba).innerHTML = '<div class="divAbaAtivaFim"></div>';
  document.getElementById(local + "corpoAba" + js_cd_aba).className = 'divAbaAtiva';
}
function strin(str,codigo,valor) {
  if(str) {
      str = str + '&' + codigo + '=' + valor;
  } else {
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
    var grupo = document.getElementById(OForm).getElementsByTagName('input');
    var stri = "";
    var codigo = "";
    var descricao = "";
    var i;
    for (i = 0; i < grupo.length; i++) {
      codigo = "";
      codigo = grupo[i].name;
      if (grupo[i].getAttribute('type') == 'checkbox') {
        descricao = document.getElementById(codigo).checked;
        stri = strin(stri,codigo,descricao);
      }else{
        if (document.getElementById(codigo)){
          descricao = document.getElementById(codigo).value;
          stri = strin(stri,codigo,descricao);
        }
      }
    }
    var grupo = document.getElementById(OForm).getElementsByTagName('select');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        descricao = document.getElementById(codigo).value;
        stri = strin(stri,codigo,descricao);
    }
    var grupo = document.getElementById(OForm).getElementsByTagName('textarea');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        descricao = document.getElementById(codigo).value;
        stri = strin(stri,codigo,descricao);
    }
    if (Limpar){document.getElementById(IdRetorno).innerHTML = "";}
    Acha(TelaRetorno , stri , IdRetorno)
}
function testa_campo_credito() {
  if (isNaN(document.cliente.limitecredito.value)) {
    alert("Campo tem que ser numérico");
    document.cliente.limitecredito.focus();
  }
}
function LimpaCamposItens(){
  var d = document.ped;
  d.codigo_cc.value = "";
  d.descricao_cc.value = "";
  d.qtd_cc.value = "";
  d.ipi_cc.value = "";
  d.valor_unitario_cc.value = "";
  d.valor_total_cc.value = "";
  d.opcao.value = "";
}
function testa_campo_suframa() {
  if (isNaN(document.cliente.codigosuframa.value)) {
    alert("Campo tem que ser numérico");
    document.cliente.codigosuframa.focus();
  }
}
function FormataValor(campo){
  if (campo.length>"3"){
    if (campo.length>"5"){
      campo.value = campo.value.toString().replace( ",", "." );
      campo.value = campo.value+".";
    }else{
      campo.value = campo.value+".";
    }
  }
}
function calculavalor(){
  if (document.ped.especial){
    var Especial = document.ped.especial.value;
    if (Especial==0){ Especial = "";}
  }
  var Qtd = document.ped.qtd_cc.value;
  var Desconto = document.ped.desconto.value;
  var PrecoMinimo = document.ped.preco_minimo_cc.value;
  var QtdCaixa = document.ped.qtd_caixa_cc.value;
  var ValorUnitario1 = document.ped.valor_unitario_cc.value;

  var d = document.ped; //Se trocar o form mudar aqui

  var valor, valor2, qtd1,qtd2,qtd3,total1,total2;

  campo1='valor_total_cc';
  
  valor  = (Math.round(ValorUnitario1 * 100))/100;

  qtd3=Qtd;
  if (qtd3<1){
    //alert("A quantidade deve ser maior que zero");
    d.qtd_cc.focus();
    return false;
  }
  //tira virgulas
  valor = valor.toString().replace( ",", "." );

  //alert("calculavalor() - Campo valor: "+valor);

  qtd3 = qtd3.toString().replace( ",", "." );

  d.valor_unitario_cc.value = d.valor_unitario_cc.value.toString().replace( ",", "." );
  //alert(ValorUnitario1+" <<< Valor unit --------- Preco minimo >> "+PrecoMinimo);
  if (Math.floor(ValorUnitario1)<Math.floor(PrecoMinimo)) {
     d.valor_unitario_cc.value = 0;
     ValorUnitario1 = 0;
     document.getElementById('errovalor1').innerHTML = 'Valor unitário inválido';
     //d.valor_unitario1_cc.value =  PrecoMinimo;
     //ValorUnitario1 = PrecoMinimo;
  }else{
     document.getElementById('errovalor1').innerHTML = "";
  }
  //Esconde o botão Ok
  if (Desconto>0){
    if (ValorUnitario1==0){
      document.getElementById('Ok').style.display = 'none';
    }else{
      if (document.getElementById('Ok').style.display=="none"){
        document.getElementById('Ok').style.display = 'block';
        document.getElementById('Ok').focus();
      }
    }
  }else{
    if (ValorUnitario1==0){
      document.getElementById('Ok').style.display = 'none';
    }else{
      if (document.getElementById('Ok').style.display=="none"){
        document.getElementById('Ok').style.display = 'block';
        document.getElementById('Ok').focus();
      }
    }
  }
  //alert(ValorUnitario1+" <<< Valor unit --------- Preco minimo >> "+PrecoMinimo);
  //alert("Valor unitário (2) menor que o valor mínimo");
  if (isNaN(parseFloat(qtd3)) || isNaN(parseFloat(valor))) {
    alert("Digite apenas pontos entre os números ex: 1.6 - Caso seja milhar digite sem pontos.");
    return false;
  }else{
    //tira virgula
    d.qtd_cc.value = d.qtd_cc.value.toString().replace( ",", "." );
    d.valor_unitario_cc.value = (Math.round((d.valor_unitario_cc.value * 100)))/100;
    d.valor_unitario_cc.value = d.valor_unitario_cc.value.toString().replace( ",", "." );

    valor = d.valor_unitario_cc.value;

    Desconto=Desconto.toString().replace( ",", "." );
    desc1=Desconto/100;
    //desc2=1-desc1;
//    if (!Especial){
//      if (QtdCaixa>0){
//        Qtd_de_Caixas = qtd3 / QtdCaixa;
//        Qtd_de_Caixas = Math.ceil(Qtd_de_Caixas);
//        d.qtd_cc.value = Qtd_de_Caixas * QtdCaixa;
//        qtd3 = Qtd_de_Caixas * QtdCaixa;
//      }
//    }
    qtd1 = qtd3;
//    resto = qtd1;
//
//    if (resto != 0){ //diferente de zero
//      if (qtd1 >= 1){
//        qtd1 = qtd1 - resto;
//      }else{
//        qtd1 = 1 ;
//      }
//    }
    //if (!Especial){
//      qtd2 = qtd3 - qtd1;
    //}else{
    //  qtd2 = qtd1;
    //}
    total1 = valor*qtd1;
    //tira virgulas
    total1 = total1.toString().replace( ",", "." );
    if (d.valor_unitario_cc.value != ValorUnitario1){
      d.alterado1.value = 'S';
    }else{
      d.alterado1.value = 'N';
    }
    //alert(total1+"<<Total1 ----- Total2>>"+total2);
    d[campo1].value = total1;
    d[campo1].value = (Math.round((d[campo1].value * 100)))/100;
//    d[campo2].value = (Math.round((d[campo2].value * 100)))/100;
    d[campo1].value = d[campo1].value.toString().replace( ",", "." );
//    d[campo2].value = d[campo2].value.toString().replace( ",", "." );
//    //if (!Especial){
      d["qtd_cc"].value = qtd1;
//      d["qtd2_cc"].value = qtd2;
    //}else{
//      d["qtd1_cc"].value = qtd2;
    //  d["qtd2_cc"].value = qtd1;
    //}
    CalculaValorUnitario('', '', document.ped.preco_venda_cc.value,'valor_unitario','');
  }
}
function TeclaEnter(e){
  var whichCode = (window.Event) ? e.which : e.keyCode;
  //alert(whichCode);
  if (whichCode == 13){
    if(e.preventDefault)
      e.preventDefault()
    else
      e.returnValue = false;
    return true;
  }
}
function DisableEnableForm(xForm,xHow){
  objElems = xForm.elements;
  for(i=0;i<objElems.length;i++){
    objElems[i].disabled = xHow;
  }
}
function tabindex (campo,destino){
  //alert(document.getElementById(campo).tabIndex);
  var elem=document.getElementById(destino);
  //alert(elem.tabIndex);
  //alert("Nome: " +elem.parentNode.parentNode.parentNode.parentNode.nodeName + " - Valor: " + elem.parentNode.parentNode.parentNode.parentNode.nodeValue + " - Tipo:" + elem.parentNode.parentNode.parentNode.parentNode.nodeType);
  elem.tabIndex = document.getElementById(campo).tabIndex + 1
}
function moveto(obj1, chars, obj2){
//if(obj1.value.length == chars)
  obj2.focus();
}

function mesmocobranca() {
  var d = document.cad;
  if (d.MesmoCobranca.checked){
    d.cep_cobranca.value=d.cep.value;
    d.endereco_cobranca.value=d.endereco.value;
    d.cidade_cobranca.value=d.cidade.value;
    d.bairro_cobranca.value=d.bairro.value;
    d.estado_cobranca.value=d.estado.value;
    d.telefone_cobranca.value=d.telefone.value;
  }else{
    d.cep_cobranca.value="";
    d.endereco_cobranca.value="";
    d.cidade_cobranca.value="";
    d.bairro_cobranca.value="";
    d.estado_cobranca.value="";
    d.telefone_cobranca.value="";
  }
}
function mesmoentrega() {
  var d = document.cad;
  if (d.MesmoEntrega.checked){
    d.cep_entrega.value=d.cep.value;
    d.endereco_entrega.value=d.endereco.value;
    d.cidade_entrega.value=d.cidade.value;
    d.bairro_entrega.value=d.bairro.value;
    d.estado_entrega.value=d.estado.value;
    d.telefone_entrega.value=d.telefone.value;
  }else{
    d.cep_entrega.value="";
    d.endereco_entrega.value="";
    d.cidade_entrega.value="";
    d.bairro_entrega.value="";
    d.estado_entrega.value="";
    d.telefone_entrega.value="";
  }
}
