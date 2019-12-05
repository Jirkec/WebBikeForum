<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();


    $jak = 0;
    if($login->isUserLoged()){
        $login->logout();
        $jak = true;
    }else{
        $jak = false;
    }

    echo $jak;


?>