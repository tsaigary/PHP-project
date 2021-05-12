<?php
session_start();
require_once('./db.inc.php');
require_once('./BS-html-head.php');
require_once('./BS-header-admin.php');
// require_once("./func-buildTree.php");
// require_once("./func-getRecursiveCategoryIds.php");

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
                    <h1 class="h2 text-uppercase mb-0">商品編輯</h1>
                </div>

            </div>
        </div>
    </section>
    <!-- BILLING ADDRESS-->
    <section class="py-5">
        <?php
        // SQL 敘述
        $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`, `categories`.`categoryId`, `categories`.`categoryName`
                FROM `items` INNER JOIN `categories`
                ON `items`.`itemCategoryId` = `categories`.`categoryId`
                WHERE `itemId` = ? ";
        // 設定繫結值
        $arrParam = [
            (int)$_GET['itemId']
        ];
        // 查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        if ($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll()[0];
        ?>
            <h2 class="h5 text-uppercase mb-4">商品資料</h2>
            <div class="row">
                <div class="col-lg-8">
                    <form name="myForm" method="POST" action="./update.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase">商品名稱</label>
                                <input class="form-control form-control-lg" id="itemName" name="itemName" type="text" value="<?php echo $arr['itemName'] ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase">商品類別</label>
                                <select class="form-control form-control-lg" name="itemCategoryId">
                                    <?php buildTree($pdo, 0); ?>
                                </select>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase">商品售價</label>
                                <input class="form-control form-control-lg" id="itemPrice" name="itemPrice" type="text" value="<?php echo $arr['itemPrice'] ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="text-small text-uppercase">商品數量</label>
                                <input class="form-control form-control-lg" id="itemQty" name="itemQty" type="text" value="<?php echo $arr['itemQty'] ?>">
                            </div>
                            <div class=" col-lg-12 form-group">
                                <label class="text-small text-uppercase">上傳圖片</label>
                                <?php if ($arr['itemImg'] !== NULL) { ?>
                                    <img class="w200px" src="./images/items/<?php echo $arr['itemImg'] ?>" />
                                <?php } ?>
                                <input class="form-control form-control-lg" type="file" name="itemImg">
                            </div>

                            <div class="col-lg-12 form-group">
                                <input type="hidden" name="itemId" value="<?php echo (int)$_GET['itemId'] ?>">
                                <input class="btn btn-dark" type="submit" name="smb" value="更新">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php
        } else {
        ?>
            <tr>
                <td class="border" colspan="6">沒有資料</td>
            </tr>
        <?php
        }
        ?>
    </section>
</div>
<?php
require_once('./BS-footer.php');
require_once('./BS-html-foot.php');
?>