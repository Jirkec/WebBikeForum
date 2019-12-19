<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once "functions.inc.php";

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class ClanekController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;
    private $login;
    private $idclanky;
    private $iduzivatele;
    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct($idclanky = 0) {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
        require_once (DIRECTORY_MODELS ."/LoginModel.class.php");
        $this->login = new LoginModel();

        if(empty($idclanky)){
            $idclanky = 0;
        }
        $this->idclanky = $idclanky;

        if($this->login->isUserLoged())
            $this->iduzivatele = $this->db->getIduzivateleByLogin($this->login->getUserLogin());
        else
            $this->iduzivatele = -1;
    }

    /**
     * Vrati obsah uvodni stranky.
     * @return string               Vypis v sablone.
     */
    public function show():string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];
/*
        echo $this->idclanky;
        print_r($_POST);
        print_r($_FILES);
*/
        if(isset($_POST["ulozit"])){        //ukládání | update

            if(isset($_FILES["soubor"]) && !empty($_FILES["soubor"]["name"])){
                $nahrani = nahrani_souboru($_FILES["soubor"]);
            }else{
                $nahrani["hlaska"] = "";
                $nahrani["jak"] = true;
                $nahrani["nazev_souboru"] = "";
            }

            strip_tags($nahrani["nazev_souboru"]);
            strip_tags($_POST["titulek"]);

            if($nahrani["jak"]){
                if($this->idclanky == 0){
                    $nahrani["jak"] = $this->db->insertClanek($nahrani["nazev_souboru"], $_POST["titulek"], $_POST["text"], $this->iduzivatele);
                }else{
                    $nahrani["jak"] = $this->db->updateClanek($nahrani["nazev_souboru"], $_POST["titulek"], $_POST["text"], $this->idclanky);
                }
            }

            if($nahrani["jak"]){
                $nahrani["hlaska"] .= "Úspěšně uloženo";
            }
        }


        $tplData['clanek'] = $this->db->getClanky($this->idclanky);

        if(array_key_exists('clanek', $tplData) && !empty($tplData['clanek']) && !empty($tplData['clanek'][0]['idclanky']) ) {
            $update = true;
        }else{
            $update = false;
        }

        if($this->login->isUserLoged() && aktualni_prava(array(2), $this->db, $this->login)){
            $editable = true;
            if($update && $tplData['clanek'][0]['autor'] != $this->iduzivatele ){
                $editable = false;
            }
        }else{
            $editable = false;
        }

        $uzivatel_muze_pridat_recenci = false;
        if(!$editable && !empty($this->idclanky)){
            $uzivatel_muze_pridat_recenci = $this->db->muzeUzivatelPridatRecenzi($this->iduzivatele, $this->idclanky);

            $tplData["hodnoceni"] = $this->db->getHodnoceniByIdclanky($this->idclanky);
            $tplData['recenzenti'] = $this->db->getUzivateleByPravo(3);
        }

        ob_start();
        if($editable)
            require(DIRECTORY_VIEWS ."/ClanekEditTemplate.tpl.php");
        else
            require(DIRECTORY_VIEWS ."/ClanekDetailTemplate.tpl.php");
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>