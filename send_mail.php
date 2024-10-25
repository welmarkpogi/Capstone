<?php
// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

function sendEmail($toEmail, $subject, $messageBody) {
    $mail = new PHPMailer(true);
    
    try {
        
        //Server settings
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                           
        $mail->Host = 'smtp.gmail.com';            
        $mail->SMTPAuth = true;                    
        $mail->Username = 'welmarksevellita@gmail.com';  // Your Gmail address
        $mail->Password = 'welmark2002';   // Your Gmail password or app password if using 2FA
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;                        
        //Recipients
        $mail->setFrom('welmarksevellita@gmail.com', 'welmark');
        $mail->addAddress($toEmail);              

        // Content
        $mail->isHTML(true);                       
        $mail->Subject = $subject;
        $mail->Body    = $messageBody;
        $mail->AltBody = strip_tags($messageBody); 
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Example Usage
sendEmail('barangayPoblacion@gmail.com', 'Test Email', '<h1>This is a test email!</h1><p>This is the body of the email.</p>');
?>
