<?php
session_start();

//Título da página
$pageTitle = 'Categorías de Serviços';

//Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

//Verifica se o usuário já está logado
if (isset($_SESSION['username_barbershop_Xw211qAAsq4']) && isset($_SESSION['password_barbershop_Xw211qAAsq4'])) {
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Cabeçalho da página -->

        <!-- Tabela de categorias de serviço -->
        <?php
        $stmt = $con->prepare("SELECT * FROM service_categories");
        $stmt->execute();
        $rows_categories = $stmt->fetchAll();
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary">Categorias de serviço</h4>
            </div>
            <div class="card-body">

                <!-- BOTÃO ADICIONAR NOVA CATEGORIA -->
                <button class="btn btn-success btn-sm" style="margin-bottom: 10px;" type="button" data-toggle="modal" data-target="#add_new_category" data-placement="top">
                    <i class="fa fa-plus"></i>
                    Adicionar Categoria
                </button>

                <!-- Adicionar novo modal de categoria -->
                <div class="modal fade" id="add_new_category" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Adicionar nova categoria</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="category_name">Nome da Categoria</label>
                                    <input type="text" id="category_name_input" class="form-control" placeholder="Nome da Categoria" name="category_name">
                                    <div class="invalid-feedback" id="required_category_name" style="display: none;">
                                        O nome da categoria é obrigatório!
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-info" id="add_category_bttn">Adicionar Categoría</button>
                            </div>
                        </div>
                    </div>
                </div>


                <style>
                    .table td, .table th{
                        padding: 1px !important;
                        vertical-align: middle!important;
                        text-align: center;
                        font-size: 16px;
                    }
                    .list-inline-item{
                        margin-top: 7px;
                    }
                </style>
                <!-- Tabela de Categorias -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID da Categoría</th>
                                <th>Nome da Categoria</th>
                                <th>Administrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_categories as $category) {
                                echo "<tr>";
                                echo "<td>";
                                echo $category['category_id'];
                                echo "</td>";
                                echo "<td>";
                                echo $category['category_name'];
                                echo "</td>";
                                echo "<td>";
                                if (strtolower($category["category_name"]) != "uncategorized") {
                                    $delete_data = "delete_" . $category["category_id"];
                                    $edit_data = "edit_" . $category["category_id"];
                            ?>
                                    <!-- BOTÕES EXCLUIR E EDITAR -->
                                    <ul>
                                        <li class="list-inline-item" data-toggle="tooltip" title="Editar">
                                            <button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $edit_data; ?>" data-placement="top"><i class="fa fa-edit"></i></button>

                                            <!-- EDITAR Modal -->

                                            <div class="modal fade" id="<?php echo $edit_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $edit_data; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Editar Categoría</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="category_name">Nome da Categoria</label>
                                                                <input type="text" class="form-control" id="<?php echo "input_category_name_" . $category["category_id"]; ?>" value="<?php echo $category["category_name"]; ?>">
                                                                <div class="invalid-feedback" id="<?php echo "invalid_input_" . $category["category_id"]; ?>">
                                                                    Nome da categoria e obrigatorio.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" data-id="<?php echo $category['category_id']; ?>" class="btn btn-success edit_category_bttn">Editar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <!---->
                                        <li class="list-inline-item" data-toggle="tooltip" title="Eliminar">
                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $delete_data; ?>" data-placement="top"><i class="fa fa-trash"></i></button>

                                            <!-- Excluir Modal -->

                                            <div class="modal fade" id="<?php echo $delete_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $delete_data; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Excluir Categoria</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Tem certeza que deseja excluir a categoria: "<?php echo $category['category_name']; ?>" ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="button" data-id="<?php echo $category['category_id']; ?>" class="btn btn-danger delete_category_bttn">Excluir</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                            <?php
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php

    //Include Rodape
    include 'Includes/templates/footer.php';
} else {
    header('Location: login.php');
    exit();
}

?>