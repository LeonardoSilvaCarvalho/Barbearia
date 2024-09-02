<?php
session_start();

// SE O USUÁRIO JÁ ESTIVER LOGADO
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
	header('Location: index.php');
	exit();
}
// OUTRO
$pageTitle = 'Barbearia Tchelos';
include 'connect.php';
include 'Includes/functions/functions.php';


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Painel Administrativo</title>
    <!-- ARQUIVO DE FONTES -->
	<link href="Design/fonts/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- ARQUIVO DE FAMÍLIA DE FONTE Nunito -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- ARQUIVOS CSS -->
	<link href="Design/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="Design/css/main.css" rel="stylesheet">
</head>

<body style="background: #ddd">
	<div class="login">
		<form class="login-container validate-form" name="login-form" method="POST" action="login.php" onsubmit="return validateLogInForm()">
			<span class="login100-form-title p-b-32">
				<b>
                    Login
                    <br>
                Painel Administrativo
                </b>
			</span>

            <!-- PHP SCRIPT AO ENVIAR -->

			<?php

			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin-button'])) {
				$username = test_input($_POST['username']);
				$password = test_input($_POST['password']);
				$hashedPass = sha1($password);

                //Verifica se o usuário existe no banco de dados

				$stmt = $con->prepare("Select admin_id, username,password from barber_admin where username = ? and password = ?");
				$stmt->execute(array($username, $hashedPass));
				$row = $stmt->fetch();
				$count = $stmt->rowCount();

                // Verifica se count > 0 o que significa que o banco de dados contém um registro sobre este nome de usuário

				if ($count > 0) {

					$_SESSION['username_barbershop_Xw211qAAsq4'] = $username;
					$_SESSION['password_barbershop_Xw211qAAsq4'] = $password;
					$_SESSION['admin_id_barbershop_Xw211qAAsq4'] = $row['admin_id'];
					header('Location: index.php');
					die();
				} else {
			?>

					<div class="alert alert-danger">
						<button data-dismiss="alert" class="close close-sm" type="button">
							<span aria-hidden="true">×</span>
						</button>
						<div class="messages">
							<div>O nome do usuário e/ou a senha estão incorretos!</div>
						</div>
					</div>

			<?php
				}
			}

			?>

            <!-- ENTRADA DE NOME DE USUÁRIO -->

			<div class="form-input">
				<span class="txt1">Usuario:</span>
				<input type="text" name="username" class="form-control" oninput="getElementById('required_username').style.display = 'none'" autocomplete="off">
				<span class="invalid-feedback" id="required_username">Você precisa do nome do usuário!</span>
			</div>

            <!-- ENTRADA DE SENHA -->

			<div class="form-input">
				<span class="txt1">Senha:</span>
				<input type="password" name="password" class="form-control" oninput="getElementById('required_password').style.display = 'none'" autocomplete="new-password">
				<span class="invalid-feedback" id="required_password">Você precisa de uma senha!</span>
			</div>

            <!-- BOTÃO ENTRAR -->

			<p>
				<button type="submit" name="signin-button">Entrar</button>
			</p>


		</form>
	</div>

    <!-- Rodapé -->
	<footer class="sticky-footer">
		<div class="container my-auto">
			<div class="copyright text-center my-auto">
                <p style="color: #000; font-size: 18px; margin-top: -30px">Todos os direitos reservador &copy; - Leonardo Carvalho - 2024</p>
			</div>
		</div>
	</footer>
    <!-- Fim do rodapé -->

    <!-- INCLUIR SCRIPTS JS -->
	<script src="Design/js/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="Design/js/bootstrap.bundle.min.js"></script>
	<script src="Design/js/sb-admin-2.min.js"></script>
	<script src="Design/js/main.js"></script>
</body>

</html>