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
/*
    if($update)
        echo "update";
    else
        echo "insert";
*/
//var_dump($tplData);
        ?>
    <div class="element_on_page">
        <?php

        if(isset($nahrani["hlaska"]) && isset($nahrani["jak"]))
            echo "<div class=\"alert alert-".($nahrani["jak"]?"success":"danger")."\" role=\"alert\">".$nahrani["hlaska"]."</div>";
        ?>

        <form name="form_clanek" method="post" enctype="multipart/form-data" onsubmit="document.form_clanek.submit()">
            <div class="form-group">
                <input type="text" class="form-control" id="titulek" name="titulek" placeholder="Titulek" required
                    <?php
                    if($update)
                        echo "value='".$tplData['clanek'][0]['titulek']."'";
                    ?>
                >
            </div>
            <?php
                if($update && file_exists(DIRECTORY_UPLOADED_FILES."/".$tplData['clanek'][0]['obrazek']) && !empty($tplData['clanek'][0]['obrazek'])){
                    echo "<img src='".DIRECTORY_UPLOADED_FILES."/".$tplData['clanek'][0]['obrazek']."'>";
                }
            ?>

            <div class="form-group">
                    Nahrát obrázek: <input type="file" name="soubor" id="soubor">
            </div>

            <div class="form-group">
                <textarea name="text" id="cke_text" rows="10" cols="80">
                    <?php
                    if($update)
                        echo $tplData['clanek'][0]['text'];
                    ?>
                </textarea>
                <script>
                    CKEDITOR.replace( 'cke_text' );
                </script>
            </div>

            <input type="submit" class="btn btn-primary" value="Uložit" name="ulozit">
        </form>
    </div>


<?php
$tplHeaders->getHTMLFooter()
?>