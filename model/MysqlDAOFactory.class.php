<?php
include("MysqlUsuariosDAO.php");
include("MysqlIntegracoesDAO.php");


class MysqlDAOFactory{

	private $connection;
	
	public function getUsuariosDAO(){
		return new MysqlUsuariosDAO($this->getConnection());
	}
	public function getIntegracoesDAO(){
		return new MysqlIntegracoesDAO($this->getConnection());
	}

	private function getConnection(){

		$servidor = "localhost";
		$usuario = "root";
		$senha = "";
		
		try{
			$this->connection = mysqli_connect($servidor, $usuario, $senha);
			mysqli_select_db($this->connection,"diprotec");
			return $this->connection;
		}
		catch(Exception $e){
			echo "Erro na conexao com o banco de dados.";
		}
	}

	public function close(){
		mysqli_close($this->connection);
	}

}

?>
