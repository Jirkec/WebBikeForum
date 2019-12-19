<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();

if($login->isUserLoged()) {
    $jak = 0;
    if (!empty($_POST["pocet_hvezd"]) && !empty($_POST["komentar"]) && !empty($_POST["idclanky"]) && !empty($_POST["iduzivatele"])) {
        strip_tags($_POST["pocet_hvezd"]);
        strip_tags($_POST["komentar"]);
        $jak = $db->updateRecenze($_POST["pocet_hvezd"], $_POST["komentar"], $_POST["idclanky"], $_POST["iduzivatele"]);
    } else {
        $jak = 0;
    }

    echo $jak;
}

?>