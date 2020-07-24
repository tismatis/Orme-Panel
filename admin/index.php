<?php
session_start();
include("../config/settings.php");
include("../config/mysql.php");
if(isset($_SESSION['is_connected']))
{
    if($_SESSION['account_id'] == "")
    {
        header('Location: ' . $settings_php_page . "auth/?e=4");
        $_SESSION['is_connected'] = null;
        $_SESSION['account_id'] = null;

        session_destroy();
        exit;
    }else{
        $bdd = new PDO('mysql:host=' . $mysql_ip . ';dbname=' . $mysql_DB . ';charset=utf8', $mysql_id, $mysql_mdp);
        $reponse = $bdd->query("SELECT * FROM users WHERE id='" . $_SESSION['account_id'] . "'");
        $donnees = $reponse->fetch();

    }
}else{
    header('Location: ' . $settings_php_page . "auth/?e=2");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $settings_info_name; ?> - Accueil</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../css/tpanel.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
        <style>

        </style>
    </head>
    <body>
        <div class="sidenav">
            <a class="name"><?php echo $settings_info_name; ?></a>
            <gcaf class="username"><?php echo $donnees['first_name'] . ", " . $donnees['second_name']; ?></gcaf>
            <a><br /></a>
            <a class="active" href="<?php echo $settings_php_page; ?>admin/"><i class="fa fa-home"></i> Accueil</a>
            <a href="<?php echo $settings_php_page; ?>"><i class="fa fa-rotate-left"></i> Retour</a>
            <gca>Gestion des comptes</gca>
            <a href="gest_user/"><i class="fa fa-users"></i> Mes comptes</a>
            <a href="gest_user/settings.php"><i class="fa fa-gears"></i> Paramètres</a> 
            <gca>Gestion des serveurs</gca>
            <a href="gest_serv/"><i class="fa fa-server"></i> Mes serveurs</a>
            <a href="gest_serv/nodes.php"><i class="fa fa-sitemap"></i> Mes nodes</a>
            
            <a style="position: absolute; bottom: 0;"> a</a>
        </div>
        <div class="menu">
            <div><br/><gc class="pos_pager"><i class="fa fa-gears"></i> <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;">Administration</gc></a> > <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><i class="fa fa-home"></i><gc style="font-weight: bold;"> Accueil</gc></a></gc></div>
            
            <div class="main">
                a
            </div>
            <br/><br/><p class="copyright_t" style="text-align: right;margin-right: 200px;">&copy; Orme Panel by TismaDEV 2020</p>
        </div>
    </body>

</html>