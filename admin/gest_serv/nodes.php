<?php
session_start();
ini_set('display_errors','off');
include("../../config/settings.php");
include("../../config/mysql.php");
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
        $reponse2 = $bdd->query("SELECT * FROM node");
        $reponse3 = $bdd->query("SELECT * FROM server");
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
        <link href="../../css/tpanel.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
        <style>

        </style>
    </head>
    <body>

        <div class="sidenav">
            <a class="name"><?php echo $settings_info_name; ?></a>
            <gcaf class="username"><?php echo $donnees['first_name'] . ", " . $donnees['second_name']; ?></gcaf>
            <a><br /></a>
            <a href="<?php echo $settings_php_page; ?>admin/"><i class="fa fa-home"></i> Accueil</a>
            <a href="<?php echo $settings_php_page; ?>"><i class="fa fa-rotate-left"></i> Retour</a>
            <gca>Gestion des comptes</gca>
            <a href="../gest_user/index.php"><i class="fa fa-users"></i> Mes comptes</a>
            <a href="../gest_user/settings.php"><i class="fa fa-gears"></i> Paramètres</a> 
            <gca>Gestion des serveurs</gca>
            <a href="../gest_serv/"><i class="fa fa-server"></i> Mes serveurs</a>
            <a class="active" href="../gest_serv/nodes.php"><i class="fa fa-sitemap"></i> Mes nodes</a>
            
            <a style="position: absolute; bottom: 0;"> a</a>
        </div>
        <div class="menu">
            <div><br/><gc class="pos_pager"><i class="fa fa-gears"></i> <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;">Administration</gc></a> > <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;"> Gestion des serveurs</gc></a></gc> > <gc class="pos_pager"><i class="fa fa-sitemap"></i> <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;">Mes nodes</gc></a></div>
            
            <div class="main">
                <a class="button-type-2 right" href="create_node.php">Créer un nouveau node</a>
                <table width="100%" class="node_tab">
                    <tr>
                        <th width="10%">Status</th>
                        <th width="20%">Nom</th>
                        <th width="20%">Memoire RAM</th>
                        <th width="20%">Disque</th>
                        <th width="20%">Nombre de serveur</th>
                        <th width="10%">SSL</th>
                    </tr>
                    <?php
                    while($donnees2 = $reponse2->fetch())
                    {
                        ?>
                    <tr><td>
                    <?php  
$host = $donnees2['adress']; 
$port = $donnees2['port'];
$waitTimeoutInSeconds = 1; 
if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
   echo '<i style="color: green;" class="fa fa-heartbeat"></i>';
} else {
   echo '<i style="color: red;" class="fa fa-heart-o"></i>';
} 
fclose($fp);
                        ?>
                        </td>
                        <td><a style="color: black;" href="../../gest_serv/?id=<?php echo $donnees2['id']; ?>"><?php echo $donnees2['name']; ?></a></td>
                        <td><a style="color: black;" href="../../gest_serv/?id=<?php echo $donnees2['id']; ?>"><?php echo $donnees2['ram_max']; ?>MB</a></td>
                        <td><a style="color: black;" href="../../gest_serv/?id=<?php echo $donnees2['id']; ?>"><?php echo $donnees2['disk']; ?>Mo</a></td>
                        <td><a style="color: black;" href="../../gest_serv/?id=<?php echo $donnees2['id']; ?>"><?php
                        $variable_totalement_pas_utile = 0;
                        while($donnees3 = $reponse3->fetch())
                        {
                            if($donnees3['server_location'] == $donnees2['id'])
                            {
                                $variable_totalement_pas_utile = $variable_totalement_pas_utile + 1;
                            }
                        }
                        echo $variable_totalement_pas_utile;
                        ?></a></td>
                        <td><?php if($donnees2['ssl'] == "true"){echo '<i style="color:green;" class="fa fa-lock"></i>'; }else{echo '<i style="color:red;" class="fa fa-unlock"></i>';}?></td>
                        
                    </tr>
                        <?php
                    }
                    ?>
                    
                </table>
            </div>
            <br/><br/><p class="copyright_t" style="text-align: right;margin-right: 200px;">&copy; Orme Panel by TismaDEV 2020</p>
        </div>
    </body>

</html>