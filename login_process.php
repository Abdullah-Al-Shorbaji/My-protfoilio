<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
include("data_validation.php");
$empty_email = $empty_password = $empty_confirmation_code = "";
$email = $password = $confirmation_code	= "";
$login_failure				=	"";
$pass_to_login				=	0;
$i							=	0;
$is_confirmed				=	-1;

?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<title>Login page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" type="text/css" href="css\login_process.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<!--<script src="js/login_process_jquery.js"></script>-->

</head>

<body>
<div class="head_upper"> <!--Sunnitella yläpalkki 1-->
<ul id="head_upper_ul">
<li id="about_us"><a href="#">JoineMe Co.</a></li>
<li id="contact_us"><a href="#">Contact us</a></li>
<li id="languages">EN&nbsp;|&nbsp;<a href="#">FI</a></li>
</ul>

</div>

<div class="header_and_nav">

<header><!--Sunnitella yläpalkki 2-->
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

<li id="unmembering_expression"> 
Not a member yet? click&nbsp;<a href="profile_creation.php">here</a>
</li>
</ul>
</header>

</div>
<?php
if(!empty($_SESSION["email"])) /*Asettaa mitä tapahtuu kun sähköpostin kennän ei ole jätetty tyhjänä*/
{
$_POST["email"]	= purifying_data($_SESSION["email"]);
unset($_SESSION["email"]);
}

if(isset($_POST["sign_in"])) /*Asettaa mitä tapahtuu kun kirjautumispainikkeen on painettu*/
{

$pass_to_login 	=	0;

	if($_POST["email"] == "") /*Asettaa mitä tapahtuu kun sähköpostin kennän on jätetty tyhjänä*/
	{
	$empty_email = "Please enter your email.";
	}
	else /*Asettaa mitä tapahtuu kun sähköpostin kennän ei ole jätetty tyhjänä*/
	{
	$email	=	purifying_data($_POST["email"]);
	$pass_to_login += 1;
	}

	if($_POST["passwd"] == "") /*Asettaa mitä tapahtuu kun salasanan kennän on jätetty tyhjänä*/
	{
	$empty_password = "Please enter your password.";
	}
	else /*Asettaa mitä tapahtuu kun salasanan kennän ei ole jätetty tyhjänä*/
	{
	$password		=	md5(purifying_data($_POST["passwd"]));
	$pass_to_login 	+= 	1;
	}

	if($pass_to_login == 2) /*	Asettaa mitä tapahtuu kun pakolliset kennät ei ole jätetty tyhjänä
								noutamaan käyttäjän tiedot tietokannasta*/
	{
		$email			= 	$_POST["email"];
		$password 		=	$_POST["passwd"];
		
		$check_account_availability	=	"select 
												user_id,
												first_name,
												last_name,
												personal_photo,
												email,
												project_owner,
												skill_owner,
												invest_owner,
												is_confirmed,
												confirmation_code,
												is_profile_created,
												is_profile_completed,
												is_admin,
												is_active

										from
												doc_user_accounts 

										where
												email	=	'$email'
										and		passwd	=	md5('$password');";
		$get_account	=	$conn->query($check_account_availability);
		if($get_account->num_rows > 0)
		{
				$rows = $get_account->fetch_assoc();

				if($rows["is_active"] != 0)
				{/*Asettaa käyttäjän muutujat*/
					$_SESSION["user_id"]				=	$rows["user_id"];
					$_SESSION["first_name"]				=	$rows["first_name"];
					$_SESSION["last_name"]				=	$rows["last_name"];
					$_SESSION["personal_photo"]			=	$rows["personal_photo"];
					$_SESSION["email"]					=	$rows["email"];
					$_SESSION["project_owner"]			=	$rows["project_owner"];
					$_SESSION["skill_owner"]			=	$rows["skill_owner"];
					$_SESSION["invest_owner"]			=	$rows["invest_owner"];
					$_SESSION["is_confirmed"]			=	$rows["is_confirmed"];
					$_SESSION["confirmation_code"]		=	$rows["confirmation_code"];
					$_SESSION["is_profile_created"]		=	$rows["is_profile_created"];
					$_SESSION["is_profile_completed"]	=	$rows["is_profile_completed"];
					$_SESSION["is_admin"]				=	$rows["is_admin"];
					$_SESSION["is_active"]				=	$rows["is_active"];
					$_SESSION["personal_photo_load"]	=	1;

					$is_confirmed		=	$rows["is_confirmed"];

					if($is_confirmed	==	1)
					{/*Asettaa Onnestumisen viestin  näyttäminen*/
						echo "	<div id='transparency_body' name='transparency_body'>
								<div id='modal_content1' name='modal_content1'>
								<p id='successful_detail'>Welcome back dear!<br>Lets go!</p>
								</div>
								</div>
								<script>
								var t_body = document.getElementById('transparency_body');
								t_body.style.display = 'block';
								</script>";	
						if($rows["project_owner"]	==	1)
						{/*Asettaa siirtymisen projektin luontisivulle*/
						$user_id = $rows["user_id"];
						$check_profile = $conn->query("	select 	1 
														from 	joinme_acts.act_project_profiles
														where 	user_id 	=	$user_id
														and		is_active 	=	1");
							if($check_profile->num_rows > 0)
							{
							echo "<meta http-equiv='refresh' content='2;url=index.php'>";
							}
							else
							{
							echo "<meta http-equiv='refresh' content='2;url=professional_profile_creation.php'>";
							}
						}
						else
						{
						echo "<meta http-equiv='refresh' content='2;url=index.php'>";
						}
					}
					else
					{
					echo "<meta http-equiv='refresh' content='0.1;url=confirmation_process.php'>";
					}
				}
				else
				{
				echo "<div id='login_failure'>This account is deactivated, contact the site's administration to activate it.</div>";
				}
		}
		else
		{
			try
			{
				$login_failure = "<div id='login_failure'>There's no account with given email and password.</div>\r\n<div id='login_failure'>If you aren't a member yet, click&nbsp;<a href='profile_creation.php'>here</a>&nbsp;to join us</div>";
				throw new Exception($login_failure);
			}
			
			catch(Exception $e)
			{}
		}
	}
		

}

?>
<div>
<!--Asettaa kirjautumislomakkeen-->
<form id="form_container" class="form_container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<legend id="form_title">Welcome back!</legend>
<fieldset class="form_frame">

<table id="login_table">

<tr id="row">
<td id="cel1"><label>Email:</label></td>
<td id="cel2"><input type="email" id="email" value="<?php if(isset($_POST["email"])){echo $_POST["email"];} ?>" name="email"/><span>*</span>
<span><?php echo "<br>".$empty_email; ?></span></td>
</tr>

<tr id="row">
<td id="cel1"><label>Password:</label></td>
<td id="cel2"><input type="password" id="passwd" value="<?php if(isset($_POST["passwd"])){echo $_POST["passwd"];} ?>" name="passwd"/><span>*</span>
<span><?php echo "<br>".$empty_password; ?></span></td>
</tr>

<tr id="row">
<td id="cel1"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
<td id="cel2">
<button style="outline:none; border: 1px solid #e8e0c1;" id='clear_all' name='clear_all' class='clear_all' type='reset'>Clear all</button>
<button style="outline:none; border: 1px solid #e8e0c1;" id="sign_in" name="sign_in" class='sign_in' type='submit'>Sign in</button>
</td>
</tr>

</table>

</fieldset>
</form>

</div>
<div id="login_failure" name="login_failure"><?php echo $login_failure; ?></div>
</body>

</html>