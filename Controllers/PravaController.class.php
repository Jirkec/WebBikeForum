<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class PravaController implements IController {

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
            $tplData['prava'] = $this->db->getPrava();
        }

        //$tplData['testprep'] = $this->db->testPrepered();

        ob_start();
        require(DIRECTORY_VIEWS ."/PravaTemplate.tpl.php");
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>