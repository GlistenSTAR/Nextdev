<?php
/*
* Classe para Abstração de Banco de Dados
* Utilizando MySQL e Geração de Log de erros!
*/
class bd {
	/*
	* Nome do  servidor de banco de dados.
	* @name $host
	*/
	var $host = "localhost";

	/*
	* Nome da base de dados.
	* @name $base
	*/
	var $base = "nome_da_base_de_dados";

	/*
	* Usuário do banco de dados.
	* @name $user
	*/
	var $user = "tmferreira";

	/*
	* Senha do banco de dados.
	* @name $password
	*/
	var $password = "blog";

	/*
	* Armazena a conexão ativa com o banco de dados
	* @name $conexao
	*/
	var $conexao = NULL;

	/*
	* Armazena as mensagens de erros geradas pela classe.
	* @name $erros
	*/
	var $erros = array(
		      0 => "Aconteceu um erro desconhecido. Contacte o administrador do sistema.",
		   1045 => "Acesso negado! Usuário ou senha inválido.",
	    1049 => "Banco de Dados não encontrado.",
	    1062 => "Entrada duplicada em chave única.",
	    1146 => "Tabela inexistente.",
	    2003 => "Impossível conectar ao servidor MySQL.",
	    2005 => "Servidor inexistente."
	);

	/*
	* Método construtor.
	* Registra o método desconecta para ser executado no final da execução do script ou detruir o objeto gerado.
	* @name $bd
	* @return void
	*/
	function __construct() {
		register_shutdown_function( array( &$this, "desconecta" ) );
	}

	/*
	* Conecta ao banco de dados.
	* @name $conecta
	* @return String (em caso de erro)
	*/
	function conecta() {
		$erros = $this->erros;
		if ( $this->conexao == NULL ) {
			if ( !$con = @mysql_connect( $this->host, $this->user, $this->password ) ) {
				if ( array_key_exists( mysql_errno(), $erros ) ) {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= $erros[mysql_errno()] . "rn";
					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[mysql_errno()];
				} else {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= mysql_error() . "rn";
					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[0];
				}
			}
			if ( !$db = @mysql_select_db( $this->base, $con ) ) {
				if ( array_key_exists( mysql_errno(), $erros ) ) {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= $erros[mysql_errno()] . "rn";
					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[mysql_errno()];
				} else {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= mysql_error() . "rn";
					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[0];
				}
			}
			$this->conexao = $con;
		}
	}
	/*
	* Desconecta do banco de dados
	* @name $desconecta
	* @return void
	*/
	function desconecta() {
		if ( $this->conexao != NULL && @mysql_close( $this->conexao ) ) {
			$this->conexao = NULL;
		}
	}
	/*
	* Executa uma query SQL
	* @name $query
	* @param String $sql (query SQL)
	* @return Resource (em caso de sucesso)
	* @return String (em caso de erro)
	* @return False (caso não seja passado parâmetro ou a conexão dê erro)
	*/
	function query($sql) {
		$erros = $this->erros;
		if ( $this->conexao == NULL ) {
			$this->conecta();
		}
		if ( !empty( $sql ) && $this->conexao != NULL ) {
			if ( !$query = @mysql_query( $sql, $this->conexao ) ) {
				if ( array_key_exists( mysql_errno(), $erros ) ) {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= $erros[mysql_errno()] . "rn";

					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[mysql_errno()];
				} else {
					$erro = date("d/m/Y h:i:s", time()) . "rn";
					$erro .= mysql_error() . "rn";

					/*
					* Grava o erro no arquivo de logs erros.log
					*/
					error_log($erro, 3, "erros.log");
					return $erros[0];
				}
			}
			return $query;
		}
		$this->desconecta();
		return false;
	}

	/*
	* Retorna o número de registros de uma consulta.
	* @name $num_rows
	* @param Resource $query
	* @return Integer (em caso de sucesso)
	* @return False (em caso de falha)
	*/
	function num_rows( $query ) {
		if ( is_resource( $query ) ) {
			return mysql_num_rows( $query );
		}
		return false;
	}

	/*
	* Retorna um array com os valores de um registro de uma consulta. O array de retorno pode ser acessado através de índices numéricos ou nome das colunas da consulta.
	* @name $fetch_array
	* @param Resource $query
	* @return Array (em caso de sucesso)
	* @return False (em caso de falha)
	*/
	function fetch_array( $query ) {
		if ( is_resource( $query ) ) {
			return mysql_fetch_array( $query );
		}
		return false;
	}

	/*
	* Retorna um array com os valores de um registro de uma consulta. O array de retorno pode ser acessado através do nome das colunas da consulta.
	* @name $fetch_assoc
	* @param Resource $query
	* @return Array (em caso de sucesso)
	* @return False (em caso de falha)
	*/
	function fetch_assoc( $query ) {
		if ( is_resource( $query ) ) {
			return mysql_fetch_assoc( $query );
		}
		return false;
	}

	/*
	* Retorna um array com os valores de um registro de uma consulta. O array de retorno pode ser acessado através de índices numéricos.
	* @name $fetch_row
	* @param Resource $query
	* @return Array (em caso de sucesso)
	* @return False (em caso de falha)
	*/
	function fetch_row( $query ) {
		if ( is_resource( $query ) ) {
			return mysql_fetch_row( $query );
		}
		return false;
	}

	/*
	* Retorna o id gerado na última instrução INSERT de uma tabela com campo auto_increment.
	* @name $insert_id
	* @return Integer (em caso de sucesso)
	*/
	function insert_id() {
		if ( $this->conexao == NULL ) {
			$this->conecta();
		}
		$id = mysql_insert_id( $this->conexao );
		$this->desconecta();
		return $id;
	}
	/*
	* Retorna o número de registros afetados por uma query SQL de INSERT, UPDATE ou DELETE.
	* @name $affected_rows
	* @return Integer (em caso de sucesso)
	*/
	function affected_rows() {
		if ( $this->conexao == NULL ) {
			$this->conecta();
		}
		$quant = mysql_affected_rows( $this->conexao );
		$this->desconecta();
		return $quant;
	}
}
?>
