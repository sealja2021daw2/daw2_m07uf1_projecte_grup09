<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"]));
    else{
        include '../classcommand.php';
        include '../classfitxer.php';
        $fitxer1 = new Fitxer("../FITXERS/commands.txt");
        $linea=$fitxer1->fitxerlectura();
        $comandes="";
        $comandes=$fitxer1->visualitzarllistacomandes($linea,$_SESSION["clientid"]); 
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
         <h1>COMMANDS</h1>
     <?php
        if (!isset($_SESSION["clientid"])) echo "NO HI HA CAP SESSIO CREADA".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/index.html">INICIAR SESSIO</a>';
        else if ($comandes==null) echo "<p>No hi ha cap comanda.</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
        else echo "<p>".$comandes."</p>".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
     ?>
     </div>
</body>
</html>