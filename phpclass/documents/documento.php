<?php

include_once('../documents/Csv.php');

$csv = new Csv();


$arquivo = $_FILES['csv'];

if (!empty($arquivo) && $arquivo['type'] == 'text/csv') {

    $caminho_atual = (__DIR__);

    $nome_arquivo = rand().'.csv';
    $caminho = $caminho_atual.'/'.$nome_arquivo;

    if (move_uploaded_file($arquivo['tmp_name'], $caminho)){
        $csv->getDadosCsvToArray($nome_arquivo);
    } else {
        $_GET['erro'] = 'falha ao enviar o aquivo';
        return header("Location: /");
    }


    return header("Location: /lista.php");
}

return header("Location: /?erro=falha ao enviar o aquivo");


//$csv->getDadosCsvToArray();
//
//header("Location: /lista.php");
