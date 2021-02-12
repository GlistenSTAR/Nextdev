<?php
/*
Classe MovEst - Movimentação de estoque automática

Essa classe faz a ligação com o banco de dados recebendo alguns valores que devem ser setados onde é necessário mover o estoque,
tanto para sair quanto para entrar

03/10/2007 - Emerson - Tninfo
*/

class DivPed {
  //Atributos
  private $numero;
  private $especial;
  private $;

  //Construtor
  public function __construct(){

  }

  //Setando acesso e pegando atributos
  public function set_numero($numero){ $this->numero = $numero; }
    public function get_numero(){ return $this->numero;  }
  public function set_especial($especial){ $this->especial = $especial; }
    public function get_especial(){ return $this->especial;  }
  

  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){
    include "abre_banco.inc.php";

    if ($this->especial){
      #Especial
      $TemDesconto = true
      $DadosTipoPedido = "'$Item[qtd2]','$Item[valor_total2]',";
    }else{
      #Normal
      $TemDesconto = false;
      $DadosTipoPedido = "'$Item[qtd1]','$Item[valor_total1]',";
    }
    //Carrega numero máximo de itens
    $SqlReferencias = pg_query("Select numero_maximo_itens, fat_min from referencias") or die ("Erro 1");
    $ArrayReferencias = pg_fetch_array($SqlReferencias);
    $Maximo = $ArrayReferencias[numero_maximo_itens];
    $FatMin = $ArrayReferencias[fat_min];
    //Arredonda ítens
    $SqlItens = pg_query("Select * from itens_pedidos_internet where numero_pedido = '$this->numero' order by id ") or die ("Erro 2");
    $NumeroItens = pg_num_rows($SqlItens);
    
    if ($NumeroItens % $Maximo <> 0){
      $Arredondar = round($NumeroItens / $Maximo);
      if ($Arredondar>="5"){
        $QtdPedidos = settype($NumeroItens / $Maximo, int);
      }else{
        $QtdPedidos = settype(($NumeroItens / $Maximo) + 1, int);
      }
    }else{
      $QtdPedidos = settype($NumeroItens / $Maximo, int);
    }
    $ItensPorPedido = settype($NumeroItens / $Maximo, int);
    
    while($Item = pg_fetch_array($SqlItens)){
      $SqlGravaTemp = "Insert into divisao_pedidos (
                         id,
                         pedido,
                         codigo,
                         qtd,
                         valor_total,
                         pedido_novo
                       )values(
                         '$Item[id]',
                         '$Item[numero_pedido]',
                         '$Item[codigo]',
                         $DadosTipoPedido
                         '',
                       )
                      ";
      pg_query($SqlGravaTemp) or die ("Erro 3");
    }
    // Analisando dados tempórários
    $SqlListaTemp = pg_query("Select * from divisao_pedidos order by valor_total desc")
    $Cont = $QtdPedidos;
    $PrimeiraVez = true;
    
    while($ItemTemp = pg_fetch_array($SqlListaTemp)){
      pg_query("Update divisao_pedidos set pedido_novo='$Cont' where pedido_novo='$ItemTemp[pedido_novo]'") or die ("Erro 4");
      if ($PrimeiraVez){
        $Cont = $Cont - 1
      }else{
        $Cont = $Cont + 1
      }
      if (($Cont==0) or ($Cont > $QtdPedidos)){
        $Cont = 1;
        $PrimeiraVez = false
      }
    }

    $SqlCalculaFatMin = pg_query("Select Sum(divisao_pedidos.valor_total) as SomaValorTotal, divisao_pedidos.pedido_novo from divisao_pedidos group by divisao_pedidos.pedido_novo") or die ("Erro 5");
    $ArrayCalculaFatMin = pg_fetch_array($SqlCalculaFatMin);
    if ($ArrayCalculaFatMin[SomaValorTotal] < $FatMin){
      echo "Não foi possível dividir o pedido: $this->numero Não bateu faturamento minímo. Por favor refaça o pedido manualmete com no máximo $Maximo itens e com valor mínimo de R$ $FatMin";
      exit;
    }

    $SqlPedidos = pg_query("Select * from pedidos where numero ='$this->numero'");
    $Pedido = $this->numero + 1;
    
    while (){
    
    }

    Dim NumeroPedidoNovo As Double, TotalComNota As Double, TotalSemNota As Double, TotalIPI As Double, IpiItem As Double
    Dim TbPedido As Recordset, TBPedidoNovo As Recordset
    Dim Pedido As Long
    Set TbPedido = db.OpenRecordset("select * from pedidos where numero= " + CStr(NumeroPedido) + " AND (codigo_empresa = ''" + CStr(CodigoEmpresa) + "'')")
    Pedido = (NumeroPedido + 1)
    For Cont = 2 To QtdPedidos ''laço para achar um numero de pedido que ainda nao exista
        Dim Achou As Boolean
        Achou = True
        Do While Achou
            Set TBPedidoNovo = db.OpenRecordset("select * from pedidos where numero = " + CStr(Pedido) + " AND (codigo_empresa = ''" + CStr(CodigoEmpresa) + "'')")
            If TBPedidoNovo.EOF = True Then
                Achou = False
            End If
            If TBPedidoNovo.EOF = False Then  ''Achou pedido
                Achou = True
                Pedido = Pedido + 1
                TBPedidoNovo.Close
            End If
        Loop
        NumeroPedidoNovo = CStr(Pedido)
        TotalComNota = 0
        TotalSemNota = 0
        TotalIPI = 0
        IpiItem = 0
        Set TbItensTemp = dbtemp.OpenRecordset("select * from divisao_pedidos where pedido_novo = " + CStr(Cont))
        ''começo a gravar
        Do Until TbItensTemp.EOF
            Set TBItens = db.OpenRecordset("select * from itens_do_pedido_vendas where id = " + CStr(TbItensTemp("id")) + " AND (codigo_empresa = ''" + CStr(CodigoEmpresa) + "'')")
            TBItens.Edit
            TBItens("numero_pedido") = NumeroPedidoNovo
            If TemDesconto Then ''mesmo esquema: se tiver desconto calcula senao pega o total
                TotalComNota = TotalComNota + CDbl(TbItensTemp("valor_total"))
                TotalSemNota = TotalSemNota + ((CDbl(TBItens("qtd1")) * CDbl(TBItens("unitario1"))) + (CDbl(TBItens("qtd2")) * CDbl(TBItens("unitario2"))))
            Else
                TotalComNota = TotalComNota + CDbl(TbItensTemp("valor_total"))
                TotalSemNota = TotalSemNota + CDbl(TbItensTemp("valor_total"))
            End If
            IpiItem = (CDbl(TBItens("total_item")) * (CDbl(TBItens("ipi")) / 100)) ''ipi unitario
            TotalIPI = TotalIPI + IpiItem ''ipi total
            TBItens.Update
            TBItens.Close
            Set TBItens = Nothing
            TbItensTemp.MoveNext
        Loop
        TBPedidoNovo.AddNew
        TBPedidoNovo("numero") = NumeroPedidoNovo
        ''vai para o relatorio final dos pedidos gerados(numero)
        RelatMSG = RelatMSG & Chr(13) & Chr(9) & "   " & CStr(NumeroPedidoNovo)

        TBPedidoNovo("codigo_empresa") = TbPedido("codigo_empresa")
        TBPedidoNovo("enviado") = TbPedido("enviado")
        TBPedidoNovo("cliente") = TbPedido("cliente")
        TBPedidoNovo("data") = TbPedido("data")
        TBPedidoNovo("data_envio") = TbPedido("data_envio")
        TBPedidoNovo("data_prevista_entrega") = TbPedido("data_prevista_entrega")
        TBPedidoNovo("numero_nota") = TbPedido("numero_nota")
        TBPedidoNovo("venda_efetivada") = TbPedido("venda_efetivada")
        TBPedidoNovo("contas_a_receber") = TbPedido("contas_a_receber")
        TBPedidoNovo("vendedor") = TbPedido("vendedor")
        TBPedidoNovo("nota") = TbPedido("nota")
        TBPedidoNovo("numero_cliente") = TbPedido("numero_cliente")
        TBPedidoNovo("desconto_cliente") = TbPedido("desconto_cliente")
        TBPedidoNovo("id_cliente") = TbPedido("id_cliente")
        TBPedidoNovo("codigo_pagamento") = TbPedido("codigo_pagamento")
        TBPedidoNovo("desconto_cliente2") = TbPedido("desconto_cliente2")
        TBPedidoNovo("desconto_cliente3") = TbPedido("desconto_cliente3")
        TBPedidoNovo("transportadora") = TbPedido("transportadora")
        TBPedidoNovo("contato") = TbPedido("contato")
        TBPedidoNovo("lista_preco") = TbPedido("lista_preco")
        TBPedidoNovo("comissao") = TbPedido("comissao")
        TBPedidoNovo("destacar_desconto") = TbPedido("destacar_desconto")
        TBPedidoNovo("desconto_pedido") = TbPedido("desconto_pedido")
        TBPedidoNovo("total_sem_desconto") = TotalSemNota
        ''vai para o relatorio final dos pedidos gerados(valor)
        RelatMSG = RelatMSG & Chr(9) & Chr(9) & CStr(Format$(TotalSemNota, "0.00"))

        TBPedidoNovo("total_com_desconto") = TotalComNota
        TBPedidoNovo("total_ipi") = TotalIPI
        TBPedidoNovo("cgc") = TbPedido("cgc")
        TBPedidoNovo("cancelado") = TbPedido("cancelado")
        TBPedidoNovo("valor_total_nota") = TbPedido("valor_total_nota")
        TBPedidoNovo("data_emissao_nota") = TbPedido("data_emissao_nota")
        TBPedidoNovo("reservado") = TbPedido("reservado")
        TBPedidoNovo("peso_bruto") = TbPedido("peso_bruto")
        TBPedidoNovo("peso_liquido") = TbPedido("peso_liquido")
        TBPedidoNovo("total_comissao") = TbPedido("total_comissao")
        TBPedidoNovo("codigo_vendedor") = TbPedido("codigo_vendedor")
        TBPedidoNovo("numero_pedido_vendedor") = TbPedido("numero_pedido_vendedor")
        TBPedidoNovo("sedex") = TbPedido("sedex")
        TBPedidoNovo("cod_area_entrega") = TbPedido("cod_area_entrega")
        TBPedidoNovo("cod_regiao_entrega") = TbPedido("cod_regiao_entrega")
        TBPedidoNovo("local_entrega") = TbPedido("local_entrega")
        TBPedidoNovo("parcial") = TbPedido("parcial")
        TBPedidoNovo("fator1") = TbPedido("fator1")
        TBPedidoNovo("fator2") = TbPedido("fator2")
        TBPedidoNovo("cod_status") = TbPedido("cod_status")
        TBPedidoNovo("data_cancelamento") = TbPedido("data_cancelamento")
        TBPedidoNovo("status") = TbPedido("status")
        Set TbObs = db.OpenRecordset("SELECT observacao FROM observacao_do_pedido WHERE numero_pedido = " & CStr(NumeroPedido) & " AND codigo_empresa = ''" & CStr(TbPedido("codigo_empresa")) & "''")
        TBPedidoNovo("obs") = TbObs("observacao")
        TbObs.Close

        TBPedidoNovo("frete") = TbPedido("frete")
        TBPedidoNovo("codigo_pagamento2") = TbPedido("codigo_pagamento2")
        TBPedidoNovo("cod_suframa") = TbPedido("cod_suframa")
        TBPedidoNovo.Update
        ''edita o pedido original e subtrai os valores do novo pedido gerado
        TbPedido.Edit
        TbPedido("total_ipi") = TbPedido("total_ipi") - TotalIPI
        TbPedido("total_sem_desconto") = TbPedido("total_sem_desconto") - TotalSemNota
        TbPedido("total_com_desconto") = TbPedido("total_com_desconto") - TotalComNota
        TbPedido.Update
        ''a cada novo pedido gerado chama as rotinas de exportaçao
        Call Registro_Tipo_002(CStr(Cgc), CStr(NumeroPedidoNovo))      ''cliente
        Call Registro_Tipo_003(CStr(NumeroPedidoNovo))                 ''pedido
        Call Registro_Tipo_004(CStr(NumeroPedidoNovo))                 ''itens
    Next Cont
    ''agora exporta o pedido original já com os valores "teoricamente" certos
    Call Registro_Tipo_002(CStr(Cgc), NumeroPedido)                    ''cliente
    Call Registro_Tipo_003(NumeroPedido)                               ''pedido
    Call Registro_Tipo_004(NumeroPedido)                               ''itens
    ''gera o relat
    msg = "O pedido " & CStr(NumeroPedido) & " foi dividido nos seguintes pedidos:" & Chr(13)
    msg = msg & Chr(9) & "-Número-" & Chr(9) & Chr(9) & "-Valor-" & Chr(13)
    msg = msg & RelatMSG
    MsgBox msg, vbOKOnly, "Relatótio de pedidos gerados"

  }
}
?>
