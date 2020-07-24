<?php
include("../config/settings.php");
include("../config/mysql.php");
if(isset($_GET['act']))
{
    if(isset($_GET['id']))
    {
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
                $reponse2 = $bdd->query("SELECT * FROM server WHERE id='". $_GET['id'] ."'");
                $donnees2 = $reponse2->fetch();
                $reponse3 = $bdd->query("SELECT * FROM node WHERE id='". $donnees2['location_id'] ."'");
                $donnees3 = $reponse3->fetch();
                if($donnees2['proprio_id'] != $_SESSION['account_id'])
                {
                    if($donnees['admin'] != true)
                    {
                        if($donnees3['sub_id'] != $_SESSION['account_id'])
                        {
                            echo "<script language='javascript'>window.close()</script>";
                            exit;
                        }else{
                            if($_GET['act'] == 1)
                            {
                                $fileget = $file_get_contents("http://" . $donnees3['adress'] . ":8080/daemon?apikey=" . $donnees3['apikey'] . "&cmd=start.server&arg1=" . $donnees2['name']);
                            }
                            
                        }
                    }
                }
            }
        }
    }
}
?>