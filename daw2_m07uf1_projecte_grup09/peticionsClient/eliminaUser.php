<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"]));
    else{
        include '../classfitxer.php';
        include '../classuser.php';
        $fitxer1 = new Fitxer("../FITXERS/users.txt");
        $linea=$fitxer1->fitxerlectura();
        $verifica=null;
        $verifica=$fitxer1->visualitzardadespersonals($linea,$_SESSION["clientname"]);
        if ($verifica!=null){
            $fitxer1 = new Fitxer("../FITXERS/peticions.txt");
            $linea=$fitxer1->fitxerlecturaEscritura();
            $newpeticio=$fitxer1->afegirpeticioeliminauser($linea,$_SESSION["clientid"]);
        };
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
        else if ($verifica==null) echo "<p>No existeix aquet usuari.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/clientprincipal.html">Sortir</a>';
        else echo "<p>Peticio amb exit!!! :)</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/logout.php">Sortir</a>';
     ?>
     </div>
</body>
</html>