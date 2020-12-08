<?php
	# Inicia sessió
	session_start();
	$name=$_SESSION['clientname'];
	# Destrucció (unset) de les variables de sessió
	session_unset();
	# Neteja les cookies de sessió
	$cookie_sessio = session_get_cookie_params();
	setcookie(session_name(),'',time() - 86400, $cookie_sessio['path'], $cookie_sessio['domain'], $cookie_sessio['secure'], $cookie_sessio['httponly']); 
	# Destrucció de la sessió
	session_destroy();
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
        echo "<h1>Adeu ".$name." :( </h1>\n".' <a class="a_button" href="index.html">TORNAR :)</a>';
     ?>
</div>
</body>
</html>
