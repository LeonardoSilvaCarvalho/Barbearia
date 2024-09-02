<?php
    //Iniciar sessão
	session_start();
    //Desativa variáveis da sessão
	session_unset();
    //Destruir Sessão
	session_destroy();
	header('Location: login.php');
	exit();
?>