<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();


if($login->isUserLoged()) {

    $jak = true;
    if (isset($iduzivatele) && !empty($iduzivatele)) {

        if (!empty($db->getIduzivateleByLogin($_POST["login"]))) {

            strip_tags($_POST["jmeno"]);
            strip_tags($_POST["email"]);
            strip_tags($_POST["login"]);

            $jak &= $db->updateInfoUzivatele(intval($iduzivatele), $_POST["jmeno"], $_POST["email"], $_POST["login"]);
        } else {
            $jak = false;
        }

        if (isset($_POST["heslo_stare"]) && !empty($_POST["heslo_stare"]) && $jak) {
            $heslo_spravne = $db->getHesloByLogin($_POST["login"])[0]["heslo"];

            if (strcmp($heslo_spravne, $_POST["heslo_stare"]) == 0) {
                strip_tags($_POST["heslo_nove"]);
                $jak &= $db->updateHeslo(intval($iduzivatele), $_POST["heslo_nove"]);
            } else {
                $jak = false;
            }
        }

        if ($jak) {
            $login->logout();
            $login->login($_POST["login"]);
        }

    } else {
        $jak = false;
    }

    echo $jak;

}
?>