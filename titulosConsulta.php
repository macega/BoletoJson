<?php require_once './header.phtml'; ?>
<div class="inner-screen">
    <div class="form">
        <form action="titulosLista.php">  
            <h1><?php
                if (!PRODUCAO) {
                    echo '(Teste) ';
                }
                ?>Digite seu CPF para visualizar títulos em aberto</h1>
            <input type="text" name="cpf" id="cpf" data-mask="000.000.000-00" data-mask-selectonfocus="true" placeholder="Digite seu CPF" <?php
                   if (!PRODUCAO) {
                       echo 'value="017.709.672-14"';
                   }
                   ?>/>
            <input type="submit" value="<?php
            if (!PRODUCAO) {
                echo '(Teste) ';
            }
            ?>Procurar títulos em aberto"/>
        </form>
        <h6>Qualquer dúvida ligue para <?PHP echo FONE_DUVIDAS; ?></h6>
        <?php echo!PRODUCAO ? '<a href="info.php">info</a>' : ''; ?>
        <br>
    </div>
</div>
<!--<div class="inner-screen2">
    <div>
        <p class="listText">Formas de pagamento do Boleto</p>
    </div>
    <ul class="iconList">
        <li class="fristLI" >
            <img src="img/mobile.svg">
            <p>Se você possui uma conta em algum banco, utilize o aplicativo ou site do seu banco, este é o meio mais simples e facil.</p></li>
        <li class="fristLI">
            <img src="img/caixa-eletronico.svg">
            <p>Se você possui o cartão do seu banco, poderá ir ao caixa eletrônico do seu banco ou aos caixas 24hrs para fazer o pagamento do boleto.</p>
        </li>
    </ul>
</div>-->
<?php require_once './footer.phtml'; ?>
