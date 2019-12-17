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
echo "detail";

    if($update) {
        ?>

    <div class="table-responsive element_on_page">
        <table class="table table-sm table-striped ">
        <thead class="table-dark">
        <tr>
            <th>ID uzivatele</th><th>login</th><th>jmeno</th><th>email</th><th>prava</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>


<?php
    }else{
        echo "<div class=\"alert alert-warning\" role=\"alert\">Nenalezen požadovaný článek</div>";
    }

$tplHeaders->getHTMLFooter()
?>