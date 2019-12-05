<?php 

class LoginModel{

    private $ses;
    private $dName = "jmeno";
    private $dDate = "datum";

    public function __construct(){
        include_once("SessionModel.class.php");
        // inicializuju objekt sessny
        $this->ses = new SessionModel;
    }

    public function isUserLoged(){
        return $this->ses->isSessionSet($this->dName);
    }

    public function login($login){
        $this->ses->addSession($this->dName,$login); // jmeno
        $this->ses->addSession($this->dDate,date("d. m. Y, G:m:s"));
    }

    public function logout(){
        $this->ses->removeSession($this->dName);
        $this->ses->removeSession($this->dDate);
    }

    public function getUserLogin(){
        return $this->ses->readSession($this->dName);
    }

    public function getUserInfo(){
        $name = $this->ses->readSession($this->dName);
        $date = $this->ses->readSession($this->dDate);
        return "Jméno: $name<br>Datum: $date<br>";
    }
    
}
?>