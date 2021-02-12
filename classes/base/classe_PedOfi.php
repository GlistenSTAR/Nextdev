<?php
/*
Classe PedOfi
Grava os pedidos da base temporária na base oficial, uma simples troca de tabelas de pedidos_internet para pedidos.
Essa classe é usada em:
cadastrar_pedidos.php
27/11/2007 - Emerson - Tninfo
*/
class PedidoOficial {
  //Atributos
  private $numero_internet;
  //Construtor
  public function __construct(){                                                                                                     }
  //Setando acesso e pegando atributos
  public function set_numero_internet($numero_internet){                $this->numero_internet = $numero_internet;                     }
  public function get_numero_internet(){                         return $this->numero_internet;                                        }
  //Setando acesso e pegando atributos
  public function set_obs($Obs){                                        $this->obs = $Obs;                                             }
  public function get_obs(){                                     return $this->obs;                                                    }
  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){
    include("inc/config.php");
    pg_query ($db, "begin");
    //Seta valores a variaveis estáticas
    $numero = $this->numero_internet;
    $Observacao = $this->obs;
    ######################################################
    # Armazena envio de pedido
    ######################################################
    $sql = "Update pedidos_internet_novo set enviado='1' where numero='".$this->numero_internet."'";
    pg_query($sql) or die ($MensagemDbError.$sql.pg_query ($db, "rollback"));
    ######################################################
    # Conferindo se o pedido ja foi gravado
    ######################################################
    $SqlPedidoGravado = pg_query("Select numero from pedidos where numero_internet='".$this->numero_internet."'") or die ($MensagemDbError.pg_query ($db, "rollback"));
    $ccc = pg_num_rows($SqlPedidoGravado);
    if ($ccc){
      $ped = pg_fetch_array($SqlPedidoGravado);
      $original = $ped[numero];
      $max = $original.date("His");
    }
      ######################################################
      # Gravando dados do pedido Envio Oficial!
      ######################################################
      #########################################################################
      # Carrega os dados do pedido da internet para gravar no pedidos oficial
      #########################################################################
      $SqlCarregaDados = pg_query("Select * from pedidos_internet_novo where numero='".$this->numero_internet."'");
      $p = pg_fetch_array($SqlCarregaDados);						

      
      ########################################################################################################################
      ##### CHECA LIMITE DE CRÉDITO                              #############################################################
      ##### POR: DÊNIS - EM:12/02/2014 - PAC: 20411              #############################################################
      ##### VARIAVEL GLOBAL $LimiteCredito GERADA EM config.php  #############################################################
      ########################################################################################################################      
      //Checo limite
      $SqlLimite = "SELECT limite_credito FROM clientes WHERE id = $p[id_cliente]";
      $SqlLimite = pg_query($db, $SqlLimite) or die ($MensagemDbError.$SqlLimite.pg_query ($db, "rollback"));
      $Limite = pg_fetch_array($SqlLimite);      

       
      if ($LimiteCredito == 1 AND $Limite[limite_credito] > 0){

        //Pega Valor das duplicatas em aberto (nao pagas)
        $SQlDuplicatas ="SELECT COALESCE(Sum(valor),0) as dup FROM duplicatas WHERE pagar <> 1 and pago = 0 and codigo_do_cliente = $p[id_cliente]";
        $SQlDuplicatas = pg_query($db, $SQlDuplicatas) or die ($MensagemDbError.$SQlDuplicatas.pg_query ($db, "rollback"));
        $Duplicatas = pg_fetch_array($SQlDuplicatas);

        //'Pega valor dor pedidos em aberto (nao efetivados)
        $SqlPedidos = "SELECT COALESCE(sum(total_com_desconto),0) as total_pedidos FROM pedidos WHERE numero IN (SELECT numero FROM pedidos WHERE venda_efetivada = 0 AND outros=0  AND id_cliente = $p[id_cliente] )";
        
        $SqlPedidos = pg_query($db, $SqlPedidos) or die ($MensagemDbError.$SqlPedidos.pg_query ($db, "rollback"));
        $Pedidos = pg_fetch_array($SqlPedidos);
        
        $VDupli = $Duplicatas[dup]; 
        $VPed = $Pedidos[total_pedidos];         
        $VAtual = $p[total_com_desconto]; 
                
        $Limite_Disponivel = ($Limite[limite_credito] - $VDupli - $VPed - $VAtual);         
        
        If($Limite_Disponivel < 0){
          echo "<span style='font-family:Arial, Verdana; font-size:12px;'>Limite de Crédito não é suficiente para continuar a operação</span>";             
          exit();
        }
        
      }
      ########################################################################################################################
      ########################################################################################################################
      
      if (!$max){
        ##########################################################################
        # Verifica se o ultimo numero é mesmo o ultimo pedido
        ##########################################################################
        if ($CodigoEmpresa=="75"){ // Perlex
          $ultimopedido = "SELECT numero_maximo_itens, ultimo_numero_pedido_internet + 1 as maximo FROM referencias";
        }else{
          $ultimopedido = "SELECT numero_maximo_itens, ultimo_numero_pedido + 1 as maximo FROM referencias";
        }
        $pedido = pg_query($db, $ultimopedido) or die ($MensagemDbError.$ultimopedido.pg_query ($db, "rollback"));
        $maximo = pg_fetch_array($pedido);
        $max = $maximo[maximo];
        $ACHEI = 0;
        while ($ACHEI == 0) {
          $SE_EXISTE = "select numero from pedidos where numero = ".$max;
          $PROCURA = pg_query($db, $SE_EXISTE) or die ($MensagemDbError.$SE_EXISTE.pg_query ($db, "rollback"));
          $ACHEI = pg_num_rows($PROCURA);
          if ($ACHEI > 0) {
            $max = $max + 1;
            $ACHEI = 0;
          }else {
            $ACHEI = 1;
          }
        }
        $_SESSION['NumeroPedidoGravado'] = $max;
      }else{
        $_SESSION['NumeroPedidoGravado'] = $original;
      }
      ######################################################
      # Fim Rotina de carregamento
      ######################################################
						
      $SqlCampo['cgc'] = $p[cgc];
      $SqlCampo['cliente'] = left($p[cliente], 50);
      $SqlCampo['codigo_vendedor'] = $id_vendedor;
      $SqlCampo['contato'] = left($p[contato],20);
      $SqlCampo['data'] = $data_hoje;
      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
        $SqlCampo[venda_casada] = ($p[venda_casada])?"1":"0";
        $SqlCampo[tipo_pedido] = $p[tipo_pedido];
        $SqlCampo[com_termo] = ($p[com_termo])?"1":"0";
        //$SqlCampo[tem_especial] = ($p[desconto_cliente]>0)?"1":"0";
        $SqlCampo[especificado] = $p[especificado];
      }
      if ($CodigoEmpresa=="75"){
        $SqlCampo['outros'] = (($p[codigo_pagamento]=="139") or ($p[codigo_pagamento1]=="139"))?"1":"0"; //Condição de pagamento = AMOSTRA
        if ($p[data_prevista_entrega]){
          $SqlCampo['data_prevista_entrega'] =date('Y-m-d', mktime(0,0,0,date('m',$p[data_prevista_entrega])+1,date('d',$p[data_prevista_entrega]),date('Y',$p[data_prevista_entrega])));   //$p[data_prevista_entrega];
        }else{
          //$SqlCampo['data_prevista_entrega'] = null;
        }
      }else{
        $SqlCampo['data_prevista_entrega'] = $p[data_prevista_entrega];
      }
      $SqlCampo['id_cliente'] = $p['id_cliente'];
      $SqlCampo['local_entrega'] = $p['local_entrega'];
      $SqlCampo['numero_pedido_vendedor'] = $p['numero_pedido_vendedor'];
      $SqlCampo['numero'] = $max;
      $SqlCampo['numero_cliente'] = $p['numero_cliente'];
      $SqlCampo['transportadora'] = $p['transportadora'];
      $SqlCampo['vendedor'] = $_SESSION['nome_vendedor'];
      $SqlCampo['comissao'] = $Comissao;
      $SqlCampo['transportadora'] = $p['transportadora'];
      $SqlCampo['codigo_pagamento'] = ($p['codigo_pagamento'])? "$p[codigo_pagamento]":"0";
      $SqlCampo['codigo_pagamento1'] = ($p['codigo_pagamento1'])? "$p[codigo_pagamento1]":"0";
      //$SqlCampo['desconto_cliente'] = ($p['desconto_cliente'])? "$p[desconto_cliente]":"0";        
      $SqlCampo['fator1'] = ($p['fator1'])? "$p[fator1]":"0";
      $SqlCampo['fator2'] = ($p['fator2'])? "$p[fator2]":"0";
      $SqlCampo['fob'] = $p['fob'];
      $SqlCampo['cif'] = $p['cif'];
      $SqlCampo['numero_internet'] = $this->numero_internet;
      $SqlCampo['data_importacao'] = $data_hoje;
      $SqlCampo['aprovado'] = "-1";
      $SqlCampo['venda_efetivada'] = 0;
      
      $SqlCampo['cgc_entrega'] = $p[cgc_entrega];
      $SqlCampo['cidade_entrega'] = $p[cidade_entrega];
      $SqlCampo['local_entrega'] = $p[local_entrega];
      $SqlCampo['bairro_entrega'] = $p[bairro_entrega];
      $SqlCampo['endereco_entrega_numero'] = $p[endereco_entrega_numero];
      $SqlCampo['estado_entrega'] = $p[estado_entrega];
      $SqlCampo['cep_entrega'] = $p[cep_entrega];
      $SqlCampo['codigo_ibge_entrega'] = ($p[codigo_ibge_entrega])?"$p[codigo_ibge_entrega]":"0";
      $SqlCampo['inscricao_entrega'] = $p[inscricao_entrega];
      $SqlCampo['tel_entrega'] = $p[tel_entrega];
      $SqlCampo['hora_envio_site'] = date("H:i");
      $SqlCampo['lista_preco'] = $p[lista_preco];
						$SqlCampo['pedido_internet'] = "1";
      $SqlCampo['desconto_pedido'] = $p[desconto_pedido];
      if($p[desconto_pedido] > "0"){
        $SqlCampo['destacar_desconto'] = "1";
      }      
      
      //Fiz isso pois a regra de desconto utilizada no site esta diferente da regra do next
      // 30/04/2014 11:42 - Dênis      
      $SQlDesc = pg_query($db, "SELECT codigo FROM descontos WHERE valor='".$p['fator1']."'");
      $DescCli = pg_fetch_array($SQlDesc);
      if(isset($DescCli['codigo'])){ $SqlCampo['desconto_cliente'] = $DescCli['codigo'];}
      
       while( $Campo = each($SqlCampo )){
         $SqlInicio = "Insert into pedidos (";
         $SqlExecutar .= " $Campo[key],";
         $SqlExecutar2 = " ) VALUES ( ";
         $SqlExecutar3 .= " '$Campo[value]',";
         $SqlFim = ")";
       }
       $Grava = $SqlInicio."".substr($SqlExecutar, 0, -1)."".$SqlExecutar2."".substr($SqlExecutar3, 0, -1)."".$SqlFim;
       //echo "SQL Pedidos: ".TrocaCaracteres($Grava)."<BR><BR>";
//       exit;
       if (!$_Err){
         pg_query ($db,TrocaCaracteres($Grava)) or die ($MensagemDbError.TrocaCaracteres($Grava).pg_query ($db, "rollback"));
       }
       unset($SqlCampo);
       unset($SqlExecutar);
       unset($SqlExecutar2);
       unset($SqlExecutar3);
       unset($SqlFim);
       unset($SqlInicio);
       unset($Campo);
       unset($Grava);
       //exit;
      /////////////////////////////////////////////////////////
      $SqlAlter = "Update pedidos set usuario_cadastrou='".left($_SESSION['usuario'], 10)."', data_alteracao='".$data_hoje."' where numero='".$max."'";
      pg_query($db, $SqlAlter);

      //Cria uma sequencia para o campo ID
      $uid = strtoupper($_REQUEST['id']+1);
      $ultimoid="SELECT MAX(id)+1 as ultimoid FROM alteracao_pedidos";
      $ultimoid = pg_query($ultimoid);
      $row = pg_fetch_array($ultimoid);
      //echo $row[ultimoid];

      $SqlCampo['id'] = $row['ultimoid'];
      $SqlCampo['numero_pedido'] = $max;
      $SqlCampo['usuario_alterou'] = left($_SESSION['login'], 10);
      $SqlCampo['data_alteracao'] = $data_hoje;
      $SqlCampo['ip'] = $_SERVER[REMOTE_ADDR];
      $SqlCampo['alteracao'] = "CADASTROU NOVO PEDIDO VIA SITE";

       while($Campo = each($SqlCampo)){
         $SqlInicio = "Insert into alteracao_pedidos (";
         $SqlExecutar .= " $Campo[key],";
         $SqlExecutar2 = " ) VALUES ( ";
         $SqlExecutar3 .= " '$Campo[value]',";
         $SqlFim = ")";
       }
       $Grava = $SqlInicio."".substr($SqlExecutar, 0, -1)."".$SqlExecutar2."".substr($SqlExecutar3, 0, -1)."".$SqlFim;
       //echo "SQL Alteracao: $Grava<BR><BR>";
       //exit;
       if (!$_Err){
         pg_query ($db,TrocaCaracteres($Grava)) or die ($MensagemDbError.$Grava.pg_query ($db, "rollback"));
       }
       unset($SqlCampo);
       unset($SqlExecutar);
       unset($SqlExecutar2);
       unset($SqlExecutar3);
       unset($SqlFim);
       unset($SqlInicio);
       unset($Campo);
       unset($Grava);
      /////////////////////////////////////////////////////////
      // Itens
      /////////////////////////////////////////////////////////
      $SqlCarregaItens = "Select * from itens_do_pedido_internet where numero_pedido = '".$numero."' order by id";
      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
        $SqlCarregaItens .= " , especial ";
      }
      $SqlCarregaItens = $SqlCarregaItens." ASC ";
      $SqlCarregaItens = pg_query($SqlCarregaItens) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
      while($i = pg_fetch_array($SqlCarregaItens)){
        //echo "<BR>$i[especial]";
        if ($i[especificado]=="1"){
          $Especificado = "1";
        }else{
          $Especificado = "0";
        }
        $prod = pg_query("Select base_reduzida from produtos where codigo='".$i['codigo']."'");
        $prod = pg_fetch_array($prod);

        $Cliente = pg_query("Select estado from clientes where cgc='".$p['cgc']."'");
        $Cliente = pg_fetch_array($Cliente);

        $Aliquota = pg_query("Select aliquota_01 from aliquotas_de_icm where est='".$Cliente['estado']."'");
        $Aliquota = pg_fetch_array($Aliquota);
        $IcmItem = $Aliquota['aliquota_01'] / 100;
        if ($prod['base_reduzida']=="1"){
          if ($Cliente['estado']=="SP"){
            $IcmItem = $prod['codigo_icms'] / 100;
          }
        }
        $IcmItem = $i['valor_total'] * $IcmItem;
        $TotalIcm += $IcmItem;
        $TotalItens += $i['valor_total'];
        
								//Busco comissão do vendedor
								$SCom = pg_query("SELECT comissao FROM vendedores WHERE id='".$id_vendedor."'");						
								$Com = pg_fetch_array($SCom);		

								if($Com['comissao']==""){
										$VCom = "0";
								}else{
										$VCom = $Com['comissao'];
								}								
								
								$ComissaoItem = $i['valor_total'] * ($VCom / 100);
								
        if ($i['especial']==0){
          /////////////////////////////////////////////////////////
          // NORMAL
          /////////////////////////////////////////////////////////
          $ValorLiquido = $i['valor_total'] - $IcmItem;
          if ($i['qtd']>0){
            $consulta = "INSERT INTO itens_do_pedido_vendas ";
            $consulta = $consulta." (numero_pedido,codigo,qtd,valor_unitario,";
            $consulta = $consulta."valor_total,";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " especial,especificado, valor_liquido, ";
            }
            $consulta = $consulta."ipi,valor_ipi,nome_do_produto, peso_bruto, peso_liquido, ";
            if ($i["fator1"]){
              $consulta = $consulta."fator1, ";
            }
            $consulta = $consulta." quantidade_reservada, reservado, preco_alterado, comissao, valor_comissao) values( ";
            $consulta=  $consulta."$max, '$i[codigo]', $i[qtd], ";
            $consulta = $consulta."'$i[valor_unitario]', ";
            $consulta = $consulta."'$i[valor_total]', ";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " 0, '$Especificado',  '$ValorLiquido', ";
            }
            $consulta = $consulta."'$i[ipi]', '$i[valor_ipi]', '$i[nome_do_produto]', ";
            $consulta = $consulta."'$i[peso_bruto]', '$i[peso_liquido]', ";
            if ($i["fator1"]){
              $consulta = $consulta."'$i[fator1]', ";
            }
            $consulta = $consulta." '$i[qtd]','1', '$i[preco_alterado]','$VCom','$ComissaoItem') ";
            $Total = $Total + $i[valor_total];
            pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          }
        }else{
          /////////////////////////////////////////////////////////
          // Especial
          /////////////////////////////////////////////////////////
          $ValorLiquido = $i[valor_total];
          if ($i[qtd]>0){
            $consulta = "INSERT INTO itens_do_pedido_vendas ";
            $consulta = $consulta." (numero_pedido,codigo,qtd,valor_unitario,";
            $consulta = $consulta."valor_total,";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " especial, ";
            }
            $consulta = $consulta."ipi, valor_ipi, nome_do_produto,preco_alterado, peso_bruto, peso_liquido, ";
            if ($i["fator2"]){
              $consulta = $consulta."fator2,";
            }
            $consulta = $consulta."especificado, quantidade_reservada, reservado, valor_liquido) values( ";
            $consulta=  $consulta."$max, '$i[codigo]', $i[qtd],";
            $consulta = $consulta."'$i[valor_unitario]', ";
            $consulta = $consulta."'$i[valor_total]',";
            if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
              $consulta .= " 1, ";
            }
            $consulta = $consulta."'$i[ipi]', '$i[valor_ipi]', '$i[nome_do_produto]'";
            $consulta = $consulta.",'$i[preco_alterado]', '$i[peso_bruto]', '$i[peso_liquido]', ";
            if ($i["fator2"]){
              $consulta = $consulta."'$i[fator2]', ";
            }
            $consulta = $consulta."'$Especificado', '$i[qtd]','1', '$ValorLiquido') ";
            $Total = $Total + $i[valor_total];
            $TotalEspecial = $TotalEspecial + $i[valor_total];
            pg_query ($db,$consulta) or die ($MensagemDbError.$consulta.pg_query ($db, "rollback"));
          }
        }
        //echo $consulta;
        $TotalLiquido += $ValorLiquido;
        //insere na tabela oficial todas as cores
        if ($CodigoEmpresa=="86"){ //só tem cores pra Perfil
          $consulta = "UPDATE itens_do_pedido_vendas set ";
          if ($i[preto] <> "") {
             $consulta .= "preto =".$i[preto];
             $divisor = ",";
          }
          if ($i[branco] <> "") {
             $consulta .= $divisor."branco =".$i[branco];
             $divisor = ",";
          }
          if ($i[azul] <> "") {
             $consulta .= $divisor."azul =".$i[azul];
             $divisor = ",";
          }
          if ($i[verde] <> "") {
             $consulta .= $divisor."verde =".$i[verde];
             $divisor = ",";
          }
          if ($i[vermelho] <> "") {
             $consulta .= $divisor."vermelho =".$i[vermelho];
             $divisor = ",";
          }
          if ($i[amarelo] <> "") {
             $consulta .= $divisor."amarelo =".$i[amarelo];
             $divisor = ",";
          }
          if ($i[marrom] <> "") {
             $consulta .= $divisor."marrom =".$i[marrom];
             $divisor = ",";
          }
          if ($i[cinza] <> "") {
             $consulta .= $divisor."cinza =".$i[cinza];
             $divisor = ",";
          }
          if ($i[laranja] <> "") {
             $consulta .= $divisor."laranja =".$i[laranja];
             $divisor = ",";
          }
          if ($i[rosa] <> "") {
             $consulta .= $divisor."rosa =".$i[rosa];
             $divisor = ",";
          }
          if ($i[violeta] <> "") {
             $consulta .= $divisor."violeta =".$i[violeta];
             $divisor = ",";
          }
          if ($i[bege] <> "") {
             $consulta .= $divisor."bege =".$i[bege];
             $divisor = ",";
          }
          if ($i[outra] <> "") {
             $consulta .= $divisor."outra =".$i[outra];
             $divisor = ",";
          }
          $consulta .= ",especificado=1, quantidade_reservada=$i[qtd], reservado=1 ";
          $consulta .= " WHERE numero_pedido=".$max." AND codigo='".$i[codigo]."'";
          if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
            $consulta .= " and especial='".$i['especial']."' ";
          }
          pg_query ($db,$consulta);
          $CodigoReserva = $i['codigo'];
        }
        $PesoBruto = $PesoBruto + $i['peso_bruto'];
        $PesoLiquido = $PesoLiquido + $i['peso_liquido'];
      }						
						
      if ($p['desconto_cliente']){
        $TotalDesconto = $Total  - $TotalEspecial; // TOTAL COM DESCONTO = TOTAL - ESPECIAL.
      }else{
        $TotalDesconto = $Total;
      }
      if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
        $SqlCamposExtra = "valor_total_liquido='".$TotalLiquido."', ";
      }
						
      $TotalComissao = $Total * ($VCom / 100);
						//echo "totalcom:".$TotalComissao;						
						
      $SqlUpdate = "update pedidos set especificado='".$Especificado."', $SqlCamposExtra total_sem_desconto='".$Total."', total_com_desconto='".$TotalDesconto."', comissao='".$VCom."', total_comissao='".$TotalComissao."', peso_bruto='".$PesoBruto."', peso_liquido='".$PesoLiquido."',pedido_internet='1' where numero='".$max."'";
      pg_query($SqlUpdate);
      if ($original){
        //////////////////////////////////////////////////////////////////
        pg_query("delete from pedidos where numero = $original");
        pg_query("delete from itens_do_pedido_vendas where numero_pedido = $original");
        pg_query("Update pedidos set numero=$original where numero = $max");
        pg_query("Update itens_do_pedido_vendas set numero_pedido=$original where numero_pedido = $max");
        pg_query("delete from pedidos where numero = $max");
        pg_query("delete from itens_do_pedido_vendas where numero_pedido = $max");
        $max = $numero; //desfaz o negreiro
        /////////////////////////////////////////////////////////////////
      }else{
        pg_query("update referencias set ultimo_numero_pedido='".$max."'");
      }
      
      //Checo OBS Cliente/Pedido
      $SqlObs = "SELECT incluir_obs_pedido, observacao FROM clientes WHERE id='".$p['id_cliente']."'";
      //echo $SqlObs;
      $SqlObs = pg_query($db, $SqlObs);
      $ObsPed = pg_fetch_array($SqlObs);
      if($ObsPed[incluir_obs_pedido] == "1"){
        $OBSCLI = $ObsPed[observacao];
      }
      
      $OBS = "INSERT INTO observacao_do_pedido (numero_pedido, observacao) VALUES (";
      $OBS = $OBS.$max.",";
      $OBS = $OBS."'".$OBSCLI." - ".$Observacao."')";
      pg_query($OBS);
      pg_query ($db, "commit");
      
      $datadia = date("Y-m-d");
      
      //Gravo alerta para next2000
      pg_query("INSERT INTO alerta_pedidos_internet ( numero_pedido, data, lido) VALUES('$max','$datadia ', 0) ");
      
      
      //Insere Desconto Destacado - H8
      $SqlDes = "SELECT ped.numero, ped.numero_internet,SUM(itn.valor_total) AS total_com_desconto, SUM(prod.preco_venda) AS total_sem_desconto
                 FROM itens_do_pedido_vendas AS itn
                 JOIN pedidos AS ped ON ped.numero = itn.numero_pedido
                 JOIN produtos AS prod ON prod.codigo = itn.codigo
                 WHERE ped.numero='".$max."'
                 GROUP BY ped.numero, ped.numero_internet";
                 
       //echo $SqlDes;
  
  }
}
?>
