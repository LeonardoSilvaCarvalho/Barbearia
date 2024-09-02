<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
    // Título da página
    $pageTitle = 'Agendamentos';

    // Inclui
    include 'connect.php';
    include 'Includes/functions/functions.php';
    include 'Includes/templates/header.php';

    // Verifica se a pesquisa por funcionário foi enviada
    if (isset($_GET['employee_search'])) {
        $employee_search = $_GET['employee_search'];

        // Verifica se a pesquisa por funcionário está vazia
        if (!empty($employee_search)) {
            // Consulta SQL para buscar os agendamentos do funcionário
            $stmt = $con->prepare("SELECT * 
                           FROM appointments a
                           INNER JOIN clients c ON a.client_id = c.client_id
                           INNER JOIN employees e ON a.employee_id = e.employee_id
                           WHERE CONCAT(e.first_name, ' ', e.last_name) LIKE ? AND a.canceled = 0
                           ORDER BY a.start_time");
            $stmt->execute(array("%$employee_search%"));
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();
        } else {
            // Consulta SQL padrão para todos os agendamentos
            $stmt = $con->prepare("SELECT * 
                                   FROM appointments a
                                   INNER JOIN clients c ON a.client_id = c.client_id
                                   WHERE start_time >= ? AND a.canceled = 0
                                   ORDER BY a.start_time");
            $stmt->execute(array(date('Y-m-d H:i:s')));
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();
        }
    } else {
        // Consulta SQL padrão para todos os agendamentos
        $stmt = $con->prepare("SELECT * 
                               FROM appointments a
                               INNER JOIN clients c ON a.client_id = c.client_id
                               WHERE start_time >= ? AND a.canceled = 0
                               ORDER BY a.start_time");
        $stmt->execute(array(date('Y-m-d H:i:s')));
        $rows = $stmt->fetchAll();
        $count = $stmt->rowCount();
    }
?>

    <!-- Conteúdo da página inicial -->
    <div class="container-fluid">

        <!-- Cabeçalho da página -->

        <!-- Linha de conteúdo -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total de clientes
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                    echo countItems("client_id",
                                        "clients") ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bs bs-boy fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Serviços totais
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                    echo countItems("service_id",
                                        "services") ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bs bs-scissors-1 fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Funcionários
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php
                                            echo countItems("employee_id",
                                                "employees") ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bs bs-man fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Agendamentos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php
                                    echo countItems("appointment_id",
                                        "appointments") ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <style>
            .card-body {
                font-size: 13px;
            }
        </style>
        <!-- Tabelas de agendamentos -->
        <div class="card shadow mb-4">
            <div class="card-header tab"
                 style="padding: 0px !important;background: #1984bc!important">
                <button class="tablinks active"
                        onclick="openTab(event, 'Upcoming')">
                    Próximas Reservas
                </button>
                <button class="tablinks" onclick="openTab(event, 'All')">
                    Todas as reservas
                </button>
                <button class="tablinks" onclick="openTab(event, 'Canceled')">
                    Reservas canceladas
                </button>
                <form method="get" class="form-inline my-2 my-lg-2"
                      style="justify-content: flex-end; flex-flow: row wrap; margin: 0 20px 0 0">
                    <input class="form-control mr-sm-0" type="search"
                           name="employee_search"
                           placeholder="Pesquisar por funcionario"
                           aria-label="Search"
                           style="border-radius: 7px 0 0 7px">
                    <button class="btn btn-outline-success my-0 my-sm-0"
                            type="submit"
                            style="padding: 5px 10px;
                            border-radius: 0 7px 7px 0;
                            background: #1cc88a;
                            color: #fff"
                    ><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered tabcontent" id="Upcoming"
                           style="display:table" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Funcionário</th>
                            <th>Serviços reservados</th>
                            <th>Hora de início</th>
                            <th>Hora de término</th>
                            <th>Cliente</th>
                            <th>Preço</th>
                            <th>Administrar</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        if ($count == 0) {
                            echo "<tr>";
                            echo "<td colspan='5' style='text-align:center;'>";
                            echo "A lista de próximas reservas estará aqui";
                            echo "</td>";
                            echo "</tr>";
                        } else {
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td style='color: #000; font-weight: bold;'>";
                                $stmtEmployees = $con->prepare("SELECT first_name,last_name
                                            FROM employees e, appointments a
                                            WHERE e.employee_id = a.employee_id
                                            AND a.appointment_id = ?");
                                $stmtEmployees->execute(array($row['appointment_id']));
                                $rowsEmployees = $stmtEmployees->fetchAll();
                                foreach ($rowsEmployees as $rowsEmployee) {
                                    echo $rowsEmployee['first_name'] . " " . $rowsEmployee['last_name'];
                                }
                                echo "</td>";
                                echo "<td>";
                                $stmtServices = $con->prepare("SELECT service_name, service_price
                                            FROM services s, services_booked sb
                                            WHERE s.service_id = sb.service_id
                                            AND appointment_id = ?");
                                $stmtServices->execute(array($row['appointment_id']));
                                $rowsServices = $stmtServices->fetchAll();
                                $totalPrice = 0; // Variável para armazenar o preço total
                                foreach ($rowsServices as $rowsService) {
                                    echo "" . $rowsService['service_name'] . " (R$ " . number_format($rowsService['service_price'], 2, ',', '.') . ")"; // Exibe o nome do serviço e o preço formatado
                                    if (next($rowsServices) == true) {
                                        echo " <br> ";
                                    }
                                    $totalPrice += $rowsService['service_price']; // Adiciona o preço do serviço ao preço total
                                }
                                echo "</td>";
                                echo "<td>";
                                echo date('d/m/Y H:i', strtotime($row['start_time']));
                                echo "</td>";
                                echo "<td>";
                                echo date('d/m/Y H:i', strtotime($row['end_time_expected']));
                                echo "</td>";
                                echo "<td>";
                                echo "<a href = # style='cursor: default; text-decoration: none; color: #858796'>";
                                $stmtClient = $con->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name
                                        FROM clients
                                        WHERE client_id = ?");
                                $stmtClient->execute(array($row['client_id']));
                                $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
                                echo $client['full_name'];
                                echo "</a>";
                                echo "</td>";
                                echo "<td>";
                                echo "R$ " . number_format($totalPrice, 2, ',', '.'); // Exibe o preço total formatado
                                echo "</td>";
                                echo "<td>";
                                $cancel_data = "cancel_appointment_"
                                    . $row["appointment_id"];
                                ?>
                                <ul class="list-inline m-0">

                                    <!-- BOTÃO CANCELAR -->

                                    <li class="list-inline-item"
                                        data-toggle="tooltip"
                                        title="Cancelar Agendamento">
                                        <button class="btn btn-danger btn-sm rounded-0"
                                                type="button"
                                                data-toggle="modal"
                                                data-target="#<?php
                                                echo $cancel_data; ?>"
                                                data-placement="top">
                                            <i class="fas fa-calendar-times"></i>
                                        </button>

                                        <!-- CANCELAR MODAL -->
                                        <div class="modal fade" id="<?php
                                        echo $cancel_data; ?>" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="<?php
                                             echo $cancel_data; ?>"
                                             aria-hidden="true">
                                            <div class="modal-dialog"
                                                 role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Cancelar Agendamento</h5>
                                                        <button type="button"
                                                                class="close"
                                                                data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Deseja cancelar esse agendamento?</p>
                                                        <div class="form-group">
                                                            <label>Descreva o motivo?</label>
                                                            <textarea
                                                                    class="form-control"
                                                                    id='<?php
                                                                    echo "appointment_cancellation_reason_"
                                                                    . $row['appointment_id'] ?>'
                                                                    placeholder="Não e obrigatorio!"
                                                            ></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-dismiss="modal">
                                                            Não
                                                        </button>
                                                        <button type="button"
                                                                data-id="<?php
                                                                echo $row['appointment_id']; ?>"
                                                                class="btn btn-danger cancel_appointment_button">
                                                            Sim, Cancelar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </li>
                                </ul>

                                <?php
                                echo "</td>";
                                echo "</tr>";
                            }
                        }

                        ?>

                        </tbody>
                    </table>
                    <table class="table table-bordered tabcontent" id="All"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Funcionario</th>
                            <th>Servicios reservados</th>
                            <th>Cliente</th>
                            <th>Hora de inicio</th>
                            <th>Hora de finalización prevista</th>
                            <th>Preço</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $stmt = $con->prepare("SELECT *
                                                FROM appointments a , clients c
                                                where a.client_id = c.client_id
                                                order by employee_id;
                                                ");
                        $stmt->execute(array());
                        $rows = $stmt->fetchAll();
                        $count = $stmt->rowCount();

                        if ($count == 0) {
                            echo "<tr>";
                            echo "<td colspan='5' style='text-align:center;'>";
                            echo "A lista de próximas reservas estará aqui";
                            echo "</td>";
                            echo "</tr>";
                        } else {
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td style='color: #000; font-weight: bold;'>";
                                $stmtEmployees = $con->prepare("SELECT first_name,last_name
                                                        from employees e, appointments a
                                                        where e.employee_id = a.employee_id
                                                        and a.appointment_id = ?");
                                $stmtEmployees->execute(array($row['appointment_id']));
                                $rowsEmployees = $stmtEmployees->fetchAll();
                                foreach ($rowsEmployees as $rowsEmployee) {
                                    echo $rowsEmployee['first_name'] . " "
                                        . $rowsEmployee['last_name'];
                                }
                                echo "</td>";
                                echo "<td>";
                                $stmtServices = $con->prepare("SELECT service_name, service_price
                                            FROM services s, services_booked sb
                                            WHERE s.service_id = sb.service_id
                                            AND appointment_id = ?");
                                $stmtServices->execute(array($row['appointment_id']));
                                $rowsServices = $stmtServices->fetchAll();
                                $totalPrice = 0; // Variável para armazenar o preço total
                                foreach ($rowsServices as $rowsService) {
                                    echo "" . $rowsService['service_name']; // Exibe o nome do serviço e o preço formatado
                                    if (next($rowsServices) == true) {
                                        echo " <br> ";
                                    }
                                    $totalPrice += $rowsService['service_price']; // Adiciona o preço do serviço ao preço total
                                }
                                echo "</td>";
                                echo "<td>";
                                echo "<a href = # style='cursor: default; text-decoration: none; color: #858796'>";
                                $stmtClient = $con->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name
                                        FROM clients
                                        WHERE client_id = ?");
                                $stmtClient->execute(array($row['client_id']));
                                $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
                                echo $client['full_name'];
                                echo "</a>";
                                echo "</td>";
                                echo "<td>";
                                echo date('d/m/Y H:i', strtotime($row['start_time']));
                                echo "</td>";
                                echo "<td>";
                                echo date('d/m/Y H:i', strtotime($row['end_time_expected']));
                                echo "</td>";
                                echo "<td>";
                                echo "R$ " . number_format($totalPrice, 2, ',', '.'); // Exibe o preço total formatado
                                echo "</td>";

                                echo "</tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered tabcontent" id="Canceled"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Data e hora</th>
                            <th>Cliente</th>
                            <th>Motivo do cancelamento</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $stmt = $con->prepare("SELECT * 
                                                FROM appointments a , clients c
                                                where canceled = 1
                                                and a.client_id = c.client_id
                                                ");
                        $stmt->execute(array());
                        $rows = $stmt->fetchAll();
                        $count = $stmt->rowCount();

                        if ($count == 0) {
                            echo "<tr>";
                            echo "<td colspan='5' style='text-align:center;'>";
                            echo "A lista de suas reservas canceladas será apresentada aqui";
                            echo "</td>";
                            echo "</tr>";
                        } else {
                            foreach ($rows as $row) {
                                echo "<tr>";
                                echo "<td>";
                                echo date('d/m/Y H:i', strtotime($row['start_time']));
                                echo "</td>";
                                echo "<td>";
                                echo "<a href = # style='cursor: default; text-decoration: none; color: #858796'>";
                                $stmtClient = $con->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name
                                        FROM clients
                                        WHERE client_id = ?");
                                $stmtClient->execute(array($row['client_id']));
                                $client = $stmtClient->fetch(PDO::FETCH_ASSOC);
                                echo $client['full_name'];
                                echo "</a>";
                                echo "</td>";
                                echo "<td>";

                                echo $row['cancellation_reason'];

                                echo "</td>";
                                echo "</tr>";
                            }
                        }

                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
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