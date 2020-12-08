<?php 
    ini_set('display_errors', 1);
    session_start();
    include "../classuser.php";
    $filename='../FITXERS/users.txt';
    $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
    if ($fitxer) {
        $mida_fitxer=filesize($filename);	
        $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
    }
    $estat=0;
    foreach ($linia as $cadena) {
        $prop=explode(';',$cadena);
        if($_SESSION["clientname"] == $prop[1]){
            $estat=1;
            $usuari=new Client($prop[0],$prop[1],$prop[2],$prop[3],$prop[4],$prop[5],$prop[6],$prop[7]);
            break;
        }
    }
    fclose($fitxer);
?>
<html>
<head>
     <meta content="text/html" charset="UTF-8" http-equiv="content-type"/>
	<link href="../CSS/projecte.css" rel="stylesheet" type="text/css"/>
	<title>projecte</title>
</head>
<body>
<div class="contingut_centrat">
     <?php
     ini_set('display_errors', 1);
        if($estat==1){
            echo "<p>".$usuari->toString()."</p>".'<a class="a_button" href="../clientprincipal.html">tornar</a>';
        }else echo "<p>error en la sessio</p>".'<a class="a_button" href="../clientprincipal.html">tornar</a>';
     ?>
</div>
</body>
</html>