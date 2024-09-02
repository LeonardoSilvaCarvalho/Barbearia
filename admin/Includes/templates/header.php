<?php
include 'connect.php';

// Obtém a URL atual
$current_url = $_SERVER['REQUEST_URI'];

// Verifica se a URL atual corresponde à página de agendamentos
$is_schedule_page = strpos($current_url, 'index.php') !== false;

// Verifica se a URL atual corresponde à página de categorias de serviços
$is_service_categories_page = strpos($current_url, 'service-categories.php') !== false;

// Verifica se a URL atual corresponde à página de serviços
$is_services_page = strpos($current_url, 'services.php') !== false;

// Verifica se a URL atual corresponde à página de clientes
$is_clients_page = strpos($current_url, 'clients.php') !== false;

// Verifica se a URL atual corresponde à página de funcionários
$is_employees_page = strpos($current_url, 'employees.php') !== false;

// Verifica se a URL atual corresponde à página de agenda de funcionários
$is_employees_schedule_page = strpos($current_url, 'employees-schedule.php') !== false;

// Verifica se a URL atual corresponde à página de agenda de relatorio financeiro
$is_relatorio_financeiro = strpos($current_url, 'relatorio_financeiro.php') !== false;

$sql = "SELECT full_name FROM barber_admin";
$stmt = $con->prepare($sql);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
$full_name = $resultado['full_name'];

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Barbearia Tchelos">

	<title><?php echo $pageTitle ?></title>

    <!-- ARQUIVO DE FONTES -->
	<link href="Design/fonts/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="Includes/templates/favicon-32x32.png" type="image/x-icon">
    <!-- ARQUIVO DE FAMÍLIA DE FONTE Nunito -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- ARQUIVOS CSS -->
	<link href="Design/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="Design/css/main.css" rel="stylesheet">

    <!-- Ícones de barbeiro -->
	<link rel="stylesheet" type="text/css" href="Design/fonts/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="Design/css/barber-icons.css">


    <!--  Jquery  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body id="page-top">

    <!-- Wrapper da página -->
	<div id="wrapper">

        <!-- Barra lateral -->
		<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Barra lateral - Marca -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
				<div class="sidebar-brand-icon rotate-n-10">
                    <strong style="font-size: 20px; color: #000; font-style: italic">Barbearia</strong>
                    <span style="font-family: 'Pacifico', cursive; font-style: italic ">Tchelo's</span>
				</div>
			</a>

            <!-- Divisor -->
			<hr class="sidebar-divider">


            <!-- Título -->
            <div class="sidebar-heading">
                Lista de agendamentos
            </div>

            <!-- Item de navegação - Painel -->
			<li class="nav-item" <?php echo $is_schedule_page ? 'active' : 'active'; ?>">
				<a class="nav-link" href="index.php">
                    <i class="fas fa-calendar-alt"></i>
					<span>Andamentos</span>
				</a>
			</li>

            <!-- Divisor -->
			<hr class="sidebar-divider">

            <!-- Título -->
			<div class="sidebar-heading">
                Gerenciar serviços
			</div>

            <!-- Item de navegação - Menu de recolhimento de páginas -->
            <li class="nav-item <?php echo $is_service_categories_page ? 'active' : ''; ?>">
				<a class="nav-link" href="service-categories.php">
					<i class="fas fa-list"></i>
					<span>Categorias de serviços</span>
				</a>
			</li>
            <li class="nav-item <?php echo $is_services_page ? 'active' : ''; ?>">
				<a class="nav-link" href="services.php">
					<i class="bs bs-scissors-1"></i>
					<span>Serviços</span>
				</a>
			</li>
            <!-- Divisor -->
			<hr class="sidebar-divider">

            <!-- Título -->
			<div class="sidebar-heading">
                Clientes e funcionários
			</div>

            <!-- Item de navegação - Gráficos -->
            <li class="nav-item <?php echo $is_clients_page ? 'active' : ''; ?>">
				<a class="nav-link" href="clients.php">
					<i class="far fa-address-card"></i>
					<span>Clientes</span>
				</a>
			</li>
            <li class="nav-item <?php echo $is_employees_page ? 'active' : ''; ?>">
				<a class="nav-link" href="employees.php">
					<i class="far fa-user"></i>
					<span>Funcionarios</span>
				</a>
			</li>
            <li class="nav-item <?php echo $is_employees_schedule_page ? 'active' : ''; ?>">
				<a class="nav-link" href="employees-schedule.php">
					<i class="fas fa-calendar-week icon-ver"></i>
					<span>Agenda de funcionários</span>
				</a>
			</li>

            <!-- Divisor -->
			<hr class="sidebar-divider d-none d-md-block">

            <!-- Título -->
            <div class="sidebar-heading">
                Financeiro
            </div>

            <!-- Item de navegação - Gráficos -->
            <li class="nav-item <?php echo $is_relatorio_financeiro ? 'active' : ''; ?>">
                <a class="nav-link" href="relatorio_financeiro.php">
                    <i class="far fa-address-card"></i>
                    <span>Relatorio</span>
                </a>
            </li>

            <!-- Divisor -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Alternador da barra lateral (barra lateral) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>
		</ul>

        <!-- Fim da barra lateral -->

        <!-- Wrapper de conteúdo -->
		<div id="content-wrapper" class="d-flex flex-column">

            <!-- Conteúdo principal -->
			<div id="content">

                <!-- Barra superior -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Alternar barra lateral (barra superior) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

                    <!-- Barra superior Barra de navegação -->
					<ul class="navbar-nav ml-auto">
						<li class="nav-item">
							<a class="nav-link" href="../" target="_blank">
								<i class="far fa-eye" style="color: #0f0cc1;"></i>
								<span style="margin-left: 5px; color: #0f0cc1;">Ver site</span>
							</a>
						</li>
						<div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Item de navegação - Informações do usuário -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small" style="color: #000!important; font-size: 16px; font-weight: bold;">
									<?php
                                    echo $full_name;
//                                    echo $_SESSION['username_barbershop_Xw211qAAsq4'];
                                    ?>
								</span>
								<i class="fas fa-caret-down" style="color: #000"></i>
							</a>

                            <!-- Menu suspenso - Informações do usuário -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" style="font-size: 14px; color: #000;">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" style="color: red!important; font-size: 14px"></i>
                                    Deslogar
								</a>
							</div>
						</li>
					</ul>
				</nav>
                <!-- Fim da barra superior -->