<?php
ini_set('user_agent', 'PHP');
header('Content-Type: text/html; charset=utf-8');
//header('Location: titulosConsulta.php');
//header('Location: https://bit.ly/34q5kna');
define('ROOT_PATH', dirname(__FILE__));
define('PRODUCAO', FALSE);
define('API', 'http://www.grupomilla.com.br:3518/datasnap/Rest/TServerMethods1');
define('URL_CONSULTAR_TITULOS_CPF', API.'/ConsultaTitulosCPF');
define('URL_PDF_BOLETO',  API.'/pdfboleto');
define('FOLDER_DOWNLOAD', 'download/');
define('PHOENIX_EMPRESSA', '1'); // empressa cadastrada no phoenix( sempre 1)
define('PHOENIX_BOLETO', '299'); // configuracao do boleto cadastrado no phoenix
define('CODIGO_BANCO', 104); // CODIGO DO BANCO DO BOLETO (CAIXA ECONOMICA 104)
define('VALOR_PERMITIDO_BOLETO', 50,00); // CONDICAO PARA IMPRESSAO DE BOLETO
define('FONE_COBRANCA', '(69)3217-2628'); // TELEFONE DE COBRANCA
define('FONE_DUVIDAS', '(69)3217-2628'); // TELEFONE PARA DUVIDAS

