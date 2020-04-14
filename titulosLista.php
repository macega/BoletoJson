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
                include './titulosHeader.phtml';
                $itens;
                foreach ($cliente->titulos as $titulo) {
                    if ($titulo->isVisibile()) {
                        $iten = array(
                            'numeroTitulo' => $titulo->getNrTitulo(),
                            'parcela' => $titulo->getParcela() . '/' . $titulo->getTotalParcela(),
                            'valorTitulo' => 'R$ ' . number_format($titulo->getVlrTitulo(), 2, ',', '.'),
                            'dataVencimento' => $titulo->getDtVencimento(),
                            'action' => $titulo->getAction()
                        );
                        $itens[] = $iten;
                        include './titulosItens.phtml';
                    }
                }
                include_once './titulosFooter.phtml';
//                testes paginacao 
//                echo '<br>';
//                echo '<script> var array_titulos = [';
//                foreach ($itens as $value) {
//                    echo '[';
//                    foreach ($value as $v) {
//                        echo '"' . str_replace(',', '.', $v) . '", ';
//                    }
//                    echo ']';
//                }
//                var i, array_titulos, string_array;
//                string_array =;
//                array_titulos = string_array . split("||");
//                for (i in array_titulos) {
//                   alert(array_titulos[i]);
//                }
//                echo ']</script>';
//                testes paginacao 
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
