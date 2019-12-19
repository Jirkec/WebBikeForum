<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();

    $jak = 0;
    if (isset($_POST["idclanky"]) && !empty($_POST["idclanky"])) {
        $jak = $db->updateClanek("", "", "", $_POST["idclanky"], 1);
    } else {
        $jak = 0;
    }

    echo $jak;

?>