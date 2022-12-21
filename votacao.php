<?php 
	require_once("header.php");
	
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
					
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-center text-primary">ELEIÇÕES ABERTAS</h6>
							</div>
							<div class="card-body">
								<div class="card-deck" id="retornoEleicoes">


								</div>
								<hr>
							</div>
							<div class="card-footer py-3  " >
								
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

function redirVotacao(idEleicao,id){
	window.location.replace('votar?identifier='+idEleicao+'&id='+id);
}

chamaListarEleicoes();

function chamaListarEleicoes(){

	var operacao = 'listarEleicoesAbertas';
	loading();
	$.post('controlaEleicoes.php?operacao='+operacao, 
	
	function(data) { 	
		$("#retornoEleicoes").html(data);	
		loading();
	});
	
}
	
</script>
