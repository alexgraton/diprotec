<?php
class MysqlUsuariosDAO{

	private $con;

	public function __construct($con){
		$this->con = $con;
	}
	
	
	public function jaVotou($idEleicao,$idUsuario){
        $query = "select count(*) from votos where idEleicao = $idEleicao and idUsuario = $idUsuario";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		if($tupla[0] > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function qtdUsuarios(){
        $query = "select count(*) as qtd from usuarios where is_active = '1'";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	
	public function excluiAcessoEmpresa($id,$idEmpresa){
			
		$sql = "delete from usuAcessoEmpresa where idUsuario = $id and idEmpresa = $idEmpresa";
	
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}
	}
	
	public function incluiAcessoEmpresa($id,$idEmpresa){
			
		$sql = "insert into usuAcessoEmpresa (idUsuario, idEmpresa) values ($id,$idEmpresa); ";
	
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}
	}

	
	public function listaAcessosUsuarioEmpresa($id,$idEmpresa){
		
		$query = "SELECT * FROM usuAcessoEmpresa where idUsuario = $id and idEmpresa = $idEmpresa";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
		
		if(mysqli_num_rows($rs) > 0){
			return " checked ";			
		}else{
			return " ";
		}
				
	}
	
	public function listaEmpresas(){
		
		$query = "select * from detalhesBancos;";
		
		$rs = mysqli_query($this->con, $query) or mysqli_error();
		$i = 0;
		$matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			$matriz[$i]['idDetalhesBancos'] = $tupla['idDetalhesBancos'];
			$matriz[$i]['idBanco'] = $tupla['idBanco'];
			$matriz[$i]['nomeDetalhesBancos'] = $tupla['nomeDetalhesBancos'];
			
			$i++;
			
		}
		
		return $matriz;
		
	}
	
	
	public function listaTelas(){
		
		$query = "SELECT * FROM usuTelas";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
        $i=0;
        $matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			
             $matriz[$i]["idTela"] = $tupla["idTela"];
             $matriz[$i]["nomeTela"] = $tupla["nomeTela"];			 
			$i++;
		}
		return $matriz;
		
	}
	
	



	public function dadosUsuarioPorId($id){
		
		$query = "SELECT * FROM usuarios where idUsuario = $id";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
        $i=0;
        $matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			
             $matriz[$i]["idUsuario"] = $tupla["idUsuario"];
             $matriz[$i]["nomeUsuario"] = $tupla["nomeUsuario"];			 
             $matriz[$i]["email"] = $tupla["email"];
			 $matriz[$i]["is_active"] = $tupla["is_active"];
			 $matriz[$i]["dtCadastro"] = $tupla["dtCadastro"];
		
			$i++;
		}
		return $matriz;
				
	}
	
	
	public function incluiAcesso($id,$idTela){
			
		$sql = "insert into usuAcesso (idUsuario, idTela) values ($id,$idTela); ";
	
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}
	}
	
	public function excluiAcesso($id,$idTela){
			
		$sql = "delete from usuAcesso where idUsuario = $id and idTela = $idTela";
	
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}
	}
	
	public function listaAcessosUsuario($id,$idTela){
		
		$query = "SELECT * FROM usuAcesso where idUsuario = $id and idTela = $idTela";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
		
		if(mysqli_num_rows($rs) > 0){
			return " checked ";			
		}else{
			return " ";
		}
				
	}
	
		
	public function buscaUsuarios($id){
		
		$query = "select * from usuarios where idUsuario = $id";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
        $i=0;
        $matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			
             $matriz[$i]["idUsuario"] = $tupla["idUsuario"];
             $matriz[$i]["nomeUsuario"] = $tupla["nomeUsuario"];
             $matriz[$i]["login"] = $tupla["login"];
             $matriz[$i]["nivelAcesso"] = $tupla["nivelAcesso"];
			 
			$i++;
		}
		return $matriz;		
	}	
	
	public function insereInfos($nome, $email, $senha){
				
		$sql = "INSERT INTO usuarios (nomeUsuario, email, senha, dtCadastro, is_active) 
				VALUES ('$nome', '$email', '$senha', now(), 1);";				
		
		if(mysqli_query($this->con,$sql)or die(mysqli_error($this->con))){
			return true;
		}else{
			return false;			
		}
	
	}


	public function alteraInfos($nome, $email, $senha, $ativo, $idUsuario){
				
		$sql = "update usuarios set 
						nomeUsuario = '$nome',
						email = '$email',";		
							
							
		if($senha != ''){
			$sql .= "senha = '$senha',";
		}

		$sql .= "is_active = '$ativo'
			where idUsuario = $idUsuario;";
		
		if(mysqli_query($this->con,$sql)or die(mysqli_error($this->con))){
			return true;
		}else{
			return false;			
		}
	
	}
	
	public function excluiInfo($id){
			
		$sql = "delete from usuarios 
		where idUsuario = ($id)";
	
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}
	}
	
	public function editaInfo($idUsuario,$valor,$campo){
			
		$sql = "update usuarios 
					set $campo = '$valor'
						where idUsuario = ($idUsuario)";
							
		if(mysqli_query($this->con,$sql)){
			@$usuarioDaSessao  = $_SESSION['idUsuario'];
			if($usuarioDaSessao == $idUsuario){
				$_SESSION['senha'] = '123456';
			}
			
			return true;
		}else{
			return false;			
		}
	}
	
	public function listaUsuarios(){
		
		$query = "SELECT * FROM usuarios";
				   
		$rs = mysqli_query( $this->con, $query) or mysqli_error();
        $i=0;
        $matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			
             $matriz[$i]["idUsuario"] = $tupla["idUsuario"];
             $matriz[$i]["nomeUsuario"] = $tupla["nomeUsuario"];
             $matriz[$i]["login"] = $tupla["login"];
             $matriz[$i]["nivelAcesso"] = $tupla["nivelAcesso"];
			 
			$i++;
		}
		return $matriz;
		
	}
	
	public function valida($usuario,$senha){
		
		$sql= "select u.* from usuarios u
                where u.login = '$usuario' and u.senha = '$senha'";
								
		$result = mysqli_query($this->con,$sql);
		$num_rows = mysqli_num_rows($result);
		
		$rs = mysqli_fetch_array($result);
		$usu_logado = $rs['login'];
		$nome_usuario = $rs['nomeUsuario'];
		$idUsuario = $rs['idUsuario'];
		$senhaUsuario = $rs['senha'];
		$admin = $rs['admin'];
		$is_active = $rs['is_active'];
		
		$_SESSION['usu_logado'] = $usu_logado;
		$_SESSION['nome'] = $nome_usuario;
		$_SESSION['idUsuario'] = $idUsuario;
		$_SESSION['senha'] = $senhaUsuario;
		$_SESSION['admin'] = $admin;
		$_SESSION['is_active'] = $is_active;

				
		if($num_rows!=0){
			return true;
		}else{
			return false;			
		}
	}	

	public function trocaSenha($login,$senha){
		
		$sql="update usuarios set senha = '$senha' where login = '$login'";
		
		if(mysqli_query($this->con,$sql)){
			$_SESSION['senha'] = $senha;
			return true;
		}else{
			return false;			
		}		
		

	}
	
	
	
	
	
	
	
	
}
?>
