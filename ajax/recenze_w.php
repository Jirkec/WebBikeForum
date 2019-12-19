<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();


    $jak = 0;
    if(!empty($_POST["pocet_hvezd"]) && !empty($_POST["komentar"]) && !empty($_POST["idclanky"]) && !empty($_POST["iduzivatele"])){
         $jak = $db->updateClanek($_POST["pocet_hvezd"], $_POST["komentar"], $_POST["idclanky"], $_POST["iduzivatele"]);
    }else{
        $jak = 0;
    }

    echo $jak;


?>