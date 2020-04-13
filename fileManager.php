<?php
$diretorio = dir(FOLDER_DOWNLOAD);
while ($arquivo = $diretorio->read()) {
    switch ($arquivo) {
        case '.':
            break;
        case '..':
            break;
        default:
            if (filectime(FOLDER_DOWNLOAD . $arquivo) <= strtotime('-3 day')) {
                unlink(FOLDER_DOWNLOAD . $arquivo);
            } 
            break;
    }
} $diretorio->close();
