<?php
require_once("../db_connect.php");

$sql = "SELECT articles.*,articles_category.name FROM articles
JOIN articles_category ON articles.category_id = articles_category.id WHERE valid=1";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
$allArticleCount = $result->num_rows;



$sqlCategory = "SELECT articles_category.* FROM articles_category ORDER BY id ASC";
$resultCate = $conn->query($sqlCategory);
$cateRows = $resultCate->fetch_all(MYSQLI_ASSOC);

$categoryArr = [];
foreach ($cateRows as $cate) {
  $categoryArr[$cate["id"]] = $cate["name"];
}




if (isset($_GET["search"]) && empty($_GET["delpage"])) {

  $page = $_GET["page"];
  $order = $_GET["order"];
  $perPage = 10;
  $firstItem = ($page - 1) * $perPage;
  $search = $_GET["search"];
  $searchSql = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.title LIKE '%$search%'  AND articles.valid=1  ";

  $searchResult = $conn->query($searchSql);
  $searchRow = $searchResult->fetch_all(MYSQLI_ASSOC);
  $searchPage = $searchResult->num_rows;
  $searchPageCount = ceil($searchPage / $perPage);





  switch ($order) {
    case 1:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.title LIKE '%$search%'  AND articles.valid=1 ORDER BY articles.id ASC LIMIT $firstItem, $perPage ";
      break;
    case 2:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.title LIKE '%$search%'  AND  articles.valid=1 ORDER BY articles.id DESC LIMIT $firstItem, $perPage ";
      break;
  }
} else if (isset($_GET["category"]) && isset($_GET["page"]) && isset($_GET["order"]) && !isset($_GET["delpage"])) {





  $category_id = $_GET["category"];
  $page = $_GET["page"];
  $order = $_GET["order"];
  $perPage = 10;
  $firstItem = ($page - 1) * $perPage;

  $sqlArticleNum = "SELECT articles.* FROM articles  WHERE articles.category_id = $category_id AND valid=1 ";
  $resultNum = $conn->query($sqlArticleNum);
  $rowsNum = $resultNum->fetch_all(MYSQLI_ASSOC);
  $OneArticleCount = $resultNum->num_rows;

  $onepageCount = ceil($OneArticleCount / $perPage);
  $pageCount = ceil($allArticleCount / $perPage);




  switch ($order) {
    case 1:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.category_id = $category_id AND articles.valid=1 ORDER BY articles.id ASC LIMIT $firstItem, $perPage ";
      break;
    case 2:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.category_id = $category_id AND  articles.valid=1 ORDER BY articles.id DESC LIMIT $firstItem, $perPage ";
      break;
  }
} else if (isset($_GET["page"]) && isset($_GET["order"]) && empty($_GET["delpage"])) {
  $page = $_GET["page"];
  $perPage = 10;
  $firstItem = ($page - 1) * $perPage;
  $pageCount = ceil($allArticleCount / $perPage);
  $order = $_GET["order"];

  switch ($order) {
    case 1:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.valid=1 ORDER BY articles.id ASC LIMIT $firstItem, $perPage ";
      break;
    case 2:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.valid=1 ORDER BY articles.id DESC LIMIT $firstItem, $perPage ";
      break;
  }
} else if (isset($_GET["delpage"])) {
  $order = $_GET["order"];
  $page = $_GET["page"];
  $perPage = 10;
  $firstItem = ($page - 1) * $perPage;
  $search = $_GET["search"];
  $delPageSumSql = "SELECT articles.* FROM articles  WHERE valid=0 ";
  $delPageSumResult = $conn->query($delPageSumSql);
  $delPageSumNumRows = $delPageSumResult->num_rows;

  $delPageSumCount = ceil($delPageSumNumRows / $perPage);


  switch ($order) {
    case 1:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.valid=0 AND articles.title LIKE '%$search%' ORDER BY articles.id ASC LIMIT $firstItem, $perPage";
      break;
    case 2:
      $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE articles.valid=0 AND articles.title LIKE '%$search%'  ORDER BY articles.id DESC LIMIT $firstItem, $perPage ";
      break;
  }
} else {
  $sqltest = "SELECT articles.*,articles_category.name FROM articles
      JOIN articles_category ON articles.category_id = articles_category.id WHERE article.valid=1";
  header("location:Articles.php?page=1&order=1");
}

$resultChange = $conn->query($sqltest);
$rowsChange = $resultChange->fetch_all(MYSQLI_ASSOC);














// if (isset($_GET["category"])){

// }


?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <?php include("../css.php"); ?>
  <?php include("article-css.php"); ?>
  <style>
    .testt {
      white-space: nowrap;
      overflow-x: auto;
      width: 100%;
    }

    .table {

      white-space: nowrap;
      overflow-x: auto;

    }

    input[type="text"] {
      border: 1px solid #ccc;
      /* border */
    }

    input[type="text"]:focus {
      outline: none;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .testTT {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
</head>

<body>
  <?php include("../dashboard-comm.php") ?>
  <main class="main-content p-3">
    <h1>文章管理</h1>
    <hr>

    </div>
    <div class="container">
      <?php if (!isset($_GET["search"])) : ?>
        <ul class="nav nav-underline mb-3">
          <li class="nav-item ">
            <a class="nav-link text-success <?php if (!isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["delpage"])) echo "active"; ?>" href="Articles.php">全部</a>
          </li>

          <?php foreach ($cateRows as $category) : ?>
            <li class="nav-item">
              <a class="nav-link text-success <?php if (isset($_GET["category"]) && $category_id == $category["id"]) echo "active"; ?>" href="Articles.php?page=1&order=1&category=<?= $category["id"] ?>"><?= $category["name"] ?>
              </a>
            </li>
          <?php endforeach; ?>
          <li class="nav-item ">
            <a class="nav-link text-success <?php if (isset($_GET["delpage"])) echo "active" ?> " href="Articles.php?delpage=1&page=1&order=1">下架文章</a>
          </li>
        </ul>
      <?php endif; ?>
      <?php if (isset($_GET["search"]) && empty($_GET["delpage"])) : ?>
        <div class="mb-3">

          <h2 class="fw-bold">標題搜尋"<?= $search ?>"的結果</h2>

        </div>
      <?php endif; ?>
      <?php if (isset($_GET["search"]) && isset($_GET["delpage"])) : ?>
        <div class="mb-3">

          <h2 class="fw-bold">下架標題搜尋"<?= $search ?>"的結果</h2>

        </div>
      <?php endif; ?>

      <!-- 搜尋 -->
      <?php if (empty($_GET["delpage"])) : ?>
        <div class="d-flex gap-3">
          <form action="" class="flex-grow-1">
            <div class="input-group">
              <?php if (isset($_GET["search"])) : ?>
                <a class="btn btn-success" href="Articles.php">
                  <i class="fa-solid fa-rotate-left"></i>
                </a>
              <?php endif; ?>

              <input type="hidden" name="page" value="1">
              <input type="hidden" name="order" value="1">

              <input type="text" name="search" class="form-control">
              <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </form>
          <!-- 新增按鈕 -->
          <div>
            <?php if (!isset($_GET["delpage"])) : ?>
              <a class=" mt-2" href="addArticleUI.php"><button class="btn btn-success">新增文章</button></a>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <?php if (!empty($_GET["delpage"])) : ?>
        <div class="d-flex gap-3">
          <form action="" class="flex-grow-1">
            <div class="input-group">
              <?php if (isset($_GET["search"])) : ?>

                <a class="btn btn-success" href="Articles.php">
                  <i class="fa-solid fa-rotate-left"></i>
                </a>

              <?php endif; ?>

              <input type="hidden" name="page" value="1">
              <input type="hidden" name="order" value="1">
              <input type="hidden" name="delpage" value="1">

              <input type="text" name="search" class="form-control">
              <button class="btn btn-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </form>
        </div>
        <!-- 新增按鈕 -->
        <div>
          <?php if (!isset($_GET["delpage"])) : ?>
            <a class=" mt-2" href="addArticleUI.php"><button class="btn btn-success">新增文章</button></a>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <!-- 排序 -->
      <div class="d-flex justify-content-end mt-1">
        <?php if (isset($_GET["page"]) && isset($_GET["order"]) && !isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["delpage"])) : ?>
          <div class="btn-group">

            <a href="?page=<?= $page ?>&order=1" class="btn btn-success <?php if ($order == 1) echo "active" ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
            <a href="?page=<?= $page ?>&order=2" class="btn btn-success <?php if ($order == 2) echo "active" ?>">id<i class="fa-solid fa-arrow-down-wide-short"></i></a>
          </div>

        <?php elseif (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["delpage"])) : ?>
          <div class="btn-group">

            <a href="?page=<?= $page ?>&order=1&category=<?= $category_id ?>" class="btn btn-success <?php if ($order == 1) echo "active" ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
            <a href="?page=<?= $page ?>&order=2&category=<?= $category_id ?>" class="btn btn-success <?php if ($order == 2) echo "active" ?>">id<i class="fa-solid fa-arrow-down-wide-short"></i></a>
          </div>

        <?php elseif (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["search"]) && !isset($_GET["category"]) && !isset($_GET["delpage"])) : ?>
          <div class="btn-group">

            <a href="?page=<?= $page ?>&order=1&search=<?= $search ?>" class="btn btn-success <?php if ($order == 1) echo "active" ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
            <a href="?page=<?= $page ?>&order=2&search=<?= $search ?>" class="btn btn-success <?php if ($order == 2) echo "active" ?>">id<i class="fa-solid fa-arrow-down-wide-short"></i></a>
          </div>

        <?php elseif (isset($_GET["delpage"]) && !isset($_GET["search"]) && isset($_GET["order"]) && !isset($_GET["category"]) && isset($_GET["page"])) : ?>
          <div class="btn-group">

            <a href="?delpage=1&page=<?= $page ?>&order=1" class="btn btn-success <?php if ($order == 1) echo "active" ?>">id <i class="fa-solid fa-arrow-down-short-wide"></i></a>
            <a href="?delpage=1&page=<?= $page ?>&order=2" class="btn btn-success <?php if ($order == 2) echo "active" ?>">id<i class="fa-solid fa-arrow-down-wide-short"></i></a>
          </div>

        <?php endif; ?>
      </div>
      <hr>
      <!---------------------------------------------這裡是內容 ------------------------------------->
      <?php if ($result->num_rows > 0) : ?>
        <div class="testt mb-2">
          <table class="table">
            <thead>
              <tr>

                <th>文章編號</th>
                <th>文章標題</th>
                <th>文章種類</th>
                <th>建立時間</th>
                <th>修改時間</th>
                <th></th>
                <th class=""></th>

              </tr>
              <tr class="">

                <?php if (!isset($_GET["delpage"]) && (isset($_GET["search"]) || isset($_GET["page"]))) : ?>
                  <?php foreach ($rowsChange as $row) : ?>

                    <div class="modal fade" id="deleteModal<?= $row["id"] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">再次確認</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            確認刪除文章?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="deleteArticle.php?id=<?= $row["id"] ?>" type="button" class="btn btn-success">確認</a>
                          </div>
                        </div>
                      </div>
                    </div>

              <tr class="">

                <th><?= $row["id"] ?></th>
                <th class="testTT"><?= $row["title"] ?></th>
                <th><?= $row["name"] ?></th>
                <th><?= $row["created_at"] ?></th>
                <th><?= $row["updated_at"] ?></th>

                    <th class="text-center">
                      <span class="d-inline-block"><a class="d-inline-block me-1" href="lookArticles.php?id=<?php echo $row["id"] ?>"><button class="btn btn-success"><i class="bi bi-eye-fill"></i></button></a>
                        <a class="d-inline-block me-1" href="editArticle.php?id=<?= $row["id"] ?>"><button class="btn btn-success"><i class="bi bi-pencil-fill"></i></button></a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row["id"] ?>"><i class="bi bi-trash3-fill"></i></button></span>
                    </th>




              </tr>
            <?php endforeach; ?>
          <?php elseif (isset($_GET["delpage"])) : ?>
            <?php foreach ($rowsChange as $row) : ?>

              <div class="modal fade" id="addModal<?= $row["id"] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">再次確認</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      要重新上架此文章?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a href="backArticle.php?id=<?= $row["id"] ?>" type="button" class="btn btn-success">確認</a>
                    </div>
                  </div>
                </div>
              </div>

              <tr class="">

                <th><?= $row["id"] ?></th>
                <th class="testTT"><?= $row["title"] ?></th>
                <th><?= $row["name"] ?></th>
                <th><?= $row["created_at"] ?></th>
                <th><?= $row["updated_at"] ?></th>

                <th class="text-center">
                  <span class="d-inline-block"><a class="d-inline-block me-1" href="lookArticles.php?id=<?php echo $row["id"] ?>"><button class="btn btn-success"><i class="bi bi-eye-fill"></i></button></a>
                    <a class="d-inline-block me-1" href="deleditArticle.php?id=<?= $row["id"] ?>"><button class="btn btn-success"><i class="bi bi-pencil-fill"></i></button></a>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal<?= $row["id"] ?>"><i class="fa-solid fa-rotate-left"></i></button></span>
                </th>



              </tr>
            <?php endforeach; ?>

          <?php endif; ?>
            </thead>
          </table>

        </div>
        <?php if (isset($_GET["page"]) && isset($_GET["order"]) && !isset($_GET["search"]) && !isset($_GET["category"]) && !isset($_GET["delpage"])) : ?>
          <nav aria-label="Page navigation example ">
            <ul class="pagination">
              <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                <li class="page-item  <?php if ($i == $page) echo "active" ?>">
                  <a class="page-link  btn-success" href="?page=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>

        <?php elseif (isset($_GET["page"]) && isset($_GET["order"]) && !isset($_GET["delpage"])  && !isset($_GET["category"])  && isset($_GET["search"])) : ?>
          <nav aria-label="Page navigation example ">
            <ul class="pagination">
              <?php for ($i = 1; $i <= $searchPageCount; $i++) : ?>
                <li class="page-item  <?php if ($i == $page) echo "active" ?>">
                  <a class="page-link  btn-success" href="?page=<?= $i ?>&order=<?= $order ?>&search=<?= $search ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>

        <?php elseif (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["delpage"])) : ?>
          <nav aria-label="Page  navigation example ">
            <ul class="pagination ">
              <?php for ($i = 1; $i <= $onepageCount; $i++) : ?>

                <li class="page-item  <?php if ($i == $page) echo "active" ?>">
                  <a class="page-link  btn-success" href="?page=<?= $i ?>&order=<?= $order ?>&category=<?= $category_id ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        <?php elseif (isset($_GET["page"]) && isset($_GET["order"]) && isset($_GET["delpage"])  && !isset($_GET["search"]) && !isset($_GET["category"])) : ?>

          <nav aria-label="Page navigation example ">
            <ul class="pagination ">
              <?php for ($i = 1; $i <= $delPageSumCount; $i++) : ?>
                <li class="page-item  <?php if ($i == $page) echo "active" ?>">
                  <a class="page-link  btn-success" href="?page=<?= $i ?>&order=<?= $order ?>&delpage=1"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>


        <?php else : ?>

        <?php endif; ?>

      <?php endif; ?>















    </div>
  </main>
  <?php include("../js.php") ?>
</body>

</html>