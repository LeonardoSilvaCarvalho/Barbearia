<?php
ob_start();
session_start();

//Título da página
$pageTitle = 'Funcionarios';

//Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

//ARQUIVOS JS extras
echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";

//Verifica se o usuário já está logado
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
?>
    <!-- Conteúdo da página inicial -->
    <div class="container-fluid">

        <!-- Cabeçalho da página -->

        <?php
        $do = '';

        if (isset($_GET['do']) && in_array($_GET['do'], array('Add', 'Edit'))) {
            $do = htmlspecialchars($_GET['do']);
        } else {
            $do = 'Manage';
        }

        if ($do == 'Manage') {
            $stmt = $con->prepare("SELECT * FROM employees");
            $stmt->execute();
            $rows_employees = $stmt->fetchAll();

        ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Funcionarios</h4>
                </div>
                <div class="card-body">

                    <!-- BOTÃO ADICIONAR NOVO FUNCIONÁRIO -->
                    <a href="employees.php?do=Add" class="btn btn-success btn-sm" style="margin-bottom: 10px;">
                        <i class="fa fa-plus"></i>
                        Cadastrar Funcionario
                    </a>

                    <!-- Tabela de Funcionários -->
                    <style>
                        .table td, .table th {
                            padding: 0.4rem;
                            font-size: 14px;
                        }
                    </style>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Administrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($rows_employees as $employee) {
                                    echo "<tr>";
                                    echo "<td>";
                                    $stmtEmploye = $con->prepare("SELECT CONCAT(first_name, ' ', last_name) AS full_name
                                                FROM employees
                                                WHERE employee_id = ?");
                                    $stmtEmploye->execute(array($employee['employee_id']));
                                    $client = $stmtEmploye->fetch(PDO::FETCH_ASSOC);
                                    echo $client['full_name'];
                                    echo "</td>";
                                    echo "<td>";
                                    // Formata o número de telefone
                                    $phone_number = $employee['phone_number'];
                                    $formatted_phone_number = '(' . substr($phone_number, 0, 2) . ') ' . substr($phone_number, 2, 5) . '-' . substr($phone_number, 7);
                                    echo $formatted_phone_number;
                                    echo "</td>";
                                    echo "<td>";
                                    echo $employee['email'];
                                    echo "</td>";
                                    echo "<td>";
                                    $delete_data = "delete_employee_" . $employee["employee_id"];
                                ?>
                                    <ul class="list-inline m-0">

                                        <!-- BOTÃO EDITAR -->

                                        <li class="list-inline-item" data-toggle="tooltip" title="Editar">
                                            <button class="btn btn-success btn-sm rounded-0">
                                                <a href="employees.php?do=Edit&employee_id=<?php echo $employee['employee_id']; ?>" style="color: white;">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </button>
                                        </li>

                                        <!-- BOTÃO EXCLUIR -->

                                        <li class="list-inline-item" data-toggle="tooltip" title="Eliminar">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $delete_data; ?>" data-placement="top"><i class="fa fa-trash"></i></button>

                                            <!-- Excluir Modal -->

                                            <div class="modal fade" id="<?php echo $delete_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $delete_data; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Excluir funcionario</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Certeza que deseja excluir o funcionario: "<?php echo $client['full_name']; ?>" ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" data-id="<?php echo $employee['employee_id']; ?>" class="btn btn-danger delete_employee_bttn">Excluir</button>
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
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
        } elseif ($do == 'Add') {
        ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Adicionar novo funcionario</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="employees.php?do=Add">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_fname">Nome</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['employee_fname'])) ? htmlspecialchars($_POST['employee_fname']) : '' ?>" placeholder="Nome" name="employee_fname">
                                    <?php
                                    $flag_add_employee_form = 0;
                                    if (isset($_POST['add_new_employee'])) {
                                        if (empty(test_input($_POST['employee_fname']))) {
                                    ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                Nome e obrigatorio
                                            </div>
                                    <?php

                                            $flag_add_employee_form = 1;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_lname">Sobrenome</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['employee_lname'])) ? htmlspecialchars($_POST['employee_lname']) : '' ?>" placeholder="Sobrenome" name="employee_lname">
                                    <?php
                                    if (isset($_POST['add_new_employee'])) {
                                        if (empty(test_input($_POST['employee_lname']))) {
                                    ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                Sobrenome e obrigatorio
                                            </div>
                                    <?php

                                            $flag_add_employee_form = 1;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_phone">Telefone</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['employee_phone'])) ? htmlspecialchars($_POST['employee_phone']) : '' ?>" placeholder="Telefone" name="employee_phone">
                                    <?php
                                    if (isset($_POST['add_new_employee'])) {
                                        if (empty(test_input($_POST['employee_phone']))) {
                                    ?>
                                            <div class="invalid-feedback" style="display: block;">
                                                Telefone e obrigatorio
                                            </div>
                                    <?php

                                            $flag_add_employee_form = 1;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee_email">E-mail</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($_POST['employee_email'])) ? htmlspecialchars($_POST['employee_email']) : '' ?>" placeholder="E-mail" name="employee_email">
                                    <?php
                                    if (isset($_POST['add_new_employee'])) {
                                        if (empty(test_input($_POST['employee_email']))) {
                                    ?>
                                            <div class="invalid-feedback" style="display: block;">
                                               Email e obrigatorio
                                            </div>
                                    <?php

                                            $flag_add_employee_form = 1;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- BOTÃO ENVIAR -->

                        <button type="submit" name="add_new_employee" class="btn btn-primary">Cadastrar funcionario</button>

                    </form>

                    <?php

                    /*** ADICIONAR NOVO FUNCIONÁRIO ***/

                    if (isset($_POST['add_new_employee']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_add_employee_form == 0) {
                        $employee_fname = test_input($_POST['employee_fname']);
                        $employee_lname = $_POST['employee_lname'];
                        $employee_phone = test_input($_POST['employee_phone']);
                        $employee_email = test_input($_POST['employee_email']);

                        try {
                            $stmt = $con->prepare("insert into employees(first_name,last_name,phone_number,email) values(?,?,?,?) ");
                            $stmt->execute(array($employee_fname, $employee_lname, $employee_phone, $employee_email));

                    ?>
                            <!-- MENSAGEM DE SUCESSO -->

                            <script type="text/javascript">
                                swal("Novo empregado", "O novo funcionário foi cadastrado com sucesso.", "success").then((value) => {
                                    window.location.replace("employees.php");
                                });
                            </script>

                    <?php

                        } catch (Exception $e) {
                            echo "<div class = 'alert alert-danger' style='margin:10px 0px;'>";
                            echo 'Um erro ocorreu: ' . $e->getMessage();
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        } elseif ($do == 'Edit') {
            $employee_id = (isset($_GET['employee_id']) && is_numeric($_GET['employee_id'])) ? intval($_GET['employee_id']) : 0;

            if ($employee_id) {
                $stmt = $con->prepare("Select * from employees where employee_id = ?");
                $stmt->execute(array($employee_id));
                $employee = $stmt->fetch();
                $count = $stmt->rowCount();

                if ($count > 0) {
            ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Editar funcionario</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="employees.php?do=Edit&employee_id=<?php echo $employee_id; ?>">
                                <!-- ID do funcionário -->
                                <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_fname">Nome</label>
                                            <input type="text" class="form-control" value="<?php echo $employee['first_name'] ?>" placeholder="Nome" name="employee_fname">
                                            <?php
                                            $flag_edit_employee_form = 0;
                                            if (isset($_POST['edit_employee_sbmt'])) {
                                                if (empty(test_input($_POST['employee_fname']))) {
                                            ?>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        Nome e obrigatorio
                                                    </div>
                                            <?php

                                                    $flag_edit_employee_form = 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_lname">Sobrenome</label>
                                            <input type="text" class="form-control" value="<?php echo $employee['last_name'] ?>" placeholder="Sobrenome" name="employee_lname">
                                            <?php
                                            if (isset($_POST['edit_employee_sbmt'])) {
                                                if (empty(test_input($_POST['employee_lname']))) {
                                            ?>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        Sobrenome e obrigatorio
                                                    </div>
                                            <?php

                                                    $flag_edit_employee_form = 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_phone">Telefone</label>
                                            <input type="text" class="form-control" value="<?php echo $employee['phone_number'] ?>" placeholder="Telefone" name="employee_phone">
                                            <?php
                                            if (isset($_POST['edit_employee_sbmt'])) {
                                                if (empty(test_input($_POST['employee_phone']))) {
                                            ?>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        Telefone e obrigatorio
                                                    </div>
                                            <?php

                                                    $flag_edit_employee_form = 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_email">E-mail</label>
                                            <input type="text" class="form-control" value="<?php echo $employee['email'] ?>" placeholder="E-mail" name="employee_email">
                                            <?php
                                            if (isset($_POST['edit_employee_sbmt'])) {
                                                if (empty(test_input($_POST['employee_email']))) {
                                            ?>
                                                    <div class="invalid-feedback" style="display: block;">
                                                        E-mail e obrigatorio
                                                    </div>
                                            <?php

                                                    $flag_edit_employee_form = 1;
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTÃO ENVIAR -->
                                <button type="submit" name="edit_employee_sbmt" class="btn btn-primary">
                                    Editar
                                </button>
                            </form>
                            <?php
                            /*** EDITAR FUNCIONÁRIO ***/
                            if (isset($_POST['edit_employee_sbmt']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $flag_edit_employee_form == 0) {
                                $employee_fname = test_input($_POST['employee_fname']);
                                $employee_lname = $_POST['employee_lname'];
                                $employee_phone = test_input($_POST['employee_phone']);
                                $employee_email = test_input($_POST['employee_email']);
                                $employee_id = $_POST['employee_id'];

                                try {
                                    $stmt = $con->prepare("update employees set first_name = ?, last_name = ?, phone_number = ?, email = ? where employee_id = ? ");
                                    $stmt->execute(array($employee_fname, $employee_lname, $employee_phone, $employee_email, $employee_id));

                            ?>
                                    <!-- MENSAGEM DE SUCESSO -->

                                    <script type="text/javascript">
                                        swal("Funcionário atualizado", "O funcionário foi atualizado com sucesso", "success").then((value) => {
                                            window.location.replace("employees.php");
                                        });
                                    </script>

                            <?php

                                } catch (Exception $e) {
                                    echo "<div class = 'alert alert-danger' style='margin:10px 0px;'>";
                                    echo 'Um erro ocorreu: ' . $e->getMessage();
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
        <?php
                } else {
                    header('Location: employees.php');
                    exit();
                }
            } else {
                header('Location: employees.php');
                exit();
            }
        }
        ?>
    </div>

<?php

    //Inclui rodapé
    include 'Includes/templates/footer.php';
} else {
    header('Location: login.php');
    exit();
}

?>