<?php

session_start();

// Título da página
$pageTitle = 'Clientes';

// Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['username_barbershop_Xw211qAAsq4'])
    && isset($_SESSION['password_barbershop_Xw211qAAsq4'])
) {
    ?>
    <!-- Conteúdo da página inicial -->
    <div class="container-fluid">

        <!-- Cabeçalho da página -->

        <!-- Tabela de Clientes -->
        <?php
        // Definindo a quantidade de registros por página
        $registros_por_pagina = isset($_GET['per_page']) && $_GET['per_page'] ? $_GET['per_page'] : 10;

        // Verifica se foi passado o parâmetro de página na URL, caso contrário, define como página 1
        $pagina_atual = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;

        // Calcula o offset (deslocamento) para a consulta SQL
        $offset = ($pagina_atual - 1) * $registros_por_pagina;

        //Consulta para buscar os registros
        $stmt = $con->prepare("SELECT * FROM clients LIMIT :offset, :registros_por_pagina");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
        $stmt->execute();
        $rows_clients = $stmt->fetchAll( PDO::FETCH_ASSOC);

//        // Exibir os registros
//        foreach ($rows_clients as $rows_client) {
//            echo '<p>' . $rows_client['date_created'] . '</p>';
//        }

        $stmt_count = $con->prepare("SELECT COUNT(*) AS total_registros FROM clients");
        $stmt_count->execute();
        $row = $stmt_count->fetch(PDO::FETCH_ASSOC);
        $total_registros = $row ? $row['total_registros'] : 0;

        $total_paginas = ceil($total_registros / $registros_por_pagina);

        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Clientes</h4>
            </div>
            <div class="card-body">

                <style>
                    .table td, .table th {
                        padding: 0.4rem;
                        font-size: 14px;
                    }
                </style>
                <!-- Tabela de Clientes -->
                <div class="table-responsive" id="tabelaClientes">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">E-mail</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows_clients as $client_row)
                        { // Renomeia $client para $client_row
                            echo "<tr>";
                            echo "<td>";
                            echo $client_row['client_id']; // Usa $client_row para evitar a sobreposição
                            echo "</td>";
                            echo "<td>";
                            $stmtClient = $con->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name
                                                FROM clients
                                                WHERE client_id = ?");
                            $stmtClient->execute(array($client_row['client_id'])); // Usa $client_row
                            $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
                            echo $client['full_name'];
                            echo "</td>";
                            echo "<td>";
                            // Formata o número de telefone
                            $phone_number = $client_row['phone_number'];
                            $formatted_phone_number = '(' . substr($phone_number, 0, 2) . ') ' . substr($phone_number, 2, 5) . '-' . substr($phone_number, 7);
                            echo $formatted_phone_number;
                            echo "</td>";
                            echo "<td>";
                            echo $client_row['client_email'];
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Paginação -->
        <div class="pagination justify-content-center mt-4">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $total_paginas; $i++) {
//                    $active = ($i == $pagina_atual) ? "active" : "";
                    echo '<li class="page-item ' . ($pagina_atual == $i ? 'active' : '') . '"><a class="page-link" href="clients.php?page=' . $i . '">' . $i . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <?php

    //Inclui rodapé
    include 'Includes/templates/footer.php';
} else {
    header('Location: login.php');
    exit();
}

?>
