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
    }

    /**
     * Vrati obsah uvodni stranky.
     * @return string               Vypis v sablone.
     */
    public function show():string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];

        $tplData['clankek'] = $this->db->getClanky($this->idclanky);

        if(array_key_exists('clankek', $tplData) && count($tplData['clankek'])>0 && !empty($tplData['clankek'][0]['idclanky'] > 0)) {
            $update = true;
        }else{
            $update = false;
        }

        if($this->login->isUserLoged() && aktualni_prava(array(2), $this->db, $this->login)){
            $editable = true;
            if($update && $tplData['clankek'][0]['autor'] != $this->db->getIduzivateleByLogin($this->login->getUserLogin()) ){
                $editable = false;
            }
        }else{
            $editable = false;
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