<?php
	error_reporting (0);
/**
 * Forgot Password form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class ForgotPasswordForm extends BaseForm
{

  public function setup()
  {
    parent::configure();

    $years = range(date('Y') - 105, date('Y') - 5);
    $this->years = array_combine($years, $years);

    $this->setWidgets(array(
      'email' => new sfWidgetFormInputText(array(), array('placeholder' => 'Email Address'))
    ));


    $this->widgetSchema->setLabels(array(
      'email' => 'Email'
    ));

    $this->setValidators(array(
      'email' => new sfValidatorEmail(array('max_length' => 192, 'required' => true))
    ));

    $this->widgetSchema->setNameFormat('forgot_password[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

	public function getSecureSalt()
	{
		$i = 0;
		$cstrong = false;
		
		while ($i < 10 && $cstrong == false)	// If we can't get a secure random number in 10 tries, give up
		{
			$bytes = openssl_random_pseudo_bytes(8, $cstrong);
		    $hex   = bin2hex($bytes);			
//	    	var_dump($hex);
//	    	var_dump($cstrong);
	    }
		return $hex;
	}
	
	public function encrypt_token($plaintext)
	{
		# --- ENCRYPTION ---

		# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
		# convert a string into a key
		# key is specified using hexadecimal
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	
		# show key size use either 16, 24 or 32 byte keys for AES-128, 192
		# and 256 respectively
		$key_size =  strlen($key);
		//echo "Key size: " . $key_size . "\n";
	
		# create a random IV to use with CBC encoding
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	
		# creates a cipher text compatible with AES (Rijndael block size = 128)
		# to keep the text confidential 
		# only suitable for encoded input that never ends with value 00h
		# (because of default zero padding)
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);

		# prepend the IV for it to be available for decryption
		$ciphertext = $iv . $ciphertext;
	
		# encode the resulting cipher text so it can be represented by a string
		$ciphertext_base64 = base64_encode($ciphertext);

		//echo  $ciphertext_base64 . "\n";
	
		return $ciphertext_base64;
	}
	
	public function decrypt_token($ciphertext_base64)
	{
		# === WARNING ===

		# Resulting cipher text has no integrity or authenticity added
		# and is not protected against padding oracle attacks.
	
		# --- DECRYPTION ---

		# the key should be random binary, use scrypt, bcrypt or PBKDF2 to
		# convert a string into a key
		# key is specified using hexadecimal
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	
		# show key size use either 16, 24 or 32 byte keys for AES-128, 192
		# and 256 respectively
		$key_size =  strlen($key);
		//echo "Key size: " . $key_size . "\n";

		$ciphertext_dec = base64_decode($ciphertext_base64);
	
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		# retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
		$iv_dec = substr($ciphertext_dec, 0, $iv_size);
	
		# retrieves the cipher text (everything except the $iv_size in the front)
		$ciphertext_dec = substr($ciphertext_dec, $iv_size);

		# may remove 00h valued characters from end of plain text
		$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
		
		//echo  $plaintext_dec . "\n";
		return $plaintext_dec;
	}
	
	public function forgotpassword($to)
	{
		$date = date("m/d/Y h:i:s A");
		$date = strtotime($date);
		$date = strtotime("+2 day", $date);
		$expire = date('m/d/Y h:i:s A', $date);
		$salt	= $this->getSecureSalt();
		$pwd 	= "secretkey112358!$%?";
    	$token = $this->encrypt_token($to."|".$expire."|".$salt);

		$q = Doctrine_Query::create()->update('MeredithReg u');
		$q->set('u.token', '?', $token);
		$q->where('u.email = ?', $to)->execute();

		$body  ='<p>We received a request to reset the password for the following account on BetterRecipes.com.</p>';
		$body .='<p>Email Address: '.$to.'</p>';
		$body .='<p>To reset your password, click the link below or copy and paste the link into your browser:</p>';
		$body .='<p>http://www.betterrecipes.com/auth/reset?token='.$token.'&referrer=%2F</p>';
		$body .='<p>Please note that this password reset link will expire on '.$expire.' or when used.</p>';
		$body .='<p>If you did not request to have your password reset, you can safely ignore this email. Rest assured your customer account is safe.</p>';
		$subject = "Password Reset";
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-sending:".$body);
		}
    

		$this->sendmail($body,$to,$subject);
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-sent:".$body);
		}
    
	}

	public function sendmail($body,$to,$subject)
	{
		//require_once 'init.php';
/*
		$from='support@betterrecipes.com';      
		$headersfrom='';
		$headersfrom .= 'MIME-Version: 1.0' . "\r\n";
		$headersfrom .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headersfrom .= 'From: '.$from.' '. "\r\n";
		mail($to,$subject,$body,$headersfrom);
//*/
		if (sfConfig::get('sf_logging_enabled'))
                {
                        sfContext::getInstance()->getLogger()->info("BEN-sfpresent:".$body);
                }
 
		$message = Swift_Message::newInstance();
		
        	$message->setSubject($subject);
		$message->setFrom(array('support@betterrecipes.com' => 'Better Recipes'));
        	$message->setTo($to);
        	$message->setBody($body, 'text/html');
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        );
        */

	$mailer = sfContext::getInstance()->getMailer();
 	$mailer->send($message);
	
 		if (sfConfig::get('sf_logging_enabled'))
                {
                        sfContext::getInstance()->getLogger()->info("BEN-sfsent:".$body);
                }

	}

  /**
   * Sends request for password
   * 
   * @return type 
   */
  public function send()
  {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }

    $values = $this->values;
    $reg_service = new RegServices();
    $response = $reg_service->sendPasswordReminder($values['email']);
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-sendingPasswordReminder:".$response);
		}
    

    if ($response['code'] == '0') {
    	$this->forgotpassword($values['email']);
      return true;
    } else {
      if ($response['code'] == '102') {
        $message = 'The login could not be found.';
      } else {
        $message = $response['message'];
      }
      $this->errorSchema->addError(new sfValidatorError($this->validatorSchema, $message, array('field' => 'email')), 'email');
      return false;
    }
  }

}
