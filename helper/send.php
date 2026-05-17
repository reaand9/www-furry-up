<?php

    require '../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Load config
    $config = require '../config/mail.php';

    function sendEmail($toEmail, $toName, $subject, $body){
        global $config;

        $mail = new PHPMailer(true);

        try{
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = $config['encryption'];
            $mail->Port = $config['port'];
            $mail->CharSet = 'UTF-8';

            $fromName = $config['from_name'] ?? 'Furry Up';
            $mail->setFrom($config['username'], $fromName);
            $mail->addReplyTo($config['username'], $fromName);
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            return true;
        }
        catch (Exception $e){
            return $mail->ErrorInfo;
        }
    }

?>