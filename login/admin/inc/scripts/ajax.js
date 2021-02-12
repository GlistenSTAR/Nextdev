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
    document.getElementById('carregando').style.display="block";
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
      } else {
          //alert("Houve um problema ao obter os dados:\n" + req.statusText);
          alert("Você precisa logar no sistema\n");
      }
      document.getElementById('carregando').style.display="none";
  }
}
//POR POST
function Acha1(tela,filtro,id_htm){
    document.getElementById('carregando').style.display="block";
    id_html = null;
    id_html = id_htm;
    //alert(filtro);
    loadXMLDoc1(tela,filtro);
}
function loadXMLDoc1(url,filtro){
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
function Adiciona(Id, Nome, Destino){
  if (document.getElementById(Destino+"_id")){
    document.getElementById(Destino+"_id").value=Id;
  }
  if (document.getElementById(Destino+"_cc")){
    document.getElementById(Destino+"_cc").value=Nome;
  }
  //if (document.getElementById(id_html)){
  //  document.getElementById(id_html).innerHTML = "";
  //}
  if (document.getElementById("listar_"+Destino)){
    document.getElementById("listar_"+Destino).innerHTML = "";
  }
  return false;
}
function CalculaValorUnitario(Fator1,Fator2,ValorUnitario,CampoDestino,CampoDestino2){
  if (ValorUnitario>0){
    if (Fator1){ //Checa se veio fator do ítem
      ValorUnitario1 = Math.round(ValorUnitario * Fator1 * 100)/100;;
    }else{
      Fator1 = document.ped.desconto1_cc.value;
      if (Fator1){ //Checa se veio fator do pedido
        ValorUnitario1 = Math.round(ValorUnitario * Fator1 * 100)/100;;
      }else{
        ValorUnitario1 = ValorUnitario;
      }
    }
    if (Fator2){ //Checa se veio fator do ítem
      ValorUnitario2 = Math.round(ValorUnitario * Fator2 * 100)/100;;
    }else{
      Fator2 = document.ped.desconto2_cc.value;
      if (Fator2){ //Checa se veio fator do pedido
        ValorUnitario2 = Math.round(ValorUnitario * Fator2 * 100)/100;;
      }else{
        ValorUnitario2 = ValorUnitario;
      }
    }
    Adiciona('',ValorUnitario,'preco_venda')
    Adiciona('',ValorUnitario1,CampoDestino)
    Adiciona('',ValorUnitario2,CampoDestino2)
  }
}
function CalculaValorUnitarioDesconto(){
  if (document.ped.desconto11_cc.value){
    var Fator1 = document.ped.desconto11_cc.value;
  }else{
    var Fator1 = document.ped.desconto1_cc.value;
  }
  if (document.ped.desconto22_cc.value){
    var Fator2 = document.ped.desconto22_cc.value;
  }else{
    var Fator2 = document.ped.desconto2_cc.value;
  }
  var ValorUnitario = document.ped.preco_minimo_cc.value;
  var CampoDestino = 'valor_unitario1';
  var CampoDestino2 = 'valor_unitario2';
  
  valor_unitario_cheio = document.ped.preco_venda_cc.value
  if (Fator1){
    valor_unitario10 = valor_unitario_cheio * Fator1 ;
    document.ped.valor_unitario1_cc.value = Math.round(valor_unitario10*100)/100;
  }else{
    valor_unitario10 = valor_unitario_cheio;
    document.ped.valor_unitario1_cc.value = Math.round(valor_unitario10*100)/100;
  }
  if (Fator2){
    valor_unitario20 = valor_unitario_cheio * Fator2 ;
    document.ped.valor_unitario2_cc.value = Math.round(valor_unitario20*100)/100;
  }else{
    valor_unitario20 = valor_unitario_cheio;
    document.ped.valor_unitario2_cc.value = Math.round(valor_unitario20*100)/100;
  }
  CalculaValor();
}
function trocarAba(js_cd_aba,nr_aba){
  if (!nr_aba){nr_aba=4;}
  for(j=1; j <= nr_aba; j++){
    document.getElementById("corpo" + j).style.display = 'none';
    document.getElementById("aba" + j).innerHTML = '<div class="divAbaInativaFim"></div>';
    document.getElementById("corpoAba" + j).className = 'divAbaInativa';
  }
  document.getElementById("corpo" + js_cd_aba).style.display =  '';
  document.getElementById("aba" + js_cd_aba).innerHTML = '<div class="divAbaAtivaFim"></div>';
  document.getElementById("corpoAba" + js_cd_aba).className = 'divAbaAtiva';
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

// TESTE com POST
function ajax() {
};
ajax.prototype.iniciar = function() {

    try{
        this.xmlhttp = new XMLHttpRequest();
    }catch(ee){
        try{
            this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(E){
                this.xmlhttp = false;
            }
        }
    }
    return true;
}

ajax.prototype.ocupado = function() {
    estadoAtual = this.xmlhttp.readyState;
    return (estadoAtual && (estadoAtual < 4));
}

ajax.prototype.processa = function() {
    if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {
        return true;
    }
}

ajax.prototype.enviar = function(url, metodo, modo) {
    if (!this.xmlhttp) {
        this.iniciar();
    }
    if (!this.ocupado()) {
        if(metodo == "GET") {
            this.xmlhttp.open("GET", url, modo);
            this.xmlhttp.send(null);
        } else {
            this.xmlhttp.open("POST", url, modo);
            //this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            this.xmlhttp.setRequestHeader("Content-type", "multipart/form-data");
            this.xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
            this.xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
            this.xmlhttp.setRequestHeader("Pragma", "no-cache");
            this.xmlhttp.send(url);
        }

        if (this.processa) {
            return unescape(this.xmlhttp.responseText);
        }
    }
    return false;
}

//Fim função POST

function acerta_campos(OForm,IdRetorno, TelaRetorno, Limpar) {
    var grupo = document.getElementById(OForm).getElementsByTagName('input');
    var stri = "";
    var codigo = "";
    var descricao = "";
    var i;
    for (i = 0; i < grupo.length; i++) {
        if (grupo[i].getAttribute('type') != 'button') {
            codigo = "";
            codigo = grupo[i].name;
            if (codigo!=""){
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
    //var xmlhttp;
    //xmlhttp = new ajax();
    //id = xmlhttp.enviar('teste3.php', "POST", false); //manda adicionar
    //document.getElementById(IdRetorno).innerHTML = id;
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
  d.desconto11_cc.value = "";
  d.desconto22_cc.value = "";
  d.qtd1_cc.value = "";
  d.valor_unitario1_cc.value = "";
  d.valor_total1_cc.value = "";
  d.qtd2_cc.value = "";
  d.valor_unitario2_cc.value = "";
  d.valor_total2_cc.value = "";
  d.opcao.value = "";
  setTimeout("document.ped.codigo_cc.focus()",250);
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
function CalculaValor(Especial){
  if (document.ped.especial){
    var Especial = document.ped.especial.value;
    if (Especial==0){ Especial = "";}
  }
  var Qtd = document.ped.qtd_cc.value;
  var Desconto = document.ped.desconto.value;
  var PrecoMinimo = document.ped.preco_minimo_cc.value;
  var QtdCaixa = document.ped.qtd_caixa_cc.value;
  var ValorUnitario1 = document.ped.valor_unitario1_cc.value;
  var ValorUnitario2 = document.ped.valor_unitario2_cc.value;

  var d = document.ped; //Se trocar o form mudar aqui

  campo1='valor_total1_cc';
  campo2='valor_total2_cc';
  valor=(Math.round((ValorUnitario1 * 1000)))/1000;
  valor2=(Math.round((ValorUnitario2 * 1000)))/1000;
  qtd3=Qtd;
  if (qtd3<1){
    alert("A quantidade deve ser maior que zero");
    d.qtd_cc.focus();
    return false;
  }
  //tira virgulas
  valor = valor.toString().replace( ",", "." );
  valor2 = valor2.toString().replace( ",", "." );
  qtd3 = qtd3.toString().replace( ",", "." );

  d.valor_unitario1_cc.value = d.valor_unitario1_cc.value.toString().replace( ",", "." );
  d.valor_unitario2_cc.value = d.valor_unitario2_cc.value.toString().replace( ",", "." );

  if (ValorUnitario1 < PrecoMinimo) {
     d.valor_unitario1_cc.value =  PrecoMinimo;
     ValorUnitario1 = PrecoMinimo;
     //alert("Valor unitário (1) menor que o valor mínimo");
  }
  if (ValorUnitario1 < PrecoMinimo) {
     d.valor_unitario2_cc.value =  PrecoMinimo;
     ValorUnitario2 = PrecoMinimo;
     //alert("Valor unitário (2) menor que o valor mínimo");
  }

  if (isNaN(parseFloat(qtd3)) || isNaN(parseFloat(valor)) || isNaN(parseFloat(valor2))) {
    alert("Digite apenas pontos entre os números ex: 1.6 - Caso seja milhar digite sem pontos.");
    return false;
  }else{
    //tira virgula
    d.qtd_cc.value = d.qtd_cc.value.toString().replace( ",", "." );
    d.valor_unitario1_cc.value = (Math.round((d.valor_unitario1_cc.value * 1000)))/1000;
    d.valor_unitario2_cc.value = (Math.round((d.valor_unitario2_cc.value * 1000)))/1000;
    d.valor_unitario1_cc.value = d.valor_unitario1_cc.value.toString().replace( ",", "." );
    d.valor_unitario2_cc.value = d.valor_unitario2_cc.value.toString().replace( ",", "." );
    
    valor = (Math.round((valor * 1000)))/1000;
    valor2 = (Math.round((valor2 * 1000)))/1000;
    valor = valor.toString().replace( ",", "." );
    valor = valor.toString().replace( ",", "." );

    valor = d.valor_unitario1_cc.value;
    valor2 = d.valor_unitario2_cc.value;

    Desconto=Desconto.toString().replace( ",", "." );
    desc1=Desconto/100;
    desc2=1-desc1;
    if (!Especial){
      if (QtdCaixa>0){
        Qtd_de_Caixas = qtd3 / QtdCaixa;
        Qtd_de_Caixas = Math.ceil(Qtd_de_Caixas);
        d.qtd_cc.value = Qtd_de_Caixas * QtdCaixa;
        qtd3 = Qtd_de_Caixas * QtdCaixa;
      }
    }
    qtd1 = desc2*qtd3+0.000001;
    resto = qtd1 - Math.floor(qtd1);

    if (resto != 0){ //diferente de zero
      if (qtd1 >= 1){
        qtd1 = qtd1 - resto;
      }else{
        qtd1 = 1 ;
      }
    }
    if (!Especial){
      qtd2 = qtd3 - qtd1;
    }else{
      qtd2 = qtd1;
    }
    total1 = valor*qtd1;
    total2 = valor2*qtd2;
    //tira virgulas
    total1 = total1.toString().replace( ",", "." );
    total2 = total2.toString().replace( ",", "." );
    if (d.valor_unitario1_cc.value != ValorUnitario1){
      d.alterado1.value = 'S';
    }else{
      d.alterado1.value = 'N';
    }
    if (d.valor_unitario2_cc.value != ValorUnitario2){
      d.alterado2.value = 'S';
    }else{
      d.alterado2.value = 'N';
    }
    d[campo1].value = total1;
    d[campo2].value = total2;
    d[campo1].value = (Math.round((d[campo1].value * 100)))/100;
    d[campo2].value = (Math.round((d[campo2].value * 100)))/100;
    d[campo1].value = d[campo1].value.toString().replace( ",", "." );
    d[campo2].value = d[campo2].value.toString().replace( ",", "." );
    if (!Especial){
      d["qtd1_cc"].value = qtd1;
      d["qtd2_cc"].value = qtd2;
    }else{
      d["qtd1_cc"].value = qtd2;
      d["qtd2_cc"].value = qtd1;
    }
    CalculaValorUnitario(document.ped.desconto11_cc.value, document.ped.desconto22_cc.value, document.ped.preco_venda_cc.value,'valor_unitario1','valor_unitario2');
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
