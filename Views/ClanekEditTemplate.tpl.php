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

    if($update)
        echo "update";
    else
        echo "insert";

        ?>
    <div class="element_on_page">
        <form name="form_clanek">
            <div class="form-group">
                <input type="text" class="form-control" id="titulek" name="titulek" placeholder="Titulek" required>
            </div>

            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFileLang" lang="fr">
                    <label class="custom-file-label" for="customFileLang">Nahrát obrázek</label>
                </div>
            </div>

            <div class="form-group">
                <textarea name="text" id="cke_text" rows="10" cols="80">
                </textarea>
                <script>
                    CKEDITOR.replace( 'cke_text' );
                </script>
            </div>

            <input type="submit" class="btn btn-primary" value="Uložit">
        </form>
    </div>


<?php
$tplHeaders->getHTMLFooter()
?>