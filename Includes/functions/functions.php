<?php

/*
    Título da função que imprime o título da página caso a página tenha a variável $pageTitle e imprime o título padrão para outras páginas
*/
function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle . " | Barbearia Tchelos";
    } else {
        echo "Barbearia Tchelos";
    }
}

/*
    Essa função retorna o número de itens em uma tabela fornecida
*/

function countItems($item, $table)
{
    global $con;
    $stat_ = $con->prepare("SELECT COUNT($item) FROM $table");
    $stat_->execute();

    return $stat_->fetchColumn();
}

/*

** Função de Verificação de Itens
** Função para Verificar um Item no Banco de Dados [Função com Parâmetros]
** $select = o item a ser selecionado [Exemplo: usuário, item, categoria]
** $from = a tabela para selecionar de [Exemplo: usuários, itens, categorias]
** $value = O valor da seleção [Exemplo: Ossama, Caixa, Eletrônicos]

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
  ==============================================
  FUNÇÃO DE ENTRADA DE TESTE, USADA PARA SANALIZAR ENTRADAS DE USUÁRIO
  E REMOVER CARACTERES SUSPEITOS e Remover Espaços Extras
  ==============================================

*/

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
