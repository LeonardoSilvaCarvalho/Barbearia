<?php
include '../connect.php';

// Verificar se a conexão com o banco de dados foi estabelecida
if ($con) {
    if (!empty($_POST)) {
        // Verificar se a seleção é diária ou mensal
        if ($_POST['intervalo'] == 'diario') {
            // Define a cláusula WHERE para intervalo diário
            $whereClause = "DATE(start_time) = :dataDiaria";
            // Define o parâmetro da data diária
            $paramDiaria = $_POST['data'];
        } elseif ($_POST['intervalo'] == 'mensal') {
            // Define a cláusula WHERE para intervalo mensal
            $whereClause = "MONTH(start_time) = :mesMensal";
            // Define o parâmetro do mês mensal
            $paramMensal = $_POST['mes'];
        }

        // Consulta SQL com a cláusula WHERE dinâmica
        $query = "SELECT 
                    DATE(start_time) AS data,
                    CONCAT_WS(' ', c.first_name, c.last_name) AS descricao_cliente,
                    CONCAT_WS(' ', e.first_name, e.last_name) AS descricao_funcionario,
                    s.service_name AS descricao_servico,
                    s.service_price AS valor_bruto,
                    (s.service_price * 0.4) AS valor_funcionario,
                    (s.service_price * 0.6) AS valor_liquido
                FROM appointments a
                INNER JOIN clients c ON a.client_id = c.client_id
                INNER JOIN employees e ON a.employee_id = e.employee_id
                INNER JOIN services_booked sb ON a.appointment_id = sb.appointment_id
                INNER JOIN services s ON sb.service_id = s.service_id
                WHERE $whereClause";

        // Preparar e executar a consulta SQL
        $stmt = $con->prepare($query);
        if ($_POST['intervalo'] == 'diario') {
            $stmt->bindParam(':dataDiaria', $paramDiaria, PDO::PARAM_STR);
        } elseif ($_POST['intervalo'] == 'mensal') {
            $stmt->bindParam(':mesMensal', $paramMensal, PDO::PARAM_INT);
        }
        $stmt->execute();

        // Obter os resultados da consulta
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retornar os resultados como JSON
        echo json_encode($results);
    }
} else {
    echo "Erro na conexão com o banco de dados.";
}
?>
