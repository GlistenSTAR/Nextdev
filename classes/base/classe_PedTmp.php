<?php
/*
Classe PedTmp

Grava os pedidos da base temporária

Essa classe é usada em:

cadastrar_pedidos.php

27/11/2007 - Emerson - Tninfo
*/

class PedidoTemporario {
  //Setando acesso e pegando atributos
  public function set_operacao($operacao){                       $this->operacao = $operacao;                          }
  public function get_operacao(){                         return $this->operacao;                                      }

  public function set_clientecnpj($clientecnpj){                 $this->clientecnpj = $clientecnpj;                    }
  public function get_clientecnpj(){                      return $this->clientecnpj;                                   }

  public function set_cliente_cc($cliente_cc){                   $this->cliente_cc = $cliente_cc;                      }
  public function get_cliente_cc(){                       return $this->cliente_cc;                                    }

  public function set_contato_cc($contato_cc){                   $this->contato_cc = $contato_cc;                      }
  public function get_contato_cc(){                       return $this->contato_cc;                                    }

  public function set_DataPrevistaEntrega($DataPrevistaEntrega){  $this->DataPrevistaEntrega = $DataPrevistaEntrega;   }
  public function get_DataPrevistaEntrega(){               return $this->DataPrevistaEntrega;                          }

  public function set_cliente_id($cliente_id){                    $this->cliente_id = $cliente_id;                     }
  public function get_cliente_id(){                        return $this->cliente_id;                                   }

  public function set_trans_id($trans_id){                        $this->trans_id = $trans_id;                         }
  public function get_trans_id(){                          return $this->trans_id;                                     }

  public function set_numero($numero){                            $this->numero = $numero;                             }
  public function get_numero(){                            return $this->numero;                                       }

  public function set_numero_cliente($numero_cliente){            $this->numero_cliente = $numero_cliente;             }
  public function get_numero_cliente(){                    return $this->numero_cliente;                               }
  
  public function set_trans_cc($trans_cc){                        $this->trans_cc = $trans_cc;                         }
  public function get_trans_cc(){                          return $this->trans_cc;                                     }
  
  public function set_condpag1_id($condpag1_id){                  $this->condpag1_id = $condpag1_id;                   }
  public function get_condpag1_id(){                       return $this->condpag1_id;                                  }

  public function set_condpag2_id($condpag2_id){                  $this->condpag2_id = $condpag2_id;                   }
  public function get_condpag2_id(){                       return $this->condpag2_id;                                  }

  public function set_desconto($desconto){                        $this->desconto = $desconto;                         }
  public function get_desconto(){                          return $this->desconto;                                     }

  public function set_desconto11_cc($desconto11_cc){              $this->desconto11_cc = $desconto11_cc;               }
  public function get_desconto11_cc(){                     return $this->desconto11_cc;                                }

  public function set_desconto1_cc($desconto1_cc){                $this->desconto1_cc = $desconto1_cc;                 }
  public function get_desconto1_cc(){                      return $this->desconto1_cc;                                 }
  
  public function set_desconto22_cc($desconto22_cc){              $this->desconto22_cc = $desconto22_cc;               }
  public function get_desconto22_cc(){                     return $this->desconto22_cc;                                }
  
  public function set_desconto2_cc($desconto2_cc){                $this->desconto2_cc = $desconto2_cc;                 }
  public function get_desconto2_cc(){                      return $this->desconto2_cc;                                 }
  
  public function set_tipo_pedido($tipo_pedido){                  $this->tipo_pedido = $tipo_pedido;                   }
  public function get_tipo_pedido(){                       return $this->tipo_pedido;                                  }

  public function set_venda_casada($venda_casada){                $this->venda_casada = $venda_casada;                 }
  public function get_venda_casada(){                      return $this->venda_casada;                                 }
  
  public function set_com_termo($com_termo){                      $this->com_termo = $com_termo;                       }
  public function get_com_termo(){                         return $this->com_termo;                                    }
  
  public function set_local_entrega($local_entrega){              $this->local_entrega = $local_entrega;               }
  public function get_local_entrega(){                     return $this->local_entrega;                                }

  public function set_fob($fob){                                  $this->fob = $fob;                                   }
  public function get_fob(){                               return $this->fob;                                          }

  public function set_cgc_entrega($cgc_entrega){                  $this->cgc_entrega = $cgc_entrega;                   }
  public function get_cgc_entrega(){                       return $this->cgc_entrega;                                  }

  public function set_cidade_entrega($cidade_entrega){            $this->cidade_entrega = $cidade_entrega;             }
  public function get_cidade_entrega(){                    return $this->cidade_entrega;                               }

  public function set_bairro_entrega($bairro_entrega){            $this->bairro_entrega = $bairro_entrega;             }
  public function get_bairro_entrega(){                    return $this->bairro_entrega;                               }

  public function set_endereco_entrega_numero($endereco_entrega_numero){              $this->endereco_entrega_numero = $endereco_entrega_numero;   }
  public function get_endereco_entrega_numero(){                                return $this->endereco_entrega_numero;                             }

  public function set_estado_entrega($estado_entrega){            $this->estado_entrega = $estado_entrega;             }
  public function get_estado_entrega(){                    return $this->estado_entrega;                               }

  public function set_cep_entrega($cep_entrega){                  $this->cep_entrega = $cep_entrega;                   }
  public function get_cep_entrega(){                       return $this->cep_entrega;                                  }

  public function set_codigo_ibge_entrega($codigo_ibge_entrega){  $this->codigo_ibge_entrega = $codigo_ibge_entrega;   }
  public function get_codigo_ibge_entrega(){               return $this->codigo_ibge_entrega;                          }

  public function set_inscricao_entrega($inscricao_entrega){      $this->inscricao_entrega = $inscricao_entrega;       }
  public function get_inscricao_entrega(){                 return $this->inscricao_entrega;                            }

  public function set_tel_entrega($tel_entrega){                  $this->tel_entrega = $tel_entrega;                   }
  public function get_tel_entrega(){                       return $this->tel_entrega;                                  }
  
  public function set_lista_preco($lista_preco){                  $this->lista_preco = $lista_preco;                   }
  public function get_lista_preco(){                       return $this->lista_preco;                                  }
  
  public function set_DescDest($DescDest){                        $this->DescDest = $DescDest;                         }
  public function get_DescDest(){                           return $this->DescDest;                                    }  
  
  // Inincia as operações da classe, tudo o que estiver aqui dentro é o que ela poderá fazer.
  public function fazer(){

    include("inc/config.php");
    pg_query ($db, "begin");
    ######################################################
    # Gravando dados do pedido parte1
    ######################################################
    $SqlCampo['cgc'] = $this->clientecnpj;
    $SqlCampo['cliente'] = $this->cliente_cc;
    $SqlCampo['codigo_vendedor'] = $_SESSION['id_vendedor'];
    $SqlCampo['contato'] = left($this->contato_cc,20);
    $SqlCampo['data'] = $data_hoje;
    //echo "<BR><BR>$this->DataPrevistaEntrega<BR><BR>";
    //($this->DataPrevistaEntrega)?"$SqlCampo[data_prevista_entrega] = $this->DataPrevistaEntrega":"";
    $SqlCampo['data_prevista_entrega'] = $this->DataPrevistaEntrega;
    //echo "<BR><BR>$SqlCampo[data_prevista_entrega]<BR><BR>";
    $SqlCampo['id_cliente'] = $this->cliente_id;
    $SqlCampo['numero'] = $this->numero;
    $SqlCampo['numero_cliente'] = str_replace("'","",$this->numero_cliente);
    $SqlCampo['transportadora'] = $this->trans_cc;
    $SqlCampo['vendedor'] = left($_SESSION['nome_vendedor'], 20);
    $SqlCampo['tipo_pedido'] = $this->tipo_pedido;
    $SqlCampo['codigo_pagamento'] = ($this->condpag1_id)? "$this->condpag1_id":"0";
    $SqlCampo['codigo_pagamento1'] = ($this->condpag2_id)? "$this->condpag2_id":"0";
    $SqlCampo['desconto_cliente'] = ($this->desconto)? "$this->desconto":"0";
    if (($this->desconto11_cc) or ($this->desconto1_cc)){
      if ($this->desconto11_cc){
        $Desconto = $this->desconto11_cc; //Desconto do Item
      }elseif ($this->desconto1_cc){
        $Desconto = $this->desconto1_cc;  //Desconto do Pedido
      }else{
        $Desconto = 0;
      }
      $SqlCampo['fator1'] = $Desconto;
    }
    if (($this->desconto22_cc) or ($this->desconto2_cc)){
      if ($this->desconto22_cc){
        $Desconto = $this->desconto22_cc; //Desconto do Item
      }elseif ($this->desconto2_cc){
        $Desconto = $this->desconto2_cc;  //Desconto do Pedido
      }else{
        $Desconto = 0;
      }
      $SqlCampo['fator2'] = $Desconto;
    }
    //$SqlCampo['venda_casada'] = ($this->venda_casada=="true")?"1":"0";
    $SqlCampo['com_termo'] = ($this->com_termo=="true")?"1":"0";
    $SqlCampo['fob'] = ($this->fob=="CIF")?"0":"1";
    $SqlCampo['cif'] = ($this->fob=="CIF")?"1":"0";
    $SqlCampo['numero_internet'] = $this->numero;
    $SqlCampo['baixou_estoque'] = 0;
    $SqlCampo['data_importacao'] =$data_hoje;
    $SqlCampo['cgc_entrega'] = $this->cgc_entrega;
    $SqlCampo['cidade_entrega'] = $this->cidade_entrega;
    $SqlCampo['local_entrega'] = $this->local_entrega;
    $SqlCampo['bairro_entrega'] = $this->bairro_entrega;
    $SqlCampo['endereco_entrega_numero'] = $this->endereco_entrega_numero;
    $SqlCampo['estado_entrega'] = $this->estado_entrega;
    $SqlCampo['cep_entrega'] = $this->cep_entrega;
    $SqlCampo['codigo_ibge_entrega'] = ($this->codigo_ibge_entrega)?"$this->codigo_ibge_entrega":"0";
    $SqlCampo['inscricao_entrega'] = $this->inscricao_entrega;
    $SqlCampo['tel_entrega'] = $this->tel_entrega;
    $SqlCampo['lista_preco'] = $this->lista_preco;
    if($this->DescDest<>""){
      $SqlCampo['desconto_pedido'] = $this->DescDest;
    }else{
     $SqlCampo['desconto_pedido'] = 0;
    }

    while( $Campo = each($SqlCampo )){
      if ($this->operacao=="edita"){
        $SqlInicio = "Update pedidos_internet_novo set ";
        $SqlExecutar .= " $Campo[key]='$Campo[value]',";
        $SqlFim = " where numero='$this->numero' ";
      }else{
        $SqlInicio = "Insert into pedidos_internet_novo (";
        $SqlExecutar .= " $Campo[key],";
        $SqlExecutar2 = " ) VALUES ( ";
        $SqlExecutar3 .= " '$Campo[value]',";
        $SqlFim = ")";
      }
    }
    $Grava = $SqlInicio."".substr($SqlExecutar, 0, -1)."".$SqlExecutar2."".substr($SqlExecutar3, 0, -1)."".$SqlFim;
    //echo $Grava;
//    exit;
    if (!$_Err){
     // pg_query ($db,TrocaCaracteres($Grava)) or die ($MensagemDbError.$Grava.pg_query ($db, "rollback"));
    }
  }
}
?>
