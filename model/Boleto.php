<?php

class Boleto {

    protected $byte;
    protected $size;
    protected $fileName;
    protected $linhaDigitavel;

    public function __construct($params = array()) {
        try {
            if (!empty($params) &&
                    is_array($params) &&
                    !array_keys($params)[0] == 'error') {
                $this->byte = $params[0];
                $this->size = $params[1];
                $this->fileName = md5($params[2]) . '.pdf';
                $this->linhaDigitavel = $params[3];
                if (!is_dir(FOLDER_DOWNLOAD)) {
                    mkdir(FOLDER_DOWNLOAD, 0666, true);
                }
                file_put_contents(FOLDER_DOWNLOAD . $this->getFileName(), $this->getContent());
            }
        } catch (Exception $ex) {
        }
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
