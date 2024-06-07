<!-- ============================== -->
<?php
session_start();
if (!isset($_GET["id"])) {
  $id = 1; //若沒有選特定的，顯示預設第一筆資料
} else {
  $id = $_GET["id"];
}

require_once("../db_connect.php");
$sql = "SELECT * FROM users WHERE id = $id";
// $sql = "SELECT * FROM users WHERE id = $id AND valid=1";
// echo $sql;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
//var_dump($row);//確認抓的到資料

// 圖片區
if ($result->num_rows > 0) {
  $userExit = true;
  $title = $row["name"];
} else {
  $userExit = false;
  $title = "使用者不存在";
}
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
  <?php include("user-css.php") ?>
  <style>
    .cir {
      width: 350px;
      width: 350px;
      overflow: hidden;
    }

    img {

      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* 
    img {
      background-image: url("images/boy.png");
      position: center;
      background-size: 350px;


    } */

    /* .img-boy {
      background-image: url("images/boy.png");
      position: center;
      background-size: 350px;

    }

    .img-girl {
      background-image: url("images/girl.png");
      position: center;
      background-size: 350px;

    } */
  </style>
</head>

<body>
  <?php include("../dashboard-comm.php") ?>
  <main class="main-content p-3">
    <div class="d-flex justify-content-between">
      <h1>會員檔案</h1>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
    </div>
    <hr>
    <!---------------------------------------------這裡是內容 ------------------------------------->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">刪除帳號</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            確認凍結使用者?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>

            <a href="user-delete.php?id=<?= $row["id"] ?> " type="button" class="btn btn-danger">確認</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->

    <div class="container">
      <!-- ===回主選單按鈕=== -->
      <div class="py-2">
        <a href="users.php" class="btn btn-success"><i class="fa-solid fa-arrow-left"></i>&nbsp回會員列表</a>

      </div>
      <!-- ===回主選單按鈕=== -->
      <div class="row justify-content-center">
        <div class="col-lg-4 mt-3">

          <div class="ratio ratio-1x1 rounded-circle border border-5 overflow-hidden bg-transparent shadow p-3 mb-5 bg-body-tertiary rounded" style="position: relative; ">
            <img src="../user_images/<?= $row["images_name"] ?>" alt="使用者<?= $row["name"] ?>的照片">

          </div>
        </div>
        <div class="col-lg-6 ms-5 mt-3 shadow p-3 bg-body-tertiary rounded">
          <!-- ================== -->
          <?php if ($userExit) : ?>
            <!-- 判斷使用者是否存在 -->
            <table class="table table-bordered">
              <tr>
                <th class="text-center">ID</th>
                <td><?= $row["id"] ?></td>
              </tr>
              <tr>
                <th class="text-center">姓名</th>
                <td><?= $row["name"] ?></td>
              </tr>
              <tr>
                <th class="text-center">帳號</th>
                <td><?= $row["account"] ?></td>
              </tr>
              <tr>
                <th class="text-center">Email</th>
                <td><?= $row["email"] ?></td>
              </tr>
              <!-- <tr>
                <th class="text-center">密碼</th>
                <td>$row["password"]</td>
              </tr> -->

              <tr>
                <th class="text-center">電話</th>
                <td><?= $row["phone"] ?></td>
              </tr>
              <th class="text-center">生日</th>
              <td><?= $row["birthday"] ?></td>
              </tr>
              <th class="text-center">性別</th>
              <td><?= $row["gender"] ?></td>
              </tr class="text-center">
              <th class="text-center">城市</th>
              <td><?= $row["location"] ?></td>
              </tr>
              <tr>
                <th class="text-center">資料建立日期</th>
                <td><?= $row["created_at"] ?></td>
              </tr>
              <tr>
                <th class="text-center">帳號狀態</th>
                <td><?php if ($row["valid"] == 1) {
                      echo "有效";
                    } else echo "停權" ?></td>
              </tr>
              <tr>
              <td colspan="2">
              <div class="ms-3 mt-1 fs-5">
              <!-- 資料更新訊息 -->
                <?php if (isset($_SESSION["updateMsg"])) : ?>
                  <div class="text-danger">
                    <?= $_SESSION["updateMsg"] ?>
                  </div>
                <?php unset($_SESSION["updateMsg"]);
                endif; ?>
                <!-- 資料更新訊息 -->
              <div class="d-flex justify-content-end">
                <a class="btn btn-success me-3 " title="編輯使用者" href="user-edit.php?id=<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square">&nbsp修改</i></a>
                <!-- 修改按鈕 -->
  
                <button class="btn btn-danger" title="刪除使用者" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa-solid fa-trash-can">&nbsp刪除</i></button>
                <!-- 刪除按鈕 --></div>
                </td>  
              </tr>
            </table>
            <div class="col-lg-2 mt-3"></div>

            <!-- ================== -->
          <?php else : ?>
            <h1>使用者不存在</h1>
          <?php endif; ?>
          <!-- 判斷使用者是否存在 -->
        </div>

      </div>

    </div>
  </main>
  <?php include("../js.php") ?>
  <!-- bootstrapJS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>












</body>

</html>