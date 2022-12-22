<?php 

// include('email_helper.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$from = "example@example.com";
$fromName = "From Name";
$to = "to@address.com";
$attachment = "text.png";
$template = "email_template.php";
function send_email ($to, $fromName, $from, $subject, $details, $attachment){
   //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    $mail->isHTML(true);  
    //Set the hostname of the mail server
    $mail->Host = 'host';
    $mail->Port = 'port';
    $mail->SMTPAuth = true;
    $mail->Username = 'username';
    $mail->Password = 'password';
    $mail->setFrom($from, $fromName);
    $mail->addReplyTo($from, $fromName);
    $mail->addAddress($to, $details['firstName']);
    $mail->Subject = $subject;
    $template = file_get_contents('email_template.php');
    $bodyContent = prepare_html_body($details, $template);
    $mail->AddEmbeddedImage('uploads/' . $attachment, "my-attach", 'uploads/' . $attachment);
    $mail->Body = $bodyContent . 'Embedded Image: <img alt="PHPMailer" src="cid:my-attach"> Here is an image!';
    // $mail->Body = $bodyContent;
    $mail->AltBody = 'Message From Zee Biskope';
    // $mail->addAttachment('uploads/' . $attachment);

    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
    }
}

function prepare_html_body($details, $template)
{
	if(!empty($details))
	{
		foreach($details as $key => $value)
		{
			$template = str_replace('{{'.$key.'}}', $value, $template);
		}
	}
	return $template;
}


send_email($to, $fromName, $from, "SUbject", array("firstName" => "First Name", "message"=> "Welcome to the Birthday Party"), $attachment);


