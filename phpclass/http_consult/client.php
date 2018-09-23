<?php

include_once('../db/Conn.php');
include_once('../clients/Clientes.php');

//verifica se o parâmetro cllients exite e se existir faz a consulta
if (!empty($_GET['clients'])) {
    $clients = new Clientes();
    echo json_encode($clients->getWhereLike('razao_social', strtoupper($_GET['clients'])));
}