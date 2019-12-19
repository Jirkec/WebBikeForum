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

//print_r($tplData['testprep']);

if($this->login->isUserLoged() && aktualni_prava(array(1), $this->db, $this->login)){

    if(array_key_exists('prava', $tplData) && count($tplData['prava'])>0 ) {

        ?>
        <div class="table-responsive element_on_page">
                            <table class="table table-sm table-striped ">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID prava</th><th>pravo</th><th>popis</th><!-- priprava pro editacith>&nbsp;</th>-->
                                    </tr>
                                </thead>
                                <tbody>
        <?php

        foreach ($tplData['prava'] as $d) {
            ?>
            <tr class="">
                <td><?php echo $d["idprava"]; ?></td>
                <td><?php echo $d["pravo"]; ?></td>
                <td><?php echo $d["popis"]; ?></td>
                <!-- priprava pro editaci
                <td>
                    <a onclick="editovat_pravo()"><span class="fa fa-edit"></span></a>
                        &nbsp;
                    <a onclick="smazat_pravo()"><span class="fa fa-trash"></span></a>
                </td>
                -->
            </tr>

             <?php } ?>

              </tbody>
            </table>
        <?php
    } else {
        echo "<div class=\"alert alert-warning\" role=\"alert\">Nenalezeny žádná práva</div>";
    }
}else{
    echo "<div class=\"alert alert-danger\" role=\"alert\">Nemáte dostatečná práva na zobrazení této stránky!</div>";
}


// paticka
$tplHeaders->getHTMLFooter()

?>