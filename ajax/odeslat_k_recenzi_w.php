<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();

    $jak = 0;
    if (isset($_POST["idclanky"]) && !empty($_POST["idclanky"])
        && isset($_POST["recenzenti"]) && !empty($_POST["recenzenti"])
        && isset($_POST["iduzivatele_predal"]) && !empty($_POST["iduzivatele_predal"])) {
        $jak = $db->poslatRecenzetum(intval($_POST["idclanky"]), $_POST["recenzenti"], intval($_POST["iduzivatele_predal"]));
    } else {
        $jak = 0;
    }

    echo $jak;


?>