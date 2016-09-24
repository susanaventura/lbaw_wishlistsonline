<?
	include_once('init.php');
	include_once ('../lib/swiftmailer/lib/swift_required.php');

	/***************************************/
	/******** RECOVER PASSWORD EMAIL *******/
	/**************************************/
	
	function send_recover_psw_email($info){

		$transport = Swift_SmtpTransport::newInstance('smtp.fe.up.pt', 25,'telnet');

		$transport->setUsername();
		$transport->setPassword();
		 
		//format each email
		$body = format_email_recover_psw($info,'.html');
		$body_plain_txt = format_email_recover_psw($info,'.txt');
	 
		//setup the mailer
		$transport = Swift_SmtpTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance();
		$message ->setSubject('Complete your password recovery proccess');
		$message ->setFrom(array('noreply@wishlistsonline.pt' => 'Wishlists Online'));
		$message ->setTo(array($info['email'] => $info['username']));
		
		 
		$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
				 
		$result = $mailer->send($message);
		 
		return $result;
     
	}
	
	function format_email_recover_psw($info, $format){
		global $BASE_DIR; global $BASE_URL; global $BASE_DOMAIN;
		//grab the template content
		$template = file_get_contents($BASE_DIR.'templates/homepage/email_recover_psw'.$format);
				 
		$template = ereg_replace('{USERNAME}', $info['username'], $template);
		$template = ereg_replace('{EMAIL}', $info['email'], $template);
		$template = ereg_replace('{KEY}', $info['key'], $template);
		$template = ereg_replace('{EXP_DATE}', $info['exp_date'], $template);
		$template = ereg_replace('{TEMP_PSW}', $info['temp_psw'], $template);
		$template = ereg_replace('{SITEPATH}',$BASE_DOMAIN.$BASE_URL.'actions', $template);
			 
		//return the html of the template
		return $template;
 
	}
	
	/***************************************/
	/******** CONFIRM ACCOUNT EMAIL *******/
	/**************************************/
	
	function send_confirmation_email($info){

		$transport = Swift_SmtpTransport::newInstance('smtp.fe.up.pt', 25,'telnet');
		$transport->setUsername('');
		$transport->setPassword('');
		 
		//format each email
		$body = format_email_confirmation($info,'.html');
		$body_plain_txt = format_email_confirmation($info,'.txt');
	 
		//setup the mailer
		$transport = Swift_SmtpTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance();
		$message ->setSubject('Welcome to Wishlists Online');
		$message ->setFrom(array('noreply@wishlistsonline.pt' => 'Wishlists Online'));
		$message ->setTo(array($info['email'] => $info['username']));
		
		 
		$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
				 
		$result = $mailer->send($message);
		 
		return $result;
     
	}
	
	
	function format_email_confirmation($info, $format){
		global $BASE_DIR; global $BASE_URL; global $BASE_DOMAIN;
		//grab the template content
		$template = file_get_contents($BASE_DIR.'templates/homepage/email_confirmation'.$format);
				 
		$template = ereg_replace('{USERNAME}', $info['username'], $template);
		$template = ereg_replace('{EMAIL}', $info['email'], $template);
		$template = ereg_replace('{KEY}', $info['key'], $template);
		$template = ereg_replace('{SITEPATH}',$BASE_DOMAIN.$BASE_URL.'actions', $template);
			 
		//return the html of the template
		return $template;
 
	}
	
	
	/***************************************/
	/******** GENERIC EMAIL ***************/
	/**************************************/
	
	//sendGenericEmail('templates/admin/noreply_emails/ban_user_email', 'Your account has been inactivated', $info);
	function sendGenericEmail($template, $subject, $info){
		global $BASE_DIR; global $BASE_URL; global $BASE_DOMAIN;
		
		$transport = Swift_SmtpTransport::newInstance('smtp.fe.up.pt', 25,'telnet');
		$transport->setUsername('');
		$transport->setPassword('');
		
		//format each email
		$body = formatGenericEmail($info,'.html', $template);
		$body_plain_txt = formatGenericEmail($info, '.txt', $template);
		
		//setup the mailer
		$transport = Swift_SmtpTransport::newInstance();
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance();
		$message ->setSubject('Welcome to Wishlists Online');
		$message ->setFrom(array('noreply@wishlistsonline.pt' => 'Wishlists Online'));
		$message ->setTo(array($info['email'] => $info['username']));
		
		 
		$message ->setBody($body_plain_txt);
		$message ->addPart($body, 'text/html');
				 
		$result = $mailer->send($message);
		 
		return $result;
		
		
	}

	
	function formatGenericEmail($info, $format, $template){
		global $BASE_DIR; global $BASE_URL; global $BASE_DOMAIN;
		
		//grab the template content
		$complete_template = file_get_contents($BASE_DIR.$template.$format);
				 
		$complete_template = ereg_replace('{USERNAME}', $info['username'], $complete_template);
			 
		//return the html of the template
		return $complete_template;
 
	}
	
	
	/***************************************/
	/***************** UTIL ***************/
	/**************************************/
	
	function formatDate($time)
	{

		$time = time() - $time; // to get the time since that moment

		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}
	
	function randStrGen($len){
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXWZ_0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;
	}

?>