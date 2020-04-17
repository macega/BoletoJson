<?php

require_once ROOT_PATH . '\inferface\ExceptionInterface.php';

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
                throw new apiException('o servidor nao responde. Por favor, tente novamente mais tarde', 600);
            }
        } else {
            $info = curl_getinfo($client);
            //echo var_dump($info);
            $httpCode = $info['http_code'];
            curl_close($client);

            /**
             * 
             * Respostas de informação (100-199),
             * Respostas de sucesso (200-299),
             * Redirecionamentos (300-399)
             * Erros do cliente (400-499)
             * Erros do servidor (500-599).
             */
            switch ($httpCode) {
                case 200:
                    return json_decode($response, true);
                case 500:
                    throw new apiException('Erro interno do servidor. Por favor, tente novamente mais tarde', 500);
                default:
                    throw new apiException('O servidor encontrou um erro. Por favor, tente novamente mais tarde', 601);
            }
        }
        return '';
    }

}
