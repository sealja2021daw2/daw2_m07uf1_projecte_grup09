<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"]));
    else{
        include '../classuser.php';
        $filename="../FITXERS/users.txt";
        $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
        if ($fitxer) {
            $mida_fitxer=filesize($filename);	
            $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
        }
        $comandes="";
        $existeix=0;
        $existeixp=0;
        foreach ($linia as $cadena){
            $prop=explode(';',$cadena); 
            if($_SESSION["clientid"]==$prop[0] && $_POST['form_changedata']==$prop[$_POST['form_dataoption']]){
                $existeixp=1;
                break;
            }
            if($_SESSION["clientid"]==$prop[0]){
                $existeix=1;
                break;
            }
        }
        fclose($fitxer);
        if ($existeix==1){
            $filename="../FITXERS/peticions.txt";
            $newpeticio="\nModifieduser;".$_SESSION["clientid"].";".$_POST['form_dataoption'].";".$_POST['form_changedata'].";";
            file_put_contents($filename, $newpeticio, FILE_APPEND | LOCK_EX);
        }
    }           
?>
<html>
<head>
     <meta content="text/html" charset="UTF-8" http-equiv="content-type"/>
     <link href="../CSS/projecte.css" rel="stylesheet" type="text/css"/>
	<title>projecte</title>
</head>
<body>
     <div class="contingut_centrat">
         <h1>REQUEST</h1>
     <?php
        if (!isset($_SESSION["clientid"])) echo "NO HI HA CAP SESSIO CREADA".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
        else if ($existeixp==1) echo "<p>El nou valor introduit es el mateix que l'actual.</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
        else if ($existeix!=1) echo "<p>Aquest usuari no existeix.</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
        else echo "<p>Peticio amb exit!!! :)</p>".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
     ?>
     </div>
</body>
</html>