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
    <title>sign-in</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php include("../css.php") ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
    </style>
</head>

<body>
    <div class="vh-100 d-flex justify-content-center align-items-center  ">
        <div class="login-panel">
            <img class="logo" src="../user_images/logo.svg" alt="">
            <h2 class="text-shadow-sm">drinking tea...</h2>
            <h6 class="text-dark text-shadow-sm">登入您的帳戶</h6>

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
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                            <label for="floatingPassword">Password</label>
                        </div>
                    </div>
                    <!-- 錯誤訊息 -->
                    <?php if (isset($_SESSION["errorMsg"])) : ?>
                        <div class="text-danger">
                            <?= $_SESSION["errorMsg"] ?>
                        </div>
                    <?php unset($_SESSION["errorMsg"]);
                    endif; ?>

                    <!-- =========== -->
                    <div class="form-check my-3 text-dark">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Remember me
                        </label>
                    </div>
                    <div class=" mb-5 my-3 d-flex d-grid py-2 justify-content-between">
                        <button type="submit" class="btn btn-primary">Log in</button>
                        <button type="submit" class="btn btn-secondary">Register</button>
                    </div>
                </form>


            <?php endif; ?>
            <div class="text-white text-shadow-sm fs-6">© Just Taiwan Tea</div>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>