<?php
    ini_set('display_errors', 1);
    session_start();
    $error=0;
    if($_POST['form_dataoption']=="2" && strlen($_POST['form_changedata'])<8) $error=1;
    else if (!isset($_SESSION["clientid"]));
    else{
        include '../classuser.php';
        include '../classfitxer.php';
        $fitxer1 = new Fitxer("../FITXERS/users.txt");
        $linea=$fitxer1->fitxerlectura();
        $existeix=$fitxer1->verificacambiusuari($linea,$_SESSION["clientid"],$_POST['form_dataoption'],$_POST['form_changedata']);
        if ($existeix==1){
            $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
            $linea=$fitxer1->fitxerlecturaEscritura();
            $newpeticio=$fitxer1->afegirpeticiomodificauser($linea,$_SESSION["clientid"],$_POST['form_dataoption'],$_POST['form_changedata']);
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
        if($error==1) echo "La contrasenya te que tindre minim 8 caracters\n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
        else if (!isset($_SESSION["clientid"])) echo "NO HI HA CAP SESSIO CREADA".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
        else if ($existeix!=1) echo "<p>El nou valor introduit es el mateix que l'actual o Aquest usuari no existeix..</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
        else echo "<p>Peticio amb exit!!! :)</p>".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">tornar</a>';
     ?>
     </div>
</body>
</html>