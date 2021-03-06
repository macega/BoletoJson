<?php

require_once ROOT_PATH . '\model\Titulos.php';
require_once ROOT_PATH . '\inferface\ExceptionInterface.php';
require_once ROOT_PATH . '\services\Api.php';

class InvalidCpfException extends \InvalidArgumentException implements ExceptionInterface {

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

class Cliente {

    var $cpf;
    var $titulos;
    var $totalTitulos;
    protected $mensagen = 'Não foram encontrados registros para o cpf informado.';
    protected $nomeCliente = '';

    /**
     * Cpf constructor.
     * @param string $cpf
     */
    public function __construct($cpf) {
        $this->setCpf($cpf);
        if ($this->validate() === false) {
            throw new InvalidCpfException('CPF informado inválido', 788);
        }
        $this->setTitulos();
        if (empty($this->getTitulos()) || empty(current($this->getTitulos())->getNome_Cliente())) {
        } else {
            $this->setNomeCliente(current($this->getTitulos())->getNome_Cliente());
        }
    }

    function setMensagen($mensagen) {
        $this->mensagen = $mensagen;
    }

    function setNomeCliente($nomeCliente) {
        if (!empty($nomeCliente)) {
            $this->nomeCliente = $nomeCliente;
        }
    }

    function getNomeCliente() {
        return $this->nomeCliente;
    }

    function getMensagen() {
        return $this->mensagen;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTitulos() {
        return $this->titulos;
    }

    function getTotalTitulos() {
        return $this->totalTitulos;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setTitulos() {
        try {
            $result = Api::getJson(URL_CONSULTAR_TITULOS_CPF . '/' . $this->getCpf());
            if (isset($result) && !empty($result)) {
                $soma = [0.0];
                foreach ($result as $value) {
                    $titulo = new Titulos($value);
                    $this->titulos[] = $titulo;
                    $soma[] = $titulo->getVlrTitulo();
                }
                $this->totalTitulos = array_sum($soma);
            }
        } catch (Exception $e) {
            $this->setMensagen($e->getMessage());
        }
    }

    private function validate() {
        // Extrair somente os números
        $this->cpf = preg_replace('/[^0-9]/is', '', $this->cpf);
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($this->cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $this->cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

}
