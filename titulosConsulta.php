<?php require_once './header.phtml'; ?>
<div class="inner-screen">
    <div class="form">
        <form action="titulosLista.php">  
            <h1><?php
                if (!PRODUCAO) {
                    echo '(Teste) ';
                }
                ?>Digite seu CPF para visualizar títulos em aberto</h1>
            <input class="inputTextCPF" type="text" name="cpf" id="cpf" data-mask="000.000.000-00" data-mask-selectonfocus="true" placeholder="Digite seu CPF" <?php
            if (!PRODUCAO) {
                echo 'value="017.709.672-14"';
            }
            ?>/>
            <input class="buttonConsulta" type="submit" value="<?php
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
<?php require_once './fileManager.php';
      require_once './footer.phtml'; ?>
