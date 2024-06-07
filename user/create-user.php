<?php session_start(); ?>
<!-- 新增會員功能 -->
<!---------------------------------------------這裡是內容 ------------------------------------->
<!doctype html>
<html lang="en">

<head>
  <title>新增會員</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- CSS -->
  <?php include("user-css.php") ?>
  <?php include("../css.php") ?>
  <style>
    .cir {
      width: 200px;
      height: 200px;
      overflow: hidden;
    }

    img {

      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <!-- header、aside -->
  <?php include("../dashboard-comm.php") ?>
  <main class="main-content p-3">
    <div class="d-flex justify-content-between">
      <h1>新增會員</h1>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
    <hr>
    <!---------------------------------------------這裡是內容 ------------------------------------->
    <div class="container">
      <div class="py-2">
        <a href="users.php" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i>&nbsp回會員列表</a>
      </div>
      <form action="doCreateUser.php" method="post" enctype="multipart/form-data">
        <div class="row justify-content-center">
          <!-- 左側照片 -->
          <div class="col-lg-4 mt-3 ">
            <div class="position-relative">
              <div class="ratio ratio-1x1 rounded-circle border border-5 overflow-hidden bg-transparent shadow p-3 mb-5 bg-body-tertiary rounded"> <img id="previewImage" src="../user_images/user.png">
              </div>
              <div class="position-absolute bottom-0 start-50 translate-middle-x ">
                <input type="file" id="fileUpload" name="image" style="display: none;" onchange="displayImage(this)">
                <!-- accept="image/*"  -->
                <button type="button" class="btn btn-success   " onclick="document.getElementById('fileUpload').click();">
                  選擇圖片
                </button>
              </div>

            </div>
          </div>

          <!-- 右側資訊 -->
          <div class="col-lg-6 ms-5 mt-3 shadow p-3 mb-5 bg-body-tertiary rounded">


            <table class="table table-bordered align-middle justify-content-center  rounded">
              <tr>
                <th for="" class="form-label">姓名</th>
                <td><input type="text" class="form-control" name="name">
                </td>

              </tr>
              <tr>
                <th for="" class="form-label">帳號</th>
                <td><input type="text" class="form-control" name="account"></td>
              </tr>
              <tr>
                <th for="" class="form-label">email</th>
                <td><input type="email" class="form-control" name="email"></td>
              </tr>
              <tr>
                <th for="" class="form-label ">密碼</th>
                <td class="position-relative"> <input type="password" class="form-control " name="password" id="floatingPassword" placeholder="Password" name="password" oninput="checkInput()">
                  <div id="button2" class="btn position-absolute d-flex top-50 end-0  z-3 lookEye d-none" onclick="switchButton()">
                    <i class="fa-solid fa-eye fa-lg" style="color: #0f4c3a;"></i>
                  </div>
                  <div id="button1" class="btn position-absolute d-flex top-50 end-0 z-3 unlookEye d-none" onclick="switchButton()">
                    <i class="fa-solid fa-eye-slash fa-lg" style="color: #0f4c3a;"></i>
                  </div>
                </td>

              </tr>
              <tr>
                <th for="" class="form-label">電話</th>
                <td><input type="tel" class="form-control" name="phone"></td>
              </tr>
              <tr>
                <th for="" class="form-label">生日</th>
                <td>
                  <div class="d-flex align-items-center "><select name="birthday-y" id="" class="form-select">
                      <option selected="" value="0">請選擇</option>
                      <?php for ($i = 1925; $i <= 2024; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php endfor; ?>
                    </select>
                    <p class="mt-3">&nbsp年&nbsp</p>
                    <select name="birthday-m" id="" class="form-select">
                      <option selected="" value="0">請選擇</option>
                      <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php endfor; ?>
                    </select>
                    <p class="mt-3">&nbsp月&nbsp</p>
                    <select name="birthday-d" id="" class="form-select ">
                      <option selected="" value="0">請選擇</option>
                      <?php for ($i = 1; $i <= 31; $i++) : ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                      <?php endfor; ?>
                  </div></select>
                  <p class="mt-3">&nbsp日&nbsp</p>
                </td>
              </tr>
              <tr>
                <th for="" class="form-label">性別</th>
                <td> <select name="gender" id="" class="form-select">
                    <option value="0">請選擇</option>
                    <option value="1">女性</option>
                    <option value="2">男性</option>
                    <option value="3">其他</option>
                  </select></td>
              </tr>
              <tr>
                <th for="" class="form-label">城市</th>
                <td><select name="location" id="" class="form-select" type="text">
                    <option selected="" value="0">請選擇</option>
                    <option value="臺北市">臺北市</option>
                    <option value="彰化縣">彰化縣</option>
                    <option value="南投縣">南投縣</option>
                    <option value="嘉義市">嘉義市</option>
                    <option value="嘉義縣">嘉義縣</option>
                    <option value="雲林縣">雲林縣</option>
                    <option value="臺南市">臺南市</option>
                    <option value="高雄市">高雄市</option>
                    <option value="澎湖縣">澎湖縣</option>
                    <option value="屏東縣">屏東縣</option>
                    <option value="臺東縣">臺東縣</option>
                    <option value="基隆市">基隆市</option>
                    <option value="花蓮縣">花蓮縣</option>
                    <option value="金門縣">金門縣</option>
                    <option value="連江縣">連江縣</option>
                    <option value="新北市">新北市</option>
                    <option value="宜蘭縣">宜蘭縣</option>
                    <option value="新竹市">新竹市</option>
                    <option value="新竹縣">新竹縣</option>
                    <option value="桃園市">桃園市</option>
                    <option value="苗栗縣">苗栗縣</option>
                    <option value="臺中市">臺中市</option>

                  </select></td>
              </tr>
            </table>
            <!-- 錯誤訊息 -->
            <?php if (isset($_SESSION["errorMsg"])) : ?>
              <div class="text-danger">
                <?= $_SESSION["errorMsg"] ?>
              </div>
            <?php unset($_SESSION["errorMsg"]);
            endif; ?>
            <!-- 錯誤訊息 -->
            <div class="py-2 d-flex justify-content-end">
              <button class="btn btn-success" type="submit">送出</button>
            </div>
            <div class="col-lg-2 mt-3"></div>
          </div>
        </div>
      </form>
    </div>
  </main>

  <!-- ===========圖片JS=========== -->
  <script>
    // 圖片上傳
    function displayImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          document.getElementById('previewImage').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
  <script>
    // 圖片讀取失敗時
    const previewImage = document.getElementById('previewImage');
    const profilePicPath = 'C:\\xampp\\htdocs\\project\\images\\profilepic.JPG';

    previewImage.onerror = function() {
      previewImage.src = profilePicPath;
    };
  </script>
  <!-- ===========圖片JS=========== -->

  <!-- 顯示密碼eye btn -->
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
  <!-- 顯示密碼eye btn -->

</body>

</html>