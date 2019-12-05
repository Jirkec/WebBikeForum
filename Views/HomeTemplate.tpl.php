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
    foreach ($tplData['clanky'] as $d) {
        $res.= "<a onclick='show_clanek($d[idclanky]);'>
                    <div class='div_mini_clanek'>
                            <img src='clanky_obrazky/$d[obrazek]'>        
                            <div class='div_mini_clanek_info'>
                                <span>$d[titulek]</span>
                                <span>".date("Y-m-d", strtotime($d[datumcas_vlozeni]))."</span>
                                <span>$d[autor]</span>
                            </div>
                            <img src='style/$d[pocet_hvezd]_hvedzda.png' class='img_hvezdy'>
                   </div>
               </a>";

        /*
        $res .= "<h2>$d[title]</h2>";
        $res .= "<b>Autor:</b> $d[author] (" . date("d. m. Y, H:i.s", strtotime($d['date'])) . ")<br><br>";
        $res .= "<div style='text-align:justify;'><b>Úryvek:</b> $d[text]</div><hr>";*/
    }
} else {
    $res .= "Nenalezeny žádné články";
}
echo $res;

// paticka
$tplHeaders->getHTMLFooter()

?>