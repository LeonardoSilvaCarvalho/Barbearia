<?php

session_start();

// Título da página
$pageTitle = 'Relatório Financeiro';

// Includes
include 'connect.php';
include 'Includes/functions/functions.php';
include 'Includes/templates/header.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['username_barbershop_Xw211qAAsq4'])
    && isset($_SESSION['password_barbershop_Xw211qAAsq4'])
) {
    ?>


    <style>
        .list-group li {
            font-size: 17px;
        }
    </style>
    <!--   TABELA DE RELATORIO GERAL   -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">
                    <strong>Ajuda - </strong> Filtre os resumos financeiros
                    selecionando o intervalo desejado e a data. Em seguida,
                    clique em "Filtrar" para visualizar os resultados.
                    <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Resumo do Relatório -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Resumo
                            Geral</h6>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-3">Faturamento</h5>
                        <ul class="list-group" id="resumoFaturamento">
                            <!-- Os valores de faturamento serão adicionados aqui -->
                        </ul>
                        <h5 class="mt-4 mb-3">Comissões</h5>
                        <ul class="list-group" id="resumoComissoes">
                            <!-- As comissões serão adicionadas aqui -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
            padding-left: .5rem !important;
            padding-right: 0.5rem !important;
            font-size: 14px !important;
        }
    </style>
    <!--  TABELA DE RELATORIO FINANCEIRO  -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <!-- Cabeçalho da página -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Relatório
                    Financeiro</h4>
                <span>
                    <form class="d-flex justify-content-start align-items-center"
                          id="form-control">
                        <label class="mt-2 mr-2">Intervalo:</label>
                            <select class="form-control" name="intervalo">
                                <option value="diario">Diario</option>
                                <option value="mensal">Mensal</option>
                            </select>
                            <label class="mr-1 mt-2 ml-1 p-2"
                                   style="border-left: 1px solid #c3c3c3">Data:</label>
                        <div class="">
                            <input type="date" class="form-control"
                                   id="filtroData" name="data">
                        </div>
                        <div style="border-right: 1px solid #c3c3c3">
                            <button type="submit"
                                    class="btn btn-primary mr-2 ml-1"
                                    id="btnFiltrar">Filtrar</button>
                        </div>
                        <button type="button" class="btn btn-primary mx-2" style="white-space: nowrap" id="gerarPDF">Gerar PDF</button>
                        <input type="hidden" id="dadosFiltrados" name="dadosFiltrados">
                    </form>
                </span>
            </div>

            <!-- Conteúdo da tabela -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Funcionário</th>
                            <th>Serviço</th>
                            <th>Valor Bruto</th>
                            <th>Valor Funcionário</th>
                            <th>Valor Líquido</th>
                        </tr>
                        </thead>
                        <tbody id="tabelaDados">
                        <!-- Os dados filtrados serão exibidos aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: rgb(255,243,205);justify-content: flex-start;">
                    <i class="fas fa-exclamation-triangle" style="color: #000000; margin-right: 10px; font-size: 30px"></i>
                    <h5 class="modal-title" id="alertModalLabel" style="color: #000; font-weight: bolder;">Ops um Problema !</h5>
                </div>
                <div class="modal-body" style="color: #000000; font-weight: bolder;">
                    <!-- O conteúdo do modal será preenchido dinamicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function () {
            // Função para alterar dinamicamente o tipo do campo #filtroData
            function changeDateInputType() {
                var intervalo = $('select[name="intervalo"]').val();
                if (intervalo === 'diario') {
                    $('#filtroData').attr('type', 'date');
                } else if (intervalo === 'mensal') {
                    $('#filtroData').attr('type', 'month');
                }
            }
            // Chamada da função no carregamento da página
            changeDateInputType();
            // Evento de mudança no campo select para alterar o tipo do campo #filtroData
            $('select[name="intervalo"]').change(function () {
                changeDateInputType();
            });
            // **********************************************************************
            $('#form-control').submit(function (event) {
                event.preventDefault();

                if ($('#filtroData').val().trim() === '') {
                    $('#alertModal .modal-body').text('Por favor, preencha o campo de filtro da data.');
                    $('#alertModal').modal('show'); // Mostrar o modal se o campo estiver vazio
                    return; // Abortar o envio do formulário
                }

                var formData = $(this).serialize();
                if ($('select[name="intervalo"]').val() == 'mensal') {
                    // Obter o valor do campo de entrada de data e formatá-lo para enviar apenas o mês
                    var data = $('#filtroData').val();
                    // var mes = new Date(data).getMonth() + 1; // Adiciona 1 porque os meses começam de 0
                    var mes = data.split('-')[1]; // Obter o mês a partir da data
                    formData += '&mes=' + mes;
                }
                $.ajax({
                    data: formData,
                    url: 'ajax_files/relatorio_ajax.php',
                    type: 'POST',
                    success: function (response) {
                        // Limpar a tabela de dados antes de adicionar os novos dados
                        $('#tabelaDados').empty();
                        // Limpar o resumo de faturamento antes de adicionar os novos dados
                        $('#resumoFaturamento').empty();
                        // Limpar o resumo de comissões antes de adicionar os novos dados
                        $('#resumoComissoes').empty();

                        // Converter a resposta JSON em um objeto JavaScript
                        var dados = JSON.parse(response);

                        // Cálculo do total geral de faturamento
                        var totalBarbearia = 0;

                        // Objeto para armazenar o valor total de comissões por funcionário
                        var comissoesPorFuncionario = {};

                        // Iterar sobre os dados e adicionar linhas à tabela
                        $.each(dados, function (index, item) {
                            // Formatar a data de acordo com o intervalo selecionado
                            var dataFormatada;
                            if ($('select[name="intervalo"]').val() == 'diario') {
                                dataFormatada = new Date(item.data).toLocaleDateString('pt-BR');
                            } else if ($('select[name="intervalo"]').val() == 'mensal') {
                                dataFormatada = new Date(item.data).toLocaleDateString('pt-BR', {
                                    month: 'long',
                                    year: 'numeric'
                                });
                            }
                            // Formatar os valores como "R$00,00"
                            var valorBruto = parseFloat(item.valor_bruto).toFixed(2).replace('.', ',');
                            var valorFuncionario = parseFloat(item.valor_funcionario).toFixed(2).replace('.', ',');
                            var valorLiquido = parseFloat(item.valor_liquido).toFixed(2).replace('.', ',');
                            var row = "<tr>" +
                                "<td>" + dataFormatada + "</td>" +
                                "<td>" + item.descricao_cliente + "</td>" +
                                "<td>" + item.descricao_funcionario + "</td>" +
                                "<td>" + item.descricao_servico + "</td>" +
                                "<td>R$" + valorBruto + "</td>" +
                                "<td>R$" + valorFuncionario + "</td>" +
                                "<td>R$" + valorLiquido + "</td>" +
                                "</tr>";
                            $('#tabelaDados').append(row);

                            // Somar ao total geral de faturamento
                            totalBarbearia += parseFloat(item.valor_liquido);

                            // Adicionar o valor do serviço ao total de comissões do funcionário
                            var nomeFuncionario = item.descricao_funcionario;
                            if (!comissoesPorFuncionario[nomeFuncionario]) {
                                comissoesPorFuncionario[nomeFuncionario] = 0;
                            }
                            comissoesPorFuncionario[nomeFuncionario] += parseFloat(valorFuncionario);
                        });

                        // Adicionar o total geral de faturamento à lista de faturamento
                        var rowFaturamentoBarbearia = "<li class='list-group-item d-flex justify-content-between align-items-center'>Barbearia<span class='badge badge-primary badge-pill p-2'>R$" + totalBarbearia.toFixed(2).replace('.', ',') + "</span></li>";

                        $('#resumoFaturamento').append(rowFaturamentoBarbearia);

                        // Adicionar as comissões à lista de comissões
                        $.each(comissoesPorFuncionario, function (nomeFuncionario, valorComissao) {
                            var rowComissao = "<li class='list-group-item d-flex justify-content-between align-items-center'>" + nomeFuncionario + "<span class='badge badge-primary badge-pill p-2'>R$" + valorComissao.toFixed(2).replace('.', ',') + "</span></li>";
                            $('#resumoComissoes').append(rowComissao);
                        });

                        $('#dadosFiltrados').val(response);

                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            // Adiciona um evento de clique ao botão #gerarPDF
            $('#gerarPDF').click(function() {
                // Obter os dados filtrados do campo oculto
                const dadosFiltrados = $('#dadosFiltrados').val();

                // Verificar se o campo está vazio
                if (!dadosFiltrados) {
                    // Exibir um modal de aviso
                    $('#alertModal .modal-body').html('Não há dados disponíveis para gerar o PDF.<br><b>Filtre uma data.<b>');
                    $('#alertModal').modal('show');
                    return; // Abortar a geração do PDF
                }

                // Tentar fazer o parsing do JSON
                try {
                    const dados = JSON.parse(dadosFiltrados);

                    // Ordenar os dados pela data
                    dados.sort(function(a, b) {
                        // Converter as datas para o formato "dd/mm/aaaa"
                        const dataA = new Date(a.data).toLocaleDateString('pt-BR');
                        const dataB = new Date(b.data).toLocaleDateString('pt-BR');

                        // Comparar as datas
                        if (dataA < dataB) return -1;
                        if (dataA > dataB) return 1;
                        return 0;
                    });

                    const headerHtml = '<div style="text-align: center; margin-bottom: 20px;">' +
                        '<img src="../Design/images/logo.jpg" alt="Logotipo da Empresa" style="max-width: 150px;">' +
                        '<h4>Barbearia Tchelo\'s</h4>' +
                        '<p>Data: ' + new Date().toLocaleDateString('pt-BR') + '</p>' +
                        '</div>';

                    // Criar uma tabela HTML com estilos para ajustar o tamanho do PDF
                    let tableHtml = '<div><h4 style="color: #000; font-weight: bold;">Resumo Detalhado<h4></div><table style="width:98%; font-size: 13px; line-height: 14px; border-collapse: collapse;  color: #000" border="1" cellspacing="0" cellpadding="5"><thead><tr><th>Data</th><th>Cliente</th><th>Funcionário</th><th>Serviço</th><th>Valor Bruto</th><th>Valor Funcionário</th><th>Valor Líquido</th></tr></thead><tbody>';
                    dados.forEach(function(item) {
                        // Formatar a data
                        var data = new Date(item.data);
                        var dia = data.getDate().toString().padStart(2, '0');
                        var mes = (data.getMonth() + 1).toString().padStart(2, '0');
                        var ano = data.getFullYear();

                        var dataFormatada = dia + '/' + mes + '/' + ano;

                        // Formatar os valores como "R$00,00"
                        var valorBruto = 'R$' + parseFloat(item.valor_bruto).toFixed(2).replace('.', ',');
                        var valorFuncionario = 'R$' + parseFloat(item.valor_funcionario).toFixed(2).replace('.', ',');
                        var valorLiquido = 'R$' + parseFloat(item.valor_liquido).toFixed(2).replace('.', ',');

                        // Truncar os textos que excedem o tamanho do campo
                        var cliente = item.descricao_cliente.length > 15 ? item.descricao_cliente.substring(0, 15) + '...' : item.descricao_cliente;
                        var funcionario = item.descricao_funcionario.length > 15 ? item.descricao_funcionario.substring(0, 15) + '...' : item.descricao_funcionario;
                        var servico = item.descricao_servico.length > 15 ? item.descricao_servico.substring(0, 15) + '...' : item.descricao_servico;

                        // Construir a linha da tabela com os dados formatados
                        var row = "<tr>" +
                            "<td style='padding: 5px;'>" + dataFormatada + "</td>" +
                            "<td style='padding: 5px;'>" + cliente + "</td>" +
                            "<td style='padding: 5px;'>" + funcionario + "</td>" +
                            "<td style='padding: 5px;'>" + servico + "</td>" +
                            "<td style='padding: 5px;'>" + valorBruto + "</td>" +
                            "<td style='padding: 5px;'>" + valorFuncionario + "</td>" +
                            "<td style='padding: 5px;'>" + valorLiquido + "</td>" +
                            "</tr>";

                        // Adicionar a linha à tabela
                        tableHtml += row;
                    });

                    // Fechar a tabela
                    tableHtml += '</tbody></table>';

                    // Obter as informações do resumo geral
                    const resumoFaturamento = $('#resumoFaturamento').html();
                    const resumoComissoes = $('#resumoComissoes').html();

                    // Estilizar os resumos para o PDF
                    const estiloCampo = 'padding: 9px; border-bottom: 1px solid #ddd;  color: #000';
                    const estiloTitulo = 'background-color: #f2f2f2; border: 1px solid #ddd; padding: 8px;  color: #000';
                    const estiloResumoItem = 'border: 1px solid #ddd; padding: 1px;'; // Estilo para o conteúdo dentro dos resumos

                    // Criar uma tabela para armazenar as informações do resumo geral
                    let resumoHtml = '<table style="width: 98%; margin-bottom: 15px; border: 1px solid #333;">' +
                        '<tr>' +
                        '<th colspan="2" style="' + estiloTitulo + '">Resumo Geral</th>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="' + estiloCampo + '">Faturamento</td>' +
                        '<td style="' + estiloCampo + '">' + '<table style="width:100%;' + estiloResumoItem + '">' + resumoFaturamento + '</table>' + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="' + estiloCampo + '">Comissões</td>' +
                        '<td style="' + estiloCampo + '">' + '<table style="width:100%;' + estiloResumoItem + '">' + resumoComissoes + '</table>' + '</td>' +
                        '</tr>' +
                        '</table><hr style="margin-top: 20px; color: #000000; width: 98%">';


                    const option = {
                        margin: [10, 10, 10, 10],
                        filename: 'arquivo.pdf',
                        html2canvas: {scale: 2},
                        jsPDF: {unit: 'mm', format: "a4", orientation: 'portrait'}
                    }

                    // Combinar as informações do resumo geral com a tabela de dados
                    const pdfContent = headerHtml + resumoHtml + tableHtml;

                    // ************************************************
                        // criar o PDF e ja colocalo para download
                        // html2pdf().set(option).from(tableHtml).save();
                    // *********************************************

                    // ****************************************************
                    // Abrir o PDF no navegador
                            html2pdf().set(option).from(pdfContent).toPdf().get('pdf').then(function(pdf){
                                pdf.output('dataurlnewwindow');
                            });
                    // ****************************************************


                } catch (error) {
                    console.error('Erro ao fazer o parsing do JSON ou ao gerar o PDF:', error);
                }
            });

        });
    </script>


    <?php

// Inclui rodapé
    include 'Includes/templates/footer.php';
} else {
    header('Location: login.php');
    exit();
}

?>
