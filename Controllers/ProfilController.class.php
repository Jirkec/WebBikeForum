<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class ProfilController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;
    private $login;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
        require_once (DIRECTORY_MODELS ."/LoginModel.class.php");
        $this->login = new LoginModel();
    }

    /**
     * Vrati obsah uvodni stranky.
     * @return string               Vypis v sablone.
     */
    public function show():string {
        //// vsechna data sablony budou globalni
        global $tplData;
        $tplData = [];


        if($this->login->isUserLoged()) {
            $iduzivatele = $this->db->getIduzivateleByLogin($this->login->getUserLogin());
            //print_r($iduzivatele);
            $tplData['profil'] = $this->db->getUzivateleInfo(intval($iduzivatele));
        }
        ob_start();
        require(DIRECTORY_VIEWS ."/ProfilTemplate.tpl.php");
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>