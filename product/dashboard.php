<!doctype html>
<html lang="en">

<head>
  <title>主控台</title>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php include("../css.php") ?>
  <style>

  </style>
</head>

<body>
  <header class="main-header bg-success-subtle d-flex fixed-top shadow justify-content-between align-items-center">
    <a href="dashboard.php" class="google-font fs-5 p-3 text-success bg-success-subtle">
      雅茗
    </a>

    <div class="d-flex align-middle me-3 gap-3">
      <p class="google-font fs-5 m-0 pt-1">Hi,admin</p>
      <a href="" class="btn btn-dark">登入</a>
      <a href="" class="btn btn-dark">登出</a>
    </div>
  </header>

  <aside class="aside-left position-fixed border-end border-3 vh-100 google-font fs-4">

    <ul class="list-unstyled">
      <li>
        <a class="d-block p-2 px-3" href="dashboard.php">
          <i class="bi bi-house-fill me-2"></i>首頁
        </a>
      </li>
      <li>
        <a class="d-block p-2 px-3 pmList">
          <i class="bi bi-cart4 me-2"></i></i>商品管理
        </a>
        <ul class="listWatch deactive list-unstyled ps-5 fs-5 position-relative">
          <li>
            <a href="product-list.php"><i class="fa-solid fa-play fs-6"></i> 商品列表</a>
          </li>
          <li>
            <a href="product-add.php"><i class="fa-solid fa-play fs-6"></i> 新增商品</a>
          </li>
          <li>
            <a href="product-category.php"><i class="fa-solid fa-play fs-6"></i> 商品分類管理</a>
          </li>
        </ul>
      </li>
      <li>
        <a class="d-block p-2 px-3" href="">
          <i class="bi bi-cash me-2"></i>優惠券管理
        </a>
      </li>
      <li>
        <a class="d-block p-2 px-3" href="">
          <i class="bi bi-flag me-2"></i>課程管理
        </a>
      </li>
      <li>
        <a class="d-block p-2 px-3" href="">
          <i class="bi bi-clipboard2-data me-2"></i>訂單管理
        </a>
      </li>
      <li>
        <a class="d-block p-2 px-3" href="">
          <i class="bi bi-book me-2"></i>文章管理
        </a>
      </li>
      <li>
        <a class="d-block p-2 px-3" href="">
          <i class="bi bi-paypal me-2"></i>付款方式
        </a>
      </li>

    </ul>
  </aside>
  <main class="main-content p-3">
    <div class="d-flex justify-content-between">
      <h1>主控台</h1>
    </div>
    </div>
    <hr>
  </main>
  <?php include_once("../js.php") ?>
  <script>
    const pmList = document.querySelector(".pmList")
    const listWatch = document.querySelector(".listWatch")


    pmList.addEventListener("click", function() {
      listWatch.classList.toggle("deactive");
      listWatch.classList.toggle("list-active");
    })
  </script>
</body>

</html>