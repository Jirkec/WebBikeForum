<?php


function ma_uzivatel_pravo(array $prava, DatabaseModel $db, int $iduzivatele){

    $login = $db->getUzivateleInfo($iduzivatele)[0]["login"];
    $prava_uzivatele = $db->getPravaByLogin($login);
    //print_r($prava_uzivatele);

    $ma_prava = true;

    if(!empty($prava_uzivatele)){
        foreach ($prava_uzivatele as $d){
            foreach ($prava as $i){
                $ma_prava &= !in_array($i, $d);
            }
        }
    }else{
        return false;
    }

    return !$ma_prava;
}

function aktualni_prava(array $prava, DatabaseModel $db, LoginModel $login){

    $prava_uzivatele = $db->getPravaByLogin($login->getUserLogin());
    //print_r($prava_uzivatele);

    $ma_prava = true;

    if(!empty($prava_uzivatele)){
        foreach ($prava_uzivatele as $d){
            foreach ($prava as $i){
                $ma_prava &= !in_array($i, $d);
            }
        }
    }else{
        return false;
    }

    return !$ma_prava;
}

function nahrani_souboru(array $soubor):array {
    $nazev_souboru = $soubor["name"];
    $tmp_name = $soubor["tmp_name"];
    $size = $soubor["size"];

    $return["hlaska"] = "";
    $return["jak"] = true;
    $return["nazev_souboru"] = "";

    $target_file = DIRECTORY_UPLOADED_FILES ."/".rand(0, 10000)."_".basename($nazev_souboru);
    while(file_exists($target_file)) {
        $target_file = DIRECTORY_UPLOADED_FILES ."/".rand(0, 10000)."_".basename($nazev_souboru);
    }

    $return["nazev_souboru"] = str_replace(DIRECTORY_UPLOADED_FILES ."/", "", $target_file);

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($tmp_name);
        if($check !== false) {
            //$return["hlaska"] .= "Soubor je obrázek - " . $check["mime"] . ".";
            $return["jak"] = 1;
        } else {
            $return["hlaska"] .= "CHYBA, soubor není obrázek.";
            $return["jak"] = 0;
        }


// Check file size
    if ($size > 5000000) {
        $return["hlaska"] .= "CHYBA, soubor je moc velký.";
        $return["jak"] = 0;
    }
// Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $return["hlaska"] .= "CHYBA, pouze JPG, JPEG, PNG & GIF soubory jsou podporovány.";
        $return["jak"] = 0;
    }

    if ($return["jak"] == 0) {
        $return["hlaska"] .= "CHYBA, soubor nebyl nahrán.";
    } else {
        if (move_uploaded_file($tmp_name, $target_file)) {
            //$return["hlaska"] .= "Soubor ". basename($nazev_souboru). " byl nahrán.";
        } else {
            $return["hlaska"] .= "CHYBA, Nastala chyba při nahrávání souboru.";
        }
    }

    return $return;
}

?>

<script>
    var dialog_width;
    var dialog_height;

function prepocitat_velikost_dialogu() {
    dialog_width = $( document ).width()*0.4;
    dialog_height = $( document ).height()*0.5;

    if( $( window ).width() < 769){
        dialog_width =  $( document ).width();
    }
    if( $( window ).width() < 769){
        dialog_height =  $( document ).height();
    }
}

function show_div_edit_prava(iduzivatele) {
        prepocitat_velikost_dialogu();

        jQuery.ajax({
            type : 'POST',
            url:"<? echo DIRECTORY_AJAX; ?>" +"/edit_prava.php",
            async: false,
            data: {
                iduzivatele : iduzivatele
            },
            success: function(html_div)
            {
                //console.log(html_div);
                jQuery('#div_edit_prava').remove();
                $('#div_sem_vloz_edit_prava_div').append(html_div);

                $('#div_edit_prava').dialog({ autoOpen: false });
                $('#div_edit_prava').dialog( { title: "Práva uživatele", resizable: false, modal: true, show: 'fade', width: dialog_width, height: dialog_height, hide: 'fade' } );
                $('#div_edit_prava').dialog({
                    position: { my: "center center", of: document }
                })
                $('#div_edit_prava').dialog('open');

            }});

}

function odeslat_edit_prava(iduzivatele) {
        var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/edit_prava_w.php", jQuery("#form_edit_prava").serialize()+"&iduzivatele="+iduzivatele);
        posting.done(function(data)
        {
            if(data == 1){
                location.reload();
            }else{
                alert("Editace práv se nepovedla");
            }
        });
}



function show_div_registrace() {
    prepocitat_velikost_dialogu();

    $('#div_registrace').dialog({ autoOpen: false });
    $('#div_registrace').dialog( { title: "Registrace", resizable: false, modal: true, show: 'fade', width: dialog_width, height: dialog_height, hide: 'fade' } );
    $('#div_registrace').dialog({
        position: { my: "center center", of: document }
    })
    $('#div_registrace').dialog('open');
}

function odeslat_registraci() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/registrace_w.php", jQuery("#form_registrace").serialize());
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Registrace se nepovedla");
        }
    });
}

function show_div_prihlasit() {
    prepocitat_velikost_dialogu();

    $('#div_prihlasit').dialog({ autoOpen: false });
    $('#div_prihlasit').dialog( { title: "Přihlásit", resizable: false, modal: true, show: 'fade', width: dialog_width, height: dialog_height, hide: 'fade' } );
    $('#div_prihlasit').dialog({
        position: { my: "center center", of: document }
    })
    $('#div_prihlasit').dialog('open');
}

function odeslat_prihlaseni() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/prihlaseni_w.php", jQuery("#form_prihlasit").serialize());
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Příhlášení se nepovedlo");
        }
    });
}

function odhlasit_uzivatele() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/odhlaseni_w.php");
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Odhlášení se nezdařilo");
        }
    });
}

function odeslat_edit_profilu() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/edit_profilu_w.php", jQuery("#form_editace_profilu").serialize());
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Změna se nepovedla");
        }
    });
}

function show_div_recence() {
    prepocitat_velikost_dialogu();

    $('#div_recence').dialog({ autoOpen: false });
    $('#div_recence').dialog( { title: "Recenze", resizable: false, modal: true, show: 'fade', width: dialog_width, height: dialog_height, hide: 'fade' } );
    $('#div_recence').dialog({
        position: { my: "center center", of: document }
    })
    $('#div_recence').dialog('open');
}

function odeslat_recenzi() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/recenze_w.php", jQuery("#form_recence").serialize());
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Uložení recenze se nepovedlo");
        }
    });
}

function schvalit_clanek(idclanky) {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/schvalit_clanek_w.php", "idclanky="+idclanky);
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Schválení článku se nepovedlo");
        }
    });
}

function show_div_poslat_k_recenzi() {
    prepocitat_velikost_dialogu();

    $('#div_poslat_k_recenzi').dialog({ autoOpen: false });
    $('#div_poslat_k_recenzi').dialog( { title: "Poslat k recenzi", resizable: false, modal: true, show: 'fade', width: dialog_width, height: dialog_height, hide: 'fade' } );
    $('#div_poslat_k_recenzi').dialog({
        position: { my: "center center", of: document }
    })
    $('#div_poslat_k_recenzi').dialog('open');
}

function odeslat_k_recenci() {
    var posting = jQuery.post("<?php echo DIRECTORY_AJAX; ?>/odeslat_k_recenzi_w.php", jQuery("#form_poslat_k_recenzi").serialize());
    posting.done(function(data)
    {
        if(data == 1){
            location.reload();
        }else{
            alert("Odeslatni k recenzi se nepovedlo.");
        }
    });
}



</script>