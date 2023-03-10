<?php 
	require_once("header.php");
	
	$qtdContatos = $integracoes->qtdContatos();
	$ultImportacaoContatos = $integracoes->ultImportacaoContatos();
	$ultPaginaContatos = $integracoes->ultPaginaContatos();
		
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
							<h6 class="m-0 font-weight-bold text-warning">Contatos Extra??dos do Nectar</h6>
						</div>
						<div class="card-body form-inline">
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">CONTATOS</div>
									  <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo number_format($qtdContatos,0,',','.')?></div>
									</div>
									<div class="col-auto">
									  <i class="fa fa-coins fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">??LTIMA IMPORTA????O</div>
									  <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo date("d/m/Y",strtotime($ultImportacaoContatos))?></div>
									</div>
									<div class="col-auto">
									  <i class="fas fa-calendar fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">??LTIMA P??GINA</div>
									  <div class="h6 mb-0 font-weight-bold text-gray-800"><?php echo number_format($ultPaginaContatos,0,',','.')?></div>
									</div>
									<div class="col-auto">
									  <i class="fas fa-calendar fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  <button type="button" onclick="exportaContatos()" class="btn btn-warning btn-sm">Exportar</button>
									</div>
									<div class="col-auto">
									  
									  <i class="fas fa-file-excel fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  
									  <button type="button" onclick="excluiBaseContatos()" class="btn btn-warning btn-sm">Apagar Base</button>
									</div>
									<div class="col-auto">
									  
									  <i class="fas fa-trash fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
							<div class="col-xl-2 col-md-6 mb-4">
							  <div class="card border-left-warning shadow h-100 py-2">
								<div class="card-body">
								  <div class="row no-gutters align-items-center">
									<div class="col mr-2">
									  
									  <button type="button" onclick="atualizaContatos()"  class="btn btn-warning btn-sm">Atualizar</button>
									</div>
									<div class="col-auto">
									  
									  <i class="fas fa-recycle fa-2x text-gray-300"></i>
									</div>
								  </div>
								</div>
							  </div>
							</div>
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
function excluiBaseContatos(){
	Swal.fire({
	  title: 'Deseja realmente excluir a base?',
	  text: "Esta a????o n??o pode ser desfeita!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Sim, delete!',
	  cancelButtonText: 'Cancelar!'
	}).then((result) => {
	  if (result.isConfirmed) {

      $.post("integracaoNectarContatos.php?operacao=excluir",
        function(data) {
            if (data == '0') {
                Swal.fire(
                    'Sucesso',
                    'Base excluida com Sucesso!',
                    'success'
                )
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
