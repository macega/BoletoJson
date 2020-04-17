<?php require_once './header.phtml'; ?>
<div class='inner-screen'>
    <div class='formt'>
        <?php
        require_once ROOT_PATH . '\model\Cliente.php';
        try {
            $cliente = new Cliente(filter_input(INPUT_GET, "cpf", FILTER_DEFAULT));
            if (isset($cliente->titulos) &&
                    !empty($cliente->getNomeCliente())) {
                echo '<h2>Olá ' . $cliente->getNomeCliente() . ' tudo bem com você?</h2>';
                include './titulosHeader.phtml';
                foreach ($cliente->titulos as $titulo) {
                    if ($titulo->isVisibile()) {
                        $iten = array(
                            'numeroTitulo' => $titulo->getNrTitulo(),
                            'parcela' => $titulo->getParcela() . '/' . $titulo->getTotalParcela(),
                            'valorTitulo' => 'R$ ' . number_format($titulo->getVlrTitulo(), 2, ',', '.'),
                            'dataVencimento' => $titulo->getDtVencimento(),
                            'action' => $titulo->getAction()
                        );
                        include './titulosItens.phtml';
                    }
                }
                include_once './titulosFooter.phtml';
            } else {
                echo '<h2>' . $cliente->getMensagen() . '</h2>';
            }
        } catch (InvalidCpfException $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        } catch (Exception $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        }
        ?>
        <br><a href='titulosConsulta.php'>Consultar novo CPF</a>
    </div>
</div>
<?php require_once './footer.phtml'; ?>
