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
  var TotalPedido = parseFloat(d.botao_total.value.toString().replace(".", "" ));
  var QtdParcelas = (d.vezes)?parseInt(d.vezes.value):"1";
  var ValorDaParcela = TotalPedido / QtdParcelas;
  QtdParcelas2 = (d.vezes2) ? parseInt(d.vezes2.value) : null;
  var ValorDaParcela2 = TotalPedido / QtdParcelas2;
  var ret=true, msg='';
  if (ValorDaParcela<10){
    msg = "Condição de pagamento 1 inválida para esse pedido.\n";
    trocarAba(1,3);
    setTimeout('d.condpag1_id.focus()',250);
    ret=false;
  }
  if (ValorDaParcela2<10){
    msg +="Condição de pagamento 2 inválida para esse pedido.\n";
    trocarAba(1,3);
    setTimeout('d.condpag2_id.focus()',250);
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
function ChecaPedido1(){
  var d = document.ped;
  var msg='';
  /* Acrescentado por Emerson a pedido do Roberto 06/01/2009
  * Checagem de data de entrega, deve permitir datas > que 15 dias da data de emissão
  ************************************************************************************/
  var now = new Date();
  var dia15 = now.getDate() + 15;
  var mes = now.getMonth() + 1;
  mes = (mes<10) ? "0" + mes : mes;
  var DataMaxima = parseInt(now.getFullYear() + "" + mes + "" + dia15);
  var Data = d.data_entrega.value;
  Data = parseInt( Data.split( "/" )[2].toString() + Data.split( "/" )[1].toString() + Data.split( "/" )[0].toString() )
  if (Data<DataMaxima){
    msg = "A data de entrega deve ser no mínimo 15 dias corridos a partir da data de emissão do pedido\n";
  }
  /** 06/01/2009 */
  if (!$('trans_cc').value){
    msg += "Confira a transportadora\n";
  }
  if (!$('condpag1_id').value){
    msg += "Confira a condição de pagamento 1\n";
  }
  if ($('desconto').value>0){
    if (!$('condpag2_id').value){
      msg += "Confira a condição de pagamento 2\n";
    }
  }
  if (!$('frete').value){
    if(!$('frete1').value){
      msg += "Selecione a opção de frete\n";
    }
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
  }else{
    if (document.listar.data_inicial.value){
      if (document.listar.numero_pedido.value){
        window.open('impressao.php?&numero='+document.listar.numero_pedido.value+'&t=1','_blank');
      }else{
        Acha('listar_pedidos.php','pagina=$pagina&data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&numero_pedido='+document.listar.numero_pedido.value+'&tipo='+tipo+'&vendedor2_id='+document.listar.vendedor2_id.value+'','Conteudo');
      }
    }
  }
}

function habilitapagto2(){
  var opcao;
  opcao= (document.ped.desconto.value>0) ? 'block' : 'none';
  $('box-labelpagto2').style.display=opcao;
  $('box-dadospagto2').style.display=opcao;
  ($('box-labeldesc2')) ? $('box-labeldesc2').style.display=opcao : null;
  ($('box-dadosdesc2')) ? $('box-dadosdesc2').style.display=opcao : null;
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
  }else{
    c.cep_cobranca.value="";
    c.endereco_cobranca.value="";
    c.cidade_cobranca.value="";
    c.bairro_cobranca.value="";
    c.estado_cobranca.value="";
    c.telefone_cobranca.value="";
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
  }else{
    c.cep_entrega.value="";
    c.endereco_entrega.value="";
    c.cidade_entrega.value="";
    c.bairro_entrega.value="";
    c.estado_entrega.value="";
    c.telefone_entrega.value="";
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
  var Qtd = parseFloat(d.qtd_cc.value.replace(",","."));
  var Desconto = parseFloat(d.desconto.value.replace(",","."));
  var PrecoMinimo = parseFloat(d.preco_minimo_cc.value.replace(",","."));
  var QtdCaixa = d.qtd_caixa_cc.value;
  var ValorUnitario1 = parseFloat(d.valor_unitario1_cc.value.replace(",","."));
  var ValorUnitario2 = parseFloat(d.valor_unitario2_cc.value.replace(",","."));
  var CaixaFechada = d.caixafechada.value;
  var valor, valor2, qtd1,qtd2,qtd3,total1,total2;
  campo1='valor_total1_cc';
  campo2='valor_total2_cc';
  valor  = (Math.round(ValorUnitario1 * 100))/100;
  valor2 = (Math.round(ValorUnitario2 * 100))/100;
  qtd3=Qtd;
  if (qtd3<1){d.qtd_cc.focus();return false;}
  qtd3 = qtd3.toString().replace( ",", "." );

  if (Math.floor(ValorUnitario1)<Math.floor(PrecoMinimo)) {
     d.valor_unitario1_cc.value = 0;
     ValorUnitario1 = 0;
     $('errovalor1').innerHTML = 'Valor unitário (1) inválido';
  }else{
     $('errovalor1').innerHTML = "";
  }
  if (Desconto>0){
    if (Math.floor(ValorUnitario2)<Math.floor(PrecoMinimo)) {
       d.valor_unitario2_cc.value = "";
       ValorUnitario2 = "";
       $('errovalor2').innerHTML = '<BR>Valor unitário (2) inválido';
       $('Ok').style.display = 'none';
    }else{
       $('errovalor2').innerHTML = "";
    }
  }
  if (Desconto>0){
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

  d.valor_unitario1_cc.value = (Math.round((d.valor_unitario1_cc.value * 100)))/100;
  d.valor_unitario2_cc.value = (Math.round((d.valor_unitario2_cc.value * 100)))/100;
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
  d[campo1].value = (Math.round((d[campo1].value * 100)))/100;
  d[campo2].value = (Math.round((d[campo2].value * 100)))/100;
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
