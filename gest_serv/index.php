<?php
session_start();
ini_set('display_errors','off');
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
        $reponse2 = $bdd->query("SELECT * FROM server");
        $reponse3 = $bdd->query("SELECT * FROM subserv WHERE id='" . $_GET['id'] . "'");
        
        $donnees2 = $reponse2->fetch();
        $donnees3 = $reponse3->fetch();
        $reponse4 = $bdd->query("SELECT * FROM node WHERE id='" . $donnees2['server_location'] . "'");
        $donnees4 = $reponse4->fetch();
        if($donnees2['proprio_id'] != $_SESSION['account_id'])
        {
            if($donnees['admin'] != true)
            {
                if($donnees3['sub_id'] != $_SESSION['account_id'])
                {
                    header("Location: ../error.php");
                }
            }
        }
    }
}else{
    header('Location: ' . $settings_php_page . "auth/?e=2");
    exit;
}
if(isset($_GET['t'])){}else{
	header("Location: index.php?id=" . $_GET['id'] . "&t=1");
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
            <a href="<?php echo $settings_php_page; ?>"><i class="fa fa-home"></i> Accueil</a>
            <gca>Mon Compte</gca>
            <a href="../myuser.php"><i class="fa fa-user"></i> Mon Compte</a>
            <?php 
            if($donnees['admin'] == true)
            {
                ?><a href="../admin/"><i class="fa fa-gears"></i> Administration</a>
                <?php
            }
            ?>
            <gca>Gestion des serveurs</gca>
            <a class="active" href="../serverlist.php"><i class="fa fa-server"></i> Mes serveurs</a>
            
            <a style="position: absolute; bottom: 0;"> a</a>
            <gca>Gestion du serveur</gca>
			<?php
			if($_GET['t'] == 1){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=1"><i class="fa fa-terminal"></i> Console</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=1"><i class="fa fa-terminal"></i> Console</a>
			<?php 
			}
			if($_GET['t'] == 2){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=2"><i class="fa fa-rocket"></i> Acces SFTP</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=2"><i class="fa fa-rocket"></i> Acces SFTP</a><?php } 
			if($_GET['t'] == 3){
			?><a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=3"><i class="fa fa-file-archive-o"></i> Backup</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=3"><i class="fa fa-file-archive-o"></i> Backup</a>
            <?php } 
			if($_GET['t'] == 4){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=4"><i class="fa fa-database"></i> Base de données</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=4"><i class="fa fa-database"></i> Base de données</a>
			<?php } 
			if($_GET['t'] == 5){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=5"><i class="fa fa-user-plus"></i> Sous-utilisateur</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=5"><i class="fa fa-user-plus"></i> Sous-utilisateur</a>
			<?php } 
			if($_GET['t'] == 6){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=6"><i class="fa fa-folder-open"></i> Gestion des fichiers</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=6"><i class="fa fa-folder-open"></i> Gestion des fichiers</a>
			<?php } 
			if($_GET['t'] == 7){
			?>
            <a class="active" href="index.php?id=<?php echo $_GET['id']; ?>&t=7"><i class="fa fa-info"></i> Information</a>
			<?php 
			}else{
			?><a href="index.php?id=<?php echo $_GET['id']; ?>&t=7"><i class="fa fa-info"></i> Information</a><?php } ?>
            <a style="position: absolute; bottom: 0;"> a</a>
        </div>
        <div class="menu">
            <div><br/><gc class="pos_pager"><i class="fa fa-gears"></i><a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;"> Gestion des serveurs</gc></a> > <gc class="pos_pager"><i class="fa fa-server"></i> <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;">Mes serveurs</gc></a> > <gc class="pos_pager"><i class="fa fa-server"></i> <a style="text-decoration: none;" href="<?php echo $settings_php_page; ?>admin/"><gc style="font-weight: bold;">Serveur <?php echo $_GET['id']; ?></gc></a></div>     

            
            <div class="main">
                <center>
				<?php
				
					if($_GET['t'] == 1){
				?>
                    <div class="form-gest-server">
                        <table width="90%">
                            <tr>
                                <th>
                                    <div class="form-minipanel-base border-red">
                                        <title>Mémoire RAM</title>0/1500MB
                                        <img class="border-circle border-red" src="<?php echo $settings_php_page_asset; ?>/icon/ram.png">
                                    </div>
                                </th>
                                <th>
                                    <div class="form-minipanel-base border-blue">
                                        <title>CPU</title>0/100%
                                        <img class="border-circle border-blue" src="<?php echo $settings_php_page_asset; ?>/icon/cpu.png">
                                    </div>
                                </th>
                                <th>
                                    <div class="form-minipanel-base border-green">
                                        <title>Espace Disque</title>0/512Mo
                                        <img class="border-circle border-green" src="<?php echo $settings_php_page_asset; ?>/icon/disk.png">
                                    </div>
                                </th>
                                <!--<th>
                                    <div class="form-minipanel-base border-cyan">
                                        <title>test</title>
                                        <img class="border-circle border-cyan" src="<?php echo $settings_php_page_asset; ?>/icon/ram.png">
                                    </div>
                                </th>-->
                            </tr>
                            
                        </table>
                        <div class="form-gest-server-console">
                            <iframe src="http://<?php echo $donnees4['adress']; ?>:<?php echo $donnees4['port']; ?>/daemon?apikey=<?php echo $donnees4['apikey']; ?>&cmd=console.server&args1=testserv1"></iframe>
                        </div>
                        <div class="form-gest-server-btn">
                            <a class="button-start-disable" href="act.php?id=<?php echo $_GET['id'] . "&act=1"; ?>" target="_blank"><i class="fa fa-play"></i> Démarrer le serveur</a>
                            <a class="button-restart-disable" href="act.php?id=<?php echo $_GET['id'] . "&act=2"; ?>"><i class="fa fa-refresh"></i> Redémarrer le serveur </a>
                            <a class="button-stop-disable" href="act.php?id=<?php echo $_GET['id'] . "&act=3"; ?>"><i class="fa fa-power-off"></i> Stopper le serveur</a>
                            <a class="button-stop-disable" href="act.php?id=<?php echo $_GET['id'] . "&act=4"; ?>"><i class="fa fa-eraser"></i> Tuer le serveur</a>
                        </div>
                    </div>
					<?php
				}elseif($_GET['t'] == 2){
				?>
				
				<?php
				}
				
				
				
				?>
                </center>
            </div>
            <br/><br/><p class="copyright_t" style="text-align: right;margin-right: 200px;">&copy; Orme Panel by TismaDEV 2020</p>
        </div>
    </body>

</html>