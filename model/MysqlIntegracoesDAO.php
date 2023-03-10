<?php
class MysqlIntegracoesDAO{

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
	
	public function insereContatos($retorno, $pagina){
		$sql = "insert into contatos(retorno, dtInsert, pagina) values('$retorno',now(),$pagina)";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}
	
	public function insereOportunidades($retorno, $pagina){
		$sql = "insert into oportunidades(retorno, dtInsert, pagina) values('$retorno',now(),$pagina)";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}
	
	public function insereFeedback($retorno, $pagina){
		$sql = "insert into feedback(retorno, dtInsert, pagina) values('$retorno',now(),$pagina)";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}

	public function apagaBaseOportunidades(){
		$sql = "truncate table oportunidades";
		//$sql = "delete from oportunidades where pagina = 1134";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}	
	public function apagaBaseFeedback(){
		$sql = "truncate table feedback";
		//$sql = "delete from feedback where pagina = 1771";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}
	public function apagaBaseContatos(){
		$sql = "truncate table contatos";
		//$sql = "delete from oportunidades where pagina = 1134";
		if(mysqli_query($this->con,$sql)){
			return true;
		}else{
			return false;			
		}	
	}		

	public function qtdContatos(){
        $query = "select count(*) as qtd from contatos";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	public function ultImportacaoContatos(){
        $query = "select max(dtInsert) as maxImp from contatos";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	public function ultPaginaContatos(){
        $query = "select max(pagina) as maxPag from contatos";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	
	public function qtdFeedbacks(){
        $query = "select count(*) as qtd from feedback";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	public function ultImportacaoFeedbacks(){
        $query = "select max(dtInsert) as maxImp from feedback";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	public function ultPaginaFeedbacks(){
        $query = "select max(pagina) as maxPag from feedback";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	
	public function qtdOportunidades(){
        $query = "select count(*) as qtd from oportunidades";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	
	public function ultImportacaoOportunidades(){
        $query = "select max(dtInsert) as maxImp from oportunidades";
        $rs = mysqli_query( $this->con, $query) or mysqli_error();
        $tupla = mysqli_fetch_array($rs);
		return $tupla[0];
	}
	public function ultPaginaOportunidades(){
        $query = "select max(pagina) as maxPag from oportunidades";
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
	
	
	
	public function buscaContatos(){
		$query = 'SELECT 
					json_extract(retorno, "$.responsavel.id") as responsavelId,
					json_extract(retorno, "$.responsavel.nome") as responsavelNome,
					json_extract(retorno, "$.nome") as nome,
					json_extract(retorno, "$.razaoSocial") as razaoSocial,
					json_extract(retorno, "$.cnpj") as cnpj,
					json_extract(retorno, "$.dataCriacao") as dataCriacao,
					json_extract(retorno, "$.observacao") as observacao,
					json_extract(retorno, "$.origem") as origem,
					json_extract(retorno, "$.ativo") as ativo,
					json_extract(retorno, "$.empresa") as empresa,
					COALESCE(json_extract(retorno, "$.telefone"),json_extract(retorno, "$.telefonePrincipal")) as clienteTelefone,
					COALESCE(json_extract(retorno, "$.email"),json_extract(retorno, "$.emailPrincipal")) as clienteEmail
					FROM contatos;';
					
		$rs = mysqli_query($this->con, $query) or mysqli_error();
		$i = 0;
		$matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			$matriz[$i]['responsavelId'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['responsavelId'])));
			$matriz[$i]['responsavelNome'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['responsavelNome'])));
			$matriz[$i]['nome'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['nome'])));
			$matriz[$i]['razaoSocial'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['razaoSocial'])));
			$matriz[$i]['cnpj'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['cnpj'])));
			$matriz[$i]['dataCriacao'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['dataCriacao'])));
			$matriz[$i]['observacao'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['observacao'])));
			$matriz[$i]['origem'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['origem'])));
			$matriz[$i]['ativo'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['ativo'])));
			$matriz[$i]['empresa'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['empresa'])));
			$matriz[$i]['clienteTelefone'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['clienteTelefone'])));
			$matriz[$i]['clienteEmail'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['clienteEmail'])));
			$i++;
		}
		return $matriz;
	}
	
	public function buscaFeedbacks(){
		$query = 'SELECT 
					json_extract(retorno, "$.id") as idFeedback, 
					json_extract(retorno, "$.autor.id") as autorId,
					json_extract(retorno, "$.autor.nome") as autorNome,
					json_extract(retorno, "$.dataCriacao") as dataCriacao,
					json_extract(retorno, "$.dataAtualizacao") as dataAtualizacao,
					json_extract(retorno, "$.qtdeComentarios") as qtdeComentarios,
					json_extract(retorno, "$.oportunidade.id") as idOportunidade,
					json_extract(retorno, "$.oportunidade.cliente.id") as idClienteOportunidade,
					json_extract(retorno, "$.assunto") as assunto,
					json_extract(retorno, "$.descricao") as descricao
					FROM feedback';
					
		$rs = mysqli_query($this->con, $query) or mysqli_error();
		$i = 0;
		$matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			$matriz[$i]['idFeedback'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['idFeedback'])));
			$matriz[$i]['autorId'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['autorId'])));
			$matriz[$i]['autorNome'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['autorNome'])));
			$matriz[$i]['dataCriacao'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['dataCriacao'])));
			$matriz[$i]['dataAtualizacao'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['dataAtualizacao'])));
			$matriz[$i]['qtdeComentarios'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['qtdeComentarios'])));
			$matriz[$i]['idOportunidade'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['idOportunidade'])));
			$matriz[$i]['idClienteOportunidade'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['idClienteOportunidade'])));
			$matriz[$i]['assunto'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['assunto'])));
			$matriz[$i]['descricao'] = str_replace('"','',utf8_decode(Utf8_ansi($tupla['descricao'])));
			$i++;
		}
		return $matriz;
	}	
	
	public function buscaOportunidades(){
		
		$query = 'SELECT 
					json_extract(retorno, "$.id") as idOportunidade, 
					json_extract(retorno, "$.responsavel.id") as responsavelId,
					json_extract(retorno, "$.responsavel.nome") as responsavelNome,
					json_extract(retorno, "$.autor.id") as autorId,
					json_extract(retorno, "$.autor.nome") as autorNome,
					json_extract(retorno, "$.nome") as nomeOportunidade,
					json_extract(retorno, "$.cliente.id") as clienteId,
					json_extract(retorno, "$.cliente.cnpj") as clienteCnpj,
					json_extract(retorno, "$.cliente.nome") as clienteNome,
					COALESCE(json_extract(retorno, "$.cliente.telefone"),json_extract(retorno, "$.cliente.telefonePrincipal")) as clienteTelefone,
					COALESCE(json_extract(retorno, "$.cliente.email"),json_extract(retorno, "$.cliente.email")) as clienteEmail,
					json_extract(retorno, "$.codigo") as oportunidadeCodigo,
					json_extract(retorno, "$.status") as oportunidadeStatus,
					json_extract(retorno, "$.dataCriacao") as oportunidadeDataCriacao,
					json_extract(retorno, "$.pipeline") as oportunidadeFunil,
					json_extract(retorno, "$.funilVenda.id") as funilId,
					json_extract(retorno, "$.funilVenda.nome") as funilNome,
					json_extract(retorno, "$.etapa") as etapaId,
					json_extract(retorno, "$.etapaAtual.nome") as etapaNome,
					json_extract(retorno, "$.etapaAtual.descricao") as etapaDescricao,
					json_extract(retorno, "$.observacao") as observa????o,
					json_extract(retorno, "$.valorTotal") as valorTotal
					FROM oportunidades';
		
		$rs = mysqli_query($this->con, $query) or mysqli_error();
		$i = 0;
		$matriz = null;
		while($tupla = mysqli_fetch_assoc($rs)){
			$matriz[$i]['idOportunidade'] = $tupla['idOportunidade'];
			$matriz[$i]['responsavelId'] = $tupla['responsavelId'];
			$matriz[$i]['responsavelNome'] = $tupla['responsavelNome'];
			$matriz[$i]['autorId'] = $tupla['autorId'];
			$matriz[$i]['autorNome'] = $tupla['autorNome'];
			$matriz[$i]['nomeOportunidade'] = $tupla['nomeOportunidade'];
			$matriz[$i]['clienteId'] = $tupla['clienteId'];
			$matriz[$i]['clienteCnpj'] = $tupla['clienteCnpj'];
			$matriz[$i]['clienteNome'] = $tupla['clienteNome'];
			$matriz[$i]['clienteTelefone'] = $tupla['clienteTelefone'];
			$matriz[$i]['clienteEmail'] = $tupla['clienteEmail'];
			$matriz[$i]['oportunidadeCodigo'] = $tupla['oportunidadeCodigo'];
			$matriz[$i]['oportunidadeStatus'] = $tupla['oportunidadeStatus'];
			$matriz[$i]['oportunidadeDataCriacao'] = $tupla['oportunidadeDataCriacao'];
			$matriz[$i]['oportunidadeFunil'] = $tupla['oportunidadeFunil'];
			$matriz[$i]['funilId'] = $tupla['funilId'];
			$matriz[$i]['funilNome'] = $tupla['funilNome'];
			$matriz[$i]['etapaId'] = $tupla['etapaId'];
			$matriz[$i]['etapaNome'] = $tupla['etapaNome'];
			$matriz[$i]['etapaDescricao'] = $tupla['etapaDescricao'];
			$matriz[$i]['observa????o'] = $tupla['observa????o'];
			$matriz[$i]['valorTotal'] = $tupla['valorTotal'];
			
			$i++;
			
		}
		
		return $matriz;
		
	}	
}

function Utf8_ansi($valor='') {

    $utf8_ansi2 = array(
    "\u00c0" =>"??",
    "\u00c1" =>"??",
    "\u00c2" =>"??",
    "\u00c3" =>"??",
    "\u00c4" =>"??",
    "\u00c5" =>"??",
    "\u00c6" =>"??",
    "\u00c7" =>"??",
    "\u00c8" =>"??",
    "\u00c9" =>"??",
    "\u00ca" =>"??",
    "\u00cb" =>"??",
    "\u00cc" =>"??",
    "\u00cd" =>"??",
    "\u00ce" =>"??",
    "\u00cf" =>"??",
    "\u00d1" =>"??",
    "\u00d2" =>"??",
    "\u00d3" =>"??",
    "\u00d4" =>"??",
    "\u00d5" =>"??",
    "\u00d6" =>"??",
    "\u00d8" =>"??",
    "\u00d9" =>"??",
    "\u00da" =>"??",
    "\u00db" =>"??",
    "\u00dc" =>"??",
    "\u00dd" =>"??",
    "\u00df" =>"??",
    "\u00e0" =>"??",
    "\u00e1" =>"??",
    "\u00e2" =>"??",
    "\u00e3" =>"??",
    "\u00e4" =>"??",
    "\u00e5" =>"??",
    "\u00e6" =>"??",
    "\u00e7" =>"??",
    "\u00e8" =>"??",
    "\u00e9" =>"??",
    "\u00ea" =>"??",
    "\u00eb" =>"??",
    "\u00ec" =>"??",
    "\u00ed" =>"??",
    "\u00ee" =>"??",
    "\u00ef" =>"??",
    "\u00f0" =>"??",
    "\u00f1" =>"??",
    "\u00f2" =>"??",
    "\u00f3" =>"??",
    "\u00f4" =>"??",
    "\u00f5" =>"??",
    "\u00f6" =>"??",
    "\u00f8" =>"??",
    "\u00f9" =>"??",
    "\u00fa" =>"??",
    "\u00fb" =>"??",
    "\u00fc" =>"??",
    "\u00fd" =>"??",
    "\u00b" =>"??",
    "\u00ff" =>"??");

    return strtr($valor, $utf8_ansi2);      

}
?>
