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

// vypis pohadek
$res = "";
if(array_key_exists('clanky', $tplData) && count($tplData['clanky'])>0 ) {
    $res.= "<div class='row'>";
    foreach ($tplData['clanky'] as $d) {
        $res.= "<div class='col-sm-6 col-md-3 col-lg-2 div_mini_clanek'>
                    <a href='index.php?page=pridat_clanek&idclanky=$d[idclanky]'>
                        <div>";

            if(file_exists(DIRECTORY_UPLOADED_FILES."/".$d["obrazek"]) && !empty($d["obrazek"])){
                $res .= "<img src='".DIRECTORY_UPLOADED_FILES."/".$d["obrazek"]."'>";
            }else{
                $res .= "<img src='".DIRECTORY_UPLOADED_FILES."/zakladni_nahled.png'>";
            }
                               $res .= "<div class='div_mini_clanek_info'>
                                    <span>".$d["titulek"]."</span>
                                    <span>".date("Y-m-d", strtotime($d["datumcas_vlozeni"]))."</span>
                                    <span>by ".$this->db->getUzivateleInfo($d["autor"])[0]["jmeno"]."</span>
                                </div>";


                        $pocet_hvezd = 0;
                        $pocet_hodnoceni = 0;
                        $hodnoceni = $this->db->getHodnoceniByIdclanky($d["idclanky"]);
                        foreach ($hodnoceni as $h){
                            $pocet_hvezd += $h["pocet_hvezd"];
                            $pocet_hodnoceni++;
                        }
                        if($pocet_hodnoceni>0){
                            $prumer_hodnoceni = $pocet_hvezd/$pocet_hodnoceni;
                            $res .= "<img src='style/".$prumer_hodnoceni."_hvezda.png' class='img_hvezdy'>";
                        }else{
                            $res .= "Nehodnoceno";
                        }

                     $res.=  "</div>
                   </a>
               </div>";

        /*
        $res .= "<h2>$d[title]</h2>";
        $res .= "<b>Autor:</b> $d[author] (" . date("d. m. Y, H:i.s", strtotime($d['date'])) . ")<br><br>";
        $res .= "<div style='text-align:justify;'><b>Úryvek:</b> $d[text]</div><hr>";*/

    }
    $res .= "</div>";
} else {
    $res .= "<div class=\"alert alert-warning\" role=\"alert\">Nenalezeny žádné články</div>";
}
echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>