<script>
var RecaptchaOptions = {
	theme : 'custom',
	custom_theme_widget: 'recaptcha_widget',
	custom_translations : { instructions_visual : "Please enter text from the image above" }
};
</script>

<style>

#recaptcha_widget{
	display:inline-block;
	background-color:#cee1ed;
	border:1px solid #CCCCCC;
	padding:.3em;
    width: 100% !important;
	max-width:35em;
}
#recaptcha_widget #recaptcha_image{
	background-color:#FFFFFF;
	border:1px solid #CCCCCC;
	margin-bottom:.3em;
	width:90% !important;
	height:52px !important;
	float:left;
	vertical-align:top;
}
#recaptcha_image img{
    width: 100% !important;
	height:48px; !important;
    cursor: pointer;
}
#recaptcha_widget span{
    display:block;
}
#recaptcha_widget #recaptcha_response_field{
    width: 100% !important;
   /* width: 298px !important;*/
	display:inline-block;
}
#recaptcha_widget .control-buttons{
	text-align:right;
    width: 10% !important;
	float:right;
}
#recaptcha_widget .control-btn{
	display:block;
	padding:0;margin:0;
	max-width:25px;
	float:right;
	margin-left:.3em;
}
#recaptcha_widget .control-btn img{
	width:100%;
}


@media (max-width: 600px) {	
	#recaptcha_widget{}
	#recaptcha_image img{}
}
	
/*
#recaptcha_widget_div{display:inline-block;}
#recaptcha_table{background-color:#CEE1ED;}
.recaptchatable .recaptcha_image_cell{background-color:#CEE1ED !important;}
.recaptchatable #recaptcha_response_field{font-size:10pt;background-color:#FFFFFF;border:1px solid #CCCCCC !important}
.recaptchatable a, .recaptchatable a:hover {color: #15366b !important;}
fieldset#recaptcha_response_field{padding:5.2em 6.3em 0 5.4em;}
*/
</style>

<div id="recaptcha_widget" style="display:none">

    
   <div id="recaptcha_image"></div>
   
   
	<div class="control-buttons">
		<div class="control-btn"><a href="javascript:Recaptcha.reload()"><img id="recaptcha_reload" width="25" height="18" alt="Get a new challenge" src="http://www.google.com/recaptcha/api/img/clean/refresh.png"></a></div>
		<div class="control-btn recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')"><img id="recaptcha_switch_audio" width="25" height="15" alt="Get an audio challenge" src="http://www.google.com/recaptcha/api/img/clean/audio.png"></a></div>
		<div class="control-btn recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')"><img id="recaptcha_switch_img" width="25" height="15" alt="Get a visual challenge" src="http://www.google.com/recaptcha/api/img/clean/text.png"></a></div>
		<div class="control-btn"><a href="javascript:Recaptcha.showhelp()"><img id="recaptcha_whatsthis" width="25" height="16" src="http://www.google.com/recaptcha/api/img/clean/help.png" alt="Help"></a></div>
	</div>
    
   <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>

<!--
   <span class="recaptcha_only_if_image">Type the two words:</span>
   <span class="recaptcha_only_if_audio">Enter the numbers you hear:</span>
-->
   <input type="text" id="recaptcha_response_field" name="recaptcha_response_field"/>

 </div>


<script type="text/javascript" src="https://www.google.com/recaptcha/api/challenge?k=<?=$recaptcha_public_key;?>"></script>
<noscript>
	<iframe src="https://www.google.com/recaptcha/api/noscript?k=<?=$recaptcha_public_key;?>" height="300" width="500" frameborder="0"></iframe><br>
	<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
</noscript>