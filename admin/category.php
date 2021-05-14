<?php
require_once '../checkSession.php';
require_once '../db.inc.php';
require_once '../template/admin-html-head.php';
require_once './BS-header-admin.php';
// require_once '../template-cart/func-buildTree.php';
require_once '../template-cart/func-getRecursiveCategoryIds.php';

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
        echo "<ul class='list-group list-group-flush'>";
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($arr); $i++) {
            echo "<li class='list-group-item'>";
            echo "<input class='form-check-input' type='radio' name='categoryId' value='" . $arr[$i]['categoryId'] . "' />";
            echo "<span class='text-small'>";
            echo $arr[$i]['categoryName'];
            echo "</span>";
            echo " | <a class='reset-anchor small' href='./editCategory.php?editCategoryId=" . $arr[$i]['categoryId'] . "'>編輯</a>";
            echo " | <a class='reset-anchor small' href='./deleteCategory.php?deleteCategoryId=" . $arr[$i]['categoryId'] . "'>刪除</a>";
            buildTree($pdo, $arr[$i]['categoryId']);
            echo "</li>";
        }
        echo "</ul>";
    }
}
?>
<div class="container">
    <!-- HERO SECTION------------------------------------------------>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">編輯類別</h1>
                </div>

            </div>
        </div>
    </section>
    <section class="py-5">
        <!-- BILLING ADDRESS-->
        <h2 class="h5 text-uppercase mb-4">類別清單</h2>
        <div class="row">
            <div class="col-lg-4">
                <form name="myForm" method="POST" action="./insertCategory.php" enctype="multipart/form-data">
                    <?php buildTree($pdo, 0); ?>
                    <div class="row mt-4">
                        <div class="col-lg-12 form-group">
                            <label class="text-small text-uppercase" for="firstName">類別名稱</label>
                            <input class="form-control form-control-lg" id="categoryName" name="categoryName" type="text" placeholder="輸入名稱">
                        </div>

                        <div class="col-lg-12 form-group">
                            <input class="btn btn-dark" type="submit" name="smb" value="新增">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<?php require_once '../template/footer.php' ?>
<?php require_once '../template/admin-html-foot.php' ?>