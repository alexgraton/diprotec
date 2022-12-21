<?php
    session_start();
	require_once("model/MysqlDAOFactory.class.php");
	
	date_default_timezone_set('America/Sao_Paulo');
	
	//Eleicoes Mysql
	$daoEleicoes = new MysqlDAOFactory();
	$eleicoes = $daoEleicoes->getEleicoesDAO();
	
	$operacao = $_GET['operacao'];
	
	
	if($operacao == "excluiChapa"){
		
		$idChapa = $_POST['idChapa'];

		if($eleicoes->deletaChapa($idChapa)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "votar"){
		
		$idEleicao = $_POST['idEleicao'];
		$idChapa = $_POST['idChapa'];
		$idUsuario = $_SESSION['idUsuario'];

		$login = $_SESSION['login'];
		
		$jaVotou = $eleicoes->jaVotou($idEleicao,$idUsuario);
		
		if($jaVotou){
			echo 2;
			die('Já votou!');	
		}
		
		
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		if($eleicoes->insereVoto($idEleicao,$idChapa,$login,$ip,$idUsuario)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "inserirChapas"){
		
		$idEleicao = $_GET['idEleicao'];
		$nomeChapa = $_POST['nomeChapa'];
		$descricaoChapa = $_POST['descricaoChapa'];
		//$token = geraChaveAleatoria(60);
		
		if($eleicoes->insereChapas($idEleicao,$nomeChapa,$descricaoChapa)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "inserir"){
		
		if(empty($_POST['tituloEleicao'])){
			die("Titulo da eleição é OBRIGATÓRIO!");
		}elseif(empty($_POST['inicioEleicao'])){
			die("Data de início da eleição é OBRIGATÓRIA!");
		}elseif(empty($_POST['fimEleicao'])){
			die("Data de fim da eleição é OBRIGATÓRIA!");
		}elseif(empty($_POST['pauta'])){
			die("Pauta da eleição é OBRIGATÓRIO!");
		}
		
		$tituloEleicao = $_POST['tituloEleicao'];
		$linkEleicao = $_POST['linkEleicao'];
		$inicioEleicao = $_POST['inicioEleicao'];
		$fimEleicao = $_POST['fimEleicao'];
		$pauta = $_POST['pauta'];
		
		$identifier = geraChaveAleatoria(60);
		
		if($eleicoes->insereInfos($tituloEleicao,$linkEleicao,$inicioEleicao,$fimEleicao,$pauta,$identifier)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "listarTudo"){
		
		$todasEleicoes = $eleicoes->listarTudo();
		
		if(!empty($todasEleicoes)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							
							<th class="text-center">TITULO</th>
							<th class="text-center">LINK</th>
							<th class="text-center">INICIO</th>
							<th class="text-center">FIM</th>
							<th class="text-center">ATIVO</th>
							<th class="text-center">DATA CADASTRO</th>
							<th class="text-center"><i class="fas fa-cogs fa-2x"></i></th>
						</thead>
						<tbody>';
			
			foreach($todasEleicoes as $rs){
				
				if($rs['ativo'] == '1'){
					$ativo = 'Sim';
				}else{
					$ativo = 'Não';
				}
				
				$tabela .= '<tr>';
					
					$tabela .= '<td class="text-center">'.$rs['titulo'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['link'].'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['inicio'])).'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['fim'])).'</td>';
					$tabela .= '<td class="text-center">'.$ativo.'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i:s',strtotime($rs['created_at'])).'</td>';
					$tabela .= '<td class="text-center"><a href="detalhesEleicoes?id='.$rs['idEleicao'].'"><i style="cursor:pointer" class="fas fa-pencil-alt"></i></a></td>';
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}
	
	if($operacao == "listarChapas"){
		
		$idEleicao = $_GET['idEleicao'];
		$todasChapas = $eleicoes->listarChapas($idEleicao);		
		
		if(!empty($todasChapas)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<th class="text-center">ID</th>
							<th class="text-center">NOME</th>
							<th class="text-center">DESCRICAO</th>
							<th class="text-center">DATA CADASTRO</th>
							<th class="text-center">EXCLUIR</th>
						</thead>
						<tbody>';
			
			foreach($todasChapas as $rs){
								
				$tabela .= '<tr>';
					$tabela .= '<td class="text-center">'.$rs['idChapa'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['nomeChapa'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['descricaoChapa'].'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i:s',strtotime($rs['created_at'])).'</td>';
					$tabela .= '<td class="text-center"><i onclick="removeChapa('.$rs['idChapa'].')" style="cursor:pointer;color:red" class="fas fa-trash-alt"></i></td>';
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}
	
	if($operacao == "editarEleicao"){
		
		if(empty($_POST['tituloEleicao'])){
			die("Titulo da eleição é OBRIGATÓRIO!");
		}elseif(empty($_POST['inicioEleicao'])){
			die("Data de início da eleição é OBRIGATÓRIA!");
		}elseif(empty($_POST['fimEleicao'])){
			die("Data de fim da eleição é OBRIGATÓRIA!");
		}elseif(empty($_POST['pauta'])){
			die("Pauta da eleição é OBRIGATÓRIO!");
		}elseif(empty($_POST['ativo']) || $_POST['ativo'] == '0'){
			die("Campo Ativo é OBRIGATÓRIO!");
		}
		
		$idEleicao = $_POST['idEleicao'];
		$titulo = $_POST['tituloEleicao'];
		$link = $_POST['linkEleicao'];
		$inicio = $_POST['inicioEleicao'];
		$fim = $_POST['fimEleicao'];
		$pauta = $_POST['pauta'];
		$ativo = $_POST['ativo'];
		
		if($eleicoes->editarEleicao($idEleicao, $titulo, $link, $inicio, $fim, $pauta,$ativo)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	
	if($operacao == "listarEleicoesAbertas"){
		
		$idUsuario = $_SESSION['idUsuario'];
		$todasEleicoes = $eleicoes->listarEleicoesAbertas($idUsuario);		
		
		if(!empty($todasEleicoes)){
		
			$tabela = '';
			
			foreach($todasEleicoes as $rs){
				$tabela .= '<div class="card" role="button" onclick="redirVotacao(\''. $rs["identifier"] .'\',\''. $rs["idEleicao"] .'\')" >
								<!--<img class="card-img-top" src="..." alt="Card image cap">-->
								<div class="card-body">
									<h5 class="card-title text-primary text-center">'.$rs["titulo"].'</h5>
										<p class="card-text  text-center">'.$rs["pauta"].'</p>
								</div>
								<div class="card-footer">
									<small class="text-muted">Encerra em '.date('d/m/Y H:i:s',strtotime($rs['fim'])).'</small>
								</div>
							</div>';
			}	
		}else{
			$tabela = 'Não há nenhuma Eleição aberta no momento!';
		}
		
		echo $tabela;
		
	}	
	
	if($operacao == "mostraResultadoEleicao"){
		
		$idEleicao = $_GET['idEleicao'];
		$todasEleicoes = $eleicoes->resultadoEleicao($idEleicao);

		if(!empty($todasEleicoes)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							
							<th class="text-center">ID CHAPA</th>
							<th class="text-center">NOME CHAPA</th>
							<th class="text-center">ELEIÇÃO</th>
							<th class="text-center">INICIO</th>
							<th class="text-center">FIM</th>
							<th class="text-center">ATIVO</th>
							<th class="text-center">QTD VOTOS</th>
						</thead>
						<tbody>';
			
			foreach($todasEleicoes as $rs){
				
				if($rs['ativo'] == '1'){
					$ativo = 'Sim';
				}else{
					$ativo = 'Não';
				}
				
				$tabela .= '<tr>';
					
					$tabela .= '<td class="text-center">'.$rs['idChapa'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['nomeChapa'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['titulo'].'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['inicio'])).'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['fim'])).'</td>';
					$tabela .= '<td class="text-center">'.$ativo.'</td>';
					$tabela .= '<td class="text-center">'.number_format($rs['qtdVotos'],0,',','.').'</td>';
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}

	if($operacao == "listaEleicoesFinalizadas"){
		
		$todasEleicoes = $eleicoes->listaEleicoesFinalizadas();
		
		if(!empty($todasEleicoes)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							
							<th class="text-center">TITULO</th>
							<th class="text-center">LINK</th>
							<th class="text-center">INICIO</th>
							<th class="text-center">FIM</th>
							<th class="text-center">ATIVO</th>
							<th class="text-center">DATA CADASTRO</th>
							<th class="text-center">QTD VOTOS</th>
							<th class="text-center">VER</th>
						</thead>
						<tbody>';
			
			foreach($todasEleicoes as $rs){
				
				if($rs['ativo'] == '1'){
					$ativo = 'Sim';
				}else{
					$ativo = 'Não';
				}
				
				$tabela .= '<tr>';
					
					$tabela .= '<td class="text-center">'.$rs['titulo'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['link'].'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['inicio'])).'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i',strtotime($rs['fim'])).'</td>';
					$tabela .= '<td class="text-center">'.$ativo.'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i:s',strtotime($rs['created_at'])).'</td>';
					$tabela .= '<td class="text-center">'.number_format($rs['qtdVotos'],0,',','.').'</td>';
					$tabela .= '<td class="text-center"><a href="resultadoEleicoes?id='.$rs['idEleicao'].'"><i style="cursor:pointer" class="fas fa-search"></i></a></td>';
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}


	
	
//SEM USO
	if($operacao == "vincularEmpTransp"){
				
		$idEmpresa = $_POST['idEmpresa'];
		$idTransportadora = $_POST['transportadoras'];
		
		$erro = 0;
		
		foreach($idTransportadora as $rs){
			
			$ultID = $empresas->vincularEmpTransp($idEmpresa, $rs);
			
			//TENTA INSERIR O ID NA TABELA DE VINCULO
			if($ultID != false){
				//SE DEU BOA INSERIR, CRIO O REGISTRO NA TABELA DE DETALHES TRANSPORTADORAS
				if(!$empresas->criaRegistroDetalhesTranspEmpresa($ultID)){
					$erro++;
				}				
			}else{
				$erro++;
			}
		}
		echo $erro;
	}
	
	if($operacao == "ativaVinculoTransportadora"){
					
		$id = $_POST['id'];
		
		if($empresas->ativaVinculoTransportadora($id)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "desativaVinculoTransportadora"){
					
		$id = $_POST['id'];
		
		if($empresas->desativaVinculoTransportadora($id)){
			echo 0;
		}else{
			echo 1;
		}
	}
	
	if($operacao == "atualizar"){
				
		
		$id = $_POST['id'];
		$nomeEmpresa = $_POST['nomeEmpresa'];
		$email = $_POST['email'];
		$cnpj = $_POST['cnpj'];
		$url = $_POST['url'];
		$cep = $_POST['cep'];
		$endereco = $_POST['endereco'];
		$numero = $_POST['numero'];
		$bairro = $_POST['bairro'];
		$cidade = $_POST['cidade'];
		$uf = $_POST['uf'];
		
		if($empresas->updateEmpresa($id,$nomeEmpresa,$email,$cnpj,$url,$cep,$endereco,$numero,$bairro,$cidade,$uf)){
			echo 0;
		}else{
			echo 1;
		}
	}

	if($operacao == "atualizaDadosTransportadoraEmpresaTaxas"){
				
		$id = $_POST['idTransp'];
		$tas = str_replace(',','.',str_replace('','.',$_POST['tas']));
		$seguroAmbiental = str_replace(',','.',str_replace('','.',$_POST['seguroAmbiental']));
		$paletizacao = str_replace(',','.',str_replace('','.',$_POST['paletizacao']));
		$taxaAgendaEntrega = str_replace(',','.',str_replace('','.',$_POST['taxaAgendaEntrega']));
		$taxaPermanenciaCargas = str_replace(',','.',str_replace('','.',$_POST['taxaPermanenciaCargas']));
		$trc = str_replace(',','.',str_replace('','.',$_POST['trc']));
		$tad = str_replace(',','.',str_replace('','.',$_POST['tad']));
		$pedagio = str_replace(',','.',str_replace('','.',$_POST['pedagio']));
		$fracaoPorKg = str_replace(',','.',str_replace('','.',$_POST['fracaoPorKg']));
		$valorMinPedagio = str_replace(',','.',str_replace('','.',$_POST['valorMinPedagio']));
		$grisPerc = str_replace(',','.',str_replace('','.',$_POST['grisPerc']));
		$valorMinGris = str_replace(',','.',str_replace('','.',$_POST['valorMinGris']));
		
		if($empresas->updateDadosGeraisTransEmpresaTaxas($id,$tas,$seguroAmbiental,$paletizacao,$taxaAgendaEntrega,$taxaPermanenciaCargas,$trc,$tad,$pedagio,$fracaoPorKg,$valorMinPedagio,$grisPerc,$valorMinGris)){
			echo 0;
		}else{
			echo 1;
		}
	}

	if($operacao == "atualizaDadosTransportadoraEmpresaGeral"){
				
		$id = $_POST['idTransp'];
		$codSistema = $_POST['codSistema'];
		$metodoEnvio = $_POST['metodoEnvio'];
		//$diasAdicionais = $_POST['diasAdicionais'];
		//$percAdicional =  str_replace(',','.',str_replace('','.',$_POST['percAdicional']));
		$somaDimensoes = str_replace(',','.',str_replace('.','',$_POST['somaDimensoes']));
		$maiorAresta = str_replace(',','.',str_replace('.','',$_POST['maiorAresta']));
		$fatorPesoCubico = str_replace(',','.',str_replace('.','',$_POST['fatorPesoCubico']));
		$fatorPesoMinimo = str_replace(',','.',str_replace('.','',$_POST['fatorPesoMinimo']));
		$minimoItens = str_replace(',','.',str_replace('.','',$_POST['minimoItens']));
		$valorMinimo = str_replace(',','.',str_replace('.','',$_POST['valorMinimo']));
		$valorMaximo = str_replace(',','.',str_replace('.','',$_POST['valorMaximo']));
		$pesoMaximo = str_replace(',','.',str_replace('.','',$_POST['pesoMaximo']));

		
		if($empresas->updateDadosGeraisTransEmpresa($id,$codSistema,$metodoEnvio,$somaDimensoes,$maiorAresta,$fatorPesoCubico,$fatorPesoMinimo,$minimoItens,$valorMinimo,$valorMaximo,$pesoMaximo)){
			echo 0;
		}else{
			echo 1;
		}
	}

	
	
	if($operacao == "atualizarDadosGerais"){
				
		
		$id = $_POST['id'];
		$aliquota_global = $_POST['aliquota_global'];
		$prazo_adicional = $_POST['prazo_adicional'];
		
		if($empresas->updateEmpresaDadosGerais($id,$aliquota_global,$prazo_adicional)){
			echo 0;
		}else{
			echo 1;
		}
	}
	


	if($operacao == "listaTransportadorasDisponiveis"){
		
		$idEmpresa = $_POST['id'];
		$idCliente = $_SESSION['idCliente'];
		
		$transpDisp = $empresas->listaTransportadorasDisponiveis($idEmpresa,$idCliente);		
		if(!empty($transpDisp)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<th class="text-center">Transportadora</th>
							<th class="text-center">CNPJ</th>
							<!--<th class="text-center">Endereço</th>-->
							<th class="text-center">Cidade</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Vincular</th>
						</thead>
						<tbody>';
			
			foreach($transpDisp as $rs){
								
				$tabela .= '<tr>';
					$tabela .= '<td class="text-center">'.$rs['nomeTransportadora'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['cnpj'].'</td>';
//					$tabela .= '<td class="text-center">'.$rs['endereco'].', '.$rs['numero'].' - '.$rs['bairro'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['cidade'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['estado'].'</td>';
					$tabela .= '<td class="text-center"><input class="form-check-input" type="checkbox" name="transportadoras[]" id="'.$rs['idTransportadora'].'" value="'.$rs['idTransportadora'].'" /></td>';
					
					
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}
	
	if($operacao == "listaTransportadorasVinculadas"){
		
		$idEmpresa = $_POST['id'];
		
		$todasEmpresas = $empresas->listaTransportadorasVinculadas($idEmpresa);		
		if(!empty($todasEmpresas)){
		
			$tabela = '<div class="table-responsive">
						<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<th class="text-center">Transportadora</th>
							<th class="text-center">CNPJ</th>
							<th class="text-center">Ativo</th>
							<th class="text-center">Endereço</th>
							<th class="text-center">Cidade</th>
							<th class="text-center">Estado</th>
							<th class="text-center">Data Vinculação</th>
							<th colspan="2" class="text-center">AÇÃO</th>
						</thead>
						<tbody>';
			
			foreach($todasEmpresas as $rs){
				
				if($rs['ativo'] == '1'){
					$ativo = 'Sim';
					$funcao = 'desativaVinculoTransportadora('.$rs['id'].')';
					$icone = 'fa fa-times';
					$cor = 'red';
				}else{
					$ativo = 'Não';
					$funcao = 'ativaVinculoTransportadora('.$rs['id'].')';
					$icone = 'fa fa-check';
					$cor = 'green';
				}
				
				$tabela .= '<tr>';
					$tabela .= '<td class="text-center">'.$rs['nomeTransportadora'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['cnpj'].'</td>';
					$tabela .= '<td class="text-center">'.$ativo.'</td>';
					$tabela .= '<td class="text-center">'.$rs['endereco'].', '.$rs['numero'].' - '.$rs['bairro'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['cidade'].'</td>';
					$tabela .= '<td class="text-center">'.$rs['estado'].'</td>';
					$tabela .= '<td class="text-center">'.date('d/m/Y H:i:s',strtotime($rs['dtCriacao'])).'</td>';
					$tabela .= '<td class="text-center"><i class="'.$icone.'" aria-hidden="true" style="color:'.$cor.';cursor:pointer" onclick="'.$funcao.'"></td>';
					$tabela .= '<td class="text-center"><a href="detalhesVinculosTransportadoras?id='.$rs['id'].'"><i class="far fa-edit" aria-hidden="true" style="color:blue;cursor:pointer"></a></td>';
				$tabela .= '</tr>';
			}	
			
			$tabela .='</tbody>
				</table>
				</div>';
		}else{
			$tabela = 'Não há dados para listar!';
		}
		
		echo $tabela;
		
	}
	
	
	if($operacao == "editar"){
		
		$idAluno = $_POST['idAluno'];
		$nomeAluno = $_POST['nomeAluno'];
		$cpf = $_POST['cpf'];
		$telefone = $_POST['telefone'];
		$email = $_POST['email'];
		$dataNasc = $_POST['dataNasc'];
		if(trim($dataNasc) != ""){
			$dataNasc = date('Y-m-d',strtotime($dataNasc));
		}
		$rua = $_POST['rua'];
		$num = $_POST['num'];
		$bairro = $_POST['bairro'];
		$cep = $_POST['cep'];
		$cidade = $_POST['cidade'];
		$uf = $_POST['uf'];
		$genero = $_POST['genero'];
		$stakeholder = $_POST['stakeholder'];
		$empresa = $_POST['empresa'];
		$areaAtuacao = $_POST['areaAtuacao'];
		$complemento = $_POST['complemento'];
		
		if($alunos->editaInfo($idAluno, $nomeAluno, $cpf, $telefone, $email, $dataNasc, $rua, $num, $bairro, $cep, $cidade, $uf, $genero, $stakeholder, $empresa, $areaAtuacao,$complemento)){
			echo 0;
		}else{
			echo 1;
		}
	}

	
	if($operacao == "excluir"){
		$id = $_POST['id'];
		
		$retorno = $empresas->excluiInfo($id);
		
		if($retorno){
			echo '0';
		}else{
			echo $retorno;
		} 
	}


	if($operacao == 'enviafotoEmpresa'){

		$nome = geraChaveAleatoria (30);
		$id = $_GET['id'];
	
		if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
		else {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			//$novoNome = $nome.'.'.$ext;
			move_uploaded_file($_FILES['file']['tmp_name'], 'img/'.$nome.'.'.$ext);
			
			$empresas->mudaCaminhoLogo($id,$nome.'.'.$ext);
			echo 'img/'.$nome.'.'.$ext;
		}
		
		//$_FILES['file']['name']
	}


		
		
function geraChaveAleatoria ($len_of_gen_str){
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$var_size = strlen($chars);
	$retorno = '';
	//echo "Random string ="; 
	for( $x = 0; $x < $len_of_gen_str; $x++ ) {  
		$random_str= $chars[ rand( 0, $var_size - 1 ) ];  
		$retorno .= $random_str;  
	}
	return $retorno;
}
	
?>