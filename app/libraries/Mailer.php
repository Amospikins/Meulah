<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

class Mailer {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Server settings
            $this->mail->isSMTP();
            $this->mail->Host       = SMTP_HOST;
            $this->mail->SMTPAuth   = true;
            $this->mail->Username   = SMTP_USER;
            $this->mail->Password   = SMTP_PASS;
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port       = SMTP_PORT;

            // Default sender
            $this->mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        } catch (Exception $e) {
            throw new Exception("Mailer Initialization Error: " . $e->getMessage());
        }
    }

    public function send($toEmail, $toName, $subject, $body) {
        try {
            $this->mail->addAddress($toEmail, $toName);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->isHTML(true);

            return $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Mail Sending Error: " . $e->getMessage());
        }
    }
}