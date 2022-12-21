<?php 
	require_once("header.php");

	if(!isset($_GET['identifier']) || !isset($_GET['id'])){
		echo 'Ocorreu um problema no acesso a esta eleição, ou ela não está mais ativa!';
		require_once("footer.php");
		die();
	}else{
		$identifier = $_GET['identifier'];
		$id = $_GET['id'];		
	}
	
	$dadosEleicaoParaVotar = $eleicoes->detalhesVotacaoAberto($identifier,$id);
	$jaVotou = $eleicoes->jaVotou($_GET['id'],$_SESSION['idUsuario']);
	
	if($jaVotou){
		header("Location: index");
	}
	
	if(empty($dadosEleicaoParaVotar)){
		echo 'Ocorreu um problema no acesso a esta eleição, ou ela não está mais ativa!';
		require_once("footer.php");
		die();
	}else{
		if($dadosEleicaoParaVotar[0]['ativo'] != 1){
			require_once("footer.php");
			die('A Eleição não está ativa');	
		}
	}
	
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
					
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-center text-primary">TELA DE VOTAÇÃO</h6>
							</div>
							<div class="card-body">
								<div class="card-deck" >
									<?php
										if(!empty($dadosEleicaoParaVotar)){
											foreach($dadosEleicaoParaVotar as $rs){
												echo '
													<div class="card" role="button" onclick="votar(\''.$rs['nomeChapa'].'\',\''.$rs['idChapa'].'\')" >
														<div class="card-body">
															<h5 class="card-title text-primary text-center">'.$rs['nomeChapa'].'</h5>
															<p class="card-text  text-center">'.$rs['descricaoChapa'].'</p>
														</div>
														<div class="card-footer">
															<small class="text-muted"></small>
														</div>
													</div>												
												';
											}
										}
									
									?><!--
									<div class="card" role="button" onclick="votar(' EM BRANCO')" >
										<div class="card-body">
											<h5 class="card-title text-primary text-center">VOTAR EM BRANCO</h5>
											<p class="card-text  text-center">Declaro que voto EM BRANCO</p>
										</div>
										<div class="card-footer">
											<small class="text-muted"></small>
										</div>
									</div>
									<div class="card" role="button" >
										<div class="card-body">
											<h5 class="card-title text-primary text-center">VOTAR NULLO</h5>
											<p class="card-text  text-center">Declaro que voto NULLO</p>
										</div>
										<div class="card-footer">
											<small class="text-muted"></small>
										</div>
									</div>-->
								</div>
								<hr>
							</div>
							<div class="card-footer py-3  " >
								<small class="text-muted">ATENÇÃO, SÓ É PERMITIDO VOTAR APENAS 1 VEZ.</small>
							</div>
						</div>
					
				</div>
			</div>
		</div>
        		
		</div>
		</div>
        <!-- /.container-fluid -->


    </div>
    <!-- End of Content Wrapper -->
<?php 
	require_once("footer.php");
?>
<script>
function votar(nomeChapa,idChapa){
		
	var url_string = window.location.href; 
	var url = new URL(url_string);
	var idEleicao = url.searchParams.get("id");
		
	Swal.fire({
	  title: 'Confirmação de voto',
	  text: "Realmente confirmar o voto na chapa " + nomeChapa,
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sim, votar!',
	  cancelButtonText: 'Cancelar!'
	}).then((result) => {
	  if (result.isConfirmed) {

      $.post("controlaEleicoes.php?operacao=votar", { idChapa: idChapa,idEleicao: idEleicao ,},
        function(data) {
            if (data == '1451') {
                Swal.fire(
                    'ERRO!',
                    'Não foi possível computar seu voto, contate o Administrador do sistema!',
                    'error'
                )
            } else if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Voto computado com Sucesso!',
                    'success'
                )
				setTimeout(function(){ window.location.replace('index');}, 2000);
            } else if (data == '2') {
                Swal.fire(
                    'ERRO',
                    'Já Votou!!',
                    'error'
                )
				setTimeout(function(){ window.location.replace('index');}, 500);
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
</script>
