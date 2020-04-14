<?php

require_once ROOT_PATH . '\inferface\ExceptionInterface.php';

class apiTimeOutException extends \Exception implements ExceptionInterface {

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}

// Maximum number of concurrent connections
class apiMaximumConnectionsException extends \Exception implements ExceptionInterface {

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }

    // personaliza a apresentação do objeto como string
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}

class apiException extends \Exception implements ExceptionInterface {

    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
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
                throw new apiTimeOutException('o servidor encontrou um erro. Por favor, tente novamente mais tarde', 799);
            }
        } else {
            $info = curl_getinfo($client);
            $httpCode = $info['http_code'];
            curl_close($client);
            if ($httpCode == 500) {
                throw new apiMaximumConnectionsException('Número máximo de conexões simultâneas excedido. Por favor, tente novamente mais tarde', 500);
            } else {
                return json_decode($response, true);
            }
        }
        return '';
    }

}
