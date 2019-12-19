<?php
$cesta = "../";
require_once $cesta."settings.inc.php";
require_once $cesta."functions.inc.php";

require_once ($cesta.DIRECTORY_MODELS ."/DatabaseModel.class.php");
$db = new DatabaseModel();
require_once ($cesta.DIRECTORY_MODELS ."/LoginModel.class.php");
$login = new LoginModel();


if($login->isUserLoged() && aktualni_prava(array(1),$db,$login)) {

if(isset($iduzivatele)){?>
    <div id="div_edit_prava" style="display: none;">
        <form name="form_edit_prava" id="form_edit_prava">

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="adminCheck" name="adminCheck" value="1"
                    <?php
                    if(ma_uzivatel_pravo(array(1), $db, $iduzivatele)){
                        echo " checked";
                    }
                    ?>

                >
                <label class="form-check-label" for="adminCheck">Admin</label>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="autorCheck" name="autorCheck" value="1"
                    <?php
                    if(ma_uzivatel_pravo(array(2), $db, $iduzivatele)){
                        echo " checked";
                    }
                    ?>

                >
                <label class="form-check-label" for="autorCheck">Autor</label>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="recenzentCheck" name="recenzentCheck" value="1"
                    <?php
                    if(ma_uzivatel_pravo(array(3), $db, $iduzivatele)){
                        echo " checked";
                    }
                    ?>

                >
                <label class="form-check-label" for="recenzentCheck">Recenzent</label>
            </div>

        </form>
        <br><button class="btn btn-primary" onclick="odeslat_edit_prava(<?php echo $iduzivatele; ?>)">Uložit</button>
    </div>
<?php
}
}


?>