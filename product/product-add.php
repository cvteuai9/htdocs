<?php
require_once("../db_connect.php");

$sqlTc = "SELECT id, name AS tc_name FROM tea_category";
$sqlBrand = "SELECT id, name AS brand_name FROM brand";
$sqlPack = "SELECT id, name AS pack_name FROM pack_category";
$sqlStyle = "SELECT id, name AS style_name FROM style";

$resultTc = $conn->query($sqlTc);
$resultBrand = $conn->query($sqlBrand);
$resultPack = $conn->query($sqlPack);
$resultStyle = $conn->query($sqlStyle);

$rowsTc = $resultTc->fetch_all(MYSQLI_ASSOC);
$rowsBrand = $resultBrand->fetch_all(MYSQLI_ASSOC);
$rowsPack = $resultPack->fetch_all(MYSQLI_ASSOC);
$rowsStyle = $resultStyle->fetch_all(MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">

<head>
    <title>新增商品頁</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php include("../css.php") ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --aside-witch: 200px;
            --header-height: 50px;
        }

        .logo {
            width: var(--aside-witch);
        }

        .aside-left {
            padding-top: var(--header-height);
            width: var(--aside-witch);
            top: 20px;
            overflow: auto;
        }

        .main-content {
            margin: var(--header-height) 0 0 var(--aside-witch);
        }

        #preview {
            width: 400px;
            height: 400px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #preview img {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</head>

<body>
    <header class="main-header bg-dark d-flex fixed-top shadow justify-content-between align-items-center">
        <a href="" class="p-3 bg-black text-white text-decoration-none">
            tea
        </a>

        <div class="text-white me-3">
            Hi,adain
            <a href="" class="btn btn-dark">登入</a>
            <a href="" class="btn btn-dark">登出</a>
        </div>
    </header>
    <aside class="aside-left position-fixed bg-white border-end vh-100 ">
        <ul class="list-unstyled">
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-house-fill me-2"></i>首頁
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-cart4 me-2"></i></i>商品
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-cash me-2"></i>優惠券
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-flag me-2"></i>課程
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-clipboard2-data me-2"></i> 訂單
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-book me-2"></i> 文章管理
                </a>
            </li>
            <li>
                <a class="d-block p-2 px-3 text-decoration-none" href="">
                    <i class="bi bi-paypal me-2"></i> 付款方式
                </a>
            </li>

        </ul>
    </aside>
    <main class="main-content p-3">
        <!-- 返回商品列表按鈕 -->
        <div class="container-fluid mb-2">
            <a class="btn btn-success fs-4 mb-3" href="product-list.php?page=1&order=1">
                <i class="fa-solid fa-arrow-left"></i> 返回商品列表
            </a>
        </div>

        <div class="container text-center mb-4">
            <h1>新增商品頁</h1>
        </div>

        <div class="container">
            <div class="row justify-content-center">

                <!-- 商品圖片預覽區 -->
                <div class="col-lg-4 d-flex flex-column align-items-center">
                    <div id="preview">Image Preview</div>
                    <div class="h4 mt-1">圖片預覽</div>
                </div>

                <div class="col-lg-6">
                    <form action="doProductAdd.php" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered">
                            <!-- 商品圖片 -->
                            <tr>
                                <th>商品圖片</th>
                                <td>
                                    <!-- accept 限制檔案類型，image/* 所有image的類型都可上傳 -->
                                    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>
                                </td>
                            </tr>

                            <!-- 商品名稱 -->
                            <tr>
                                <th>商品名稱</th>
                                <td>
                                    <input class="form-control" type="text" name="productName" placeholder="請輸入商品名稱...">
                                </td>
                            </tr>

                            <!-- 品牌 -->
                            <tr>
                                <th>品牌</th>
                                <td>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="brand_id">
                                            <option selected></option>
                                            <?php foreach ($rowsBrand as $row) : ?>
                                                <option value="<?= $row["id"] ?>"><?= $row["brand_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">選擇品牌</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 茶種 -->
                            <tr>
                                <th>茶種</th>
                                <td>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="tea_id">
                                            <option selected></option>
                                            <?php foreach ($rowsTc as $row) : ?>
                                                <option value="<?= $row["id"] ?>"><?= $row["tc_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">選擇茶種</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 包裝方式 -->
                            <tr>
                                <th>包裝方式</th>
                                <td>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="pack_id">
                                            <option selected></option>
                                            <?php foreach ($rowsPack as $row) : ?>
                                                <option value="<?= $row["id"] ?>"><?= $row["pack_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">選擇包裝方式</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 茶葉類型 -->
                            <tr>
                                <th>類型</th>
                                <td>
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="style_id">
                                            <option selected></option>
                                            <?php foreach ($rowsStyle as $row) : ?>
                                                <option value="<?= $row["id"] ?>"><?= $row["style_name"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="floatingSelect">選擇茶葉類型</label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 商品描述 -->
                            <tr>
                                <th>商品描述</th>
                                <td>
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px" name="description"></textarea>
                                        <label for="floatingTextarea2">商品描述...</label>
                                    </div>

                                </td>
                            </tr>

                            <!-- 重量 -->
                            <tr>
                                <th>重量</th>
                                <td>
                                    <input class="form-control" type="text" name="weight" placeholder="請輸入重量...">
                                </td>
                            </tr>

                            <!-- 單價 -->
                            <tr>
                                <th>單價</th>
                                <td>
                                    <input class="form-control" type="number" name="price" placeholder="請輸入單價金額...">
                                </td>
                            </tr>

                            <!-- 庫存 -->
                            <tr>
                                <th>庫存</th>
                                <td>
                                    <input class="form-control" type="number" name="stock" placeholder="請輸入庫存數量...">
                                </td>
                            </tr>
                        </table>
                        <div class="text-end">
                            <button class="btn btn-success" type="submit">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>













    </main>

    <!-- Javascript -->
    <?php include("../js.php") ?>
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                preview.innerHTML = '';
                preview.appendChild(img);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>