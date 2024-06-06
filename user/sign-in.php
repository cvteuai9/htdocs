<?php
session_start();
if (isset($_SESSION["user"])) {
  header("location: user.php");
  exit;
}

?>

<!-- ============================== -->
<!doctype html>
<html lang="en">

<head>
  <title>test-sign-up</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("user-css.php"); ?>
  <style>
    body {
      background: url("../user_images/bg.jpg");
      background-size: 100vh norepl;
      background-repeat: no-repeat;
      backdrop-filter: brightness(70%);
      color: #0F4C3A;

    }

    .login-panel {
      width: 280px;
    }

    .input-area {
      .form-floating {
        &:first-child {
          .form-control {
            /* border-end-end-radius: 0;
                        border-end-start-radius: 0; */
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            position: relative;
            top: 1px;
          }
        }

        &:last-child {
          .form-control {
            border-top-left-radius: 0;
            border-top-right-radius: 0;
          }
        }

        .form-control:focus {
          position: relative;
          z-index: 1;
        }

      }
    }

    .logo {
      height: 48px;
    }

    button:focus {
      outline: none;
    }
  </style>
</head>

<body>
  <div class="vh-100 d-flex justify-content-center align-items-center ">
    <div class="login-panel">
      <h2 class="text-shadow-sm fw-bold">drinking tea...</h2>
      <h6 class="text-dark text-shadow-sm fw-bold">登入您的帳戶</h6>

      <?php if (isset($_SESSION["errorTimes"]) && $_SESSION["errorTimes"] >= 5) : ?>
        <div class="text-dark text-center h4 my-3">登入錯誤次數太多<br>請稍後再嘗試</div>
      <?php else :  ?>
        <?php ?>



        <form action="doLogin.php" method="post">
          <div class="input-area">
            <div class="form-floating">
              <input type="test" class="form-control" id="floatingInput" placeholder="name@example.com" name="account">
              <label for="floatingInput">Account</label>
            </div>


            <div class="form-floating position-relative">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" oninput="checkInput()">
              <label for="floatingPassword">Password</label>
              <div id="button1" class="btn position-absolute d-flex top-50 end-0  z-3 lookEye d-none" onclick="switchButton()">
                <i class="fa-solid fa-eye fa-lg" style="color: #0f4c3a;"></i>
              </div>
              <div id="button2" class="btn position-absolute d-flex top-50 end-0 z-3 unlookEye d-none" onclick="switchButton()">
                <i class="fa-solid fa-eye-slash fa-lg" style="color: #0f4c3a;"></i>
              </div>
            </div>


            <!-- 錯誤訊息 -->
            <?php if (isset($_SESSION["errorMsg"])) : ?>
              <div class="text-danger">
                <?= $_SESSION["errorMsg"] ?>
              </div>
            <?php unset($_SESSION["errorMsg"]);
            endif; ?>

            <div class=" mb-5 my-3 d-flex d-grid py-2 justify-content-between">
              <button type="submit" class="btn btn-primary">登入</button>
            <?php endif; ?>
        </form>
        <a class="btn btn-success" href="sign-up.php">註冊</a>
    </div>




    <div class="text-white text-shadow-sm fs-6">© Just Taiwan Tea</div>
  </div>
  </div>

  <script>
    function switchButton() {
      var button1 = document.getElementById('button1');
      var button2 = document.getElementById('button2');
      var inputField = document.getElementById('floatingPassword');

      if (button1.classList.contains('d-none')) {
        button1.classList.remove('d-none');
        button2.classList.add('d-none');
        inputField.type = 'password';
      } else {
        button1.classList.add('d-none');
        button2.classList.remove('d-none');
        inputField.type = 'text';
      }
    }

    function checkInput() {
      var inputField = document.getElementById('floatingPassword');
      var button1 = document.getElementById('button1');
      var button2 = document.getElementById('button2');

      if (inputField.value.trim() !== "") {
        if (button2.classList.contains('d-none')) {
          button1.classList.remove('d-none');
        } else {
          button2.classList.remove('d-none');
        }
      } else {
        button1.classList.add('d-none');
        button2.classList.add('d-none');
      }
    }
  </script>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>