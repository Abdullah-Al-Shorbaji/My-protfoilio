function check_recatcha()
{/*Päivityksen napin käytöstä poistaminen*/
var submit_button = document.getElementById("create_account");
	submit_button.disabled = true;
	submit_button.style.color = "#bdbdbd";
}

function enable_button()
{
/*Päivityksen napin käyttöön ottaminen*/
var submit_button = document.getElementById("create_account");

	submit_button.style.color = "#090333";
	submit_button.disabled = false;
}

function display_image(input)
{/*Profiilin kuvan omaan erityiseen paikkaan laittaminen*/
	if(input.files && input.files[0])
	{
		var to_get = new FileReader();
		
		to_get.onload = function(e)
									{
									$('#personal_photo').attr('src', e.target.result).width(250).height(335);
									$("#clear_image").css("display","block");
									}
									
	to_get.readAsDataURL(input.files[0]);
	}
}

function reset_image()
{/*Profiilin kuvan omasta erityisestä paikasta poistaminen*/
	if(document.getElementById("personal_photo").src != "" || document.getElementById("personal_photo").src == "images/question_mark.png")
	{
	document.getElementById("personal_photo").src = "images/question_mark.png";
	$("#clear_image").css("display","none");
	}
}