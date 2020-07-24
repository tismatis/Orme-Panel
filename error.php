<center><h1>ERREUR <?php echo $_GET['error']; ?></h1>
<?php 
$var = "";
if($_GET['error'] == 401)
{
    $var = "Vous n'êtes pas autorisé à venir sur cette page.";
}
?>
<h4><?php echo $var; ?></h4></center>