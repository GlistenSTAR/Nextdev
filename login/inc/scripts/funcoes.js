function editaritens(){
  calculavalor();
  acerta_campos('pedido','GrdProdutos','incluir_itens.php',true);
  setTimeout('document.ped.codigo_cc.focus()',50);
  LimpaCamposItens();
  document.getElementById('boxdesconto').innerHTML=document.ped.desconto.value;
  document.ped.desconto.style.display='none';
  if (document.getElementById('produtoinexistente')){
    document.getElementById('produtoinexistente').innerHTML = '';
  }
}

function listarpedidos () {
  if (document.listar.data_inicial.value){
    if (document.listar.numero_pedido.value){
      window.open('impressao.php?&numero='+document.listar.numero_pedido.value+'&t=1','_blank');
    }else{
      Acha('listar_pedidos.php','data_inicial='+document.listar.data_inicial.value+'&data_final='+document.listar.data_final.value+'&numero_pedido='+document.listar.numero_pedido.value+'&enviados='+document.listar.enviados.value+'','Conteudo');
    }
  }
}
