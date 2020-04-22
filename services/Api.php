<?php

require_once ROOT_PATH . '\inferface\ExceptionInterface.php';
require_once ROOT_PATH . '\services\testePHPClass.php';

class apiException extends \Exception implements ExceptionInterface {

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // garante que tudo está corretamente inicializado
        parent::__construct(MENSAGEN_ERRO_GERAL . '; <br>' . $message, $code, $previous);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}

/**
 * 
 * Respostas de informação (100-199),
 * Respostas de sucesso (200-299),
 * Redirecionamentos (300-399)
 * Erros do cliente (400-499)
 * Erros do servidor (500-599).
 */
class Api {

    public static function getJson($url) {

        $curl = curl_init($url);

        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 600";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 22);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 77);

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $httpCode = $info['http_code'];

        switch ($httpCode) {
            case 0:
                throw new apiException('O servidor não responde. Por favor, tente novamente mais tarde', 0);
            case 200:
                return json_decode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            case 500:
                if (PRODUCAO) {
                    throw new apiException($response, 500);
                } else {
                    $teste = new testePHPClass();
                    return json_decode(
                            substr($url, 64, 18) == 'ConsultaTitulosCPF' ?
                            $teste->getConsultaTitulosCPF() :
                            $teste->getPdfboleto(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                }
            case 401:
                return NULL;
            case 400:
                return NULL;
            default:
                throw new apiException($response, $httpCode);
        }
    }

}
