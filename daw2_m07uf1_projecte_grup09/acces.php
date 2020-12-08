<?php
    ini_set('display_errors', 1);
    session_start();
    if (isset($_SESSION['clientid'])){
        $where=0;
        if($_SESSION['clientname']=="admin") $where=1;    
    }else{
        include 'classuser.php';
        $estat=0;
        if($_POST['form_useri']==$admin->user && $_POST['form_passwordi']==$admin->password){
            $_SESSION['clientname'] = $admin->user;
            $_SESSION['clientid'] = $admin->id;
            $estat=1;
        }else{
            $filename="FITXERS/users.txt";
            $fitxer=fopen($filename,"r+") or die ("No s'ha pogut obrir el fitxer");
            if ($fitxer) {
                $mida_fitxer=filesize($filename);	
                $linia = explode(PHP_EOL, fread($fitxer,$mida_fitxer));
            }
            foreach ($linia as $cadena) {
                $prop=explode(';',$cadena);
                if($_POST['form_useri'] == $prop[1] && $_POST['form_passwordi']==$prop[2]){
                    $estat=1;
                    $usuariacces=new Client($prop[0],$prop[1],$prop[2],$prop[3],$prop[4],$prop[5],$prop[6],$prop[7]);
                    $_SESSION['clientname'] = $usuariacces->user;
                    $_SESSION['clientid'] = $usuariacces->id;
                    break;
                }
            }
            fclose($fitxer);
        }
    }
?>
<html>
<head>
     <meta content="text/html" charset="UTF-8" http-equiv="content-type"/>
	<link href="CSS/projecte.css" rel="stylesheet" type="text/css"/>
	<title>projecte</title>
</head>
<body>
<div class="contingut_centrat">
     <?php
        ini_set('display_errors', 1);
        if (isset($where)){ 
            if($where==1) echo "<h1>No habias tancat la sessio amb l'usuari ". $_SESSION['clientname']."</h1>\n".' <a class="a_button" href="adminprincipal.html">ACCEDEIX</a>';
            else echo "<h1>No habias tancat la sessio amb l'usuari ".$_SESSION['clientname']."</h1>\n".' <a class="a_button" href="clientprincipal.html">ACCEDEIX</a>';
        }else if(!isset($_SESSION['clientname'])) echo "Usuari o contrasenya incorrecta\n".'<a class="a_button" href="index.html">LOGIN</a>';
        else if($_SESSION['clientname']=="admin") echo "<h1>Hola de nou ".$admin->user."</h1>\n".' <a class="a_button" href="adminprincipal.html">ACCEDEIX</a>';
        else echo "<h1>Hola de nou ".$usuariacces->user."</h1>\n".' <a class="a_button" href="clientprincipal.html">ACCEDEIX</a>';
        exit(0);
     ?>
</div>
</body>
</html>