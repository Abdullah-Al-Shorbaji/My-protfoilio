<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/login_successful.css">
</head>
<body>
<div class="container"> <!--Suunnitella Onnistumisen viestin-->
<?php
echo "<div id='creation_successful'>An email with code have been sent to you to confirm your email in first login.</div>";
echo "<meta http-equiv='refresh' content='5;url=login_process.php'>";
?>
</div>
</body>
</html>