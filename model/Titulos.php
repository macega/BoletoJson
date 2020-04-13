<?php

require_once ROOT_PATH . "\model\Boleto.php";

class Titulos {

    protected $ID;
    protected $Cliente;
    protected $Nome_Cliente;
    protected $Filial;
    protected $NrTitulo;
    protected $Parcela;
    protected $TotalParcela;
    protected $DtEmissao;
    protected $DtVencimento;
    protected $Dias_Atrazo;
    protected $Descricao_FlgStatus;
    protected $Descricao_Origem;
    protected $Descricao_modalidade;
    protected $VlrTitulo;
    protected $VlrSaldo;
    protected $VlrJuro;
    protected $VlrMulta;
    protected $VlrCorrigido;
    protected $VlrAbatimento;
    protected $VlrLiquido;
    protected $VlrTaxaCobranca;
    protected $TaxaDescontoAdimplencia;
    protected $VlrDesconto_Adimplencia;
    protected $FlgPermiteNegociacao;
    protected $NrNotaFiscal;
    protected $ModeloNotaFiscal;
    protected $SerieNotaFiscal;
    protected $ChaveNota;
    protected $Linha_Digitavel;
    protected $FlgPermiteEmissaoBoleto;
    protected $Portador;
    protected $Descricao_Portador;
    protected $boleto;
    protected $visibile = true;
    protected $fileName;
    protected $action;

    public function __construct($params = array()) {
        try {
            if (!empty($params) && is_array($params)) {
                foreach ($params as $key => $value) {
                    if (method_exists($this, 'set' . $key)) {
                        $this->{'set' . $key}($value);
                    }
                }
                //$this->setVisibile();
                $this->setBoleto();
                $this->setAction();
            }
        } catch (Exception $e) {
            
        }
    }

    function getAction() {
        return $this->action;
    }

    function setAction() {
        switch ($this->getPortador()) {
            case 999:
                $this->action = AVISO_BOLETO_PORTADOR_999;
                break;
            case 299:
                $this->action = AVISO_BOLETO_PORTADOR_299;
                break;
            case 799:
                $this->action = AVISO_BOLETO_PORTADOR_799;
                break;
            case 1599:
                $this->action = AVISO_BOLETO_PORTADOR_1599;
                break;
            case 1899:
                $this->action = AVISO_BOLETO_PORTADOR_1899;
                break;
            case 1999:
                $this->action = AVISO_BOLETO_PORTADOR_1999;
                break;
            case 1199:
                $this->action = AVISO_BOLETO_PORTADOR_1199;
                break;
            default:
                if ($this->getVlrTitulo() <= VALOR_MINIMO_BOLETO) {
                    $this->action = AVISO_BOLETO_VALOR_MINIMO;
                } else if (!$this->isFlgPermiteEmissaoBoleto()) {
                    $this->action = AVISO_FLG_PERMITE_EMISSAO_BOLETO;
                } else if (empty($this->getFileName())) {
                    $this->action = '(ERRO) Não foi possível gerar o boleto';
                } else {
                    $this->action = '<input class="buttonDownload" type="submit" value=" Gerar Boleto " name="buttonDownload" onclick="window.location=' . "'" . 'download.php?pdf=1&fileName=' . $this->getFileName() . "'" . '"/>';
                    //$this->action = '<a href="#" onclick="window.location=' . "'" . 'download.php?pdf=1&fileName=' . $this->getFileName() . "'" . '">Gerar Boleto</a>';
                }
                break;
        }
    }

    function isVisibile() {
        return $this->visibile;
    }

    function getBoleto() {
        return $this->boleto;
    }

    function getFileName() {
        return $this->fileName;
    }

    function setBoleto() {
        if ($this->isFlgPermiteEmissaoBoleto() &&
                $this->isVisibile() &&
                $this->getVlrTitulo() >= VALOR_MINIMO_BOLETO) {
            $id = '/' . PHOENIX_EMPRESSA . '-'; // empressa cadastrada no phoenix(sempre 1)
            $id .= $this->getFilial() . '-'; // filial do titulo (retornado no primero metodo)
            $id .= $this->getCliente() . '-'; // codigo do cliente (retornado no primero metodo)
            $id .= $this->getNrTitulo() . '-'; // nrTitulo (retornado no primero metodo)
            $id .= $this->getParcela() . '-'; // parcela (retornado no primero metodo)
            $id .= PHOENIX_BOLETO . '-'; // configuracao do boleto cadastrado no phoenix 
            $id .= CODIGO_BANCO . '-'; // codigo do banco que ira efeturar a impressao do boleto
            $id .= $this->getFilial(); //2 filial do emissor do boleto
            $result = Api::getJson(URL_PDF_BOLETO . $id);
            if (isset($result)) {
                $boleto = new boleto($result);
                $this->boleto = $boleto;
                $this->fileName = $boleto->getFileName();
            }
        }
    }

    function getID() {
        return $this->ID;
    }

    function getCliente() {
        return $this->Cliente;
    }

    function getNome_Cliente() {
        return $this->Nome_Cliente;
    }

    function getFilial() {
        return $this->Filial;
    }

    function getNrTitulo() {
        return $this->NrTitulo;
    }

    function getParcela() {
        return $this->Parcela;
    }

    function getTotalParcela() {
        return $this->TotalParcela;
    }

    function getDtEmissao() {
        return $this->DtEmissao;
    }

    function getDtVencimento() {
        return $this->DtVencimento;
    }

    function getDias_Atrazo() {
        return $this->Dias_Atrazo;
    }

    function getDescricao_FlgStatus() {
        return $this->Descricao_FlgStatus;
    }

    function getDescricao_Origem() {
        return $this->Descricao_Origem;
    }

    function getDescricao_modalidade() {
        return $this->Descricao_modalidade;
    }

    function getVlrTitulo() {
        return $this->VlrTitulo;
    }

    function getVlrSaldo() {
        return $this->VlrSaldo;
    }

    function getVlrJuro() {
        return $this->VlrJuro;
    }

    function getVlrMulta() {
        return $this->VlrMulta;
    }

    function getVlrCorrigido() {
        return $this->VlrCorrigido;
    }

    function getVlrAbatimento() {
        return $this->VlrAbatimento;
    }

    function getVlrLiquido() {
        return $this->VlrLiquido;
    }

    function getVlrTaxaCobranca() {
        return $this->VlrTaxaCobranca;
    }

    function getTaxaDescontoAdimplencia() {
        return $this->TaxaDescontoAdimplencia;
    }

    function getVlrDesconto_Adimplencia() {
        return $this->VlrDesconto_Adimplencia;
    }

    function getFlgPermiteNegociacao() {
        return $this->FlgPermiteNegociacao;
    }

    function getNrNotaFiscal() {
        return $this->NrNotaFiscal;
    }

    function getModeloNotaFiscal() {
        return $this->ModeloNotaFiscal;
    }

    function getSerieNotaFiscal() {
        return $this->SerieNotaFiscal;
    }

    function getChaveNota() {
        return $this->ChaveNota;
    }

    function getLinha_Digitavel() {
        return $this->Linha_Digitavel;
    }

    function isFlgPermiteEmissaoBoleto() {
        return $this->FlgPermiteEmissaoBoleto == 'S' ? true : false;
    }

    function getPortador() {
        return $this->Portador;
    }

    function getDescricao_Portador() {
        return $this->Descricao_Portador;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setCliente($Cliente) {
        $this->Cliente = $Cliente;
    }

    function setNome_Cliente($Nome_Cliente) {
        $this->Nome_Cliente = $Nome_Cliente;
    }

    function setFilial($Filial) {
        $this->Filial = $Filial;
    }

    function setNrTitulo($NrTitulo) {
        $this->NrTitulo = $NrTitulo;
    }

    function setParcela($Parcela) {
        $this->Parcela = $Parcela;
    }

    function setTotalParcela($TotalParcela) {
        $this->TotalParcela = $TotalParcela;
    }

    function setDtEmissao($DtEmissao) {
        $this->DtEmissao = $DtEmissao;
    }

    function setDtVencimento($DtVencimento) {
        $this->DtVencimento = $DtVencimento;
    }

    function setDias_Atrazo($Dias_Atrazo) {
        $this->Dias_Atrazo = $Dias_Atrazo;
    }

    function setDescricao_FlgStatus($Descricao_FlgStatus) {
        $this->Descricao_FlgStatus = $Descricao_FlgStatus;
    }

    function setDescricao_Origem($Descricao_Origem) {
        $this->Descricao_Origem = $Descricao_Origem;
    }

    function setDescricao_modalidade($Descricao_modalidade) {
        $this->Descricao_modalidade = $Descricao_modalidade;
    }

    function setVlrTitulo($VlrTitulo) {
        $this->VlrTitulo = $VlrTitulo;
    }

    function setVlrSaldo($VlrSaldo) {
        $this->VlrSaldo = $VlrSaldo;
    }

    function setVlrJuro($VlrJuro) {
        $this->VlrJuro = $VlrJuro;
    }

    function setVlrMulta($VlrMulta) {
        $this->VlrMulta = $VlrMulta;
    }

    function setVlrCorrigido($VlrCorrigido) {
        $this->VlrCorrigido = $VlrCorrigido;
    }

    function setVlrAbatimento($VlrAbatimento) {
        $this->VlrAbatimento = $VlrAbatimento;
    }

    function setVlrLiquido($VlrLiquido) {
        $this->VlrLiquido = $VlrLiquido;
    }

    function setVlrTaxaCobranca($VlrTaxaCobranca) {
        $this->VlrTaxaCobranca = $VlrTaxaCobranca;
    }

    function setTaxaDescontoAdimplencia($TaxaDescontoAdimplencia) {
        $this->TaxaDescontoAdimplencia = $TaxaDescontoAdimplencia;
    }

    function setVlrDesconto_Adimplencia($VlrDesconto_Adimplencia) {
        $this->VlrDesconto_Adimplencia = $VlrDesconto_Adimplencia;
    }

    function setFlgPermiteNegociacao($FlgPermiteNegociacao) {
        $this->FlgPermiteNegociacao = $FlgPermiteNegociacao;
    }

    function setNrNotaFiscal($NrNotaFiscal) {
        $this->NrNotaFiscal = $NrNotaFiscal;
    }

    function setModeloNotaFiscal($ModeloNotaFiscal) {
        $this->ModeloNotaFiscal = $ModeloNotaFiscal;
    }

    function setSerieNotaFiscal($SerieNotaFiscal) {
        $this->SerieNotaFiscal = $SerieNotaFiscal;
    }

    function setChaveNota($ChaveNota) {
        $this->ChaveNota = $ChaveNota;
    }

    function setLinha_Digitavel($Linha_Digitavel) {
        $this->Linha_Digitavel = $Linha_Digitavel;
    }

    function setFlgPermiteEmissaoBoleto($FlgPermiteEmissaoBoleto) {
        $this->FlgPermiteEmissaoBoleto = $FlgPermiteEmissaoBoleto;
    }

    function setPortador($Portador) {
        $this->Portador = $Portador;
    }

    function setDescricao_Portador($Descricao_Portador) {
        $this->Descricao_Portador = $Descricao_Portador;
    }

}
