<?php
/** 1. CLOUDFLARE SETTINGS
*******************************************************************/
$token = $_POST['cf-turnstile-response'];
$secret = '0x4AAAAAABWk9DKCxWfymjZB6fhi0BKiWCU';

$verify = file_get_contents("https://challenges.cloudflare.com/turnstile/v0/siteverify", false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'secret'   => $secret,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ])
    ]
]));

$captcha_success = json_decode($verify);

if (!$captcha_success->success) {
    echo json_encode([
        'error' => 'Captcha verification failed. You might be a bot 🛑'
    ]);
    exit;
}


/** 1. MAIN SETTINGS
*******************************************************************/


// ENTER YOUR EMAIL
$emailTo = "hello@codebyval.ca";

// ENTER IDENTIFIER
$emailIdentifier =  "Message sent via contact form from " . $_SERVER["HTTP_HOST"];


/** 2. MESSAGES
*******************************************************************/


// SUCCESS MESSAGE
$successMessage = "* Your Message has been sent!";


/** 3. MAIN SCRIPT
*******************************************************************/


if($_POST) {
    
    $block_success = false;

    $name = addslashes(trim($_POST['name']));
    
    $clientEmail = addslashes(trim($_POST['email']));
        
    $phone = addslashes(trim($_POST['phone']));
    
    $message = addslashes(trim($_POST['message']));
    
    $antiSpamHPC = addslashes(trim($_POST['taxid']));
    
    $array = array('nameMessage' => '', 'emailMessage' => '', 'phoneMessage' => '', 'messageMessage' => '', 'succesMessage' => '');

    if( $name === '' ) {
        $array['nameMessage'] = 'error';
        $block_success = true;
    }

    if( !filter_var( $clientEmail, FILTER_VALIDATE_EMAIL ) ) {
        $array['emailMessage'] = 'error';
        $block_success = true;
    }

    if( $message === '' ) {
        $array['messageMessage'] = 'error';
        $block_success = true;
    }
    
    if( $block_success === false && $antiSpamHPC === "" ) {	
        
        $message_body = "";
        
        $array["succesMessage"] = $successMessage;

        $headers= "MIME-Version: 1.0" . "\r\n";
        $headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers= "From: " . $name . " <" . $clientEmail .">\r\n";
        $headers.= "Reply-To: " . $clientEmail;
        
        if( $phone !== '' ) {
            $message_body .= "Phone: " . $phone . "\r\n";
        }
        
        $message_body .= "\r\n" . "Message: " . $message;

        mail($emailTo, $emailIdentifier, $message_body, $headers);

    }

    echo json_encode($array);

}

?>