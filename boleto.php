<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa			       	  |
// | 																	                                    |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Bradesco: Ramon Soares						            |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

include "inc/config.php";

$Sql = pg_query("select * from pedidos where numero='$_REQUEST[numero]'");
$p = pg_fetch_array($Sql);

$Sql = pg_query("select * from referencia_empresa");
$r = pg_fetch_array($Sql);

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 2.95;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $p[total_sem_desconto]; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "75896452";  // Nosso numero sem o DV - REGRA: M�ximo de 11 caracteres!
$dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $p[cliente];
$dadosboleto["endereco1"] = $p[endereco_cliente];
$dadosboleto["endereco2"] = "$p[cidade_cliente] - $p[estado_cliente] - CEP: $p[cep]"; //"S�o Paulo - SP - CEP: 010200-000";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento de Boleto Perlex";
$dadosboleto["demonstrativo2"] = "Valor referente a pedido de venda $p[numero]<br>Taxa banc�ria - R$ ".$taxa_boleto;
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% ap�s o vencimento";
$dadosboleto["instrucoes2"] = "- Receber at� 10 dias ap�s o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de d�vidas entre em contato conosco: faturamentoperlex@grupoperlex.com.br";
$dadosboleto["instrucoes4"] = " ";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "001";
$dadosboleto["valor_unitario"] = $valor_boleto;
$dadosboleto["aceite"] = "";
$dadosboleto["uso_banco"] = "";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DS";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - Bradesco
$dadosboleto["agencia"] = "1172"; // Num da agencia, sem digito
$dadosboleto["agencia_dv"] = "0"; // Digito do Num da agencia
$dadosboleto["conta"] = "0403005"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - Bradesco
$dadosboleto["conta_cedente"] = "0403005"; // ContaCedente do Cliente, sem digito (Somente N�meros)
$dadosboleto["conta_cedente_dv"] = "2"; // Digito da ContaCedente do Cliente
$dadosboleto["carteira"] = "06";  // C�digo da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] = $r[nome_contribuinte];
$dadosboleto["cpf_cnpj"] = $r[cnpj];
$dadosboleto["endereco"] = $r[endereco];
$dadosboleto["cidade_uf"] = "$r[municipio] - $r[estado]";
$dadosboleto["cedente"] = $r[nome_contribuinte];

// N�O ALTERAR!
include("inc/boletos/funcoes_bradesco.php");
include("inc/boletos/layout_bradesco.php");
?>
