<?php
require_once("../db_connect.php");

// 獲取所有優惠券的總數
$sqlALL = "SELECT * FROM coupons WHERE valid=1";
$resultAll = $conn->query(($sqlALL));
$allUserCount = $resultAll->num_rows;

$searchCondition = "";
$typeCondition = "";
$statusCondition = "";

if (isset($_GET["search"])) {
  $search = $_GET["search"];
  // <!-- 由於"狀態"不是數據庫中的直接欄位，而是通過PHP代碼計算得出的，因此我們需要在order前先把status定義。 -->
  $sql = "SELECT *,
    CASE
      WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) < NOW() AND (STR_TO_DATE(end_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '可使用'
      WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '未開放'
      ELSE '已停用'
    END AS status
    FROM coupons
    WHERE (name LIKE '%$search%' OR code LIKE '%$search%') AND valid=1 ";
} else if (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["category"]) && isset($_GET["status"])) {
  $page = $_GET["page"];
  $perPage = 10;
  $firstItem = ($page - 1) * $perPage;
  $pageCount = ceil($allUserCount / $perPage);

  $order = isset($_GET["order"]) ? $_GET["order"] : 'id_asc';

  //⭐︎⭐︎⭐︎ 排序
  switch ($order) {

    case "id_desc": // id ASC
      // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id ASC LIMIT $firstItem,$perPage";
      $orderClause = "ORDER BY id DESC";
      break;
    case "id_asc": // id DESC
      // $sql = "SELECT * FROM users WHERE valid=1 ORDER BY id DESC LIMIT $firstItem,$perPage";
      $orderClause = "ORDER BY id ASC";
      break;
    case "name_desc":
      $orderClause = "ORDER BY name DESC";
      break;
    case "name_asc":
      $orderClause = "ORDER BY name ASC";
      break;
    case "code_desc":
      $orderClause = "ORDER BY code DESC";
      break;
    case "code_asc":
      $orderClause = "ORDER BY code ASC";
      break;
    case "category_desc":
      $orderClause = "ORDER BY category DESC";
      break;
    case "category_asc":
      $orderClause = "ORDER BY category ASC";
      break;
    case "discount_desc":
      $orderClause = "ORDER BY discount DESC";
      break;
    case "discount_asc":
      $orderClause = "ORDER BY discount ASC";
      break;
    case "min_spend_amount_desc":
      $orderClause = "ORDER BY min_spend_amount DESC";
      break;
    case "min_spend_amount_asc":
      $orderClause = "ORDER BY min_spend_amount ASC";
      break;
    case "stock_desc":
      $orderClause = "ORDER BY stock DESC";
      break;
    case "stock_asc":
      $orderClause = "ORDER BY stock ASC";
      break;
    case "start_time_desc":
      $orderClause = "ORDER BY start_time DESC";
      break;
    case "start_time_asc":
      $orderClause = "ORDER BY start_time ASC";
      break;
    case "end_time_desc":
      $orderClause = "ORDER BY end_time DESC";
      break;
    case "end_time_asc":
      $orderClause = "ORDER BY end_time ASC";
      break;
    case "status_asc":
    case "status_desc":
      $orderClause = "ORDER BY status " . ($order == "status_asc" ? "ASC" : "DESC");
      // $condition ? $value_if_true : $value_if_false
      // 這裡的 $condition 是一個表達式，如果 $condition 為真（即值不為 false、0、空字符串、null 或空陣列），則返回 $value_if_true，否則返回 $value_if_false。
      break;
    default:
      $orderClause = "ORDER BY id ASC";
      break;
  }


  $type = $_GET["category"] ? $_GET["category"] : '';
  if ($type === '金額') {
    $typeCondition = "AND category='金額'";
  } elseif ($type === '百分比') {
    $typeCondition = "AND category='百分比'";
  } else {
    $typeCondition = '';
  }

  $status = $_GET["status"] ? $_GET["status"] : '';
  if ($status === '可使用') {
    $statusCondition = "AND status='可使用'";
  } elseif ($status === '已停用') {
    $statusCondition = "AND status='已停用'";
  } elseif ($status === '未開放') {
    $statusCondition = "AND status='未開放'";
  } else {
    $statusCondition = '';
  }



  $sql = "SELECT *,
  CASE
    WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) < NOW() AND (STR_TO_DATE(end_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '可使用'
    WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '未開放'
    ELSE '已停用'
  END AS status
  FROM coupons 
  WHERE valid=1 $typeCondition $statusCondition $orderClause LIMIT $firstItem, $perPage";

  $sql2 = "SELECT *,
  CASE
    WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) < NOW() AND (STR_TO_DATE(end_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '可使用'
    WHEN (STR_TO_DATE(start_time, '%Y-%m-%d %H:%i:%s')) > NOW() THEN '未開放'
    ELSE '已停用'
  END AS status
  FROM coupons 
  WHERE valid=1 $typeCondition $statusCondition $orderClause";
  // 取到類別向下的筆數，sql不能被limit

  $result2 = $conn->query($sql2);
  $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
  $userCount2 = $result2->num_rows;
  // 取到類別向下的筆數，的總頁數

  $pageCount = ceil($userCount2 / $perPage);
} else {
  $sql = "SELECT * FROM coupons WHERE valid=1";
  header("location: coupons.php?page=1&order=id_asc&category=&status=");
}



$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$userCount = $result->num_rows;



if (!isset($_GET["search"]) && empty($type)) {
  $userCount = $allUserCount;
}

// 更新status到數據庫
foreach ($rows as $coupon) {
  $status = $coupon['status'];
  $id = $coupon['id'];
  $updateStatusSQL = "UPDATE coupons SET status='$status' WHERE id=$id";
  $conn->query($updateStatusSQL);
}
//如果沒寫這段，status在排序的時候會自動帶入值
if ($_GET["status"] == '') {

  $status = '';
}

?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


  <?php include("../css.php") ?>
  <?php include("ne-css.php") ?>
</head>

<body>
  <!-- header、aside -->
  <?php include("../dashboard-comm.php") ?>
  <main class="main-content p-3">
    <div class="text-center mt-3 pt-3">
      <h1>優惠券清單</h1>
    </div>
    <div class="d-flex justify-content-between">
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
    </div>
    <hr>
    <!---------------------------------------------這裡是內容 ------------------------------------->
    <div class="container">
      <div>
        <?php if (isset($_GET["search"])) : ?>
          <a href="coupons.php"><button class="btn btn-custom "><i class="fa-solid fa-arrow-left"></i></button></a>
        <?php endif; ?>
      </div>

      <div class="d-flex pb-4">
        <form action="" class="me-3 flex-grow-1">
          <div class="input-group "> <!-- 搜尋框 -->

            <input type="text" class="form-control" placeholder="請輸入優惠券名稱或代碼" name="search">
            <button class="btn btn-custom " type="submit">
              <i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
        <div class="">
          <a class="btn btn-custom" href="create-coupon.php" title="增加優惠券"><i class="fa-solid fa-ticket "></i></a>
        </div>
      </div>
      <div class="d-flex">
        <!-- ⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎共幾張 -->
        <div class="me-2">
          共
          <?php if (isset($_GET["category"])) : ?>
            <?= $userCount2 ?>
          <?php else : ?>
            <?= $userCount ?>
          <?php endif; ?>
          張
        </div>
        <div class="pb-4 d-flex justify-content-end gap-2 ms-auto">
          <!-- ⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎拉種類的功能 -->
          <div>
            <form action="" method="GET" id="filter-form">
              <select name="category" class="form-select" onchange="filterCoupons()">
                <option value="">所有種類</option>
                <option value="金額">金額</option>
                <option value="百分比">百分比</option>
              </select>
            </form>
          </div>

          <!-- ⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎⛳︎拉狀態的功能 -->
          <div>
            <form action="" method="GET" id="filter-form2">
              <select name="status" class="form-select" onchange="filterCoupons2()">
                <option value="">所有狀態</option>
                <option value="可使用">可使用</option>
                <option value="已停用">已停用</option>
                <option value="未開放">未開放</option>
              </select>
            </form>
          </div>
        </div>
      </div>
      <div class="">
        <table class="table table-striped text-nowrap ">
          <thead class="table-header">
            <!-- //⭐︎⭐︎⭐︎ 排序 -->
            <th>ID<a href="?page=<?= $page ?>&order=<?= $order == 'id_asc' ? 'id_desc' : 'id_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a></th>
            <th>優惠券名稱<a href="?page=<?= $page ?>&order=<?= $order == 'name_asc' ? 'name_desc' : 'name_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a></th>
            <th>代碼<a href="?page=<?= $page ?>&order=<?= $order == 'code_asc' ? 'code_desc' : 'code_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>種類<a href="?page=<?= $page ?>&order=<?= $order == 'category_asc' ? 'category_desc' : 'category_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>折扣面額<a href="?page=<?= $page ?>&order=<?= $order == 'discount_asc' ? 'discount_desc' : 'discount_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a></th>
            <th>低消金額<a href="?page=<?= $page ?>&order=<?= $order == 'min_spend_amount_asc' ? 'min_spend_amount_desc' : 'min_spend_amount_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>數量<a href="?page=<?= $page ?>&order=<?= $order == 'stock_asc' ? 'stock_desc' : 'stock_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>開始時間<a href="?page=<?= $page ?>&order=<?= $order == 'start_time_asc' ? 'start_time_desc' : 'start_time_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>結束時間<a href="?page=<?= $page ?>&order=<?= $order == 'end_time_asc' ? 'end_time_desc' : 'end_time_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>
            <th>狀態<a href="?page=<?= $page ?>&order=<?= $order == 'status_asc' ? 'status_desc' : 'status_asc' ?>&category=<?= $type ?>&status=<?= $status ?>"><i class="fa-solid fa-sort sort-icon"></i></a>
            </th>

            <th></th>
          </thead>
          <tbody class="status-colors">
            <?php foreach ($rows as $coupon) : ?>


              <?php
              // $status=$coupon['status'];
              $statusClass = '';
              switch ($coupon['status']) {
                case '可使用':
                  $statusClass = 'status-available';
                  break;
                case '未開放':
                  $statusClass = 'status-not-open';
                  break;
                case '已停用':
                  $statusClass = 'status-disabled';
                  break;
              }
              ?>
              <tr class="align-middle">
                <td><?= $coupon["id"] ?></td>
                <td><?= $coupon["name"] ?></td>
                <td><?= $coupon["code"] ?></td>
                <td><?= $coupon["category"] ?></td>
                <td><?= $coupon["discount"] ?></td>
                <td><?= $coupon["min_spend_amount"] ?></td>
                <td><?= $coupon["stock"] ?></td>
                <td><?= $coupon["start_time"] ?></td>
                <td><?= $coupon["end_time"] ?></td>

                <td>
                  <p id="<?= $statusClass ?>" class="status-custom"><?= $coupon["status"] ?></p>
                </td>

                <td>
                  <a class="btn " href="coupon.php?id=<?= $coupon["id"] ?>"><i class="fa-regular fa-eye eye-icon"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if (isset($_GET["page"])) : ?>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                <li class="page-item
                      
                        <?php if ($i == $page) echo "active" ?>"><a class="page-link" href="?page=<?php echo $i; ?>&order=<?php echo $order; ?>&category=<?php echo $type; ?>&status=<?php echo $status; ?>"><?= $i ?></a></li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php endif; ?>
      </div>
    </div>

  </main>
  <!-- 😀😀😀 -->
  <?php include("../js.php") ?>

  <script>
    function filterCoupons() {
      const selectedCategory = document.getElementById('filter-form').category.value;
      const selectedStatus = document.getElementById('filter-form2').status.value;

      // 保存或清空选定的类别到 localStorage
      if (selectedCategory === '所有種類') {
        localStorage.removeItem('selectedCategory');
      } else {
        localStorage.setItem('selectedCategory', selectedCategory);
      }

      const currentPage = 1; // 每次重新选择类别时，重置到第一页
      const currentOrder = '<?php echo $order; ?>';

      const filterLink = `coupons.php?page=${currentPage}&order=${currentOrder}&category=${selectedCategory}&status=${selectedStatus}`;
      window.location.href = filterLink;
    }

    function filterCoupons2() {
      const selectedCategory = document.getElementById('filter-form').category.value;
      const selectedStatus = document.getElementById('filter-form2').status.value;

      // 保存或清空选定的状态到 localStorage
      if (selectedStatus === '所有狀態') {
        localStorage.removeItem('selectedStatus');
      } else {
        localStorage.setItem('selectedStatus', selectedStatus);
      }

      const currentPage = 1; // 每次重新选择状态时，重置到第一页
      const currentOrder = '<?php echo $order; ?>';

      const filterLink = `coupons.php?page=${currentPage}&order=${currentOrder}&category=${selectedCategory}&status=${selectedStatus}`;
      window.location.href = filterLink;
    }

    window.onload = function() {
      const storedCategory = localStorage.getItem('selectedCategory');
      const storedStatus = localStorage.getItem('selectedStatus');

      if (storedCategory !== null) {
        document.getElementById('filter-form').category.value = storedCategory;
      } else {
        document.getElementById('filter-form').category.value = '';
      }

      if (storedStatus !== null) {
        document.getElementById('filter-form2').status.value = storedStatus;
      } else {
        document.getElementById('filter-form2').status.value = '';
      }
    }
  </script>




</body>

</html>