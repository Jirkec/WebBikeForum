<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();


    $jak = 0;
    if(!empty($_POST["jmeno"]) && !empty($_POST["heslo"]) && !empty($_POST["email"]) && !empty($_POST["login"])){
         $jak = $db->insertNewUser($_POST["jmeno"], $_POST["heslo"], $_POST["email"], $_POST["login"]);
        if($jak)
            $login->login($_POST["login"]);


    }else{
        $jak = 0;
    }

    echo $jak;


?>