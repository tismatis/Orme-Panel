<?php
session_start();
include("../config/settings.php");
include("../config/mysql.php");
if(isset($_SESSION['is_connected']))
{
    header('Location: ' . $settings_php_page);
    exit;
}else{
    if(isset($_POST['userid']))
    {
        if(isset($_POST['password']))
        {
            $mdp_md5 = md5($_POST['password']);
            $bdd = new PDO('mysql:host=' . $mysql_ip . ';dbname=' . $mysql_DB . ';charset=utf8', $mysql_id, $mysql_mdp);
            $reponse = $bdd->query("SELECT * FROM users WHERE username='" . $_POST['userid'] . "' AND password='" . $mdp_md5 . "'");
            $donnees = $reponse->fetch();
                if(isset($donnees['username']))
                {
                    $_SESSION['is_connected'] = true;
                    $_SESSION['account_id'] = $donnees['id'];
                    header('Location: ' . $settings_php_page);
                    exit;
                }else{
                    header('Location: ' . $settings_php_page . 'auth/?e=1');
                    $_POST['userid'] = null;
                    $_POST['password'] = null;
                    exit;
                }
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $settings_info_name; ?> - Se connecter</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../css/tpanel.css" rel="stylesheet" type="text/css" />
        <style>

        </style>
    </head>
    <body class="background_gris_foncer">
        <br/><br/><br/>
        <?php
        if(isset($_GET['e']))
        {
            if($_GET['e'] == "1")
            {
                ?>
                <div class="form-connection-error">
                        <p><br/>Mot de passe ou identifiant incorrect.<br/><br/> </p>
                </div>
                <?php
            }
            if($_GET['e'] == "2")
            {
                ?>
                <div class="form-connection-error">
                        <p><br/>Vous n'êtes pas connecté.<br/><br/> </p>
                </div>
                <?php
            }
            if($_GET['e'] == "3")
            {
                ?>
                <div class="form-connection-confirm">
                        <p><br/>Vous vous êtes déconnecté.<br/><br/> </p>
                </div>
                <?php
            }
            if($_GET['e'] == "4")
            {
                ?>
                <div class="form-connection-error">
                        <p><br/>Code erreur <a style="color: black;" href="">L-1</a>. Essayer de vous reconnecter.<br/><br/> </p>
                </div>
                <?php
            }
        }else{
            ?>
            <br/><br/><br/><br/><br/>
            <?php
        }
        ?>
        <br/><br/><br/><br/><br/><br/>
        <div class="form-connection">

            <div class="header"><img src=<?php echo $settings_info_logo; ?> width="350px" /><br/>Se connecter
            </div>
            <div class="content">
                <form action="" method="post">
                    <div class="head">
                        <div class="">
                            <label for="userid">Identifiant: </label>
                            <input type="text" name="userid" class="textbox-type-1" placeholder="Identifiant"/>
                        </div>
                        <div class="">
                            <label for="password">Mot de passe: </label>
                            <input type="password" name="password" class="textbox-type-1" placeholder="Mot de passe"/>
                        </div>
                        <br />
                    </div>
                    <div class="foot">                                                               
                        <button type="submit" class="button-type-1">Me connecter</button>
                        
                        <p><a href="#">J'ai oublier mon mot de passe</a><br /><h5 class="copyright_t">&copy; Orme Panel by TismaDev 2020</h5></p>
                    </div>
                </form>
                <br />
            </div>
        </div>
    </body>
</html>