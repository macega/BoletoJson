<?php require_once './header.phtml'; ?>
<?php
if (!PRODUCAO) {
    echo phpinfo();
}
?>
<?php require_once './footer.phtml'; ?>