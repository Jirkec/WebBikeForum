<?php
/////////////////////////////////////////////////////////////
/////////// Sablona pro zobrazeni uvodni stranky  ///////////
/////////////////////////////////////////////////////////////


//// vypis sablony
// urceni globalnich promennych, se kterymi sablona pracuje
global $tplData;

// pripojim objekt pro vypis hlavicky a paticky HTML
require(DIRECTORY_VIEWS ."/TemplateBasics.class.php");
$tplHeaders = new TemplateBasics();

?>
<!-- ------------------------------------------------------------------------------------------------------- -->

<!-- Vypis obsahu sablony -->
<?php
// hlavicka
$tplHeaders->getHTMLHeader();

if($this->login->isUserLoged()){

    if(array_key_exists('profil', $tplData) && count($tplData['profil'])>0 ) {

        foreach ($tplData['profil'] as $d) {
            ?>
            <form name="form_editace_profilu" id="form_editace_profilu" class="element_on_page">
                <label for="jmeno">Jméno</label>
                <input type="text" class="form-control" id="jmeno" name="jmeno" required value="<?php echo $d["jmeno"]; ?>">

                <label for="login">Uživatelské jméno</label>
                <input type="text" class="form-control" id="login" name="login" required value="<?php echo $d["login"]; ?>">

                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?php echo $d["email"]; ?>">

                <label for="heslo">Staré heslo</label>
                <input type="password" class="form-control" id="heslo_stare" name="heslo_stare" >

                <label for="heslo">Nové heslo</label>
                <input type="password" class="form-control" id="heslo_nove" name="heslo_nove" >

                <input type="hidden" name="iduzivatele" value="<?php echo $d["iduzivatele"]; ?>">

                <br>

                <a onclick="odeslat_edit_profilu()" class="btn btn-primary" style="color: white">Uložit</a>
            </form>
        <?php }
    } else {
        echo "Nenalezeny žádné informace o  uživateli";
    }

}else{
   echo "<span class='error'>Není přihlášen žádný uživatel</span>";
}


// paticka
$tplHeaders->getHTMLFooter()

?>