<?php

include_once('../db/Conn.php');

$conn = new Conn();

//remove dados da tabela dados
$conn->conn->query("TRUNCATE TABLE dados");

$caminho = __DIR__.'/../documents/*.csv';

foreach (glob($caminho) as $filename) {
//    deleta arquivos csv
    unlink($filename);
}

return true;