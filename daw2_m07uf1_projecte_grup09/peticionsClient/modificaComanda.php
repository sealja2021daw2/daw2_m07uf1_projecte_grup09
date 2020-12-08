<?php
    ini_set('display_errors', 1);
    session_start();
    if (!isset($_SESSION["clientid"]));
    else{
        include '../classproduct.php';
        $filename="../FITXERS/products.txt";
        $fitxer=fopen($filename,"r") or die ("No s'ha pogut obrir el fitxer");
        if ($fitxer) {
            $mida_fitxer=filesize($filename);	
            $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
        }
        $verifica=0;
        foreach ($linia as $cadena) {
            $prop=explode(';',$cadena);
            if($_POST['form_changeproduct']==$prop[1]){
                $verifica=1;
                break;
            }
        }
        fclose($fitxer);
        if($verifica !=1) echo "No existeix aquet producte";
        else{
            include '../classcommand.php';
            $filename="../FITXERS/commands.txt";
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
                if($_SESSION["clientid"]==$prop[0] && $_POST['form_changeproduct']==$prop[2]){
                    $existeixp=1;
                    break;
                }
                if($_SESSION["clientid"]==$prop[0] && $_POST['form_numcommand']==$prop[1] && $_POST['form_changeproduct']!=$prop[2]){
                    $existeix=1;  
                }
            }
            fclose($fitxer);
            if ($existeix==1){
               $filename="../FITXERS/peticions.txt";
               $newpeticio="\nModifiedcommand;".$_SESSION["clientid"].";".$_POST['form_numcommand'].";2;".$_POST['form_changeproduct'].";";
               file_put_contents($filename, $newpeticio, FILE_APPEND | LOCK_EX);
            };
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
        else if ($verifica!=1) echo "<p>Aquet producte no existeix.</p> \n".'Torna a  intentar-lo <a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
        else if ($existeixp==1) echo "<p>Ja has demanat al producte anteriorment.</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
        else if ($existeix!=1) echo "<p>Aquesta comanda no existeix.</p> \n".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
        else echo "<p>Peticio amb exit!!! :)</p>".'<a class="a_button" href="http://localhost/daw2_m07uf1_projecte_grup09/commands.html">tornar</a>';
     ?>
     </div>
</body>
</html>