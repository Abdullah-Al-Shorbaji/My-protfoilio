<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/logout_process.css">
<head>
<body>
<div class="container">
<?php
/*Antaa kirjautumisen ulos vaikutuksen istunnon muuttujille*/
echo "Thank you ".$_SESSION["first_name"]." ".$_SESSION["last_name"]." for your visit to us!<br><br>Hope to see you soon!.";
unset($_SESSION["user_id"]);
unset($_SESSION["first_name"]);
unset($_SESSION["last_name"]);
unset($_SESSION["personal_photo"]);
unset($_SESSION["email"]);
unset($_SESSION["project_owner"]);
unset($_SESSION["skill_owner"]);
unset($_SESSION["invest_owner"]);
unset($_SESSION["confirmation_code"]);
unset($_SESSION["is_confirmed"]);
unset($_SESSION["is_profile_created"]);
unset($_SESSION["is_profile_completed"]);
unset($_SESSION["is_admin"]);
unset($_SESSION["is_active"]);
unset($_SESSION["personal_photo_load"]);
echo "<meta http-equiv='refresh' content='3;url=index.php'>";
?>
</div>
</body>
</html>