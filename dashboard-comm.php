<header class="main-header bg-white d-flex fixed-top shadow justify-content-between align-items-center">
    <div class="my-2">
<img class="logo-img" src="/tea.png" alt="">
    <a href="dashboard.php" class="google-font fs-5 p-3 text-success bg-white">
    
    </a>
    </div>

    <div class="d-flex align-middle me-3 gap-3">
        <p class=" fs-5 m-0 pt-1">Hi,admin</p>
        <!-- <a href="" class="btn btn-dark">登入</a> -->
        <a href="/user/doSingOut.php" class="btn btn-dark">登出</a>
    </div>
</header>


<aside class="aside-left position-fixed border-end border-3 vh-100  fs-5">


    <ul class="list-unstyled">
        <li>
            <a class="d-block p-2 px-3" href="/dashboard.php">
                <i class="bi bi-house-fill me-2"></i>首頁<i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
        <li>
            <a class="d-block p-2 px-3 pmList">
                <i class="bi bi-clipboard2-data me-2"></i>會員管理<i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="listWatch deactive list-unstyled ps-5 fs-5">
                <li>
                    <a href="/user/users.php"><i class="fa-solid fa-play fs-6"></i> 會員列表</a>
                </li>
                <li>
                    <a href="/user/create-user.php"><i class="fa-solid fa-play fs-6"></i> 新增會員</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="d-block p-2 px-3 pmList">
                <i class="bi bi-cart4 me-2"></i></i>商品管理<i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="listWatch deactive list-unstyled ps-5 fs-5">
                <li>
                    <a href="/product/product-list.php"><i class="fa-solid fa-play fs-6"></i> 商品列表</a>
                </li>
                <li>
                    <a href="/product/product-add.php"><i class="fa-solid fa-play fs-6"></i> 新增商品</a>
                </li>
                <li>
                    <a href="/product/product-category.php"><i class="fa-solid fa-play fs-6"></i> 商品分類管理</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="d-block p-2 px-3 pmList">
                <i class="bi bi-cash me-2"></i>優惠券管理<i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="listWatch deactive list-unstyled ps-5 fs-5">
                <li>
                    <a href="/cupon/coupons.php"><i class="fa-solid fa-play fs-6"></i> 優惠券列表</a>
                </li>
                <li>
                    <a href="/cupon/create-coupon.php"><i class="fa-solid fa-play fs-6"></i> 新增優惠券</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="d-block p-2 px-3 pmList">
                <i class="bi bi-flag me-2"></i>課程管理<i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="listWatch deactive list-unstyled ps-5 fs-5">
                <li>
                    <a href="/activity/activity.php"><i class="fa-solid fa-play fs-6"></i> 課程列表</a>
                </li>
                <li>
                    <a href="/activity/create-activity.php"><i class="fa-solid fa-play fs-6"></i> 新增課程</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="d-block p-2 px-3">
                <i class="bi bi-clipboard2-data me-2"></i>訂單管理<i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
        <li>
            <a class="d-block p-2 px-3 pmList">
                <i class="bi bi-book me-2"></i>文章管理<i class="fa-solid fa-angle-right"></i>
            </a>
            <ul class="listWatch deactive list-unstyled ps-5 fs-5">
                <li>
                    <a href="/article/Articles.php"><i class="fa-solid fa-play fs-6"></i> 文章列表</a>
                </li>
                <li>
                    <a href="/article/addArticleUI.php"><i class="fa-solid fa-play fs-6"></i> 新增文章</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="d-block p-2 px-3">
                <i class="bi bi-paypal me-2"></i>付款方式<i class="fa-solid fa-angle-right"></i>
            </a>
        </li>

    </ul>
</aside>