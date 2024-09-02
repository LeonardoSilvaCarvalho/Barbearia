<!-- PHP INCLUDES -->

<?php

include "connect.php";
include "Includes/functions/functions.php";
include "Includes/templates/header.php";
include "Includes/templates/navbar.php";

?>
<!-- Estilo da página de agendamento de consulta -->
<link rel="stylesheet" href="Design/css/appointment-page-style.css">

<!-- SEÇÃO DE AGENDAMENTO DE CONSULTA -->

<section class="booking_section">
    <div class="container">

        <?php

        if (isset($_POST['submit_book_appointment_form']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            // Serviços selecionados

            $selected_services = $_POST['selected_services'];

            // Funcionário selecionado

            $selected_employee = $_POST['selected_employee'];

            // Data+Hora selecionadas

            $selected_date_time = explode(' ', $_POST['desired_date_time']);

            $date_selected = $selected_date_time[0];
            $start_time = $date_selected . " " . $selected_date_time[1];
            $end_time = $date_selected . " " . $selected_date_time[2];


            //Detalhes do Cliente

            $client_first_name = test_input($_POST['client_first_name']);
            $client_last_name = test_input($_POST['client_last_name']);
            $client_phone_number = test_input($_POST['client_phone_number']);
            $client_email = test_input($_POST['client_email']);

            $con->beginTransaction();

            try {
                // Verifica se o email do cliente já existe em nosso banco de dados
                $stmtCheckClient = $con->prepare("SELECT * FROM clients WHERE client_email = ?");
                $stmtCheckClient->execute(array($client_email));
                $client_result = $stmtCheckClient->fetch();
                $client_count = $stmtCheckClient->rowCount();

                if ($client_count > 0) {
                    $client_id = $client_result["client_id"];
                } else {
                    // Se o cliente não existe, insira um novo cliente
                    $stmtClient = $con->prepare("INSERT INTO clients (first_name, last_name, phone_number, client_email) VALUES (?, ?, ?, ?)");
                    $stmtClient->execute(array($client_first_name, $client_last_name, $client_phone_number, $client_email));

                    // Obtenha o ID do cliente inserido
                    $client_id = $con->lastInsertId();
                }

                // Insira o agendamento na tabela appointments
                $stmt_appointment = $con->prepare("INSERT INTO appointments (date_created, client_id, employee_id, start_time, end_time_expected) VALUES (:date_created, :client_id, :employee_id, :start_time, :end_time)");
                $stmt_appointment->bindValue(':date_created', date("Y-m-d H:i"));
                $stmt_appointment->bindValue(':client_id', $client_id);
                $stmt_appointment->bindValue(':employee_id', $selected_employee);
                $stmt_appointment->bindValue(':start_time', $start_time);
                $stmt_appointment->bindValue(':end_time', $end_time);
                $stmt_appointment->execute();

                // Obtenha o ID do agendamento inserido
                $appointment_id = $con->lastInsertId();

                // Insira os serviços reservados na tabela services_booked
                foreach ($selected_services as $service) {
                    $stmt = $con->prepare("INSERT INTO services_booked (appointment_id, service_id) VALUES (:appointment_id, :service_id)");
                    $stmt->bindValue(':appointment_id', $appointment_id);
                    $stmt->bindValue(':service_id', $service);
                    $stmt->execute();
                }

                echo "<div class='alert alert-success'>";
                echo "Excelente! Sua consulta foi agendada com sucesso.";
                echo "</div>";

                $con->commit();
            } catch (Exception $e) {
                $con->rollBack();
                echo "<div class='alert alert-danger'>";
                echo $e->getMessage();
                echo "</div>";
            }
        }

        ?>

        <!-- FORMULÁRIO DE RESERVA -->

        <form method="post" id="appointment_form" action="appointment.php">

            <!-- SELECIONAR SERVIÇO -->

            <div class="select_services_div tab_reservation" id="services_tab">

                <!-- MENSAGEM DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    Por favor, selecione pelo menos um serviço!
                </div>

                <div class="text_header">
					<span>
						1. Escolha o serviço que você precisa:
					</span>
                </div>

                <!-- GUICHE DE SERVIÇOS -->

                <div class="items_tab">
                    <?php
                    $stmt = $con->prepare("Select * from services");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();

                    foreach ($rows as $row) {
                        echo "<div class='itemListElement'>";
                        echo "<div class = 'item_details'>";
                        echo "<div>";
                        echo $row['service_name'];
                        echo "</div>";
                        echo "<div class = 'item_select_part'>";
                        echo "<span class = 'service_duration_field'>";
                        echo $row['service_duration'] . " min";
                        echo "</span>";
                        echo "<div class = 'service_price_field'>";
                        echo "<span style = 'font-weight: bold;'>";
                        echo "R$" . $row['service_price'];
                        echo "</span>";
                        echo "</div>";
                        ?>
                        <div class="select_item_bttn">
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="service_label item_label btn btn-secondary" style="margin-right: -6px">
                                    <input type="checkbox" name="selected_services[]" value="<?php echo $row['service_id'] ?>" autocomplete="off">Selecionar
                                </label>
                            </div>
                        </div>
                        <?php
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- SELECIONAR FUNCIONÁRIO -->

            <div class="select_employee_div tab_reservation" id="employees_tab">

                <!-- MENSAGEM DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    Por favor, selecione um barbeiro!
                </div>

                <div class="text_header">
					<span>
						2. Escolha do barbeiro
					</span>
                </div>

                <!-- GUICHE DE FUNCIONÁRIOS -->

                <div class="btn-group-toggle" data-toggle="buttons">
                    <div class="items_tab">
                        <?php
                        $stmt = $con->prepare("Select * from employees");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();

                        foreach ($rows as $row) {
                            echo "<div class='itemListElement'>";
                            echo "<div class = 'item_details'>";
                            echo "<div>";
                            echo $row['first_name'] . " " . $row['last_name'];
                            echo "</div>";
                            echo "<div class = 'item_select_part'>";
                            ?>
                            <div class="select_item_bttn">
                                <label class="item_label btn btn-secondary active">
                                    <input type="radio" class="radio_employee_select" name="selected_employee" value="<?php echo $row['employee_id'] ?>">Selecionar
                                </label>
                            </div>
                            <?php
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>


            <!-- SELECIONAR DATA E HORA -->

            <div class="select_date_time_div tab_reservation" id="calendar_tab">

                <!-- MENSAGEM DE ALERTA -->

                <div class="alert alert-danger" role="alert" style="display: none">
                    Por favor, selecione a hora da sua reserva!
                </div>

                <div class="text_header">
					<span>
						3. Escolha a data e a hora:
					</span>
                </div>

                <div class="calendar_tab" style="overflow-x: auto;overflow-y: visible;" id="calendar_tab_in">
                    <div id="calendar_loading">
                        <img src="Design/images/ajax_loader_gif.gif" style="display: block;margin-left: auto;margin-right: auto;">
                    </div>
                </div>

            </div>


            <!-- DETALHES DO CLIENTE -->

            <div class="client_details_div tab_reservation" id="client_tab">

                <div class="text_header">
					<span>
						4. Suas informações como cliente:
					</span>
                </div>

                <div>
                    <div class="form-group colum-row row">
                        <div class="col-sm-6">
                            <input type="text" name="client_first_name" id="client_first_name" class="form-control" placeholder="Nome">
                            <span class="invalid-feedback">Este campo é obrigatório</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="client_last_name" id="client_last_name" class="form-control" placeholder="Sobrenome">
                            <span class="invalid-feedback">Este campo é obrigatório</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="email" name="client_email" id="client_email" class="form-control" placeholder="Email">
                            <span class="invalid-feedback">Endereço de e-mail inválido</span>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="client_phone_number" id="client_phone_number" class="form-control" placeholder="Telefone Móvel">
                            <span class="invalid-feedback">Número de telefone inválido</span>
                        </div>
                    </div>

                </div>
            </div>




            <!-- BOTÕES PRÓXIMO E ANTERIOR -->

            <div style="overflow:auto;padding: 30px 0px;">
                <div style="float:right;">
                    <input type="hidden" name="submit_book_appointment_form">
                    <button type="button" id="prevBtn" class="next_prev_buttons" style="background-color: #bbbbbb;" onclick="nextPrev(-1)">Anterior</button>
                    <button type="button" id="nextBtn" class="next_prev_buttons" onclick="nextPrev(1)">Próximo</button>
                </div>
            </div>

            <!-- Círculos que indicam as etapas do formulário: -->

            <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
            </div>

        </form>
    </div>
</section>



<!-- FOOTER INFERIOR -->

<?php include "Includes/templates/footer.php"; ?>
