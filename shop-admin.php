<?php
session_start();
require_once('./db.inc.php');
require_once('./BS-html-head.php');
require_once('./BS-header-admin.php');
require_once("./func-buildTree.php");
require_once("./func-getRecursiveCategoryIds.php");
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
                            <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
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
                    <div class="row">
                        <!-- PRODUCT-->

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
                                <div class="col-lg-4 col-sm-6">
                                    <div class="product text-center">
                                        <div class="mb-3 position-relative">
                                            <div class="badge text-white badge-"></div>
                                            <a class="d-block" href="./detail.php?itemId=<?php echo $arr[$i]['itemId']; ?>">
                                                <!-- 調整圖片size跟位置 -->
                                                <img style="height: 300px; object-fit:cover;" class="img-fluid w-100" src="./images/items/<?php echo $arr[$i]['itemImg']; ?>" alt="...">
                                            </a>
                                            <div class="product-overlay">
                                                <ul class="mb-0 list-inline">
                                                    <li class="list-inline-item m-0 p-0">
                                                        <a class="btn btn-sm btn-outline-dark" href="#">
                                                            <i class="far fa-heart"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item m-0 p-0">
                                                        <form name="cartForm" id="cartForm" method="POST" action="./addCart.php">
                                                            <button class="btn btn-sm btn-dark">
                                                                Add to cart
                                                            </button>
                                                            <input hidden type="text" name="cartQty" id="cartQty" value="1">
                                                            <input type="hidden" name="itemId" id="itemId" value="<?php echo $arr[$i]['itemId'] ?>">
                                                        </form>
                                                    </li>
                                                    <li class="list-inline-item mr-0">
                                                        <a class="btn btn-sm btn-outline-dark" href="#productView" data-toggle="modal">
                                                            <i class="fas fa-expand"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h6>
                                            <a class="reset-anchor" href="detail.php"><?php echo $arr[$i]['itemName']; ?></a>
                                            |
                                            <a class="reset-anchor" href="./edit.php?itemId=<?php echo $arr[$i]['itemId']; ?>">編輯</a>
                                            |
                                            <a class="reset-anchor" href="./delete.php?itemId=<?php echo $arr[$i]['itemId']; ?>">刪除</a>
                                        </h6>
                                        <p class="small text-muted">$<?php echo $arr[$i]['itemPrice']; ?></p>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

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
require_once('./BS-footer.php');
require_once('./BS-html-foot.php');
?>