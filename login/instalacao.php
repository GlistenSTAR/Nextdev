CREATE TABLE pedidos_internet_novo
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
  CONSTRAINT pedidos_internet_novo_pkey PRIMARY KEY (numero)
)
WITH OIDS;
ALTER TABLE pedidos_internet_novo OWNER TO postgres;

alter table pedidos_internet_novo add column enviado integer DEFAULT 0;
alter table pedidos_internet_novo add column desconto double precision;
alter table pedidos add column data_importacao character varying(30);
alter table referencias add column ultimo_numero_pedido_internet integer DEFAULT 0;

CREATE TABLE itens_do_pedido_internet
(
  id integer NOT NULL DEFAULT nextval(('"itens_do_pedido_internet_id_seq"'::text)::regclass),
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
  CONSTRAINT itens_do_pedido_internet_pkey PRIMARY KEY (id)
)
WITH OIDS;
ALTER TABLE itens_do_pedido_internet OWNER TO postgres;
alter table itens_do_pedido_internet add column preco_venda varchar(20);
alter table itens_do_pedido_internet add column qtd_caixa varchar(20);
alter table itens_do_pedido_internet add column preco_minimo varchar(20);

CREATE SEQUENCE itens_do_pedido_internet_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE itens_do_pedido_internet_id_seq OWNER TO postgres;

CREATE TABLE noticias (
  id integer NOT NULL DEFAULT nextval(('"noticias_id_seq"'::text)::regclass),
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

CREATE SEQUENCE noticias_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE noticias_id_seq OWNER TO postgres;

alter table vendedores add column ultimo_login timestamp;
alter table vendedores add column qtd_entrada_site integer;

CREATE TABLE categorias (
  id integer NOT NULL DEFAULT nextval(('"categorias_id_seq"'::text)::regclass),
  nome varchar(120) NOT NULL default '',
  descricao text NOT NULL,
  ativo integer NOT NULL default '0',
  CONSTRAINT categorias_id_pkey PRIMARY KEY (id)
) ;

CREATE SEQUENCE categorias_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE categorias_id_seq OWNER TO postgres;

CREATE TABLE categorias_sub (
  id integer NOT NULL DEFAULT nextval(('"categorias_sub_id_seq"'::text)::regclass),
  id_categoria integer NOT NULL default '0',
  nome varchar(120) NOT NULL default '',
  descricao text NOT NULL,
  ativo integer NOT NULL default '0',
  CONSTRAINT categorias_sub_id_pkey PRIMARY KEY (id)
) ;

CREATE SEQUENCE categorias_sub_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE categorias_sub_id_seq OWNER TO postgres;

CREATE TABLE imagens (
  id integer NOT NULL DEFAULT nextval(('"imagens_id_seq"'::text)::regclass),
  imagem varchar(120) NOT NULL default '',
  legenda text NOT NULL,
  data date,
  ativo integer NOT NULL default '0',
  CONSTRAINT imagens_id_pkey PRIMARY KEY (id)
) ;

CREATE SEQUENCE imagens_id_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE imagens_id_seq OWNER TO postgres;

alter table referencias add column fatmin float;
alter table pedidos add column numero_internet double precision;
alter table vendedores add column login varchar(25);
alter table vendedores add column senha varchar(25);
alter table pedidos add column emissao varchar(20);
alter table vendedores add column nivel_site integer;
