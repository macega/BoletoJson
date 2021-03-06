<?php require_once './header.phtml'; ?>
<div class='inner-screen'>
    <div class='formt'>
        <?php
        $cpf = filter_input(INPUT_GET, "cpf", FILTER_DEFAULT);
        $pagina = filter_input(INPUT_GET, "pagina", FILTER_DEFAULT);
        require_once ROOT_PATH . '\model\Cliente.php';
        try {
            $cliente = new Cliente($cpf);
            if (isset($cliente->titulos) &&
                    !empty($cliente->getNomeCliente())) {
                $itens_por_pagina = 10;
                $num_total = sizeof($cliente->titulos);
                $num_paginas = ceil($num_total / $itens_por_pagina);
                if ($num_total > 0) {
                    echo '<h2>Olá ' . $cliente->getNomeCliente() . ' tudo bem com você?</h2>';
                    include './titulosHeader.phtml';
                    for ($i = $pagina * $itens_por_pagina; $i < $num_total && $i < ($pagina + 1) * $itens_por_pagina; $i++) {
                        if ($cliente->titulos[$i]->isVisibile()) {
                            $iten = array(
                                'numeroTitulo' => $cliente->titulos[$i]->getNrTitulo(),
                                'parcela' => $cliente->titulos[$i]->getParcela() . '/' . $cliente->titulos[$i]->getTotalParcela(),
                                'valorTitulo' => 'R$ ' . number_format($cliente->titulos[$i]->getVlrTitulo(), 2, ',', '.'),
                                'dataVencimento' => $cliente->titulos[$i]->getDtVencimento(),
                                'action' => $cliente->titulos[$i]->getAction()
                            );
                            include './titulosItens.phtml';
                        }
                    }
                    include_once './titulosFooter.phtml';
                }
            } else {
                echo '<h2>' . $cliente->getMensagen() . '</h2>';
            }
        } catch (InvalidCpfException $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        } catch (Exception $e) {
            echo '<h2>' . $e->getMessage() . '<h2>';
        }
        ?>
        <div class="divButtonNovaConsulta">
            <form action="titulosConsulta.php">
                <input class="buttonNovaConsulta" type="submit" value="Consultar novo CPF" />
            </form>
        </div>
        <br>
    </div>
</div>
<?php require_once './footer.phtml'; ?>
