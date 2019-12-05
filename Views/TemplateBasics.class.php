<?php



class TemplateBasics {


    public function getHTMLHeader() {

        require_once (DIRECTORY_MODELS ."/LoginModel.class.php");
        $login = new LoginModel();
        require_once (DIRECTORY_MODELS ."/DatabaseModel.class.php");
        $db = new DatabaseModel();


        require_once "functions.inc.php";


        ?>

        <!doctype html>
        <html>
            <head>
                <meta charset='utf-8'>
                <link rel="shortcut icon" type="image/png" href="style/favicon.png"/>

                <!-- nastaveni viewportu je zakladem pro responzivni design i Boostrap -->
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">

                <title><?php echo WEB_TITLE; ?></title>

                <link rel="stylesheet" href="style/composer/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="style/composer/vendor/components/font-awesome/css/font-awesome.min.css">
                <link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
                <link rel="stylesheet" href="style/style.css">

                <script src="jquery-3.4.1.min.js"></script>
                <script src="style/composer/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="style/composer/vendor/components/jquery/jquery.min.js"></script>
                <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>


                <!--
                <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                <script src="jquery-3.4.1.min.js"></script>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->

            </head>
            <body>

                <nav class="navbar navbar-expand-md bg-dark navbar-dark">

                        <a class="navbar-brand" href="index.php?page=home">
                            <span class="fa fa-bicycle"></span>
                            <?php echo WEB_PAGES["home"]["title"]; ?>
                        </a>



                    <div class="collapse navbar-collapse " id="collapsibleNavbar">
                            <ul class="navbar-nav">
                                <!--<li class="nav-item">
                                    <a class="nav-link" href="index.php?page=autori">Autoři</a>
                                </li>-->
                                <?php
                                    if($login->isUserLoged() && aktualni_prava(array(1),$db,$login)) {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?page=prava"><?php echo WEB_PAGES["prava"]["title"]; ?></a>
                                        </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?page=uzivatele"><?php echo WEB_PAGES["uzivatele"]["title"]; ?></a>
                                    </li>
                                    <?php
                                        }
                                    ?>
                            </ul>
                        </div>


                    <?php
                    if(!$login->isUserLoged()){
                    ?>
                        <ul class="navbar-nav ">
                            <li class="nav-item">
                                <a class="nav-link" onclick="show_div_prihlasit()" >Přihlásit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="show_div_registrace()" >Registrace</a>
                            </li>
                        </ul>
                        <?php
                        }else{
                    ?>
                                <ul class="navbar-nav ">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">
                                            <span class="fa fa-user-o fa-2x"></span>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="index.php?page=profil">Nastavení profilu</a>
                                            <a class="dropdown-item" onclick="odhlasit_uzivatele()">Odhlásit</a>
                                        </div>
                                    </li>
                                </ul>
                        <?php
                        }
                        ?>


                    <!-- Toggler/collapsibe Button -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                        <span>&nbsp;&nbsp;</span>

                        <form class="form-inline my-2 my-lg-0" action="index.php?page=home" method="post">
                            <input class="form-control mr-sm-2" type="text" placeholder="Hledat" aria-label="Search" name="hledat">
                        </form>



                </nav>

        <div id="div_vnitrek">


        <?php
    }

    public function getHTMLFooter(){
        ?>
        </div>
                <br>
                    <a href="#">
                        <!--<img title="Back to Top" src="https://cdn.dribbble.com/assets/icon-backtotop-1b04df73090f6b0f3192a3b71874ca3b3cc19dff16adc6cf365cd0c75897f6c0.png" alt="Icon backtotop">
                   --> </a>
                <footer>

                </footer>


        <div id="div_prihlasit" title="Přihlásit" style="display: none">
            <form name="form_prihlasit" id="form_prihlasit">
                <label for="login">Uživatelské jméno</label>
                <input type="text" class="form-control" id="login" name="login" required>

                <label for="heslo">Heslo</label>
                <input type="password" class="form-control" id="heslo" name="heslo" required>

            </form>
            <br><button class="btn btn-primary" onclick="odeslat_prihlaseni()">Přihlásit</button>
        </div>
        
        <div id="div_registrace" title="Registrace" style="display: none">
            <form name="form_registrace" id="form_registrace">
                <div class="row">
                    <div class="col">
                        <label for="jmeno">Jméno</label>
                        <input type="text" class="form-control" id="jmeno" name="jmeno" required>
                    </div>
                    <div class="col">
                        <label for="login">Uživatelské jméno</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>
                </div>

                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>

                <label for="heslo">Heslo</label>
                <input type="password" class="form-control" id="heslo" name="heslo" required>

            </form>

            <br><button class="btn btn-primary" onclick="odeslat_registraci()">Registrovat</button>
        </div>

            </body>
        </html>

        <?php
    }
        
}

?>