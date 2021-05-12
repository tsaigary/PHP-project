<?php
require_once './checkSession.php';
require_once('./db.inc.php');
require_once('./BS-html-head.php');
require_once('./BS-header-admin.php');

//建立種類列表
function buildTree($pdo, $parentId = 0)
{
    $sql = "SELECT `categoryId`, `categoryName`, `categoryParentId`
            FROM `categories` 
            WHERE `categoryParentId` = ?";
    $stmt = $pdo->prepare($sql);
    $arrParam = [$parentId];
    $stmt->execute($arrParam);
    if ($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<option value='" . $arr[$i]['categoryId'] . "'>";
            echo $arr[$i]['categoryName'];
            echo "</option>";
            buildTree($pdo, $arr[$i]['categoryId']);
        }
    }
}

?>


<div class="container">
    <!-- HERO SECTION------------------------------------------------>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">新增商品</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="py-5">
        <!-- BILLING ADDRESS-->
        <h2 class="h5 text-uppercase mb-4">商品資料</h2>
        <div class="row">
            <div class="col-lg-8">
                <form name="myForm" method="POST" action="./add.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="firstName">商品名稱</label>
                            <input class="form-control form-control-lg" id="itemName" name="itemName" type="text" placeholder="輸入名稱">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="lastName">商品類別</label>
                            <select class="form-control form-control-lg" name="itemCategoryId">
                                <?php buildTree($pdo, 0); ?>
                            </select>
                            <!-- <input class="form-control form-control-lg" id="eventClass" name="eventClass" type="text" placeholder="類別C/D"> -->
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase">商品售價</label>
                            <input class="form-control form-control-lg" id="itemPrice" name="itemPrice" type="text" placeholder="輸入整數值不含字元品">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label class="text-small text-uppercase" for="phone">商品數量</label>
                            <input class="form-control form-control-lg" id="itemQty" name="itemQty" type="text" placeholder="商品庫存數量">
                        </div>
                        <!-- <div class="col-lg-12 form-group">
                            <label class="text-small text-uppercase" for="address">商品描述</label>
                            <input class="form-control form-control-lg" id="eventPrice" name="eventPrice" type="text" placeholder="商品相關描述">
                        </div> -->
                        <div class="col-lg-12 form-group">
                            <label class="text-small text-uppercase" for="address">上傳圖片</label>
                            <input class="form-control form-control-lg" type="file" name="itemImg">
                        </div>

                        <div class="col-lg-12 form-group">
                            <input class="btn btn-dark" type="submit" name="smb" value="建立">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php
require_once('./BS-footer.php');
require_once('./BS-html-foot.php');
?>