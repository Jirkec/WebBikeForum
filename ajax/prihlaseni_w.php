<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();


    $jak = 0;
    if(!empty($_POST["heslo"]) && !empty($_POST["login"])){
        strip_tags($_POST["heslo"]);
        strip_tags($_POST["login"]);

        $heslo_spravne = $db->getHesloByLogin($_POST["login"])[0]["heslo"];
//print_r($db->getHesloByLogin($_POST["login"]));
        if(strcmp($heslo_spravne,$_POST["heslo"])==0){
            $jak = true;
            $login->login($_POST["login"]);
        }else{
            $jak = false;
        }
        //echo "|$heslo_spravne| ".$_POST["heslo"];

    }else{
        $jak = false;
    }

    echo $jak;


?>