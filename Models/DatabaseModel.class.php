<?php

/**
 * Trida spravujici databazi.
 */
class DatabaseModel {

    /** @var PDO $pdo  Objekt pracujici s databazi prostrednictvim PDO. */
    private $pdo;

    /**
     * Inicializace pripojeni k databazi.
     */
    public function __construct() {
        // inicializace DB
        $this->pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
        // vynuceni kodovani UTF-8
        $this->pdo->exec("set names utf8");
    }

    public function getClanky(int $idclanky = 0, int $schvaleno = -1, int $orderByFilter = 0):array {
        // pripravim dotaz
        $orderBy= "ORDER BY ";
        if($orderByFilter != 0)
            $orderBy .= TABLE_HODNOCENI.".pocet_hvezd desc";
        else
            $orderBy .= TABLE_CLANKY.".datumcas_vlozeni desc";


        if($schvaleno!=-1){
            $where[] = TABLE_CLANKY.".schvaleno = '$schvaleno'";
        }
        if($idclanky!=0){
            $where[] = TABLE_CLANKY.".idclanky='$idclanky'";
        }
        if(!empty($where))
            $whereSQL = "WHERE ".join(" and ",$where);

        $sql = "SELECT ".TABLE_CLANKY.".idclanky,
                        ".TABLE_CLANKY.".titulek,
                        ".TABLE_CLANKY.".datumcas_vlozeni,
                        ".TABLE_CLANKY.".iduzivatele as autor,
                        ".TABLE_CLANKY.".obrazek,
                        ".TABLE_CLANKY.".schvaleno,
                        ".TABLE_HODNOCENI.".pocet_hvezd
                  FROM ".TABLE_CLANKY." 
                    left join ".TABLE_HODNOCENI." 
                        on ".TABLE_CLANKY.".idclanky = ".TABLE_HODNOCENI.".idclanky
                  $whereSQL      
                  $orderBy";
        //echo $sql;

        // provedu a vysledek vratim jako pole
        // protoze je o uzkazku, tak netestuju, ze bylo neco vraceno
        return $this->pdo->query($sql)->fetchAll();
    }

    public function insertNewUser(string $jmeno, string $heslo, string $email, string $login){

        if( empty($this->getIduzivateleByLogin($login)) ){
            $sql = "INSERT INTO " . TABLE_UZIVATELE . " (jmeno, heslo, login, email) VALUES ('$jmeno', '$heslo', '$login', '$email')";
            if($this->pdo->exec($sql) === false){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }

    }

    public function getHesloByLogin(string $login){
        $sql = "SELECT heslo FROM ".TABLE_UZIVATELE." WHERE login = '$login';";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getPrava(){
        $sql = "SELECT idprava, pravo, popis FROM ".TABLE_PRAVA;
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getPravaByLogin(string $login){
        $sql = "SELECT  ".TABLE_PRAVA.".idprava, 
                        ".TABLE_PRAVA.".pravo, 
                        ".TABLE_PRAVA.".popis 
                FROM ".TABLE_UZIVPRAVA." 
                    left join ".TABLE_UZIVATELE."
                        on ".TABLE_UZIVPRAVA.".iduzivatele = ".TABLE_UZIVATELE.".iduzivatele
                    left join ".TABLE_PRAVA."
                        on ".TABLE_UZIVPRAVA.".idprava = ".TABLE_PRAVA.".idprava
                WHERE ".TABLE_UZIVATELE.".login = '$login'";

        //echo $sql;
        return $this->pdo->query($sql)->fetchAll();
    }

    public function getUzivateleInfo(int $iduzivatele = 0){
        $uzivatele_return = array();

        $sql = "SELECT ".TABLE_UZIVATELE.".iduzivatele,
                      ".TABLE_UZIVATELE.".jmeno,
                       ".TABLE_UZIVATELE.".login,
                       ".TABLE_UZIVATELE.".email
                FROM ".TABLE_UZIVATELE;
        if(!empty($iduzivatele)){
            $sql.= " WHERE ".TABLE_UZIVATELE.".iduzivatele = '$iduzivatele'";
        }

        $sql.= " ORDER BY ".TABLE_UZIVATELE.".iduzivatele";

        //echo $sql;
        $uzivatele = $this->pdo->query($sql)->fetchAll();

        if(!empty($uzivatele)){
            foreach ($uzivatele as $uzivatel){
                $prava = $this->getPravaByLogin($uzivatel["login"]);
                $prava_uzivatele = "";
                if(!empty($prava)){
                    foreach ($prava as $pravo){
                        $prava_uzivatele .= $pravo["pravo"]."(".$pravo["idprava"].") ";
                    }
                }
                $uzivatel["prava"] = $prava_uzivatele;
                $uzivatele_return[] = $uzivatel;
            }
        }

        return $uzivatele_return;
    }

    public function setPravo(int $iduzivatele, int $idprava, int $hodnota){
        $jak = true;

        $sql = "DELETE FROM ".TABLE_UZIVPRAVA." WHERE idprava='$idprava' and iduzivatele='$iduzivatele'";
        if($this->pdo->exec($sql) === false){
            $jak = false;
        }else{
            $jak = true;
        }

        if($hodnota == 1){
            $sqlInsert= "INSERT INTO ".TABLE_UZIVPRAVA." (idprava, iduzivatele) VALUES ('$idprava', '$iduzivatele') 
                            on DUPLICATE key update
                                idprava = '$idprava',
                                iduzivatele = '$iduzivatele'";
            //echo "<br>$sql<br>";
            if($this->pdo->exec($sqlInsert) === false){
                $jak &= false;
            }else{
                $jak &= true;
            }
        }

        return $jak;
    }

    public function getIduzivateleByLogin(string $login){
        $sql = "SELECT iduzivatele FROM ".TABLE_UZIVATELE." WHERE login = '$login'";
        //echo $sql;
        return $this->pdo->query($sql)->fetchAll()[0]['iduzivatele'];
    }

    public function updateInfoUzivatele(int $iduzivatele, string $jmeno, string $email, string $login)
    {
        $sql = "UPDATE ".TABLE_UZIVATELE." 
                SET jmeno = '$jmeno', 
                    email = '$email',
                    login = '$login'
                WHERE iduzivatele = '$iduzivatele'";

        if($this->pdo->exec($sql) === false){
            return false;
        }else{
            return true;
        }
    }

    public function updateHeslo(int $iduzivatele, string $heslo_nove){
        $sql = "UPDATE ".TABLE_UZIVATELE." 
                SET heslo = '$heslo_nove'
                WHERE iduzivatele = '$iduzivatele'";
        if($this->pdo->exec($sql) === false){
            return false;
        }else{
            return true;
        }
    }
    
}

?>