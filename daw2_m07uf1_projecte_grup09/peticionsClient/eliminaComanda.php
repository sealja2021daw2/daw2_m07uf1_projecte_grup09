<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"]));
    else{
        $filename="../FITXERS/commands.txt";
        $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
        if ($fitxer) {
            $mida_fitxer=filesize($filename);	
            $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
        }
        $verifica=0;
        foreach ($linia as $cadena) {
            $prop=explode(';',$cadena);
            if($_POST['form_numcommand']==$prop[1] && $_SESSION["clientid"]==$prop[0] ){
                $verifica=1;
                break;
            }
        }
        if ($verifica==1){
            $filename="../FITXERS/peticions.txt";
            $newpeticio="\nDeletecommand;".$_SESSION["clientid"].";".$_POST['form_numcommand'].";";
            file_put_contents($filename, $newpeticio, FILE_APPEND | LOCK_EX);
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
        else if ($verifica!=1) echo "<p>Aquesta comanda no existeix.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
        else echo "<p>Peticio amb exit!!! :)</p>".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
     ?>
     </div>
</body>
</html>