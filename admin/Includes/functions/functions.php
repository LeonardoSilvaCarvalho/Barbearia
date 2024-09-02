<?php

/*
================================================= ================================================= =====================
Função de título que ecoa o título da página caso a página tenha a variável $ pageTitle e ecoa o título padrão para outras páginas
================================================= ================================================= =====================
*/

function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle . ' | Barbearia Tchelos';
    } else {
        echo "Barbearia | Barbearia Tchelos";
    }
}

/*
================================================= ===========
** Função Contar Itens
** Esta função conta e retorna o número de elementos em uma determinada tabela
================================================= ============

*/


function countItems($item, $table)
{
    global $con;
    $stat_ = $con->prepare("SELECT COUNT($item) FROM $table");
    $stat_->execute();

    return $stat_->fetchColumn();
}

/*
================================================= ===========
** Função de verificação de itens
** Função para verificar item no banco de dados [Função com parâmetros]
** $select = o item a ser selecionado [Exemplo: usuário, item, categoria]
** $from = a tabela para selecionar [Exemplo: usuários, itens, categorias]
** $value = O valor do select [Exemplo: Ossama, Box, Electronics]
================================================= ============

*/

function checkItem($select, $from, $value)
{
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;
}

/*
=============================================
FUNÇÃO DE ENTRADA DE TESTE, É USADA PARA HIGIENIZAR AS ENTRADAS DO USUÁRIO
E REMOVA CARGAS SUSPEITAS e remova espaços extras
=============================================

*/

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}




