<?php

$GerParam = filter_input(INPUT_GET, "pdf", FILTER_DEFAULT);
$FileParam = filter_input(INPUT_GET, "fileName", FILTER_DEFAULT);

// FUNCAO RESPONSAVEL POR ENVIAR HEADERS AO SERVIDOR
function InputHeader($FILE) {
    header("Content-disposition: attachment; filename={$FILE}");
    header('Content-type: application/pdf');
    readfile($FILE);
}

switch ($GerParam) {
    case "1":
        InputHeader($FileParam);
        echo $GerParam;
        echo $FileParam;
        break;
}


