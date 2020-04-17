<?php

ini_set('user_agent', 'PHP');
header('Content-Type: text/html; charset=utf-8');
//header('Location: titulosConsulta.php');
//header('Location: https://bit.ly/34q5kna');
define('ROOT_PATH', dirname(__FILE__));
define('PRODUCAO', FALSE);

/**
 * API REST 
 */
define('API', 'http://www.grupomilla.com.br:3518/datasnap/Rest/TServerMethods1');
define('URL_CONSULTAR_TITULOS_CPF', API . '/ConsultaTitulosCPF');
define('URL_PDF_BOLETO', API . '/pdfboleto');
define('FOLDER_DOWNLOAD', 'download/');

/**
 * CONFIGURACAO DO BOLETO
 */
define('PHOENIX_EMPRESSA', '1'); // empressa cadastrada no phoenix( sempre 1 )
define('PHOENIX_BOLETO', '299'); // configuracao do boleto cadastrado no phoenix
define('CODIGO_BANCO', 104); // codigo do banco para os boletos (CAIXA ECONOMICA 104)

define('FONE_COBRANCA', '(69)3217-2628'); // telefone de cobrança 
define('FONE_DUVIDAS', '(69)3217-2628'); // telefone para duvidas
define('VALOR_MINIMO_BOLETO', 50.00); // valor minimo do boleto permitido
define('MENSAGEN_ERRO_GERAL', 'Olá, tudo bem? temos um problema com o servidor entre em contato com a cobrança '.FONE_COBRANCA);

/**
 * Aviso de titulos 
 */
define('AVISO_BOLETO_VALOR_MINIMO', 'Valor minimo do boleto R$' . number_format(VALOR_MINIMO_BOLETO, 2, ',', '.') . '; Fone cobrança ' . FONE_COBRANCA);
define('AVISO_FLG_PERMITE_EMISSAO_BOLETO', 'Opção de boleto nao permitido ' . FONE_COBRANCA);
define('AVISO_BOLETO_PORTADOR_999', 'Aviso Portador 999');
define('AVISO_BOLETO_PORTADOR_299', 'Aviso Portador 299');
define('AVISO_BOLETO_PORTADOR_799', 'Aviso Portador 799');
define('AVISO_BOLETO_PORTADOR_1599', 'Aviso Portador 1599');
define('AVISO_BOLETO_PORTADOR_1899', 'Aviso Portador 1899');
define('AVISO_BOLETO_PORTADOR_1999', 'Aviso Portador 1999');
define('AVISO_BOLETO_PORTADOR_1199', 'Aviso Portador 1199');