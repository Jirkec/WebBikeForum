<?php
// nactu rozhrani kontroleru
require_once(DIRECTORY_CONTROLLERS."/IController.interface.php");
require_once "functions.inc.php";

/**
 * Ovladac zajistujici vypsani uvodni stranky.
 */
class HomeController implements IController {

    /** @var DatabaseModel $db  Sprava databaze. */
    private $db;
    private $login;
    private $iduzivatele;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace prace s DB
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $this->db = new DatabaseModel();
        require_once (DIRECTORY_MODELS ."/LoginModel.class.php");
        $this->login = new LoginModel();

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

        if($this->login->isUserLoged()) {
            global $schvaleno;
            if (aktualni_prava(array(1), $this->db, $this->login) && isset($schvaleno) && $schvaleno == 0) {
                $schvaleno = 0;
            } else {
                $schvaleno = 1;
            }

            global $hodnoceno;
            if (aktualni_prava(array(1), $this->db, $this->login) && isset($hodnoceno) && $hodnoceno == 0) {
                $hodnoceno = 0;
                $schvaleno = -1;
            } else {
                $hodnoceno = -1;
            }

            global $moje;
            if (aktualni_prava(array(1), $this->db, $this->login) && isset($moje) && $moje == 1 && $this->iduzivatele != -1) {
                $moje = $this->iduzivatele;
                $schvaleno = -1;
                $hodnoceno = -1;
            } else {
                $moje = -1;
            }

            global $recenze;
            if (aktualni_prava(array(1), $this->db, $this->login) && isset($recenze) && $recenze == 1 && $this->iduzivatele != -1) {
                $recenze = $this->iduzivatele;
                $schvaleno = -1;
                $hodnoceno = -1;
                $moje = -1;
            } else {
                $recenze = -1;
            }

        }else{
            $schvaleno = 1;
            $moje = -1;
            $recenze = -1;
            $hodnoceno = -1;
        }

        $tplData['clanky'] = $this->db->getClanky(-1, $schvaleno, $hodnoceno, $moje, $recenze);


        //// vypsani prislusne sablony
        // zapnu output buffer pro odchyceni vypisu sablony
        ob_start();
        // pripojim sablonu, cimz ji i vykonam
        require(DIRECTORY_VIEWS ."/HomeTemplate.tpl.php");
        // ziskam obsah output bufferu, tj. vypsanou sablonu
        $obsah = ob_get_clean();

        // vratim sablonu naplnenou daty
        return $obsah;
    }

}

?>