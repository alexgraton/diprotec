<?php 
	require_once("header.php");

	
	
	if(empty($_GET['id'])){
		require_once("footer.php");
		die("Volte e selecione uma Eleição para editar.");
	}else{
		$idEleicao = $_GET['id'];
		$detalhesEleicoes = $eleicoes->detalhesEleicoes($idEleicao);
	}
	
	//$todosUF = $ufs->listarTudo();
	
?>


<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<?php include 'sidebar.php' ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
		  
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nomeLogado?></span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
               <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Sair
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
			<div class="row" >
				<div class="col-lg-12">
					<!-- Overflow Hidden -->
					<form method="post" onsubmit="return false" id="dados">
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo $detalhesEleicoes[0]['titulo']?></h6>
							</div>
							<input type="hidden" value="<?php echo $detalhesEleicoes[0]['idEleicao']?>" id="idEleicao" name="idEleicao">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<label for="tituloEleicao" >Título</label>
										<input type="text" name="tituloEleicao" id="tituloEleicao"  value="<?php echo $detalhesEleicoes[0]['titulo']?>" class="form-control" >
									</div>
									<div class="col-lg-3">
										<label for="linkEleicao" >Link</label>
										<input type="text" name="linkEleicao" id="linkEleicao"  value="<?php echo $detalhesEleicoes[0]['link']?>" class="form-control" >
									</div>
		
									<div class="col-lg-2">
										<label for="inicioEleicao" >Inicio</label>
										<input type="datetime-local" data-clear-btn="false"	name="inicioEleicao"  value="<?php echo $detalhesEleicoes[0]['inicio']?>" id="inicioEleicao" class="form-control" value="">
									</div>
									<div class="col-lg-2">
										<label for="fimEleicao" >Fim</label>
										<input type="datetime-local" data-clear-btn="false"	name="fimEleicao"  value="<?php echo $detalhesEleicoes[0]['fim']?>"  id="fimEleicao" class="form-control" value="">
									</div>
									<div class="col-lg-1">
										<label for="ativo" >Ativo</label>
										<select class="form-control" name="ativo" id="ativo">
											<option <?php if($detalhesEleicoes[0]['ativo'] == 0){echo ' selected ';}?> value="0">
												Não
											</option>
											<option <?php if($detalhesEleicoes[0]['ativo'] == 1){echo ' selected ';}?> value="1">
												Sim
											</option>
										</select>
										
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-lg-12" >
										<label for="pauta" >Pauta</label>
										<textarea id="pauta" class="form-control" name="pauta"  rows="4" value=""><?php echo $detalhesEleicoes[0]['pauta']?></textarea>
									</div>
								</div>
							</div>
							<div class="card-footer py-3  " >
								<button class="btn btn-primary float-right" onclick="eleicoes('editarEleicao')" >SALVAR</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			
		
		</div>
        <div class="container-fluid">
			<div class="row" >
				<div class="col-lg-12">
					<!-- Overflow Hidden -->
					<form method="post" onsubmit="return false" id="dadosSetores">
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Chapas Concorrendo</h6>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div id="retorno" ></div>
									</div>
								</div>
							</div>
							<div class="card-footer py-3  " >
								<button class="btn btn-primary float-right" data-toggle="modal"  data-target="#modalChapa" >
									  NOVA CHAPA
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>	
		</div>			
		</div>
		</div>
        <!-- /.container-fluid -->


    </div>
	

    <div class="modal fade" id="modalChapa" tabindex="-1" role="dialog" aria-labelledby="modalChapa" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalChapa">Nova Chapa</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
				<form method="post" onsubmit="return false" id="dadosChapas" >
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							  <label for="nomeChapa">Nome da Chapa</label>
							  <input type="text" autofocus name="nomeChapa" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
							  <label for="descricaoChapa">Descrição</label>
							  <textarea id="descricaoChapa" class="form-control" name="descricaoChapa"  rows="4" value=""></textarea>
							</div>
						</div>
					</div>
				</form>
		  </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" style="cursor:pointer;color:#fff" type="button" data-dismiss="modal">Cancelar</button>
            <a class="btn btn-primary" style="cursor:pointer;color:#fff" onclick="chapas('inserirChapas')" >Salvar</a>
          </div>
        </div>
      </div>
    </div>
	
    <!-- End of Content Wrapper -->
<?php 
	require_once("footer.php");
?>

<script>

$('#cnpj').mask('00.000.000/0000-00');
$('#cep').mask('00.000-000');
$('#telefone').mask('(00) 00000-0000');

function excluiTransportadora(id){
	Swal.fire({
	  title: 'Deseja realmente excluir?',
	  text: "Esta ação não pode ser desfeita!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sim, delete!',
	  cancelButtonText: 'Cancelar!'
	}).then((result) => {
	  if (result.isConfirmed) {

      $.post("controlaTransportadoras.php?operacao=excluir", { id: id, },
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não é possível excluir o registro, esta transportadora já está parametrizada!',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Registro excluido com Sucesso!',
                    'success'
                )
                chamaListarTransportadoras();
            } else {
                Swal.fire(
                    'Retorno',
                    data,
                    'warning'
                )
            }

        });
	  }
	})
}


function buscaCidades(id){
	
	var operacao = 'buscaCidadePorUF';
	loading();
	$.post('controlaCidades.php?operacao='+operacao, {id: id},
	
	function(data) { 			
		$("#retornoCidade").html(data);	
		loading();
	});
	
	
	
}


chamaChapasEleicao();

function chamaChapasEleicao(){


	var url_string = window.location.href; 
	var url = new URL(url_string);
	var idEleicao = url.searchParams.get("id");
	var operacao = 'listarChapas';
	loading();
	$.post('controlaEleicoes.php?operacao='+operacao+'&idEleicao='+idEleicao, 
	
	function(data) { 	
		$("#retorno").html(data);	
		loading();
	});
	
	document.getElementById("dados").reset();
}
	
</script>
