<?php
session_start();

require_once __DIR__ . '/koneksi.php';

$conn = getConnection();

function smtp_mailer($to, $subject, $msg) {
  include('smtp/PHPMailerAutoload.php');
  $mail=new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->port = 587;
  $mail->SMTPSecure = "tls";
  $mail->SMTPAuth = true;
  $mail->Username = "simila827@gmail.com";
  $mail->Password = "bahasan2020";
  $mail->SetFrom = ("simila827@gmail.com");
  $mail->addAddress("simila827@gmail.com");
  $mail->IsHTML(true);
  $mail->Subject="New Contact Us";
  $mail->Body=$msg;
  $mail->SMTPOptions=array('ssl'=>array(
    'verify_peer'=>false,
    'verify_peer_name'=>false,
    'allow_self_signed'=>false
  ));
}

if(empty($_POST['email']) && empty($_POST['password'])) {
  $email = null;
  $password = null;
} else { 
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']); 

  $statement = $conn->query("SELECT user, email, password, role FROM user WHERE email = '$email' AND password = '$password'");
  $sql = $statement->fetch(PDO::FETCH_ASSOC);

  $_SESSION['login'] = true;
  $_SESSION['user'] = $sql['user'];
  $_SESSION['email'] = $sql['email'];
  $_SESSION['password'] = $sql['password'];
  $_SESSION['role'] = $sql['role'];
  $emailDB = $sql['email'];

  if ($sql) {
    $otp = rand(111111, 999999);
    $queryOTP = "UPDATE user SET otp = '$otp' WHERE email = '$emailDB'";
    $conn->exec($queryOTP);

    $html = "kode otp anda adalah $otp";

    smtp_mailer($sql['email'], 'hamlo', $html);

      if($sql['role'] == 'a') {
        echo "admin";
        // header('Location: /Project-PKL/admin/index.php');
      } else if($sql['email'] == $email && $sql['password'] == $password) {
        echo "user";
        // header('Location: /Project-PKL/user/index.php');
      } else {
        echo "error";
      }         
  }
}



$conn = null;
?>
