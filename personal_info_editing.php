<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
include("data_validation.php");
require_once("PHPMailer/PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer/PHPMailer-master/src/SMTP.php");
require_once("PHPMailer/PHPMailer-master/src/Exception.php");
require_once("PHPMailerAutoload.php");
include("config.php");

$empty_first_name 			=	"";
$empty_last_name 			=	"";
$empty_email 				=	"";
$empty_password 			=	"";
$empty_confirm_password 	=	"";
$empty_profile_type 		=	"";

$user_id					=	"";
$first_name 				=	"";
$last_name 					=	"";
$personal_photo 			=	"";
$personal_pic 				=	"";
$email 						=	"";
$passwd 					=	"";
$confirm_passwd 			=	"";
$project_owner 				=	"";
$skill_owner 				=	"";
$invest_owner 				=	"";
$is_profile_created 		=	"";
$is_profile_completed 		=	"";
$profile_type 				=	"";

$new_first_name 			=	"";
$new_last_name 				=	"";
$new_personal_photo 		=	"";
$new_email 					=	"";
$new_passwd 				=	"";
$new_project_owner 			=	"";
$new_skill_owner 			=	"";
$new_invest_owner 			=	"";

$initiate_first_name 		=	"";
$initiate_last_name 		=	"";
$initiate_personal_photo 	=	"";
$initiate_email 			=	"";
$initiate_passwd 			=	"";
$initiate_project_owner 	=	"";
$initiate_skill_owner 		=	"";
$initiate_invest_owner 		=	"";

$update_statement			=	"is_active=is_active";

$personal_photo_value		=	"";
$show_hide_x				=	"";
$photo_changed				=	0;

$have_project = $have_skill = $have_investment = 0;
$pass_to_insert 			= 	0;
$is_a_duplicated_email		= 	0;
$duplicate_result			=	"";
$is_not_matched_password	= 	0;
$matching_result			=	"";
$checkbox_array_id			=	0;
$save_confirmation_code		=	"";
$create_new_user 			=	"";
$empty_personal_photo		=	"";
$personal_photo_title		=	"Add personal photo";
$fileDestination			=	"";
$upload_successful			=	0;
$personal_photo_directory	=	"personal_photos";
$count_of_duplicated_images	=	1;
$personal_photo_html		=	"";
$alternative_first_name		=	0;
$alternative_last_name		=	0;
$alternative_email			=	0;
$alternative_passwd			=	0;
$alternative_c_passwd		=	0;
$alternative_project		=	0;
$alternative_skill			=	0;
$alternative_investment		=	0;
$files 						=	"";
$filesName					=	"";
$filesType					=	"";
$filesTmpName				=	"";
$filesError					=	"";
$filesSize					=	"";
$filesExt					=	"";
$filesActualExt				=	"";
$FilesAllowedExt			=	"";
?>
<html>
<head> <!--Yhteyttää sivun ulko asetuksille -->
<title>Editing of personal perofile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" type="text/css" href="css\personal_info_editing.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="js/personal_info_editing2.js"></script>
<script src="js/personal_info_editing_jquery.js"></script>

</head>
<!--Suunnitella yläpalkki 1-->
<body onload="check_recatcha(); reset_image();">
<div class="head_upper">
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
<a href="index.php"><img src="images/IMG-20190617-WA0000.jpg"/></a>
</li>
<li id="nav_ul_outer_frame"> <!--Suunnitella rekisteröidyin profiileidin tyyppien linkit-->
	<ul class="nav_ul">
	<li id="projects"><a href="#">Projects/Companies</a></li>
	<li id="skills"><a href="#">Skills</a></li>
	<li id="investments"><a href="#">Invetments</a></li>
	</ul>
</li>
<!--
<ul id="header_ul">
<li id="logo"><a href="index.php"><img src="images/IMG-20190617-WA0000.jpg"/><span id="website_name">JoinMe</span></a></li>
<li>
<ul class="nav_ul">
<li id="projects"><a href="#">Projects/Companies</a></li>
<li id="skills"><a href="#">Skills</a></li>
<li id="investments"><a href="#">Invetments</a></li>
</ul>
</li>
-->
<?php

if (isset($_SESSION["user_id"])) /*Asettaa oikea yläkulma kun joku käyttäjä on kirjautunut sisään*/
{
/*----------Me:n listan näyttäminen----------*/
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
	<li id="personal_photo_li"><span id="personal_photo_span"><img src="$personal_photo" onerror="this.onerror=null; this.src='images/question_mark.png'" alt="My photo" id="personal_photo_nav" name="personal_photo_nav"/></span></li>
	
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

<?php

if (isset($_SESSION["user_id"]))
{
/*-------------Nykyinen henkilön tiedot noutaminen-------------*/
$user_id	=	$_SESSION["user_id"];
	if(
		$get_personal_info = $conn->query("
											select 
													user_id,
													first_name,
													last_name,
													personal_photo,
													email,
													passwd,
													project_owner,
													skill_owner,
													invest_owner,
													is_profile_created,
													is_profile_completed
											
											from
													doc_user_accounts 
											
											where
													user_id	=	$user_id
											"))
	{
		if($get_personal_info->num_rows > 0)
		{/*Asettaa kirjauduttu sisään käyttäjän tiedot*/
			$p_rows			=	$get_personal_info->fetch_assoc();
			$user_id		=	$p_rows["user_id"];
			$first_name		=	$p_rows["first_name"];
			$last_name 		=	$p_rows["last_name"];
			$personal_pic 	=	$p_rows["personal_photo"];
			$email 			=	$p_rows["email"];
			$passwd			=	$p_rows["passwd"];
			$project_owner 	=	$p_rows["project_owner"];
			$skill_owner 	=	$p_rows["skill_owner"];
			$invest_owner	=	$p_rows["invest_owner"];
		}
	}
}

if(isset($_FILES["file"]))
{
/*------------Ladatun kuvan tiedot asettaminen-------------*/
	$files 				=	$_FILES["file"];
	$show_hide_x		=	"display:block";
	$filesName			=	$files["name"];
	$filesType			=	$files["type"];
	$filesTmpName		=	$files["tmp_name"];
	$filesError			=	$files["error"];
	$filesSize			=	$files["size"];
	
	$filesExt			=	explode(".", $filesName);
	$filesActualExt		=	strtolower(end($filesExt));
	$FilesAllowedExt	=	array("jpg", "jpeg", "gif", "png");
	
}

if(isset($_POST["clear_image"]))
{
/*------------Ladatun kuvan tiedot tyhjeneminen-------------*/
	$show_hide_x		=	"display:none";
	$files				=	"";
	$filesName			=	"";
	$filesType			=	"";
	$filesTmpName		=	"";
	$filesError			=	"";
	$filesSize			=	"";
	$fileDestination	=	"images/question_mark.png";
	$personal_pic		=	"";
	$_SESSION["personal_photo_load"]		=	0;
}

if(isset($_POST["perform_update"]))
{
/*-----------Päivittäminen toiminta-----------*/
$pass_to_insert = 0;
/*---------------------------*/	

	if($filesName	!=	"")
	{
	/*---------Kuvan lataaminen---------*/
		if(in_array($filesActualExt, $FilesAllowedExt)) /*Kun valitulla kuvalla on sopiva tiedostopääte*/
		{
			if($filesError	===	0) /*Kun valitulla kuvalla ei ole mitään virheita*/
			{
				if($filesSize < 5242880) /*Kun valitun kuvan on yhtä sama tai alle kuin sallittu koko*/
				{
					$handle = opendir(dirname(realpath(__FILE__))."/$personal_photo_directory/" );
					while($file = readdir($handle)) /*Tarkistaa jos valittu kuva on monistettu*/
					{
					preg_match_all('!\d+!', $file, $matches);
					  if($file !== '.' && $file !== '..' && $matches[0][0] == 2)
					  {
						$count_of_duplicated_images++;
					  }
					}
				/*Uuden kuvan nimen perustaminen*/
				$filesNewName		=	uniqid("", true).".".$filesActualExt;
				$fileDestination	=	"$personal_photo_directory/".$user_id."_".$count_of_duplicated_images."_".$filesNewName;
				$update_statement	.=	", personal_photo = '$fileDestination'";
				move_uploaded_file($filesTmpName, $fileDestination);
				$upload_successful	=	1;
				}
				else
				{
				echo "File size exceed the allowed (5M)!";
				}
			}
			else
			{
			echo "An error in uploading file!";
			}
		}
		else
		{
		echo "Invalid file type";
		}
	}

	if(isset($_POST["clear_image"]))
	{
	/*------------Ladatun kuvan tiedot tyhjeneminen-------------*/
	$fileDestination	=	"images/question_mark.png";
	}	

/*---------------------------*/	

	/*---------Etunimen asettaminen----------*/
	if($_POST["first_name"] == "")
	{
	$empty_first_name = "Please enter your first name.";
	}
	else
	{
	$new_first_name	=	purifying_data($_POST["first_name"]);
		if($new_first_name != $first_name)
		{
		$update_statement .= ", first_name = '$new_first_name'";
		}
	$pass_to_insert += 1;
	}

	/*---------Sukunimen asettaminen----------*/
	if($_POST["last_name"] == "")
	{
	$empty_last_name = "Please enter your last name.";
	}
	else
	{
	$new_last_name	=	purifying_data($_POST["last_name"]);
		if($new_last_name != $last_name)
		{
		$update_statement .= ", last_name = '$new_last_name'";
		}	
	$pass_to_insert += 1;
	}
	if(!empty($_POST["clear_image"]))
	{
	$update_statement .= ", personal_photo = ''";
	}
	
	/*---------Sähköpostin asettaminen----------*/
	if($_POST["email"] == "")
	{
	$empty_email = "Please enter your email.";
	}
	else
	{
	$new_email	=	purifying_data($_POST["email"]);
	$pass_to_insert += 1;
	$check_duplicate_email = "select 1 duplicate_flag from doc_user_accounts where email = '$email' and user_id <> $user_id";
	$get_email = $conn->query($check_duplicate_email);
	
		if($get_email->num_rows > 0)
		{
		$rows = $get_email->fetch_assoc();
		$is_a_duplicated_email = $rows["duplicate_flag"];

			try
			{
				if($is_a_duplicated_email == 1)
				{
				$duplicate_result = "Email you entered already exists. If you're already a member, click&nbsp;<a href='login_process.php'>here</a>&nbsp;to sign in";
				throw new Exception($duplicate_result);
				}
			}
			
			catch(Exception $e)
			{}
		
		}
		if($new_email != $email)
		{
		$update_statement .= ", email = '$new_email'";
		}
	}
	
	/*---------Salasanan asettaminen----------*/	
	if($_POST["passwd"] == "")
	{
	$empty_password = "Please enter your password.";
	}
	else
	{
	$new_passwd	=	md5(purifying_data($_POST["passwd"]));
		if($new_passwd != $passwd)/*Kun profiilin salasana on vaihdettu*/
		{/*Asettaa päivytyksen lauseetta päivittämään salasanan*/
		$update_statement .= ", passwd = '$new_passwd'";
		}	
	$pass_to_insert += 1;
	}
	
	/*---------Salasanan vahvistuksen asettaminen----------*/	
	if( ($_POST["c_passwd"] == "") || ($_POST["c_passwd"] == null))
	{
	$empty_confirm_password = "Please confirm your password.";
	}
	else
	{
		if(($new_passwd != "") && ($_POST["passwd"] != $_POST["c_passwd"]))
		{/*Asettaa huomion viesti kun salasana ja sen vahvistussana eivät vastaa*/
		$empty_confirm_password = "Passwords aren't identical.";
		try {throw new Exception("A");}
		catch(Exception $e){}
		}
	$confirm_password	=	purifying_data($_POST["c_passwd"]);
	$pass_to_insert += 1;
	}

	/*---------Projektin valinnan asettaminen----------*/
	if(isset($_POST["project"]))
	{
	$new_project_owner  =	$_POST["project"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$new_project_owner =	0;
	}

		if($new_project_owner  != $project_owner)/*Kun projektin profiilin tyypin valinnan on vaihdettu*/
		{/*Asettaa päivytyksen lauseetta päivittämään tämän valinnan*/
		$update_statement .= ", project_owner = $new_project_owner";
		}
	
	/*---------Taidon valinnan asettaminen----------*/
	if(isset($_POST["skill"]))
	{
	$new_skill_owner =	$_POST["skill"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$new_skill_owner =	0;
	}

		if($new_skill_owner  != $skill_owner)/*Kun taidon profiilin tyypin valinnan on vaihdettu*/
		{/*Asettaa päivytyksen lauseetta päivittämään tämän valinnan*/
		$update_statement .= ", skill_owner = $new_skill_owner";
		}	
	
	/*---------Sijoituksen valinnan asettaminen----------*/
	if(isset($_POST["investment"]))
	{
	$new_investment_owner =	$_POST["investment"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$new_investment_owner =	0;
	}

		if($new_investment_owner  != $invest_owner)/*Kun sijoituksen profiilin tyypin valinnan on vaihdettu*/
		{/*Asettaa päivytyksen lauseetta päivittämään tämän valinnan*/
		$update_statement .= ", invest_owner = $new_investment_owner";
		}
		
	/*---------Profiilin tyyppin asettaminen----------*/
	if ($checkbox_array_id == 0)
	{
	$empty_profile_type = "Please select what do you have(at least one).";
	}
	else
	{
	$pass_to_insert += 1;
	}
	
	/*--------Päivytyksen suorittaminen---------*/	
	if($pass_to_insert == 6)/*Kun kaikki tarpeet päivityksen kentät ovat onnistu*/
	{
		if(strlen($update_statement) > 19)/*Kun jotain päivityksen lauseita on lisätty alkuperäiselle päivityksen lauseelle*/
		{
			$save_new_info = "update doc_user_accounts set $update_statement where user_id = $user_id";
		
			if($conn->query($save_new_info))/*Todellisen päivityksen prosessin suorittaminen*/
			{
			/*Alkaa: Vahvistuksen koodin sähköpostin lähettäminen*/
			
			/*Alkaa: Sähköpostin lähettämisen muuttujat asettaminen*/
			$c_code				=	strtoupper(substr(md5(microtime()),rand(0,26),5));
			$_SESSION["email"]	=	$to		=	$_POST["email"];
			$mail = new PHPMailer\PHPMailer\PHPMailer();

			$mail->SMTPDebug = false;

			$mail->isSMTP();
			$mail->Host = "smtp.gmail.com";
			$mail->SMTPAuth = true;
			$mail->Username = smpt_user;
			$mail->Password = smpt_password;
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom(smpt_user, "Abdullah Al-Shorbaji");
			$mail->addAddress($_POST["email"], $_POST["first_name"]." ".$_POST["last_name"]);     // Add a recipient
			$mail->addReplyTo(smpt_user, "Abdullah Al-Shorbaji");
			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = "Confirmation code for JoinMe.fi";
			$mail->Body    = "	<table style='text-align: left;'>
									<tr>
										<th style='	font-size:		2em;
													color:			#1d4096;
													border-bottom: 	3px dashed #3a63c7; 
													padding-bottom:	10px;
													width:			auto;
													height:			auto;'>
										Hi <strong>".$_POST["first_name"]." ".$_POST["last_name"]."</strong><br>
										</th>
									</tr>

									<tr>
										<td style='	font-size:		1.5em;
													color:			#557ee0;
													border-top: 	3px dashed #3a63c7;
													padding-top:	10px;
													width:			auto;
													height:			auto;'>
										Thank you for joining us in JoinMe.
										<br>
										Your confirmation code is: <span style='color:#1d4096;'>".$c_code."</span>
										</td>
									</tr>
								</table>";
				/*Loppuu: Sähköpostin lähettämisen muuttujat asettaminen*/
				if(!$mail->send())/*Kun Sähköpostin lähettäminen ei onnistunut*/
				{
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}
				else
				{/*Sähköpostin lähettämisen suorittaminen*/
					$save_confirmation_code	=	"update doc_user_accounts set confirmation_code = '$c_code', is_confirmed = 0 where user_id = '$user_id'";
					$perfom_saving = $conn->query($save_confirmation_code);
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
					$_SESSION["personal_photo_load"] = 1;
					echo "	<div id='transparency_body' name='transparency_body'>
							<div id='modal_content' name='modal_content'>
							<p id='successful_detail'><strong id='successful_title'>Re-login request!</strong><br>Due to you personal info is modified, you should re-login to be modification(s) take effect. And for the security need, a confirmation code sent to your email to confirm again your email address</p>
							</div>
							</div>
							<script>
							var t_body = document.getElementById('transparency_body');
							t_body.style.display = 'block';
							</script>";
					echo "<meta http-equiv='refresh' content='5;url=login_process.php'>";
				}
			/*Loppuu: Vahvistuksen koodin sähköpostin lähettäminen*/
			}

		}
		else
		{/*Kun ei mitään päivitystä lausetta on lisätty alkuperäiselle päivityksen lauseelle*/
		$_SESSION["personal_photo_load"] = 1;
		echo "	<div id='transparency_body1' name='transparency_body1'>
							<div id='modal_content1' name='modal_content1'>
							<p id='successful_detail1'><strong id='successful_title1'>No modifications are made!</strong></p>
							</div>
							</div>
							<script>
							var t_body = document.getElementById('transparency_body1');
							t_body.style.display = 'block';
							</script>";
		echo "<meta http-equiv='refresh' content='3;url=index.php'>";
		}
	}
	else/*Kun ei kaikkia tarpeita päivityksen kentät ovat onnistu*/
	{
		$first_name		=	"";
		$last_name 		=	"";
		$email 			=	"";
	}
}


/*Alkaa: Käyttäjän tiedojen näyttämisen lomakkeen suunnitteleminen*/
echo <<<EOT
<div>

<form class='form_container' action='personal_info_editing.php' method='post' enctype='multipart/form-data'>
<h2 id='form_title'>Welcome to join JoinMe</h2>
<fieldset class='form_frame'>
<ul class='upload_list'>
<li id='image_li'>
<span class='cabinet'>
EOT;

/*-------------Nykyinen henkilön kuvan näyttäminen---------*/
if($personal_pic == "")
{
$personal_photo_value = "images/question_mark.png";
}
else
{
$personal_photo_value = "$personal_pic";
}
$personal_photo_html = "<img id='personal_photo' name='personal_photo' src='$personal_photo_value' onerror='this.onerror=null; this.src='images/question_mark.png'' alt='My photo'/>";
echo $personal_photo_html;

/*-------------Nykyinen etunimen näyttäminen---------*/
if($alternative_first_name	==	0)
{
$initiate_first_name	=	$first_name;
$alternative_first_name	=	1;
}
else
{
$initiate_first_name	=	"";
}

/*-------------Nykyinen sukunimen näyttäminen---------*/
if($alternative_last_name	==	0)
{
$initiate_last_name		=	$last_name;
$alternative_last_name	=	1;
}
else
{
$initiate_last_name		=	"";
}

/*-------------Nykyinen sähköpostin näyttäminen---------*/
if($alternative_email	==	0)
{
$initiate_email		=	$email;
$alternative_email	=	1;
}
else
{
$initiate_email		=	"";
}

/*-------------Nykyinen projektin valinnan arvon näyttäminen---------*/
if($alternative_project	==	0)
{
$initiate_project_owner	=	$project_owner;
$alternative_project	=	1;
}

/*-------------Nykyinen taidon valinnan arvon näyttäminen---------*/
if($alternative_skill	==	0)
{
$initiate_skill_owner	=	$skill_owner;
$alternative_skill	=	1;
}

/*-------------Nykyinen sijoituksen valinnan arvon näyttäminen---------*/
if($alternative_investment	==	0)
{
$initiate_investment_owner	=	$invest_owner;
$alternative_investment	=	1;
}

echo "
</span>
<table id='removing_photo' style='$show_hide_x'>
<th id='clear_image_title'>
Remove photo on updating:&nbsp;&nbsp;
</th>
<td>
<input type='checkbox' value='1' id='clear_image' name='clear_image'/>
</td>
</table>
<span id='personal_photo_note'>$personal_photo_title</span>
<input type='file' id='file' name='file' class='file' value='Add personal photo' onchange='display_image(this);' />
</li>

<li>
<table>

<tr id='row'>
<td id='cel1'><label>First name:</label></td>
<td id='cel2'><input type='text' id='first_name' value='$initiate_first_name' name='first_name'/><span>*</span>
<span>$empty_first_name</span>
</td>
<td id='cel1'><label>Last name:</label></td>
<td id='cel2'><input type='text' id='last_name' value='$initiate_last_name' name='last_name'/><span>*</span>
<span>$empty_last_name</span></td>
</tr>

<tr id='row'>
<td id='cel1'><label>Email:</label></td>
<td id='cel2'><input type='email' id='email' value='$initiate_email' name='email'/><span>*</span>
<span>$empty_email</span></td>
<td id='cel1'><label>I have:</label></td>
<td id='cel2' class='owned_profile'>";
?>
<label id='project_title'>Project</label><input type='checkbox' id='project' value='1' <?php if($initiate_project_owner == 1) {echo "checked='checked'"; } ?> name='project'/>
<label id='skill_title'>Skill</label><input type='checkbox' id='skill' value='1' <?php if($initiate_skill_owner == 1) {echo "checked='checked'"; } ?> name='skill'/>
<label id='investment_title'>Investment</label><input type='checkbox' id='investment' value='1' <?php if($initiate_investment_owner == 1) {echo "checked='checked'"; } ?> name='investment'/><span id='profile_star'>*</span>
<?php
echo "
<span>$empty_profile_type</span>
</td>
</tr>

<tr id='row'>
<td id='cel1'><label>Password:</label></td>
<td id='cel2'><input type='password' id='passwd' name='passwd'/><span>*</span>
<span>$empty_password</span></td>
<td id='cel1'><label>Confirm password:</label></td>
<td id='cel2'><input type='password' id='c_passwd' name='c_passwd'/><span>*</span>
<span>$empty_confirm_password</span></td>
</tr>

<tr id='row'>
<td id='cel1'><span>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
<td id='cel2' class='g-recaptcha' data-sitekey='6Lf0-aoUAAAAAJmd2TLsrKt9nPZk4L3WJo3AJN2v' data-callback='enable_button'></td>
<td id='cel1'><span>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
<td id='cel2'>
<button id='perform_update' name='perform_update' class='perform_update' type='submit'>Update</button>
</td>
</tr>

</table>
</li>
</ul>

</fieldset>
</form>

</div>";

?>
<div id="duplicate_result" name="duplicate_result"><?php echo $duplicate_result; ?></div>
<!--Loppuu: Käyttäjän tiedojen näyttämisen lomakkeen suunnitteleminen-->
</body>

</html>