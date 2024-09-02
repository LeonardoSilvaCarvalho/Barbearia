<?php

// Inclui o arquivo de funções que contém a função test_input
include "../functions/functions.php";

// Verifica se os dados do formulário foram recebidos
if(isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_subject']) && isset($_POST['contact_message']))
{

    // Limpa e valida os dados do formulário
    $contact_name = test_input($_POST['contact_name']);
    $contact_email  = test_input($_POST['contact_email']);
    $contact_subject = test_input($_POST['contact_subject']);
    $contact_message = test_input($_POST['contact_message']);

    try
    {
        // Envia o e-mail para o endereço definido
        mail("seuemail@example.com",$contact_subject,$contact_message);
        echo "<div class='alert alert-success'>";
        echo "A mensagem foi enviada com sucesso";
        echo "</div>";
    }
    catch(Exception $ex)
    {
        // Se ocorrer um erro durante o envio do e-mail, exibe uma mensagem de aviso
        echo "<div class='alert alert-warning'>";
        echo "Ocorreu um problema ao tentar enviar a mensagem, por favor, tente novamente!";
        echo "</div>";
    }

}

?>
