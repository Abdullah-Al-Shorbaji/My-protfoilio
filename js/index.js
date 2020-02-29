/*Näyttää/piilota käyttäjän oman profiilin linkin listan ikkunan*/
$(document).ready(function(){
							$("#me_li, #icon_li").click(function(){
																	if(!$(".personal_area").is(":visible"))
																	{
																	$(".personal_area").css("display","block");
																	}
																	else
																	{
																	$(".personal_area").css("display","none");
																	}
																}
													);

							$(".head_upper, #logo, #website_name, #personal_photo_li, #website_introduction, .search_frame, .recent_events_container").click(function(){
																																												if($(".personal_area").is(":visible"))
																																												{
																																												$(".personal_area").css("display","none");
																																												}
																																											}
																																								);
							}

					);
