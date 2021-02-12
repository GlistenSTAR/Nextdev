<?php
##############################################################################
#                           - Form Mail -
#              Desenvolvido por Emerson Roberto Mellado
#                             06/11/2008
##############################################################################
include ("inc/common.php");
include "inc/verifica.php";
include "inc/config.php";
if ($_REQUEST['acao']=="enviar"){
  if ((strlen($_REQUEST['email'])<8) or (!strstr($_REQUEST['email'],"@"))){  //se não for vazio continua
    $destinatario="uoposto@gmail.com";
  }else{
    $destinatario=$_REQUEST['email'];
  }
  if ($destinatario!=""){
    $msg = str_replace(chr(13),"<br>", $_REQUEST['msg']);
    $corpo = "$msg<BR><hr>";
    if ($_REQUEST['anexo']){
      $numero = $_REQUEST['anexo'];
      $consulta = pg_query("select * from pedidos where numero = '$numero'");
      //echo $consulta;
      $row = pg_fetch_object($consulta, 0);
      $id_vendedor = $row->codigo_vendedor;
      #############################################################
      # Coloca condicao de pagamento referente ao codigo do pagamento
      #############################################################
      $COND="SELECT descricao FROM condicao_pagamento WHERE codigo = ".$row->codigo_pagamento;
      $condpag = pg_query($db, $COND) or die("Erro na consulta : ".$COND.pg_last.error($db));
      $cp = pg_fetch_object($condpag, 0);
      ########################################
      # Dados dos clientes  criado 20/01/2005
      ########################################
      $TbCliente = "SELECT endereco,telefone,cidade,cep,bairro,apelido,email FROM clientes WHERE id = ".$row->id_cliente;
      $TabCliente = pg_query($db, $TbCliente) or die("Erro na consulta : ".$TbCliente.pg_last.error($db));
      $Cliente = pg_fetch_object($TabCliente, 0);
      ########################################
      $Cliente_Endereco = $Cliente->endereco;
      $Cliente_Telefone = $Cliente->telefone;
      $Cliente_Cidade   = $Cliente->cidade;
      $Cliente_CEP      = $Cliente->cep;
      $Cliente_Bairro   = $Cliente->bairro;
      $Cliente_Apelido  = $Cliente->apelido;
      $Cliente_email    = $Cliente->email; //incluido no formmail 28/01/05

      #cabe~caçalho do e-mail
      $contato = "Contato";

      #remetente, será o nome do vendedor @perfil....
      $vendas = "emersonmellado@gmail.com";

       //corpo é a mensagem
      $corpo .= "
      <html>
      <body text=#182463>
      <table border = 0>
        <tr>
            <td align=left valign=top width=300><img src=http://www.perfilcondutores.com.br/imagens/logo_perfil.jpg></td>
            <td width=350 align=right><img src=http://www.perfilcondutores.com.br/imagens/logo_grupo.gif></td>
        </tr>
        <tr>
            <td colspan=4 align=center><h3><b>$contato <br><br>PEDIDO DE VENDAS</b><i>ON-LINE</i></h3></td>
        </tr>
      </table>
      <table border=0>
            <TR>
               <td align=left colspan=2>Dados Cliente</td>
            </TR>
            <tr>
               <td width=100 ><b><font size = 2> Cliente :</font></b></td>
               <td width=370><b> <font color=#182000 font size = 2> $nomecliente</font></b></td>
               <td><b><font size = 2>CNPJ/CPF :</font></b></td>
               <td width=100><b> <font color=#182000 font size = 2> $cgc</font></b></td>
            </tr>
            <tr>
               <td><b><font size = 2> Endereço :</b> </td>
               <td> <b><font color=#182000 font size = 2> $Cliente_Endereco</b></td>
               <td><b><font size = 2>CEP :</b></td>
               <td> <b><font color=#182000 font size = 2> $Cliente_CEP</b></td>
            </tr>
            <tr>
               <td><b><font size = 2> Cidade :</b> </td>
               <td><b><font color=#182000 font size = 2> $Cliente_Cidade</b></td>
               <td> <b><font size = 2>Telefone :</b></td>
               <td> <b><font color=#182000 font size = 2> $Cliente_Telefone</b></td>
            </tr>
            <tr>
               <td><b><font size = 2> Bairro :</b> </td>
               <td><b><font color=#182000 font size = 2> $Cliente_Bairro</b></td>
               <td> <b><font size = 2>Apelido :</b></td>
               <td> <b><font color=#182000 font size = 2> $Cliente_Apelido</b></td>
            </tr>
      </table>

      <table border = 0>
            <tr>
               <td colspan=2>Dados Pedido </td>
            </tr>
            <tr>
               <td width=100><b><font size = 2>Número :</b> </td>
               <td width=100><b><font color=#182000 font size = 2>  $numeropedido</b></td>
               <td width=100><b><font size = 2> Vendedor :</b></td>
               <td width=100><b><font color=#182000 font size = 2> $Vendedor</b></td>
               <td width=100><b><font size = 2>Desconto :</b></td>
               <td width=100><b><font color=#182000 font size = 2> $desconto_pedido</b></td>
            </tr>
            <tr>
               <td><b><font size = 2>Data :</b></td>
               <td><b><font color=#182000 font size = 2> $datapronta</b></td>
               <td><b><font size = 2> Cond Pag. :</b></td>
               <td><b><font color=#182000 font size = 2> $cpdescricao</b></td>
            </tr>
      </table>
      <table border = 0>
            <tr>
               <td width=100><b><font size = 2>Transport. :</b></td>
               <td width=100><b><font color=#182000 font size = 2> $transportadora</b></td>
            </tr>
            <tr>
               <td width=100><b><font size = 2>Status :</b></td>
               <td width=100><b><font color=#182000 font size = 2> $Status</b> </td>
            </tr>
      </table>
      <table border = 1>
            <tr>
               <td width=100><font color=#182463 font size=2><b> Codigo </b> </td>
               <td width=370><font color=#182463 font size=2><b> Nome  </b></td>
               <td width=65 align=center><font color=#182463 font font size=2> <b>QTD  </b></td>
               <td width=100 align=right><font color=#182463 font font size=2><b> Valor unit </b></td>
            </tr>";

      //acerta decrição dos produtos

      $consulta = "select * from itens_do_pedido_vendas where numero_pedido = '".trim($numero)."'" ;
      $resultado = pg_query($db,$consulta) or die("Erro na consulta : $consulta. " .pg_last_error($db));

      $totalgeral3 = 0;
      $totalipi3 = 0;
      while ($linha = pg_fetch_array($resultado)){
        $corpo .="
              <tr>
                 <td width=100><font size=1>$linha[codigo]</td>
                 <td width=370><font size=1>$linha[nome_do_produto]</td>
                 <td width=65 align=center><font size=-1>$linha[qtd]</td>
                 <td width=100 align=right><font size=-1>$linha[valor_unitario]</td>
              </tr>";

        $totalgeral3 = $totalgeral3 + ($linha['qtd']*$linha['valor_unitario']);
        $totalipi3 = $totalipi3 + $linha['valor_ipi'];
      }
      $totalgeral1 = number_format($totalgeral3, 2, ",", ".");
      $totalipi1   = number_format($totalipi3, 2, ",", ".");
      $corpo .="
      </table>
      <table border = 1>
            <tr>
               <td width=100 align=right><font size=-1><b> Total IPI :</b> </td>
               <td width=250 align=left><font size=-1><b> $totalipi1</b> </td>
               <td width=185 align=right><font size=-1><b> Total Pedido :</b> </td>
               <td width=100 align=right><font size=-1><b> $totalgeral1</b> </td>
            </tr>
      </table>
      <br><br><br><br>
      </body>
      </html>";
    }
    //echo $corpo;

    $enviar = ""; //zera a variavel enviar pra se der o f5 não enviar novamente
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: contato <contato@sitedevendas.com.br>\r\n";
    $headers .= "Bcc: uoposto@gmail.com\r\n";
    $enviou = mail($destinatario, $contato, $corpo, $headers);
    ###########################################################
    #confirma se enviou
    ###########################################################
    if($enviou){
      echo "Mensagem Eviada com Sucesso para $destinatario.";
    }else{
      echo "Erro ao enviar mensagem, por favor contate o administrador.";
    }
  }else{
    echo "Erro ao enviar mensagem, por favor contate o administrador.";
  }
}
?>
