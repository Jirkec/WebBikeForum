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
// muze se hodit: strtotime($d['date'])

// hlavicka
$tplHeaders->getHTMLHeader();

if($this->login->isUserLoged() && aktualni_prava(array(1), $this->db, $this->login)){
?>
    <div class="table-responsive element_on_page">
    <?php

    if(array_key_exists('uzivatele', $tplData) && count($tplData['uzivatele'])>0 ) {

        ?>

                            <table class="table table-sm table-striped ">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID uzivatele</th><th>login</th><th>jmeno</th><th>email</th><th>prava</th>
                                    </tr>
                                </thead>
                                <tbody>
        <?php

        foreach ($tplData['uzivatele'] as $d) {
            ?>
            <tr class="">
                <td><?php echo $d["iduzivatele"]; ?></td>
                <td><?php echo $d["login"]; ?></td>
                <td><?php echo $d["jmeno"]; ?></td>
                <td><?php echo $d["email"]; ?></td>
                <td><?php echo $d["prava"]; ?><a onclick="show_div_edit_prava(<?php echo $d["iduzivatele"]; ?>)"><span class="fa fa-edit"></span></a></td>
            </tr>

        <?php }
    } else {
        echo "<div class=\"alert alert-warning\" role=\"alert\">Nenalezeni žádní uživatelé</div>";
    }
    ?>

        </tbody>
    </table>

    <div id="div_sem_vloz_edit_prava_div"></div>
    <?php

}else{
    echo "<div class=\"alert alert-danger\" role=\"alert\">Nemáte dostatečná práva na zobrazení této stránky!</div>";
}


// paticka
$tplHeaders->getHTMLFooter()

?>