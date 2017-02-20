<?php
/*
# ------------------------------------------------------------------------
# Extensions for Joomla 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2011-2015 Ext-Joom.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2.
# Author: Ext-Joom.com
# Websites:  http://www.ext-joom.com 
# Date modified: 25/02/2015 - 13:00
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die;
error_reporting(E_ALL & ~E_NOTICE);
?>

<div class="mod_ext_simple_contact_form <?php echo $moduleclass_sfx ?>">

<?php
// check
if(isset($_POST['extsend']) ) {	
	
	// Was there a reCAPTCHA response?
	if ($_POST["g-recaptcha-response"]) {
		$resp = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}
		
	$name 		= trim(strip_tags($_POST["name"]));
	$email 		= trim(strip_tags($_POST["email"]));
	$subject  	= trim(strip_tags($_POST["subject"]));
	$message 	= trim(htmlspecialchars($_POST["message"],ENT_QUOTES));
	
	if (!isEmail($email)) {
		if ($ext_error_email == '' OR $ext_error_email == ' ') {
			$errMsg= JText::_(ERROREMAIL);
		} else {
			$errMsg = $ext_error_email;
			}

	}
	
	if ( $name=="" OR  $email=="" OR $subject=="" OR $message=="") {
		if($ext_error_field == '' OR $ext_error_field == ' ') {
			$errMsg = JText::_(ERRORFIELD);
		} else {
			$errMsg = $ext_error_field;
			}
	}
	
	
	if($errMsg == '' AND $resp != null && $resp->success) {
		if(get_magic_quotes_gpc()) {
			$message = stripslashes($message);
		}
		
		//$msg     = "$ext_name_label  $name \r\n $ext_email_label  $email \r\n $ext_subject_label $subject \r\n\n" . "$ext_message_label \r\n$message";		
		$msg  = "$ext_name_label  $name <br/>";
		$msg .=	"$ext_email_label  $email <br/>";
		$msg .=	"$ext_subject_label  $subject <br/>";
		$msg .=	"$ext_message_label \r\n$message";		
		
		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: $email\r\n";
		$headers .= "Reply-To: $email\r\n";
		//$headers .= "Return-Path: $email\r\n";

		mail($ext_my_email, $subject, $msg, $headers);
	

?>
		<div class="alert alert-block alert-success">
			<p>
			<?php 
			echo $ext_send_message=='' ? JText::_(SENDMESSAGE) : $ext_send_message;
			?>
			</p>
			<div style="clear:both;"></div>
		</div>
<?php
	} else {
		$errMsg = $ext_recaptcha_message;
		}
}

if(!isset($_POST['extsend']) || $errMsg != '') {
?>	
	<div class="ext_simple_contact_form">
		<?php 
		if ($errMsg != ''){ 
			echo '<div class="alert alert-block alert-error fade in"><button type="button" class="close" data-dismiss="alert">×</button><div>'.$errMsg.'</div><div style="clear:both;"></div></div>';
		}
		?>	
		
		<form id="ext_form_<?php echo $module_id;?>" action="" method="post">
			<p>
				<label><?php echo $ext_name_label;?></label>
				<input type="text" class="text" name="name" required />
			</p>
			<p>
				<label><?php echo $ext_email_label;?></label>
				<input type="text" class="text" name="email" required />
			</p>
			<p>
				<label><?php echo $ext_subject_label;?></label>
				<input type="text" class="text" name="subject" required />
			</p>
			<p class="area">
				<label><?php echo $ext_message_label;?></label>
				<textarea class="textarea" name="message" required ></textarea>
			</p>
			<p>				
				<div class="g-recaptcha" data-sitekey="<?php echo $publickey;?>"></div>
				<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $ext_recaptcha_lang;?>">
				</script>				
			</p>
			<p>
				<label>&nbsp;</label>
				<input type="submit" class="btn" value="<?php echo $ext_send_label;?>"  name="extsend" />				
			</p>			
		</form>	
	</div>

<?php
}
?>
	<div style="clear:both;"></div>
</div>