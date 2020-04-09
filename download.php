<?php

// FUNCAO RESPONSAVEL POR ENVIAR HEADERS AO SERVIDOR
function InputHeader($FILE) {
    header("Content-disposition: attachment; filename={$FILE}");
    header('Content-type: application/pdf');
    readfile($FILE);
}

switch (filter_input(INPUT_GET, "pdf", FILTER_DEFAULT)) {
    case "1":
        InputHeader(filter_input(INPUT_GET, "fileName", FILTER_DEFAULT));
        break;
}


