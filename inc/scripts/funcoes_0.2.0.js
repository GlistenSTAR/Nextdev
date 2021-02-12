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
  var Arredondamento = parseFloat(document.ped.arredondamento.value.replace(",","."));
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
  ValorUnitario = ValorUnitario.toString().replace( ",", "." );
  ValorUnitario22 = ValorUnitario22.toString().replace( ",", "." );
  if (ValorUnitario>0){
    if (Fator1>0 && Alterado1=="N"){ //Checa se veio fator do ítem
//      ValorUnitario1 = Math.round(ValorUnitario * Fator1 * Arredondamento)/Arredondamento;
      ValorUnitario1 = Math.round(ValorUnitario * Arredondamento)/Arredondamento;
      ValorUnitario11 = Math.round(ValorUnitario * Arredondamento)/Arredondamento;
      Alterado1="S";
    }else{
      if (d.desconto1_cc){
        Fator1 = d.desconto1_cc.value;
      }else{
        Fator1 = 0;
      }
      if (Fator1>0 && Alterado1=="N"){ //Checa se veio fator do pedido
//        ValorUnitario1 = Math.round(ValorUnitario * Fator1 * Arredondamento)/Arredondamento;;
        ValorUnitario1 = Math.round(ValorUnitario * Arredondamento)/Arredondamento;;
        Alterado1="S";
      }else{
        ValorUnitario1 = ValorUnitario;
      }
    }
    //alert("Original: "+ValorUnitario+" - Mudado"+ValorUnitario1+" - Mudado 2"+ValorUnitario11);
    if (Fator2>0 && Alterado2=="N"){ //Checa se veio fator do ítem
//      ValorUnitario2 = Math.round(ValorUnitario22 * Fator2 * Arredondamento)/Arredondamento;;
      ValorUnitario2 = Math.round(ValorUnitario22 * Arredondamento)/Arredondamento;;
//      Alterado2="S";
//      alert("#1 ValorUnitario2: " + ValorUnitario2);
    }else{
      if (d.desconto2_cc){
        Fator2 = d.desconto2_cc.value;
      }else{
        Fator2 = 0;
      }
      if (Fator2>0 && Alterado2=="N"){ //Checa se veio fator do pedido
        //ValorUnitario2 = Math.round(ValorUnitario22 * Fator2 * Arredondamento)/Arredondamento;;
        ValorUnitario2 = Math.round(ValorUnitario22 * Arredondamento)/Arredondamento;;
        Alterado2="S";
//        alert("#2 ValorUnitario2: " + ValorUnitario2 + "#2 ValorUnitario22: " + ValorUnitario22 + "#2 fator: " + Fator2);
      }else{
        ValorUnitario2 = ValorUnitario22;
//        alert("#3 ValorUnitario2: " + ValorUnitario2);
      }
    }
//    Adiciona('',Alterado1,'alterado1')
//    Adiciona('',Alterado2,'alterado2')
    Adiciona('',ValorUnitario1,CampoDestino)
    Adiciona('',ValorUnitario2,CampoDestino2)
  }
}
function CalculaValorUnitarioDesconto(){
  var d = document.ped;
  var Arredondamento = parseFloat(document.ped.arredondamento.value.replace(",","."));
  var Fator1 = (d.desconto11_cc.value>0) ? d.desconto11_cc.value : d.desconto1_cc.value;
  var Fator2 = (d.desconto22_cc.value>0) ? d.desconto22_cc.value : d.desconto2_cc.value;
  var ValorUnitario = d.preco_minimo_cc.value;
  var CampoDestino = 'valor_unitario1';
  var CampoDestino2 = 'valor_unitario2';
  valor_unitario_cheio = d.preco_venda_cc.value
  if (Fator1>0){
//    valor_unitario10 = valor_unitario_cheio * Fator1 ;
    valor_unitario10 = valor_unitario_cheio;
    d.valor_unitario1_cc.value = Math.round(valor_unitario10*Arredondamento)/Arredondamento;
  }else{
    if (Math.floor(d.valor_unitario1_cc.value)<Math.floor(d.preco_minimo_cc.value)) {
      d.valor_unitario1_cc.value = 0;
    }
  }
  if (Fator2>0){
//    valor_unitario20 = valor_unitario_cheio * Fator2 ;
    valor_unitario20 = valor_unitario_cheio;
    d.valor_unitario2_cc.value = Math.round(valor_unitario20*Arredondamento)/Arredondamento;
  }else{
    if (Math.floor(d.valor_unitario2_cc.value)<Math.floor(d.preco_minimo_cc.value)) {
      d.valor_unitario2_cc.value = 0;
    }
  }
  //calculavalor();
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
          descricao = encodeURIComponent($(codigo).value);
          stri = strin(stri,codigo,descricao);
        }
      }
    }
    var grupo = $(OForm).getElementsByTagName('select');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        if ($(codigo)){
          descricao =encodeURIComponent($(codigo).value);
          stri = strin(stri,codigo,descricao);
        }
    }
    var grupo = $(OForm).getElementsByTagName('textarea');
    for (i = 0; i < grupo.length; i++) {
        codigo    = grupo[i].name;
        if ($(codigo)){
          descricao = encodeURIComponent($(codigo).value);
          stri = strin(stri,codigo,descricao);
        }
    }
    if (Limpar){$(IdRetorno).innerHTML = "";}
     Acha(TelaRetorno , stri , IdRetorno);
}
function registracores() {
  calculavalor();
  if (d.optcores.checked){
    $('divAbaGeral').style.display='none';
    $('cores').style.display='block';
    $('codigo_cores').innerHTML = d.codigo_cc.value;
    $('qtd_cores').innerHTML=d.qtd_cc.value;
    $('falta_cores').innerHTML=d.qtd_cc.value;
  }else{
    LimpaCamposItens();
  }
}

function ParcelaMinima(){
  var d = document.ped;
  var Arredondamento = parseFloat(document.ped.arredondamento.value.replace(",","."));
  var TotalPedido = parseFloat(d.botao_total.value.toString().replace(".", "" ));
  if (d.botao_total1){
    var TotalPedidoNormal = parseFloat(d.botao_total1.value.toString().replace(".", "" ));
  }else{
    var TotalPedidoNormal = parseFloat(d.botao_total.value.toString().replace(".", "" ));
  }
  var CodigoEmpresa = d.codigo_empresa.value;
  var QtdParcelas = (d.vezes)?parseInt(d.vezes.value):"1";
  var ValorParcelaMinima = d.ValorParcelaMinima.value;
  var ValorDaParcela = TotalPedido / QtdParcelas;
  QtdParcelas2 = (d.vezes2) ? parseInt(d.vezes2.value) : null;
  var ValorDaParcela2 = TotalPedido / QtdParcelas2;
  var ret=true, msg='';
  if ((CodigoEmpresa=="75") && (ValorParcelaMinima>1)){ //Perlex
    if (TotalPedidoNormal<480){
      msg = "O valor está abaixo do mínimo.\n";
      trocarAba(1,3);
      setTimeout('document.ped.condpag1_id.focus()',250);
      ret=false;
    }
  }
  if (ValorDaParcela<ValorParcelaMinima){
    msg = "Condição de pagamento 1 inválida para esse pedido.\n";
    trocarAba(1,3);
    setTimeout('document.ped.condpag1_id.focus()',250);
    ret=false;
  }
  if (ValorDaParcela2<ValorParcelaMinima){
    msg +="Condição de pagamento 2 inválida para esse pedido.\n";
    trocarAba(1,3);
    setTimeout('document.ped.condpag2_id.focus()',250);
    ret=false;
  }
  (msg) ? alert(msg) : null;
  return ret;
}

function cores(){
  var d = document.ped;
  var fl=0;
  var Br = (d.branco.value>0)? parseInt(d.branco.value) : 0;
  var Az = (d.azul.value>0)? parseInt(d.azul.value) : 0;
  var Vd = (d.verde.value>0)? parseInt(d.verde.value) : 0;
  var Vm = (d.vermelho.value>0)? parseInt(d.vermelho.value) : 0;
  var Am = (d.amarelo.value>0)? parseInt(d.amarelo.value) : 0;
  var Ma = (d.marrom.value>0)? parseInt(d.marrom.value) : 0;
  var Ci = (d.cinza.value>0)? parseInt(d.cinza.value) : 0;
  var La = (d.laranja.value>0)? parseInt(d.laranja.value) : 0;
  var Ro = (d.rosa.value>0)? parseInt(d.rosa.value) : 0;
  var Vi = (d.violeta.value>0)? parseInt(d.violeta.value) : 0;
  var Be = (d.bege.value>0)? parseInt(d.bege.value) : 0;
  var Ou = (d.outra.value>0)? parseInt(d.outra.value) : 0;
  var Pr = (d.preto.value>0)? parseInt(d.preto.value) : 0;
  var Qtd = (d.qtd_cores.value>0)? parseInt(d.qtd_cores.value) : 0;

  fl = Qtd - (Pr+Br+Az+Vd+Vm+Am+Ma+Ci+La+Ro+Vi+Be+Ou);
  $('falta_cores1').value = parseInt(fl);
}
function gravacores(conferir) {
  var d = document.ped;
  if (conferir){
    if (d.falta_cores1.value==0){
      if (confirm('A divisão de cores está correta?')){
        acerta_campos('cores','cores','confere_cores.php', true);
        $('cores').style.display='none';
        trocarAba(2,3);
        $('botoes').style.display='block';
        acerta_campos('pedido','GrdProdutos','incluir_itens.php',true);
        setTimeout('d.codigo_cc.focus()',50);
        Acha('incluir_itens.php', 'numero='+d.numero.value+'', 'GrdProdutos')
        LimpaCamposItens();
      }
    }else if(d.falta_cores1.value>0){
      alert('Falta dividir alguns itens.');
      setTimeout('d.preto.focus()',50);
    }else{
      alert('Foram divididos mais itens que o máximo permitido.');
      setTimeout('d.preto.focus()',50);
    }
  }else{
    $('cores').style.display='none';
    //$('divAbaGeral').style.display='block';
    $('botoes').style.display='block';
    trocarAba(2,3);
    //$('confere_cores').innerHTML='';
    Acha('incluir_itens.php', 'acao=excluir&numero='+d.numero.value+'&codigo='+d.codigo_cc.value+'', 'GrdProdutos');
    Acha('incluir_itens.php', 'numero='+d.numero.value+'', 'GrdProdutos')
    LimpaCamposItens();

  }
}
function checkMail(mail){
  var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
  if(typeof(mail) == "string"){
    if(er.test(mail)){ return true; }
  }else if(typeof(mail) == "object"){
    if(er.test(mail.value)){
      return true;
    }
  }else{
    return false;
  }
}
function ChecaPedido1(){
  if ((document.ped.desconto.value!="0") && (document.ped.desconto.value!="50")){
    alert('São permitidos somente os valores 0 e 50');
    document.ped.desconto.value=0;
  }
  var d = document.ped;
  var msg='';
  /* Acrescentado por Emerson a pedido do Roberto 06/01/2009
  * Checagem de data de entrega, deve permitir datas > que 15 dias da data de emissão
  ************************************************************************************/
  var now = new Date();
  //var dia15 = now.getDate() + 0;
  var dia15 = now.getDate() + 0;
  var mes = now.getMonth() + 1;
  mes = (mes<10) ? "0" + mes : mes;
  var DataMaxima = parseInt(now.getFullYear() + "" + mes + "" + dia15);
  var Data = d.data_entrega.value;
  Data = parseInt( Data.split( "/" )[2].toString() + Data.split( "/" )[1].toString() + Data.split( "/" )[0].toString() )
  if (Data<DataMaxima){
    //msg = "A data de entrega deve ser no mínimo 1 dia corridos a partir da data de emissão do pedidos\n";
    msg = "A data de entrega não pode ser menor que a data de hoje\n";
  }
  /** 06/01/2009 */
  if (!$('trans_cc').value){
    msg += "Confira a transportadora\n";
  }
  if (!$('condpag1_id').value){
    msg += "Confira a condição de pagamento 1\n";
  }
  if (!checkMail($('email_nfe').value)){
    msg += "Digite um endereço de E-mail NFE válido\n";
  }
  if ($('desconto').value>0){
    if (!$('condpag2_id').value){
      msg += "Confira a condição de pagamento 2\n";
    }
  }
  if (!$('tipo_frete').value){
    msg += "Selecione a opção de frete\n";
  }
  if ($('data_entrega').value.length<10){
    msg += "Deve existir uma data de entrega\n";
  }
  if (d.desconto1_cc.style.display=='block'){
    if (!$('desconto1_cc').value){msg = msg + "Selecione o fator de desconto 1\n";}
    if ($('desconto').value>0){
      if (!$('desconto2_cc').value){msg = msg + "Selecione o fator de desconto 2\n";}
    }
  }
  /*
  Solicitado retirar o termo, o ideal é ser sobre o pagamento.
  if ($('termo')){
    if (!$('termo').checked){
      msg = msg + "Você precisa marcar o termo de responsabilidade\n";
    }
  }
  */
  if ($('tipo_pedido')){
    if (!$('tipo_pedido').value){
      msg += "Você precisa selecionar um tipo de pedido\n";
    }
  }
  if (msg){
    alert(msg);
    return false;
  }else{
    Acha('inc/ParcelaMinima.php', 'cod_pag='+d.condpag1_id.value+'', 'qtdParcelas') //Preenche qtdParcelas
    if ($('condpag2_id')){ Acha('inc/ParcelaMinima.php', 'cod_pag2='+d.condpag2_id.value+'', 'qtdParcelas2');}
    $('corpoAba2').style.display='block';
    $('aba2').style.display='block';
    trocarAba(2,3);
  }
  return true;
}
function ChecaPedido2(){
  var d = document.ped;
  if (!$('vezes')){
    if ($('vezes').value){
      Acha('inc/ParcelaMinima.php', 'cod_pag='+d.condpag1_id.value+'', 'qtdParcelas');
    }
    if ($('vezes2')){
      if ($('vezes2').value){
        Acha('inc/ParcelaMinima.php', 'cod_pag2='+d.condpag2_id.value+'', 'qtdParcelas2');
      }
    }
  }else{
    if (d.desconto.style.display=='none'){
      if (ParcelaMinima()){
        $('corpoAba3').style.display='block';
        $('aba3').style.display='block';
        trocarAba(3,3);
      }
    }else{
      alert("Esse pedido deve ter pelo menos um ítem\n");
    }
  }
  return true;
}
function editaritens(cores){
  var d = document.ped;
  calculavalor();
  d.descontocores.value=d.desconto.value;
  d.desc2.value="";
  d.descricao_cc.value="";
  if (cores){
    if (d.optcores.checked){
      if (d.codigo_cc.value){
        acerta_campos('pedido','GrdProdutos','incluir_itens.php',true);
        $('cores').style.display='block';
        if ($('botoes')){$('botoes').style.display='none';}
        acerta_campos('itens','cores','cores.php',true);
      }
    }else{
      acerta_campos('pedido','GrdProdutos','incluir_itens.php',true);
      setTimeout('d.codigo_cc.focus()',50);
      LimpaCamposItens();
    }
  }else{
    acerta_campos('pedido','GrdProdutos','incluir_itens.php',true);
    setTimeout('d.codigo_cc.focus()',50);
    LimpaCamposItens();
  }
  $('boxdesconto').innerHTML=d.desconto.value;
  if (d.desconto.style.display!='none'){InverteEstado('opcoes_empresa'); }
  d.desconto.style.display='none';
  $('Prossiga2').style.display='block';
}

function listarpedidos (tipo) {
  if (tipo=="pedidos_clientes"){
    Acha('relatorios/pedidos_clientes.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&pedidos_clientes_id='+document.listar.pedidos_clientes_id.value+'&pedidos_clientes_cc='+document.listar.pedidos_clientes_cc.value+'&numero_pedido='+document.listar.numero_pedido.value+'&tipo='+tipo+'','Conteudo');
  }else if (tipo=="itens_cores"){
    Acha('relatorios/itens_cores.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&pedidos_clientes_id='+document.listar.pedidos_clientes_id.value+'&pedidos_clientes_cc='+document.listar.pedidos_clientes_cc.value+'&numero_pedido='+document.listar.numero_pedido.value+'&tipo='+tipo+'','Conteudo');
  }else if (tipo=="previsao_pedido"){
    Acha('relatorios/previsao_pedido.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&pedidos_clientes_id='+document.listar.pedidos_clientes_id.value+'&pedidos_clientes_cc='+document.listar.pedidos_clientes_cc.value+'&numero_pedido='+document.listar.numero_pedido.value+'&tipo='+tipo+'','Conteudo');
  }else if (tipo=="faturamento"){
    if(document.listar.nao_canceladas.checked){
      var CheckNC = 1;
    }else{
      var CheckNC = 0;
    }
    Acha('relatorios/faturamento.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&pedidos_clientes_id='+document.listar.pedidos_clientes_id.value+'&pedidos_clientes_cc='+document.listar.pedidos_clientes_cc.value+'&numero_pedido='+document.listar.numero_pedido.value+'&tipo='+tipo+'&id_natureza='+document.listar.id_natureza.value+'&nao_canceladas='+CheckNC+'','Conteudo');
  }else{
    if (document.listar.data_inicial.value){
      if (document.listar.numero_pedido.value){
        window.open('impressao.php?&numero='+document.listar.numero_pedido.value+'&t=1','_blank');
      }else{
        Acha('listar_pedidos.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&tipo_data='+document.listar.tipo_data.value+'&numero_pedido='+document.listar.numero_pedido.value+'&status_pedido='+document.listar.status_pedido.value+'&tipo='+tipo+'&vendedor2_id='+document.listar.vendedor2_id.value+'','Conteudo');
      }
    }
  }
}

function listarclientes (tipo) {
        Acha('listar_clientes.php','','Conteudo');
}

function habilitapagto2(){
  //alert(document.ped.desconto.value);
  if ((document.ped.desconto.value!="0") && (document.ped.desconto.value!="50")){
    alert('São permitidos somente os valores 0 e 50');
    document.ped.desconto.value=0;
  }else{
    var opcao;
    opcao= (document.ped.desconto.value>0) ? 'block' : 'none';
    $('box-labelpagto2').style.display=opcao;
    $('box-dadospagto2').style.display=opcao;
    ($('box-labeldesc2')) ? $('box-labeldesc2').style.display=opcao : null;
    ($('box-dadosdesc2')) ? $('box-dadosdesc2').style.display=opcao : null;
  }
}

function isCPFCNPJ(campo,pType){
   if( isEmpty( campo ) ){return false;}

   var campo_filtrado = "", valor_1 = " ", valor_2 = " ", ch = "";
   var valido = false;

   for (i = 0; i < campo.length; i++){
      ch = campo.substring(i, i + 1);
      if (ch >= "0" && ch <= "9"){
         campo_filtrado = campo_filtrado.toString() + ch.toString()
         valor_1 = valor_2;
         valor_2 = ch;
      }
      if ((valor_1 != " ") && (!valido)) valido = !(valor_1 == valor_2);
   }
   if (!valido) campo_filtrado = "12345678912";

   if (campo_filtrado.length < 11){
      for (i = 1; i <= (11 - campo_filtrado.length); i++){campo_filtrado = "0" + campo_filtrado;}
   }

	if(pType <= 1){
		if ( ( campo_filtrado.substring(9,11) == checkCPF( campo_filtrado.substring(0,9) ) ) && ( campo_filtrado.substring(11,12)=="") ){return true;}
	}

	if((pType == 2) || (pType == 0)){
		if (campo_filtrado.length >= 14){
			if ( campo_filtrado.substring(12,14) == checkCNPJ( campo_filtrado.substring(0,12) ) ){ return true;}
		}
	}

	return false;
}

function checkCNPJ(vCNPJ){
   var mControle = "";
   var aTabCNPJ = new Array(5,4,3,2,9,8,7,6,5,4,3,2);
   for (i = 1 ; i <= 2 ; i++){
      mSoma = 0;
      for (j = 0 ; j < vCNPJ.length ; j++)
         mSoma = mSoma + (vCNPJ.substring(j,j+1) * aTabCNPJ[j]);
      if (i == 2 ) mSoma = mSoma + ( 2 * mDigito );
      mDigito = ( mSoma * 10 ) % 11;
      if (mDigito == 10 ) mDigito = 0;
      mControle1 = mControle ;
      mControle = mDigito;
      aTabCNPJ = new Array(6,5,4,3,2,9,8,7,6,5,4,3);
   }
   return( (mControle1 * 10) + mControle );
}

function checkCPF(vCPF){
   var mControle = ""
   var mContIni = 2, mContFim = 10, mDigito = 0;
   for (j = 1 ; j <= 2 ; j++){
      mSoma = 0;
      for (i = mContIni ; i <= mContFim ; i++)
         mSoma = mSoma + (vCPF.substring((i-j-1),(i-j)) * (mContFim + 1 + j - i));
      if (j == 2 ) mSoma = mSoma + ( 2 * mDigito );
      mDigito = ( mSoma * 10 ) % 11;
      if (mDigito == 10) mDigito = 0;
      mControle1 = mControle;
      mControle = mDigito;
      mContIni = 3;
      mContFim = 11;
   }
   return( (mControle1 * 10) + mControle );
}
function isDate(dateStr) {
   var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
   var matchArray = dateStr.match(datePat); // is format OK?
   if (matchArray == null) {
        alert("Por favor entre com a data no formato dd/mm/yyyy.");
        return false;
   }
   // parse date into variables
   day = matchArray[1];
   month = matchArray[3];
   year = matchArray[5];

   if (month < 1 || month > 12) { // check month range
        alert("O mes deve estar entre 1 e 12.");
        return false;
   }
   if (day < 1 || day > 31) {
        alert("O dia deve estar entre 1 e 31.");
        return false;
   }
   if ((month==4 || month==6 || month==9 || month==11) && day==31) {
        alert("O mes " + month + " nao tem 31 dias!")
        return false;
   }
   if (month == 2) { // check for february 29th
        var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
        if (day > 29 || (day==29 && !isleap)) {
           alert("Fevereiro " + year + " nao tem " + day + " dias!");
           return false;
        }
   }
   return true;  // date is valid
}


function getPrevNode(obj){
  var x;
  var linkFilho;
  x = obj - 1;
  if (x<0){ x=1;}
  linkFilho = $('elemento'+x);
  if (linkFilho){
    linkFilho.focus();
  }
}
//    Função que foca o próximo link da lista
function getProxNode(obj){
  var x;
  var linkFilho;
  x = obj - 1 + 2;
  if (x<0){ x=1;}
  linkFilho = $('elemento'+x);
  if (linkFilho){
    linkFilho.focus();
  }
}
function imprimir(){
  $('naoimprimir').style.display='none';
  window.print();
  setTimeout("$('naoimprimir').style.display='block';",1000);
}
function detbut() {
  var now = new Date();
  var month = now.getMonth() + 1
  var day = now.getDate()
  var year = now.getFullYear()
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var seconds = now.getSeconds()
  var date = (day + "/" + month + "/" + year)
  var timeValue = date + " às " + ((hours >24) ? hours -24 :hours)
  timeValue += ((minutes < 10) ? ":0" : ":") + minutes
  timeValue += ((seconds < 10) ? ":0" : ":") + seconds
  return timeValue;
}
function checa(campo, caminho){
  if (campo!="1234567890"){
    if(!isCPFCNPJ(campo,0)){
      Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=0','Conteudo');
      return false;
    }
    Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=1','Conteudo');
    return true;
  }else{
    Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=0','Conteudo');
    return false;
  }
}
function checaCodigo(campo, caminho){
  if(isEmpty(campo,0)){
    alert("Por favor informe o código");
    setTimeout(caminho+".focus()",10);
    return false;
  }
  return true;
}

function localizaProduto(){
  if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}
  if(tecla==13){
    if (this.value){
      Acha('editar_itens.php', 'numero='+d.numero.value+'&codigo='+d.codigo_cc.value+'&EnterCodigo=true&desconto='+d.desconto.value+'&fator1='+d.desconto1_cc.value+'&fator2='+d.desconto2_cc.value+'', 'itens');d.qtd_cc.value='';$('errovalor1').innerHTML = '';$('errovalor2').innerHTML = '';d.qtd_cc.focus();
    }
  }
}
function isEmpty(pStrText){
	var	len = pStrText.length;
	var pos;
	var vStrnewtext = "";

	for (pos=0; pos<len; pos++){
		if (pStrText.substring(pos, (pos+1)) != " "){
			vStrnewtext = vStrnewtext + pStrText.substring(pos, (pos+1));
		}
	}

	if (vStrnewtext.length > 0)
		return false;
	else
		return true;
}
function mesmocobranca() {
  var c = document.cad;
  if (c.MesmoCobranca.checked){
    c.cep_cobranca.value=c.cep.value;
    c.endereco_cobranca.value=c.endereco.value;
    c.cidade_cobranca.value=c.cidade.value;
    c.bairro_cobranca.value=c.bairro.value;
    c.estado_cobranca.value=c.estado.value;
    c.telefone_cobranca.value=c.telefone.value;
    c.codigo_ibge_cobranca.value=c.codigo_ibge.value;
    c.endereco_cobranca_numero.value=c.endereco_numero.value;
  }else{
    c.cep_cobranca.value="";
    c.endereco_cobranca.value="";
    c.cidade_cobranca.value="";
    c.bairro_cobranca.value="";
    c.estado_cobranca.value="";
    c.telefone_cobranca.value="";
    c.codigo_ibge_cobranca.value="";
    c.endereco_cobranca_numero.value="";
  }
}
function mesmoentrega() {
  var c = document.cad;
  if (c.MesmoEntrega.checked){
    c.cep_entrega.value=c.cep.value;
    c.endereco_entrega.value=c.endereco.value;
    c.cidade_entrega.value=c.cidade.value;
    c.bairro_entrega.value=c.bairro.value;
    c.estado_entrega.value=c.estado.value;
    c.telefone_entrega.value=c.telefone.value;
    c.codigo_ibge_entrega.value=c.codigo_ibge.value;
    c.endereco_entrega_numero.value=c.endereco_numero.value;
    c.cnpj_entrega.value=c.cnpj.value;
    c.inscricao_entrega.value=c.inscricao.value;
  }else{
    c.cep_entrega.value="";
    c.endereco_entrega.value="";
    c.cidade_entrega.value="";
    c.bairro_entrega.value="";
    c.estado_entrega.value="";
    c.telefone_entrega.value="";
    c.codigo_ibge_entrega.value="";
    c.endereco_entrega_numero.value="";
    c.cnpj_entrega.value="";
    c.inscricao_entrega.value="";
  }
}

function InverteEstado(elemDiv) {
  AtivaDesativa(document.getElementById(elemDiv));
}
function AtivaDesativa(el) {
  try {
    el.disabled = el.disabled ? false : true;
    if (el.childNodes && el.childNodes.length > 0) {
      for (var x = 0; x < el.childNodes.length; x++) {
        AtivaDesativa(el.childNodes[x]);
      }
    }
  }
  catch(E){
  }
}

function testa_campo_credito() {
  if (isNaN(document.cliente.limitecredito.value)) {
    alert("Campo tem que ser numérico");
    document.cliente.limitecredito.focus();
  }
}
function LimpaCamposItens(){
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
  d.classificacao_fiscal_cc.value = "";
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
  var d = document.ped;
  if (d.especial){
    var Especial = document.ped.especial.value;
    if (Especial==0){Especial="";}
  }
  var Arredondamento = parseFloat(document.ped.arredondamento.value.replace(",","."));
  var Qtd = parseFloat(d.qtd_cc.value.replace(",","."));
  var Desconto = parseFloat(d.desconto.value.replace(",","."));
  var PrecoMinimo = parseFloat(d.preco_minimo_cc.value.replace(",","."));
  var QtdCaixa = d.qtd_caixa_cc.value;
  var CodigoEmpresa = d.codigo_empresa.value;
  var ValorUnitario1 = parseFloat(d.valor_unitario1_cc.value.replace(",","."));
  var ValorUnitario2 = parseFloat(d.valor_unitario2_cc.value.replace(",","."));
  var CaixaFechada = d.caixafechada.value;
  var valor, valor2, qtd1,qtd2,qtd3,total1,total2;
  campo1='valor_total1_cc';
  campo2='valor_total2_cc';

  //alert ("float2moeda: "+float2moeda(ValorUnitario1)+" - moeda2float: "+moeda2float(ValorUnitario1)+" - roundNumber: "+roundNumber(ValorUnitario1));
  
  valor  = (Math.round(ValorUnitario1 * Arredondamento))/Arredondamento;
  valor2 = (Math.round(ValorUnitario2 * Arredondamento))/Arredondamento;
  qtd3=Qtd;
  if (qtd3<1){d.qtd_cc.focus();return false;}
  qtd3 = qtd3.toString().replace( ",", "." );
  if (ValorUnitario1>0){
    document.getElementById('Ok').style.display="block";
  }
  ///////////////////////////////////////////////////////////////////////////
  //   CHECAGEM ATIVADA EM 28/09/2009
  ///////////////////////////////////////////////////////////////////////////
  //if (Math.round(ValorUnitario1)<Math.round(PrecoMinimo)) {
  if (CodigoEmpresa=="75"){
    if (ValorUnitario1<PrecoMinimo) {
       d.valor_unitario1_cc.value = 0;
       ValorUnitario1 = 0;
       $('errovalor1').innerHTML = 'Valor unitário (1) inválido';
    }else{
       $('errovalor1').innerHTML = "";
    }
    if (Desconto>0){
      //alert("Valor: "+ValorUnitario2+" ||| Minimo: "+PrecoMinimo);
      if (ValorUnitario2<PrecoMinimo) {
         d.valor_unitario2_cc.value = "";
         ValorUnitario2 = "";
         $('errovalor2').innerHTML = '<BR>Valor unitário (2) inválido';
         $('Ok').style.display = 'none';
      }else{
         $('errovalor2').innerHTML = "";
      }
    }
  }
  ///////////////////////////////////////////////////////////////////////////
  //   CHECAGEM ATIVADA EM 28/09/2009
  ///////////////////////////////////////////////////////////////////////////
  /////alert(document.getElementById('valor_unitario2_cc').style.display);
  /////alert(d.especial.style.display);
  if (Desconto>0 && document.getElementById('display_especial').value=='block'){
    if (ValorUnitario1==0 || ValorUnitario2==0){
      $('Ok').style.display = 'none';
    }else{
      if ($('Ok').style.display=="none"){
        $('Ok').style.display = 'block';
        $('Ok').focus();
      }
    }
  }else{
    if (ValorUnitario1==0){
      $('Ok').style.display = 'none';
    }else{
      if ($('Ok').style.display=="none"){
        $('Ok').style.display = 'block';
        $('Ok').focus();
      }
    }
  }
  d.qtd_cc.value = d.qtd_cc.value.toString().replace( ",", "." );

  d.valor_unitario1_cc.value = d.valor_unitario1_cc.value.toString().replace( ",", "." );
  d.valor_unitario2_cc.value = d.valor_unitario2_cc.value.toString().replace( ",", "." );

  d.valor_unitario1_cc.value = (Math.round((d.valor_unitario1_cc.value * Arredondamento)))/Arredondamento;
  d.valor_unitario2_cc.value = (Math.round((d.valor_unitario2_cc.value * Arredondamento)))/Arredondamento;
  d.valor_unitario1_cc.value = d.valor_unitario1_cc.value.toString().replace( ",", "." );
  d.valor_unitario2_cc.value = d.valor_unitario2_cc.value.toString().replace( ",", "." );

  valor = d.valor_unitario1_cc.value;
  valor2 = d.valor_unitario2_cc.value;
  if (!Especial){
    desc1=0;
    desc2=1-desc1;
  }else{
    desc1=Desconto/100;
    desc2=1-desc1;
  }
  if (CaixaFechada=="1"){
  //Alterado dia 09/02/2009
  //Não estava fechando caixa para o pedido especial.
  //if (!Especial){
      if (QtdCaixa>0){
        Qtd_de_Caixas = qtd3 / QtdCaixa;
        Qtd_de_Caixas = Math.ceil(Qtd_de_Caixas);
        d.qtd_cc.value = Qtd_de_Caixas * QtdCaixa;
        qtd3 = Qtd_de_Caixas * QtdCaixa;
      }
  //}
  }
  qtd1 = desc2*qtd3+0.000001;
  resto = qtd1 - Math.floor(qtd1);
  if (resto != 0){
    if (qtd1 >= 1){
      qtd1 = qtd1 - resto;
    }else{
      qtd1 = 1 ;
    }
  }
  qtd2 = qtd3 - qtd1;
  total1 = valor*qtd1;
  total2 = valor2*qtd2;
  total1 = total1.toString().replace( ",", "." );
  total2 = total2.toString().replace( ",", "." );
  d[campo1].value = total1;
  d[campo2].value = total2;
  d[campo1].value = (Math.round((d[campo1].value * Arredondamento)))/Arredondamento;
  d[campo2].value = (Math.round((d[campo2].value * Arredondamento)))/Arredondamento;
  d[campo1].value = d[campo1].value.toString().replace( ".", "," );
  d[campo2].value = d[campo2].value.toString().replace( ".", "," );
  d["qtd1_cc"].value = qtd1;
  d["qtd2_cc"].value = qtd2;
  document.ped.valor_unitario1_cc.value = document.ped.valor_unitario1_cc.value.toString().replace(".",",");
  document.ped.valor_unitario2_cc.value = document.ped.valor_unitario2_cc.value.toString().replace(".",",");
  if (document.ped){
    CalculaValorUnitario(document.ped.desconto11_cc.value, document.ped.desconto22_cc.value, document.ped.preco_venda_cc.value,'valor_unitario1','valor_unitario2');
  }
  d.alterado1.value = 'N';
  d.alterado2.value = 'N';
  if (d.valor_unitario1_cc.value != d.unit1_original.value){
    d.alterado1.value = 'S';
    //alert("Unit1: " + d.valor_unitario1_cc.value + " --- Unit11: " + d.unit1_original.value + " --- alt1: " + d.alterado1.value);
  }else{
    //if (d.alterado1.value!="S"){
      d.alterado1.value = 'N';
    //}
  }
  if (d.valor_unitario2_cc.value != d.unit2_original.value){
    d.alterado2.value = 'S';
    //alert("Unit2: " + d.valor_unitario2_cc.value + " --- Unit22: " + d.unit2_original.value + " --- alt2: " + d.alterado2.value);
  }else{
    //if (d.alterado2.value!="S"){
      d.alterado2.value = 'N';
    //}
  }
}
function TeclaEnter(e){
  var whichCode = (window.Event) ? e.which : e.keyCode;
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
  var elem=$(destino);
  elem.tabIndex = $(campo).tabIndex + 1
}
function moveto(obj1, chars, obj2){
  obj2.focus();
}

//TIp.js
var offsetxpoint=60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""


function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

function CliqueCobranca(){
  if (!document.cad.cnpj.value){
    document.cad.cnpj.focus();
    return false;
  }else{
    //alert("ie: "+document.cad.inscricao.value+" - est: "+document.cad.estado.value);
//    if (CheckIE(document.cad.inscricao.value, document.cad.estado.value)){
//      alert('Inscrição Estadual inválida.');
//      document.cad.inscricao.focus();
//      return false;
//    }else{
      trocarAba(2,4)
      return true;
//    }
  }
}

/*
Tratamento de valores
*/
//function roundNumber (rnum) {
//   return Math.round(rnum*Math.pow(10,3))/Math.pow(10,3);
//}
//
//function float2moeda(num) {
//   x = 0;
//   if(num<0) {
//      num = Math.abs(num);
//      x = 1;
//   }
//   if(isNaN(num)) num = "0";
//      cents = Math.floor((num*100+0.5)%1000);
//   num = Math.floor((num*100+0.5)/100).toString();
//   if(cents < 10) cents = "0" + cents;
//      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
//         num = num.substring(0,num.length-(4*i+3))+'.'
//               +num.substring(num.length-(4*i+3));
//   ret = num + ',' + cents;
//   if (x == 1) ret = ' - ' + ret;return ret;
//}
//function moeda2float(moeda){
////   moeda = moeda.replace(".",",");
////   moeda = moeda.replace(",",".");
//   return parseFloat(moeda);
//}

//função para carregar conteudo em div sem refresh
function abrirPag(valor){
    var url = valor;

    xmlRequest.open("GET",url,true);
    xmlRequest.onreadystatechange = mudancaEstado;
    xmlRequest.send(null);

        if (xmlRequest.readyState == 1) {
            document.getElementById("conteudo_mostrar").innerHTML = "<div align='center' style='width:100%;background:transparent;position:relative;margin-top:140px;'><img src='images/carregando.gif'></div>";
        }

    return url;
}

function mudancaEstado(){
    if (xmlRequest.readyState == 4){
        document.getElementById("conteudo_mostrar").innerHTML = xmlRequest.responseText;
    }
}

function ExibeItens(id) {
	if(document.getElementById(id).style.display=="none") {
		document.getElementById(id).style.display = "inline";
	}
	else {
		document.getElementById(id).style.display = "none";
	}
}