<?php
//////////////////////////////////////////////////////////////////
/////////////////  Globalni nastaveni aplikace ///////////////////
//////////////////////////////////////////////////////////////////

//// Pripojeni k databazi ////
/** Adresa serveru. */
define("DB_SERVER","localhost");
/** Nazev databaze. */
define("DB_NAME","semestral");
/** Uzivatel databaze. */
define("DB_USER","root");
/** Heslo uzivatele databaze */
define("DB_PASS","");


//// Nazvy tabulek v DB ////
/** Tabulka s pohadkami. */
define("TABLE_CLANKY", "clanky");
/** Tabulka s uzivateli. */
define("TABLE_UZIVATELE", "uzivatele");
/** Tabulka s pravy */
define("TABLE_PRAVA", "prava");
/** Tabulka s pravy uzivatelu*/
define("TABLE_UZIVPRAVA", "prava_to_uzivatele");
/** Tabulka s hodnocenim*/
define("TABLE_HODNOCENI", "hodnoceni");

//title webu
const WEB_TITLE = "MTBIKES";


const DIRECTORY_CONTROLLERS = "Controllers";
const DIRECTORY_MODELS = "Models";
const DIRECTORY_VIEWS = "Views";
const DIRECTORY_AJAX = "ajax";

/** Dostupne webove stranky. */
const WEB_PAGES = array(
    // uvodni stranka
    "home" => array("file_name" => "HomeController.class.php",
                    "class_name" => "HomeController",
        "title" => "MTBIKES"),

    // editace profilu uzivatele
    "profil" => array("file_name" => "ProfilController.class.php",
                      "class_name" => "ProfilController",
        "title" => ""),

    // seznam profilu uzivatelu
    "uzivatele" => array("file_name" => "UzivateleController.class.php",
                         "class_name" => "UzivateleController",
        "title" => "Uživatelé"),

    // editace profilu uzivatele
    "autori" => array("file_name" => "AutoriController.class.php",
                      "class_name" => "AutoriController",
        "title" => "Autoři"),

    "prava" => array("file_name" => "PravaController.class.php",
            "class_name" => "PravaController",
            "title" => "Práva" )
    );

/** Klic defaultni webove stranky. */
const DEFAULT_WEB_PAGE_KEY = "home";

require_once (DIRECTORY_MODELS ."/LoginModel.class.php");
$login = new LoginModel();
require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
$db = new DatabaseModel();

?>