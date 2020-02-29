<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
include("data_validation.php");
$user_id				=	"";
$first_name				=	"";
$last_name				=	"";
$personal_photo			=	"";
$email					=	"";
$project_owner			=	"";
$skill_owner			=	"";
$invest_owner			=	"";
$is_profile_created		=	"";
$is_profile_completed	=	"";
$owned_profile_types	=	"";
$status_of_profiles		=	"";
$continuing_statement	=	"";
$project_statement		=	"";
$skill_statement		=	"";
$investment_statement	=	"";
?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<title>Reviewing of personal information</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" type="text/css" href="css/personal_info.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/personal_info.js"></script>

</head>

<body>

<div class="head_upper"> <!--Suunnitella yläpalkki 1-->
<ul id="head_upper_ul">
<li id="about_us"><a href="#">JoineMe Co.</a></li>
<li id="contact_us"><a href="#">Contact us</a></li>
<li id="languages">EN&nbsp;|&nbsp;<a href="#">FI</a></li>
</ul>
</div>

<div class="header_and_nav"> <!--Suunnitella yläpalkki 2-->
<header>
<ul id="header_ul">
<li id="logo">
<a href="index.php"><img src="images/IMG-20190617-WA0000.jpg"/></a>
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

<!---------------------------------------------------->
<!---------------------------------------------------->
<!---------------------------------------------------->

<?php
if(!empty($_SESSION["email"])) /*Asettaa mitä tapahtuu kun sähköpostin kennän ei ole jätetty tyhjänä*/
{
$email	=	$_SESSION["email"];
}
/*Noutaa kirjautuvan käyttäjän tiedot*/
$select_personal_info 	=	"
							select 
									user_id,
									first_name,
									last_name,
									personal_photo,
									email,
									project_owner,
									skill_owner,
									invest_owner,
									is_profile_created,
									is_profile_completed
									
							from
									doc_user_accounts 
							
							where
							email	=	'$email'";
							
$get_personal_info 	= 	$conn->query($select_personal_info);

if($get_personal_info->num_rows > 0) /*Asettaa mitä tapahtuu kun tietojen noutaminen on onnistuttu*/
{
$rows 					= 	$get_personal_info->fetch_assoc();
$user_id				=	$rows["user_id"];
$personal_photo			=	$rows["personal_photo"];
$first_name				=	$rows["first_name"];
$last_name				=	$rows["last_name"];
$email					=	$rows["email"];
$project_owner			=	$rows["project_owner"];
$skill_owner			=	$rows["skill_owner"];
$invest_owner			=	$rows["invest_owner"];
$is_profile_created		=	$rows["is_profile_created"];
$is_profile_completed	=	$rows["is_profile_completed"];
/*Alkaa: asettaa käyttäjän profiilin tyyppi*/
if($project_owner == 1 && $skill_owner == 1 && $invest_owner == 1)
{
$owned_profile_types	=	"Project, skill and investment";
$project_statement		=	"<a href='professional_profile.php'>My projects/companies</a>";
}
elseif($project_owner == 1 && $skill_owner == 1 && $invest_owner == 0)
{
$owned_profile_types	=	"Project and skill";
$project_statement		=	"<a href='professional_profile.php'>My projects/companies</a>";
}
elseif($project_owner == 1 && $skill_owner == 0 && $invest_owner == 1)
{
$owned_profile_types	=	"Project and investment";
$project_statement		=	"<a href='professional_profile.php'>My projects/companies</a>";
}
elseif($project_owner == 0 && $skill_owner == 1 && $invest_owner == 1)
{
$owned_profile_types	=	"Skill and investment";
}
elseif($project_owner == 1 && $skill_owner == 0 && $invest_owner == 0)
{
$owned_profile_types	=	"Project";
$project_statement		=	"<a href='professional_profile.php'>My projects/companies</a>";
}
elseif($project_owner == 0 && $skill_owner == 1 && $invest_owner == 0)
{
$owned_profile_types	=	"Skill";
}
elseif($project_owner == 0 && $skill_owner == 0 && $invest_owner == 1)
{
$owned_profile_types	=	"Investment";
}
/*Loppuu: asettaa käyttäjän profiilin tyyppi*/

/*Alkaa: asettaa käyttäjän profiilin valmistuminen*/ 
if($is_profile_created	==	1 && $is_profile_completed	==	1)
{
$status_of_profiles		=	"Profile's side is created and completed";
}
elseif($is_profile_created	==	0 && $is_profile_completed	==	0)
{
$status_of_profiles	=	"Profile's side is not created and not completed.";
}
/*Loppuu: asettaa käyttäjän profiilin valmistuminen*/ 

/*Alkaa: Suunnitella käyttäjän tietojen syöttämisen lomakkeen*/
echo <<<EOT

<div class="personal_info_container">
<table>
<tr>
	<td rowspan="6">
		<img id="personal_photo_display" src="$personal_photo" onerror="this.onerror=null; this.src='images/question_mark.png'" alt="My photo"/>
	</td>
	
	<th>
		Full name:
	</th>
	
	<td id="full_name_td">
		$first_name $last_name
	</td>
	
</tr>
	
<tr>
	<th>
		Email:
	</th>
	
	<td id="email_td">
		$email
	</td>
	
	<td rowspan="3">
		<a href="personal_info_editing.php"><i style="font-size:5em; color:#fff8d4;" class="fa fa-edit"></i></a>
	</td>
</tr>

<tr>
	<th>
		Password:
	</th>
	
	<td id="password_td">
		*******
	</td>
</tr>

<tr>
	<th>
		Owned profile types:
	</th>
	
	<td id="owned_profile_td">
		$owned_profile_types
	</td>
</tr>

<tr>
	<th>
		Status of profiles:
	</th>
	
	<td id="status_of_profile_td">
		$status_of_profiles
	</td>
</tr>

</tabel>

</div>
<table>
<tr></tr><td id="continuing_statement_frame"><div id='continuing_statement'>$project_statement</div></td>
</table>
EOT;

}
/*Loppuu: Suunnitella käyttäjän tietojen syöttämisen lomakkeen*/
?>

</body>

</html>