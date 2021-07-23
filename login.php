<?php
session_start();

require_once __DIR__ . '/koneksi.php';

$conn = getConnection();

if (isset($_SESSION['login'])) {
  if($_SESSION['login'] == true) {
    header('Location: /Project-PKL/user/infopesanan.php');
    exit();
  }
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <style>
      .second-box{display: none;}
    </style>
    <script>
      function direct(response) {
        let role = response
        const direct = document.location = `/Project-PKL/${role}`
      }
    </script>
    <title>Login</title>
  </head>

  <body>
    <div class="d-flex justify-content-center align-items-center login-container">
      <form class="login-form text-center" action="" method="POST">
        
        <div class="form-group first-box">
          <h1 class="mb-5 font-weight-light text-uppercase">Login</h1>
          <input type="email" class="form-control rounded-pill form-control-lg" name="email" placeholder="Email" id="email" require />
        </div>
        <div class="form-group first-box">
          <input type="password" class="form-control rounded-pill form-control-lg" name="password" id="password" placeholder="Password" />
        </div>
        <div class="forgot-link form-group d-flex justify-content-between align-items-center">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" />
            <label class="form-check-label" for="remember">Remember Password</label>
          </div>
        </div>
        <button type="submit" class="btn mt-5 rounded-pill btn-lg btn-primary btn-block text-uppercase" name="submit" id="signup">Login</button>
        <p class="mt-3 font-weight-normal">
          Don't have an account? <a href="registerPage.php"><strong>Register</strong></a>
        </p>
        <div class="form-group second-box">
          <h1 class="mb-5 font-weight-light text-uppercase">Konfirmasi</h1>
          <input type="text" class="form-control rounded-pill form-control-lg" name="otp" id="otp" placeholder="Isi Kode OTP" />
          <button type="submit" class="btn mt-5 rounded-pill btn-lg btn-primary btn-block text-uppercase" name="submit" id="signup">Konfirmasi Akun</button>
        </div>
      </form>
    </div>

    <script src="js/sweetalert2.all.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script>

      $(document).ready(function () {
        $("#signup").click(function (e) {
          e.preventDefault();
          let email = $("#email").val();
          let password = $("#password").val();

          if (email.length == "") {
            Swal.fire({
              icon: "warning",
              title: "Oops...",
              text: "Email Wajib Diisi !",
            });
          } else if (password.length == "") {
            Swal.fire({
              icon: "warning",
              title: "Oops...",
              text: "Password Wajib Diisi !",
            });
          } else {
            $.ajax({             
              url: "loginphp.php",
              method: "POST",
              data: {
                email: email,
                password: password
              },
              
              success: function (response) {                                
                if (response == "admin") {
                  $('.first-box').hide();
                  $('.second-box').show();
                  // Swal.fire({
                  //   icon: "success",
                  //   title: "Login Berhasil!",
                  //   text: "Welcome Admin!",
                  // });              
                  // setTimeout(direct(response), 3000);
                } 

              },

              error: function (response) {
                Swal.fire({
                  icon: "error",
                  title: "Opps!",
                  text: "server error!",
                });
              }
            })
          }
        })
      })
    </script>
  </body>
</html>
