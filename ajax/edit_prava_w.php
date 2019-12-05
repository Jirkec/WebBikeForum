<?php
$cesta = "../";
    require_once $cesta."settings.inc.php";

    require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
    $db = new DatabaseModel();

    require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
    $login = new LoginModel();



    $jak = true;
    if(!empty($iduzivatele)){

        if(!isset($adminCheck))
            $adminCheck = 0;
        if(!isset($autorCheck))
            $autorCheck = 0;
        if(!isset($recenzentCheck))
            $recenzentCheck = 0;

        //echo "$adminCheck $autorCheck $recenzentCheck |";
        $jak &= $db->setPravo($iduzivatele, 1, $adminCheck);
        $jak &= $db->setPravo($iduzivatele, 2, $autorCheck);
        $jak &= $db->setPravo($iduzivatele, 3, $recenzentCheck);

    }else{
        $jak = false;
    }

    echo $jak;


?>