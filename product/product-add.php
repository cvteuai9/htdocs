<?php
session_start();
require_once("../db_connect.php");

$sqlTc = "SELECT id, name AS tc_name FROM tea_category WHERE valid=1";
$sqlBrand = "SELECT id, name AS brand_name FROM brand WHERE valid=1";
$sqlPack = "SELECT id, name AS pack_name FROM pack_category WHERE valid=1";
$sqlStyle = "SELECT id, name AS style_name FROM style WHERE valid=1";

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
    <style>
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
    <!-- header、aside -->
    <?php include("../dashboard-comm.php") ?>
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
            <?php if (isset($_SESSION["errorMsg"])) : ?>
                <div class="text-danger ps-2 text-center">
                    * <?= $_SESSION["errorMsg"] ?>
                </div>
            <?php
                unset($_SESSION["errorMsg"]);
            endif; ?>
            <div class="row justify-content-center">

                <!-- 商品圖片預覽區 -->
                <div class="col-lg-4 d-flex flex-column align-items-center">
                    <div id="preview">Image Preview</div>
                    <div class="h4 mt-1">圖片預覽</div>
                </div>

                <div class="col-lg-6">
                    <form action="doProductAdd.php" method="post" enctype="multipart/form-data">
                        <table class="table table-bordered align-middle">
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
                                    <input class="form-control" type="text" name="product_name" placeholder="請輸入商品名稱...">
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

                            <!-- 上下架 -->
                            <tr>
                                <th>狀態</th>
                                <td>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault1" value="1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                上架
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="valid" id="flexRadioDefault2" value="0">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                下架
                                            </label>
                                        </div>
                                    </div>
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
        // 圖片預覽函式
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