<?php
session_start();
require_once('../db.inc.php');
require_once('../template/admin-html-head.php');
require_once('./BS-header-admin.php');
require_once("../template-cart/func-buildTree.php");
require_once("../template-cart/func-getRecursiveCategoryIds.php");
?>

<div class="container">
    <!-- HERO SECTION-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">商品列表</h1>
                </div>
                <div class="col-lg-6 text-lg-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                            <li class="breadcrumb-item"><a href="admin.php">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">商品列表</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container p-0">
            <div class="row">
                <!-- SHOP SIDEBAR-->
                <div class="col-lg-3 order-2 order-lg-1">
                    <h5 class="text-uppercase mb-4">商品種類</h5>
                    <div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase font-weight-bold">美術館商品</strong></div>
                    <!-- 樹狀商品種類連結 -->
                    <?php buildTree($pdo, 0); ?>

                    <h6 class="text-uppercase mb-4">Price range</h6>
                    <div class="price-range pt-4 mb-5">
                        <div id="range"></div>
                        <div class="row pt-2">
                            <div class="col-6"><strong class="small font-weight-bold text-uppercase">From</strong></div>
                            <div class="col-6 text-right"><strong class="small font-weight-bold text-uppercase">To</strong></div>
                        </div>
                    </div>
                </div>
                <!-- SHOP LISTING-->
                <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                    <div class="row mb-3 align-items-center">
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <p class="text-small text-muted mb-0">Showing 1–12 of 53 results</p>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                                <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th-large"></i></a></li>
                                <li class="list-inline-item text-muted mr-3"><a class="reset-anchor p-0" href="#"><i class="fas fa-th"></i></a></li>
                                <li class="list-inline-item">
                                    <select class="selectpicker ml-auto" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                                        <option value="default">Default sorting</option>
                                        <option value="popularity">Popularity</option>
                                        <option value="low-high">Price: Low to High</option>
                                        <option value="high-low">Price: High to Low</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="">
                        <!-- PRODUCT-->
                        <table>
                            <thead>
                                <tr>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">商品照片</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">商品名稱</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">商品價格</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">商品數量</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">商品種類</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">新增時間</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">更新時間</strong></th>
                                    <th class="py-2 px-3 bg-dark text-white text-center"><strong class="small text-uppercase font-weight-bold">功能</strong></th>
                                </tr>


                            </thead>
                            <tbody>

                                <?php
                                if (isset($_GET['categoryId'])) {
                                    $strCategoryIds = "";;
                                    $strCategoryIds .= $_GET['categoryId'];
                                    getRecursiveCategoryIds($pdo, $_GET['categoryId']);
                                }

                                //SQL 敘述
                                $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`, `categories`.`categoryName`
                                FROM `items` INNER JOIN `categories`
                                ON `items`.`itemCategoryId` = `categories`.`categoryId`";

                                //若網址有商品種類編號，則整合字串來操作 SQL 語法
                                if (isset($_GET['categoryId'])) {
                                    $sql .= "WHERE `items`.`itemCategoryId` in ({$strCategoryIds})";
                                }

                                $sql .= "ORDER BY `items`.`itemId` ASC ";

                                //查詢分頁後的商品資料
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                //若商品項目個數大於 0，則列出商品
                                if ($stmt->rowCount() > 0) {
                                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    for ($i = 0; $i < count($arr); $i++) {
                                ?>
                                        <tr class="product mt-4">

                                            <td>
                                                <!-- <div class="badge text-white badge-"></div> -->
                                                <!-- 調整圖片size跟位置 -->
                                                <img style="width: 100px; height: 100px; object-fit:cover;" class="img-fluid" src="../images/items/<?php echo $arr[$i]['itemImg']; ?>" alt="...">
                                            </td>
                                            <td class="text-center">
                                                <span class="small text-muted"><?php echo $arr[$i]['itemName']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="small text-muted">$<?php echo $arr[$i]['itemPrice']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="small text-muted"><?php echo $arr[$i]['itemQty']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="small text-muted"><?php echo $arr[$i]['categoryName']; ?></span>
                                            </td>
                                            <td class="text-center px-2">
                                                <span class="small text-muted"><?php echo $arr[$i]['created_at']; ?></span>
                                            </td>
                                            <td class="text-center px-2">
                                                <span class="small text-muted"><?php echo $arr[$i]['updated_at']; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a class="reset-anchor small" href="./edit.php?itemId=<?php echo $arr[$i]['itemId']; ?>">編輯</a>
                                                <br>
                                                <a class="reset-anchor small" href="./delete.php?itemId=<?php echo $arr[$i]['itemId']; ?>">刪除</a>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                    <!-- PAGINATION-->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center justify-content-lg-end">
                            <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</div>


<?php
require_once('../template/footer.php');
require_once('../template/admin-html-foot.php');
?>