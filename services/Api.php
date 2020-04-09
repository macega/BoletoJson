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

/**
 * Description of Api
 *
 * @author julia
 */
class Api {

    public static function getJson($url) {
//        // faz a requisicao
//        $json_data = file_get_contents($url);
//        if (false != $json_data) {
        $client = curl_init($url);

        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($client, CURLOPT_TIMEOUT, 12);
        curl_setopt($client, CURLOPT_CONNECTTIMEOUT, 77);
        $response = curl_exec($client);
        
        if ($response === false) {
            $info = curl_getinfo($client);

            if ($info['http_code'] === 0) {
                curl_close($client);
                throw new apiTimeOutException('o servidor encontrou um erro. tente novamente mais tarde', 799);
            }
        }
        curl_close($client);
        return json_decode($response, true);
//        } else {
//            throw new apiException('servidor retornou um erro', 798);
//        }
    }

}
