<?php
if (!isset($_GET["id"])) {
  $id = 1; //若沒有選特定的，顯示預設第一筆資料
} else {
  $id = $_GET["id"];
}

require_once("../db_connect.php");
$sql = "SELECT * FROM users WHERE id = $id AND valid = 1";
// echo $sql;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);//確認抓的到資料
if ($result->num_rows > 0) {
  $userExit = true;
  $title = $row["name"];
} else {
  $userExit = false;
  $title = "使用者不存在";
}
$array = explode("-", $row["birthday"]);
$year = $array[0];
$month = $array[1];
$day = $array[2];
?>
<!---------------------------------------------這裡是內容 ------------------------------------->

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("../css.php") ?>
  <?php include("user-css.php"); ?>
  <style>
    /* .user-image {
       background-image: url("images/boy.png") ; 


    } */
    .cir {
      width: 350px;
      height: 350px;
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
      <h1>修改會員檔案</h1>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
    <hr>
    <!---------------------------------------------這裡是內容 ------------------------------------->
    <div class="container">
      <!-- ===回主選單按鈕=== -->
      <div class="py-2">
        <a class="btn btn-dark" href="user.php?id=<?= $id ?>">
          <!-- ?? -->
          <i class="fa-solid fa-arrow-left"></i>&nbsp回會員檔案</a>

        <a href="users.php" class="btn btn-dark">會員管理中心</a>
      </div>
      <!-- ===回主選單按鈕=== -->
      <?php if ($userExit) : ?>

        <form action="doUpdateUser.php" method="post" enctype="multipart/form-data">
          <div class="row justify-content-center">
            <div class="col-lg-4 mt-3">
              <div class="position-relative">
                <div class="ratio ratio-1x1 rounded-circle border border-5 overflow-hidden bg-transparent cir">
                  <img id="previewImage" src="../user_images/<?= $row["images_name"] ?>">
                  <!-- <img id="previewImage" src="/upload/<? //$image["pic_name"] 
                                                            ?>" alt="圖片預覽" class="object-fit-cover"> -->
                </div>

                <div class="position-absolute  top-100 start-0 ">

                  <input type="file" id="fileUpload" name="image" style="display: none;" onchange="displayImage(this)">
                  <!-- accept="image/*"  -->
                  <button type="button" class="btn btn-dark" onclick="document.getElementById('fileUpload').click();">
                    選擇圖片
                  </button>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-3">
              <table class="table table-bordered align-middle justify-content-center">
                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                <tr>
                  <th class="text-center">ID</th>
                  <td class="ps-3"><?= $row["id"] ?></td>
                </tr>
                <tr>
                  <th class="text-center">姓名</th>
                  <td>
                    <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                  </td>
                </tr>
                <tr>
                  <th class="text-center">帳號</th>
                  <td class="ps-3"><?= $row["account"] ?></td>
                </tr>
                <tr>
                  <th class="text-center">Email</th>
                  <td><input type="text" class="form-control" name="email" value="<?= $row["email"] ?>"></td>
                </tr>
                <tr>
                  <th class="text-center">密碼</th>
                  <td><input type="text" class="form-control" name="password" value="<?= $row["password"] ?>"></td>
                </tr>
                <tr>
                  <th class="text-center">電話</th>
                  <td><input type="text" class="form-control" name="phone" value="<?= $row["phone"] ?>"></td>
                </tr>

                <tr>
                  <th class="text-center">生日</th>
                  <td>
                    <!-- <input type="text" class="form-control" name="phone" value="<= $row["phone"] >">
                    
                    
                      <div class="mb-2 d-flex"> -->
                    <div class="d-flex align-items-center ">

                      <?php //var_dump($year, $month, $day) 
                      ?>
                      <select name="birthday-y" id="" class="form-select">
                        <?php for ($i = 1925; $i <= 2024; $i++) : ?>
                          <option <?php if ($i == $year) echo "selected" ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                      <p class="mt-3">&nbsp年&nbsp</p> <select name="birthday-m" id="" class="form-select">
                        <!-- <option selected="" value="0">請選擇</option> -->
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                          <option <?php if ($i == $month) echo "selected" ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                      <p class="mt-3">&nbsp月&nbsp</p>
                      <select name="birthday-d" id="" class="form-select ">
                        <!-- <option selected="" value="0">請選擇</option> -->
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                          <option <?php if ($i == $day) echo "selected" ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select>
                      <p class="mt-3">&nbsp日&nbsp</p>

                    </div>
                  </td>

                <tr>
                  <th class="text-center">性別</th>
                  <td>
                    <?php
                    // 從資料庫獲取的性別描述
                    $gender_description = $row["gender"];

                    // 創建一個映射陣列
                    $gender_map = [
                      "女性" => 1,
                      "男性" => 2,
                      "其他" => 3
                    ]; // 將描述轉換成對應的值
                    $gender_value = $gender_map[$gender_description] ?? null;
                    // 使用 null 作為預設值以處理未知性別
                    ?>
                    <select name="gender" id="gender" class="form-select">
                      <option value="1" <?= ($gender_value == 1 ? 'selected' : ''); ?>>女性</option>
                      <option value="2" <?= ($gender_value == 2 ? 'selected' : ''); ?>>男性</option>
                      <option value="3" <?= ($gender_value == 3 ? 'selected' : ''); ?>>其他</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="text-center">城市</th>
                  <td>
                    <!-- <?php $location = $row["location"]; ?> -->
                    <select name="location" id="" class="form-select" type="text">

                      <option value="臺北市" <?= ($location == "臺北市" ? 'selected' : ''); ?>>臺北市</option>
                      <option value="彰化縣" <?= ($location == "彰化縣" ? 'selected' : ''); ?>>彰化縣</option>
                      <option value="南投縣" <?= ($location == "南投縣" ? 'selected' : ''); ?>>南投縣</option>
                      <option value="嘉義市" <?= ($location == "嘉義市" ? 'selected' : ''); ?>>嘉義市</option>
                      <option value="嘉義縣" <?= ($location == "嘉義縣" ? 'selected' : ''); ?>>嘉義縣</option>
                      <option value="雲林縣" <?= ($location == "雲林縣" ? 'selected' : ''); ?>>雲林縣</option>
                      <option value="臺南市" <?= ($location == "臺南市" ? 'selected' : ''); ?>>臺南市</option>
                      <option value="高雄市" <?= ($location == "高雄市" ? 'selected' : ''); ?>>高雄市</option>
                      <option value="澎湖縣" <?= ($location == "澎湖縣" ? 'selected' : ''); ?>>澎湖縣</option>
                      <option value="屏東縣" <?= ($location == "屏東縣" ? 'selected' : ''); ?>>屏東縣</option>
                      <option value="臺東縣" <?= ($location == "臺東縣" ? 'selected' : ''); ?>>臺東縣</option>
                      <option value="基隆市" <?= ($location == "基隆市" ? 'selected' : ''); ?>>基隆市</option>
                      <option value="花蓮縣" <?= ($location == "花蓮縣" ? 'selected' : ''); ?>>花蓮縣</option>
                      <option value="金門縣" <?= ($location == "金門縣" ? 'selected' : ''); ?>>金門縣</option>
                      <option value="連江縣" <?= ($location == "連江縣" ? 'selected' : ''); ?>>連江縣</option>
                      <option value="新北市" <?= ($location == "新北市" ? 'selected' : ''); ?>>新北市</option>
                      <option value="宜蘭縣" <?= ($location == "宜蘭縣" ? 'selected' : ''); ?>>宜蘭縣</option>
                      <option value="新竹市" <?= ($location == "新竹市" ? 'selected' : ''); ?>>新竹市</option>
                      <option value="新竹縣" <?= ($location == "新竹縣" ? 'selected' : ''); ?>>新竹縣</option>
                      <option value="桃園市" <?= ($location == "桃園市" ? 'selected' : ''); ?>>桃園市</option>
                      <option value="苗栗縣" <?= ($location == "苗栗縣" ? 'selected' : ''); ?>>苗栗縣</option>
                      <option value="臺中市" <?= ($location == "臺中市" ? 'selected' : ''); ?>>臺中市</option>
                    </select>
                  </td>
                </tr>
              </table>
              <div class="py-2 d-flex justify-content-end">
                <button class="btn btn-dark" type="submit">送出</button>
              </div>
            </div>
            <div class="col-lg-2 mt-3"></div>
          </div>
        </form>
      <?php else : ?>
        <h1>使用者不存在</h1>
      <?php endif; ?>
    </div>
    <!-- ================== -->
  </main>

  <!-- 判斷使用者是否存在 -->

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
    const profilePicPath = '../user_images/profilepic.jpg';

    previewImage.onerror = function() {
      previewImage.src = profilePicPath;
    };
  </script>
  <!-- ===========圖片JS=========== -->
</body>

</html>