<?php
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;

class Sendmail
{
    private $Host = 'smtp.titan.email';
    private $Username = 'dentian@dentian.online';
    private $Password = 'Abcde12345';
    private $SMTPSecure = 'ssl';
    private $Port = 465;

    public function Email($companyName, $email, $output, $invoiceValues)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       =  $this->Host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->Username;
        $mail->Password   = $this->Password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port       = $this->Port;

        //Recipients
        $mail->setFrom('dentian@dentian.online', $companyName);
        $mail->addAddress($email, $email);


        //Attachments
        $mail->addStringAttachment($output, 'Invoice-' . $invoiceValues['order_id'] . '.pdf');
        //Content
        $mail->isHTML(true);
        $mail->Subject = "$companyName's Invoice";
        $mail->Body    = 'Dear ' . $invoiceValues['order_receiver_name'] . ',<br>The above attachment is the invoice requested.<br>Yours Sincerely,<br>' . $companyName . '';
        $mail->send();
    }
    public function blast($to, $uploadfile, $fileName, $company)
    {
        $mail = new PHPMailer(true);
        //Server settings                    
        $mail->isSMTP();
        $mail->Host       = $this->Host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->Username;
        $mail->Password   = $this->Password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port       = $this->Port;

        //Recipients
        $mail->setFrom('dentian@dentian.online', $company);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body    = $_POST['body'];
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $mail->addAttachment($uploadfile, $fileName);
            $mail->send();
        } else {
            $mail->send();
        }
    }
    public function forget($myemail, $myuser, $mypassword)
    {
        $mail = new PHPMailer(true);
        //Server settings                    
        $mail->isSMTP();
        $mail->Host       = $this->Host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->Username;
        $mail->Password   = $this->Password;
        $mail->SMTPSecure = $this->SMTPSecure;
        $mail->Port       = $this->Port;
        //Recipients
        $mail->setFrom('dentian@dentian.online', "Forget password");
        $mail->addAddress($myemail);
        $mail->isHTML(true);
        $mail->Subject = "Dentian: Forget your password";
        $mail->Body    = "Dear $myuser, <br>Your password is: $mypassword <br>Yours Sincerely, <br>Dentian";
        $mail->send();
    }
}
