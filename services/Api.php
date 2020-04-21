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
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($client, CURLOPT_TIMEOUT, 12);
        curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 77);
        $response = curl_exec($client);
        if ($response === false) {
            $info = curl_getinfo($client);
            curl_close($client);
            if ($info['http_code'] === 0) {
                throw new apiException('O servidor nao responde. Por favor, tente novamente mais tarde', 600);
            }
        } else {
            $info = curl_getinfo($client);
            //echo var_dump($info);
            $httpCode = $info['http_code'];
            curl_close($client);
            switch ($httpCode) {
                case 200:
                    return json_decode($response, true);
                case 500:
                    if (PRODUCAO) {
                        throw new apiException($response, 500);
                    } else {
                        $teste = new testePHPClass();
                        return json_decode(
                                substr($url, 64, 18) == 'ConsultaTitulosCPF' ?
                                $teste->getConsultaTitulosCPF() :
                                $teste->getPdfboleto(), true);
                    }
                default:
                    throw new apiException('O servidor nao responde. Por favor, tente novamente mais tarde', 601);
            }
        }
        return '';
    }

}
