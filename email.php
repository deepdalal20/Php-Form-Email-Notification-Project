<?php
    include 'dbcon.php';
    session_start();
    if(!isset($_SESSION['name']))
    {
        header('location:index.php');
    }
    $name = $_SESSION['name'];
    $con = $_SESSION['contact'];
    $email = $_SESSION['email'];
    $subject = $_SESSION['subject'];
    $msg = $_SESSION['message'];
    $ip = $_SESSION['ipa'];
?>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require('PHPMailer.php');
    require('Exception.php');
    require('SMTP.php');

    $mail = new PHPMailer(true);
    try 
    {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'projectbydeep08@gmail.com';
        $mail->Password   = 'gqollolesxkewbhz';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $toEmail = 'deepdalal20@gmail.com';
        $emailSubject = 'New email from your contact form';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=utf-8'];
        $bodyParagraphs = ["Name: {$name}\n", "Email: {$email}\n", "Message:", $msg];
        $body = join(PHP_EOL, $bodyParagraphs);

        $mail->setFrom('projectbydeep08@gmail.com', 'Seewans Bakery');
        $mail->addAddress($toEmail);     //Add a recipient   

        $mail->isHTML(true);
        $mail->Subject = $emailSubject;
        $mail->Body    = $body;
        $mail-> MsgHTML = ('h');
        $check = $mail->send();

        if($check)
        {
            unset($_SESSION['name']);
            unset($_SESSION['contact']);
            unset($_SESSION['email']);
            unset($_SESSION['subject']);
            unset($_SESSION['message']);
            unset($_SESSION['ip']);

            header('location: success.html');
        }
        else
        {
            echo "<script>alert('Some Error occured at server side');</script>";
        }

    } 
    catch (Exception $e) 
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
?>