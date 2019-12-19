<?php

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

    if($update) {
        echo "<div class='element_on_page'>";
            echo "<div id='div_titulek'>
                    <h1 id='h1_titulek'>".$tplData["clanek"][0]["titulek"]." </h1>";

            if(aktualni_prava(array(1),$this->db, $this->login)){
                    echo "<div id='div_nabidka'>";
                        if($tplData['clanek'][0]['schvaleno'] == 0)
                            echo "<a onclick='schvalit_clanek($this->idclanky)'><span class='fa fa-check'></span> Schválit</a><br>";
                    echo "<a><span class='fa fa-mail-forward'></span> Poslat k recenzi</a></div>";
            }
            echo "<span class='info'>by ".$this->db->getUzivateleInfo($tplData["clanek"][0]["autor"])[0]["jmeno"]."</span>
                    
                  </div>";

            if($update && file_exists(DIRECTORY_UPLOADED_FILES."/".$tplData['clanek'][0]['obrazek']) && !empty($tplData['clanek'][0]['obrazek'])){
                echo "<img src='".DIRECTORY_UPLOADED_FILES."/".$tplData['clanek'][0]['obrazek']."'>";
            }

            echo "<div id='div_text'>".$tplData["clanek"][0]["text"] ."</div>";

            echo "<div id='div_hodnoceni'>";
                echo "<span class='font-weight-bold'>Recenze</span>";

                //if($uzivatel_muze_pridat_recenci)
                    echo "&nbsp;<a onclick='show_div_recence()'><span class='fa fa-plus'></span></a>";

                    if(isset($tplData["hodnoceni"]) && !empty($tplData["hodnoceni"])){
                        echo "<div class='table-responsive'>";
                        echo '<table class="table table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Recenzent</th><th>Hodnocení</th><th>Komentář</th><!-- priprava pro editacith>&nbsp;</th>-->
                                    </tr>
                                </thead>
                                <tbody>';
                        foreach ($tplData["hodnoceni"] as $d) {
                            ?>
                            <tr class="">
                                <td><?php echo $d["jmeno"]; ?></td>
                                <td><?php echo "<img src='style/".$d["pocet_hvezd"]."_hvezda.png'>"; ?></td>
                                <td><?php echo $d["komentar"]; ?></td>
                            </tr>

                        <?php } ?>

                        </tbody>
                        </table>
                        <?php
                    }
            echo "</div>";
        echo "</div>";
?>
        <div id="div_recence" title="Recenze" style="display: none">
            <form name="form_recence" id="form_recence">
                <label for="pocet_hvezd">Počet hvězd</label>
                <input type="number" class="form-control" id="pocet_hvezd" name="pocet_hvezd" max="5" min="1" required>

                <label for="komentar">Komentář</label>
                <input type="text" class="form-control" id="komentar" name="komentar">

                <input type="hidden" name="iduzivatele" value="<?php echo $this->iduzivatele; ?>">
                <input type="hidden" name="idclanky"    value="<?php echo $this->idclanky; ?>">

            </form>
            <br><button class="btn btn-primary" onclick="odeslat_recenci()">Uložit recenzi</button>
        </div>
<?php
    }else{
        echo "<div class=\"alert alert-warning\" role=\"alert\">Nenalezen požadovaný článek</div>";
    }

$tplHeaders->getHTMLFooter()
?>