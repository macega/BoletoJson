<?php

/**
 * Description of Boleto
 *
 * @author julia
 */
class Boleto {

    protected $byte;
    protected $size;
    protected $fileName;
    protected $linhaDigitavel;

    public function __construct($params = array()) {
        $this->byte = $params[0];
        $this->size = $params[1];
        $this->fileName = FOLDER_DOWNLOAD . md5($params[2]) . '.pdf';
        $this->linhaDigitavel = $params[3];
        file_put_contents($this->getFileName(), $this->getContent());
    }

    function getContent() {
        $string = null;
        foreach (explode(',', $this->byte) as $chr) {
            $string .= chr($chr);
        }
        return $string;
    }

    function getSize() {
        return $this->size;
    }

    function getFileName() {
        return $this->fileName;
    }

    function getLinhaDigitavel() {
        return $this->linhaDigitavel;
    }

}
