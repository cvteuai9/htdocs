<?php

if (!isset($_GET["id"])) {
    $id = 1;  //就算沒資料也會預設id=1 (帶第一筆資料)
} else {
    $id = $_GET["id"];
}
require_once("../db_connect.php");

$sql = "SELECT * FROM coupons WHERE id=$id ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    $couponExit = true;
} else {
    $couponExit = false;
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
        <div class="d-flex justify-content-between">
            <h1>編輯優惠券</h1>
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
            <div class="py-2">
                <a class="btn btn-custom" href="coupon.php?id=<?= $id ?>"><i class="fa-solid fa-arrow-left"></i>取消</a>
            </div>
            <div class="row justify-content-center ">
                <div class="col-lg-12">
                    <?php if ($couponExit) : ?>
                        <form action="doUpdateCoupon.php" method="post">
                            <table class="table table-bordered table-coupon align-middle">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <tr>
                                    <th>ID</th>
                                    <td><?= $row["id"] ?></td>
                                </tr>
                                <tr>
                                    <th>優惠券名稱</th>
                                    <td>
                                        <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠券代碼</th>
                                    <td>
                                        <input type="text" class="form-control" name="code" id="coupon-code" value="<?= $row["code"] ?>" required>

                                        <button type="button" class="btn btn-outline-secondary" onclick="fillRandomCode()">生成代碼</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠券種類</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" id="amount" value="金額" <?php if ($row["category"] == "金額") : ?>checked<?php endif ?> required>
                                            <label class="form-check-label" for="amount">
                                                金額
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" id="percent" value="百分比" <?php if ($row["category"] == "百分比") : ?>checked<?php endif ?> required>
                                            <label class="form-check-label" for="percent">
                                                百分比
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>折扣面額</th>
                                    <td>
                                        <input type="text" class="form-control" name="discount" value="<?= $row["discount"] ?>" required>
                                        <div id="error-message"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>最低消費金額</th>
                                    <td>
                                        <input type="text" class="form-control" name="min_spend_amount" value="<?= $row["min_spend_amount"] ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>優惠券數量</th>
                                    <td>
                                        <input type="text" class="form-control" name="stock" value="<?= $row["stock"] ?>" required>
                                    </td>
                                </tr>

                                <tr>
                                    <th>開始時間</th>
                                    <td>
                                        <input type="datetime-local" class="form-control" name="start_time" id="start_time" value="<?= $row["start_time"] ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>結束時間</th>
                                    <td>
                                        <input type="datetime-local" class="form-control" name="end_time" id="end_time" value="<?= $row["end_time"] ?>" required>
                                    </td>
                                </tr>

                            </table>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-custom" type="submit">確認修改</button>

                            </div>
                        </form>
                    <?php else : ?>
                        <h1>優惠券不存在</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>



    </main>
    <?php include("../js.php") ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var startTimeInput = document.getElementById('start_time');
            //   console.log(startTimeInput);
            var endTimeInput = document.getElementById('end_time');

            // 设置开始时间的最小值为当前时间
            var now = new Date().toISOString().slice(0, 16);
            //   startTimeInput.min = now;
            endTimeInput.min = startTimeInput.value;

            startTimeInput.addEventListener('change', function() {
                endTimeInput.min = startTimeInput.value;

            });
            var amountRadio = document.getElementById('amount');
            var percentRadio = document.getElementById('percent');
            var discountInput = document.querySelector('input[name="discount"]');
            var couponForm = document.querySelector('form');

            couponForm.addEventListener('submit', function(event) {
                var discountValue = parseFloat(discountInput.value);
                var categoryChecked = document.querySelector('input[name="category"]:checked');

                var errorMeg = ""; // 初始化错误消息
                if (categoryChecked && categoryChecked.value === '金額' && discountValue <= 1) {
                    errorMeg = "金額折扣應大於1";
                    event.preventDefault();
                } else if (categoryChecked && categoryChecked.value === '百分比' && (discountValue <= 0 || discountValue >= 1)) {
                    errorMeg = "百分比折扣應為0到1之間的小數";
                    event.preventDefault();
                }
                // 将错误消息插入到页面中适当位置
                document.getElementById('error-message').innerText = errorMeg;
            });
        });

        function generateRandomCode() {
            let code = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            const charactersLength = characters.length;

            for (let i = 0; i < 6; i++) {
                const randomIndex = Math.floor(Math.random() * charactersLength);
                code += characters.charAt(randomIndex);
            }

            return code;
        }

        function fillRandomCode() {
            document.getElementById('coupon-code').value = generateRandomCode();
        }

        console.log(generateRandomCode());
    </script>
</body>

</html>