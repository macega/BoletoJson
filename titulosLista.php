<?php require_once './header.phtml'; ?>
<div class='inner-screen'>
    <div class='formt'>
        <?php
        require_once ROOT_PATH . '\model\Cliente.php';
        try {
            $cliente = new Cliente(filter_input(INPUT_GET, "cpf", FILTER_DEFAULT));
            if (isset($cliente->titulos) &&
                    !empty($cliente->getNomeCliente())) {
                echo '<h2>Cliente: ' . $cliente->getNomeCliente() . '</h2>';
                include './table2.phtml';
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
                echo '</tbody></table><h1>* Títulos com mais de 60 dias de atraso, ligar para Cobrança ' . FONE_COBRANCA . '.</h1>';
            } else {
                echo '<h2>' . $cliente->getMensagen() . '</h2>';
            }
        } catch (InvalidCpfException $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        } catch (Exception $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        }
        ?>
        <a href='titulosConsulta.php'>Consultar novo CPF</a>
    </div>
</div>
<?php require_once './footer.phtml'; ?>
