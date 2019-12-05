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

</script>