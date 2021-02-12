<?php
include ("inc/common.php");
include_once "inc/config.php";
function ConfereCampos($Tabela,$Campo,$Tipo){
  $Sql = pg_query("SELECT column_name FROM information_schema.columns WHERE table_name ='".$Tabela."' and column_name='".$Campo."'");
  $ccc = pg_num_rows($Sql);
  if (!$ccc){
    $Sql = "
           alter table $Tabela add column $Campo $Tipo;
           ";
    echo "<BR>Campo <b>$Campo</b> (<b>$Tipo</b>) <font color=red>criados na Tabela <b>$Tabela</b></font>!";
    pg_query($Sql);
  }else{
    echo "<BR>Campo <b>$Campo</b> (<b>$Tipo</b>) já existe.";
  }
}
##########################################################################################################
#
#                       CHECAGEM DE TABELAS - POSTGRES
#
##########################################################################################################
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "log_site";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela (
                id integer DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                sql text  default '',
                data date,
                ip  varchar (20) default '',
                CONSTRAINT ".$Tabela."_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "pedidos_internet_novo";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela
              (
                base_calculo_icms double precision,
                base_icms_substituicao double precision,
                cancelado smallint DEFAULT 0,
                cfop character varying(10),
                cgc character varying(18),
                cliente character varying(50),
                cod_area_entrega integer,
                cod_regiao_entrega integer,
                codigo_indexador smallint,
                codigo_pagamento smallint,
                codigo_vendedor integer,
                coleta integer,
                comissao double precision DEFAULT 0,
                contas_a_receber smallint,
                contato character varying(20),
                data date,
                data_emissao_nota date,
                data_indexador date,
                data_prevista_entrega date,
                data_quitacao date,
                desconto_cliente double precision,
                desconto_cliente2 double precision,
                desconto_cliente3 double precision,
                desconto_pedido double precision,
                destacar_desconto smallint,
                distribuidora integer,
                divisao character varying(25),
                especie character varying(10),
                frete integer,
                frete_icms smallint,
                frete_total smallint,
                icms double precision,
                id_cliente integer,
                indexado smallint,
                lista_preco smallint,
                local_entrega character varying(200),
                marca character varying(10),
                natureza_da_operacao character varying(35),
                nota smallint,
                numero double precision NOT NULL,
                numero_cliente character varying(15),
                numero_nota character varying(10),
                numero_pedido_vendedor character varying(15),
                numero2 character varying(10),
                obs1_nota character varying(60),
                obs2_nota character varying(60),
                obs3_nota character varying(60),
                obs4_nota character varying(60),
                outras_despesas double precision,
                outras_icms smallint,
                outras_total smallint,
                outros integer,
                peso_bruto character varying(20),
                peso_liquido character varying(20),
                qtd double precision,
                quitacao integer,
                reservado integer,
                retira_base integer,
                retira_produtos integer,
                sedex double precision,
                seguro_icms smallint,
                seguro_total smallint,
                status character varying(15),
                tipo_de_venda integer,
                total_com_desconto double precision,
                total_comissao double precision,
                total_ipi double precision,
                total_produtos double precision,
                total_sem_desconto double precision,
                transportadora character varying(50),
                valor_frete double precision,
                valor_icms double precision,
                valor_icms_substituicao double precision,
                valor_indexador double precision,
                valor_nota double precision,
                valor_seguro double precision,
                valor_total_nota double precision,
                venda_efetivada smallint,
                vendedor character varying(50),
                tem_especial integer,
                parcial integer,
                data_cancelamento date,
                fator1 double precision DEFAULT 0,
                fator2 double precision DEFAULT 0,
                fardo integer,
                numero_caixa integer,
                codigo_pagamento1 integer DEFAULT 0,
                banco_cliente character varying(50),
                impresso smallint,
                data_impressao date,
                valor_total_liquido double precision,
                fob integer DEFAULT 0,
                aprovado smallint DEFAULT 0,
                motivo_cancelamento character varying(150),
                cif smallint,
                calculado smallint DEFAULT 0,
                req_impressa smallint DEFAULT 0,
                pedido_saldo double precision,
                especificado smallint DEFAULT 0,
                motivo_rejeicao character varying(30),
                motivo_rejeicao_venda character varying(30),
                gerou_op smallint,
                data_efetivacao date,
                garantia integer,
                data_conferencia date,
                conferido_por character varying(15),
                embalado_por character varying(15),
                entregue_por character varying(15),
                id_transportadora double precision,
                data_hora_efetivacao timestamp with time zone,
                encerrado integer,
                numero_internet double precision, -- adicionado para analisar a duplicação de pedidos vindos do site
                com_termo smallint DEFAULT 0,
                baixou_estoque smallint DEFAULT 0,
                data_importacao character varying(30),
                CONSTRAINT ".$Tabela."_pkey PRIMARY KEY (numero)
              )
              WITH OIDS;
              ALTER TABLE $Tabela OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "itens_do_pedido_internet";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela
                (
                  id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                  caixas double precision,
                  codigo character varying(15),
                  comissao double precision,
                  custo double precision,
                  ipi double precision,
                  nome_do_produto character varying(254),
                  numero_pedido double precision,
                  peso_bruto1 character varying(20),
                  peso_liquido1 character varying(20),
                  preco_alterado character varying(1),
                  qtd double precision,
                  quantidade_reservada double precision,
                  reservado smallint,
                  unidade character varying(2),
                  valor_comissao double precision,
                  valor_ipi double precision,
                  valor_total double precision,
                  valor_unitario double precision,
                  especial integer,
                  nome_produto character varying(254),
                  preto real,
                  branco real,
                  azul real,
                  verde real,
                  vermelho real,
                  amarelo real,
                  marrom real,
                  outra real,
                  peso_bruto real,
                  peso_liquido real,
                  rosa real DEFAULT 0,
                  violeta real DEFAULT 0,
                  laranja real DEFAULT 0,
                  cinza real DEFAULT 0,
                  valor_liquido double precision,
                  fator1 double precision DEFAULT 0,
                  fator2 double precision DEFAULT 0,
                  bege real DEFAULT 0,
                  especificado smallint DEFAULT 0,
                  verde_amarelo real DEFAULT 0,
                  entregue_preto integer DEFAULT 0,
                  entregue_branco integer DEFAULT 0,
                  entregue_azul integer DEFAULT 0,
                  entregue_verde integer DEFAULT 0,
                  entregue_vermelho integer DEFAULT 0,
                  entregue_amarelo integer DEFAULT 0,
                  entregue_marrom integer DEFAULT 0,
                  entregue_outra integer DEFAULT 0,
                  entregue_cinza integer DEFAULT 0,
                  entregue_laranja integer DEFAULT 0,
                  entregue_rosa integer DEFAULT 0,
                  entregue_violeta integer DEFAULT 0,
                  entregue_bege integer DEFAULT 0,
                  entregue_verde_amarelo integer DEFAULT 0,
                  encerrado integer,
                  numero_internet double precision, -- adicionado para corrigir o problema de duplicidade
                  CONSTRAINT ".$Tabela."_pkey PRIMARY KEY (id)
                )
                WITH OIDS;
                ALTER TABLE $Tabela OWNER TO postgres;
                CREATE SEQUENCE ".$Tabela."_id_seq
                  INCREMENT 1
                  MINVALUE 1
                  MAXVALUE 9223372036854775807
                  START 1
                  CACHE 1;
                ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "noticias";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                id_usuario integer NOT NULL default '0',
                titulo varchar(120) NOT NULL default '',
                texto text NOT NULL,
                foto varchar(60) NOT NULL default '',
                autor varchar(60) NOT NULL default '',
                data date,
                categoria varchar(100) NOT NULL default '',
                ativo integer NOT NULL default '0',
                data_alteracao date,
                posicao integer NOT NULL default '0',
                legenda varchar(200) NOT NULL default '',
                publicado integer NOT NULL default '0',
                data_publicacao date,
                hora_publicacao time NOT NULL default '00:00:00',
                CONSTRAINT noticias_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;

             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "categorias";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                nome varchar(120)  default '',
                descricao text,
                ativo integer default '0',
                CONSTRAINT categorias_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "alteracao_pedidos";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                numero_pedido double precision,
                usuario_alterou character varying(10),
                data_alteracao date,
                alteracao text,
                CONSTRAINT alteracao_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "categorias_sub";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                id_categoria integer default '0',
                nome varchar(120) default '',
                descricao text,
                ativo integer default '0',
                CONSTRAINT ".$Tabela."_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "categorias_sub_sub";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."'");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                id_categoria integer default '0',
                id_categoria_sub integer default '0',
                nome varchar(120) default '',
                descricao text,
                ativo integer default '0',
                CONSTRAINT ".$Tabela."_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "imagens";
    $Sql = pg_query("select * from information_schema.tables where table_schema='public' and table_type='BASE TABLE' and table_name='".$Tabela."''");
    $ccc = pg_num_rows($Sql);
    if (!$ccc){
      $Sql = "
              CREATE TABLE $Tabela(
                id integer NOT NULL DEFAULT nextval(('\"".$Tabela."_id_seq\"'::text)::regclass),
                id_categoria integer default '0',
                id_categoria_sub integer default '0',
                id_categoria_sub_sub integer default '0',
                imagem varchar(120) default '',
                legenda text,
                data date,
                ativo integer default '0',
                CONSTRAINT ".$Tabela."_id_pkey PRIMARY KEY (id)
              ) ;

              CREATE SEQUENCE ".$Tabela."_id_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
              ALTER TABLE ".$Tabela."_id_seq OWNER TO postgres;
             ";
      echo "<BR>Tabela <b>$Tabela</b> <font color=red>criada!</font>";
      pg_query($Sql);
    }else{
      echo "<BR>Tabela <b>$Tabela</b> ja existe";
    }
##########################################################################################################
#
#                       CHECAGEM DE CAMPOS - POSTGRES
#
##########################################################################################################
  ##########################################################################################################
  #
  #          Exclusivo - Perlex e Perfil
  #
  ##########################################################################################################
  if (($CodigoEmpresa=="75") or ($CodigoEmpresa=="86")){
    $Tabela = "pedidos";
    $Campo = "venda_casada";
    $Tipo = "smallint default 0";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "com_termo";
    $Tipo = "smallint default 0";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "vendedores";
    $Campo = "caixa_fechada";
    $Tipo = "integer default 1";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "pedidos_internet_novo";
    $Campo = "venda_casada";
    $Tipo = "smallint DEFAULT 0";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "com_termo";
    $Tipo = "smallint DEFAULT 0";
    ConfereCampos($Tabela,$Campo,$Tipo);
  }
  ##########################################################################################################
  #
  #                       Todos os clientes
  #
  ##########################################################################################################
    $Tabela = "alteracao_pedidos";
      $Campo = "ip";                                    $Tipo = "varchar(20)";        ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "referencias";
      $Campo = "fatmin";                                $Tipo = "float";               ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "ultimo_numero_pedido_internet";         $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "pedidos";
      $Campo = "numero_internet";                       $Tipo = "double precision";    ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "tipo_pedido";                           $Tipo = "varchar(5)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "hora_envio_site";                       $Tipo = "varchar(5)";          ConfereCampos($Tabela,$Campo,$Tipo);

      $Campo = "data_importacao";                       $Tipo = "varchar(30)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "fob";                                   $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "motivo_cancelamento";                   $Tipo = "varchar(150)";        ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "usuario_cadastrou";                     $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "data_alteracao";                        $Tipo = "date";                ConfereCampos($Tabela,$Campo,$Tipo);

      $Campo = "data_importacao";                       $Tipo = "varchar(30)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "fob";                                   $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "motivo_cancelamento";                   $Tipo = "varchar(150)";        ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "usuario_cadastrou";                     $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "data_alteracao";                        $Tipo = "date";                ConfereCampos($Tabela,$Campo,$Tipo);
      
      $Campo = "cgc_entrega";                           $Tipo = "varchar(18)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "cidade_entrega";                        $Tipo = "varchar(60)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "bairro_entrega";                        $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "endereco_entrega_numero";               $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "estado_entrega";                        $Tipo = "varchar(2)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "cep_entrega";                           $Tipo = "varchar(9)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "codigo_ibge_entrega";                   $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "inscricao_entrega";                     $Tipo = "varchar(25)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "tel_entrega";                           $Tipo = "varchar(14)";         ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "transportadoras";
      $Campo = "inativo";                               $Tipo = "smallint default 0";  ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "vendedores";
    $Campo = "login";
    $Tipo = "varchar(25)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "ativo";
    $Tipo = "smallint default 1";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "nivel_site";
    $Tipo = "smallint default 1";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "senha";
    $Tipo = "varchar(25)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "ultimo_login";
    $Tipo = "timestamp";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "qtd_entrada_site";
    $Tipo = "integer";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "pedidos_internet_novo";
      $Campo = "enviado";                               $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "desconto";                              $Tipo = "double precision";    ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "tipo_pedido";                           $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "numero_internet";                       $Tipo = "double precision";    ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "tipo_pedido";                           $Tipo = "varchar(5)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "cgc_entrega";                           $Tipo = "varchar(18)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "cidade_entrega";                        $Tipo = "varchar(60)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "bairro_entrega";                        $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "endereco_entrega_numero";               $Tipo = "varchar(20)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "estado_entrega";                        $Tipo = "varchar(2)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "cep_entrega";                           $Tipo = "varchar(9)";          ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "codigo_ibge_entrega";                   $Tipo = "integer DEFAULT 0";   ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "inscricao_entrega";                     $Tipo = "varchar(25)";         ConfereCampos($Tabela,$Campo,$Tipo);
      $Campo = "tel_entrega";                           $Tipo = "varchar(14)";         ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "clientes";
    $Campo = "codigo_ibge_cobranca";
    $Tipo = "integer";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "codigo_ibge_entrega";
    $Tipo = "integer";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "email_nfe";
    $Tipo = "varchar(120)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "condicao_pagamento";
    $Campo = "site";
    $Tipo = "character varying(10) default 1";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "itens_do_pedido_internet";
    $Campo = "preco_venda";
    $Tipo = "varchar(20)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "itens_do_pedido_vendas";
    $Campo = "especial";
    $Tipo = "integer";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "itens_do_pedido_internet";
    $Campo = "qtd_caixa";
    $Tipo = "varchar(20)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "preco_minimo";
    $Tipo = "varchar(20)";
    ConfereCampos($Tabela,$Campo,$Tipo);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $Tabela = "imagens";
    $Campo = "id_categoria";
    $Tipo = "integer";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "id_categoria_sub";
    ConfereCampos($Tabela,$Campo,$Tipo);
    $Campo = "id_categoria_sub_sub";
    ConfereCampos($Tabela,$Campo,$Tipo);
    tipo_pedido
?>
