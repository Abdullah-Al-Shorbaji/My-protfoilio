<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
include("data_validation.php");
?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<title>JoinMe homepage</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/index.js"></script>

</head>

<body>
<div class="head_upper"> <!--Suunnitella yläpalkki 1-->
<ul id="head_upper_ul">
<li id="about_us"><a href="#">JoineMe Co.</a></li>
<li id="contact_us"><a href="#">Contact us</a></li>
<li id="languages">EN&nbsp;|&nbsp;<a href="#">FI</a></li>
</ul>

</div>
<div class="header_and_nav">
<header> <!--Suunnitella yläpalkki 2-->

<ul id="header_ul">
<li id="logo">
<img src="images/IMG-20190617-WA0000.jpg"/>
</li>
<li id="nav_ul_outer_frame"> <!--Suunnitella rekisteröidyin profiileidin tyyppien linkit-->
	<ul class="nav_ul">
	<li id="projects"><a href="#">Projects/Companies</a></li>
	<li id="skills"><a href="#">Skills</a></li>
	<li id="investments"><a href="#">Invetments</a></li>
	</ul>
</li>

<?php

if (isset($_SESSION["user_id"])) /*Asettaa oikea yläkulma kun joku käyttäjä on kirjautunut sisään*/
{
$name_personal_area		= 	$_SESSION["first_name"]." ".$_SESSION["last_name"];
$email_personal_area	=	$_SESSION["email"];
$personal_photo			=	$_SESSION["personal_photo"];
/*Alkaa: suunnitella omaisen tietojen linkin lista*/
echo <<<EOT
<li id="membering_expression">
	<ul class="login_group_ul">
	<li id="me_li">Me</li>
	<li id="icon_li">
	<div class="personal_area_frame">
	<i id="icon" class="fa fa-caret-down" style="font-size:27px;"></i>
	<table class="personal_area">
	<tr id="tr1">
		<th>
		<span id="name_personal_area"><strong>{$name_personal_area}</strong></span>
		<br>
		<span id="email_personal_area">{$email_personal_area}</span>
		</th>
	</tr>

	<tr id="tr2">
		<td>
		<a href="personal_info.php">My personal information</a>
		</td>
	</tr>	

	<tr id="tr3">
		<td>
		<a href="#">My account</a>
		</td>
	</tr>

	<tr id="tr4">
		<td>
		<a href='logout_process.php'><i class='fa fa-power-off' style='font-size:30px;'></i></a>
		</td>
	</tr>
	</table>
	</div>
	</li>
	<li id="personal_photo_li"><span id="personal_photo_span"><img src="$personal_photo" onerror="this.onerror=null; this.src='images/question_mark.png'" alt="My photo" id="personal_photo" name="personal_photo"/></span></li>
	
	</ul>	
</li>
EOT;
/*Loppuu: suunnitella omaisen tietojen linkin lista*/
}
else /*Asettaa oikea yläkulma kun kokaan käyttäjä ei ole kirjautunut sisään*/
{
/*Suunnitella tuntematon käyttäjän tilnteen*/
echo "<li id='unmembering_expression'><a href='login_process.php'>Sign in</a>, not yet a member? click&nbsp;<a href='profile_creation.php'>here</a></li>";
}

?>
</ul>
</header>


</div>
<!--Asettaa esittelykuvat-->
<div class="sl-content sl-section" id="website_introduction" style="width: 100%; margin-top: 0; top: 0;">
	<img id="website_introduction_image1" class="mySlides sl-animate-fading" src="images/figure-3277576_1920.jpg">
	<img id="website_introduction_image1" class="mySlides sl-animate-fading" src="images/teamwork-3276682_1920.jpg">
	<img id="website_introduction_image1" class="mySlides sl-animate-fading" src="images/teamwork-3275561_1920.jpg">
	<img id="website_introduction_image1" class="mySlides sl-animate-fading" src="images/teamwork-3275565_1920.jpg">
</div>

<script>
/*Suorittaa kuvien liukuminen*/
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 5000);    
}

</script>

<div class="search_frame"> <!--Sunnitella haun tilan-->

<form class="search_form" action="index.php" method="post">
<ul id="search_form_list">
<li id="search_keyword_li">
<input id="search_keyword" name="search_keyword" type="text" placeholder="Search in projects, skills and investments"/>
</li>
<li id="search_icon_frame_li">
<!-- <img src="images/seo-1970475_1280.png"/> -->
<div id="search_icon_frame"><i style="	font-size:			2em; 
										color:				#fffdf2;
										margin:	auto;				" class="fa fa-search" aria-hidden="true"></i></div>
</li>
</ul>
</form>

</div>

<div class="one_event_container"> <!--Sunnitella äskettäin lisätyt projektit-->
<h3>Recent added projects/companies</h3>
</div>

<div class="one_event_container"><!--Sunnitella äskettäin lisätyt taidot-->
<h3>Recent added skills</h3>
</div>

<div class="one_event_container"><!--Sunnitella äskettäin lisätyt sijoitukset-->
<h3>Recent added investments</h3>
</div>

</body>

</html>