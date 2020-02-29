<?php
/*Asettaa alkuasetukset*/
include("open_session.php");
include("connect_to_database.php");
include("data_validation.php");

require_once("PHPMailerAutoload.php");
require_once("PHPMailer/PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer/PHPMailer-master/src/SMTP.php");
require_once("PHPMailer/PHPMailer-master/src/Exception.php");
require_once("config.php");
$empty_first_name = $empty_last_name = $empty_email = $empty_password = $empty_confirm_password = $empty_profile_type = "";
$first_name = $last_name = $email = $password = $confirm_password = $profile_type = "";
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
$alternative_first_name		=	"";
$alternative_last_name		=	"";
$alternative_email			=	"";
$alternative_passwd			=	"";
$alternative_c_passwd		=	"";
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
<title>Creation of personal perofile</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie-edge">
<link rel="stylesheet" type="text/css" href="css\profile_creation1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="js/profile_creation2.js"></script>

</head>

<body onload="check_recatcha(); reset_image();">
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

<li id="unmembering_expression"> 
Already a member? click&nbsp;<a href="login_process.php">here</a>
</li>
</ul>
</header>

</div>

<?php
/*Alkaa: noutaa maksimi käyttäjätunnus on rekisteröity tietokannassa*/
$max_user_id 	=	"select ifnull(max(user_id),0) + 1 user_id from doc_user_accounts;";
$get_user_id 	= 	$conn->query($max_user_id);
$new_user_id	=	"";

if($get_user_id->num_rows > 0)
{
$rows 			= 	$get_user_id->fetch_assoc();
$new_user_id 	=	$rows["user_id"];
}
/*Loppuu: noutaa maksimi käyttäjätunnus on rekisteröity tietokannassa*/

if(isset($_FILES["file"])) /*Asettaa ladatun kuvan tiedot*/
{
	$files 				=	$_FILES["file"];

	$filesName			=	$files["name"];
	$filesType			=	$files["type"];
	$filesTmpName		=	$files["tmp_name"];
	$filesError			=	$files["error"];
	$filesSize			=	$files["size"];
	
	$filesExt			=	explode(".", $filesName);
	$filesActualExt		=	strtolower(end($filesExt));
	$FilesAllowedExt	=	array("jpg", "jpeg", "gif", "png");	
}

if(isset($_POST["clear_image"])) /*Tyhjetaa ladatun kuvan tiedot*/
{
	$files			=	"";
	$filesName		=	"";
	$filesType		=	"";
	$filesTmpName	=	"";
	$filesError		=	"";
	$filesSize		=	"";
}	

if(isset($_POST["create_account"])) /*Noustaa uuden käyttäjän tietojen tietokannan rekisteröinnin prosessi*/
{
$pass_to_insert = 0;
/*---------------------------*/	

	if($filesName	!=	"") /*Aloittaa kuvan lataaminen prosessi*/
	{
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
				$fileDestination	=	"$personal_photo_directory/".$new_user_id."_".$count_of_duplicated_images."_".$filesNewName;
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
/*---------------------------*/	

	if($_POST["first_name"] == "") /*Tarkista ja asettaa käyttäjän etunimen arvon*/
	{
	$empty_first_name = "Please enter your first name.";
	}
	else
	{
	$first_name	=	purifying_data($_POST["first_name"]);
	$pass_to_insert += 1;
	}

	if($_POST["last_name"] == "") /*Tarkista ja asettaa käyttäjän sukunimen arvon*/
	{
	$empty_last_name = "Please enter your last name.";
	}
	else
	{
	$last_name	=	purifying_data($_POST["last_name"]);
	$pass_to_insert += 1;
	}

	if($_POST["email"] == "") /*Tarkista ja asettaa käyttäjän sähköpostin arvon*/
	{
	$empty_email = "Please enter your email.";
	}
	else
	{
	$email	=	purifying_data($_POST["email"]);
	$pass_to_insert += 1;
	$check_duplicate_email = "select 1 duplicate_flag from doc_user_accounts where email = '$email'";
	$get_email = $conn->query($check_duplicate_email);
	
		if($get_email->num_rows > 0)
		{
		$rows = $get_email->fetch_assoc();
		$is_a_duplicated_email = $rows["duplicate_flag"];

			try
			{
				if($is_a_duplicated_email == 1)
				{
				$duplicate_result = "User with email you entered already exists. If you're already a member, click&nbsp;<a href='login_process.php'>here</a>&nbsp;to sign in";
				throw new Exception($duplicate_result);
				}
			}
			
			catch(Exception $e)
			{}
		
		}
	}

	if($_POST["passwd"] == "") /*Tarkista ja asettaa käyttäjän salasanan arvon*/
	{
	$empty_password = "Please enter your password.";
	}
	else
	{
	$password	=	md5(purifying_data($_POST["passwd"]));
	$pass_to_insert += 1;
	}
	
	if( ($_POST["c_passwd"] == "") || ($_POST["c_passwd"] == null)) /*Tarkista ja asettaa käyttäjän salasanan vahvistuksen arvon*/
	{
	$empty_confirm_password = "Please confirm your password.";
	}
	else
	{
		if(($password != "") && ($_POST["passwd"] != $_POST["c_passwd"]))
		{
		$empty_confirm_password = "Passwords aren't identical.";
		try {throw new Exception("A");}
		catch(Exception $e){}
		}
	$confirm_password	=	purifying_data($_POST["c_passwd"]);
	$pass_to_insert += 1;
	}
	
	if(isset($_POST["project"])) /*Tarkista ja asettaa käyttäjän projektin valinnan arvon*/
	{
	$have_project =	$_POST["project"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$have_project =	0;
	}
	if(isset($_POST["skill"])) /*Tarkista ja asettaa käyttäjän taidon valinnan arvon*/
	{
	$have_skill =	$_POST["skill"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$have_skill =	0;
	}

	if(isset($_POST["investment"])) /*Tarkista ja asettaa käyttäjän sijoituksen valinnan arvon*/
	{
	$have_investment =	$_POST["investment"];
	$checkbox_array_id	=	1;
	}
	else
	{
	$have_investment =	0;
	}
	
	if ($checkbox_array_id == 0) /*Tarkista ja asettaa mitä tapahtuu kun ei mitään valintaa ('Project', 'Skill', 'Investment') on valittu*/
	{
	$empty_profile_type = "Please select what do you have(at least one).";
	}
	else
	{
	$pass_to_insert += 1;
	}
	/*Asettaa käyttäjän tietojen rekisteröinnin lauseen*/
	$insert_new_user = "insert into doc_user_accounts values(
															$new_user_id, 
															'$first_name', 
															'$last_name',
															'$fileDestination',
															'$email', 
															'$password', 
															$have_project, 
															$have_skill, 
															$have_investment, 
															0,
															'',
															0,
															0,
															0, 
															1, 
															current_timestamp
															)";
}


/*Suunnitella käyttäjän tietojen syöttämisen lomakkeen*/
echo <<<EOT
<div>

<form class='form_container' action='profile_creation.php' method='post' enctype='multipart/form-data'>
<h2 id='form_title'>Welcome to join JoinMe</h2>
<fieldset class='form_frame'>
<ul class='upload_list'>
<li id='image_li'>
<span class='cabinet'>
EOT;

$personal_photo_html = "<img id='personal_photo' name='personal_photo' src='' onerror='this.onerror=null; this.src='images/question_mark.png'' alt='My photo'/>";
echo $personal_photo_html;

if(isset($_POST["first_name"]))	{$alternative_first_name	=	$_POST["first_name"];}

if(isset($_POST['last_name']))	{$alternative_last_name		=	$_POST['last_name'];}

if(isset($_POST['email']))		{$alternative_email			=	$_POST['email'];}

if(isset($_POST['project']))	{$alternative_project		=	'1';}

if(isset($_POST['skill']))		{$alternative_skill			=	'1';}

if(isset($_POST['investment']))	{$alternative_investment	=	'1';}

if(isset($_POST['passwd']))		{$alternative_passwd		=	$_POST['passwd'];}

if(isset($_POST['c_passwd']))	{$alternative_c_passwd		=	$_POST['c_passwd'];}

echo "
</span>
<button style='display: block;' id='clear_image' name='clear_image' onclick='reset_image();'><i class='fa fa-times' style='background-color:	#090333; color: #fff8d4; font-size: 20px;'></i></button>
<span id='personal_photo_note'>$personal_photo_title</span>
<input type='file' id='file' name='file' class='file' value='Add personal photo' onchange='display_image(this);' />
</li>

<li>
<table>

<tr id='row'>
<td id='cel1'><label>First name:</label></td>
<td id='cel2'><input type='text' id='first_name' value='$alternative_first_name' name='first_name'/><span>*</span>
<span>$empty_first_name</span>
</td>
<td id='cel1'><label>Last name:</label></td>
<td id='cel2'><input type='text' id='last_name' value='$alternative_last_name' name='last_name'/><span>*</span>
<span>$empty_last_name</span></td>
</tr>

<tr id='row'>
<td id='cel1'><label>Email:</label></td>
<td id='cel2'><input type='email' id='email' value='$alternative_email' name='email'/><span>*</span>
<span>$empty_email</span></td>
<td id='cel1'><label>I have:</label></td>
<td id='cel2' class='owned_profile'>

<label id='project_title'>Project</label><input type='checkbox' value='1' id='project' value='$alternative_project' name='project'/>
<label id='skill_title'>Skill</label><input type='checkbox' value='1' id='skill' value='$alternative_skill' name='skill'/>
<label id='investment_title'>Investment</label><input type='checkbox' value='1' id='investment' value='$alternative_investment' name='investment'/><span id='profile_star'>*</span>

<span>$empty_profile_type</span>
</td>
</tr>

<tr id='row'>
<td id='cel1'><label>Password:</label></td>
<td id='cel2'><input type='password' id='passwd' value='$alternative_passwd' name='passwd'/><span>*</span>
<span>$empty_password</span></td>
<td id='cel1'><label>Confirm password:</label></td>
<td id='cel2'><input type='password' id='c_passwd' value='$alternative_c_passwd' name='c_passwd'/><span>*</span>
<span>$empty_confirm_password</span></td>
</tr>

<tr id='row'>
<td id='cel1'><span>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
<td id='cel2' class='g-recaptcha' data-sitekey='6Lf0-aoUAAAAAJmd2TLsrKt9nPZk4L3WJo3AJN2v' data-callback='enable_button'></td>
<td id='cel1'><button id='clear_all' name='clear_all' class='clear_all' type='reset'>Clear all</button></td>
<td id='cel2'>
<button id='create_account' name='create_account' class='create_account' type='submit'>Create account</button>
</td>
</tr>

</table>
</li>
</ul>

</fieldset>
</form>

</div>";

	if($pass_to_insert == 6)
	{
	/*Käyttäjän tietojen rekisteröinnin prosessi*/
		if($conn->query($insert_new_user))
		{
		/*-------------------------------------------*/
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
				$save_confirmation_code	=	"update doc_user_accounts set confirmation_code = '$c_code' where email = '$to'";
				$perfom_saving = $conn->query($save_confirmation_code);
				$_SESSION["is_confirmed"] = 0;
				echo "	<div id='transparency_body' name='transparency_body'>
						<div id='modal_content' name='modal_content'>
						<p id='successful_detail'><strong id='successful_title'>Congratulations!</strong><br>Joining succeed, and an email with code have been sent to you to confirm your email in first login.</p>
						</div>
						</div>
						<script>
						var t_body = document.getElementById('transparency_body');
						t_body.style.display = 'block';
						</script>";
				echo "<meta http-equiv='refresh' content='3;url=login_process.php'>";
			}

		}

	}

?>
<div id="duplicate_result" name="duplicate_result"><?php echo $duplicate_result; ?></div>

</body>

</html>